<?php

class d2FilesWidget extends CWidget
{
    public $model;
    
    public function run()
    {
        $this->render('files',array(
            'model' => $this->model,
        ));
    }
}
