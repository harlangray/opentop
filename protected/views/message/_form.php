<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div class="form">
     <?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); ?>   
  <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
)); ?>

     <p class="note">Fields with <span class="required">*</span> are required.</p>

     <?php echo $form->errorSummary($model); ?>

 

                    <div class="row">
               <?php echo $form->labelEx($model,'content'); ?>
               <?php echo $form->textField($model,'content',array('size'=>60,'maxlength'=>100)); ?>
               <?php echo $form->error($model,'content'); ?>
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'details'); ?>
               <?php echo $form->textArea($model,'details',array('rows'=>6, 'cols'=>50)); ?>
               <?php echo $form->error($model,'details'); ?>
          </div>



                    <div class="row">
               <?php echo $form->labelEx($model,'modified'); ?>
               <?php $this->widget('CJuiDateTimePicker', array(
              'model' => $model, //Model object
              'attribute' => 'modified', //attribute name
              'mode' => 'datetime', //use 'time','date' or 'datetime' (default)
              'language' => '',
              'options' => array('dateFormat' => 'yy-mm-dd', 'timeFormat' => 'hh:mm:ss'), // jquery plugin options
              'htmlOptions' => array(
                  'style' => 'width:150px',
                  'class' => 'editableField'
              ),
          ));; ?>
               <?php echo $form->error($model,'modified'); ?>
          </div>

          
     <fieldset>
          <legend>Message for These Users (Add Users with + Button)</legend>

          <div id='user_message-grid' class='formgrid'> 
               <table id='user_message'>
                    <!--desplay headdings of grid-->
                    <tbody class='user_message'>
                         <?php 
$user_messageMod = new UserMessage();
echo '<tr>';
echo '<td>' . CHtml::activeLabelEx($user_messageMod, 'user_id') . '</td>';

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
     <div class="row buttons">
          <?php echo CHtml::submitButton($model->isNewRecord ? 'Create and Edit' : 'Save and Edit', array('name' => 'saveandedit')); ?><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('name' => 'save')); ?>
<input type="reset" value="Reset">     </div>

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