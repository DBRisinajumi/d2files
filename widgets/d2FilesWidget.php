<?php

Yii::import('vendor.dbrisinajumi.d2files.D2filesModule');
Yii::import('vendor.dbrisinajumi.d2files.controllers.D2filesController');

class d2FilesWidget extends CWidget
{
    public $module;
    public $model;
    public $title = false;
    public $icon = false;
    public $hideTitle = false;
    public $readOnly = false;
    public $showImagesTypes = false;

    public function run()
    {
        if($this->title === false){
            $this->title = Yii::t('D2filesModule.crud_static', 'Attachments');
        }
        if($this->icon === false){
            $this->icon = "paperclip";
        }
        $controller = new D2filesController('d2files/d2files');
        $this->render('files',array(
            'title' => $this->title,
            'icon' => $this->icon,
            'hideTitle' => $this->hideTitle,
            'controller' => $controller,
            'model_name' => $this->module . '.' . get_class($this->model),
            'model' => $this->model,
            'readOnly' => $this->readOnly,
            'showImagesTypes' => $this->showImagesTypes,
        ));
    }
}
