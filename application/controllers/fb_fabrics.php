<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Fabrics extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->model('fb_fabrics_model');

        if ($this->session->userdata('person_id') == NULL) {
            redirect("/login", "refresh");
        }
    }

    function index() {
        ///here pagination library

        $config['base_url'] = site_url('/fb_fabrics/index');
        $config['total_rows'] = $this->fb_fabrics_model->count_all();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        if ($this->session->userdata('branch_id') != 0) {
            $data['results'] = '';
            $data['links'] = '';
        } else {
            $data['results'] = $this->fb_fabrics_model->get_all($config['per_page']);
            $data['links'] = $this->pagination->create_links();
        }

        $this->load->view('fb_common/header');

        $this->load->view('fb_fabrics/home', $data);

        $this->load->view('fb_common/footer');
    }

    public function add_new() {

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="bg-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'Fabrics Name', 'required');
        $this->form_validation->set_rules('model', 'Model', 'required');
        $this->form_validation->set_rules('qty', 'Quantity', 'required');
        $this->form_validation->set_rules('cost_price', 'Cost Price', 'required');
        $this->form_validation->set_rules('unit_price', 'Unit price', 'required');



        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            $p_data = array(
                'fabrics_model' => $this->input->post('model'),
                'name' => $this->input->post('fname'),
                'qty' => $this->input->post('qty'),
                'cost_price' => $this->input->post('cost_price'),
                'unit_price' => $this->input->post('unit_price'),
                'deleted' => 0,
                'branch_id' => 1
            );

            if ($this->db->insert('fabrics', $p_data)) {
                echo 'ok';
            } else {
                echo '';
            }
        }
    }

    public function search_fabrics() {

        $str = $this->input->post('str');
        $result = $this->fb_fabrics_model->search_fabric($str);

        foreach ($result->result() as $row) {
            $this->db->where('branch_id', $row->branch_id);
            $sql = $this->db->get('branch');
            $banch = ($sql->num_rows() == 1) ? $sql->row()->branch_name : 'not found';
            if($this->session->userdata('branch_id') != 0){
                $cost='--';
            }else{
                $cost = $row->cost_price;
            }
            
            echo '<tr class="bg-success">';
            echo '<td> <input type="checkbox" name="model" value="'.$row->fabrics_id.'"/> ' . $row->fabrics_model . '</td>
                        <td>' . $row->name . '</td>
                        <td>' . $cost. '</td>
                        <td>' . $row->unit_price . '</td>
                        <td>' . $row->qty . '</td>
                        <td>' . $row->unit . '</td>
                        <td>' . $banch . '</td>';
            if ($this->session->userdata('branch_id') != 0) {
                echo '<td> -- -- -- </td>';
            } else {
                
                echo '<td>';
                if($row->branch_id == 1){
                  echo ' <span class="btn btn-xs btn-warning edit_fabric" onClick="return editfb(' . $row->fabrics_id . ');" >Edit</span> ';
                }
                echo ' <span class="btn btn-xs btn-primary tans_fabric" onClick="return transferfb(' . $row->fabrics_id . ');">Transfer</span>
                      <span class="btn btn-xs btn-default delete_fabric" onClick="return deletefb(' . $row->fabrics_id . ');">Del</span>
                        </td> ';
            }
            echo '</tr>';
        }
    }

    function edit_fabric() {
        $id = $this->input->post('product_id');

        $data['product'] = $this->fb_fabrics_model->getProduct($id);
        echo $this->load->view('fb_fabrics/edit_form', $data, true);
    }

    function update_fabrics() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="bg-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'Fabrics Name', 'required');
        $this->form_validation->set_rules('model', 'Model', 'required');
        $this->form_validation->set_rules('qty', 'Quantity', 'required');
        $this->form_validation->set_rules('cost_price', 'Cost Price', 'required');
        $this->form_validation->set_rules('unit_price', 'Unit price', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {

            $data = array(
                'fabrics_model' => $this->input->post('model'),
                'name' => $this->input->post('fname'),
                'qty' => $this->input->post('qty'),
                'cost_price' => $this->input->post('cost_price'),
                'unit_price' => $this->input->post('unit_price')
            );

            if ($this->fb_fabrics_model->update_fb('fabrics', $data, $this->input->post('id'))) {
                /*bulk update for this model...*/               
                if($this->input->post('model') !=''){
                    $up_info = array(
                    'name'=>$this->input->post('fname'),
                    'cost_price'=>$this->input->post('cost_price'),
                    'unit_price'=>$this->input->post('unit_price')
                );
                    $this->fb_fabrics_model->update_fb_bulk($up_info, $this->input->post('model'));
                }
                echo 'ok';
            } else {
                echo 'Try Again !';
            }
        }
    }

    function delete_fabric() {

        $id = $this->input->post('product_id');
        /* check id sold */
        if (!$this->fb_fabrics_model->is_sold($id)) {
            if ($this->fb_fabrics_model->deleteProduct($id)) {
                echo 'done';
            }
        } else {
            echo 'Item Can not be deleted because of Sell ! ';
        }
    }

    
    
    
    
    
    
    function transfer_fabric() {
        $id = $this->input->post('product_id');
        $data['product'] = $this->fb_fabrics_model->getProduct($id);
        echo $this->load->view('fb_fabrics/transfer_form', $data, true);
    }

    function transfer_to_branch() {
        $msg = false;
        $id = $this->input->post('product_id');
        $product_info = $this->fb_fabrics_model->getProduct($id);
        if ($product_info->qty >= $this->input->post('qty')) {
            /* check if there exists same product */
            $exists_pr = $this->fb_fabrics_model->get_exists($product_info->fabrics_model, $this->input->post('branch_id'));

            if (!empty($exists_pr)) {
                /* product exixts at destination branch */
                $ex_qty = $exists_pr->qty;
                $up_exists_pr = array(
                    'qty' => $this->input->post('qty') + $ex_qty
                );
                if ($this->fb_fabrics_model->update_fb('fabrics', $up_exists_pr, $exists_pr->fabrics_id)) {
                    $msg = true;
                }
            } else {
                /* product non exists to destination branch */
                $new_product = array(
                    'fabrics_model' => $product_info->fabrics_model,
                    'name' => $product_info->name,
                    'qty' => $this->input->post('qty'),
                    'cost_price' => $product_info->cost_price,
                    'unit_price' => $product_info->unit_price,
                    'deleted' => 0,
                    'branch_id' => $this->input->post('branch_id')
                );

                if ($this->db->insert('fabrics', $new_product)) {
                    $msg = true;
                }
            }
            if ($msg == true) {
                $remain_qty = $product_info->qty - $this->input->post('qty');

                $up_data = array(
                    'qty' => $remain_qty
                );
                if ($this->fb_fabrics_model->update_fb('fabrics', $up_data, $id)) {
                    /* transfer success */
                    /* save trans info for report */
                    $trans_info = array(
                        'from_branch_id' => $this->input->post('current_branch'),
                        'to_branch_id' => $this->input->post('branch_id'),
                        'qty' => $this->input->post('qty'),
                        'fabrics_model' => $product_info->fabrics_model,
                        'trans_date' => date('Y-m-d')
                    );
                    $this->db->insert('fabrics_transfer', $trans_info);
                    echo 'ok';
                }
            }
        } else {
            echo 'Check Quantity to transfer ! ';
        }
    }

    function all_invoices() {
        /* view of all invoice */
        $config['base_url'] = site_url('/fb_fabrics/all_invoices');
        $config['total_rows'] = $this->fb_fabrics_model->count_all_invoice();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['results'] = $this->fb_fabrics_model->get_all_invoice($config['per_page']);
        $data['links'] = $this->pagination->create_links();
        $this->load->view('fb_common/header');
        $this->load->view('fb_fabrics/invoices', $data);
        $this->load->view('fb_common/footer');
    }

    function admin_invoices() {
        /* view of all invoice */
        $config['base_url'] = site_url('/fb_fabrics/all_invoices');
        $config['total_rows'] = $this->fb_fabrics_model->count_all_invoice_admin();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['results'] = $this->fb_fabrics_model->get_all_invoice_admin($config['per_page']);
        $data['links'] = $this->pagination->create_links();
        $this->load->view('fb_common/header');
        $this->load->view('fb_fabrics/admin_invoices_view', $data);
        $this->load->view('fb_common/footer');
    }

    function search_invoice_admin() {

        $str = $this->input->post('str');
        $result = $this->fb_fabrics_model->search_invoice_admin($str);
         if(!empty($result)){
        foreach ($result->result() as $row) {

            $this->db->where('branch_id', $row->branch_id);
            $sql2 = $this->db->get('branch');
            if ($sql2->num_rows() == 1) {
                $branch = $sql2->row()->branch_name;
            } else {
                $branch = 'Undefine';
            }

            $this->db->where('person_id', $row->customer_id);
            $sql = $this->db->get('people');
            if ($sql->num_rows() == 1) {
                $customer = $sql->row()->first_name . " " . $sql->row()->last_name."<br/>".$sql->row()->phone_number;
            } else {
                $customer = 'not found';
            }
            $link = base_url() . 'invoices/' . $row->invoice . '.pdf';

            if($row->status == 0){$sts = 'Due : '.$row->due.'/-';}else{ $sts= "full paid";}

            if ($this->session->userdata('branch_id') != 0) {
                if ($row->status == 1) {
                    $action = '<a class="btn btn-xs btn-warning" href="' . base_url() . 'invoices/' . $row->receipt . '.pdf' . '" target="_blank">Receipt</a>';
                } else {
                    $action = '<span class="btn btn-xs btn-success" onClick="return delivery("' . $row->invoice . '");">Add payment / Delivery</span>';
                }
            } else {
                if ($row->status == 1) {
                    $action = '<a class="btn btn-xs btn-warning" href="' . base_url() . 'invoices/' . $row->receipt . '.pdf' . '" target="_blank">Receipt</a>';
                } else {
                    $action = '';
                }
            }
            echo ' <tr class="bg-success">
                        <td>' . $row->invoice . '</td>
                        <td>' . $row->order_date . '</td>
                        <td>' . $row->del_date . '</td>
                        <td>' . $customer . '</td>
                        <td>' . $sts . '</td>
                        <td>'.$branch.'</td>
                        <td>
                            <a href="' . $link . '" class="btn btn-success btn-xs" target="_blank">Download</a>
                            ' . $action . '    
                            
                        </td>
                    </tr>';
        }
         }else{
              echo '<tr><td colspan="7"><div class="alert alert-danger">Nothing to Display ! </div></td></td>';
        }
    }

    function search_invoice() {

        $str = $this->input->post('str');
        $result = $this->fb_fabrics_model->search_invoice($str);
        if(!empty($result)){
            
           echo  $this->load->view('fb_fabrics/invoice_search_result', array('result'=>$result), true);
        
        }else{
            echo '<tr><td colspan="7"><div class="alert alert-danger">Nothing to Display ! </div></td></td>';
        }
    }

    function order_delivery() {

        $data['row'] = $this->fb_fabrics_model->getinvoicedata($this->input->post('invoice'));
        echo $this->load->view('fb_fabrics/delivery_form', $data, true);
    }

    function make_delivery() {

        $invoice_row = $this->fb_fabrics_model->getinvoic($this->input->post('invoice'), $this->input->post('id'));
        if ($invoice_row->due == $this->input->post('balance', true)) {
            $final_inv = 'knz' . time();
            $invoicedata = array(
                'due' => 0,
                'payment' => $invoice_row->payment + $this->input->post('balance', true),
                'status' => 1,
                're_item' => 0,
                'receipt' => $final_inv
            );
            $this->db->where('id', $invoice_row->id);
            if ($this->db->update('fb_order', $invoicedata)) {
                /* delivery track*/
                $deldata =array(
                     'invoice' => $invoice_row->invoice,
                        'delivery_date'=>date('Y-m-d')                   
                );
                  $this->db->insert('fb_delivery', $deldata);
                /* track payments */
                $paydata = array(
                    'invoice' => $invoice_row->invoice,
                    'payment' => $this->input->post('balance', true),
                    'item_del' => $invoice_row->re_item,
                    'paydate' => date('Y-m-d'),
                    'customer_id' => $invoice_row->customer_id,
                    'branch_id' => $invoice_row->branch_id
                );
                $this->db->insert('fb_payment', $paydata);
                /*get updated invoice data*/
                $invrow = $this->fb_fabrics_model->getinvoicedata($invoice_row->invoice);
                $bill_file = 'invoices/' . $final_inv . '.pdf';
                $result = $this->load->view('fb_fabrics/final_receipt', $invrow, TRUE);
                //  ob_end_clean();
                $this->load->library('mpdf');
                $mpdf = new mPDF('utf-8', 'A4');
                $mpdf->debug = true;
                $mpdf->WriteHTML($result);
                $mpdf->Output($bill_file, 'F');
                /* function to later print */

                /* delete data from cart and temp_tcost and sesssion if any */
                /* $this->load->view('fb_common/header');   
                  $this->load->view('fb_fabrics/final_receipt', $invoice_row);
                  $this->load->view('fb_common/footer');
                 */
                echo 'ok';
            } else {
                echo 'Wrong invoice !';
            }
        } else {
            echo 'Wrong Invoice !';
        }
    }

    function add_payment() {
        $invoice_row = $this->fb_fabrics_model->getinvoic($this->input->post('invoice'), $this->input->post('id'));
        if ($invoice_row->due == $this->input->post('balance', true)) {
            $final_inv = 'knz' . time();
            $invoicedata = array(
                'due' => 0,
                'payment' => $invoice_row->payment + $this->input->post('balance', true),
                'status' => 1,
                're_item' => 0,
                'receipt' => $final_inv
            );
            $this->db->where('id', $invoice_row->id);
            if ($this->db->update('fb_order', $invoicedata)) {
               /* delivery track*/
                $deldata =array(
                     'invoice' => $invoice_row->invoice,
                        'delivery_date'=>date('Y-m-d')                   
                );
                  $this->db->insert('fb_delivery', $deldata);
                /* save payment */
                $paydata = array(
                    'invoice' => $invoice_row->invoice,
                    'payment' => $this->input->post('balance', true),
                    'item_del' => $this->input->post('delv_item', true),
                    'paydate' => date('Y-m-d'),
                    'customer_id' => $invoice_row->customer_id,
                    'branch_id' => $invoice_row->branch_id
                );
                $this->db->insert('fb_payment', $paydata);


                $bill_file = 'invoices/' . $final_inv . '.pdf';
                $result = $this->load->view('fb_fabrics/final_receipt', $invoice_row, TRUE);
                //  ob_end_clean();
                $this->load->library('mpdf');
                $mpdf = new mPDF('utf-8', 'A4');
                $mpdf->debug = true;
                $mpdf->WriteHTML($result);
                $mpdf->Output($bill_file, 'F');

                echo 'ok';
            }
        } else {
            if($invoice_row->re_item < $this->input->post('delv_item', true)){
                echo 'Can not Delivery this item !';
                exit();
            }else if($invoice_row->re_item == $this->input->post('delv_item', true)){
                echo 'Can not Deliver without Full Payment !';
                exit();
            }else{
                $invoicedata = array(
                    'due' => $invoice_row->due - $this->input->post('balance', true),
                    'payment' => $invoice_row->payment + $this->input->post('balance', true),
                    're_item' => $invoice_row->re_item - $this->input->post('delv_item', true)
                );
                $this->db->where('id', $invoice_row->id);
                if ($this->db->update('fb_order', $invoicedata)) {
                    /* track payment */
                    $paydata = array(
                        'invoice' => $invoice_row->invoice,
                        'payment' => $this->input->post('balance', true),
                        'item_del' => $this->input->post('delv_item', true),
                        'paydate' => date('Y-m-d'),
                        'customer_id' => $invoice_row->customer_id,
                        'branch_id' => $invoice_row->branch_id
                    );
                    $this->db->insert('fb_payment', $paydata);
                    echo 'ok';
                }
            }
        }
    }

    function input_generate_barcodes($item_ids){
        $data=array();
       $data['ids']= $item_ids;
         echo $this->load->view('fb_fabrics/barcode_form', $data, true);
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
         $item_info = $this->fb_fabrics_model->getProduct($item_id);
           
            $results[] = array('name' => $item_info->name,
                'item_number' => $item_info->fabrics_model,           
                'price' => $item_info->unit_price,
                'id' => $item_id
                    );
            $quantity = $qty;
            $barcode = $item_info->fabrics_model;
            for ($j = 1; $j <= $quantity; $j++) {
                
             $result[$j] = '<barcode code="' . $barcode . '" type="C93"  />';
          
            }
           
        $data['items'] = $result;
        $data['itms'] = $results;
        $data['qty'] = $quantity;
       
       
        $str = $this->load->view('fb_fabrics/barcode_print', $data, true);
        $this->mpdf->WriteHTML($str);
        $this->mpdf->Output();
    }
    
    
    
    
    
    /*     * *************enf of function********************** */
}

?>
