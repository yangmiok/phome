<?php
require("../class/connect.php");
require("../class/db_sql.php");
$link=db_connect();
$empire=new mysqlquery();
//����ģ��
require(ECMS_PATH.'e/template/DoInfo/DoInfo.php');
db_close();
$empire=null;
?>