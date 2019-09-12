<div class="row">  
 <?php 
   $cartdata = $this->cart->contents();
   $this->db->where('person_id', $customer_id);
   $queryone = $this->db->get('people');
   if($queryone->num_rows() == 1 ){
       $customer = $queryone->row();
   }else{
       $customer='';
   }
   
   
   ?>
<!---cart view----->
<div style="width:100%;padding:10px 20px; background-color:#ffffff;" id='invoice_view'>
  
            <div>
                <div align="center" style="width:100%;float:left;background-color:#f90000;">
                    <!--header-->
                  <p style="padding:5px;auto;" align="center">  
                    <span  style="color:#ffffff;font-size:35px;font-weight:bold; letter-spacing: 10px;">Company</span>
                  </p>
                     
                </div>
                <div align="center" style="width:100%;float:left;background-color:#191975;margin:1px auto;" >
                    <!--header-->
                   
                    <span  style="color:#ffffff;font-size:18px;"> FABRICS, TAILORS & ACCESSORIES</span>
                
                     
                </div>
              <div align="center" style="width:100%;float:left;">
                   <!-- address-->
                   <div style="width:100%;">
                       <div style="width:40%;float:left;">
                           <table width="100%" style="">
                              <?php  if($customer !=''){ ?>
                               <tr>
                                   <td><p>&nbsp;</p> </td>
                                   <td> </td>
                                  
                               </tr>
                               <tr>
                                    <td>Name :  <?php echo $customer->first_name.' '.$customer->last_name; ?> </td>
                                   <td> </td>
                                  
                               </tr>                               
                                <tr>
                                   <td>Mobile/Phone : <?php echo $customer->phone_number; ?> </td>
                                    <td>  </td>
                               </tr>  
                                <tr>
                                    <td><h2>&nbsp;</h2></td>
                                    <td> <h2>&nbsp;</h2></td>
                               </tr> 
                              <?php }else{
                                  echo '<tr>
                                    <td>Name: Not Define </td>
                                   <td> 
                                        
                                   </td>
                                  
                               </tr>                               
                                <tr>
                                   <td>Mobile/Phone:Not define </td>
                                    <td>  </td>
                               </tr>  
                                <tr>
                                    <td><h2>&nbsp;</h2></td>
                                    <td> <h2>&nbsp;</h2></td>
                               </tr> ';
                              } ?>
                           </table>
                           
                       </div>
                      <div style="width:30%;float:left;">
                           <div style="width:100%;">
                               <p></p>
                           <div style="width:40%;float:left;">Invoice : </div>
                          <div style="width:58%;float:left;"><?php echo $invoice; ?><br/></div>
                          <div style="width:100%;float:left;"></div>
                            <div style="width:40%;float:left;">Date: </div>
                             <div style="width:58%;float:left;"><?php echo $order_date;?></div>
                             <div style="width:100%;float:left;"></div>
                            <div style="width:40%;float:left;">Delivery: </div>
                             <div style="width:58%;float:left;"><?php echo $del_date;?></div>
                           </div>
                       </div>
                       <div style="width:30%;float:left;">
                           <p>
                              <?php $this->db->where('branch_id', $branch_id);
   $querytwo = $this->db->get('branch');
   if($querytwo->num_rows() == 1){
       $branch = $querytwo->row();
       echo '<b>'.$branch->branch_name.'</b><br/>'.$branch->branch_address.'<br/>Tel: '.$branch->branch_phone;
   }else{
       echo '<b>A.K PLAZA</b><br/>House#01, Road #1/B, Sector #09<br/>Uttara Model Town, Dhaka-1230<br>Tel: 02-8953405.';
   }
       ?>
                           </p>
                       </div>
                   </div>
                </div>
                    
                <div align="center" style="width:100%;float:left;">
                    <!--table-->
                    
                    <div style="min-height:200px;width:98%;float:left;border:1px solid #ccc;">
            <table id="example2" cellpadding='5px' cellspacing='10px' brder='1' style="width:100%;">
                <thead>
                    <tr class="" style='background-color:#99C2FF;'>
                        <th>SL.</th>
                        <th>Model</th>
                        <th>Name</th>
                        <th>QTY</th>
                        <th style="text-align:right">Unit Price</th>
                        <th style="text-align:right">Sub-Total</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $i=1;
                     if(empty($cartdata)) {
                echo '<tr><td colspan="6"><div class="alert alert-danger" role="alert">No Fabrics Item  !</div></td></tr>';
                
            }else{

                  
                    foreach ($cartdata as $crt) {
                        ?>
                        <tr>
                             <td><?php echo $i; ?></td>
                            <td><?php echo $crt['options']['model'];?></td>
                            <td><?php echo $crt['name'];?></td>
                            <td>
                                 <?php echo $crt['options']['fb_qty'];?>
                            </td>
                            <td style="text-align:right"><?php echo $crt['price']; ?></td>
                             <td style="text-align:right"><?php $subtot = $crt['options']['fb_qty'] * $crt['price']; echo $this->cart->format_number($subtot); ?></td>
                             
                        </tr>
            <?php $i++; } }
              
             $query= $this->db->get('fb_temp_tcost');
             if($query->num_rows() > 0 ){ 
                    $j = $i;
                    foreach($query->result() as $tcrow){
                        $this->db->where('id', $tcrow->cost_id);
                        $querytwo = $this->db->get('fb_tailor_cost');
                        $row = $querytwo->row();
                        $sum_to_total += $row->cost;
                        ?>
             <tr>
                 <td><?php echo $j; ?></td>
                <td colspan="2" class="text-right">Tailoring Cost </td>
                 <td style="text-align:right"><strong><?php echo $row->name; ?></strong></td>
                 <td style="text-align:right"><?php echo $row->cost; ?></td>
                 <td style="text-align:right"><?php echo $row->cost; ?></td>
            </tr>
             <?php $j++; } } ?>
                        
                        
                        
                </tbody>       
            </table>
           
                    </div> 
                    <div style="width:95%;float:left;">
                        <table style="width:100%;">
                            <tr>
                            
                            <td width="60%" align="right"> <p style="padding:5px;" align="right"><b> Total:</b> </p></td>
                            <td align="right"><b><?php  echo $this->cart->format_number($tot_order); ?></b>(BDT).</td>
                              
                             </tr> 
                             <?php if($disq > 0){?>
                                    <tr>

                                   <td width="60%" align="right"> <p style="padding:5px;" align="right"><b> Total Disq :</b> </p></td>
                                   <td align="right"><b><?php  echo $this->cart->format_number($disq); ?></b>(BDT).</td>

                                    </tr>
                                    
                             <?php } ?>
                              <tr>

                                   <td width="60%" align="right"> <p style="padding:5px;" align="right"><b> Total Invoice :</b> </p></td>
                                   <td align="right"><b><?php  echo $this->cart->format_number($tot_to_pay); ?></b>(BDT).</td>

                               </tr>      
                             <tr>
                            
                            <td width="60%" align="right"> <p style="padding:5px;" align="right"><b>Paid :</b> </p></td>
                            <td align="right"><?php echo ($payment != '')? $this->cart->format_number($payment) : '0.00'; ?></td>
                              
                             </tr> 
                             <tr>
                            
                            <td width="60%" align="right"> <p style="padding:5px;" align="right"><b>Due:</b> </p></td>
                            <td align="right"><?php echo (isset($due))? $this->cart->format_number($due) : ' ' ;?></td>
                              
                             </tr> 
                             
                             <tr>
                            
                            
                              
                             </tr> 
                        </table>
                    </div>
                </div>
                
               <div style="width:100%;float:left;">
                    <!--footer-->
                 <div style="width:100%;float:left;margin-top:30px;padding-top:10px;">
                     
                        <div style="width:40%;float:left;" align="center"><p><br/><br/></p><h5>Date: <?php echo date('d-m-Y');?></h5></div>
                       
                        <div style="width:50%;float:right;" align="right"><p><br/><br/></p><h5 style="margin-left:150px;">Signature </h5><p><br/><br/><br/></p></div>
                        
                    </div>
                     <div style="width:100%;float:left;margin-top:10px;padding-top:10px;">
                         <p>
                             * some info ........................<br/>
                             * some info......................<br/>
                         </p>                      
                    </div>
                </div>
            </div>
                
    
 <div style="width:100%;float:left;bottom:10px;margin-top:10px;">
    <p align="center"> ------------------***-----------------</p>
        <p align="center" style="font-size:9px;">Powered by: WWW.REFINEITBD.COM</p>
    </div>      
</div>  


<!-------end cart ------>
<script>
    $(document).ready(function(){
        var sayfa = window.open('', '', 'width=800,height=auto');
                sayfa.document.open("text/html");
                sayfa.document.write(document.getElementById('invoice_view').innerHTML);
                sayfa.document.close();
                sayfa.print();
                
                
                
          setTimeout(function() {
                        window.location.href = "<?php echo site_url(); ?>/fb_customer/";
                  }, 5000);      
                
    });
    
    </script>

</div>