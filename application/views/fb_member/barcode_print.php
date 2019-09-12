<style type="text/css">

.bar_co{
float:left; 
/*overflow:hidden;*/
}
.laabel{
   background-color:#ffffff;height:94px;
}
.label_text{margin-left:50px;}
.bb{background-color:#ffffff;}
.cc{background-color:#ffffff;}
.box_barcode{background-color:#ffffff;float:left;border:1px solid #f00000; text-align:center;width:250;padding:18px 10px;}
</style>



<div style="width:100%; border:1px solid #ffffff;margin-top:-20px;">
    <div style="border:1px solid #ffffff;width:80%;" align="center">
       <?php  foreach($itms as $it){

    foreach($items as $vs){ ?>
        <div class="box_barcode">
          <?php   
          echo "<p align='center'><b>Company Name</b><br/>Address: ------- -------- <br/>-------- ------ <br/> Employee ID Card. <br/></p><p align='center'><img src='".$it[photo]."' width='200'></p> <p align ='center'>".$vs."</p><p align='center' style='letter-spacing:2px;font-size:13px;'><b>*".$it[item_number]."*</b> </p><p align='center'><b>".$it[name]."</b><br/> Branch : <b>".$it[branch]."</b></p>";
        ?>
          </div>
       <?php } } ?>
    </div>
</div>    
