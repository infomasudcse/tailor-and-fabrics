<div class="row">
    <div class="col-sm-12 bg-lal" align="center">    
        <b style="color:#ffffff;font-size:20px;">Company</b>
    </div>
    <!--<div class="col-sm-12 bg-dark-blue text-white text-size-16 margin-top-5" align="center">    
        FABRICS, TAILORS & ACCESSORIES
    </div> -->   
    <form method="post" id="bill_process">
        <div class="col-sm-12 bg-info" style="padding-top:5px;">
           <input type='hidden' name='customer_id' value='<?php echo ($crow !='')? $crow->person_id:''; ?>'/>
           
            <div class="form-group ">
                <label for="customer" class="col-sm-1 control-label">Name</label>
                <div class="col-sm-2 divcustomer">
                    <input type="text" name="first_name" value="<?php if($crow!=''){ echo $crow->first_name;} ?>" placeholder="first n..." id="customer" class="form-control input-sm" /><br/>
                </div>
                <div class="col-sm-2 divfname">
                    <input type="text" name="last_name" value="<?php if($crow!=''){ echo $crow->last_name;} ?>" placeholder="last n..." id="fname" class="form-control input-sm" /><br/>
                </div>
                <label for="contact" class="col-sm-1 control-label">Contact</label>
                <div class="col-sm-3 divcontact">
                    <input type="text" name="contact" value="<?php echo ($crow!='')?$crow->phone_number:''; ?>" id="contact" class="form-control input-sm" /><br/>
                </div>
                <label for="dt" class="col-sm-1 control-label">Date</label>
                <div class="col-sm-2">
                    <input type="text" name="dt" value="<?php echo date('Y-m-d');?>" id="dt" class="form-control input-sm" /><br/>
                </div>
            </div>
            <div class="form-group ">
                <label for="dldate" class="col-sm-1 control-label">Delivery Date</label>
                <div class="col-sm-2">
                    <?php 
                    $date = new DateTime(date('Y-m-d'));
                    $date->add(new DateInterval('P10D'));


                    ?>
                    <input type="text" name="dldate" value="<?php echo $date->format('Y-m-d') ; ?>" id="datepicker" class="form-control input-sm" /><br/>
                </div>
                
                
                <label for="dt" class="col-sm-1 control-label">Size</label>
                <div class="col-sm-6">
                    <input type="text" name="size" value="<?php echo ($crow!='')?$crow->comments:''; ?>" class="form-control"/>
                 </div>
                <label for="dt" class="col-sm-2 control-label"><?php echo 'Branch : ' . $branch->branch_name; ?></label>
                
            </div>
        </div>
    </form>
     <div class="col-sm-12" style="min-height:5px;background:#ccc;padding:2px auto;">    

    </div>
    <div class="col-sm-12" style="background:#e6e6e6;padding:15px;">
        <div class="row">
        <div class="col-sm-7 bordertop3" > 
            <div class="form-group ">
                <label for="add_item" class="col-sm-2 control-label">Model</label>
                <div class="col-sm-4 additem">
                    <input type="text" name="add_item"  id="add_item" class="form-control" /><br/>

                </div>
                <label for="add_qty" class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-3 input-group addqty">
                    <input type="text" name="add_qty"  id="add_qty" class="form-control" /><br/>
                    <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return add_item_to_cart();" type="button">Add</button>
                    </span>
                </div>
            </div>

        </div>
        <div class="col-sm-4  col-sm-offset-1 bordertop3" >
              <div class="form-group">
                            <label for="tcost" class="col-sm-4 control-label">Tailoring Cost</label>
                            <div class="col-sm-8 input-group">
                                <select name="tcost" class="form-control" id="tocst">
                                    <?php echo $select; ?>
                                </select>
                                <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return add_tailor_cost();" type="button">Add</button>
                    </span>
                            </div>

                        </div>
        </div>
        </div>
    </div>
      <div class="col-sm-12" style="min-height:5px;background:#ccc;padding:2px auto;">    

    </div>
    <div class="col-sm-12" style="padding:15px;background:#d6d6d6;">
        <div class="row">
        <div class="col-sm-6">
        <div class="form-group">
            <div class="col-sm-3"><label>Use Card </label></div>
                            <div class=" col-sm-8 input-group">
                                <input type="text" name="card" id="card_number" class="form-control">
                                <span class="input-group-btn">
                                 <button class="btn btn-info" onClick="return add_card_number();" type="button">Use</button>
                                 </span>
                            </div>

                    </div>
    </div>
    <div class="col-sm-6">
        <p> Card Disq. on Gross Amount </p>
    </div>
        </div>
    </div>
     <div class="col-sm-12" style="min-height:5px;background:#ccc;padding:2px auto;">    

    </div>
    <div class="col-sm-12 error_alert">    

    </div>

    <div class="col-sm-12 margin-top-5 padding-top-10">


        <table class="table table-bordered" cellpadding="6" cellspacing="1" style="width:100%" border="0">

            <tr class="">
                <th>SL.</th>
                <th>Model</th>
                <th>Name</th>
                <th>QTY</th>
                <th style="text-align:right">Unit Price</th>
                <th style="text-align:right">Sub-Total</th>
                <th>Actions</th>
            </tr>
                <?php   $cartdata = $this->cart->contents();                   
                 $totall = 0;    
                foreach ($cartdata as $crt) { $i=1;
                   
                    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $crt['options']['model'];?></td>
                <td><?php echo $crt['name'];?></td>
                <td>
                  
                    <form action="<?php echo site_url(); ?>/fb_new_order/update_cart/<?php echo $crt['rowid']; ?>" method="post">                 
                          <input type="text" class="input-sx" name="qty" value="<?php echo $crt['options']['fb_qty']; ?>" >
                            <input type="hidden" name="fb_id" value="<?php echo $crt['id'];?>" >
                               <input type="submit" class="btn btn-xs btn-warning" name="btn" value="Update">      
                    </form>            
                   
                </td>
                <td style="text-align:right"><?php echo $crt['price']; ?></td>
                 <td style="text-align:right"><?php $subtot = $crt['options']['fb_qty'] * $crt['price']; echo $this->cart->format_number($subtot); ?></td>
                 <td> <a class="btn btn-danger btn-xs" href="<?php echo site_url();?>/fb_new_order/remove_tocart/<?php echo $crt['rowid'] ?>">Delete</a></td>
                               
                </tr>

                    <?php $i++; $totall += $subtot;  } ?>

             <?php 
                $sum_to_total = 0;
             $query= $this->db->get('fb_temp_tcost');
             if($query->num_rows() > 0 ){ 
                    foreach($query->result() as $tcrow){
                        $this->db->where('id', $tcrow->cost_id);
                        $querytwo = $this->db->get('fb_tailor_cost');
                        $row = $querytwo->row();
                        $sum_to_total += $row->cost;
                        ?>
             <tr>
                <td colspan="3" class="text-right">Tailoring Cost </td>
                <td class="text-right"><strong><?php echo $row->name; ?></strong></td>
                <td class="text-right"><?php echo $row->cost; ?></td>
                <td class="text-right"><?php echo $row->cost; ?></td>
                <td> <a class="btn btn-danger btn-xs" href="<?php echo site_url();?>/fb_new_order/remove_tailor_cost/<?php echo $tcrow->id; ?>">Delete</a></td>
            </tr>
             <?php } }else{ echo '<tr><td colspan="7" class="text-warning">No Tailoring Cost added yet ! </td></tr>';} ?>
            <tr>
                <td colspan="4"> </td>
                <td class="text-right"><strong>Total</strong></td>
                <td class="text-right"><?php $tot = $totall + $sum_to_total; echo $this->cart->format_number($tot); ?></td>
            </tr>
           
                 <?php 
                            $card = $this->session->userdata('card');
                            if($card != ''){
                              
                    ?>
               <tr> 
                   <td colspan="4"><strong>Card Disq. number : <?php echo $card; ?></strong> </td>
                <td class="text-right"><?php echo 'Disq. <span class="label label-success">'.$this->session->userdata('cardtype').' '.$this->session->userdata('carddisq').' % '.'</span>'; ?></td>
                <td class="text-right" style="">   <?php $tot_disq =  ($this->session->userdata('carddisq') * $tot)/100 ;  echo '-'.$this->cart->format_number($tot_disq); ?>       </td>
               </tr>     
                <tr> 
                   <td colspan="4"> </td>
                <td class="text-right">Total Invoice:</td>
                <td class="text-right" style="">   <?php $tot_tt_pay =  $tot - $tot_disq ; echo $this->cart->format_number($tot_tt_pay); ?>       </td>
               </tr> 
                         <?php 
                            
                            }else{ 
                                echo '<tr><td colspan="6"><span class="text-warning">No Card Uses For This Order !</span></td></tr>';
                                
                            }
                            ?>
                
           
             <tr>
                <td colspan="4"> </td>
                <td class="text-right"><strong>Payment</strong></td>
                 <td class="text-right" style="max-width:200px;">
                    <div class=""> <input type="text" name="payment" class="form-control" size="3" id="payment"/></div>
                </td>
            </tr>
             

        </table>

        <p></p>
    </div>
    <div class="col-sm-12 margintopbottom5 padding-top-10 ">
        <button class="btn btn-warning" onClick="return add_form_action_to_submit();">Process Invoice</button>
        <span class="btn btn-default" onClick="return dissmiss_sell_process();">Reset all ! </span>
    </div>

</div>

<!-----modal-->



<!---modal---->



<script>
                            function add_item_to_cart() {
                                var item = $('#add_item').val();
                                var qty = $('#add_qty').val();
                                var segui = true;
                                if (item === '') {
                                    $('.additem').addClass('has-error');
                                    segui = false;
                                }
                                if (qty === '') {
                                    $('.addqty').addClass('has-error');
                                    segui = false;
                                }
                                if (segui === true) {
                                    $.ajax({
                                        type: 'post',
                                        url: '<?php echo site_url(); ?>/fb_new_order/add_item_for_sell',
                                        data: {
                                            item: item,
                                            qty: qty
                                        },
                                        success: function(data) {
                                            if (data === 'ok') {
                                                location.reload();
                                            } else {
                                                $('.error_alert').html(data);
                                            }
                                        }
                                    });
                                } else {
                                    return false;
                                }
                            }
                            
 function add_tailor_cost(){
 var tcost = $('#tocst').val();
    if(tcost !== ''){
        $.ajax({
            type:'post',
            url:'<?php echo site_url(); ?>/fb_new_order/add_tailor_cost',
            data:{tcost:tcost},
            success: function(data){
                    if(data === 'ok'){
                        location.reload();
                    }
            }
        });
    }
 }                          


function add_card_number(){
    var cardn = $('#card_number').val();
    var custm = '<?php echo $this->session->userdata('cus_id'); ?>';
    if(cardn !== '' && custm !== ''){
        $.ajax({
            type:'post',
            url:'<?php echo site_url(); ?>/fb_new_order/add_disq_card',
            data:{cardn:cardn},
            success: function(data){
                    if(data === 'ok'){
                        location.reload();
                    }else{
                        return false;
                    }
            }
        });
    }else{
    return false;
    }



}




function add_form_action_to_submit() {
                                var flname = $('#fname').val();
                                var custm = $('#customer').val();
                                var cnt = $('#contact').val();
                               var paymnt = $('#payment').val();
                               
                                var murchon = true;
                                if (flname === '') {
                                    $('.divfname').addClass('has-error');
                                    murchon = false;
                                }
                                if (custm === '') {
                                    $('.divcustomer').addClass('has-error');
                                    murchon = false;
                                }
                                if (cnt === '') {
                                    $('.divcontact').addClass('has-error');
                                    murchon = false;
                                }
                                if (murchon === true) {
                                    if(paymnt=== ''){
                                        var cnfrm = confirm(' No Payment added yet ! Process to Invoice ? ');
                                         if(cnfrm === true){
                                                     $("#bill_process").attr("action", "<?php echo site_url();?>/fb_new_order/process_new_order");
                                                    $( "#bill_process" ).submit(); 
                                           }else{
                                                
                                                $('#payment').css('background-color','#FFCC99');
                                                 murchon = false;
                                                return false;
                                            }
                                    }else{
                                            var confrm = confirm(' Process to Invoice ? ');
                                         if(confrm === true){
                                                     var aaction = "<?php echo site_url();?>/fb_new_order/process_new_order/"+paymnt;
                                                     $("#bill_process").attr("action", aaction );
                                                     $( "#bill_process" ).submit();  
                                           }else{
                                                
                                              
                                                return false;
                                            }
                                    
                                        
                                    }
                                   
                                            
                                } else {

                                    return false;
                                }



                            }


</script>