

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
                  echo '<span class="" style="font-size:18px;font-weight:bold;color:#0000FF;">Expense Report of '.$type.'<span>';
              }else{?>
                  <span class="" style="font-size:18px;font-weight:bold;color:#0000FF;"> Expense Report of <?php echo $datee; ?> </span><br/>
           
             <?php } ?>
                
            </p>            
            
        </div>
        
       
        
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
                                       
                                        <th>Date</th>
                                        <th>Branch</th>
                                        <th>Type</th>
                                        <th align="right">Cost</th>                                                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                     <?php 
                                     $tot = 0.00;
                                     if(!empty($results)){
                                            foreach($results as $row){
                                                $branch = $this->fb_report_model->get_branch_name($row->branch_id);
                                             ?>
                                    <tr>
                                        <td><?php echo $row->expdate;  ?></td>
                                         <td><?php echo $branch; ?></td>
                                          <td><?php echo (isset($row->name))? $row->name : ''; ?></td>
                                           <td align="right"><?php echo $row->cost; $tot += $row->cost; ?></td>
                                    </tr>
                                    
                                    
                                            <?php } } ?>
                                    
                                    
                                    <tr>
                                        <td></td>
                                         <td></td>
                                          <td></td>
                                           <td align="right">Total: <?php echo $tot.'/-'; ?> </td>
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