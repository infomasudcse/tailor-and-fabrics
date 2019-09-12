<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Fb_Card extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
                  if($this->session->userdata('person_id') == NULL)
         {
            redirect("/login","refresh");
         }
                $this->load->model('fb_card_model');
	}
	
    
   public function index() {
        ///here pagination library
        
        $config['base_url'] = site_url('/fb_card/index');
        $config['total_rows'] = $this->fb_card_model->count_all();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['results'] = $this->fb_card_model->get_all( $config['per_page']);
        $data['links'] = $this->pagination->create_links();
       
        $this->load->view('fb_common/header');
        $this->load->view('fb_card/home',$data);
        $this->load->view('fb_common/footer');
    }
      
      function add_new(){
          $type = $this->input->post('type', true);
          $data = array();
        
          switch($type){
              case 'silver':
                     $data['card_number']= 'knzcs'.time();    
                  $data['type']= 'silver';
                        $data['disq']= 5 ;
                  break;
              case 'gold':
                    $data['card_number']= 'knzcg'.time();
                    $data['type']= 'gold';
                        $data['disq']= 10 ;
                  break;
              case 'diamond':
                    $data['card_number']= 'knzcd'.time();
                    $data['type']= 'diamond';
                        $data['disq']= 15 ;
                  break;             
              
          }
          $data['expire']= date('Y-m-d',strtotime($this->input->post('exp', true)));
          $data['creation']= date('Y-m-d');
           $data['status']= 0; 
          if($this->fb_card_model->create_new($data)){
              echo 'ok';
              return;
          }else{
              echo 'Can not Create !';
              return;
          }
          
          
      }  
     
      function delete_card(){
            if($this->fb_card_model->delete_card($this->input->post('card_id', true))){
                echo 'ok';
                return;
                
            }else{
                echo 'can not delete ! ';
                return;
            }
          
          
      }
      
      function search_card(){
          $obj = $this->fb_card_model->search_customer_card($this->input->post('str', true)); 
          if($obj->num_rows() > 0){
              foreach($obj->result() as $row){
               $sts = ($row->status == 1)? '<span class="label label-success">Active</span>': '<span class="label label-warning">Unactive</span>';
                  if($this->session->userdata('branch_id') == 0){
                           $link = '<span class="glyphicon glyphicon-remove" style="cursor:pointer;" onClick="return delete_card('.$row->id.')"></span>';
                  }else{
                      $link = '';
                  } 
                          
               
               echo '<tr class="bg-success">
                        <td>'.$row->card_number.'</td>
                        <td>'.$row->type.'</td>
                        <td>'.$row->disq.' % </td>
                        <td>'.$sts.'</td>
                        <td>'.$link.' </td>
                      
                    </tr>';
              }
          }
          
      }
      
   function card_assign_form(){
       if($this->input->post('customer_id', true) == ''){
           echo 'Form not loaded ! try again. !';
       }else{
       $form =  ' <div class="form-group divcardnum" >
                            <label for="fname" class="col-sm-3 control-label">Card Number</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="crdnum" class="form-control" id="cardnum" placeholder="knzc....." focus>
                            </div> 


                        </div>
                        <input type="hidden" name="cust" value="'.$this->input->post('customer_id', true).'">
                            <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" onClick="return valid_assign_card();">Assign Card</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <div class="col-sm-12 crdresult">

                            </div>  
                        </div>';
       
       echo $form;
       }
       
       
       
   }
      function card_assign(){
          $result = $this->fb_card_model->assign_card($this->input->post('crdnum', true), $this->input->post('cust', true));
            echo $result; 
          
      }
      
      
      
      /****/
        
}
?>