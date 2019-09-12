<?php
class Fb_Card_Model extends CI_Model  {
    
  
      function count_all()
	{
		$this->db->from('fb_card');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
        
        function get_all($limit=50, $offset=0)
	{
		$this->db->from('fb_card');				
		$this->db->where('deleted',0);
		$this->db->order_by("creation", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
        
        function search_customer_card($str){
            	
		 $this->db->from('fb_card');
                $this->db->like('card_number', $str); 
                 $this->db->or_like('type', $str);
              $this->db->where('deleted',0);
		$this->db->order_by("status", "asc");		
		return $this->db->get();
        }
        
        function create_new($data){
            if($this->db->insert('fb_card', $data)){
            return true;   }
        }
        
        
        function delete_card($id){
             $this->db->where('id', $id);
             $sql = $this->db->get('fb_card');
             if($sql->num_rows() == 1){
                        
                        $data = array('deleted'=>1);
                   $this->db->where('id', $id);
                   if($this->db->update('fb_card', $data)){
                       return true;
                   }
             }
            
        }
        
        function assign_card($card='',$customer=''){
            if($card != '' || $customer != ''){
                
                    /*is valid card */
                    $this->db->where('card_number', $card);
                $sqqql = $this->db->get('fb_card');
                if($sqqql->num_rows == 1){
                         if($sqqql->row()->status == 0){
                            

                                $this->db->where('card_number', $card);
                                $sql=$this->db->get('fb_card');
                                if($sql->num_rows() == 1){
                                    $carddata = array(
                                            'status'=> 1,
                                        'person_id'=> $customer,
                                        'active_date'=> date('Y-m-d')
                                            );

                                    $this->db->where('id', $sql->row()->id);
                                    $this->db->update('fb_card', $carddata);
                                    return 'ok';
                                }

                            
                         }else{
                             return 'Card Already In Use !';
                         }
                            
                }else{
                    return 'Card number not valid !';
                }
            
           
            }else{
                return 'Oops ! try again !';
            } 
            
            
            
        }
        
        
        
        
   /***********end of fumction******/     
    
}

?>
