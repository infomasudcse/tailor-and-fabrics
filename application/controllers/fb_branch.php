<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Fb_Branch extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
                  if($this->session->userdata('person_id') == NULL)
         {
            redirect("/login","refresh");
         }
                $this->load->model('fb_branch_model');
	}
	
	function index()
	{
		$bdata['data'] = $this->fb_branch_model->get_all();
                 $this->load->view('fb_common/header');
                $this->load->view('fb_branch/home', $bdata);
                 $this->load->view('fb_common/footer');
	}
	
        function edit_info(){
            $id = $this->input->post('branch_id');

        $data['branch'] = $this->fb_branch_model->getBranch($id);
        echo $this->load->view('fb_branch/edit_form', $data, true);
        }
        
        function update(){
            $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="bg-danger">', '</div>');
        $this->form_validation->set_rules('name', 'Branch Name', 'required');
        $this->form_validation->set_rules('address', 'Branch address', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
     

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            
            if($this->input->post('id', true) != ''){
            $branch = array(
                'branch_name'=>$this->input->post('name', true),
                'branch_address'=>$this->input->post('address', true),
                'branch_phone'=>$this->input->post('phone', true),
            );
            if($this->fb_branch_model->up_branch($branch, $this->input->post('id'))){
                echo 'ok';
            }else{
                echo 'can not update !';
            }
            
            }else{
                echo 'Try again !';
            }
            
         }
        }
      
        function employee(){
            
            
            
            
        }
        
        
        
        
        
        
        
        
        
        
}
?>