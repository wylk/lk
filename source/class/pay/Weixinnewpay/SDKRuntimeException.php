<?php
//dezend by http://www.yunlu99.com/ QQ:270656184
class SDKRuntimeException extends Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}

?>