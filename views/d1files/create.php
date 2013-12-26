<?php
$this->setPageTitle(
    Yii::t('D1filesModule.model', 'D1files')
    . ' - '
    . Yii::t('D1filesModule.crud', 'Create')
);

$this->breadcrumbs[Yii::t('D1filesModule.model', 'D1files')] = array('admin');
$this->breadcrumbs[] = Yii::t('D1filesModule.crud', 'Create');
?>
<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
    <h1>
        <?php echo Yii::t('D1filesModule.model', 'D1files'); ?>
        <small><?php echo Yii::t('D1filesModule.crud', 'Create'); ?></small>

    </h1>

<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php $this->renderPartial('_form', array('model' => $model, 'buttons' => 'create')); ?>
<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>