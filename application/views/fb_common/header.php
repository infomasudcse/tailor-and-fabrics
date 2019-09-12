<!DOCTYPE html>
<html lang="en">
    <head>
         <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link rel="shortcut icon" href="../../assets/ico/favicon.ico">-->

        <title>Tailors & Fabrics :: Refine IT</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/custom.css" rel="stylesheet">
           <link href="<?php echo base_url(); ?>css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
           
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    
         <script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.min.js"></script>
          <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        
        
         
        <style>
            .bottom-alert{position:fixed; bottom:0;border-top:5px solid #ff0000;color:#009900;background-color: #ffffff;}
            .marginleftright10{margin-left:10px; margin-right:10px;}
            .margintopbottom5{margin-top:5px; margin-bottom:5px;}
            .borderbottom2{border-bottom: 2px #009000 solid;}
               .borderbottomred2{border-bottom: 2px #900000 double;}
			
        </style>
        <script>
             
         </script>   
        
    </head>

    <body>

        <!-- Fixed navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top borderbottomred2" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="<?php echo base_url(); ?>images/refine_logo5.png" width="30" class="marginleftright10 margintopbottom5">
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav ">
                        
                        <?php if($this->session->userdata('branch_id') != 0){?>
                         <li class="active"><a href="<?php echo site_url(); ?>/fb_home/index">Dashboard</a></li>
                         <li class=""><a href="<?php echo site_url(); ?>/fb_customer">Customers</a></li>
                        <li class=""><a href="<?php echo site_url(); ?>/fb_new_order">New Order</a></li>
                          <li class=""><a href="<?php echo site_url(); ?>/fb_fabrics/all_invoices">Invoices</a></li>
                          <li class=""><a href="<?php echo site_url(); ?>/fb_expense">Expense</a></li>    
                            <li class=""><a href="<?php echo site_url(); ?>/fb_member/branch_member">Attendance</a></li>  
                          <li class=""><a href="<?php echo site_url(); ?>/fb_report">Report</a></li>
                        <li class=""><a href="<?php echo site_url(); ?>/fb_fabrics">Fabrics</a></li>
                        
                      
                          
                        <?php }else{  ?>
                                <li class="active"><a href="<?php echo site_url(); ?>/fb_home/index">Dashboard</a></li>
                                  <li class=""><a href="<?php echo site_url(); ?>/fb_report">Report</a></li>
                                <li class=""><a href="<?php echo site_url(); ?>/fb_customer">Customers</a></li>                             
                               <li class=""><a href="<?php echo site_url(); ?>/fb_fabrics/admin_invoices">Invoices</a></li>
                               <li class=""><a href="<?php echo site_url(); ?>/fb_fabrics">Fabrics</a></li>
                                <li class="dropdown">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
                                   <ul class="dropdown-menu" role="menu">
                                     <li><a href="<?php echo site_url(); ?>/fb_member/index">Branch Member</a></li>
                                     <li><a href="<?php echo site_url(); ?>/fb_tailor_cost/tailor_cost">Tailor Cost</a></li>
                                     <li><a href="<?php echo site_url(); ?>/fb_expense/expense_type">Expense Type</a></li>
                                     <li><a href="<?php echo site_url(); ?>/fb_card/index">Customer Card</a></li>
                                     
                                     <li class="divider"></li>
                                     <li><a href="#">Change Password</a></li>
                                   </ul>
                                 </li>
                                 <li class=""><a href="<?php echo site_url(); ?>/fb_branch">Branch</a></li>
                                 <li class=""><a href="<?php echo site_url(); ?>/fb_employee">Employees</a></li>
                        <?php } ?> 
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        
                        <li><a href="<?php echo site_url(); ?>/login/logout">Logout  --></a></li>
                        
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">
            <div class="jumbotron">