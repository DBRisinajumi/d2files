<?php 
if(!$hideTitle){
?>
<div class="table-header header-color-blue">
    <i class="icon-<?php echo $icon; ?>"></i>
    <?php echo $title; ?>
</div>
<?php
}    
    $this->widget(
        'TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'label' => Yii::t("D2filesModule.crud_static","Drop files to upload"),
                'type' => 'raw',
                'template' => $this->widget(
                    'vendor.dbrisinajumi.d2files.widgets.d2Upload',
                    array(
                        'action' => 'template',
                        'model_name'=> $model_name,
                        //'model_name'=> Yii::app()->controller->id,
                        'model_id' => $model->getPrimaryKey(),
                        'controler' => $controller,
                        'readOnly' => $readOnly,
                        ),
                    true
                    ),
                'value' => $this->widget("bootstrap.widgets.TbButton", array(
                    "label"=>Yii::t("D2filesModule.crud_static","Add file"),
                    "icon"=>"icon-upload-alt",
                    'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'onclick' => '$("#fileupload_'.$this->getId().'").trigger("click");'
                     ),
                    'visible' => !$readOnly

                ),true)
                ,

            ),
        ),
    ));

