<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb_New_Order extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->model('fb_fabrics_model');
         
       $employee_id=$this->session->userdata('person_id');
        if($employee_id == NULL)
        {
               redirect("login","refresh");
     }
    }
    
    public function index($cid='')
    {
       $this->db->where('branch_id', $this->session->userdata('branch_id'));
       $sql = $this->db->get('branch');
       $select ='';
       $taicost = $this->db->get('fb_tailor_cost');
       if($taicost->num_rows() > 0){
           foreach($taicost->result() as $row){
               $select .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 
           }
       }
       if($cid != ''){
           $this->session->set_userdata('cus_id', $cid);
       }else{
           $cid = $this->session->userdata('cus_id');
       }
       $crow='';
       $this->db->where('person_id', $cid);
       $querytwo = $this->db->get('people');
       if($querytwo->num_rows() ==1){
           $crow = $querytwo->row();
       }
       $this->load->view('fb_common/header');
      $this->load->view('fb_new_order/home',array('branch'=>$sql->row(), 'select' =>$select, 'crow'=>$crow));
      $this->load->view('fb_common/footer');
    }
    
   
    function add_item_for_sell(){
        $item_model = $this->input->post('item');
       
        $totwill= 0.00;
        $crt_item = false;
        $crtrow = '';
        $row = $this->fb_fabrics_model->get_exists_to_sell($item_model, $this->session->userdata('branch_id'));
        if(!empty($row)){
            $totavail = $row->qty;
            /*check if there is item alredy added*/
             $cartdata = $this->cart->contents(); 
                 foreach ($cartdata as $crt) { 
                     if($crt['id'] == $row->fabrics_id){
                        $totwill +=  $crt['options']['fb_qty'] + $this->input->post('qty');
                        $crt_item = true;
                        $crtrow = $crt['rowid'];
                     }
                 }
                 
           
          
            if( $this->input->post('qty') < $totavail ){
               /*check if alreday exists in crt*/
                if($crt_item == true && $crtrow !=''){
                       if( $totwill < $totavail) {   

                                $dddata = array(
                                        'rowid' => $crtrow,
                                        'qty' => 0
                                    );

                                   $this->cart->update($dddata);
                                    $cdata = array(
                                                   'id'      => $row->fabrics_id,
                                                   'qty'     => 1,
                                                   'price'   => $row->unit_price,
                                                   'name'    => $row->name,
                                                   'options' => array('model' => $row->fabrics_model, 'fb_qty'=>$totwill)
                                                );  
                                if($this->cart->insert($cdata)){
                                    echo 'ok';
                                }
                       }else{
                            echo 'Same Model Product ! But Quantity is not Sufficient ! Try less qty !';
                       } 
                }else{
                    $data = array(
                           'id'      => $row->fabrics_id,
                           'qty'     => 1,
                           'price'   => $row->unit_price,
                           'name'    => $row->name,
                           'options' => array('model' => $row->fabrics_model, 'fb_qty'=>$this->input->post('qty'))
                        );  
                    if($this->cart->insert($data)){
                        echo 'ok';
                    }
                }
         }else{
             echo 'Quantity is not Sufficient !';
         }
            
    }else{
        echo 'Unable to select Fabrics !';
    }
    }
    
    
    
   public function update_cart($rowid){
      
        $row = $this->fb_fabrics_model->get_item_by_id($this->input->post('fb_id'));
        $totwill= $row->qty;
        
            
       if(  $totwill >= $this->input->post('qty')){
             $dddata = array(
                    'rowid' => $rowid,
                    'qty' => 0
                );
 
               $this->cart->update($dddata);
            
            $data = array(
                           'id'      => $row->fabrics_id,
                           'qty'     => 1,
                           'price'   => $row->unit_price,
                           'name'    => $row->name,
                           'options' => array('model' => $row->fabrics_model, 'fb_qty'=>$this->input->post('qty'))
                        );  
          $this->cart->insert($data);
           
          
       }else{
            $this->session->set_userdata('message','<span class="text-danger">Quantity Insufficient !</span>');
        }
        redirect("fb_new_order/");
    }
    
     public function remove_tocart($rowid) {
        
        $data = array(
            'rowid' => $rowid,
            'qty' => 0
        );

        $this->cart->update($data);
          $this->session->set_userdata('message','deleted !');
        redirect("fb_new_order/");
    }

    function add_tailor_cost(){
        
        $data['cost_id']=$this->input->post('tcost');
        $this->db->insert('fb_temp_tcost', $data);
        echo 'ok';
    }
    function remove_tailor_cost($id){
        $this->db->where('id',$id);
        $this->db->delete('fb_temp_tcost');
        redirect('fb_new_order/');
    }
    
    function process_new_order($payment = ''){
       
        $process = false;
        $customer_id = $this->input->post('customer_id', true);
        $mg='';
        if( $customer_id == ''){
          $customer_id = $this->fb_fabrics_model->is_available_customer_byphone($this->input->post('contact'));
            if($customer_id == ''){
            
                $customer = array(
                    'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),                
                        'phone_number' => $this->input->post('contact'),                
                        'comments' => $this->input->post('size')
                );
                 if ($this->db->insert('people', $customer)){
                        $customer_id = $this->db->insert_id();
                        $customer = array(
                            'person_id' => $customer_id,                    
                            'branch_id' => $this->session->userdata('branch_id')
                        );
                        $this->db->insert('customers', $customer);
                       $process = true;
                       $mg .='New customer Created ! ';
                      }else{
                          $this->session->set_userdata('message', 'Customer field Should not be empty !');
                          $process = false;
                    }
            
            }else{
                $this->session->set_userdata('message', 'This is an return customer ! Check data and retry. ');
                $gotopage = '/fb_new_order/index/'.$customer_id;
                redirect($gotopage);
                exit();
            }
        }else{
           $customer_id = $this->input->post('customer_id');
            $process = true;  
        }   
        /****************** now process with sell *******************/
        $invoice = 'knz'.time();
        $crt_tot = 0.00;
        $tot_pr = 0;
        /*duplicate sell prevent*/
        if(!$this->fb_fabrics_model->is_duplicate_invoice($invoice)){
        if($process == true){
            /*save crt data*/
                $cartdata = $this->cart->contents();
               
                foreach ($cartdata as $crt){
                   
                    $sell_data = array(
                        'fabrics_id'=>$crt['id'],
                        'fabrics_model'=>$crt['options']['model'],
                        'branch_id'=>$this->session->userdata('branch_id'),
                        'customer_id'=>$customer_id,
                        'invoice'=>$invoice,
                        'qty'=>$crt['options']['fb_qty'],
                        'price'=>$crt['price'],
                        'subtotal'=>$crt['options']['fb_qty'] * $crt['price']
                    );
                    $crt_tot += $crt['options']['fb_qty'] * $crt['price'];
                    $this->db->insert('fb_sell', $sell_data);
                    /*****update fabrics_row********/
                    $fbrow = $this->fb_fabrics_model->getProduct($crt['id']);
                    $remainqty = $fbrow->qty - $crt['options']['fb_qty'];
                    $fbrdata=array(
                        'qty'=> $remainqty
                    );
                    $this->db->where('fabrics_id', $fbrow->fabrics_id);
                    $this->db->update('fabrics',$fbrdata);
                    
                   $tot_pr++;
                }
          /**save tailor cost data**/      
                $tailor_total = 0;
                $tquery= $this->db->get('fb_temp_tcost');
                if($tquery->num_rows() > 0 ){
                    foreach($tquery->result() as $tcrow){
                       
                        $tailor_cost = array(
                            'invoice'=>$invoice,
                            'tailor_cost_id'=>$tcrow->cost_id
                        );
                        $this->db->insert('fb_sell_tailor_cost', $tailor_cost);
                       $this->db->where('id', $tcrow->cost_id);
                        $querytwo = $this->db->get('fb_tailor_cost');
                        $ccrow = $querytwo->row();
                        $tailor_total += $ccrow->cost; 
                        $tot_pr++;
                    }
                }
           /**save some data for quick view**/ 
                  $tot_invoice = $crt_tot + $tailor_total;
                  
            $quick_sell = array(               
               
                'branch_id'=>$this->session->userdata('branch_id'),                
                'customer_id'=>$customer_id,
                 'payment'=>$payment ,                
                'del_date'=>$this->input->post('dldate'),
               'order_date'=>date('Y-m-d'),
                'invoice'=>$invoice,
                'tot_item'=>$tot_pr,
                're_item'=>$tot_pr,
                 'tot_fabrics'=>$crt_tot,
                'tot_tailor_cost'=>$tailor_total,
                'tot_order'=> $tot_invoice 
            );  
          
            /*here we go with card. if card then make discount and save dis info */
            if($this->session->userdata('card') !='' && $this->session->userdata('carddisq') !=''){
                /**less payment*/
                $disqc = $this->session->userdata('carddisq');
                if($disqc > 0){
                    $disq_amount = ($disqc * $tot_invoice )/100;
                    $quick_sell['disq'] = $disq_amount;
                    $tot_invoice = $tot_invoice - $disq_amount;
                    $quick_sell['tot_to_pay'] = $tot_invoice;
                }
            }else{
                $quick_sell['disq'] = 0;
                $quick_sell['tot_to_pay'] = $tot_invoice ;
            }
            
            if($payment == $tot_invoice){
               $quick_sell['due']= 0;
               $quick_sell['status']= 1;
                       
            }
            elseif ($payment < $tot_invoice) {
               $quick_sell['due']= $tot_invoice - $payment;
               $quick_sell['status']= 0;  
            }
            $this->db->insert('fb_order', $quick_sell);
            /*track payment*/
             $paydata = array(
                    'invoice'=>$invoice,
                    'payment'=>$payment,
                    'item_del'=>0,
                    'paydate'=>date('Y-m-d'),
                    'customer_id'=>$customer_id,
                    'branch_id'=>$this->session->userdata('branch_id')
                );
                $this->db->insert('fb_payment', $paydata);
             /**data save success*/
            /*generate print_view*/
             //create pdf 
                
                $bill_file = 'invoices/' . $invoice . '.pdf';
                $result = $this->load->view('fb_new_order/invoice_view', $quick_sell, TRUE);
              //  ob_end_clean();
                $this->load->library('mpdf');
                $mpdf = new mPDF('utf-8', 'A4');
                $mpdf->debug = true;
                $mpdf->WriteHTML($result);
                $mpdf->Output($bill_file, 'F');
               /*  $mpdf->Output();*/
            /*function to later print*/
            
            /*delete data from cart and temp_tcost and sesssion if any */
             $this->load->view('fb_common/header');   
            $this->load->view('fb_new_order/invoice_view', $quick_sell);
             $this->load->view('fb_common/footer');
            $this->cart->destroy();/*empty cart*/
            $this->db->truncate('fb_temp_tcost');/*empty temp tailor cost*/
           $this->session->unset_userdata('cus_id');/*remove from session customer id*/
           $this->session->unset_userdata('card');/*remove from session card*/
           $this->session->unset_userdata('cardtype');/*remove from session type*/
           $this->session->unset_userdata('carddisq');/*remove from session disq*/
           /* $gotopage = '/fb_new_order/complete_order/'.$invoice;
            redirect($gotopage);/*/
            }else{
                $this->session->set_userdata('message', 'Can not sell same invoice !');
                $gotopagetwo = '/fb_fabrics/all_invoices';
                redirect($gotopagetwo);
                exit();
            } 
        }else{
            $this->session->set_userdata('message', 'Somethig wrong with Customer data ! Please Check !');
            $gotopagethree = '/fb_customer/';
                redirect($gotopagethree);
                exit();
        }
        /****process end***/
    
    } 
   
    function add_disq_card(){
        if($this->input->post('cardn', true) != ''){
            $cardnum = $this->input->post('cardn', true);
            $card_info = $this->fb_fabrics_model->get_card_info($cardnum);
            if($card_info != ''){
                $this->session->set_userdata(array('card'=>$card_info->card_number, 'cardtype'=>$card_info->type, 'carddisq'=> $card_info->disq));
                echo 'ok';
            }
        }
    }
    function dissmiss_order(){
        $this->cart->destroy();/*empty cart*/
            $this->db->truncate('fb_temp_tcost');/*empty temp tailor cost*/
           $this->session->unset_userdata('cus_id');/*remove from session customer id*/
           echo 'ok';
    }
    
   
    
    
    
    
    
    
    
}

?>
