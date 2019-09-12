<?php
class Fb_Report_Model extends CI_Model  {
    
  function generate_order_report($from='',$to='',$type='',$branch=''){
      if($type == 'sp'){          
            $dateRange = "order_date BETWEEN '$from%' AND '$to%'";
            $this->db->where($dateRange, NULL, FALSE); 
      }
      if($branch!= ''){
          $this->db->where('branch_id', $branch);
      }
      $query = $this->db->get('fb_order');
      if($query->num_rows() > 0){
          return $query->result();
      }     
  }
   
 function get_order($branch='',$start='',$end=''){
     $this->db->where('branch_id',$branch);
     if($start !='' && $end != ''){
         $dateRange = "order_date BETWEEN '$start%' AND '$end%'";
     }
     $this->db->where($dateRange, NULL, FALSE);
     $query = $this->db->get('fb_order');
     return $query->result();
 }
 function get_payment($branch='',$start='',$end=''){
     $this->db->where('branch_id',$branch);
    
    if($start !='' && $end != ''){
         $dateRange = "paydate BETWEEN '$start%' AND '$end%'";
     }
      $this->db->where($dateRange, NULL, FALSE);
     $query = $this->db->get('fb_payment');
     return $query->result();
 }
 function get_expense($branch='',$start='',$end=''){
     $this->db->where('branch_id',$branch);
     
     if($start !='' && $end != ''){
         $dateRange = "expdate BETWEEN '$start%' AND '$end%'";
     }
      $this->db->where($dateRange, NULL, FALSE);
    $this->db->join('fb_expense_type','fb_expense.expense_type_id=fb_expense_type.id');	
     $query = $this->db->get('fb_expense');
     return $query->result();
 }
  
function get_order_branch($branch='',$start='',$end='',$type=''){
     $this->db->where('branch_id',$branch);
     if($type != 'all'){
         $dateRange = "order_date BETWEEN '$start%' AND '$end%'";
           $this->db->where($dateRange, NULL, FALSE);
     }
   
     $query = $this->db->get('fb_order');
     return $query->result();
 }
 function get_payment_branch($branch='',$start='',$end='',$type=''){
     $this->db->where('branch_id',$branch);
    
    if($type != 'all'){
         $dateRange = "paydate BETWEEN '$start%' AND '$end%'";
         $this->db->where($dateRange, NULL, FALSE);
     }
      
     $query = $this->db->get('fb_payment');
     return $query->result();
 }
 function get_expense_branch($branch='',$start='',$end='',$type=''){
     $this->db->where('branch_id',$branch);
     
     if($type != 'all'){
         $dateRange = "expdate BETWEEN '$start%' AND '$end%'";
          $this->db->where($dateRange, NULL, FALSE);
     }
     
    $this->db->join('fb_expense_type','fb_expense.expense_type_id=fb_expense_type.id');	
     $query = $this->db->get('fb_expense');
     return $query->result();
 } 
 
 
 function get_tranfer_report($from='',$to='',$start='',$end='',$type=''){
     $this->db->where('from_branch_id',$from);
     $this->db->where('to_branch_id',$to);
      if($type != 'all'){
         $dateRange = "trans_date BETWEEN '$start%' AND '$end%'";
          $this->db->where($dateRange, NULL, FALSE);
     }
     $query = $this->db->get('fabrics_transfer');
     return $query->result();
     
 }
  
 
 function get_branch_name($id){
     $this->db->where('branch_id', $id);
     $sql = $this->db->get('branch');
     if($sql->num_rows() ==1){
         return $sql->row()->branch_name;
     }
     
 }
 
 
 function get_expense_report($exp_type='',$branch='',$from_date='',$to_date='',$type=''){
       
            $this->db->where('branch_id',$branch);
        
        if($exp_type != ''){
          $this->db->where('expense_type_id',$exp_type);
      	
        }
     if($type == 'sp'){
         $dateRange = "expdate BETWEEN '$from_date%' AND '$to_date%'";
          $this->db->where($dateRange, NULL, FALSE);
     }
     $this->db->join('fb_expense_type','fb_expense.expense_type_id=fb_expense_type.id');
   
     $query = $this->db->get('fb_expense');
     return $query->result();  
     
 }
 
 
 function get_attendance_report($member_id='',$branch_id='',$from_date='',$to_date='',$type=''){
      $this->db->where('branch_id',$branch_id);
   
       if($member_id != ''){   
           $this->db->where('member_id',$member_id);
           
       }
     if($type == 'sp'){
         $dateRange = "day BETWEEN '$from_date%' AND '$to_date%'";
          $this->db->where($dateRange, NULL, FALSE);
     }
     
   
     $query = $this->db->get('fb_member_attendance');
     return $query->result();  
     
     
     
     
 }
 
 
 
 
   /***********end of fumction******/     
    
}

?>
