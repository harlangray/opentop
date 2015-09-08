
<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); ?><tbody class='tankassembly' id='user_message_<?php echo $cnt ?>'>
<tr>
<td>
<?php
echo CHtml::activeDropDownList($model, 'user_id', CHtml::listData(
                          User::model()->findAll(), 'id', 'username'), array('name' => "UserMessage[$cnt][user_id]", 'id' => "UserMessage[$cnt][user_id]", 'prompt' => 'Select a User')) ;
echo CHtml::error($model, 'user_id');
?>
</td>


<td>
          <?php
                echo CHtml::image(Yii::app()->request->baseUrl . '/images/close-me.png', '', array('height' => '20px', 'width' => '20px', 'title' => 'Remove user_message from list', 'onClick' => "remove_user_message({$cnt})")); 
          ?>           
          </td></tr>
</tbody>


