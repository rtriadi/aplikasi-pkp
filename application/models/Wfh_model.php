<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wfh_model extends CI_Model {

    public function get_all_by_user($user_id)
    {
        $this->db->select('wfh_reports.*, COUNT(wfh_activities.id) as total_activities');
        $this->db->from('wfh_reports');
        $this->db->join('wfh_activities', 'wfh_reports.id = wfh_activities.wfh_report_id', 'left');
        $this->db->where('wfh_reports.user_id', $user_id);
        $this->db->group_by('wfh_reports.id');
        $this->db->order_by('wfh_reports.wfh_date', 'DESC');
        return $this->db->get();
    }

    public function get_by_id($id, $user_id)
    {
        $this->db->from('wfh_reports');
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        return $this->db->get();
    }

    public function get_activities($wfh_report_id)
    {
        $this->db->from('wfh_activities');
        $this->db->where('wfh_report_id', $wfh_report_id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function get_attachments($wfh_report_id)
    {
        $this->db->from('wfh_attachments');
        $this->db->where('wfh_report_id', $wfh_report_id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function insert_report($data)
    {
        $this->db->insert('wfh_reports', $data);
        return $this->db->insert_id();
    }

    public function update_report($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('wfh_reports', $data);
    }

    public function delete_report($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('wfh_reports');
    }

    public function save_activities($wfh_report_id, $activities)
    {
        $this->db->where('wfh_report_id', $wfh_report_id);
        $this->db->delete('wfh_activities');
        if (!empty($activities)) {
            $this->db->insert_batch('wfh_activities', $activities);
        }
    }

    public function insert_attachment($data)
    {
        $this->db->insert('wfh_attachments', $data);
    }

    public function get_attachment($id)
    {
        $this->db->from('wfh_attachments');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function delete_attachment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('wfh_attachments');
    }
}
