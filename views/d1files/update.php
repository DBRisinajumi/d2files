<?php
$this->setPageTitle(
        Yii::t('D1filesModule.model', 'D1files')
        . ' - '
        . Yii::t('D1filesModule.crud', 'Update')
        . ': '   
        . $model->getItemLabel()
);    
$this->breadcrumbs[Yii::t('D1filesModule.model','D1files')] = array('admin');
$this->breadcrumbs[$model->{$model->tableSchema->primaryKey}] = array('view','id' => $model->{$model->tableSchema->primaryKey});
$this->breadcrumbs[] = Yii::t('D1filesModule.crud', 'Update');
?>

<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
    <h1>
        
        <?php echo Yii::t('D1filesModule.model','D1files'); ?>
        <small>
            <?php echo $model->itemLabel ?>

        </small>

        
    </h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>

<?php
    $this->renderPartial('_form', array('model' => $model));
?>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>