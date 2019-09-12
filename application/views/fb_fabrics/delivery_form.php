<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary" style="">
            <button class="btn btn-danger btn-sm pull-right" data-dismiss="modal">X</button>
            <h4 style="color:#fff;">Delivery</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                
               <form id="delform">
                
                 
                    <table class="table">
                        <tr>
                            <td>Invoice: </td>
                            <td><b><?php echo $row->invoice; ?></b></td>
                            <td>Order Date</td>
                            <td><b><?php echo $row->order_date;?></b></td>
                            <td>Delivery</td>
                            <td><b><?php echo $row->del_date; ?></b></td>
                        </tr>
                        <tr>
                            <?php 
                            $this->db->where('person_id', $row->customer_id);
                            $query = $this->db->get('people');
                            
                            ?>
                            <td>Customer</td>
                            <td colspan="2"><b><?php echo $query->row()->first_name.' '.$query->row()->last_name;?></b></td>
                            <td>Phone</td>
                            <td colspan="2"><b><?php echo $query->row()->phone_number; ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="2">Total Fabrics Cost : <b> <?php echo $row->tot_fabrics;?> </b></td>
                            <td></td>
                            <td colspan="2">Total Tailoring Cost :</td>
                            <td><b><?php echo $row->tot_tailor_cost; ?></b></td>
                            
                        </tr>
                         <tr>                           
                            <td colspan='3'>Total item : <b><?php echo $row->tot_item; ?></b> <br/>
                                Remain Item: <b><?php echo $row->re_item; ?></b></td>
                          
                            <td colspan="2">Sub Total:</td>
                            <td><b><?php $sum_tot = $row->tot_fabrics + $row->tot_tailor_cost; echo $sum_tot; ?></b></td>
                            
                        </tr>
                        <tr>                           
                            <td colspan="3"></td>
                            <td colspan="2">Paid:</td>
                            <td><b><?php echo $row->payment; ?></b></td>
                            
                        </tr>
                        <tr>              
                            <td colspan="3"></td>
                            <td colspan="2">Due:</td>                            
                            <td><b><?php echo $row->due; ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="3">Balance to Pay:</td>                            
                            <td>
                                
                                <div class="bldiv">
                                    <input class="form-control" type="text" name="balance" value="<?php echo $row->due; ?>" id="balance"/>
                                </div>
                            </td>
                        </tr>
                         <tr>
                            <td colspan="2"></td>
                            <td colspan="3">Item to delivery:</td>                            
                            <td>                               
                                <div class="dldiv">
                                    <input class="form-control" type="text" name="delv_item" value="" id="delv_item"/>
                                </div>
                            </td>
                        </tr>
                    </table>

                        

              
                    <input type="hidden" name="invoice" value="<?php echo $row->invoice;?>"/>
                    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <button type="button" class="btn btn-info" onClick="return valid_payment('<?php echo $row->due; ?>');">Add Payment</button>
                               <button type="button" class="btn btn-warning" onClick="return valid_delivery('<?php echo $row->due; ?>');">Delivery</button>
                               
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <div class="col-sm-12 result bg-danger">

                            </div>  
                        </div>
                     
                </form>
              
                
            </div>
        </div>
    </div>
</div>