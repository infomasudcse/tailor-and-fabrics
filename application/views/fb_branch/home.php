<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Branches</h3></p>
        
    </div>



    <table class="table table-hover">
        <thead>
            <tr>
                <th>Branch Name</th>  
                <th>Manager</th>
                <th>Location</th>
                <th>Phone</th>             
                <th>Action</th>

            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if ($data->num_rows() > 0){
                foreach ($data->result() as $row) {
                    ?>        
                    <tr>
                        <td><?php echo $row->branch_name ; ?></td>
                        <td><?php echo $row->manager_name; ?></td>
                           <td><?php echo $row->branch_address; ?></td>
                        <td><?php echo $row->branch_phone; ?></td>
                  
                        <td>
                            <?php if($this->session->userdata('branch_id') == 0){ ?>
                                    <span class="glyphicon glyphicon-edit" onClick=" return edit_branch_info('<?php echo $row->branch_id; ?>');" style="cursor: pointer;"></span>
                            <?php } ?>
                        </td>
                    </tr>
            <?php } }?>
        </tbody>
    </table>

  <!-------edit fb--->
    <div class="modal fade" id="edit_b" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>

    <script>
        
        function edit_branch_info(id){
             $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_branch/edit_info',
                                    data: {
                                        branch_id: id
                                    },
                                    success: function(data) {
                                        $('#edit_b').html(data);
                                        $('#edit_b').modal();
                                    }
                                });
        }
  
  
        function valid_update_branch(){
             var fname = $('#bname').val();
                                var model = $('#baddress').val();
                                var qty = $('#bphone').val();
                               
                                var murchon = true;
                                if (fname === '') {
                                    $('.divbname').addClass('has-error');
                                    murchon = false;
                                }
                                if (model === '') {
                                    $('.divbaddress').addClass('has-error');
                                    murchon = false;
                                }
                                if (qty === '') {
                                    $('.divbphone').addClass('has-error');
                                    murchon = false;
                                }
                              
                                if (murchon === true) {
                                    post_data = $('#edit_form').serializeArray();
                                    $.ajax({
                                        url: '<?php echo site_url(); ?>/fb_branch/update',
                                        type: 'POST',
                                        data: post_data,
                                        success: function(data) {
                                            if (data === 'ok') {
                                                $('#form').find("input[type=text]").val("");
                                                location.reload();
                                            } else {
                                                $('.result').html(data);
                                            }
                                        }
                                    });


                                } else {

                                    return false;
                                }



        }
                            
    </script>
