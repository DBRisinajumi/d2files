<?php

class D2filesModule extends CWebModule
{
    public $upload_dir;
    public $accept_file_types = '/\.(gif|pdf|dat|jpe?g|png)$/i';
    
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'd2files.models.*',
			'd2files.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
