<?php

/**
 * This is the model base class for the table "d2files".
 *
 * Columns in table "d2files" available as properties of the model:
 * @property string $id
 * @property integer $type_id
 * @property string $file_name
 * @property string $upload_path
 * @property string $add_datetime
 * @property integer $user_id
 * @property integer $deleted
 * @property string $notes
 * @property string $model
 * @property string $model_id
 *
 * Relations of table "d2files" available as properties of the model:
 * @property D2filesType $type
 */
abstract class BaseD2files extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'd2files';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('file_name, upload_path, add_datetime, user_id, model, model_id', 'required'),
                array('type_id, deleted, notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('type_id, user_id, deleted', 'numerical', 'integerOnly' => true),
                array('file_name', 'length', 'max' => 255),
                array('model', 'length', 'max' => 50),
                array('model_id', 'length', 'max' => 20),
                array('notes', 'safe'),
                array('id, type_id, file_name, upload_path, add_datetime, user_id, deleted, notes, model, model_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->file_name;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'type' => array(self::BELONGS_TO, 'D2filesType', 'type_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('D2filesModule.model', 'ID'),
            'type_id' => Yii::t('D2filesModule.model', 'Type'),
            'file_name' => Yii::t('D2filesModule.model', 'File Name'),
            'upload_path' => Yii::t('D2filesModule.model', 'Upload Path'),
            'add_datetime' => Yii::t('D2filesModule.model', 'Add Datetime'),
            'user_id' => Yii::t('D2filesModule.model', 'User'),
            'deleted' => Yii::t('D2filesModule.model', 'Deleted'),
            'notes' => Yii::t('D2filesModule.model', 'Notes'),
            'model' => Yii::t('D2filesModule.model', 'Model'),
            'model_id' => Yii::t('D2filesModule.model', 'Model'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.type_id', $this->type_id);
        $criteria->compare('t.file_name', $this->file_name, true);
        $criteria->compare('t.upload_path', $this->upload_path, true);
        $criteria->compare('t.add_datetime', $this->add_datetime, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.deleted', $this->deleted);
        $criteria->compare('t.notes', $this->notes, true);
        $criteria->compare('t.model', $this->model, true);
        $criteria->compare('t.model_id', $this->model_id, true);


        return $criteria;

    }

}
