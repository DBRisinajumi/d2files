<?php
    $this->setPageTitle(
        Yii::t('D2filesModule.model', 'D2files Type')
        . ' - '
        . Yii::t('D2filesModule.crud_static', 'View')
        . ': '   
        . $model->getItemLabel()            
);    

$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("D2filesModule.crud_static","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("D2files.D2filesType.*") || Yii::app()->user->checkAccess("D2files.D2filesType.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("D2filesModule.crud_static","Back"),
                )
 ),true);
    
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2filesModule.model','D2files Type');?>                <small><?php echo$model->itemLabel?></small>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            $this->widget("bootstrap.widgets.TbButton", array(
                "label"=>Yii::t("D2filesModule.crud_static","Delete"),
                "type"=>"danger",
                "icon"=>"icon-trash icon-white",
                "size"=>"large",
                "htmlOptions"=> array(
                    "submit"=>array("delete","id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                    "confirm"=>Yii::t("D2filesModule.crud_static","Do you want to delete this item?")
                ),
                "visible"=> (Yii::app()->request->getParam("id")) && (Yii::app()->user->checkAccess("D2files.D2filesType.*") || Yii::app()->user->checkAccess("D2files.D2filesType.Delete"))
            ));
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span12">
        <h2>
            <?php echo Yii::t('D2filesModule.crud_static','Data')?>            <small>
                #<?php echo $model->id ?>            </small>
        </h2>

        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                
                array(
                    'name' => 'id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'id',
                            'url' => $this->createUrl('/d2files/d2filesType/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'type',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'type',
                            'url' => $this->createUrl('/d2files/d2filesType/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'model',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'model',
                            'url' => $this->createUrl('/d2files/d2filesType/editableSaver'),
                        ),
                        true
                    )
                ),
           ),
        )); ?>
    </div>

    </div>
    <div class="row">
        
</div>

<?php echo $cancel_buton; ?>