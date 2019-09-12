<div class="row">
<div class="col-md-12">
    <div class="row"><div class="col-sm-1 col-sm-offset-11">
            
             <span class="btn btn-sm btn-primary" onClick="popup_print();">Print</span>            
        
        </div></div>
    <div class="row" id="print_div">
        <div class="col-sm-12" style="background-color:#ff0000;">
            <!--header-->
            <p class="text-center"  style="margin-top:20px;"> 
                <span class="" style="font-size:25px;font-weight:bold;color:#ffffff;"> Company Name </span><br/>
            </p>            
            
        </div>
         <div class="col-sm-12">
            <!--header-->
            <p class="text-center"  style="margin-top:20px;border-bottom:1px solid red;"> 
              <?php if($type == 'all'){
                  echo '<span class="" style="font-size:18px;font-weight:bold;color:#0000FF;">Summary fo '.$type.'<span>';
              }else{?>
                  <span class="" style="font-size:18px;font-weight:bold;color:#0000FF;"> Summary of <?php echo $datee; ?> </span><br/>
           
             <?php } ?>
                
            </p>            
            
        </div>
        
        <?php 
            if($branch != ''){
        ?>
            <div class="col-sm-12">
                <!--header-->
                <p class="text-center"  style="margin-top:20px;border-bottom:1px solid green;"> 
                    <span class="" style="font-size:18px;font-weight:bold;color:#0000FF;">  
                       <?php  $this->db->where('branch_id', $branch);
                            $sql = $this->db->get('branch');
                            echo ($sql->num_rows() == 1) ? $sql->row()->branch_name : 'not found';
                            ?>
                    </span><br/>
                </p>            

            </div>
            <?php } ?>
        
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4>Orders</h4>
                            <table class="table">
                                <thead>
                                    <tr class="bg-success">
                                        <th>Invoice</th>
                                        <th>Items</th>
                                        <th>Delivery</th>
                                        <th>T.Cost</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if($orders!=''){ 
                                    foreach($orders as $row){ ?>
                                      <tr>
                                          <td><?php echo $row->invoice; ?></td>
                                           <td><?php echo $row->tot_item; ?></td>
                                            <td><?php echo $row->del_date; ?></td>
                                             <td><?php echo $row->tot_fabrics + $row->tot_tailor_cost; ?></td>
                                             
                                      </tr>
                                <?php } }  ?>
                                </tbody>
                            </table>
                        </div>
                         <div class="col-sm-4">
                             <h4>Payments</h4>
                              <table class="table">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>Invoice</th>
                                        <th>Delivery</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if($payments!=''){
                                    $tt_pay = 0.00;
                                    foreach($payments as $prow){ ?>
                                      <tr>
                                          <td><?php echo $prow->invoice; ?></td>
                                           <td><?php echo $prow->item_del; ?></td>
                                            <td><?php echo $prow->payment; $tt_pay += $prow->payment; ?></td>
                                            
                                      </tr>
                                <?php } }  ?>
                                </tbody>
                            </table>
                         </div>
                          <div class="col-sm-3">
                              <h4>Expenses</h4>
                               <table class="table">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Expense</th>
                                        <th>Amount</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if($expense!=''){ 
                                    $tt_ex = 0.00;
                                    foreach($expense as $exrow){ ?>
                                      <tr>
                                          <td><?php echo $exrow->name; ?></td>
                                           <td><?php echo $exrow->cost; $tt_ex += $exrow->cost; ?></td>
                                           
                                      </tr>
                                <?php } }  ?>
                                </tbody>
                            </table>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Summary</h4>
                            <p>
                                Total Cash: <b><?php echo $tt_pay; ?></b><br/>
                                
                            </p>
                            <p>
                                Total Expense: <b><?php echo $tt_ex; ?></b><br/>
                                
                            </p>
                            <p>
                                Total Balance: <b><?php echo $tt_pay - $tt_ex; ?></b><br/>
                                
                            </p>
                        </div>
                    </div>
                   
                </div><!-- /.box-body -->

                <div class="box-footer">
                
                    
                    <p class="text-right"> www.refineitbd.com</p>
                </div>

            </div>
        </div>
    </div>
</div>
</div>