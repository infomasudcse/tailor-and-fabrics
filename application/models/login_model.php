<?php
class Login_Model extends CI_Model
{
	/*
	Determines if a given person_id is an employee
	*/
	function exists($person_id)
	{
		$this->db->from('employees');	
		$this->db->join('people', 'people.person_id = employees.person_id');
		$this->db->where('employees.person_id',$person_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}	
	
	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($username, $password)
	{
		$query = $this->db->get_where('employees', array('username' => $username,'password'=>md5($password)), 1);
		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('person_id', $row->person_id);
                        $this->session->set_userdata('branch_id', $row->branch_id);
			return true;
		}
		return false;
	}
	
	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
	
}