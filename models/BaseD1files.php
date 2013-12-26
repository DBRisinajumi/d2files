<?php

/**
 * This is the model base class for the table "d1files".
 *
 * Columns in table "d1files" available as properties of the model:
 * @property string $id
 * @property string $type
 * @property string $file_name
 * @property string $upload_path
 * @property string $add_datetime
 * @property integer $user_id
 * @property integer $deleted
 * @property string $notes
 * @property string $model
 * @property string $model_id
 *
 * There are no model relations.
 */
abstract class BaseD1files extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const TYPE_DOCUMENT = 'Document';
    const TYPE_IMAGE = 'Image';
    const TYPE_OTHER = 'Other';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'd1files';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('type, file_name, upload_path, add_datetime, user_id, model, model_id', 'required'),
                array('deleted, notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('user_id, deleted', 'numerical', 'integerOnly' => true),
                array('type', 'length', 'max' => 8),
                array('file_name', 'length', 'max' => 255),
                array('model, model_id', 'length', 'max' => 20),
                array('notes', 'safe'),
                array('id, type, file_name, upload_path, add_datetime, user_id, deleted, notes, model, model_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->type;
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
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('model', 'ID'),
            'type' => Yii::t('model', 'Type'),
            'file_name' => Yii::t('model', 'File Name'),
            'upload_path' => Yii::t('model', 'Upload Path'),
            'add_datetime' => Yii::t('model', 'Add Datetime'),
            'user_id' => Yii::t('model', 'User'),
            'deleted' => Yii::t('model', 'Deleted'),
            'notes' => Yii::t('model', 'Notes'),
            'model' => Yii::t('model', 'Model'),
            'model_id' => Yii::t('model', 'Model'),
        );
    }

    public function enumLabels()
    {
        return array(
           'type' => array(
               self::TYPE_DOCUMENT => Yii::t('model', 'TYPE_DOCUMENT'),
               self::TYPE_IMAGE => Yii::t('model', 'TYPE_IMAGE'),
               self::TYPE_OTHER => Yii::t('model', 'TYPE_OTHER'),
           ),
            );
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }


    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.type', $this->type, true);
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
