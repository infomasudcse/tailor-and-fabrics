


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Fabrics & Tailor Demo :: Refine IT </title>

    <!-- Bootstrap core CSS -->
     <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/cover.css" rel="stylesheet">
   
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand text-center">Fabrics & Tailors</h3>
              
            </div>
          </div>

          <div class="inner cover loginform">
              <h2 class="text-left" id="view_access">LogIn</h2><br/>
                     <div style="margin-left:10%; margin-bottom:20px;" id="access">
                        <p align="left" style="color:#900000;" >Access for Demo</p>
                            <table width="250" cellpadding="10" border="1">

                                <tr>
                                    <th align="center" style="text-align:center">Role</th>
                                    <th align="center">Username</th>
                                    <th align="center">Password</th>
                                </tr>
                                <tr>
                                    <td align="center">ADMIN : </td>             
                                      <td align="center">admin</td>
                                       <td align="center">admin</td>


                                </tr>
                                <tr>
                                    <td align="center">Branch Manager : </td>

                                                <td align="center">manager1</td>

                                                <td align="center">manager1</td>

                                </tr>
                            </table>
                        </div>  
              
                    <?php 
                    $str = validation_errors();
                    if($str != ''){
                        
                        echo '<div class="alert alert-danger" id="v_err">'.$str.'</div>';
                        
                    }
                    
                    
                    ?>
              
              
                   <?php echo form_open('login', array('id'=>'login_form')); ?>
                   
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="text" name="username" id="inputEmail" class="form-control input-lg" placeholder="Username" required autofocus><br/>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" name="password" id="inputPassword" class="form-control input-lg " placeholder="Password" required><br/><br/>
                        
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                      </form>
          </div>

          <div class="mastfoot">
            <div class="inner">
                <p>Powered By <a href="http://refineitbd.com"><img src="<?php echo base_url(); ?>images/refine_logo5.png" width="50px"></a></p>
            </div>
          </div>

        </div>

      </div>

    </div>
     
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
     <script>
      $(document).ready(function(){
	$("#login_form input:first").focus();
         $('#access').hide();
            $('#view_access').click(function(){
                $('#access').slideToggle();
            });
            
        $('#v_err').delay(4000).fadeOut('slow');
        
        
});
      </script>
    
    
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url(); ?>js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
