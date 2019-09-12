<?php
class Fb_Customer_Model extends CI_Model  {
    
  
      function count_all()
	{
		$this->db->from('customers');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
        
        function get_all($limit=50, $offset=0)
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');
               
		$this->db->where('deleted',0);
		$this->db->order_by("last_name", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
        function search_cutomer($str){
            $this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');		
		/* $this->db->from('people');*/
                $this->db->like('people.first_name', $str); 
                 $this->db->or_like('people.last_name', $str);
                $this->db->or_like('people.phone_number', $str);  
		$this->db->order_by("customers.person_id", "asc");		
		return $this->db->get();
        }
        
   /***********end of fumction******/     
    
}

?>
