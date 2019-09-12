<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Employee extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('fb_employee_model');
         
         if($this->session->userdata('person_id') == NULL)
         {
            redirect("/login","refresh");
         }
    }

    public function index() {
        ///here pagination library
        
        $config['base_url'] = site_url('/fb_employee/index');
        $config['total_rows'] = $this->fb_employee_model->count_all();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['results'] = $this->fb_employee_model->get_all( $config['per_page']);
        $data['links'] = $this->pagination->create_links();
       
        $this->load->view('fb_common/header');
        $this->load->view('fb_employee/home',$data);
        $this->load->view('fb_common/footer');
    }

    
    
    
    
    
    
    
    
    
    }