<script>
    function get_selected_values()
{
	var selected_values = new Array();
	$("#table_body :checkbox:checked").each(function()
	{
		selected_values.push($(this).val());
	});
	return selected_values;
}
$(document).ready(function()
{
 $('#generate_barcodes').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert('<?php echo 'No Fabrics Selected !' ?>');
    		return false;
    	}
        else if (selected.length == 1){
            
                   $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/input_generate_barcodes/'+selected.join(':'),
                                    data: {
                                        id: 'id'
                                    },
                                    success: function(data) {
                                        $('#barcode_fb').html(data);
                                        $('#barcode_fb').modal();
                                    }
                                });
           	/*$(this).attr('href','index.php/fb_fabrics/input_generate_barcodes/'+selected.join(':'));*/
        }
        else{
        	alert('<?php echo 'Please Select Only one Fabrics !' ?>');
    		return false;
        }
    });

});



</script>





<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Fabrics</h3></p>
        <div class="row">
            <div class="col-sm-6">
                <?php if($this->session->userdata('branch_id') == 0){ 
                   echo  ' <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" > ADD NEW</button>';
                   echo ' <button class="btn" id="generate_barcodes">Barcode</button> ';     
                } ?>
            </div>
            <div class="col-sm-6">
                <div class="input-group pull-right">
                    <input type="text" id="serch_text" class="form-control" placeholder="name or model...">
                    <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return serch_fabrics();" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <table class="table table-hover">
        <thead>
            <tr>
                <th>Fabrics Model</th>
                <th>Name</th>
                <th>Cost Price</th>
                <th>Sell Price</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Branch</th>
                <th>Action</th>

            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if (!empty($results))
                foreach ($results->result() as $row) {
                  
                    ?>        
                    <tr class="<?php echo $row->fabrics_id; ?>">
                        <td><?php echo '<input type="checkbox" name="model" value="'.$row->fabrics_id.'"/> '.$row->fabrics_model; ?></td>
                        <td><?php echo $row->name; ?></td>
                          <td><?php echo $row->cost_price; ?></td>
                        <td><?php echo $row->unit_price; ?></td>
                        <td><?php echo $row->qty; ?></td>
                        <td><?php echo $row->unit; ?></td>
                        <td>
                            <?php
                            $this->db->where('branch_id', $row->branch_id);
                            $sql = $this->db->get('branch');
                            echo ($sql->num_rows() == 1) ? $sql->row()->branch_name : 'not found';
                            ?></td>
                        <td>
                             <?php if($row->branch_id == 1){ ?>  
                            <span class="btn btn-xs btn-warning edit_fabric" onClick=" return editfb('<?php echo $row->fabrics_id; ?>');" >Edit</span>
                             <?php } ?>
                            <span class="btn btn-xs btn-primary tans_fabric" onClick="return transferfb('<?php echo $row->fabrics_id; ?>');">Transfer</span>
                            <span class="btn btn-xs btn-default delete_fabric" onClick="return deletefb('<?php echo $row->fabrics_id; ?>');">Del</span>
                             
                        </td>
                    </tr>
    <?php } ?>
        </tbody>
    </table>

    <div class="col-md-12">
        <p class='pagination'><?php echo $links; ?></p>
    </div> 

    <!------->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">New Fabrics</h4>
                </div>
                <div class="modal-body">

                    <!------>
                    <form class="form-horizontal" id="form">
                        <div class="form-group divmodel" >
                            <label for="model" class="col-sm-3 control-label">Fabrics Model</label>
                            <div class="col-sm-9 ">
                                <input type="text" name="model" class="form-control" id="model" placeholder="model" focus>
                            </div> 


                        </div>
                        <div class="form-group divfname" >

                            <label for="fname" class="col-sm-3 control-label">Fabrics Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="fname" class="form-control" id="fname" placeholder="fabrics name" focus>
                            </div>

                        </div>
                        <div class="form-group divqty">
                            <label for="qty" class="col-sm-3 control-label">Quantity<small>(in yrd)</small></label>
                            <div class="col-sm-9">
                                <input type="text" name="qty" class="form-control" id="qty" placeholder="qty">
                            </div>

                        </div>
                        <div class="form-group divsellprice">                         
                            <label for="sellprice" class="col-sm-3 control-label">Cost Price</label>
                            <div class="col-sm-9">
                                <input type="text" name="cost_price" class="form-control" id="sellprice" placeholder="cost price..">
                            </div>
                        </div>
                        <div class="form-group divunitprice">
                            <label for="unitprice" class="col-sm-3 control-label">Unit Sell Price</label>
                            <div class="col-sm-9">
                                <input type="text" name="unit_price" class="form-control" id="unitprice" placeholder="unit price..">

                            </div> 

                        </div>

                        <div class="form-group">
                            <label for="branch" class="col-sm-3 control-label">Branch</label>
                            <div class="col-sm-4">
                                <input type="text" name="branch_id" class="form-control" id="branch" value="Office" readonly>


                            </div>

                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" onClick="return valid_save();">S A V E</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <div class="col-sm-12 result">

                            </div>  
                        </div>
                    </form>
                    <!------->
                </div>

            </div>
        </div>
    </div>


    <!-------edit fb--->
    <div class="modal fade" id="edit_fb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>

    <!------------edit end----->
    <!-------edit fb--->
    <div class="modal fade" id="trans_fb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>

     <div class="modal fade" id="barcode_fb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>
    <!------------edit end----->

    <script>

    </script>
