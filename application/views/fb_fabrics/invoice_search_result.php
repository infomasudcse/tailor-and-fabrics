<?php

foreach ($result->result() as $row) {
            $this->db->where('branch_id', $row->branch_id);
            $sql2 = $this->db->get('branch');
            if ($sql2->num_rows() == 1) {
                $branch = $sql2->row()->branch_name;
            } else {
                $branch = 'Undefine';
            }
            $this->db->where('person_id', $row->customer_id);
            $sql = $this->db->get('people');
            if ($sql->num_rows() == 1) {
                $customer = $sql->row()->first_name . " " . $sql->row()->last_name."<br/>".$sql->row()->phone_number;
            } else {
                $customer = 'not found';
            }
            $link = base_url() . 'invoices/' . $row->invoice . '.pdf';

           if($row->status == 0){$sts = 'Due : '.$row->due.'/-';}else{ $sts= "full paid";}

           
                if ($row->status == 1) {
                    $action = '<a class="btn btn-xs btn-warning" href="' . base_url() . 'invoices/' . $row->receipt . '.pdf' . '" target="_blank">Receipt</a>';
                } else {
                    
                    $action = "<span class='btn btn-xs btn-primary delivery' data-id='".$row->invoice."'>Add payment / Delivery</span>";
                }
            
            
            echo " <tr class='bg-success'>
                        <td>" . $row->invoice . "</td>
                        <td>" . $row->order_date . "</td>
                        <td>" . $row->del_date . "</td>
                        <td>" . $customer . "</td>
                        <td>" . $sts . "</td>
                        <td>".$branch."</td>
                        <td>
                            <a href='" . $link . "' class='btn btn-success btn-xs' target='_blank'>Download</a>
                            " . $action . "   
                            
                        </td>
                    </tr>";
        }
?>
 <!-------edit fb--->
    <div class="modal fade" id="delivery_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>

    <!------------edit end----->



<script>
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
</script>
