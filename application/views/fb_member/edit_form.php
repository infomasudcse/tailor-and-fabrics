

<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Member</h4>
                </div>
                <div class="modal-body">
                      
                    <!------>
                    <form class="form-horizontal" id="edit_mem_form" >
                        
                        <input type="hidden" name="id" value="<?php echo $member->id;?>">
                        <div class="form-group divfname" >
                            <label for="fname" class="col-sm-3 control-label">Full Name</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="fname" class="form-control" id="fname" value="<?php echo $member->full_name; ?>" focus>
                            </div> 


                        </div>

                        <div class="form-group divphone">
                            <label for="phone" class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $member->contact; ?>">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <textarea id="address" name="address" class="form-control" placeholder="address"><?php echo $member->address; ?> </textarea>
                            </div> 

                        </div>
                        <div class="form-group divlname">                         
                            <label for="lname" class="col-sm-3 control-label">Salary</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="salary" id="lname" class="form-control" id="inputEmail3" value="<?php echo $member->salary; ?>">
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
                            <label for="address" class="col-sm-3 control-label">Comments</label>
                            <div class="col-sm-9">
                                <textarea id="address" name="comments" class="form-control" placeholder="comments"><?php echo $member->comments; ?></textarea>
                            </div> 

                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" onClick="return valid_mem_update();">Update</button>
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


<script>
    
    function valid_mem_update(){
        
        post_data = $('#edit_mem_form').serializeArray();
                                    $.ajax({
                                        url: '<?php echo site_url(); ?>/fb_member/update_mm',
                                        type: 'POST',
                                        data: post_data,
                                        success: function(data) {
                                            if (data === 'ok') {
                                                location.reload();
                                            } else {
                                                $('.result').html(data);
                                            }
                                        }
                                    });
        
        
        
        
        
    }
    
    
</script>    