<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background: #000;">
            <button class="btn btn-danger btn-sm pull-right" data-dismiss="modal">X</button>
            <h4 style="color:#fff;">Transfer Fabrics</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-5" align="left">
                    <span class="label label-success">Fabric Info</span><br/>
                    
                    <p>
                            <b>Model : </b>
                            <?php echo $product->fabrics_model; ?><br/>
                            <b>Name : </b>
                            <?php echo $product->name; ?><br/>
                            <b>Sell price : </b>
                            <?php echo $product->unit_price; ?><br/>
                            <b>Quantity : </b>
                            <span id="curr_qty"><?php echo $product->qty; ?></span><br/>
                            <b>Branch : </b>
                            
                                <?php 
                                $this->db->where('branch_id', $product->branch_id);
                                 $sql = $this->db->get('branch');
                                 echo ($sql->num_rows() == 1) ? $sql->row()->branch_name : 'not found'; 
                                 ?>
                            <br/>
                      </p>
                  
                </div>
                <div class="col-sm-1">
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                </div>
                <form id="trans_form"> 
                    <input type="hidden" name="current_branch" value="<?php echo $product->branch_id; ?>" />
                    <input type="hidden" name="product_id" value="<?php echo $product->fabrics_id; ?>"/>
                <div class="col-sm-6">
                    <span class="label label-danger">Transfer to</span><br/>
                    <br/>
                    <div class="form-group divtrqty">
                            <label for="trqty" class="col-sm-4 control-label">Quantity</label>
                            <div class="col-sm-8">
                               <input type="text" name="qty" id="trqty" class="form-control" autofocus /><br/>
                            </div>

                        </div>
                   <div class="form-group divtrbranch">
                            <label for="trbranch" class="col-sm-4 control-label">Branch</label>
                            <div class="col-sm-8">
                                
<select name="branch_id" class="form-control" id="trbranch">
                                <?php 
                                $this->db->where_not_in();
                                  $sql = $this->db->get('branch');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                    if($row->branch_id != $product->branch_id){  
                                        echo '<option value="' . $row->branch_id . '">' . $row->branch_name . '</option>';
                                    }
                                  
                                  }
                                  } else {
                                  echo '<option value="">No Branch</option>';
                                  }
                                  ?>

</select>
                            </div>

                        </div>
                    
                    
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <br/>
                                <button type="button" class="btn btn-primary" onClick="return valid_transfer();">Transfer</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                             
                        </div>
                </div>
                    <div class="trans_error text-danger"></div>    
            </form>
            </div>
        </div>
    </div>
</div>