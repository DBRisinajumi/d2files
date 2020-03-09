<?php
/**
 * extended UploadHandler 
 */
Yii::import('vendor.blueimp.jquery-file-upload.server.php.UploadHandler');
class UploadHandlerD2files extends UploadHandler {

    function __construct($options = null) {
        
        //izveido direktoriju
        $options['upload_dir'] = self::getUploadDirPath($options['model_name']); 
        $options['accept_file_types'] = Yii::app()->getModule('d2files')->accept_file_types; 
        
        
        //lai netaisa thumb...
        $options['image_versions'] = array();

        parent::__construct($options, TRUE);
    }

    static function getUploadDirPath($model_name){
        $upload_dir_parh = realpath(Yii::getPathOfAlias(Yii::app()->getModule('d2files')->upload_dir));
        return  $upload_dir_parh 
                    . DIRECTORY_SEPARATOR 
                    . $model_name 
                    . DIRECTORY_SEPARATOR;
        
    }
    
    static function deleteFile($id, $notes = null){
        $m = D2files::model();
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t("D2filesModule.model","The requested record does not exist."));
        }
        $model->deleted = 1;
        if ($notes) {
            $model->notes = $notes;
        }
        $model->save();
    }
    
    public function post($print_response = true) {
        //if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
        //    return $this->delete($print_response);
        //}
        
        // validate create action access
//        if (!Yii::app()->user->checkAccess($this->options['model_name'] . '.create')) {
//            throw new CHttpException(403, Yii::t("D2filesModule.model","You are not authorized to perform this action."));
//        }
        D2files::extendedCheckAccess($this->options['model_name'] . '.uploadD2File');        
        
        $upload = isset($_FILES[$this->options['param_name']]) ?
                $_FILES[$this->options['param_name']] : null;
        // Parse the Content-Disposition header, if available:
        $file_name = isset($_SERVER['HTTP_CONTENT_DISPOSITION']) ?
                rawurldecode(preg_replace(
                                '/(^[^"]+")|("$)/', '', $_SERVER['HTTP_CONTENT_DISPOSITION']
                        )) : null;
        $file_type = isset($_SERVER['HTTP_CONTENT_DESCRIPTION']) ?
                $_SERVER['HTTP_CONTENT_DESCRIPTION'] : null;
        // Parse the Content-Range header, which has the following form:
        // Content-Range: bytes 0-524287/2000000
        $content_range = isset($_SERVER['HTTP_CONTENT_RANGE']) ?
                preg_split('/[^0-9]+/', $_SERVER['HTTP_CONTENT_RANGE']) : null;
        $size = $content_range ? $content_range[3] : null;
        $info = array();
        if ($upload && is_array($upload['tmp_name'])) {
            // param_name is an array identifier like "files[]",
            // $_FILES is a multi-dimensional array:
           
            foreach ($upload['tmp_name'] as $index => $value) {

                $sFileName = $upload['name'][$index];
                
                //save to DB
                $nFileId = $this->saveToDb($sFileName, $this->options['model_name'], $this->options['model_id']);

                // save file
                $save_file_name = self::createSaveFileName($nFileId,$sFileName);
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index], $save_file_name, $size ? $size : $upload['size'][$index], 'dat', $upload['error'][$index], $index, $content_range
                );
                if (!empty($info[count($info) - 1]->error)) {
                    $this->deleteFile($nFileId, 'Error: ' . $info[count($info) - 1]->error);
                } else {
                    $info[count($info) - 1]->name = $sFileName;
                    $info[count($info) - 1]->id = $nFileId;
                }
            }
        } else {
            // param_name is a single object identifier like "file",
            // $_FILES is a one-dimensional array:
            $file_name = $file_name ? $file_name : (isset($upload['name']) ? $upload['name'] : null);
            $sFileName = $file_name;

            $nFileId = $this->saveToDb($sFileName, $this->options['model_name'], $this->options['model_id']);
            $save_file_name = self::createSaveFileName($nFileId,$sFileName);
            $info[] = $this->handle_file_upload(
                isset($upload['tmp_name']) ? $upload['tmp_name'] : null, $file_name, $size ? $size : (isset($upload['size']) ? $upload['size'] :
                $_SERVER['CONTENT_LENGTH']), $file_type ? $file_type : (isset($upload['type']) ? $upload['type'] : $_SERVER['CONTENT_TYPE']), isset($upload['error']) ? $upload['error'] : null, null, $content_range
            );
            if (!empty($info[count($info) - 1]->error)) {
                $this->deleteFile($nFileId, 'Error: ' . $info[count($info) - 1]->error);
            } else {
                $info[count($info) - 1]->name = $sFileName;
                $info[count($info) - 1]->id = $nFileId;
            }

        }
        return $this->generate_response($info, $print_response);
    }
    
    static function createSaveFileName($d2files_id, $file_name) {
        $a = explode('.',$file_name);
        return 'd2_' . $d2files_id . '.' . array_pop($a);
    }

    /**
     * save file info in DB
     * @param char $file_name
     * @param char $model_name
     * @param int $model_id
     * @return int record id
     * @throws CHttpException
     */
    public function saveToDb($file_name,$model_name,$model_id) {
        $model = new D2files;
        $model->file_name = $file_name;
        $model->upload_path = 'tttt';
        $model->add_datetime = date('Y.m.d H:i:s');
        $model->user_id = Yii::app()->user->id;
        $model->model = $model_name;
        $model->model_id = $model_id;
        try {
            $model->save();
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
        
        return $model->primaryKey;
    }
    
    public function get($print_response = true) {
        if (!$this->options['download_via_php']) {
            $this->header('HTTP/1.1 403 Forbidden');
            return;
        }
        $file_path = $this->options['upload_dir'] 
                . self::createSaveFileName($this->options['model_id'],$this->options['file_name']);
        $file_type = $this->get_file_type($this->options['file_name']);
        
        if (is_file($file_path)) {
            if (!preg_match($this->options['inline_file_types'], $file_type)) {
                $this->header('Content-Description: File Transfer');
                $this->header('Content-Type: application/octet-stream');
                $this->header('Content-Disposition: attachment; filename="'.$this->options['file_name'].'"');
                $this->header('Content-Transfer-Encoding: binary');
            } else {
                // Prevent Internet Explorer from MIME-sniffing the content-type:
                $this->header('X-Content-Type-Options: nosniff');
                $this->header('Content-Type: '.$file_type);
                $this->header('Content-Disposition: inline; filename="'.$this->options['file_name'].'"');
            }
            $this->header('Content-Length: '.$this->get_file_size($file_path));
            $this->header('Last-Modified: '.gmdate('D, d M Y H:i:s T', filemtime($file_path)));
            $this->readfile($file_path);
        }

    }    

}