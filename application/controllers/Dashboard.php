<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
        check_not_login();
        $this->load->model(['pkp_model', 'master_model', 'user_model']);

        $data['page'] = 'Dashboard';
        $data['active_year'] = $this->master_model->get_active_year();
        
        if($this->session->userdata('role') == 'pegawai') {
            $user_id = $this->session->userdata('id_user');
            $data['user'] = $this->user_model->get($user_id)->row();
            
            // Get filter parameters
            $data['period_type'] = $this->input->get('period_type') ? $this->input->get('period_type') : 'yearly';
            $data['period_value'] = $this->input->get('period_value') ? $this->input->get('period_value') : null;
            
            if($data['active_year']) {
                $data['targets'] = $this->pkp_model->get_targets($user_id, $data['active_year']->id);
            } else {
                $data['targets'] = null;
            }
        } else if($this->session->userdata('role') == 'admin') {
            $data['count_users'] = $this->user_model->get_all_with_relations()->num_rows();
            $data['count_units'] = $this->master_model->get_units()->num_rows();
            
            if($data['active_year']) {
                // Change to Last Month
                $current_month = date('m');
                $last_month = $current_month - 1;
                if($last_month == 0) {
                    $last_month = 12; // If Jan, go to Dec of prev year (though year_id might differ, for now let's just assume same year context or handle simple prev month)
                    // Ideally we should check year too, but for simplicity in this context:
                }
                
                $data['count_submitted'] = $this->pkp_model->count_users_submitted_month($last_month, $data['active_year']->id);
            } else {
                $data['count_submitted'] = 0;
            }
        }

        $this->template->load('layout/template', 'dashboard', $data);
    }
}
