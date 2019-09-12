<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Employees</h3></p>
        
    </div>



    <table class="table table-hover">
        <thead>
            <tr class="bg-info">
                <th>Employee Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                 <th>Branch</th>
                  <th>Username</th>
                <th>Action</th>

            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if (!empty($results)){
                foreach ($results->result() as $row) {
                    ?>        
                    <tr>
                        <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->phone_number; ?></td>
                        <td><?php echo $row->address_1.'<br/>'.$row->address_2; ?></td>
                          <td>
                              
                              <?php 
                              
                              $this->db->where('branch_id', $row->branch_id);
                              $sql = $this->db->get('branch');
                              if($sql->num_rows() == 1){
                                  echo $sql->row()->branch_name; 
                              }
                              ?>
                          
                          
                          </td>
                            <td><?php echo $row->username; ?></td>
                        <td>
                            <?php if($this->session->userdata('branch_id') == 0){ ?>
                            <span class="glyphicon glyphicon-edit"></span>
                            <?php } ?>
                        </td>
                    </tr>
            <?php } }?>
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
                    <h4 class="modal-title" id="myModalLabel">New Customer</h4>
                </div>
                <div class="modal-body">

                    <!------>
                    <form class="form-horizontal" id="form">
                        <div class="form-group divfname" >
                            <label for="fname" class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="fname" class="form-control" id="fname" placeholder="first name" focus>
                            </div> 


                        </div>
                        <div class="form-group divlname" >

                            <label for="lname" class="col-sm-3 control-label">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="lname" class="form-control" id="lname" placeholder="last name" focus>
                            </div>

                        </div>
                        <div class="form-group divphone">
                            <label for="phone" class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9 has-warning">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="phone">
                            </div>

                        </div>
                        <div class="form-group">                         
                            <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <textarea id="address" name="address" class="form-control" placeholder="address"> </textarea>
                            </div> 

                        </div>
                        <div class="form-group">
                            <label for="comments" class="col-sm-3 control-label">Size</label>
                            <div class="col-sm-9">
                                <textarea id="address" name="comment" class="form-control" placeholder="size..."> </textarea>
                            </div> 

                        </div>
                        <div class="form-group">
                            <label for="zip" class="col-sm-2 control-label">Zip</label>
                            <div class="col-sm-4">
                                <input type="text" name="zip" class="form-control" id="zip" placeholder="zip">
                            </div>
                            <label for="state" class="col-sm-2 control-label">State</label>
                            <div class="col-sm-4">
                                <input type="text" name="state" class="form-control" id="state" placeholder="state">
                            </div>
                        </div>
                        <div class="form-group divcity">
                            <label for="city" class="col-sm-2 control-label">City</label>
                            <div class="col-sm-4 has-warning">
                                <input type="text" name="city" class="form-control" id="city" placeholder="city">
                            </div>
                            <label for="country" class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-4">
                                <input type="text" name="country" class="form-control" id="country" value="Bangladesh">
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
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" onClick="return valid_save_cust();">S A V E</button>
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

    <script>

  

   function serch_customer() {
         var st = $('#serch_text').val();
          $.ajax({
                  type: 'post',
                 url: '<?php echo site_url(); ?>/fb_customer/search_customer',
                  data: {
                          str: st
                         },
                  success: function(data) {
                          $('#table_body').html(data);  
                    }
                });
      }
                              function valid_save_cust() {
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
                                          url: '<?php echo site_url(); ?>/fb_customer/add_new',
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
