<?php

// auto-loading
Yii::setPathOfAlias('D2files', dirname(__FILE__));
Yii::import('D2files.*');

class D2files extends BaseD2files
{

    /**
     * shareable definition for model
     * @var type 
     */
    public $shareable_def = false;
    
    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        return parent::init();
    }

    public function getItemLabel()
    {
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

    public function rules()
    {
        return array_merge(
            parent::rules()
        /* , array(
          array('column1, column2', 'rule1'),
          array('column3', 'rule2'),
          ) */
        );
    }

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }
    
    public function afterSave() {
        
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
    
    public function searchExactCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.type_id', $this->type_id);
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
        $sql = "select * from AuthItem where `name` = '" .$authitem. "'";
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
    
    public static function getFileFullPathByType($model_name,$model_id,$type){
        
        /**
         * get record
         */
        $criteria = new CDbCriteria;
        $criteria->compare('model',$model_name);
        $criteria->compare('model_id',$model_id);
        $criteria->compare('type_id',$type);
        $criteria->compare('deleted',0);

        $d2files = D2files::model()->find($criteria);
        if(!$d2files){
            return false;
        }
        
        //get path and saved file name
        Yii::import( "vendor.dbrisinajumi.d2files.compnents.*");
        $dir_path = UploadHandlerD2files::getUploadDirPath($model_name);
        $file_name = UploadHandlerD2files::createSaveFileName($d2files->id, $d2files->file_name);
        
        return $dir_path . $file_name;
        
        
    }    
    
    /**
     * get shareable configuration for model
     */    
    public function getShareAbleDef(){
        if(!$this->shareable_def){
            $shareable = Yii::app()->getModule('d2files')->shareable_by_link;
            $is_model_shareable = false;
            foreach ($shareable as $sh_model => $def){
                if($sh_model == $this->model){
                    $this->shareable_def = $def;
                    break;
                }
            }
            
        }
        return $this->shareable_def;
    }


    /**
     * generate hash for shareable files
     * @return boolean
     */
    public function genHashForShareAbleFile(){

        $def = $this->getShareAbleDef();
        if(!$def){
            return false;
        }

        /**
         * create hash with salt
         */
        $salt = 'd2filessalt';
        if(isset($def['salt'])){
            $salt = 'd2filessalt';            
        }
        
        return hash('sha256',$this->file_name.$this->add_datetime.$this->model_id,$def['salt']);
    }
    
}
