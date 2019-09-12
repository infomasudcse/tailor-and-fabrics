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
                  echo '<span class="" style="font-size:18px;font-weight:bold;color:#0000FF;">Distribution Report of '.$type.'<span>';
              }else{?>
                  <span class="" style="font-size:18px;font-weight:bold;color:#0000FF;"> Distribution Report of <?php echo $datee; ?> </span><br/>
           
             <?php } ?>
                
            </p>            
            
        </div>
        
        <?php 
            if($from_branch != '' && $to_branch !=''){
        ?>
            <div class="col-sm-12">
                <!--header-->
                <p class="text-center"  style="margin-top:20px;border-bottom:1px solid green;"> 
                    <span class="" style="font-size:18px;font-weight:bold;color:#0000FF;">  
                      <?php echo $from_branch.' ----> '.$to_branch; ?>
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
                        
                        <div class="col-sm-12">
                            <table class='table'>
                                <thead>
                                    <tr class='bg-primary'>
                                        <th>SL.</th>
                                        <th>Date</th>
                                        <th>Fabrics_model</th>
                                        <th>Qty</th>
                                        <th>Unit_price</th>
                                        <th>Total_price</th>                                           
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($results!=''){
                                            $tot_pr = 0.00;
                                            $tot_qty = 0.00;
                                            $i=1;
                                            foreach($results as $row){
                                                  $this->db->where('fabrics_model', $row->fabrics_model);
                                                  $this->db->limit(1);
                                                 $query = $this->db->get('fabrics');
                                                 
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->trans_date; ?></td>
                                     <td><?php echo $row->fabrics_model;?></td>
                                     <td><?php echo $row->qty; $tot_qty += $row->qty; ?></td>
                                     <td><?php echo $query->row()->unit_price ;?></td>
                                     <td><?php $subtot =  $row->qty * $query->row()->unit_price ; echo $subtot; $tot_pr += $subtot; ?></td>
                                    </tr>
                                        <?php $i++;} } ?>
                                    
                                    <tr class='bg-success'>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b><?php echo 'Tot: '.$tot_qty; ?></b></td>
                                        <td></td>
                                        <td><b><?php echo 'Tot: '.$tot_pr; ?></b></td>
                                    </tr>
                                    
                                </tbody>
                                
                                
                            </table>
                        
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class='col-sm-12' style='padding-top:20px;'>
                            <div class='row'>                      
                            
                                <div class="col-sm-2">
                                    <?php echo 'Date : '.date('Y-m-d');?>
                                </div>
                                <div class="col-sm-2 col-sm-offset-6">
                                   <p> Signature</p>
                                </div>
                             </div>
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