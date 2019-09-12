<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Tailor_cost extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('fb_tailor_model');
        
         if($this->session->userdata('person_id') == NULL)
         {
            redirect("/login","refresh");
         }
    }

       function tailor_cost() {
        ///here pagination library

        $config['base_url'] = site_url('/fb_tailor_cost/tailor_cost');
        $config['total_rows'] = $this->fb_tailor_model->count_all();
        $config['per_page'] = 500;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);
        $data['results'] = $this->fb_tailor_model->get_all($config['per_page']);
        $data['links'] = $this->pagination->create_links();


        $this->load->view('fb_common/header');
        $this->load->view('fb_tailor_cost/home', $data);
        $this->load->view('fb_common/footer');
    }
   
    
    
    function add_new_cost(){
     if( $this->db->insert('fb_tailor_cost', array('name'=>$this->input->post('name', true), 'cost'=>$this->input->post('cost',true))))
       echo 'ok';
    }
    
   
    function delete_tailor($id){
       
        /*chek if not in use thi stype*/
        if(!$this->fb_tailor_model->check_usage($id,'fb_sell_tailor_cost','tailor_cost_id')){
            $this->db->where('id',$id);
            $this->db->delete('fb_tailor_cost');
            redirect('fb_tailor_cost/tailor_cost');
        }else{
            $this->session->set_userdata('message', 'Tailor Cost in Use ! Can not Delete');
            redirect('fb_tailor_cost/tailor_cost');
        }
    }
    

}

?>
