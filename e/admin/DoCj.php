<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"cj");
$add=$_GET;
$classid=$add['classid'];
$count=count($classid);
if(!$count)
{
	printerror("NotChangeCjid","history.go(-1)");
}
$add['from']=ehtmlspecialchars($add['from']);
esetcookie("recjnum",$count,0,1);
$url="ecmscj.php?enews=CjUrl".$ecms_hashur['href'];
echo"<center><b>�ɼ��ڵ���ܸ���Ϊ:<font color=red>$count</font>����</b>&nbsp;&nbsp; (<a href='ReHtml/ChangeData.php".$ecms_hashur['whehref']."#ReIfInfoHtml' target=_blank>���ݸ�������</a>)</center><br>";
for($i=0;$i<$count;$i++)
{
	$classid[$i]=(int)$classid[$i];
	$trueurl=$url."&from=$add[from]&classid=".$classid[$i];
	echo"<iframe frameborder=0 height=35 name='class".$classid[$i]."' scrolling=no 
            src=\"".$trueurl."\" 
            width=\"100%\"></iframe><br>";
}
db_close();
$empire=null;
?>
<iframe frameborder=0 height=35 name="checkrecj" scrolling=no 
            src="CheckReCj.php?first=1&from=<?=$add[from]?><?=$ecms_hashur['href']?>" 
            width="100%"></iframe>