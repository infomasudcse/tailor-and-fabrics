<?php
class Fb_Branch_Model extends CI_Model
{	
	
	function get_all()
	{
		$this->db->from('branch');
		$this->db->order_by("branch_name", "asc");		
		return $this->db->get();		
	}
	
        function getBranch($id=''){
            $this->db->where('branch_id', $id);
				
		$sql = $this->db->get('branch');
            if($sql->num_rows() == 1){
                return $sql->row(); 
            }
            
            
        }

        function up_branch($data, $id){
            $this->db->where('branch_id', $id);
            if($this->db->update('branch', $data)){
                return true;
            }
        }
        
        
        
        
        
}
?>
