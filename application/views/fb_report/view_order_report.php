<div class="row">
<div class="col-md-12">
    <div class="row"><div class="col-sm-1 col-sm-offset-11">
            
             <span class="btn btn-sm btn-primary" onClick="popup_print();">Print</span>            
        
        </div></div>
    <div class="row" id="print_div">
        <div class="col-sm-12" style="background-color:#ff0000;">
            <!--header-->
            <p class="text-center"  style="margin-top:20px;"> 
                <span class="" style="font-size:25px;font-weight:bold;color:#ffffff;"> Company Name </span><br/></p>
            
        </div>
        
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">  Orders    </h3>  
                 <?php
                 
                 if($branch != ''){
                     $this->db->where('branch_id', $branch);
                 }else{
                      $this->db->where('branch_id', $this->sesssion->userdata('branch_id'));
                 }
                     $sql = $this->db->get('branch');
                     if($sql->num_rows() == 1){
                     echo '  <p>   '.$sql->row()->branch_name.' , '.$sql->row()->branch_address.' , '.$sql->row()->branch_phone.' </p>'; 
                     
                     } ?>
                    <p class="text-center">
                        <?php if ($type == 'sp') echo $from. ' - -  ' . $to;
                        else echo 'All'; ?>
                    </p>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">

                    <table class="table table-bordered" id="data_table" >
                <thead> 
                    <tr class="bg-primary">
                        <th>Order Date</th>
                        <th>Invoice</th>                       
                        <th>Items</th>
                        <th>Fabrics Cost</th>
                        <th>Tailor Cost</th>
                        <th>Total</th>
                        <th>Payments</th>
                        <th>Due</th>
                        <th>Branch</th>
                                             
                    </tr>
                </thead>
                <tbody>
                    <tr id="t_body"></tr>
                    <?php
                    if ($result != '') {
                        $tot_fb = 0.00;
                        $tot_tailor = 0.00;
                        $tot_due = 0.00;
                        $tot_payment = 0.00; 
                               foreach($result as $row){ ?>     
                               <tr>
                                   <td><?php echo $row->order_date; ?></td>
                                    <td><?php echo $row->invoice; ?></td>
                                     <td><?php echo $row->tot_item; ?></td>
                                      <td><?php echo $row->tot_fabrics; ?></td>
                                       <td><?php echo $row->tot_tailor_cost; ?></td>
                                        <td><?php echo $row->tot_fabrics + $row->tot_tailor_cost; ?></td>
                                         <td><?php echo $row->payment; ?></td>
                                          <td><?php echo $row->due; ?></td>
                                           <td>
                                               <?php $this->db->where('branch_id', $row->branch_id);
                                                $sq = $this->db->get('branch');
                                                if($sq->num_rows() == 1){ echo $sq->row()->branch_name; } ?>
                                           </td>
                                       
                                   
                               </tr>

                               <?php  
                                        $tot_fb += $row->tot_fabrics;
                                        $tot_tailor += $row->tot_tailor_cost;
                                        $tot_due += $row->due;
                                        $tot_payment += $row->payment;
                                                } 
                                    $totpay = $tot_fb + $tot_tailor;            
                                   echo '<td></td><td></td><td></td>
                                      <td>'.$tot_fb.'</td>
                                       <td>'.$tot_tailor.'</td>
                                        <td>'.$totpay.'</td>
                                         <td>'.$tot_payment.'</td>
                                          <td>'.$tot_due.'</td>
                                           <td></td>';             
                                                
                                                
                                                } else {
                                echo '<div class="alert alert-danger"> No Data to Diaplay !</div>';
                            } ?> 
                </tbody>
            </table> 

                </div><!-- /.box-body -->

                <div class="box-footer">
                
                    
                    <p class="text-right"> www.refineitbd.com</p>
                </div>

            </div>
        </div>
    </div>
</div>
</div>