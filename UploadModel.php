<?php

namespace zxp\simditor;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\helpers\FileHelper;

class UploadModel extends Model
{
    public $file;

    private $_fileName;

    public $uploadDir = '@webroot/upload/editor';

    public $uploadUrl = '@web/upload/editor';

    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => ['jpg','png','gif']]
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            return $this->file->saveAs($this->getFilePath($this->getFileName()), true);
        }
        return false;
    }

    public function getResponse()
    {
        return [
            'filelink' =>$this->getUrl($this->getFileName()),
            'filename' => $this->getFileName()
        ];
    }

    public function getFileName()
    {
        if (!$this->_fileName) {
            $fileName = substr(uniqid(md5(rand()), true), 0, 10);
            $fileName .= '-' . Inflector::slug($this->file->baseName);
            $fileName .= '.' . $this->file->extension;
            $this->_fileName = $fileName;
        }
        return $this->_fileName;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstanceByName('upload_file');
            return true;
        }
        return false;
    }

    public function getSaveDir()
    {
        $path = Yii::getAlias($this->uploadDir);
        if(!file_exists($path)){
            if (!FileHelper::createDirectory($path, 0775, $recursive = true )) {
                throw new InvalidConfigException('$uploadDir does not exist and default path creation failed');
            }
        }
        return $path;
    }

    public function getFilePath($fileName)
    {
        return $this->getSaveDir() . DIRECTORY_SEPARATOR . $fileName;
    }

    public function getUrl($fileName)
    {
        return Url::to($this->uploadUrl . '/' . $fileName);
    }
}