<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Member extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->load->model('fb_member_model');
            $this->load->helper('url');
            		$this->load->library('upload');		
        $person_id = $this->session->userdata('person_id');
        if ($person_id == NULL) {
            redirect("login", "refresh");
        }
    }

    function index() {
        if($this->session->userdata('branch_id') != 0){
            redirect('/fb_home/index');
            exit();
        }
        
        $config['base_url'] = site_url('/fb_customer/index');
        $config['total_rows'] = $this->fb_member_model->count_all();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['results'] = $this->fb_member_model->get_all($config['per_page']);
        $data['links'] = $this->pagination->create_links();


        $this->load->view('fb_common/header');       
         $this->load->view('fb_member/all_member', $data);        
        $this->load->view('fb_common/footer');
    }

    function checkCode($str){
     	if ( !$this->fb_member_model->is_valid_code($str))
		{
			$this->form_validation->set_message('checkCode', 'The %s is not valid for this Branch !');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
    
    
    
    
      function branch_member() {
          $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="bg-danger">', '</div>');
        $this->form_validation->set_rules('mm_code', 'Member Code', 'required|callback_checkCode');
          if ($this->form_validation->run() == FALSE) {        
              /*member*/
            $config['base_url'] = site_url('/fb_customer/branch_member');
            $config['total_rows'] = $this->fb_member_model->count_all_bm();
            $config['per_page'] = '20';
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $data['results'] = $this->fb_member_model->get_all_bm($config['per_page']);
            $data['links'] = $this->pagination->create_links();
            $data['error'] =  validation_errors();
            /*attendance*/
           $data['attendance'] = $this->fb_member_model->get_day_attendance();
            
            $this->load->view('fb_common/header');       
            $this->load->view('fb_member/branch_member', $data);       
            $this->load->view('fb_common/footer');
          }else{
              
              $member_row = $this->fb_member_model->get_member_info($this->input->post('mm_code'));
              $att_data = array(
                  'branch_id'=>$member_row->branch_id,
                  'member_id'=>$member_row->id,
                  'day_out'=> date('Y-m-d').' 20-00-00',
                  'day'=>date('Y-m-d')
              );
              $this->db->insert('fb_member_attendance', $att_data);
              redirect('/fb_member/branch_member');
          }
        
        
    }
    
    function add_new() {
        
        $config['upload_path'] = './uploads/members';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '500';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
                $config['file_name']    = time();
	$this->upload->initialize($config);

		     
        
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="bg-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('salary', 'Salary', 'required|numeric');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|is_unique[fb_branchmember.contact]');


        if ($this->form_validation->run() == FALSE || ! $this->upload->do_upload()) {
            $str =  validation_errors();
            $error =  $this->upload->display_errors();
            echo $str.$error;
            return;
        } else {
            $upload_data =  $this->upload->data();
            $person_data = array(
                'full_name' => $this->input->post('fname'),
                'contact' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'salary' => $this->input->post('salary'),
                'branch_id' => $this->input->post('branch_id'),
                'comments' => $this->input->post('comments'),
                'status' => 1,
                'code'=> 'fb'.time(),
                'photo'=>   $upload_data['file_name']
            );

            if ($this->db->insert('fb_branchmember', $person_data)) {

                echo 'ok';
            }
        }
    }

    function search_member() {
        $str = $this->input->post('str');
        $result = $this->fb_member_model->search_member($str);

        foreach ($result->result() as $row) {
            $this->db->where('branch_id', $row->branch_id);
            $sql = $this->db->get('branch');
            if ($sql->num_rows() == 1) {
                $branch = $sql->row()->branch_name;
            } else {
                $branch = 'Undefine';
            }
             if($row->photo != ''){$imgg =  '<img src="'.base_url().'uploads/members/'.$row->photo.'" width="70">';}else{ $imgg =  " -- ";} 
            echo "<tr class='bg-success'>
                                <td><input type='checkbox' name='model' value='" . $row->id . "'/>' ".$row->code."</td>

                        <td> <span title='".$row->comments."'>".$row->full_name."</span></td>
                        <td>".$imgg."</td>
                                <td>" . $row->address . "</td>
                                 <td>" . $row->contact . "</td>
                                 <td>" . $row->salary . "</td>  
                                <td>" . $branch . "</td>    
                             
                               
                                <td>
                                <a class='btn btn-default' onClick='return loadEditModal(".$row->id.");'>  <span class='glyphicon glyphicon-edit'></span></a>
                            <a class='btn btn-default' href='".site_url()."/fb_member/delete_member/".$row->id."' onClick='return checkAction();'><span class='glyphicon glyphicon-remove'></span></a>
                        
                                    
                                </td>
                            </tr>";
        }
    }

    function delete_member($id = '') {
        $data = array('status' => 0);
        $this->db->where('id', $id);
        $this->db->update('fb_branchmember', $data);
        redirect('/fb_member/index');
    }

    function edit_member() {
        $id = $this->input->post('id', true);

        $data['member'] = $this->fb_member_model->getMember($id);
        echo $this->load->view('fb_member/edit_form', $data, true);
    }

    function update_mm() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="bg-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'Full Name', 'required');
        $this->form_validation->set_rules('salary', 'Salary', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            return;
        } else {

            $person_data = array(
                'full_name' => $this->input->post('fname'),
                'contact' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'salary' => $this->input->post('salary'),
                'branch_id' => $this->input->post('branch_id'),
                'comments' => $this->input->post('comments'),
                'status' => 1,
            );
            $this->db->where('contact', $this->input->post('phone', true));

            $sql = $this->db->get('fb_branchmember');
            $cex = $sql->num_rows();
            if ($cex == 1) {
                if ($sql->row()->id == $this->input->post('id', true)) {

                    $this->db->where('id', $this->input->post('id', true));
                    if ($this->db->update('fb_branchmember', $person_data)) {

                        echo 'ok';
                        return;
                    }
                }
                echo 'Phone number alreday exists !';
                return;
            } elseif ($cex > 1) {
                echo 'Phone number alreday exists !';
                return;
            } elseif ($cex < 1) {
                $this->db->where('id', $this->input->post('id', true));
                if ($this->db->update('fb_branchmember', $person_data)) {

                    echo 'ok';
                    return;
                }
            }
        }
    }

   

    
    function member_in_out(){
        
        print_r($_POST);
        
        
        
        
    }
    
      function input_generate_barcodes($item_ids){
        $data=array();
       $data['ids']= $item_ids;
         echo $this->load->view('fb_member/barcode_form', $data, true);
    }
 
    function generate_barcode_specific_item(){
       
        $item_id = $this->input->post('model');
        $qty = $this->input->post('qty');
          $this->load->library('mpdf/mpdf');
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $result = array();
        $results = array();
        $i = 0;    
               
         $item_info = $this->fb_member_model->getMember($item_id);
         $branch = $this->fb_member_model->get_branch_name($item_info->branch_id);
            $results[] = array(
                'photo' => base_url().'uploads/members/'.$item_info->photo,
                'name' => $item_info->full_name,
                'item_number' => $item_info->code,           
                'branch' => $branch->branch_name,
                'id' => $item_id
                    );
        
            $barcode = $item_info->code;
            for ($j = 1; $j <= $qty; $j++) {
                
             $result[$j] = '<barcode code="' . $barcode . '" type="C93"  />';
          
            }
           
        $data['items'] = $result;
        $data['itms'] = $results;
        $data['qty'] = $quantity;
      
        $str = $this->load->view('fb_member/barcode_print', $data, true);
        
        $this->mpdf->WriteHTML($str);
        $this->mpdf->Output();
    }
    
    function search_branch_member(){
       $str ='';
       $member =  $this->fb_member_model->get_member($this->input->post('str', true));
        if(!empty($member)){
            foreach($member as $row){
                $str .= '<option value="'.$row->id.'">'.$row->full_name.'</option>';
            }
        }
        echo $str;
        
    }
    
    
    /* end of function */
}

?>