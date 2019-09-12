<style>
    .sum_num{color:red;padding-left:10px; }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{color:#fff;background-color:#050;}</style>
<?php
$this->db->where('person_id', $this->session->userdata('person_id'));
$query = $this->db->get('people');
if ($query->num_rows() == 1) {
    $admin = $query->row()->first_name . ' ' . $query->row()->last_name;
} else {
    $admin = '';
}
/* orders */
$this->db->where('order_date', date('y-m-d'));
$querythree = $this->db->get('fb_order');
/* branches */
$querytwo = $this->db->get('branch');

/* delivery */
$this->db->from('fb_delivery');
$this->db->where('fb_delivery.delivery_date', date('y-m-d'));
$this->db->join('fb_order', 'fb_delivery.invoice=fb_order.invoice');
$queryfour = $this->db->get();

/* expenses */
$this->db->where('fb_expense.expdate', date('y-m-d'));
$this->db->join('fb_expense_type', 'fb_expense.expense_type_id=fb_expense_type.id');
$queryfive = $this->db->get('fb_expense');

$this->db->from('fb_order');
$querysix = $this->db->get();

$this->db->from('fb_expense');
$queryseven = $this->db->get();

$this->db->from('fb_payment');
$queryeight = $this->db->get();

$this->db->from('fabrics');
$querynine = $this->db->get();
?>

<h2 class="text-center borderbottom2">Welcome :: <?php echo $admin; ?></h2>
<div class="row">
    <div class="col-sm-12">
        <p class="text-right"><span class="label label-danger" style="font-size:26px;">Date : <?php echo date('d-m-Y'); ?></span></p>
    </div>
    <div class="col-sm-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h5><strong>Today : Orders</strong></h5>
            </div>
            <div class="panel-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $i = 2;
                        if ($querytwo->num_rows() > 0) {
                            foreach ($querytwo->result() as $row) {
                                if ($row->branch_id > 1) {
                                    ?>
                                    <li role="presentation" class="<?php echo ($i == 2) ? 'active' : ''; ?>"><a href="#<?php echo $row->branch_name; ?>" aria-controls="<?php echo $row->branch_name; ?>" role="tab" data-toggle="tab"><?php echo $row->branch_name; ?></a></li>

                                    <?php
                                    $i++;
                                }
                            }
                        }
                        ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php
                        $j = 2;
                        if ($querytwo->num_rows() > 0) {
                            foreach ($querytwo->result() as $row) {
                                if ($row->branch_id > 1) {
                                    ?>
                                    <div role="tabpanel" class="tab-pane <?php echo ($j == 2) ? 'active' : ''; ?>" id="<?php echo $row->branch_name; ?>">
                                        <table class="table">
                                            <thead>
                                                <tr class="bg-info">
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
                                                $tot_fb = 0.00;
                                                $tot_tailor = 0.00;
                                                $tot_due = 0.00;
                                                $tot_payment = 0.00;
                                                $totpay = 0.00;
                                                if ($querythree->num_rows() > 0) {
                                                    foreach ($querythree->result() as $orrow) {
                                                        if ($orrow->branch_id == $row->branch_id) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $orrow->order_date; ?></td>
                                                                <td><?php echo $orrow->invoice; ?></td>
                                                                <td><?php echo 'Order item: ' . $orrow->tot_item . '<br/>Remain Item: ' . $orrow->re_item; ?></td>
                                                                <td><?php echo $orrow->tot_fabrics; ?></td>
                                                                <td><?php echo $orrow->tot_tailor_cost; ?></td>
                                                                <td><?php echo $orrow->tot_fabrics + $orrow->tot_tailor_cost; ?></td>
                                                                <td><?php echo $orrow->payment; ?></td>
                                                                <td><?php echo $orrow->due; ?></td>

                                                            </tr>

                                                            <?php
                                                            $tot_fb += $orrow->tot_fabrics;
                                                            $tot_tailor += $orrow->tot_tailor_cost;
                                                            $tot_due += $orrow->due;
                                                            $tot_payment += $orrow->payment;
                                                            $totpay = $tot_fb + $tot_tailor;
                                                            ?>



                                                            <?php
                                                        }
                                                    }
                                                    echo '<tr class="bg-warning"><td></td><td></td><td></td>
                                                                    <td><b>' . $tot_fb . '</b></td>
                                                                     <td><b>' . $tot_tailor . '</b></td>
                                                                      <td><b>' . $totpay . '</b></td>
                                                                       <td><b>' . $tot_payment . '</b></td>
                                                                        <td><b>' . $tot_due . '</b></td>
                                                                         </tr>';
                                                } else {
                                                    echo "<tr><td colspan='8'><div class='alert alert-info'>There is no Order by Today !</div></td></tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>




                                    </div>
                                    <?php
                                    $j++;
                                }
                            }
                        }
                        ?>       
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h5><strong>Delivery Done by Today</strong></h5>
            </div>
            <div class="panel-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $i = 2;
                        if ($querytwo->num_rows() > 0) {
                            foreach ($querytwo->result() as $row) {
                                if ($row->branch_id > 1) {
                                    ?>
                                    <li role="presentation" class="<?php echo ($i == 2) ? 'active' : ''; ?>"><a href="#<?php echo $row->branch_name . 'del'; ?>" aria-controls="<?php echo $row->branch_name . 'del'; ?>" role="tab" data-toggle="tab"><?php echo $row->branch_name; ?></a></li>

                                    <?php
                                    $i++;
                                }
                            }
                        }
                        ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php
                        $j = 2;
                        if ($querytwo->num_rows() > 0) {
                            foreach ($querytwo->result() as $row) {
                                if ($row->branch_id > 1) {
                                    ?>
                                    <div role="tabpanel" class="tab-pane <?php echo ($j == 2) ? 'active' : ''; ?>" id="<?php echo $row->branch_name . 'del'; ?>">
                                        <table class="table">
                                            <thead>
                                                <tr class="bg-success">
                                                    <th>Order Date</th>
                                                    <th>Origin.Del.</th>
                                                    <th>Invoice</th> 
                                                    <th>Fabrics Cost</th>
                                                    <th>Tailor Cost</th>
                                                    <th>Total</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tot_fb = 0.00;
                                                $tot_tailor = 0.00;
                                                $totpay = 0.00;
                                                if ($queryfour->num_rows() > 0) {
                                                    foreach ($queryfour->result() as $delrow) {
                                                        if ($delrow->branch_id == $row->branch_id) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $delrow->order_date; ?></td>
                                                                <td><?php echo $delrow->del_date; ?></td>
                                                                <td><?php echo $delrow->invoice; ?></td>
                                                                <td><?php echo $delrow->tot_fabrics; ?></td>
                                                                <td><?php echo $delrow->tot_tailor_cost; ?></td>
                                                                <td><?php echo $delrow->tot_fabrics + $delrow->tot_tailor_cost; ?></td>

                                                            </tr>

                                                            <?php
                                                            $tot_fb += $delrow->tot_fabrics;
                                                            $tot_tailor += $delrow->tot_tailor_cost;
                                                            $tot_due += $delrow->due;
                                                            $tot_payment += $delrow->payment;
                                                            $totpay = $tot_fb + $tot_tailor;
                                                        }
                                                    }
                                                    echo '<tr class="bg-warning"><td></td><td></td><td></td>
                                                                    <td><b>' . $tot_fb . '</b></td>
                                                                     <td><b>' . $tot_tailor . '</b></td>
                                                                      <td><b>' . $totpay . '</b></td>
                                                                         </tr>';
                                                } else {
                                                    echo "<tr><td colspan='6'><div class='alert alert-info'>No Delivery Yet !</div></td></tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>




                                    </div>
                                    <?php
                                    $j++;
                                }
                            }
                        }
                        ?>       
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-warning">
            <div class="panel-heading">
                <h5><strong> Today : Expenses</strong></h5>
            </div>
            <div class="panel-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $i = 2;
                        if ($querytwo->num_rows() > 0) {
                            foreach ($querytwo->result() as $row) {
                                if ($row->branch_id > 1) {
                                    ?>
                                    <li role="presentation" class="<?php echo ($i == 2) ? 'active' : ''; ?>"><a href="#<?php echo $row->branch_name . 'exp'; ?>" aria-controls="<?php echo $row->branch_name . 'exp'; ?>" role="tab" data-toggle="tab"><?php echo $row->branch_name; ?></a></li>

            <?php
            $i++;
        }
    }
}
?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
<?php
$j = 2;
if ($querytwo->num_rows() > 0) {
    foreach ($querytwo->result() as $row) {
        if ($row->branch_id > 1) {
            ?>
                                    <div role="tabpanel" class="tab-pane <?php echo ($j == 2) ? 'active' : ''; ?>" id="<?php echo $row->branch_name . 'exp'; ?>">
                                        <table class="table">
                                            <thead>
                                                <tr class="bg-warning">
                                                    <th>Date</th>
                                                    <th>Expense Type</th>                       
                                                    <th>Amount</th>                                                                           
                                                </tr>
                                            </thead>
                                            <tbody>
            <?php
            $tot_ex = 0.00;

            if ($queryfive->num_rows() > 0) {
                foreach ($queryfive->result() as $exprow) {
                    if ($exprow->branch_id == $row->branch_id) {
                        ?>
                                                            <tr>
                                                                <td><?php echo $exprow->expdate; ?></td>
                                                                <td><?php echo $exprow->name; ?></td>
                                                                <td><?php echo $exprow->cost; ?></td>

                                                            </tr>

                                                            <?php
                                                            $tot_ex += $exprow->cost;
                                                        }
                                                    }
                                                    echo '<tr class="bg-warning"><td></td><td></td>
                                                                    <td><b>' . $tot_ex . '</b></td>
                                                                    
                                                                         </tr>';
                                                } else {
                                                    echo "<tr><td colspan='3'><div class='alert alert-info'>There is no Expense by Today !</div></td></tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>




                                    </div>
            <?php
            $j++;
        }
    }
}
?>       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">

        <?php
        $i = 2;
        if ($querytwo->num_rows() > 0) {
            foreach ($querytwo->result() as $row) {
                if ($row->branch_id > 1) {
                    ?>
       <div class="panel panel-primary">
            <div class="panel-heading">
                <span style="font-size:20px;"><?php echo $row->branch_name; ?></span>
            </div>
           <div class="panel-body">
            <?php   
                $tt_order = 0;
                $tt_received = 0.00;
                $tt_due = 0.00;
                $tt_expp = 0.00;
                $abc = 0.00;
                $tt_fabrics = 0.00;
                $tt_cost = 0.00; 
                $tt_sell = 0.00;
            if ($querysix->num_rows() > 0) {
                foreach ($querysix->result() as $ttsum) {
                    if ($ttsum->branch_id == $row->branch_id) {
                        $tt_order++;
                        $tt_due += $ttsum->due;
                        $abc += $ttsum->payment;
                    }  
                }
            }
            
             if ($queryseven->num_rows() > 0) {
                foreach ($queryseven->result() as $ttesx) {
                    if ($ttesx->branch_id == $row->branch_id) {                        
                        $tt_expp += $ttesx->cost;
                    }  
                }
            }
              if ($queryeight->num_rows() > 0) {
                foreach ($queryeight->result() as $ttpy) {
                    if ($ttpy->branch_id == $row->branch_id) {                        
                        $tt_received += $ttpy->payment;
                    }  
                }
            }
                if ($querynine->num_rows() > 0) {
                foreach ($querynine->result() as $ttfb) {
                    if ($ttfb->branch_id == $row->branch_id) {                        
                        $tt_fabrics += $ttfb->qty;
                        $tt_cost += $ttfb->cost_price;
                        $tt_sell += $ttfb->unit_price;
                    }  
                }
            }
           
                    ?>
               <table>
                   <tr>
                       <td>  <p>Orders : </p>  </td>
                       <td><p class="sum_num"><?php echo $tt_order; ?></p></td>
                   </tr>
                   <tr>
                       <td>  <p>Received : </p>  </td>
                       <td><p class="sum_num"><?php echo $tt_received; ?></p></td>
                   </tr>
                   <tr>
                       <td>   <p>Dues : </p>  </td>
                       <td><p class="sum_num"><?php echo $tt_due; ?></p></td>
                   </tr>
                   <tr>
                       <td>     <p>Expensed : </p>  </td>
                       <td> <p class="sum_num"><?php echo $tt_expp; ?></p></td>
                   </tr>
                    <tr>
                        <td>     <p>Fb.Qty<small>(Yrd)</small> : </p>  </td>
                       <td> <p class="sum_num"><?php echo $tt_fabrics; ?></p></td>
                   </tr>
                    <tr>
                       <td>     <p>T.Cost : </p>  </td>
                       <td> <p class="sum_num"><?php echo $tt_cost; ?></p></td>
                   </tr>
                    <tr>
                       <td>     <p>T.Sell : </p>  </td>
                       <td> <p class="sum_num"><?php echo $tt_sell; ?></p></td>
                   </tr>
               </table>
                          
               
              
            
               
           </div>
       </div>            
                    
            <?php
            $i++;
        }
    }
}
?>


    </div>
</div>