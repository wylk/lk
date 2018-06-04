<?php
    header("Content-Type:text/html;charset=utf8");
    include "TopSdk.php";
    include_once('./top/request/AlibabaAliqinFcSmsNumSendRequest.php');
    date_default_timezone_set('Asia/Shanghai');
    $c = new TopClient;
    $c->appkey = '23662099';
    $c->secretKey = '3e8caefde3de13e6c095db0b52061290';
    $req = new AlibabaAliqinFcSmsNumSendRequest;
    $req ->setExtend( "" );
    $req ->setSmsType( "normal" );
    $req ->setSmsFreeSignName( "E派速达" );
    $req ->setSmsParam( "{code:'1111',product:'lalala'}" );
    $req ->setRecNum( "18094259843" );
    $req ->setSmsTemplateCode( "SMS_51390009" );
    $resp = $c ->execute( $req );
    var_dump($c->execute($req));
?>