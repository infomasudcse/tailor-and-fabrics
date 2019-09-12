<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Branch Member</h3></p>
        <div class="row">
         <!--   <div class="col-sm-6">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" > ADD NEW</button>
            </div>
            <div class="col-sm-6">
                <div class="input-group pull-right">
                    <input type="text" id="serch_text" class="form-control" placeholder="name or phone...">
                    <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return serch_customer();" type="button">Go!</button>
                    </span>
                </div>
            </div>-->
        </div>
    </div>


    <div class="col-sm-5">
        <h3>Members</h3>
    <table class="table table-hover">
        <thead>
            <tr class="bg-info">  
                     <th>Photo</th>
                <th>Full Name</th>              
                <th>Phone</th>               
           
            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if (!empty($results))
                foreach ($results->result() as $row) {
                    ?>        
                    <tr>
                       <td><?php if($row->photo != ''){echo '<img src="'.base_url().'uploads/members/'.$row->photo.'" width="70">';}else{ echo " -- ";} ?></td>
                                         
                        <td><span title="<?php echo $row->branch_name.'. <br/>'.$row->comments; ?>"><?php echo $row->full_name; ?></span></td>
                       
                        <td><?php echo $row->contact; ?></td>
                       
                       
                        
                    </tr>
                <?php } ?>
        </tbody>
    </table>

   
        <p><?php echo $links; ?></p>
    </div> 

    <!------->
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6"><h3>Attendance <?php echo date('D, j - M');?></h3></div>
            <div class="col-sm-6">
                <br/>
                <form action="<?php echo site_url();?>/fb_member/branch_member" method="post">
                <div class="input-group pull-right <?php echo ($error != '')? 'has-error': 'has-info'?>">
                    <input type="text" name="mm_code" id="mm_code" class="form-control" placeholder="...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary"  type="submit">Go!</button>
                    </span>
                </div>
                </form>
            </div>
            <div class="col-sm-12">
                <?php if($error != ''){ 
                    echo $error;
                }
                ?>
            </div>
            <div class="col-sm-12">
             <table class="table table-hover">
                <thead>
                    <tr class="bg-success">                
                        <th>Full Name</th>              
                        <th> IN</th>               
                        <th>OUT</th>
                    </tr>        
                </thead>
                <tbody id="table_body">
                       <?php 
                              
                       if($attendance->num_rows() > 0){
                                  foreach($attendance->result() as $attrow){
                                   
                                     $member =  $this->fb_member_model->getMember($attrow->member_id);
                                     echo '<tr>
                                                <td>'.$member->full_name.'</td>
                                                <td>'. date(" G:i:s ", strtotime($attrow->day_in)).'</td>
                                                <td>'. date(" G:i:s ", strtotime($attrow->day_out)).'</td>
                                            </tr>';
                                  }
                              }else{
                                  echo '<tr><td colspan="3">No attendance Yet !</td></tr>';
                              }  
                       
                       ?> 
                </tbody>
             </table>
            </div>           
            
            
        </div>
    </div>
</div>
    



    <script>

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

                            function serch_customer() {
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
                            function valid_save_member() {
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
                                    post_data = $('#form').serializeArray();
                                    $.ajax({
                                        url: '<?php echo site_url(); ?>/fb_member/add_new',
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


                                } else {

                                    return false;
                                }



                            }

    </script>
