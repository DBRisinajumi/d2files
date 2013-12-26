<fieldset>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
          'id' => 'somemodel-form',
          'enableAjaxValidation' => false,
            //This is very important when uploading files
          'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
      ?>    
        <div class="row">
            <?php echo $form->labelEx($model,'field1'); ?>
            <?php echo $form->textField($model,'field1'); ?>
            <?php echo $form->error($model,'field1'); ?>
        </div>
        <!-- Other Fields... -->
        <div class="row">
            <?php echo $form->labelEx($model,'photos'); ?>
            <?php
            $this->widget( 'xupload.XUpload', array(
                'url' => Yii::app( )->createUrl( "/controller/upload"),
                //our XUploadForm
                'model' => $photos,
                //We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'somemodel-form'),
                'attribute' => 'file',
                'multiple' => true,
                //Note that we are using a custom view for our widget
                //Thats becase the default widget includes the 'form' 
                //which we don't want here
                'formView' => 'application.views.somemodel._form',
                )    
            );
            ?>
        </div>
        <button type="submit">Submit</button>
    <?php $this->endWidget(); ?>
</fieldset>