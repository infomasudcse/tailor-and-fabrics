<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Expense extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('fb_expense_model');
        
         if($this->session->userdata('person_id') == NULL)
         {
            redirect("/login","refresh");
         }
    }

       function index() {
        ///here pagination library

        $config['base_url'] = site_url('/fb_expense/index');
        $config['total_rows'] = $this->fb_expense_model->count_all();
        $config['per_page'] = 50;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);
        $data['results'] = $this->fb_expense_model->get_all($config['per_page']);
        $data['links'] = $this->pagination->create_links();


        $this->load->view('fb_common/header');
        $this->load->view('fb_expense/home', $data);
        $this->load->view('fb_common/footer');
    }
    function add_new_exp(){
        
        $data=array(
            'expense_type_id'=>$this->input->post('expense_type_id', true),
            'branch_id'=>$this->session->userdata('branch_id'),
            'cost'=>$this->input->post('amount', true),
            'expdate'=> date('Y-m-d'),
        );
        if($this->db->insert('fb_expense', $data)){
            echo 'ok';
        }
        
    }

     function expense_type() {
        
        $data['results'] = $this->fb_expense_model->get_all_expense_type();
       
        $this->load->view('fb_common/header');
        $this->load->view('fb_expense/expense_type', $data);
        $this->load->view('fb_common/footer');
    }
    
    function add_new_exp_type(){
     if( $this->db->insert('fb_expense_type', array('name'=>$this->input->post('name', true))))
       echo 'ok';
    }
    
   
    function delete_expense_type($id){
       
        /*chek if not in use thi stype*/
        if(!$this->fb_expense_model->check_usage($id,'fb_expense','expense_type_id')){
            $this->db->where('id',$id);
            $this->db->delete('fb_expense_type');
            redirect('fb_expense/expense_type');
        }else{
            $this->session->set_userdata('message', 'Expense Type in Use ! Can not Delete');
            redirect('fb_expense/expense_type');
        }
    }
    

}

?>
