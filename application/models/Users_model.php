<?php
Class Users_model extends CI_Model
{
  function get_user($user_id,$su){
		if($su!=0){
			$query = $this->db->get_where('users',array('id' => $user_id));
			return $query->row_array();
		}else{
			$this->db->join("user_group",'user_group.gid = users.gid');
			$query = $this->db->get_where('users',array('id' => $user_id));
			return $query->row_array();
		}
	}

  function user_list(){
		$this->db->order_by("id", "desc");
		$query = $this -> db -> get('users');
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

  function insert_user(){
		$insert_data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('user_password')),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
      'gid' => $this->input->post('group'),
      'prop' => $this->input->post('prop'),
			'su' => $this->input->post('account_type'),
      'date_created' => date('Y-m-d H:i:s')
		);
		if($this->db->insert('users',$insert_data)){
			return "User added successfully";
		}else{
			return "Unable to add user";
		}
	}

  function update_user($user_id){
		$user_detail = array(
			'username' => $this->input->post('username'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'gid' => $this->input->post('group'),
      'prop' => $this->input->post('prop'),
			'su' => $this->input->post('account_type')
		);
    if($this->input->post('user_password')!=''){
      $user_detail['password'] = md5($this->input->post('user_password'));
    }
		$this->db->where('id', $user_id);
		$this->db->update('users',$user_detail);
		return "User updated";
	}

  function remove_user($id){
		$query=$this->db->query("select * from users where id='$id'");
		$result=$query->row_array();
		if(($result['gid']!="SPA") && ($result['su']!="1")){
  		$this->db->delete('users', array('id' => $id));
			return true;
		}else{
			return false;
		}
	}

  function login_user_by_admin($id){
		$this -> db -> where('id', $id);
		$query = $this -> db -> get('users');
		if($query -> num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
}
