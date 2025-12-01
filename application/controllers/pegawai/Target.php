<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target extends CI_Controller {

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
            $this->session->set_flashdata('error', 'No active fiscal year found. Please contact admin.');
            redirect('dashboard');
            return;
        }

        $data['active_year'] = $active_year;
        $data['row'] = $this->pkp_model->get_targets($this->session->userdata('id_user'), $active_year->id);
        $this->template->set('page', 'Target SKP');
        $this->template->load('layout/template', 'pegawai/target/list', $data);
    }

    // Indicators Management
    public function indicators()
    {
        $active_year = $this->master_model->get_active_year();
        if (!$active_year) redirect('dashboard');

        $data['active_year'] = $active_year;
        $data['row'] = $this->pkp_model->get_indicators($this->session->userdata('id_user'), $active_year->id);
        $this->template->set('page', 'Indikator Kinerja');
        $this->template->load('layout/template', 'pegawai/target/indicators', $data);
    }

    public function indicators_add()
    {
        $active_year = $this->master_model->get_active_year();
        if (!$active_year) redirect('dashboard');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('indicator_name', 'Indicator Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['active_year'] = $active_year;
            $this->template->set('page', 'Tambah Indikator');
            $this->template->load('layout/template', 'pegawai/target/indicator_form', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $post['year_id'] = $active_year->id;
            $this->pkp_model->add_indicator($post);
            $this->session->set_flashdata('success', 'Data saved');
            redirect('pegawai/target/indicators');
        }
    }

    public function indicators_edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('indicator_name', 'Indicator Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $query = $this->pkp_model->get_indicator($id);
            if ($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $this->template->set('page', 'Edit Indikator');
                $this->template->load('layout/template', 'pegawai/target/indicator_form', $data);
            } else {
                $this->session->set_flashdata('error', 'Data not found');
                redirect('pegawai/target/indicators');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->pkp_model->edit_indicator($post);
            $this->session->set_flashdata('success', 'Data updated');
            redirect('pegawai/target/indicators');
        }
    }

    public function indicators_del($id)
    {
        // Check if has targets
        $check = $this->pkp_model->get_targets_by_indicator($id);
        if($check->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Cannot delete: Indicator has targets attached.');
            redirect('pegawai/target/indicators');
        } else {
            $this->pkp_model->del_indicator($id);
            $this->session->set_flashdata('success', 'Data deleted');
            redirect('pegawai/target/indicators');
        }
    }

    // Targets
    public function add()
    {
        $active_year = $this->master_model->get_active_year();
        if (!$active_year) {
            $this->session->set_flashdata('error', 'No active fiscal year found.');
            redirect('dashboard');
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('activity_name', 'Activity Name', 'required');
        $this->form_validation->set_rules('target_qty', 'Target Qty', 'required|numeric');
        $this->form_validation->set_rules('indicator_id', 'Indicator', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['active_year'] = $active_year;
            $data['indicators'] = $this->pkp_model->get_indicators($this->session->userdata('id_user'), $active_year->id);
            $this->template->set('page', 'Tambah Target');
            $this->template->load('layout/template', 'pegawai/target/form', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $post['year_id'] = $active_year->id;
            $this->pkp_model->add_target($post);
            $this->session->set_flashdata('success', 'Data saved');
            redirect('pegawai/target');
        }
    }

    public function edit($id)
    {
        $active_year = $this->master_model->get_active_year();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('activity_name', 'Activity Name', 'required');
        $this->form_validation->set_rules('indicator_id', 'Indicator', 'required');

        if ($this->form_validation->run() == FALSE) {
            $query = $this->pkp_model->get_target($id);
            if ($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $data['indicators'] = $this->pkp_model->get_indicators($this->session->userdata('id_user'), $active_year->id);
                $this->template->set('page', 'Edit Target');
                $this->template->load('layout/template', 'pegawai/target/form', $data);
            } else {
                $this->session->set_flashdata('error', 'Data not found');
                redirect('pegawai/target');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->pkp_model->edit_target($post);
            $this->session->set_flashdata('success', 'Data updated');
            redirect('pegawai/target');
        }
    }

    public function del($id)
    {
        $this->pkp_model->del_target($id);
        $this->session->set_flashdata('success', 'Data deleted');
        redirect('pegawai/target');
    }
}
