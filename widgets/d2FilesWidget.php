<?php

Yii::import('vendor.dbrisinajumi.d2files.D2filesModule');
Yii::import('vendor.dbrisinajumi.d2files.controllers.D2filesController');

class d2FilesWidget extends CWidget
{
    public $model;
    
    public function run()
    {
        $controller = new D2filesController('d2files/d2files');
        $this->render('files',array(
            'controller' => $controller,
            'model' => $this->model,
        ));
    }
}
