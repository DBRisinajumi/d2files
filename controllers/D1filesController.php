<?php

class D1filesController extends Controller {
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('create', 'admin', 'view', 'update', 'editableSaver', 'delete'),
                'roles' => array('D1files.D1files.*'),
            ),
            array(
                'allow',
                'actions' => array('create'),
                'roles' => array('D1files.D1files.Create'),
            ),
            array(
                'allow',
                'actions' => array('view', 'admin'), // let the user view the grid
                'roles' => array('D1files.D1files.View'),
            ),
            array(
                'allow',
                'actions' => array('update', 'editableSaver'),
                'roles' => array('D1files.D1files.Update'),
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles' => array('D1files.D1files.Delete'),
            ),
            array(
                'allow',
                'actions' => array('widgetDelete'),
                'roles' => array('D1files.D1files.Delete'),
            ),
            array(
                'allow',
                'actions' => array('upload', 'DeleteFile','DownloadFile'),
                'users' => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        if ($this->module !== null) {
            $this->breadcrumbs[$this->module->Id] = array('/' . $this->module->Id);
        }
        return true;
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render( 'view', array(
            'model' => $model,
            'photos' => $photos,
        ) );        
        
        
        //$this->render('view', array('model' => $model,));
    }

    public function actionCreate() {
        $model = new D1files;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'd1files-form');

        if (isset($_POST['D1files'])) {
            $model->attributes = $_POST['D1files'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('id', $e->getMessage());
            }
        } elseif (isset($_GET['D1files'])) {
            $model->attributes = $_GET['D1files'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'd1files-form');

        if (isset($_POST['D1files'])) {
            $model->attributes = $_POST['D1files'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model,));
    }

    public function actionEditableSaver() {
        Yii::import('TbEditableSaver');
        $es = new TbEditableSaver('D1files'); // classname of model to be updated
        $es->update();
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($id)->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!isset($_GET['ajax'])) {
                if (isset($_GET['returnUrl'])) {
                    $this->redirect($_GET['returnUrl']);
                } else {
                    $this->redirect(array('admin'));
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('D1filesModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin() {
        $model = new D1files('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['D1files'])) {
            $model->attributes = $_GET['D1files'];
        }

        $this->render('admin', array('model' => $model,));
    }
    
    public function loadModel($id) {
        $m = D1files::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('D1filesModule.crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'd1files-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
