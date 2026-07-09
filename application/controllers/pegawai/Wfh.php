<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wfh extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role('pegawai');
        $this->load->model(['wfh_model', 'user_model', 'master_model']);
        $this->load->library('upload');
    }

    public function index()
    {
        $user_id = $this->session->userdata('id_user');
        $data['reports'] = $this->wfh_model->get_all_by_user($user_id)->result();
        $this->template->set('page', 'Laporan WFH');
        $this->template->load('layout/template', 'pegawai/wfh/index', $data);
    }

    public function add()
    {
        $this->template->set('page', 'Tambah Laporan WFH');
        $this->template->load('layout/template', 'pegawai/wfh/form');
    }

    public function edit($id)
    {
        $user_id = $this->session->userdata('id_user');
        $report = $this->wfh_model->get_by_id($id, $user_id)->row();
        if (!$report) {
            $this->session->set_flashdata('error', 'Laporan WFH tidak ditemukan.');
            redirect('pegawai/wfh');
        }
        $data['report'] = $report;
        $data['activities'] = $this->wfh_model->get_activities($id)->result();
        $data['attachments'] = $this->wfh_model->get_attachments($id)->result();
        
        $this->template->set('page', 'Edit Laporan WFH');
        $this->template->load('layout/template', 'pegawai/wfh/form', $data);
    }

    public function save()
    {
        $post = $this->input->post(null, TRUE);
        $user_id = $this->session->userdata('id_user');
        $id = isset($post['id']) ? $post['id'] : null;
        
        $wfh_date = $post['wfh_date'];
        
        // Validation for uniqueness
        $this->db->from('wfh_reports');
        $this->db->where('user_id', $user_id);
        $this->db->where('wfh_date', $wfh_date);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $check = $this->db->get();
        if ($check->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Laporan WFH untuk tanggal tersebut sudah ada.');
            if ($id) {
                redirect('pegawai/wfh/edit/' . $id);
            } else {
                redirect('pegawai/wfh/add');
            }
            return;
        }
        
        $report_data = [
            'user_id' => $user_id,
            'wfh_date' => $wfh_date
        ];
        
        if ($id) {
            $this->wfh_model->update_report($id, $report_data);
            $report_id = $id;
        } else {
            $report_id = $this->wfh_model->insert_report($report_data);
        }
        
        // Save activities
        $activities = [];
        if (isset($post['work_time'])) {
            for ($i = 0; $i < count($post['work_time']); $i++) {
                if (trim($post['work_time'][$i]) != '' || trim($post['activity_description'][$i]) != '') {
                    $activities[] = [
                        'wfh_report_id' => $report_id,
                        'work_time' => $post['work_time'][$i],
                        'activity_description' => $post['activity_description'][$i],
                        'output_result' => $post['output_result'][$i],
                        'note' => $post['note'][$i]
                    ];
                }
            }
        }
        $this->wfh_model->save_activities($report_id, $activities);
        
        // Handle file uploads
        if (!empty($_FILES['files']['name'][0])) {
            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];
                
                $uploadPath = './assets/uploads/wfh/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['encrypt_name'] = TRUE;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $uploadData = [
                        'wfh_report_id' => $report_id,
                        'file_name' => $fileData['file_name']
                    ];
                    $this->wfh_model->insert_attachment($uploadData);
                } else {
                    $error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Gagal upload beberapa gambar: ' . $error);
                }
            }
        }
        
        $this->session->set_flashdata('success', 'Laporan WFH berhasil disimpan.');
        redirect('pegawai/wfh');
    }

    public function delete($id)
    {
        $user_id = $this->session->userdata('id_user');
        $report = $this->wfh_model->get_by_id($id, $user_id)->row();
        if (!$report) {
            $this->session->set_flashdata('error', 'Laporan tidak ditemukan.');
            redirect('pegawai/wfh');
            return;
        }
        
        // Delete actual files
        $attachments = $this->wfh_model->get_attachments($id)->result();
        foreach ($attachments as $att) {
            $file_path = './assets/uploads/wfh/' . $att->file_name;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $this->wfh_model->delete_report($id);
        $this->session->set_flashdata('success', 'Laporan WFH berhasil dihapus.');
        redirect('pegawai/wfh');
    }

    public function delete_attachment($id)
    {
        $att = $this->wfh_model->get_attachment($id);
        if ($att) {
            $user_id = $this->session->userdata('id_user');
            $report = $this->wfh_model->get_by_id($att->wfh_report_id, $user_id)->row();
            if ($report) {
                $file_path = './assets/uploads/wfh/' . $att->file_name;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $this->wfh_model->delete_attachment($id);
                echo json_encode(['status' => 'success']);
                return;
            }
        }
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized or not found.']);
    }

    public function print_preview($id)
    {
        $user_id = $this->session->userdata('id_user');
        $report = $this->wfh_model->get_by_id($id, $user_id)->row();
        if (!$report) {
            redirect('pegawai/wfh');
            return;
        }
        
        $data['report'] = $report;
        $data['user'] = $this->user_model->get($user_id)->row();
        $data['activities'] = $this->wfh_model->get_activities($id)->result();
        $data['attachments'] = $this->wfh_model->get_attachments($id)->result();
        
        $this->load->view('pegawai/wfh/print', $data);
    }

    public function export_docx($id)
    {
        $user_id = $this->session->userdata('id_user');
        $report = $this->wfh_model->get_by_id($id, $user_id)->row();
        if (!$report) {
            redirect('pegawai/wfh');
            return;
        }

        $user = $this->user_model->get($user_id)->row();
        $activities = $this->wfh_model->get_activities($id)->result();
        $attachments = $this->wfh_model->get_attachments($id)->result();

        // Initialize PHPWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Set default font to Arial, 11
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        // Add section with 2cm margins (1 twip = 1/1440 inch, 2cm = 1134 twips)
        $section = $phpWord->addSection([
            'marginLeft' => 1134,
            'marginRight' => 1134,
            'marginTop' => 1134,
            'marginBottom' => 1134,
        ]);

        // Add Header text
        $section->addText("LAPORAN KERJA HARIAN ASN (WFH)", ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addText("PENGADILAN AGAMA GORONTALO", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $section->addTextBreak(1);

        // Add Data Pegawai title
        $section->addText("DATA PEGAWAI", ['bold' => true, 'size' => 11]);

        // Profile Table
        $profileTable = $section->addTable(['borderSize' => 0, 'cellMargin' => 40]);
        
        $profileTable->addRow();
        $profileTable->addCell(2000)->addText("Nama");
        $profileTable->addCell(300)->addText(":");
        $profileTable->addCell(6000)->addText($user->full_name, ['bold' => true]);

        $profileTable->addRow();
        $profileTable->addCell(2000)->addText("NIP");
        $profileTable->addCell(300)->addText(":");
        $profileTable->addCell(6000)->addText($user->nip);

        $profileTable->addRow();
        $profileTable->addCell(2000)->addText("Jabatan");
        $profileTable->addCell(300)->addText(":");
        $profileTable->addCell(6000)->addText($user->position_name);

        $profileTable->addRow();
        $profileTable->addCell(2000)->addText("Unit Kerja");
        $profileTable->addCell(300)->addText(":");
        $profileTable->addCell(6000)->addText($user->unit_name);

        $profileTable->addRow();
        $profileTable->addCell(2000)->addText("Hari/Tanggal");
        $profileTable->addCell(300)->addText(":");
        $formattedDate = hari_indo(date('D', strtotime($report->wfh_date))) . ', ' . tgl_indo($report->wfh_date);
        $profileTable->addCell(6000)->addText($formattedDate);

        $section->addTextBreak(1);

        // Activities Table style
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 100
        ];
        $phpWord->addTableStyle('ActivitiesTable', $tableStyle);
        $table = $section->addTable('ActivitiesTable');

        // Add header row
        $table->addRow();
        $table->addCell(500, ['bgColor' => 'F2F2F2'])->addText("No", ['bold' => true], ['alignment' => 'center']);
        $table->addCell(1500, ['bgColor' => 'F2F2F2'])->addText("Jam Kerja", ['bold' => true], ['alignment' => 'center']);
        $table->addCell(4000, ['bgColor' => 'F2F2F2'])->addText("Deskripsi Kegiatan", ['bold' => true], ['alignment' => 'center']);
        $table->addCell(2000, ['bgColor' => 'F2F2F2'])->addText("Output / Hasil", ['bold' => true], ['alignment' => 'center']);
        $table->addCell(1500, ['bgColor' => 'F2F2F2'])->addText("Keterangan", ['bold' => true], ['alignment' => 'center']);

        // Add activities rows
        $no = 1;
        foreach ($activities as $act) {
            $table->addRow();
            $table->addCell(500)->addText($no++, null, ['alignment' => 'center']);
            $table->addCell(1500)->addText($act->work_time, null, ['alignment' => 'center']);
            
            $descCell = $table->addCell(4000);
            $descLines = explode("\n", $act->activity_description);
            foreach ($descLines as $line) {
                $descCell->addText(trim($line));
            }
            
            $table->addCell(2000)->addText($act->output_result);
            $table->addCell(1500)->addText($act->note ? $act->note : '-');
        }

        // Add Attachments Section
        if (!empty($attachments)) {
            $section->addTextBreak(2);
            $section->addText("Lampiran", ['bold' => true, 'size' => 12]);
            $section->addTextBreak(1);

            foreach ($attachments as $att) {
                $file_path = './assets/uploads/wfh/' . $att->file_name;
                if (file_exists($file_path)) {
                    $size = getimagesize($file_path);
                    $width = 450; 
                    if ($size) {
                        $orig_width = $size[0];
                        $orig_height = $size[1];
                        $ratio = $orig_height / $orig_width;
                        $height = $width * $ratio;
                    } else {
                        $height = 300;
                    }
                    
                    $section->addImage($file_path, [
                        'width' => $width,
                        'height' => $height,
                        'alignment' => 'center'
                    ]);
                    $section->addTextBreak(2);
                }
            }
        }

        // Stream file to output
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        
        $filename = 'Laporan_WFH_' . str_replace(' ', '_', $report->wfh_date) . '.docx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
