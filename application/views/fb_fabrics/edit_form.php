<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background: #000;">
            <button class="btn btn-danger btn-sm pull-right" data-dismiss="modal">X</button>
            <h4 style="color:#fff;">Edit Fabrics</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                
             
                <form class="form-horizontal" id="edit_form">
                    <input type="hidden" name="id" value="<?php echo $product->fabrics_id; ?>">
                        <div class="form-group divmodel" >
                            <label for="model" class="col-sm-3 control-label">Fabrics Model</label>
                            <div class="col-sm-9 ">
                                <input type="text" name="model" class="form-control" id="model" value="<?php echo $product->fabrics_model; ?>">
                            </div> 


                        </div>
                        <div class="form-group divfname" >

                            <label for="fname" class="col-sm-3 control-label">Fabrics Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="fname" class="form-control" id="fname" value="<?php echo $product->name; ?>">
                            </div>

                        </div>
                        <div class="form-group divqty">
                            <label for="qty" class="col-sm-3 control-label">Quantity<small>(in yrd)</small></label>
                            <div class="col-sm-9">
                                <input type="text" name="qty" class="form-control" id="qty" value="<?php echo $product->qty; ?>">
                            </div>

                        </div>
                        <div class="form-group divsellprice">                         
                            <label for="sellprice" class="col-sm-3 control-label">Cost Price</label>
                            <div class="col-sm-9">
                                <input type="text" name="cost_price" class="form-control" id="sellprice" value="<?php echo $product->cost_price; ?>">
                            </div>
                        </div>
                        <div class="form-group divunitprice">
                            <label for="unitprice" class="col-sm-3 control-label">Unit Sell Price</label>
                            <div class="col-sm-9">
                                <input type="text" name="unit_price" class="form-control" id="unitprice" value="<?php echo $product->unit_price; ?>">

                            </div> 

                        </div>

                        


                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" onClick="return valid_update();">U P D A T E</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <div class="col-sm-12 result">

                            </div>  
                        </div>
                    <div class="edit_error"></div>
                    </form>
                
            </div>
        </div>
    </div>
</div>