<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model {

    // Years
    public function get_years($id = null)
    {
        $this->db->from('ref_years');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add_year($post)
    {
        $params['year'] = $post['year'];
        $params['is_active'] = isset($post['is_active']) ? 1 : 0;
        $this->db->insert('ref_years', $params);
    }

    public function edit_year($post)
    {
        $params['year'] = $post['year'];
        $params['is_active'] = isset($post['is_active']) ? 1 : 0;
        $this->db->where('id', $post['id']);
        $this->db->update('ref_years', $params);
    }

    public function del_year($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_years');
    }

    public function set_active_year($id)
    {
        // Deactivate all
        $this->db->update('ref_years', ['is_active' => 0]);
        // Activate one
        $this->db->where('id', $id);
        $this->db->update('ref_years', ['is_active' => 1]);
    }

    public function get_active_year()
    {
        return $this->db->get_where('ref_years', ['is_active' => 1])->row();
    }

    // Units
    public function get_units($id = null)
    {
        $this->db->from('ref_units');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add_unit($post)
    {
        $params['name'] = $post['name'];
        $this->db->insert('ref_units', $params);
    }

    public function edit_unit($post)
    {
        $params['name'] = $post['name'];
        $this->db->where('id', $post['id']);
        $this->db->update('ref_units', $params);
    }

    public function del_unit($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_units');
    }

    // Ranks
    public function get_ranks($id = null)
    {
        $this->db->from('ref_ranks');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add_rank($post)
    {
        $params['rank_name'] = $post['rank_name'];
        $params['golongan'] = $post['golongan'];
        $this->db->insert('ref_ranks', $params);
    }

    public function edit_rank($post)
    {
        $params['rank_name'] = $post['rank_name'];
        $params['golongan'] = $post['golongan'];
        $this->db->where('id', $post['id']);
        $this->db->update('ref_ranks', $params);
    }

    public function del_rank($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_ranks');
    }

    // Positions
    public function get_positions($id = null)
    {
        $this->db->from('ref_positions');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add_position($post)
    {
        $params['position_name'] = $post['position_name'];
        $this->db->insert('ref_positions', $params);
    }

    public function edit_position($post)
    {
        $params['position_name'] = $post['position_name'];
        $this->db->where('id', $post['id']);
        $this->db->update('ref_positions', $params);
    }

    public function del_position($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_positions');
    }
}
