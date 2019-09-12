<div class="row">
<div class="col-md-12">
    <div class="row"><div class="col-sm-1 col-sm-offset-11">
            
             <span class="btn btn-sm btn-primary" onClick="popup_print();">Print</span>            
        
        </div></div>
    <div class="row" id="print_div">
        <div class="col-sm-12" style="background-color:#ff0000;">
            <!--header-->
            <p class="text-center"  style="margin-top:20px;"> 
                <span class="" style="font-size:25px;font-weight:bold;color:#ffffff;"> Company Name( <?php echo $branch ; ?>)</span><br/>
            </p>            
            
        </div>
         <div class="col-sm-12">
            <!--header-->
            <p class="text-center"  style="margin-top:20px;border-bottom:1px solid red;"> 
              <?php if($type == 'all'){
                  echo '<span class="" style="font-size:18px;font-weight:bold;color:#0000FF;">Attendance Report of '.$type.'<span>';
              }else{?>
                  <span class="" style="font-size:18px;font-weight:bold;color:#0000FF;"> Attendance Report of <?php echo $datee; ?> </span><br/>
           
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
                            <table class='table' align="center">
                                <thead>
                                    <tr class='bg-primary'>
                                        <th>Photo</th>
                                        <th>Full Name</th>
                                        <th>Phone</th>
                                        <th>Day</th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>Work Hour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                    $sum_sec = 0;
                                   if(!empty($results)){
                                      
                                            foreach($results as $row){ 
                                                $member = '';
                                              $this->db->where('id', $row->member_id);  
                                                $sql= $this->db->get('fb_branchmember');
                                                if($sql->num_rows() == 1 ){
                                                    $member = $sql->row();
                                                }
                                                ?>
                                            
                                    <tr>
                                        <td><?php if($member->photo != ''){ echo '<img src="'.base_url().'uploads/members/'.$member->photo.'" width="70">';}else{echo '--';}; ?></td>
                                        <td> <?php if($member->full_name != ''){ echo $member->full_name;}else{echo '--';}; ?></td>
                                        <td><?php if($member->contact != ''){ echo $member->contact;}else{echo '--';}; ?></td>
                                         <td><?php echo $row->day; ?></td>
                                          <td><?php echo date(" G:i:s ", strtotime($row->day_in)); ?></td>
                                          <td><?php echo date(" G:i:s ", strtotime($row->day_out)); ?></td>
                                          <td>
                                            <?php  $timestamp1 = strtotime($row->day_in);
                                                $timestamp2 = strtotime($row->day_out);
                                               $seconds =  "SELECT UNIX_TIMESTAMP('".$row->day_out."') - UNIX_TIMESTAMP('".$row->day_in."') as output";
                                                 $sql = $this->db->query($seconds);
                                              
                                              $sec =  $sql->row()->output;
                                            $sum_sec += $sec;
                                               echo gmdate("H:i:s", $sec);
                                              ?>
                                          </td>
                                    </tr>
                                    
                                            <?php  } }  ?> 
                                    <tr class="bg-success">
                                        <td colspan="6" align="right">Total: </td>
                                        <td>
                                            <?php  echo gmdate("H:i:s", $sum_sec);
                                              ?>
                                            
                                            
                                        </td>
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