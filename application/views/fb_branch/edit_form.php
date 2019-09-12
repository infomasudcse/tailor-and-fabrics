<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background: #000;">
            <button class="btn btn-danger btn-sm pull-right" data-dismiss="modal">X</button>
            <h4 style="color:#fff;">Edit Branch Info</h4>
        </div>
        <div class="modal-body">
            
            <?php if($branch != ''){ ?>
            
            
            <div class="row">
                
             
                <form class="form-horizontal" id="edit_form">
                    <input type="hidden" name="id" value="<?php echo $branch->branch_id; ?>">
                        <div class="form-group divbname" >
                            <label for="model" class="col-sm-3 control-label">Branch Name</label>
                            <div class="col-sm-9 ">
                                <input type="text" name="name" class="form-control" id="bname" value="<?php echo $branch->branch_name; ?>">
                            </div> 


                        </div>
                        <div class="form-group divbaddress" >

                            <label for="fname" class="col-sm-3 control-label">Branch Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="baddress" name="address"><?php echo $branch->branch_address; ?></textarea>
                            </div>

                        </div>
                        <div class="form-group divbphone">
                            <label for="qty" class="col-sm-3 control-label">Phone </label>
                            <div class="col-sm-9">
                                <input type="text" name="phone" class="form-control" id="bphone" value="<?php echo $branch->branch_phone; ?>">
                            </div>

                        </div>
                        

                        


                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" onClick="return valid_update_branch();">U P D A T E</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <div class="col-sm-12 result">

                            </div>  
                        </div>
                    <div class="edit_error"></div>
                    </form>
                
            </div>
            <?php }else{
                echo '<h2> Can not load Branch Info !</h2>';
            } ?>
        </div>
    </div>
</div>

