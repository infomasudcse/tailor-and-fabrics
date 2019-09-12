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
                alert('<?php echo 'No Member Selected !' ?>');
                return false;
            }
            else if (selected.length == 1) {

                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url(); ?>/fb_member/input_generate_barcodes/' + selected.join(':'),
                    data: {
                        id: 'id'
                    },
                    success: function(data) {
                        $('#barcode_fb').html(data);
                        $('#barcode_fb').modal();
                    }
                });
            }
            else {
                alert('<?php echo 'Please Select Only one Member !' ?>');
                return false;
            }
        });

    });



</script>



<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Branch Member</h3></p>
        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" > ADD NEW</button>
                <?php echo ' <button class="btn" id="generate_barcodes">ID CARD</button> '; ?>
            </div>
            <div class="col-sm-6">
                <div class="input-group pull-right">
                    <input type="text" id="serch_text" class="form-control" placeholder="name or phone...">
                    <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return search_member();" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <table class="table table-hover">
        <thead>
            <tr class="bg-info">
                <th>Code</th>
                <th>Full Name</th>
                    <th>Photo</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Salary</th>
                <th>Branch</th>
                <th>Action</th>

            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if (!empty($results))
                foreach ($results->result() as $row) {
                    ?>        
                    <tr>
                        <td> <?php echo '<input type="checkbox" name="model" value="' . $row->id . '"/>' ?> <?php echo $row->code; ?></td>

                        <td> <span title="<?php echo $row->comments; ?>"><?php echo $row->full_name; ?></span></td>
                        <td><?php if($row->photo != ''){echo '<img src="'.base_url().'uploads/members/'.$row->photo.'" width="70">';}else{ echo " -- ";} ?></td>
                        <td><?php echo $row->address; ?></td>
                        <td><?php echo $row->contact; ?></td>
                        <td><?php echo $row->salary; ?></td>
                        <td><?php echo $row->branch_name; ?></td>
                        <td>
                            <a class="btn btn-default" onClick="return loadEditModal('<?php echo $row->id; ?>');">  <span class="glyphicon glyphicon-edit"></span></a>
                            <a class="btn btn-default" href="<?php echo site_url(); ?>/fb_member/delete_member/<?php echo $row->id; ?>" onClick="return checkAction();"><span class="glyphicon glyphicon-remove"></span></a>

                        </td>
                    </tr>
                <?php } ?>
        </tbody>
    </table>

    <div class="col-md-12">
        <p><?php echo $links; ?></p>
    </div> 

    <!------->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">New Member</h4>
                </div>
                <div class="modal-body">

                    <!------>
                    <form class="form-horizontal" id="form" enctype="multipart/form-data" >
                        <div class="form-group divfname" >
                            <label for="fname" class="col-sm-3 control-label">Full Name</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="fname" class="form-control" id="fname" placeholder="first name" focus>
                            </div> 


                        </div>

                        <div class="form-group divphone">
                            <label for="phone" class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="phone">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-4">
                                <textarea id="address" name="address" class="form-control" placeholder="address"> </textarea>
                            </div> 
                               <label for="comments" class="col-sm-2 control-label">Comments</label>
                             <div class="col-sm-3">
                                <textarea id="address" name="comments" class="form-control" placeholder="comments"> </textarea>
                            </div> 
                        </div>
                        <div class="form-group divlname">                         
                            <label for="lname" class="col-sm-3 control-label">Salary</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="salary" id="lname" class="form-control" id="inputEmail3" placeholder="salary">
                            </div>
                        </div>   


                        <div class="form-group">
                            <label for="branch" class="col-sm-3 control-label">Branch</label>
                            <div class="col-sm-4">
                                <select name="branch_id" class="form-control" id="branch">
                                    <?php
                                    $sql = $this->db->get('branch');
                                    if ($sql->num_rows() > 0) {
                                        foreach ($sql->result() as $row) {
                                            echo '<option value="' . $row->branch_id . '">' . $row->branch_name . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Branch</option>';
                                    }
                                    ?>

                                </select>
                            </div>

                        </div>
                        
                        <div class="form-group">
                            <label for="userfile" class="col-sm-3 control-label">Photo : </label>
                            <div class="col-sm-8">
                                    <input type="file" name="userfile" id="userfile" size="20" />
                            </div> 
                            <div class="col-sm-4">
                                <div style="width:80px;padding:5px;" id="">
                                    <img width="80" id="previewHolder">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="submit" class="btn btn-primary" >S A V E</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <div class="col-sm-12 result bg-danger">

                            </div>  
                        </div>
                    </form>
                    <!------->
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_mm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<div class="modal fade" id="barcode_fb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>


<script>

$(document).ready(function(){
    
     $("#userfile").change(function() {
                        readURL(this);
                       
                    });
    
});

 function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#previewHolder').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

    function loadEditModal(id) {
        $.ajax({
            type: 'post',
            url: '<?php echo site_url(); ?>/fb_member/edit_member',
            data: {
                id: id
            },
            success: function(data) {
                $('#edit_mm').html(data);
                $('#edit_mm').modal();
            }
        });

    }

    function search_member() {
        var st = $('#serch_text').val();
        $.ajax({
            type: 'post',
            url: '<?php echo site_url(); ?>/fb_member/search_member',
            data: {
                str: st
            },
            success: function(data) {
                $('#table_body').html(data);
            }
        });
    }
    $("form#form").submit(function() {
        var fname = $('#fname').val();
        var phone = $('#phone').val();
        var lname = $('#lname').val();
        var murchon = true;
        if (fname === '') {
            $('.divfname').addClass('has-error');
            murchon = false;
        }
        if (phone === '') {
            $('.divphone').addClass('has-error');
            murchon = false;
        }
        if (lname === '') {
            $('.divlname').addClass('has-error');
            murchon = false;
        }
        if (murchon === true) {


            var formData = new FormData($(this)[0]);

            $.ajax({
                url: '<?php echo site_url(); ?>/fb_member/add_new',
                type: 'POST',
                data: formData,
                async: false,
                success: function(data) {
                    if (data === 'ok') {
                        location.reload();
                    } else {
                        $('.result').html(data);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }
        return false;
    });

</script>
