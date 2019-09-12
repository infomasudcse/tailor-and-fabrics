<?php
class Fb_Tailor_Model extends CI_Model  {
    
  
      function count_all()
	{
		$this->db->from('fb_tailor_cost');
		
		return $this->db->count_all_results();
	}
        
        function get_all($limit=50, $offset=0)
	{
		$this->db->from('fb_tailor_cost');
		
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
      
        
      function check_usage($id='',$table='',$field=''){
          
          $this->db->where($field,$id);
          $query=$this->db->get($table);
          if($query->num_rows() > 0){
              return true;
          }else{
              return false;
          }
      } 
        
        
        
}


?>
