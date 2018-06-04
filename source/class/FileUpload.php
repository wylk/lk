<?php 
namespace app\vendor\org; 
  /**  
    file: fileupload.class.php �ļ��ϴ���FileUpload 
    �����ʵ���������ڴ����ϴ��ļ��������ϴ�һ���ļ���Ҳ��ͬʱ�������ļ��ϴ� 
  */  
class FileUpload {   
    private $path = "./uploads";          //�ϴ��ļ������·��  
    private $allowtype = array('jpg','gif','png'); //���������ϴ��ļ�������  
    private $maxsize = 1000000;           //�����ļ��ϴ���С���ֽڣ�  
    private $israndname = true;           //�����Ƿ�����������ļ��� false�����  
    
    private $originName;              //Դ�ļ���  
    private $tmpFileName;              //��ʱ�ļ���  
    private $fileType;               //�ļ�����(�ļ���׺)  
    private $fileSize;               //�ļ���С  
    private $newFileName;              //���ļ���  
    private $errorNum = 0;             //�����  
    private $errorMess="";             //���󱨸���Ϣ  
    
    /** 
     * �������ó�Ա���ԣ�$path, $allowtype,$maxsize, $israndname�� 
     * ����ͨ���������һ�����ö������ֵ 
     *@param  string $key  ��Ա������(�����ִ�Сд) 
     *@param  mixed  $val  Ϊ��Ա�������õ�ֵ 
     *@return  object     �����Լ�����$this����������������� 
     */  
    function set($key, $val){  
      $key = strtolower($key);   
      if( array_key_exists( $key, get_class_vars(get_class($this) ) ) ){  
        $this->setOption($key, $val);  
      }  
      return $this;  
    }  
    
    /** 
     * ���ø÷����ϴ��ļ� 
     * @param  string $fileFile  �ϴ��ļ��ı�����  
     * @return bool        ����ϴ��ɹ�������true  
     */  
    
    function upload($fileField) {  
      $return = true;  
      /* ����ļ�·�����ͺϷ� */  
      if( !$this->checkFilePath() ) {         
        $this->errorMess = $this->getError();  
        return false;  
      }  
      /* ���ļ��ϴ�����Ϣȡ���������� */  
      $name = $_FILES[$fileField]['name']; //�ϴ��ļ����ļ��� 'Chrysanthemum.jpg'  
      $tmp_name = $_FILES[$fileField]['tmp_name']; //����������ʱ�ļ����·�� 'D:\wamp\tmp\php71E6.tmp'   
      $size = $_FILES[$fileField]['size']; //�ϴ��ļ��Ĵ�С 879394   858 KB (879,394 �ֽ�)  
      $error = $_FILES[$fileField]['error']; //������Ϣ 0  
    
      /* ����Ƕ���ļ��ϴ���$file["name"]����һ������ */  
      if(is_Array($name)){      
        $errors=array();  
        /*����ļ��ϴ���ѭ������ �� ���ѭ��ֻ�м���ϴ��ļ������ã���û�������ϴ� */  
        for($i = 0; $i < count($name); $i++){   
          /*�����ļ���Ϣ */  
          if($this->setFiles($name[$i],$tmp_name[$i],$size[$i],$error[$i] )) {  
            if(!$this->checkFileSize() || !$this->checkFileType()){  
              $errors[] = $this->getError();  
              $return=false;   
            }  
          }else{  
            $errors[] = $this->getError();  
            $return=false;  
          }  
          /* ��������⣬�����³�ʹ������ */  
          if(!$return)            
            $this->setFiles();  
        }  
    
        if($return){  
          /* ��������ϴ����ļ����ı������� */  
          $fileNames = array();        
          /* ����ϴ��Ķ���ļ����ǺϷ��ģ���ͨ��ѭ����������ϴ��ļ� */  
          for($i = 0; $i < count($name); $i++){   
            if($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i] )) {  
              $this->setNewFileName();   
              if(!$this->copyFile()){  
                $errors[] = $this->getError();  
                $return = false;  
              }  
              $fileNames[] = $this->newFileName;    
            }            
          }  
          $this->newFileName = $fileNames;  
        }  
        $this->errorMess = $errors;  
        return $return;  
      /*�ϴ������ļ�������*/  
      } else {  
        /* �����ļ���Ϣ */  
        if($this->setFiles($name,$tmp_name,$size,$error)) {  
          /* �ϴ�֮ǰ�ȼ��һ�´�С������ */  
          if($this->checkFileSize() && $this->checkFileType()){   
            /* Ϊ�ϴ��ļ��������ļ��� */  
            $this->setNewFileName();   
            /* �ϴ��ļ�  ����0Ϊ�ɹ��� С��0��Ϊ���� */  
            if($this->copyFile()){   
              return true;  
            }else{  
              $return=false;  
            }  
          }else{  
            $return=false;  
          }  
        } else {  
          $return=false;   
        }  
        //���$returnΪfalse, �������������Ϣ����������errorMess��  
        if(!$return)  
          $this->errorMess=$this->getError();    
    
        return $return;  
      }  
    }  
    
    /**  
     * ��ȡ�ϴ�����ļ����� 
     * @param  void   û�в��� 
     * @return string �ϴ������ļ������ƣ� ����Ƕ��ļ��ϴ��������� 
     */  
    public function getFileName(){  
      return $this->newFileName;  
    }  
    
    /** 
     * �ϴ�ʧ�ܺ󣬵��ø÷����򷵻أ��ϴ�������Ϣ 
     * @param  void   û�в��� 
     * @return string  �����ϴ��ļ��������Ϣ���棬����Ƕ��ļ��ϴ��������� 
     */  
    public function getErrorMsg(){  
      return $this->errorMess;  
    }  
    
    /* �����ϴ�������Ϣ */  
    private function getError() {  
      $str = "�ϴ��ļ�<font color='red'>{$this->originName}</font>ʱ���� : ";  
      switch ($this->errorNum) {  
        case 4: $str .= "û���ļ����ϴ�"; break;  
        case 3: $str .= "�ļ�ֻ�в��ֱ��ϴ�"; break;  
        case 2: $str .= "�ϴ��ļ��Ĵ�С������HTML����MAX_FILE_SIZEѡ��ָ����ֵ"; break;  
        case 1: $str .= "�ϴ����ļ�������php.ini��upload_max_filesizeѡ�����Ƶ�ֵ"; break;  
        case -1: $str .= "δ��������"; break;  
        case -2: $str .= "�ļ�����,�ϴ����ļ����ܳ���{$this->maxsize}���ֽ�"; break;  
        case -3: $str .= "�ϴ�ʧ��"; break;  
        case -4: $str .= "��������ϴ��ļ�Ŀ¼ʧ�ܣ�������ָ���ϴ�Ŀ¼"; break;  
        case -5: $str .= "����ָ���ϴ��ļ���·��"; break;  
        default: $str .= "δ֪����";  
      }  
      return $str.'<br>';  
    }  
    
    /* ���ú�$_FILES�йص����� */  
    private function setFiles($name="", $tmp_name="", $size=0, $error=0) {  
      $this->setOption('errorNum', $error);  
      if($error)  
        return false;  
      $this->setOption('originName', $name);  
      $this->setOption('tmpFileName',$tmp_name);  
      $aryStr = explode(".", $name);  
      $this->setOption('fileType', strtolower($aryStr[count($aryStr)-1]));  
      $this->setOption('fileSize', $size);  
      return true;  
    }  
    
    /* Ϊ������Ա��������ֵ */  
    private function setOption($key, $val) {  
      $this->$key = $val;  
    }  
    
    /* �����ϴ�����ļ����� */  
    private function setNewFileName() {  
      if ($this->israndname) {  
        $this->setOption('newFileName', $this->proRandName());    
      } else{   
        $this->setOption('newFileName', $this->originName);  
      }   
    }  
    
    /* ����ϴ����ļ��Ƿ��ǺϷ������� */  
    private function checkFileType() {  
      if (in_array(strtolower($this->fileType), $this->allowtype)) {  
        return true;  
      }else {  
        $this->setOption('errorNum', -1);  
        return false;  
      }  
    }  
    
    /* ����ϴ����ļ��Ƿ�������Ĵ�С */  
    private function checkFileSize() {  
      if ($this->fileSize > $this->maxsize) {  
        $this->setOption('errorNum', -2);  
        return false;  
      }else{  
        return true;  
      }  
    }  
    
    /* ����Ƿ��д���ϴ��ļ���Ŀ¼ */  
    private function checkFilePath() {  
      if(empty($this->path)){  
        $this->setOption('errorNum', -5);  
        return false;  
      }  
      if (!file_exists($this->path) || !is_writable($this->path)) {  
        if (!@mkdir($this->path, 0755)) {  
          $this->setOption('errorNum', -4);  
          return false;  
        }  
      }  
      return true;  
    }  
    
    /* ��������ļ��� */  
    private function proRandName() {      
      $fileName = date('YmdHis')."_".rand(1000,9999);      
      return $fileName.'.'.$this->fileType;   
    }  
    
    /* �����ϴ��ļ���ָ����λ�� */  
    private function copyFile() {  
      if(!$this->errorNum) {  
        $path = rtrim($this->path, '/').'/';  
        $path .= $this->newFileName;  
        if (@move_uploaded_file($this->tmpFileName, $path)) {  
          return true;  
        }else{  
          $this->setOption('errorNum', -3);  
          return false;  
        }  
      } else {  
        return false;  
      }  
    }  
  }  