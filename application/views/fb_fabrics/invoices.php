<div class="row">
    <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Invoices</h3></p>
        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <div class="input-group pull-right">
                    <input type="text" id="serch_text" class="form-control" placeholder="invoice or phone....">
                    <span class="input-group-btn">
                        <button class="btn btn-info" onClick="return serch_invoice();" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <table class="table table-hover">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Order Date</th>
                <th>Delivery</th>
                <th>Customer</th>
                <th>Payment status</th>
                  <th>Branch</th>
                <th>Options</th>


            </tr>        
        </thead>
        <tbody id="table_body">
            <?php
            if (!empty($results))
                foreach ($results->result() as $row) {
                    ?>        
                    <tr class="">
                        <td><?php echo $row->invoice; ?></td>
                        <td><?php echo $row->order_date; ?></td>
                        <td><?php echo $row->del_date; ?></td>
                        <td><?php
                            $this->db->where('person_id', $row->customer_id);
                            $sql = $this->db->get('people');
                            if ($sql->num_rows() == 1) {
                                echo $sql->row()->first_name . ' ' . $sql->row()->last_name . '<br/>' . $sql->row()->phone_number;
                            } else {
                                echo 'not found';
                            }
                            ?></td>
                        <td><?php if ($row->status == 0) {
                                echo 'Due : '.$row->due.'/-';
                            } else {
                                echo 'full paid';
                            } ?></td>
                             <td>
                            <?php 
                                 $this->db->where('branch_id', $row->branch_id);
                                  $sql2 = $this->db->get('branch');
                                  echo ($sql2->num_rows() ==1)? $sql2->row()->branch_name : 'Undefine';
                            ?>
                        </td>  
                        <td>
                            <a href="<?php echo base_url() . 'invoices/' . $row->invoice . '.pdf'; ?>" class='btn btn-success btn-xs' target='_blank'>Invoice</a>
                            <?php if($row->status == 0){ ?>
                            <span class="btn btn-xs btn-primary delivery" data-id="<?php echo $row->invoice; ?>" >Add payment / Delivery</span>
                         
                            <?php  } if($row->receipt != '' && $row->status == 1){ ?>
                            <a class="btn btn-xs btn-warning" href="<?php echo base_url() . 'invoices/' . $row->receipt . '.pdf'; ?>" class="" target="_blank">Receipt</a>
                            <?php } ?>
                       </td>
                    </tr>
    <?php } ?>
        </tbody>
    </table>

    <div class="col-md-12">
        <p class='pagination'><?php echo $links; ?></p>
    </div> 

    <!-------edit fb--->
    <div class="modal fade" id="delivery_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>

    <!------------edit end----->

    <script>



                            function serch_invoice() {
                                var st = $('#serch_text').val();
                                if(st !==''){
                                $.ajax({
                                    type: 'post',
                                    url: '<?php echo site_url(); ?>/fb_fabrics/search_invoice',
                                    data: {
                                        str: st
                                    },
                                    success: function(data) {
                                 $('#table_body').empty();
                                        $('#table_body').html(data);
                                        $('.pagination').hide();
                                    }
                                });
                                }else{
                                alert('Nothing to search ! ');
                                }
                            }
                           
                           





    </script>
