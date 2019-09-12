<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Expenses Types</h3></p>
        <div class="row">
            <div class="col-sm-6">
                <?php 
                   echo  ' <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" > ADD NEW</button>';
                ?>
            </div>
            
        </div>
    


    <div class="row">
      <div class=" col-sm-12 well">   
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>SL.</th>
                 <th>Name</th>
                <th>Action</th>
                
            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if (!empty($results))
                $i=1;
                foreach ($results->result() as $row) {
                   
                    ?>        
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row->name; ?></td>
                         
                           <td><a class="btn btn-sm btn-warning" href="<?php echo site_url(); ?>/fb_expense/delete_expense_type/<?php echo $row->id; ?>">Delete</a></td>
                          
                           
                    </tr>  
                <?php $i++; } ?>
        </tbody>
    </table>
      </div>
    <div class="col-md-12">
       
    </div> 
    </div>     
    </div> 
 <!------->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">New Expense</h4>
                </div>
                <div class="modal-body">

                    <!------>
                    <form class="form-horizontal" id="form">
                        
                        <div class="form-group divtname" >

                            <label for="fname" class="col-sm-3 control-label">Expense Type</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" id="tname" placeholder="....." >
                            </div>

                        </div>
                        
                        


                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" id="save" onClick="return valid_save_extype();">S A V E</button>
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
</div>
 <script>



                       
                            function valid_save_extype() {
                                
                                $('#save').hide();
                                var tname = $('#tname').val();
                               
                                var murchon = true;
                                if (tname === '') {
                                    $('.divtname').addClass('has-error');
                                    murchon = false;
                                }
                               
                              
                                if (murchon === true) {
                                    post_data = $('#form').serializeArray();
                                    $.ajax({
                                        url: '<?php echo site_url(); ?>/fb_expense/add_new_exp_type',
                                        type: 'POST',
                                        data: post_data,
                                        success: function(data) {
                                            if (data === 'ok') {  
                                                         
                                                location.reload();
                                                $('#save').show();
                                            } else {
                                                $('.result').html(data);
                                                        $('#save').show();
                                            }
                                        }
                                    });


                                } else {
                                  $('#save').show(); 
                                    return false;
                                   
                                }



                            }

                            
    </script>   