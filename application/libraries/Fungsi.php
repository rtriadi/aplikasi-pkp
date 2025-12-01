<?php

class Fungsi
{
	protected $ci;

	function __construct()
	{
		$this->ci = &get_instance();
	}

	function user_login()
	{
		$id_user = $this->ci->session->userdata('id_user');
        $this->ci->db->select('users.*, ref_units.name as unit_name, ref_ranks.rank_name, ref_ranks.golongan, ref_positions.position_name');
        $this->ci->db->from('users');
        $this->ci->db->join('ref_units', 'users.unit_id = ref_units.id', 'left');
        $this->ci->db->join('ref_ranks', 'users.rank_id = ref_ranks.id', 'left');
        $this->ci->db->join('ref_positions', 'users.position_id = ref_positions.id', 'left');
        $this->ci->db->where('users.id', $id_user);
		$user_data = $this->ci->db->get()->row();
		return $user_data;
	}
}
