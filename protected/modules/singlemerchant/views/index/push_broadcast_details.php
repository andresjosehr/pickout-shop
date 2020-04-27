
<div class="card" id="box_wrap">
<div class="card-body">


<form id="frm_table" method="POST" >
<?php echo CHtml::hiddenField('action','pushLogsDetails')?>
<?php echo CHtml::hiddenField('broadcast_id',$broadcast_id)?>

<table id="table_list" class="table table-striped data_tables">
 <thead>
  <tr>
    <th width="5%"><?php echo SingleAppClass::t("ID")?></th>
    <th><?php echo SingleAppClass::t("PushType")?></th>
    <th><?php echo SingleAppClass::t("Name")?></th>
    <th ><?php echo SingleAppClass::t("Platform")?></th>
    <th><?php echo SingleAppClass::t("Title")?></th>    
    <th><?php echo SingleAppClass::t("Message")?></th>
    <th><?php echo SingleAppClass::t("Date")?></th>
  </tr>
 </thead>
 <tbody>  
 </tbody>
</table>
</form>

</div> <!--card body-->
</div> <!--card-->


<div class="floating_action">


<a  href="<?php echo Yii::app()->createUrl($modulename."/index/push_broadcast")?>" 
class="btn btn-secondary left_margin"  >
 <?php echo st("BACK")?> 
</a>

 <button type="button" class="btn <?php echo APP_BTN?> refresh_datatables"  >
 <?php echo st("Refresh")?> 
 </button>
</div>