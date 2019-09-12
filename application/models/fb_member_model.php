<?php

class Fb_Member_Model extends CI_Model{
    
     function count_all()
	{
		$this->db->from('fb_branchmember');
		$this->db->where('status',1);
		return $this->db->count_all_results();
	}
        
        function get_all($limit=50, $offset=0)
	{
		$this->db->from('fb_branchmember');
                $this->db->join('branch','fb_branchmember.branch_id=branch.branch_id');	
		$this->db->where('fb_branchmember.status',1);
		$this->db->order_by("fb_branchmember.id", "desc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
     function count_all_bm()
	{
		$this->db->from('fb_branchmember');
                $this->db->where('branch_id', $this->session->userdata('branch_id'));
		$this->db->where('status',1);
		return $this->db->count_all_results();
	}
        
        function get_all_bm($limit=50, $offset=0)
	{
		$this->db->from('fb_branchmember');
                $this->db->join('branch','fb_branchmember.branch_id=branch.branch_id');	
                  $this->db->where('fb_branchmember.branch_id', $this->session->userdata('branch_id'));
		$this->db->where('fb_branchmember.status',1);
		$this->db->order_by("fb_branchmember.id", "desc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
    function search_member($str){
         $this->db->from('fb_branchmember');
         	$this->db->where('status',1);
                $this->db->like('full_name', $str);                 
                $this->db->or_like('contact', $str);  
                   $this->db->or_like('code', $str);  
		$this->db->order_by("id", "asc");		
		return $this->db->get();
        
        
    }
    
   function getMember($id){
       $this->db->from('fb_branchmember');
       $this->db->where('id', $id);
       $sql = $this->db->get();
       if($sql->num_rows() == 1 ){
           return $sql->row(); 
       }
       
   } 
  
   
   
   
   function get_member_info($code){
       $this->db->from('fb_branchmember');
       $this->db->where('code', $code);
       $sql = $this->db->get();
       if($sql->num_rows() == 1 ){
           return $sql->row(); 
       }
       
   } 
    
   function is_valid_code($code){
       $this->db->from('fb_branchmember');
       $this->db->where('code', $code);
       $sql = $this->db->get();
       if($sql->num_rows() == 1 ){
           return true; 
       }else{
           return false;
       }
   }
   
   
   function get_day_attendance(){
      $this->db->where('day', date('Y-m-d'));
       $this->db->where('branch_id', $this->session->userdata('branch_id'));
       $sql = $this->db->get('fb_member_attendance');
       
       return $sql;
       
   }
   
   
   function get_branch_name($id){
       $this->db->where('branch_id', $id);
       $sql = $this->db->get('branch');
       if($sql->num_rows() == 1){
           return $sql->row();
       }
   }
   
   function get_member($branch_id=''){
       $this->db->where('branch_id', $branch_id);
       $sql = $this->db->get('fb_branchmember');
       if($sql->num_rows() > 0){
           return $sql->result();
       }
   }
   
   
   
   
   /*end*/ 
} 


?>
