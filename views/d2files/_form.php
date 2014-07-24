<div class="crud-form">

    
    <?php
        Yii::app()->bootstrap->registerAssetCss('../select2/select2.css');
        Yii::app()->bootstrap->registerAssetJs('../select2/select2.js');
        Yii::app()->clientScript->registerScript('crud/variant/update','$(".crud-form select").select2();');

        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'd2files-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span7">
            <h2>
                <?php echo Yii::t('D2filesModule.crud_static','Data')?>                <small>
                    #<?php echo $model->id ?>                </small>

            </h2>


            <div class="form-horizontal">

                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.id')) != 'tooltip.id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'type') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.type')) != 'tooltip.type')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'type', $model->getEnumFieldLabels('type'));
                            echo $form->error($model,'type')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'file_name') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.file_name')) != 'tooltip.file_name')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'file_name', array('size' => 60, 'maxlength' => 255));
                            echo $form->error($model,'file_name')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'upload_path') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.upload_path')) != 'tooltip.upload_path')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'upload_path', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'upload_path')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'add_datetime') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.add_datetime')) != 'tooltip.add_datetime')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'add_datetime');
                            echo $form->error($model,'add_datetime')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'user_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.user_id')) != 'tooltip.user_id')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'user_id');
                            echo $form->error($model,'user_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'deleted') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.deleted')) != 'tooltip.deleted')?$t:'' ?>'>
                                <?php
                            echo $form->checkBox($model, 'deleted');
                            echo $form->error($model,'deleted')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.notes')) != 'tooltip.notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'notes')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'model') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.model')) != 'tooltip.model')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'model', array('size' => 20, 'maxlength' => 20));
                            echo $form->error($model,'model')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'model_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2filesModule.model', 'tooltip.model_id')) != 'tooltip.model_id')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'model_id', array('size' => 20, 'maxlength' => 20));
                            echo $form->error($model,'model_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
        </div>
        <!-- main inputs -->

        
        <div class="span5"><!-- sub inputs -->
            <div class="well">
            <!--<h2>
                <?php echo Yii::t('D2filesModule.crud_static','Relations')?>            </h2>-->
                        </div>
        </div>
        <!-- sub inputs -->
    </div>

    <p class="alert">
        <?php echo Yii::t('D2filesModule.crud_static','Fields with <span class="required">*</span> are required.');?>
    </p>

    <!-- TODO: We need the buttons inside the form, when a user hits <enter> -->
    <div class="form-actions" style="visibility: hidden; height: 1px">
        
        <?php
            echo CHtml::Button(
            Yii::t('D2filesModule.crud_static', 'Cancel'), array(
                'submit' => (isset($_GET['returnUrl']))?$_GET['returnUrl']:array('d2files/admin'),
                'class' => 'btn'
            ));
            echo ' '.CHtml::submitButton(Yii::t('D2filesModule.crud_static', 'Save'), array(
                'class' => 'btn btn-primary'
            ));
        ?>
    </div>

    <?php $this->endWidget() ?>
</div> <!-- form -->