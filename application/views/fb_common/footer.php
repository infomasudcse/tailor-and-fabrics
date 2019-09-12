 </div>
            <?php
            $message = $this->session->userdata('message');
            if ($message != '') {
                ?>
                <div class="" id="notify">
                    <div class=" col-md-10 bottom-alert alert  alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $message; ?>
                    </div>
                </div>
<?php } $this->session->unset_userdata('message'); ?>

 <div style="position:fixed;bottom:0;right:0;height:95px;width:150px;z-index:10101010;border-radius:10px;background-color:#ffffff;color:#00ff00;font-weight:bold;">
     <p style="color:#ffffff;background-color:#ff0000;font-size:18px;" align='center'>Company</p>
     <ul>
         <li>
                            <?php
                            $this->db->where('branch_id', $this->session->userdata('branch_id'));
                            $sql = $this->db->get('branch');
                            echo ($sql->num_rows() == 1) ? $sql->row()->branch_name : '<span style="color:red;">Office</span>';
                            ?>
         </li>
     <li class="text-danger">
                            <?php 
                                $this->db->where('person_id', $this->session->userdata('person_id'));
                                $query = $this->db->get('people');
                                if($query->num_rows() == 1 ){
                                    echo $query->row()->first_name;
                                }else{
                                  echo  'Undefine!' ;
                                }
                            
                            ?>
                        </li>
                        <li class="">
                            <?php 
                                echo date('Y-m-d');
                            ?>
                        </li>
     </ul>
     
     
 </div>


        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
       <!-- Custom styles for this template -->
       
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
 <script src="<?php echo base_url(); ?>js/jquery.validate.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
       
         

        <script>
            $(function() {
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
            function checkAction() {
                var chk = confirm("Are You Sure To DO This Action ? ");
                if (chk)
                {
                    return true;
                }
                else {
                    return false;
                }
            }
            $(document).ready(function() {
                $('#notify').delay(5000).fadeOut('slow');
            });

            function coderHakan()
            {
                var sayfa = window.open('', '', 'width=800,height=600');
                sayfa.document.open("text/html");
                sayfa.document.write(document.getElementById('printing_div').innerHTML);
                sayfa.document.close();
                sayfa.print();
            }
            
            function popup_print() {
                var myStyle = '<link href="<?php echo base_url(); ?>css/bootstrap.min_1.css" rel="stylesheet" type="text/css" />';

                w = window.open(null, 'Print_Page', 'scrollbars=yes');
                w.document.write(myStyle + jQuery('#print_div').html());
                w.document.close();
                w.print();
            }
            




                            function serch_fabrics() {
                                var st = $('#serch_text').val();
                                $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/search_fabrics',
                                    data: {
                                        str: st
                                    },
                                    success: function(data) {
                                        $('#table_body').html('');                            
                                        $('#table_body').html(data);
                                    }
                                });
                            }
                            function valid_save() {
                                var fname = $('#fname').val();
                                var model = $('#model').val();
                                var qty = $('#qty').val();
                                var sellprice = $('#sellprice').val();
                                var unitprice = $('#unitprice').val();
                                var murchon = true;
                                if (fname === '') {
                                    $('.divfname').addClass('has-error');
                                    murchon = false;
                                }
                                if (model === '') {
                                    $('.divmodel').addClass('has-error');
                                    murchon = false;
                                }
                                if (qty === '') {
                                    $('.divqty').addClass('has-error');
                                    murchon = false;
                                }
                                if (sellprice === '') {
                                    $('.divsellprice').addClass('has-error');
                                    murchon = false;
                                }
                                if (unitprice === '') {
                                    $('.divunitprice').addClass('has-error');
                                    murchon = false;
                                }
                                if (murchon === true) {
                                    post_data = $('#form').serializeArray();
                                    $.ajax({
                                        url: '<?php echo site_url(); ?>/fb_fabrics/add_new',
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

                            function editfb(id){
                            
                                
                                $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/edit_fabric',
                                    data: {
                                        product_id: id
                                    },
                                    success: function(data) {
                                        $('#edit_fb').html(data);
                                        $('#edit_fb').modal();
                                    }
                                });
                            }

                            function deletefb(id){
                               
                                $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/delete_fabric',
                                    data: {
                                        product_id: id
                                    },
                                    success: function(data) {
                                        if (data === 'done') {
                                            location.reload();
                                        }else{
                                            alert(data);
                                        }
                                    }
                                });
                            }

                           function transferfb(id) {
                               
                                $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/transfer_fabric',
                                    data: {
                                        product_id: id
                                    },
                                    success: function(data) {
                                        $('#trans_fb').html(data);
                                        $('#trans_fb').modal();
                                    }
                                });
                            }

                            function valid_update() {

                                post_data = $('#edit_form').serializeArray();
                                $.ajax({
                                    url: '<?php echo site_url(); ?>/fb_fabrics/update_fabrics',
                                    type: 'POST',
                                    data: post_data,
                                    success: function(data) {
                                        if (data === 'ok') {
                                            $('#form').find("input[type=text]").val("");
                                            location.reload();
                                        } else {
                                            $('.edit_error').html(data);
                                        }
                                    }
                                });


                            }

                            function valid_transfer() {
                               
                                
                                var trqty = $('#trqty').val();
                                
                                var trbranch = $('#trbranch').val();
                                var murchon = true;
                                if (trqty === '') {
                                    $('.divtrqty').addClass('has-error');
                                    murchon = false;
                                }
                                if (trbranch === '') {
                                    $('.divtrbranch').addClass('has-error');
                                    murchon = false;
                                }
                                
                                if (murchon === true) {
                                    post_data = $('#trans_form').serializeArray();
                                    $.ajax({
                                        url: '<?php echo site_url(); ?>/fb_fabrics/transfer_to_branch',
                                        type: 'POST',
                                        data: post_data,
                                        success: function(data) {
                                            if (data === 'ok') {

                                                location.reload();
                                            } else {
                                                $('.trans_error').html(data);
                                            }
                                        }
                                    });


                                }
                                else {
                                    return false;
                                }
                            }
$('.delivery').click(function(){
   var invoice =  $(this).attr('data-id');
   
                                if(invoice !== ''){
                                $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/order_delivery',
                                    data: {
                                        invoice: invoice
                                    },
                                    success: function(data) {
                                        $('#delivery_mod').html(data);
                                        $('#delivery_mod').modal();
                                    }
                                });
                                }else{
                                    return false;
                                }
                            });
                            
 function valid_delivery(balance){
  var pay = $('#balance').val(); 
  
    if(pay === balance){
        post_data = $('#delform').serializeArray();
         $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/make_delivery',
                                    data: 
                                        post_data
                                    ,
                                    success: function(data) {
                                        if(data === 'ok'){
                                             location.reload();
                                        }else{
                                             $('.result').html(data);
                                           
                                        }
                                    }
                                });
  }else{
    $('.result').html('Balance Must be same as Due !');
    $('.bldiv').addClass('has-error');
    return false;
  } 
 }

function valid_payment(){
     var pay = $('#balance').val(); 
     var item = $('#delv_item').val();
     if(pay > 0.00){
          post_data = $('#delform').serializeArray();
         $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/add_payment',
                                    data: 
                                        post_data
                                    ,
                                    success: function(data) {
                                       if(data === 'ok'){
                                             location.reload();
                                        }else{
                                             $('.result').html(data);
                                               $('.dldiv').addClass('has-error'); 
                                        }
                                    }
                                });
         
     }else{
          $('.result').html('No Payment added !');
          $('.bldiv').addClass('has-error'); 
          return false;
     }

}


function dissmiss_sell_process(){
 $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_new_order/dissmiss_order',
                                    
                                    success: function(data) {
                                       if(data === 'ok'){
                                             location.reload();
                                        }
                                    }
                                });

}


        </script>
        
    
      
    </body>
</html>