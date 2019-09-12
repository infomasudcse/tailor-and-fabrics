<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background: #000;">
            <button class="btn btn-danger btn-sm pull-right" data-dismiss="modal">X</button>
            <h4 style="color:#fff;">Fabrics Member Barcode</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                
             
                <form  action="<?php echo site_url('fb_member/generate_barcode_specific_item'); ?>" class="form-horizontal" method="post" id="tranfer_input">
                     <input type="hidden" name="model" value="<?php echo $ids;?>" />
                  
                        <div class="form-group divmodel" >
                            <label for="qrt" class="col-sm-3 control-label">Quantity</label>
                            <div class="col-sm-9 ">
                                <input type="text" name="qty" value="1" class="form-control" id="model" autofocus required>
                            </div> 


                        </div>
                       
                        


                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <div class="col-sm-12 result">

                            </div>  
                        </div>
                    <div class="edit_error">
                        <span class="error_message_box" style="color:red;"></span>
                    </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>
