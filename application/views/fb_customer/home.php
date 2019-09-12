<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Customers</h3></p>
        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" > ADD NEW</button>
            </div>
            <div class="col-sm-6">
                <div class="input-group pull-right">
                    <input type="text" id="serch_text" class="form-control" placeholder="name or phone...">
                    <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return serch_customer();" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <table class="table table-hover">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Size</th>
                <th>Phone</th>
                <th>Zip, City</th>
                <th>Card</th>
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
                        <td><?php echo $row->comments; ?></td>
                        <td><?php echo $row->phone_number; ?></td>
                        <td><?php echo $row->zip . ', ' . $row->city; ?></td>
                        <td>
                            
                            <?php
                            $this->db->where('person_id', $row->person_id);
                            $this->db->where('deleted', 0);
                            $sqll = $this->db->get('fb_card');
                            if($sqll->num_rows() == 1){
                              echo substr($sqll->row()->card_number, 0,8).'.......'; 
                            }else{
                                
                                echo  '<span class="btn btn-xs btn-info" onClick="return assign_card('.$row->person_id.')">assign card</span>';
                               
                            }
                                ?>
                        </td>
                        
                        <td>
                            <?php if($this->session->userdata('branch_id') != 0){ ?>
                            <a class="btn btn-primary btn-xs" href="<?php echo site_url().'/fb_new_order/index/'.$row->person_id; ?>" >Order</a>
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

    <div class="modal fade" id="myCardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Assign Card To Customer</h4>
                </div>
                <div class="modal-body">

                    <!------>
                    <form class="form-horizontal" id="cardform">
                       
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


function assign_card(customer_id){

   /* alert(customer_id);*/
    /*load modal form*/
     $.ajax({
                                          url: '<?php echo site_url(); ?>/fb_card/card_assign_form',
                                          type: 'POST',
                                          data: {customer_id: customer_id},
                                          success: function(data) {
                                      
                                            $('#cardform').html(data);
                                              $('#myCardModal').modal();
                                          }
                                      });
    
}


function valid_assign_card(){
     var cardnum = $('#cardnum').val();
                                 
                                  var murchon = true;
                                  if (cardnum === '') {
                                      $('.divcardnum').addClass('has-error');
                                      murchon = false;
                                  }
                                 
                                  if (murchon === true) {
                                      post_cdata = $('#cardform').serializeArray();
                                      $.ajax({
                                          url: '<?php echo site_url(); ?>/fb_card/card_assign',
                                          type: 'POST',
                                          data: post_cdata,
                                          success: function(data) {
                                              if (data === 'ok') {
                                                  location.reload();
                                              } else {
                                                  $('.crdresult').html(data);
                                              }
                                          }
                                      });


                                  } else {

                                      return false;
                                  }



}




    </script>
