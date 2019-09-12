<?php
class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
                $this->load->model('login_model');
	}
	
	function index()
	{
		
            $this->form_validation->set_rules('username', 'User name', 'callback_login_check');
    	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == FALSE)
			{
                           
                            $this->load->view('login');
			}
			else
			{
                            redirect('fb_home/index');
			}
		
	}
	
	function login_check($username)
	{
		$password = $this->input->post("password");	
		
		if(!$this->login_model->login($username, $password))
		{
			$this->form_validation->set_message('login_check', 'Username or Password Invalid ! ');
			return false;
		}else{
		return true;
                }
	}
        
        function logout()
	{
		$this->login_model->logout();
	}
        
}
?>