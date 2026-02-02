<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
    }

    public function index()
    {
        check_role('admin');
        
        $data['page'] = 'Backup Database';
        
        // Get list of existing backup files
        $backup_dir = FCPATH . 'backups/';
        $data['backups'] = [];
        
        if (is_dir($backup_dir)) {
            $files = scandir($backup_dir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..' && $this->_is_valid_backup_filename($file)) {
                    $data['backups'][] = [
                        'filename' => $file,
                        'size' => $this->_format_bytes(filesize($backup_dir . $file)),
                        'date' => date('Y-m-d H:i:s', filemtime($backup_dir . $file))
                    ];
                }
            }
        }
        
        // Sort by date descending
        usort($data['backups'], function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        $this->template->load('layout/template', 'admin/backup/index', $data);
    }

    public function create()
    {
        check_role('admin');
        
        // Rate limiting: prevent backup spam
        $last_backup = $this->session->userdata('last_backup_time');
        if ($last_backup && (time() - $last_backup) < 60) { // 1 minute minimum
            $this->session->set_flashdata('error', 'Mohon tunggu 1 menit antara backup');
            redirect('admin/backup');
        }
        
        // Get database configuration
        $db_config = $this->db->database;
        $hostname = $this->db->hostname;
        $username = $this->db->username;
        $password = $this->db->password;
        
        // Create backup directory if not exists
        $backup_dir = FCPATH . 'backups/';
        if (!is_dir($backup_dir)) {
            mkdir($backup_dir, 0755, true);
        }
        
        // Generate filename
        $filename = 'backup_' . $db_config . '_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $backup_dir . $filename;
        
        // Use credentials file to avoid password exposure in process list
        $creds_file = tempnam(sys_get_temp_dir(), 'db_');
        file_put_contents($creds_file, sprintf(
            "[mysqldump]\nhost=%s\nuser=%s\npassword=%s\n",
            $hostname,
            $username,
            $password
        ));
        
        $command = sprintf(
            'mysqldump --defaults-file=%s %s > %s',
            escapeshellarg($creds_file),
            escapeshellarg($db_config),
            escapeshellarg($filepath)
        );
        
        exec($command, $output, $return_var);
        
        // Clean up credentials file immediately
        unlink($creds_file);
        
        if ($return_var === 0 && file_exists($filepath)) {
            $this->session->set_userdata('last_backup_time', time());
            log_message('info', 'Database backup created: ' . $filename . ' by user: ' . $this->session->userdata('id_user'));
            $this->session->set_flashdata('success', 'Backup database berhasil dibuat: ' . $filename);
        } else {
            // Try PHP fallback method
            $this->_backup_php($filepath);
        }
        
        redirect('admin/backup');
    }

    private function _backup_php($filepath)
    {
        $tables = [];
        $query = $this->db->query('SHOW TABLES');
        foreach ($query->result_array() as $row) {
            $tables[] = array_values($row)[0];
        }
        
        $handle = fopen($filepath, 'w');
        if (!$handle) {
            $this->session->set_flashdata('error', 'Gagal membuat file backup');
            return false;
        }
        
        // Write header
        fwrite($handle, "-- Backup generated on " . date('Y-m-d H:i:s') . "\n");
        fwrite($handle, "-- Database: " . $this->db->database . "\n\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 0;\n\n");
        
        foreach ($tables as $table) {
            // Get create table statement with proper escaping
            $query = $this->db->query('SHOW CREATE TABLE `' . str_replace('`', '``', $table) . '`');
            $row = $query->row_array();
            
            fwrite($handle, "-- Table structure for table `" . $table . "`\n");
            fwrite($handle, "DROP TABLE IF EXISTS `" . $table . "`;\n");
            fwrite($handle, $row['Create Table'] . ";\n\n");
            
            // Stream data in chunks to avoid memory exhaustion
            $offset = 0;
            $batch_size = 1000;
            $has_data = false;
            
            do {
                $this->db->limit($batch_size, $offset);
                $query = $this->db->get($table);
                $rows = $query->result_array();
                
                if (count($rows) > 0 && !$has_data) {
                    fwrite($handle, "-- Dumping data for table `" . $table . "`\n");
                    fwrite($handle, "INSERT INTO `" . $table . "` VALUES ");
                    $has_data = true;
                }
                
                foreach ($rows as $i => $row) {
                    if ($offset > 0 || $i > 0) {
                        fwrite($handle, ",");
                    }
                    
                    $sql = "(";
                    $first_col = true;
                    foreach ($row as $value) {
                        if (!$first_col) {
                            $sql .= ",";
                        }
                        $first_col = false;
                        
                        if ($value === null) {
                            $sql .= "NULL";
                        } else {
                            $sql .= "'" . $this->db->escape_str($value) . "'";
                        }
                    }
                    $sql .= ")";
                    fwrite($handle, $sql);
                }
                
                $offset += $batch_size;
            } while (count($rows) === $batch_size);
            
            if ($has_data) {
                fwrite($handle, ";\n\n");
            }
        }
        
        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 1;\n");
        fclose($handle);
        
        log_message('info', 'Database backup created (PHP method): ' . basename($filepath) . ' by user: ' . $this->session->userdata('id_user'));
        $this->session->set_flashdata('success', 'Backup database berhasil dibuat (PHP method): ' . basename($filepath));
        return true;
    }

    public function download()
    {
        check_role('admin');
        
        $filename = $this->input->get('file');
        
        // Validate filename to prevent path traversal
        if (!$this->_is_valid_backup_filename($filename)) {
            show_404();
        }
        
        $filepath = FCPATH . 'backups/' . $filename;
        
        if (!file_exists($filepath)) {
            show_404();
        }
        
        // Stream file instead of loading into memory
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        
        $handle = fopen($filepath, 'rb');
        if (!$handle) {
            $this->session->set_flashdata('error', 'Gagal membaca file backup');
            redirect('admin/backup');
        }
        
        while (!feof($handle)) {
            echo fread($handle, 8192);
            flush();
        }
        fclose($handle);
        exit;
    }

    public function delete()
    {
        check_role('admin');
        
        $filename = $this->input->post('filename');
        
        // Validate filename to prevent path traversal
        if (!$this->_is_valid_backup_filename($filename)) {
            $this->session->set_flashdata('error', 'Nama file tidak valid');
            redirect('admin/backup');
        }
        
        $filepath = FCPATH . 'backups/' . $filename;
        
        if (file_exists($filepath)) {
            unlink($filepath);
            log_message('info', 'Database backup deleted: ' . $filename . ' by user: ' . $this->session->userdata('id_user'));
            $this->session->set_flashdata('success', 'File backup berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'File backup tidak ditemukan');
        }
        
        redirect('admin/backup');
    }

    private function _is_valid_backup_filename($filename)
    {
        if (empty($filename)) {
            return false;
        }
        
        // Remove any path components (prevent directory traversal)
        $filename = basename($filename);
        
        // Validate extension
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($ext !== 'sql') {
            return false;
        }
        
        // Validate filename pattern: backup_[dbname]_[YYYY-MM-DD_HH-II-SS].sql
        if (!preg_match('/^backup_[a-zA-Z0-9_]+_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.sql$/', $filename)) {
            return false;
        }
        
        return $filename;
    }

    private function _format_bytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
