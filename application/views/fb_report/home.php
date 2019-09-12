<div class="row">
     <div class=" col-sm-12 well"> 
        <p class=""><h3 class="text-center borderbottom2">Report</h3></p>
       
    </div>

    <div class=" col-sm-12 well"> 
        <hr/>
        <?php if($this->session->userdata('branch_id') != 0){ ?>
        <a href="<?php echo site_url();?>/fb_report/today_cash" class="btn btn-danger btn-lg col-sm-2 col-sm-offset-1">Today Cash</a>    
        <?php }else{ ?> 
                  <span  data-toggle="modal" data-target="#orderModel" class="btn btn-success btn-lg col-sm-2 col-sm-offset-1"> Orders</span>
                   <span  data-toggle="modal" data-target="#summaryModal" class="btn btn-primary btn-lg col-sm-2 col-sm-offset-1">Branch Summary</span>
                   <span  data-toggle="modal" data-target="#transferModal" class="btn btn-warning btn-lg col-sm-2 col-sm-offset-1">Distribution Report</span>
                   <span  data-toggle="modal" data-target="#expenseModal" class="btn btn-info btn-lg col-sm-2 col-sm-offset-1">Expense Report</span>
                   <p><br/><h1></h1><br/></p>
                    <span data-toggle="modal" data-target="#attendenceModal" class="btn btn-default btn-lg col-sm-2 col-sm-offset-1">Attendence</span>
      <?php } ?>
        <!--
     <div class="col-sm-12">        <hr/><br/>    </div>
     <span data-toggle="modal" data-target="#purchaseModal" class="btn btn-warning btn-lg col-sm-2 col-sm-offset-1"><i class="fa fa-shopping-cart"> </i> Purchase</span>
     <span  data-toggle="modal" data-target="#expenseModal" class="btn btn-github btn-lg col-sm-2 col-sm-offset-1"><i class="fa fa-expand"> </i> Expense</span>
-->
    </div>
    
    
    
<!-- summary modal-->
<div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Branch Summary</h4>
      </div>
      <div class="modal-body">       
        <div class="row">
            <div class="col-md-12">
                 

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Summary Report Input</h3>
            </div>
            <div class="box-body">
            
                <form action="<?php echo site_url(); ?>/fb_report/branch_summary_report" method="post" role="form" class="form-horizontal" >

                  
                  <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Branch</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="branch_id" required>

                                <option value="">Select</option>                        
                             <?php   $sql = $this->db->get('branch');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                      if($row->branch_id != 1){
                                          echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
                                      }
                                  }
                                  }
                                  ?>
                            </select>
                        </div>
                    </div>
                 
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">

                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio2" value="sp" > Specific
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio3" value="all"> All
                            </label>

                        </div>
                    </div>

                    <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Date Range</label>
                        <div class="col-sm-10">
                          
                            <select name="from_day">
                                <?php
                                $y = Date('Y');
                                $old = $y - 6;
                                for ($i = 1; $i < 32; $i++) {
                                    ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>
                            -----to-------
                            <select name="to_day">
                                <?php for ($i = 1; $i < 32; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>       
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->



                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class=" submit btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>

            </div><!-- /.input group -->
        </div><!-- /.form group -->
  


            </div>
        </div> 

      </div>
      <div class="modal-footer">
          <p class="text-danger pull-left">Date style: <strong>DAY-MONTH-YEAR</strong></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>



<!-- order  modal-->
<div class="modal fade" id="orderModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"> Report</h4>
      </div>
      <div class="modal-body">
       
<div class="row">

    <div class="col-md-12">

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Orders Report Input</h3>
            </div>
            <div class="box-body">
            
                <form action="<?php echo site_url(); ?>/fb_report/order_report" method="post" role="form" class="form-horizontal" >

                
                
                  <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Branch</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="branch_id" required>

                                <option value="">Select</option>                        
                             <?php   $sql = $this->db->get('branch');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                      if($row->branch_id != 1){
                                          echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
                                      }
                                  }
                                  }
                                  ?>
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">

                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio2" value="sp" > Specific
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio3" value="all"> All
                            </label>

                        </div>
                    </div>

                    <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Date Range</label>
                        <div class="col-sm-10">
                          
                            <select name="from_day">
                                <?php
                                $y = Date('Y');
                                $old = $y - 6;
                                for ($i = 1; $i < 32; $i++) {
                                    ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>
                            -----to-------
                            <select name="to_day">
                                <?php for ($i = 1; $i < 32; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>       
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->



                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class=" submit btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>

            </div><!-- /.input group -->
        </div><!-- /.form group -->

    </div>


</div> 

      </div>
      <div class="modal-footer">
           <p class="text-danger pull-left">Date style: <strong>DAY-MONTH-YEAR</strong></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>





<!-- Transfer modal-->
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">KNZ Report</h4>
      </div>
      <div class="modal-body">
       
<div class="row">

    <div class="col-md-12">

           

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Transfer Report Input</h3>
            </div>
            <div class="box-body">
            
                <form action="<?php echo site_url(); ?>/fb_report/transfer_summary_report" method="post" role="form" class="form-horizontal" >

                  
                  <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">From </label>
                        <div class="col-sm-4">
                            <select class="form-control" name="from_branch_id" required>

                                <option value="">Select</option>                        
                             <?php   $sql = $this->db->get('branch');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                  
                                          echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
                                    
                                  }
                                  }
                                  ?>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label">To </label>
                        <div class="col-sm-4">
                            <select class="form-control" name="to_branch_id" required>

                                <option value="">Select</option>                        
                             <?php   $sql = $this->db->get('branch');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                      if($row->branch_id != 1){
                                          echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
                                      }
                                  }
                                  }
                                  ?>
                            </select>
                        </div>
                    </div>
                 
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">

                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio2" value="sp" > Specific
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio3" value="all"> All
                            </label>

                        </div>
                    </div>

                    <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Date Range</label>
                        <div class="col-sm-10">
                          
                            <select name="from_day">
                                <?php
                                $y = Date('Y');
                                $old = $y - 6;
                                for ($i = 1; $i < 32; $i++) {
                                    ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>
                            -----to-------
                            <select name="to_day">
                                <?php for ($i = 1; $i < 32; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>       
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->



                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class=" submit btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>

            </div><!-- /.input group -->
        </div><!-- /.form group -->
  


    </div>


</div> 

      </div>
      <div class="modal-footer">
           <p class="text-danger pull-left">Date style: <strong>DAY-MONTH-YEAR</strong></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>




<!-- purchase modal-->
<div class="modal fade" id="attendenceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">KNZ Report</h4>
      </div>
      <div class="modal-body">
       
<div class="row">

    <div class="col-md-12">

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Attendance Report Input</h3>
            </div>
            <div class="box-body">
            
                <form action="<?php echo site_url(); ?>/fb_report/attendance_report" method="post" role="form" class="form-horizontal" >
                        
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Select Branch </label>
                        <div class="col-sm-10">
                            <select class="form-control" name="branch_id" id="attendance_branch_id" required>
                                 <option value="">Select</option>                        
                             <?php   $sql = $this->db->get('branch');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                      
                                          echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
                                      
                                  }
                                  }
                                  ?>
                               
                            </select>
                        </div>
                    </div>
                  <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Select Member </label>
                        <div class="col-sm-10">
                            <select class="form-control" name="member_id" id="attendance_member_option">
                                 <option value="">Select Branch First</option>                        
                             
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">

                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio2" value="sp" > Specific
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio3" value="all"> All
                            </label>

                        </div>
                    </div>

                    <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Date Range</label>
                        <div class="col-sm-10">
                          
                            <select name="from_day">
                                <?php
                                $y = Date('Y');
                                $old = $y - 6;
                                for ($i = 1; $i < 32; $i++) {
                                    ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>
                            -----to-------
                            <select name="to_day">
                                <?php for ($i = 1; $i < 32; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>       
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->



                   
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                             
                            <button type="submit"  class=" submit btn btn-warning">Submit</button>
                        </div>
                    </div>
                </form>

            </div><!-- /.input group -->
        </div><!-- /.form group -->

    </div>


</div> 

      </div>
      <div class="modal-footer">
          <p class="text-danger pull-left">Date style: <strong>DAY-MONTH-YEAR</strong></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<!-- purchase modal end--->

<!-- expense modal-->
<div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">KNZ Report</h4>
      </div>
      <div class="modal-body">
       
<div class="row">

    <div class="col-md-12">

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Expense Report Input</h3>
            </div>
            <div class="box-body">
            
                <form action="<?php echo site_url(); ?>/fb_report/expense_report" method="post" role="form" class="form-horizontal" >

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Expense Type</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="exp_type_id" >
                                <option value="">Select</option>
                              <?php   $exsql = $this->db->get('fb_expense_type');
                                  if ($exsql->num_rows() > 0) {
                                  foreach ($exsql->result() as $exrow) {
                                      
                                          echo '<option value="'.$exrow->id.'">'.$exrow->name.'</option>';
                                      
                                  }
                                  }
                                  ?>
                               
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Select Branch </label>
                        <div class="col-sm-10">
                            <select class="form-control" name="branch_id" required>
                                 <option value="">Select</option>                        
                             <?php   $sql = $this->db->get('branch');
                                  if ($sql->num_rows() > 0) {
                                  foreach ($sql->result() as $row) {
                                      
                                          echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
                                      
                                  }
                                  }
                                  ?>
                               
                            </select>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">

                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio2" value="sp" > Specific
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="inlineRadio3" value="all"> All
                            </label>

                        </div>
                    </div>

                    <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Date Range</label>
                        <div class="col-sm-10">
                          
                            <select name="from_day">
                                <?php
                                $y = Date('Y');
                                $old = $y - 6;
                                for ($i = 1; $i < 32; $i++) {
                                    ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="from_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>
                            -----to-------
                            <select name="to_day">
                                <?php for ($i = 1; $i < 32; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_month">
                                <?php for ($i = 1; $i < 13; $i++) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="to_year">
                                <?php for ($i = $y; $i > $old; $i--) { ?>    
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>       
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->



                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit"  class=" submit btn btn-warning">Submit</button>
                        </div>
                    </div>
                </form>

            </div><!-- /.input group -->
        </div><!-- /.form group -->

    </div>


</div> 

      </div>
      <div class="modal-footer">
           <p class="text-danger pull-left">Date style: <strong>DAY-MONTH-YEAR</strong></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<!--modal end--->    
</div>
<script type='text/javascript'>
    $(document).ready(function()
    {
        $('.submit').hide();
        $('.radio-inline').click(function(){
          $('.submit').show();  
        });
                
    });
    
    
 $( "#attendance_branch_id" )
  .change(function () {
    var str = $(this).val();
        $.ajax({
            url: '<?php echo site_url(); ?>/fb_member/search_branch_member',
            type:'post',
            data:{str:str},
            success: function(data){
               if(data !== ''){ $('#attendance_member_option').html(data);}               
            }
        });
  });
</script>   