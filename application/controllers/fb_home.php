<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Home extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        

        if ($this->session->userdata('person_id') == NULL) {
            redirect("/login", "refresh");
        }
    }
 
    
   function index(){
       
       
        $this->load->view('fb_common/header');
        if($this->session->userdata('branch_id') == 0){
             $this->load->view('fb_fabrics/admin_dashboard');            
        }else{

                $this->load->view('fb_fabrics/branch_dashboard');
            }
        $this->load->view('fb_common/footer');
       
       
   } 
    
    
    
    
}  
?>
