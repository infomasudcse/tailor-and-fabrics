<?php
class Fb_Employee_Model extends CI_Model  {
    
  
      function count_all()
	{
		$this->db->from('employees');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
        
        function get_all($limit=50, $offset=0)
	{
		$this->db->from('employees');
		$this->db->join('people','employees.person_id=people.person_id');			
		$this->db->where('deleted',0);
		$this->db->order_by("last_name", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
       
        
   /***********end of fumction******/     
    
}

?>
