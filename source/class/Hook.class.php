<?php
class Hook
{  
    private $hooklist = null ;

    public function __construct($import)
    {
    	import_plugin($import);
    }
    // 添加  
    public function add($people)
    {   
    	$people .= 'Card';
        $this->hooklist =  new $people();        
    }  
    // 触发事件  
    public function exec($fun,$arr = array())
    {  
        return call_user_func_array(array($this->hooklist, $fun),$arr);
    }  
}