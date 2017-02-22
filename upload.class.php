<?php
require_once 'thumb.class.php';
class upload
{

    protected $fileInfo;

    protected $fileName;

    protected $imageFlag;

    protected $maxSize;

    protected $allowExt;

    protected $allowMime;

    protected $uploadPath;

    protected $error;

    protected $ext;

    protected $uniName;

    protected $thumb ;
    
    public $destination;

    /**
     *
     * @param string $fileName            
     * @param string $uploadPath            
     * @param number $maxSize            
     * @param array $allowExt            
     * @param array $allowMime            
     * @param string $imageFlag            
     */
    public function __construct ($fileName = 'myFile', $uploadPath = "./uploads", 
            $maxSize = 5242880, $allowExt = array('jpeg','jpg','png','gif'), 
            $allowMime = array('image/jpeg','image/jpg','image/png','image/gif'), $imageFlag = true)
    {
        $this->fileName = $fileName;
        $this->maxSize = $maxSize;
        $this->allowMime = $allowMime;
        $this->allowExt = $allowExt;
        $this->uploadPath = $uploadPath;
        $this->imageflag = $imageFlag;
        $this->fileInfo = $_FILES[$this->fileName];
    }

    /**
     * 检测是否有错
     *
     * @return boolean
     *
     */
    protected function checkError ()
    {
        if (! is_null($this->fileInfo))
            if ($this->fileInfo['error'] > 0) {
                switch ($this->fileInfo['error']) {
                    case 1:
                        $this->error = "UPLOAD_ERR_INI_SIZE文件大小超过服务器限制大小";
                        break;
                    case 2:
                        $this->error = 'UPLOAD_ERR_FORM_SIZE文件超过表单限制大小';
                        break;
                    case 3:
                        $this->error = "UPLOAD_ERR_PARTIAL上传了部分文件";
                        break;
                    case 4:
                        $this->error = 'UPLOAD_ERR_NO_FILE空文件';
                        break;
                    case 6:
                        $this->error = 'UPLOAD_ERR_NO_TMP_DIR没有临时存放目录';
                        break;
                    case 7:
                        
                        $this->error = 'UPLOAD_ERR_CANT_WRITE系统错误';
                        break;
                    case 8:
                        $this->error = 'UPLOAD_ERR_EXTENSION系统错误';
                        break;
                }
                
                return false;
            } else
                return true;
        else {
            $this->error = "文件上传出错";
            return false;
        }
    }

    /**
     * 检测文件大小是否符合要求
     *
     * @return boolean
     */
    protected function checkSize ()
    {
        if ($this->fileInfo['size'] > $this->maxSize) {
            $this->error = "文件过大";
            return FALSE;
        }
        return true;
    }

    /**
     * 检测扩展名
     *
     * @return boolean
     */
    protected function checkExt ()
    {
        $this->ext=strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
        
        if (! in_array($this->ext, $this->allowExt)) {
            $this->error = '不允许的扩展名';
            return false;
        }
        return true;
    }

    /**
     * 检测文件类型
     *
     * @return boolean
     */
    protected function checkMime ()
    {
        if (! in_array($this->fileInfo['type'], $this->allowMime)) {
            $this->error = '不允许的文件类型';
            return false;
        }
        return true;
    }

    /**
     * 检查室不是真实图片
     *
     * @return boolean
     */
    protected function checkTrueImg ()
    {
        if ($this->imageFlag == true)
            if (! ($this->ext = @getimagesize($$this->fileInfo['tmp_name']))) {
                $this->error = '不是真实图片';
                return false;
            }
        
        return true;
    }

    /**
     * 检查文件是否通过HTTPPost上传
     *
     * @return boolean
     */
    protected function checkHTTPPost ()
    {
        if (! is_uploaded_file($this->fileInfo['tmp_name'])) {
            $this->error = "文件不是通过HTTP Post 方式上传";
            return false;
        }
        return true;
    }

    /**
     * 显示错误
     */
    protected function showError ()
    {
        exit('<span style="color:red">' . $this->error . '</span>');
    }

    /**
     * 检测目录存不存在，不存在则添加目录
     */
    protected function checkUploadPath ()
    {
        if (! file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    /**
     * 产生唯一字符串作为文件名
     * 
     * @return string
     */
    protected function getUniName ()
    {
        return $this->uniName = md5(uniqid(microtime(true), true));
    }

    public function uploadFile ()
    {
        if ($this->checkError() && $this->checkSize() && $this->checkExt() &&
                 $this->checkMime() && $this->checkTrueImg()  &&
                 $this->checkHTTPPost()) {
                 
            $this->checkUploadPath();
            $this->uniName = $this->getUniName();
            $this->destination = $this->uploadPath . '/' . $this->uniName . "." .$this->ext;
            if (@move_uploaded_file($this->fileInfo['tmp_name'], 
                    $this->destination)){

                return $this->destination;}
            else {
                $this->error = "文件移动失败";
                $this->showError();
            }
        } 

        else {
            $this->showError();
        }
    }
}