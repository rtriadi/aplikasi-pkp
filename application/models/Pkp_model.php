<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkp_model extends CI_Model {

    // Indicators
    public function get_indicators($user_id, $year_id)
    {
        $this->db->from('pkp_indicators');
        $this->db->where('user_id', $user_id);
        $this->db->where('year_id', $year_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_indicator($id)
    {
        $this->db->from('pkp_indicators');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query;
    }

    public function add_indicator($post)
    {
        $params['user_id'] = $this->session->userdata('id_user');
        $params['year_id'] = $post['year_id'];
        $params['indicator_name'] = $post['indicator_name'];
        $this->db->insert('pkp_indicators', $params);
    }

    public function edit_indicator($post)
    {
        $params['indicator_name'] = $post['indicator_name'];
        $this->db->where('id', $post['id']);
        $this->db->update('pkp_indicators', $params);
    }

    public function del_indicator($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pkp_indicators');
    }

    // Targets
    public function get_targets($user_id, $year_id)
    {
        $this->db->select('pkp_targets.*, pkp_indicators.indicator_name');
        $this->db->from('pkp_targets');
        $this->db->join('pkp_indicators', 'pkp_targets.indicator_id = pkp_indicators.id', 'left');
        $this->db->where('pkp_targets.user_id', $user_id);
        $this->db->where('pkp_targets.year_id', $year_id);
        $this->db->order_by('pkp_targets.indicator_id', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_targets_by_indicator($indicator_id)
    {
        $this->db->from('pkp_targets');
        $this->db->where('indicator_id', $indicator_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_target($id)
    {
        $this->db->from('pkp_targets');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query;
    }

    public function add_target($post)
    {
        $params['user_id'] = $this->session->userdata('id_user');
        $params['year_id'] = $post['year_id'];
        $params['indicator_id'] = $post['indicator_id'];
        $params['activity_name'] = $post['activity_name'];
        $params['target_period'] = $post['target_period'];
        $params['target_qty'] = $post['target_qty'];
        $params['target_quality'] = $post['target_quality'];
        $params['target_unit'] = $post['target_unit'];
        $params['target_credit_score'] = $post['target_credit_score'];
        $this->db->insert('pkp_targets', $params);
    }

    public function edit_target($post)
    {
        $params['indicator_id'] = $post['indicator_id'];
        $params['activity_name'] = $post['activity_name'];
        $params['target_period'] = $post['target_period'];
        $params['target_qty'] = $post['target_qty'];
        $params['target_quality'] = $post['target_quality'];
        $params['target_unit'] = $post['target_unit'];
        $params['target_credit_score'] = $post['target_credit_score'];
        $this->db->where('id', $post['id']);
        $this->db->update('pkp_targets', $params);
    }

    public function del_target($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pkp_targets');
    }

    // Monthly Realization
    public function get_monthly_realization($target_id, $month)
    {
        $this->db->from('pkp_monthly');
        $this->db->where('target_id', $target_id);
        $this->db->where('month', $month);
        $query = $this->db->get();
        return $query;
    }

    public function save_realization($post)
    {
        // Check if exists
        $check = $this->get_monthly_realization($post['target_id'], $post['month']);
        
        $params['target_id'] = $post['target_id'];
        $params['month'] = $post['month'];
        $params['real_qty'] = $post['real_qty'];
        $params['real_quality'] = $post['real_quality'];
        // $params['is_active_print'] = isset($post['is_active_print']) ? 1 : 0; // Handled separately or here

        if ($check->num_rows() > 0) {
            $this->db->where('id', $check->row()->id);
            $this->db->update('pkp_monthly', $params);
        } else {
            $this->db->insert('pkp_monthly', $params);
        }
    }

    // Signatures
    public function get_signature($user_id, $month, $year_id)
    {
        $this->db->from('pkp_signatures');
        $this->db->where('user_id', $user_id);
        $this->db->where('month', $month);
        $this->db->where('year_id', $year_id);
        $query = $this->db->get();
        return $query;
    }

    public function save_signature($post)
    {
        $user_id = $this->session->userdata('id_user');
        $check = $this->get_signature($user_id, $post['month'], $post['year_id']);

        $params['user_id'] = $user_id;
        $params['month'] = $post['month'];
        $params['year_id'] = $post['year_id'];
        $params['appraiser_name'] = $post['appraiser_name'];
        $params['appraiser_nip'] = $post['appraiser_nip'];
        $params['appraiser_position'] = $post['appraiser_position'];
        $params['atasan_appraiser_name'] = $post['atasan_appraiser_name'];
        $params['atasan_appraiser_nip'] = $post['atasan_appraiser_nip'];
        $params['atasan_appraiser_position'] = $post['atasan_appraiser_position'];

        if ($check->num_rows() > 0) {
            $this->db->where('id', $check->row()->id);
            $this->db->update('pkp_signatures', $params);
        } else {
            $this->db->insert('pkp_signatures', $params);
        }
    }
    public function get_annual_realization($target_id)
    {
        $this->db->select_sum('real_qty');
        $this->db->where('target_id', $target_id);
        $query = $this->db->get('pkp_monthly');
        return $query->row()->real_qty;
    }

    public function count_users_submitted_month($month, $year_id)
    {
        $this->db->select('pkp_targets.user_id');
        $this->db->from('pkp_monthly');
        $this->db->join('pkp_targets', 'pkp_monthly.target_id = pkp_targets.id');
        $this->db->where('pkp_monthly.month', $month);
        $this->db->where('pkp_targets.year_id', $year_id);
        $this->db->group_by('pkp_targets.user_id');
        return $this->db->get()->num_rows();
    }

    /**
     * Get realization based on period filter
     * @param int $target_id
     * @param string $period_type - 'monthly', 'quarterly', 'yearly'
     * @param int $period_value - for monthly: 1-12, for quarterly: 1-4, for yearly: ignored
     * @return float
     */
    public function get_period_realization($target_id, $period_type = 'yearly', $period_value = null)
    {
        $this->db->select_sum('real_qty');
        $this->db->where('target_id', $target_id);
        
        switch ($period_type) {
            case 'monthly':
                if ($period_value) {
                    $this->db->where('month', $period_value);
                }
                break;
            case 'quarterly':
                if ($period_value) {
                    // Q1: 1-3, Q2: 4-6, Q3: 7-9, Q4: 10-12
                    $start_month = (($period_value - 1) * 3) + 1;
                    $end_month = $period_value * 3;
                    $this->db->where('month >=', $start_month);
                    $this->db->where('month <=', $end_month);
                }
                break;
            case 'yearly':
            default:
                // No filter - sum all months
                break;
        }
        
        $query = $this->db->get('pkp_monthly');
        return $query->row()->real_qty ? $query->row()->real_qty : 0;
    }
}
