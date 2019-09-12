<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Customer Cards</h3></p>
        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" > ADD NEW</button>
            </div>
            <div class="col-sm-6">
                <div class="input-group pull-right">
                    <input type="text" id="serch_text" class="form-control" placeholder="knzc.....">
                    <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return serch_card();" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <table class="table table-hover">
        <thead>
            <tr class="bg-info">
                <th>Card Number</th>
                <th>Type</th>
                <th>Disq %</th>
                <th>Status</th>
                <th>Action</th>
            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if (!empty($results)){
                foreach ($results->result() as $row) {
                    ?>        
                    <tr>
                        <td><?php echo $row->card_number;?></td>
                        <td><?php echo $row->type;?></td>
                        <td><?php echo $row->disq.' % ';?></td>
                        <td><?php echo ($row->status == 1)? '<span class="label label-success">Active</span>': '<span class="label label-warning">Unactive</span>';?></td>
                        <td>
                            <?php if($this->session->userdata('branch_id') == 0){ ?>
                              <span class="glyphicon glyphicon-remove" style="cursor:pointer;" onClick="return delete_card('<?php echo $row->id; ?>')"></span>
                          
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
                    <h4 class="modal-title" id="myModalLabel">New Card</h4>
                </div>
                <div class="modal-body">

                    <!------>
                    <form class="form-horizontal" id="form">
                        <div class="form-group">
                            <label for="branch" class="col-sm-3 control-label">Card Type</label>
                            <div class="col-sm-4" id="divcard">
                                <select name="type" class="form-control" id="newcard">
                                    <option value="silver">Silver (5%)</option>
                                     <option value="gold">Gold (10%)</option>
                                      <option value="diamond">Diamond (15%)</option>
                                </select>
                            </div>

                        </div>
                         <div class="form-group divlname" >

                            <label for="lname" class="col-sm-3 control-label">Expire</label>
                            <div class="col-sm-9">
                                <input type="text" name="exp" class="form-control" id="datepicker" placeholder="" focus>
                            </div>

                        </div>
                       


                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="button" class="btn btn-primary" onClick="return save_card_data();">Create Card</button>
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

  

   function serch_card() {
         var str = $('#serch_text').val();
        
          $.ajax({
                  type: 'post',
                 url: '<?php echo site_url(); ?>/fb_card/search_card',
                  data: {
                          str: str
                         },
                  success: function(data) {
                          $('#table_body').html(data);  
                    }
                });
      }
                              function save_card_data() {
                                  var newcard = $('#newcard').val();
                                  var exp = $('#datepicker').val();
                                  var murchon = true;
                                  if (newcard === '') {
                                      $('.divcard').addClass('has-error');
                                      murchon = false;
                                  }
                                   if (exp === '') {
                                      $('.divlname').addClass('has-error');
                                      murchon = false;
                                  }
                                  if (murchon === true) {
                                      post_data = $('#form').serializeArray();
                                      $.ajax({
                                          url: '<?php echo site_url(); ?>/fb_card/add_new',
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
                              
                              
       function delete_card(card_id){
                if(card_id === ''){
                    return false;
                }else{
                    var chk = confirm("Are You Sure To DO This Action ? ");
                if (chk)
                {
                    $.ajax({
                        url: '<?php echo site_url(); ?>/fb_card/delete_card',
                                          type: 'POST',
                                          data: {card_id:card_id},
                                          success: function(data) {
                                              if (data === 'ok') {
                                                  location.reload();
                                              } else {
                                                  alert('can not delete !');
                                              }
                                          }
                    });
                }
                else {
                    return false;
                }
       }
       
       
       }                       
                              

    </script>
