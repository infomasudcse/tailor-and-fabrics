<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Customer extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('fb_customer_model');
         
         if($this->session->userdata('person_id') == NULL)
         {
            redirect("/login","refresh");
         }
    }

    public function index() {
        ///here pagination library
        
        $config['base_url'] = site_url('/fb_customer/index');
        $config['total_rows'] = $this->fb_customer_model->count_all();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['results'] = $this->fb_customer_model->get_all( $config['per_page']);
        $data['links'] = $this->pagination->create_links();
       
        $this->load->view('fb_common/header');
        $this->load->view('fb_customer/home',$data);
        $this->load->view('fb_common/footer');
    }

    public function add_new() {
        $this->load->library('form_validation');
       $this->form_validation->set_error_delimiters('<div class="bg-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'Full Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|is_unique[people.phone_number]');
        

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            $person_data = array(
                'first_name' => $this->input->post('fname'),
                'last_name' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'phone_number' => $this->input->post('phone'),
                'address_1' => $this->input->post('address'),
                'address_2' => '',
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip' => $this->input->post('zip'),
                'country' => $this->input->post('country'),
                'comments' => $this->input->post('comment')
            );

            if ($this->db->insert('people', $person_data)) {
                $id = $this->db->insert_id();
                $customer = array(
                    'person_id' => $id,
                    'account_number' => '',
                    'branch_id' => $this->input->post('branch_id')
                );
                $this->db->insert('customers', $customer);
                echo 'ok';
            }
        }
    }

    public function search_customer(){
        
        $str = $this->input->post('str');
        $result = $this->fb_customer_model->search_cutomer($str);
       
        foreach($result->result() as $row){
            
          $this->db->where('person_id', $row->person_id);
           $this->db->where('deleted', 0);
            $sqll = $this->db->get('fb_card');
             if($sqll->num_rows() == 1){ 
               
                  $card =  substr($sqll->row()->card_number, 0,8).'.......';
                  }else{
                      $card = '<span class="btn btn-xs btn-info" onClick="return assign_card('.$row->person_id.')">assign card</span>';
              
                  }
                       
            
            
            if($this->session->userdata('branch_id') != 0){ 
                    echo ' <tr class="bg-success">
                                <td>'.$row->first_name . ' ' . $row->last_name.'</td>
                                <td>'.$row->comments.'</td>    
                                <td>'.$row->phone_number.'</td>
                                <td>'.$row->zip . ', ' . $row->city.'</td>
                                <td>'.$card.'</td>
<td>
                                <a class="btn btn-primary btn-xs" href="'.site_url().'/fb_new_order/index/'.$row->person_id.'" >Order</a>
                                    
                                </td>
                            </tr>';
            }else{
                 echo ' <tr class="bg-success">
                                <td>'.$row->first_name . ' ' . $row->last_name.'</td>
                                <td>'.$row->comments.'</td>    
                                <td>'.$row->phone_number.'</td>
                                <td>'.$row->zip . ', ' . $row->city.'</td>
                                 <td>'.$card.'</td>
<td> -- </td>
                            </tr>';
            }
        }
        
    }
    /***************enf of function***********************/
}

?>
