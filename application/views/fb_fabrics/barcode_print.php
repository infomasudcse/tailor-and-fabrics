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
.box_barcode{background-color:#ffffff;float:left;border:1px solid #ffffff; text-align:center;width:44%;height:100px;padding:18px 10px;}
</style>



<div style="width:100%; border:1px solid #ffffff;margin-top:-20px;">
    <div style="border:1px solid #ffffff;width:80%;" align="center">
       <?php  foreach($itms as $it){

    foreach($items as $vs){ ?>
        <div class="box_barcode">
          <?php   
          echo " <span style=''>".$vs."</span><br/><table  class='bb' style='margin-left:45px;'><tr><td><span style='letter-spacing:2px;font-size:13px;'><b>*".$it[item_number]."*</b> </span></td></tr></table><table class='cc' style='margin-left:50px;'><tr><td style='font-size:16px;'><b>".$it[name]."</b><br/>MRP.  <b>".$it[price]."</b><br/>Company</td></tr></table>";
        ?>
          </div>
       <?php } } ?>
    </div>
</div>    
