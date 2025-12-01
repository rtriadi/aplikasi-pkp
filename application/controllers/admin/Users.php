<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['user_model', 'master_model']);
    }

    public function index()
    {
        $data['row'] = $this->user_model->get_all_with_relations();
        $this->template->set('page', 'Manajemen User');
        $this->template->load('layout/template', 'admin/users/list', $data);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nip', 'NIP', 'required|is_unique[users.nip]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['units'] = $this->master_model->get_units();
            $data['ranks'] = $this->master_model->get_ranks();
            $data['positions'] = $this->master_model->get_positions();
            $this->template->set('page', 'Tambah User');
            $this->template->load('layout/template', 'admin/users/form', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $post['role'] = 'pegawai';
            $this->user_model->add($post);
            $this->session->set_flashdata('success', 'Data saved');
            redirect('admin/users');
        }
    }

    public function edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nip', 'NIP', 'required');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $query = $this->user_model->get($id);
            if ($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $data['units'] = $this->master_model->get_units();
                $data['ranks'] = $this->master_model->get_ranks();
                $data['positions'] = $this->master_model->get_positions();
                $this->template->set('page', 'Edit User');
                $this->template->load('layout/template', 'admin/users/form', $data);
            } else {
                $this->session->set_flashdata('error', 'Data not found');
                redirect('admin/users');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $post['role'] = 'pegawai';
            $this->user_model->edit($post);
            $this->session->set_flashdata('success', 'Data updated');
            redirect('admin/users');
        }
    }

    public function del($id)
    {
        $this->user_model->del($id);
        $this->session->set_flashdata('success', 'Data deleted');
        redirect('admin/users');
    }

    public function import()
    {
        if (isset($_POST['import'])) {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
            if ($handle) {
                $row = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $row++;
                    if ($row == 1) continue; // Skip header

                    // Format: NIP, Name, Password
                    $nip = $data[0];
                    $name = $data[1];
                    $password = $data[2];

                    // Check if exists
                    $check = $this->db->get_where('users', ['nip' => $nip])->num_rows();
                    if ($check > 0) continue;

                    $params = [
                        'nip' => $nip,
                        'full_name' => $name,
                        'password' => password_hash($password, PASSWORD_BCRYPT),
                        'role' => 'pegawai'
                    ];
                    $this->db->insert('users', $params);
                }
                fclose($handle);
                $this->session->set_flashdata('success', 'Import finished');
                redirect('admin/users');
            }
        } else {
            $this->template->set('page', 'Import User');
            $this->template->load('layout/template', 'admin/users/import');
        }
    }
}
