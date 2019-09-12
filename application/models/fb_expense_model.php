<?php
class Fb_Expense_Model extends CI_Model  {
    
  
      function count_all()
	{
		$this->db->from('fb_expense');
		$this->db->where('branch_id', $this->session->userdata('branch_id'));
		return $this->db->count_all_results();
	}
        
        function get_all($limit=50, $offset=0)
	{
		$this->db->from('fb_expense');
		$this->db->join('fb_expense_type','fb_expense.expense_type_id=fb_expense_type.id');	
		$this->db->join('branch','fb_expense.branch_id=branch.branch_id');
                $this->db->where('fb_expense.branch_id', $this->session->userdata('branch_id'));
                 $this->db->order_by('fb_expense.id','desc');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
       function get_all_expense_type(){
                $this->db->from('fb_expense_type');
		
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
