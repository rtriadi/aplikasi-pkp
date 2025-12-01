
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['pkp_model', 'master_model', 'user_model']);
    }

    public function print_preview($month)
    {
        $active_year = $this->master_model->get_active_year();
        if (!$active_year) redirect('dashboard');

        $data['active_year'] = $active_year;
        $data['month'] = $month;
        $data['user'] = $this->user_model->get($this->session->userdata('id_user'))->row();
        $data['targets'] = $this->pkp_model->get_targets($this->session->userdata('id_user'), $active_year->id);
        $data['signature'] = $this->pkp_model->get_signature($this->session->userdata('id_user'), $month, $active_year->id)->row();
        
        $this->load->view('pegawai/report/print_preview', $data);
    }

    public function rekap_preview($month)
    {
        $active_year = $this->master_model->get_active_year();
        if (!$active_year) redirect('dashboard');

        $data['active_year'] = $active_year;
        $data['month'] = $month;
        $data['user'] = $this->user_model->get($this->session->userdata('id_user'))->row();
        $data['targets'] = $this->pkp_model->get_targets($this->session->userdata('id_user'), $active_year->id);
        $data['signature'] = $this->pkp_model->get_signature($this->session->userdata('id_user'), $month, $active_year->id)->row();
        
        $this->load->view('pegawai/report/rekap_preview', $data);
    }
}
