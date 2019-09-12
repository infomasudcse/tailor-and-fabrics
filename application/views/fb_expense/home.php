<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Expenses</h3></p>
        <div class="row">
            <div class="col-sm-6">
                <?php 
                   echo  ' <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" > ADD NEW</button>';
                ?>
            </div>
            
        </div>
    </div>
    
    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">All</a></li>
          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Today</a></li>
          
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="home">
                     <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>SL.</th>
                                     <th>Date</th>
                                    <th>Expense</th>
                                    <th>Amount</th>
                                    <th>Branch</th>

                                </tr>        
                            </thead>
                            <tbody id="table_body">
                                <?php
                                if (!empty($results)){
                                    $i=1;
                                    foreach ($results->result() as $row) {
                                       
                                        ?>        
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->expdate; ?></td>
                                             <td><?php echo $row->name; ?></td>
                                              <td><?php echo $row->cost; ?></td>
                                               <td><?php echo $row->branch_name; ?></td>


                                        </tr>  
                                <?php $i++;  }}else{
                                        echo '<tr><td colspan="5"><div class="alert alert-danger">Nothing to Display! </div></td></tr>';
                                    } ?>
                            </tbody>
                        </table>

                <p>
                    <?php echo $links;?>
                </p>
                
            </div>
            <div role="tabpanel" class="tab-pane fade" id="profile">
                     
                <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>SL.</th>
                                     <th>Date</th>
                                    <th>Expense</th>
                                    <th>Amount</th>
                                    <th>Branch</th>

                                </tr>        
                            </thead>
                            <tbody id="table_body">
                                <?php
                                if (!empty($results)){
                                    $i=1;
                                    foreach ($results->result() as $row) {
                                        if( $row->expdate == date('Y-m-d')){
                                        ?>        
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->expdate; ?></td>
                                             <td><?php echo $row->name; ?></td>
                                              <td><?php echo $row->cost; ?></td>
                                               <td><?php echo $row->branch_name; ?></td>


                                        </tr>  
                                <?php $i++; } } } ?>
                            </tbody>
                        </table>

                
                
                 
            </div>
           
          </div>

      </div>


  
    <div class="col-md-12">
       
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
                        <div class="form-group divtypeid" >
                            <label for="model" class="col-sm-3 control-label">Expense Type</label>
                            <div class="col-sm-9 ">
                                 <select class="form-control" name="expense_type_id" id="typeid">
                                     
                                <option value="">Select</option>                        
                             <?php   $sql = $this->db->get('fb_expense_type');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                      if($row->branch_id != 1){
                                          echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                      }
                                  }
                                  }
                                  ?>
                            </select>
                            
                            </div> 


                        </div>
                        <div class="form-group divamount" >

                            <label for="fname" class="col-sm-3 control-label">Amount (BDT.)</label>
                            <div class="col-sm-9">
                                <input type="text" name="amount" class="form-control" id="amount" placeholder="0.00" >
                            </div>

                        </div>
                        
                        


                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" id="save" onClick="return valid_exp_save();">S A V E</button>
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



                       
                            function valid_exp_save() {
                                
                                $('#save').hide();
                                var type = $('#typeid').val();
                                var amount = $('#amount').val();
                                
                                var murchon = true;
                                if (type === '') {
                                    $('.divtypeid').addClass('has-error');
                                    murchon = false;
                                }
                                if (amount === '') {
                                    $('.divamount').addClass('has-error');
                                    murchon = false;
                                }
                              
                                if (murchon === true) {
                                    post_data = $('#form').serializeArray();
                                    $.ajax({
                                        url: '<?php echo site_url(); ?>/fb_expense/add_new_exp',
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