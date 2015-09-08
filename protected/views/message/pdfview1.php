

<div class="form">
     <?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); ?>     <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
)); ?>

 <div style="float: left; width: 400px;">
<?php include 'ReportLogo.php'; ?>      
</div>
<div style ="clear: both"></div>

               <div class="row">
               <?php echo $form->labelEx($model,'user_id'); ?>
               <?php echo $model->user_id; ?>
                             
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'content'); ?>
               <?php echo $model->content; ?>
                             
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'details'); ?>
               <?php echo $model->details; ?>
                             
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'created'); ?>
               <?php echo $model->created; ?>
                             
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'modified'); ?>
               <?php echo $model->modified; ?>
                             
          </div>

          
     <fieldset>
          <legend>UserMessage</legend>

          <div id='user_message-grid' class='formgrid'> 
               <table id='user_message'>
                    <!--desplay headdings of grid-->
                    <tbody class='user_message'>
                         <?php 
$user_messageMod = new UserMessage();
echo '<tr>';
echo '<td>' . CHtml::activeLabelEx($user_messageMod, 'user_id') . '</td>';
echo '<td>' . CHtml::activeLabelEx($user_messageMod, 'message_read') . '</td>';
echo '<td>' . CHtml::activeLabelEx($user_messageMod, 'created') . '</td>';
echo '</tr>';
?>
                    </tbody>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~-->
                    <?php
                    $cnt = 0;
                    foreach ($user_message as $detail) {
                         echo $this->renderPartial('_user_message', array('model' => $detail, 'cnt' => $cnt));
                         $cnt++;
                    }
                    //add subform for new one
                    //$user_messageNew = new UserMessage();
                    //echo $this->renderPartial('_user_message', array('model' => $user_messageNew, 'cnt' => $cnt));
                    ?>
               </table>
          </div>

          <?php
          echo CHtml::image(Yii::app()->request->baseUrl . '/images/add-1-icon.png', '', array('height' => '40px', 'width' => '40px', 'title' => 'Add UserMessage to List', 'onClick' => 'duplicate_user_message()'));
          ?>   

     </fieldset> 

     <?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">

     cnt = <?php echo $cnt; ?>;

     function duplicate_user_message()
     {
          var newsubform = '';

          cnt++;
    
          $.ajax({ url: ' <?php echo Yii::app()->createUrl("message/get_user_message_SubForm", array()) ?>',
               data: {cnt: cnt},
               type: 'post',
               async: false,
               success: function(output) {
                    newsubform = output;
                    $('#user_message').append(newsubform);
               }
          });
 
     }function remove_user_message(id)
     {
          var div = document.getElementById('user_message_' + id);
          div.parentNode.removeChild(div);
     }   </script> 