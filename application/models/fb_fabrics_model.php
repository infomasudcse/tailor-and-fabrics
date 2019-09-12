<?php
class Fb_Fabrics_Model extends CI_Model  {
    
  
      function count_all()
	{
                $this->db->from('fabrics');                
                $this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
        
        function get_all($limit=50, $offset=0)
	{
		$this->db->from('fabrics');	
                $this->db->where('deleted',0);
		$this->db->order_by("fabrics_model", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
        function search_fabric($str){
           		
		 $this->db->from('fabrics');
                 if($this->session->userdata('branch_id') != 0){
                    $this->db->where('branch_id', $this->session->userdata('branch_id'));
                }
                 $this->db->like('fabrics_model', $str); 
                 $this->db->or_like('name', $str); 
		$this->db->order_by("branch_id", "asc");		
		return $this->db->get();
        }
        
        function getProduct($id){
             $this->db->from('fabrics');
             $this->db->where('fabrics_id', $id);
             $this->db->where('deleted',0);
             $query = $this->db->get();
             if($query->num_rows() == 1){
                 return $query->row();
             }else{
                 return '';
             }
        }
        
        
        function update_fb($table, $data, $id){
            $this->db->where('fabrics_id', $id);
            if($this->db->update($table, $data))
                    return true;
            
        }
        
        
        function deleteProduct($id){
            $this->db->where('fabrics_id', $id);
            if($this->db->delete('fabrics')){
                return true;
            }else{
                return false;
            }
        }
        
        function get_exists($fabrics_model='', $branch_id=''){
            $this->db->where('fabrics_model', $fabrics_model);
            $this->db->where('branch_id', $branch_id);
            $query = $this->db->get('fabrics');
          
            if($query->num_rows() == 1){
                 return $query->row();
                
            }
            
        }
        
        function get_exists_to_sell($fabrics_model='', $branch_id=''){
            $this->db->where('fabrics_model', $fabrics_model);
            $this->db->where('branch_id', $branch_id);
            $query = $this->db->get('fabrics');
          
            if($query->num_rows() == 1){
                return $query->row();
                
            }
            
        }
        
        function get_item_by_id($id=''){
          $this->db->where('fabrics_id', $id);
          $query = $this->db->get('fabrics');
          if($query->num_rows() == 1){
              return $query->row();
          }
          
            
        }
        
        
        function is_available_customer_byphone($phone_number){
           $this->db->where('phone_number', $phone_number);
          $query = $this->db->get('people');
          if($query->num_rows() == 1){
              return $query->row()->person_id;
          } 
        }
        
        function is_duplicate_invoice($invoice){
            $this->db->where('invoice', $invoice);
            $query = $this->db->get('fb_sell');
            if($query->num_rows() > 0){
                return true;
            }
        }
        
         function count_all_invoice()
	{
                $this->db->from('fb_order');  
                $this->db->where('branch_id',$this->session->userdata('branch_id'));
		return $this->db->count_all_results();
	}
        
        function get_all_invoice($limit=50, $offset=0)
	{
		$this->db->from('fb_order');					
                 $this->db->where('branch_id',$this->session->userdata('branch_id'));
		$this->db->order_by("id", "desc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
         function count_all_invoice_admin()
	{
                $this->db->from('fb_order');  
               
		return $this->db->count_all_results();
	}
        
        function get_all_invoice_admin($limit=50, $offset=0)
	{
		$this->db->from('fb_order');					
                
		$this->db->order_by("id", "desc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
        function search_invoice_admin($str){
           
            if(is_numeric($str)){
                
                $this->db->where('phone_number', $str);
                $sql = $this->db->get('people');
                if($sql->num_rows() == 1){
                 
                   $this->db->where('customer_id', $sql->row()->person_id);
                    $query = $this->db->get('fb_order');  
                    if($query->num_rows() > 0){
                       return $query;
                    }
                }else{
                    return '';
                }
            }else{
                 $this->db->from('fb_order');
                $this->db->like('invoice', $str); 
                $this->db->or_like('order_date', $str);
                $this->db->order_by("id", "desc");
                return $this->db->get();
            }  
				
		
        }
         function search_invoice($str){
           
            if(is_numeric($str)){
                
                $this->db->where('phone_number', $str);
           
                $sql = $this->db->get('people');
                if($sql->num_rows() == 1){
                 
                   $this->db->where('customer_id', $sql->row()->person_id);
                  $this->db->where('branch_id', $this->session->userdata('branch_id'));
                   
                    $query = $this->db->get('fb_order');  
                    if($query->num_rows() > 0){
                       return $query;
                    }
                     
                                
                 
                }else{
                    return '';
                }
            }else{
                 $this->db->from('fb_order');
                $this->db->like('invoice', $str); 
                $this->db->or_like('order_date', $str);
                $this->db->order_by("id", "desc");
                return $this->db->get();
            }  
				
		
        }
        
        function getinvoicedata($invoice){
            $this->db->where('branch_id', $this->session->userdata('branch_id'));
            $this->db->where('invoice', $invoice);
            $query = $this->db->get('fb_order');
            if($query->num_rows() == 1){
                return $query->row();
            }
        }
        
        function getinvoic($inv, $id){
             $this->db->where('branch_id', $this->session->userdata('branch_id'));
            $this->db->where('invoice', $inv);
            $this->db->where('id', $id);
            $query = $this->db->get('fb_order');
            if($query->num_rows() == 1){
                return $query->row();
            }
        }
        
     function is_sold($id=''){
         $this->db->where('fabrics_id', $id);
         $query =$this->db->get('fb_sell');
         if($query->num_rows() > 0){return true;}else{return false;}
     }
     
     function update_fb_bulk($info=array(),$model){
         $this->db->where('fabrics_model', $model);
        $query = $this->db->get('fabrics');
         if($query->num_rows() > 0){
             foreach($query->result() as $row){
                 $this->db->where('fabrics_id', $row->fabrics_id);
                 $this->db->update('fabrics', $info);
             }
         }
         
         
     }
     
     
     function get_card_info($card_num=''){
         if($card_num != ''){
             $this->db->where('card_number', $card_num);
             $this->db->where('person_id', $this->session->userdata('cus_id'));
             $sql = $this->db->get('fb_card');
             if($sql->num_rows() == 1){
                 return $sql->row();
             }
         }
     }
     
   /***********end of fumction******/     
    
}

?>
