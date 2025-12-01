<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realization extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['pkp_model', 'master_model']);
    }

    public function index()
    {
        $active_year = $this->master_model->get_active_year();
        if (!$active_year) {
            $this->session->set_flashdata('error', 'No active fiscal year found.');
            redirect('dashboard');
            return;
        }
        $data['active_year'] = $active_year;
        $this->template->set('page', 'Realisasi SKP');
        $this->template->load('layout/template', 'pegawai/realization/index', $data);
    }

    public function month($month)
    {
        $active_year = $this->master_model->get_active_year();
        if (!$active_year) {
            redirect('dashboard');
        }

        $user_id = $this->session->userdata('id_user');
        $data['active_year'] = $active_year;
        $data['month'] = $month;
        $data['targets'] = $this->pkp_model->get_targets($user_id, $active_year->id);
        $data['signature'] = $this->pkp_model->get_signature($user_id, $month, $active_year->id)->row();
        
        $this->template->set('page', 'Realisasi Bulanan');
        $this->template->load('layout/template', 'pegawai/realization/month', $data);
    }

    public function save_realization()
    {
        $post = $this->input->post(null, TRUE);
        $this->pkp_model->save_realization($post);
        echo json_encode(['status' => 'success']);
    }

    public function save_signature()
    {
        $post = $this->input->post(null, TRUE);
        $active_year = $this->master_model->get_active_year();
        $post['year_id'] = $active_year->id;
        
        $this->pkp_model->save_signature($post);
        $this->session->set_flashdata('success', 'Signature data saved');
        redirect('pegawai/realization/month/'.$post['month']);
    }
}
