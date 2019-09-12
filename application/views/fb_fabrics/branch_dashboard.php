<?php
$this->db->where('branch_id', $this->session->userdata('branch_id'));
$query = $this->db->get('branch');
if ($query->num_rows() == 1) {
    $branch = $query->row();
} else {
    $branch = '';
}
$this->db->where('branch_id', $this->session->userdata('branch_id'));
$this->db->where('del_date', date('y-m-d'));
$querytwo = $this->db->get('fb_order');
?>
<h2 class="text-center borderbottom2">Welcome :: <?php echo ($branch != '') ? $branch->branch_name : 'Undefine !'; ?></h2>
<div class="row">
    <div class="col-sm-12">
        <p class="text-right"><span class="label label-warning" style="font-size:26px;">Date : <?php echo date('d-m-Y'); ?></span></p>
    </div>
    <div class="col-sm-12">
       
        <div class="panel panel-danger">

            <div class="panel-heading">
                <h5><strong>Today Delivery</strong> :: Below orders need to delivery today. </h5>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr class="bg-primary">
                            <th>Order Date</th>
                            <th>Invoice</th>                       
                            <th>Items</th>
                            <th>Fabrics Cost</th>
                            <th>Tailor Cost</th>
                            <th>Total</th>
                            <th>Payments</th>
                            <th>Due</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if($querytwo->num_rows() > 0){
                                foreach($querytwo->result() as $row){
                        ?>
                         <tr>
                              <td><?php echo $row->order_date; ?></td>
                              <td><?php echo $row->invoice; ?></td>
                              <td><?php echo 'Order item: '.$row->tot_item.'<br/>Remain Item: '.$row->re_item; ?></td>
                              <td><?php echo $row->tot_fabrics; ?></td>
                              <td><?php echo $row->tot_tailor_cost; ?></td>
                              <td><?php echo $row->tot_fabrics + $row->tot_tailor_cost; ?></td>
                              <td><?php echo $row->payment; ?></td>
                              <td><?php echo $row->due; ?></td>
                                   
                               </tr>
                        
                            <?php  } } else{
                                echo "<tr><td colspan='8'><div class='alert alert-info'>There is no Delivery by Today !</div></td></tr>";
                            }?>
                    </tbody>
                    
                </table>

            </div>
        </div>
    </div>
    
    <!----->
    
   

</div>
