<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        // check_admin(); // Implement later
        $this->load->model('master_model');
    }

    // Years
    public function years()
    {
        $data['row'] = $this->master_model->get_years();
        $this->template->set('page', 'Data Master');
        $this->template->load('layout/template', 'admin/master/years', $data);
    }

    public function years_add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('year', 'Year', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->template->set('page', 'Data Master');
            $this->template->load('layout/template', 'admin/master/year_form');
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->add_year($post);
            if(isset($post['is_active'])) {
                $this->master_model->set_active_year($this->db->insert_id());
            }
            $this->session->set_flashdata('success', 'Data saved');
            redirect('admin/master/years');
        }
    }

    public function years_edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('year', 'Year', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $query = $this->master_model->get_years($id);
            if ($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $this->template->set('page', 'Data Master');
                $this->template->load('layout/template', 'admin/master/year_form', $data);
            } else {
                $this->session->set_flashdata('error', 'Data not found');
                redirect('admin/master/years');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->edit_year($post);
            if(isset($post['is_active'])) {
                $this->master_model->set_active_year($post['id']);
            }
            $this->session->set_flashdata('success', 'Data updated');
            redirect('admin/master/years');
        }
    }

    public function years_del($id)
    {
        $this->master_model->del_year($id);
        $this->session->set_flashdata('success', 'Data deleted');
        redirect('admin/master/years');
    }

    // Units
    public function units()
    {
        $data['row'] = $this->master_model->get_units();
        $this->template->set('page', 'Data Master');
        $this->template->load('layout/template', 'admin/master/units', $data);
    }

    public function units_add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->template->set('page', 'Data Master');
            $this->template->load('layout/template', 'admin/master/unit_form');
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->add_unit($post);
            $this->session->set_flashdata('success', 'Data saved');
            redirect('admin/master/units');
        }
    }

    public function units_edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $query = $this->master_model->get_units($id);
            if ($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $this->template->set('page', 'Data Master');
                $this->template->load('layout/template', 'admin/master/unit_form', $data);
            } else {
                $this->session->set_flashdata('error', 'Data not found');
                redirect('admin/master/units');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->edit_unit($post);
            $this->session->set_flashdata('success', 'Data updated');
            redirect('admin/master/units');
        }
    }

    public function units_del($id)
    {
        $this->master_model->del_unit($id);
        $this->session->set_flashdata('success', 'Data deleted');
        redirect('admin/master/units');
    }

    // Ranks
    public function ranks()
    {
        $data['row'] = $this->master_model->get_ranks();
        $this->template->set('page', 'Data Master');
        $this->template->load('layout/template', 'admin/master/ranks', $data);
    }

    public function ranks_add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('rank_name', 'Rank Name', 'required');
        $this->form_validation->set_rules('golongan', 'Golongan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->template->set('page', 'Data Master');
            $this->template->load('layout/template', 'admin/master/rank_form');
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->add_rank($post);
            $this->session->set_flashdata('success', 'Data saved');
            redirect('admin/master/ranks');
        }
    }

    public function ranks_edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('rank_name', 'Rank Name', 'required');
        $this->form_validation->set_rules('golongan', 'Golongan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $query = $this->master_model->get_ranks($id);
            if ($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $this->template->set('page', 'Data Master');
                $this->template->load('layout/template', 'admin/master/rank_form', $data);
            } else {
                $this->session->set_flashdata('error', 'Data not found');
                redirect('admin/master/ranks');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->edit_rank($post);
            $this->session->set_flashdata('success', 'Data updated');
            redirect('admin/master/ranks');
        }
    }

    public function ranks_del($id)
    {
        $this->master_model->del_rank($id);
        $this->session->set_flashdata('success', 'Data deleted');
        redirect('admin/master/ranks');
    }

    // Positions
    public function positions()
    {
        $data['row'] = $this->master_model->get_positions();
        $this->template->set('page', 'Data Master');
        $this->template->load('layout/template', 'admin/master/positions', $data);
    }

    public function positions_add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('position_name', 'Position Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->template->set('page', 'Data Master');
            $this->template->load('layout/template', 'admin/master/position_form');
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->add_position($post);
            $this->session->set_flashdata('success', 'Data saved');
            redirect('admin/master/positions');
        }
    }

    public function positions_edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('position_name', 'Position Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $query = $this->master_model->get_positions($id);
            if ($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $this->template->set('page', 'Data Master');
                $this->template->load('layout/template', 'admin/master/position_form', $data);
            } else {
                $this->session->set_flashdata('error', 'Data not found');
                redirect('admin/master/positions');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->master_model->edit_position($post);
            $this->session->set_flashdata('success', 'Data updated');
            redirect('admin/master/positions');
        }
    }

    public function positions_del($id)
    {
        $this->master_model->del_position($id);
        $this->session->set_flashdata('success', 'Data deleted');
        redirect('admin/master/positions');
    }
}
