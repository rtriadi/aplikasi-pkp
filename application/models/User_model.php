<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function login($post)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('nip', $post['nip']);
        $query = $this->db->get();
        return $query;
    }

    public function get($id = null)
    {
        $this->db->select('users.*, ref_units.name as unit_name, ref_ranks.rank_name, ref_ranks.golongan, ref_positions.position_name');
        $this->db->from('users');
        $this->db->join('ref_units', 'users.unit_id = ref_units.id', 'left');
        $this->db->join('ref_ranks', 'users.rank_id = ref_ranks.id', 'left');
        $this->db->join('ref_positions', 'users.position_id = ref_positions.id', 'left');
        if ($id != null) {
            $this->db->where('users.id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params['nip'] = $post['nip'];
        $params['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
        $params['full_name'] = $post['full_name'];
        $params['role'] = $post['role'];
        $params['unit_id'] = $post['unit_id'] ?? null;
        $params['rank_id'] = $post['rank_id'] ?? null;
        $params['position_id'] = $post['position_id'] ?? null;
        $this->db->insert('users', $params);
    }

    public function edit($post)
    {
        $params['nip'] = $post['nip'];
        if (!empty($post['password'])) {
            $params['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
        }
        $params['full_name'] = $post['full_name'];
        $params['role'] = $post['role'];
        $params['unit_id'] = $post['unit_id'] ?? null;
        $params['rank_id'] = $post['rank_id'] ?? null;
        $params['position_id'] = $post['position_id'] ?? null;
        $this->db->where('id', $post['id']);
        $this->db->update('users', $params);
    }

    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    public function get_all_with_relations()
    {
        $this->db->select('users.*, ref_units.name as unit_name, ref_ranks.rank_name, ref_ranks.golongan, ref_positions.position_name');
        $this->db->from('users');
        $this->db->join('ref_units', 'users.unit_id = ref_units.id', 'left');
        $this->db->join('ref_ranks', 'users.rank_id = ref_ranks.id', 'left');
        $this->db->join('ref_positions', 'users.position_id = ref_positions.id', 'left');
        $this->db->where('role', 'pegawai');
        return $this->db->get();
    }
}
