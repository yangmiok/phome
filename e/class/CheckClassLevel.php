<?php
if(!defined('empirecms'))
{
	exit();
}
//�۵�
require_once($check_path."e/class/connect.php");
if(!defined('InEmpireCMS'))
{
	exit();
}
require_once(ECMS_PATH."e/class/db_sql.php");
$check_classid=(int)$check_classid;
$toreturnurl=eReturnSelfPage(0);	//����ҳ���ַ
$gotourl=$ecms_config['member']['loginurl']?$ecms_config['member']['loginurl']:$public_r['newsurl']."e/member/login/";	//��½��ַ
$loginuserid=(int)getcvar('mluserid');
$logingroupid=(int)getcvar('mlgroupid');
if(!$loginuserid)
{
	printerror2('����Ŀ��Ҫ��Ա�������ϲ��ܲ鿴','');
}
if(!strstr($check_groupid,','.$logingroupid.','))
{
	printerror2('��û���㹻Ȩ�޲鿴����Ŀ','');
}
?>