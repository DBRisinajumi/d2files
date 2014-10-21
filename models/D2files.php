<?php

// auto-loading
Yii::setPathOfAlias('D2files', dirname(__FILE__));
Yii::import('D2files.*');

class D2files extends BaseD2files {

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function init() {
        return parent::init();
    }

    public function getItemLabel() {
        return parent::getItemLabel();
    }

    public function behaviors() {
        return array_merge(
                parent::behaviors(), array(
             //auditrail       
            'LoggableBehavior' => array(
                'class' => 'LoggableBehavior'
            ),
        ));
    }  

    public function rules() {
        return parent::rules();
//        return array_merge(
//            parent::rules(),
// 			array());
    }

    public function search() {
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria(),
        ));
    }

    public function afterSave() {
        $this->addImages();

        /**
         * registre file in task
         */
        $registre_tasks_to_models = Yii::app()->getModule('d2files')->registre_tasks_to_models;
        if($registre_tasks_to_models 
                && isset($registre_tasks_to_models[$this->model])
        ){
            $this->createProject($registre_tasks_to_models[$this->model]);
            
        
            
        }
        parent::afterSave();
    }

    public function addImages() {
        //If we have pending images
        if (Yii::app()->user->hasState('images')) {
            $userImages = Yii::app()->user->getState('images');
            //Resolve the final path for our images
            $path = Yii::app()->getBasePath() . "/../images/uploads/{$this->id}/";
            //Create the folder and give permissions if it doesnt exists
            if (!is_dir($path)) {
                mkdir($path);
                chmod($path, 0777);
            }

            //Now lets create the corresponding models and move the files
            foreach ($userImages as $image) {
                if (is_file($image["path"])) {
                    if (rename($image["path"], $path . $image["filename"])) {
                        chmod($path . $image["filename"], 0777);
                        $img = new Image( );
                        $img->size = $image["size"];
                        $img->mime = $image["mime"];
                        $img->name = $image["name"];
                        $img->source = "/images/uploads/{$this->id}/" . $image["filename"];
                        $img->somemodel_id = $this->id;
                        if (!$img->save()) {
                            //Its always good to log something
                            Yii::log("Could not save Image:\n" . CVarDumper::dumpAsString(
                                            $img->getErrors()), CLogger::LEVEL_ERROR);
                            //this exception will rollback the transaction
                            throw new Exception('Could not save Image');
                        }
                    }
                } else {
                    //You can also throw an execption here to rollback the transaction
                    Yii::log($image["path"] . " is not a file", CLogger::LEVEL_WARNING);
                }
            }
            //Clear the user's session
            Yii::app()->user->setState('images', null);
        }
    }
    
    public function searchExactCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('t.file_name', $this->file_name);
        $criteria->compare('t.upload_path', $this->upload_path);
        $criteria->compare('t.add_datetime', $this->add_datetime);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.deleted', $this->deleted);
        $criteria->compare('t.notes', $this->notes);
        $criteria->compare('t.model', $this->model);
        $criteria->compare('t.model_id', $this->model_id);


        return $criteria;

    }
    
    /**
     * create project 
     * @param array $settings 
     * @return boolean
     */
    public function createProject($settings){
    
        //currently only for persons create project
        if($this->model != 'd2person.PprsPerson'){
            return false;
        }

        //validate user roles with setting roles
        if(isset($settings['user_roles'])){
            $user_roles = Authassignment::model()->getUserRoles(Yii::app()->user->id);
            $a = array_intersect($user_roles,$settings['user_roles']);
            if(empty($a)){
                return false;
            }
        }        
        
        $model = PprsPerson::model()->findByPk($this->model_id);
        
        //create project
        $ttsk = new TtskTask;
        $ttsk->ttsk_pprs_id = $this->model_id;
        $ttsk->ttsk_name = 'New attachment to ' . $model->itemLabel;
        $ttsk->ttsk_description = '';
        $ttsk->ttsk_tstt_id = $settings['new_project_status']; //not started
        try {
            if (!$ttsk->save()) {
                return false;
            }
        } catch (Exception $e) {
            return false;            
        }        
        
        //create task
        $tcmn = new TcmnCommunication;
        $tcmn->tcmn_ttsk_id = $ttsk->ttsk_id;
        $tcmn->tcmn_task  = 'Validate attachment:' . PHP_EOL;
        $tcmn->tcmn_task .= $this->file_name . ' ' . $this->add_datetime;
        $tcmn->tcmn_tcst_id = $settings['task_init_status'];
        $tcmn->tcmn_datetime = new CDbExpression('ADDDATE(NOW(),'.$settings['task_due_in_days'].' )');
        try {
            if (!$tcmn->save()) {
                return false;
            }
        } catch (Exception $e) {
            return false;            
        }                    
        
        return true;
    }    
    
    public static function extendedCheckAccess($authitem,$exception_on = true){
        $sql = "select * from authitem where `name` = '" .$authitem. "'";
        $ai = Yii::app()->db->createCommand($sql)->queryAll();         
        
        //if auth item is defined, use strict validation
        if(empty($ai)){
            $a = explode('.',$authitem);
            switch ($a[2]) {
                case 'uploadD2File':
                    $a[2] = 'Create';    
                    break;

                case 'downloadD2File':
                    $a[2] = 'View';    
                    break;
                case 'deleteD2File':
                    $a[2] = 'Delete';    
                    break;
            }            
            $authitem = implode('.',$a);
        }
        
        if (!Yii::app()->user->checkAccess($authitem)) {
            if($exception_on){
                throw new CHttpException(403, Yii::t("D2filesModule.model","You are not authorized to perform this action."));
            }
            return false;
        }            
        return true;

    }
    
    
}
