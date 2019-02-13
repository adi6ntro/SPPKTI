<?php
Class Group_model extends CI_Model{
	function get_allgroups($role=''){
		$addsql = '';
		if($role!='SPA'){
			$addsql = " AND gid not in('ADM','SPA')";
		}
		$query = $this->db->query("SELECT * FROM user_group WHERE 1=1" . $addsql);
		$result = $query->result_array();
		return $result;
	}

	function group_list($id){
		$this->db->select('gid, group_name');
		$this->db->from('user_group');
		if($id!='SPA'){
			$this->db->where_not_in('gid', array('SPA','ADM'));
		}
		$this->db->order_by("gid", "desc");
		$query = $this->db->get();

		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function insert_group(){
		$insert_group = array(
			'gid' => $this->input->post('gid'),
			'group_name' => $this->input->post('groupname')
		);
		$this->db->insert('user_group',$insert_group);
		return "Group added successfully";
	}
	// get particular group detail
	function get_group($gid){
	 	$this->db->where('gid',$gid);
		$query = $this->db->get('user_group');
		return $query->row_array();
	}

	// update group detail
 	function update_group($gid){
 		$group_detail = array(
			'gid' => $this->input->post('gid'),
			'group_name' => $this->input->post('groupname')
	 	);
	 	$this->db->where('gid', $gid);
 		$this->db->update('user_group',$group_detail);
 		return "Group updated";
 	}

 	// delete group
 	function remove_group($gid){
		if($this->db->delete('user_group', array('gid' => $gid))){
		  	return true;
		}else{
		  	return false;
		}
	}
}
?>
