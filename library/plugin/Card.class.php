<?php
abstract class Card
{
	abstract public function add_tpl();
    /* 
    发布
    */

    abstract public function add($data);

    /*
     领取
    */
    abstract public function receive();
    /*
     核销
    */

    abstract public function verification();
    /***
    *   交易展示
    */
    abstract public function homeHtml($data);
}