<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        check_already_login();
        $this->load->view('auth/login');
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($post['login'])) {
            $this->load->model('user_model');
            $query = $this->user_model->login($post);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                if (password_verify($post['password'], $row->password)) {
                    $params = array(
                        'id_user' => $row->id,
                        'role' => $row->role
                    );
                    $this->session->set_userdata($params);
                    $this->session->set_userdata($params);
                    $this->session->set_flashdata('success', 'Selamat, login berhasil');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Login gagal, password salah');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Login gagal, username tidak ditemukan');
                redirect('auth/login');
            }
        }
    }

    public function logout()
    {
        $params = array('id_user', 'role');
        $this->session->unset_userdata($params);
        redirect('auth/login');
    }
}
