<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
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
CheckLevel($logininid,$loginin,$classid,"f");
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">�ֶι���</a>";
$sql=$empire->query("select * from {$dbtbpre}enewsf where tid='$tid' order by myorder,fid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����ֶ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmod.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td class="emenubutton"><input type="button" name="Submit2" value="�����ֶ�" onclick="self.location.href='AddF.php?enews=AddF&tid=<?=$tid?>&tbname=<?=$tbname?><?=$ecms_hashur['ehref']?>';"></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="6%" height="25"><div align="center">˳��</div></td>
      <td width="8%"><div align="center">��</div></td>
      <td width="29%" height="25"><div align="center">�ֶ���</div></td>
      <td width="20%"><div align="center">�ֶα�ʶ</div></td>
      <td width="15%"> <div align="center">�ֶ�����</div></td>
      <td width="8%"><div align="center">�ɼ���</div></td>
      <td width="14%" height="25"><div align="center">����</div></td>
    </tr>
    <?php
  	while($r=$empire->fetch($sql))
  	{
  		$ftype=$r[ftype];
  		if($r[flen])
  		{
			if($r[ftype]!="TEXT"&&$r[ftype]!="MEDIUMTEXT"&&$r[ftype]!="LONGTEXT"&&$r[ftype]!="DATE"&&$r[ftype]!="DATETIME")
			{
				$ftype.="(".$r[flen].")";
			}
  		}
  		if($r[iscj])
  		{$iscj="��";}
  		else
  		{$iscj="��";}
  		if($r[isadd])
  		{
  			$do="[<a href='AddF.php?tid=$tid&tbname=$tbname&enews=EditF&fid=".$r[fid].$ecms_hashur['ehref']."'>�޸�</a>]&nbsp;&nbsp;[<a href='../ecmsmod.php?tid=$tid&tbname=$tbname&enews=DelF&fid=".$r[fid].$ecms_hashur['href']."' onclick=\"return confirm('ȷ��Ҫɾ����');\">ɾ��</a>]";
 		 }
  		else
  		{
  			$ftype="ϵͳ�ֶ�";
  			$r[f]="<a title='ϵͳ�ֶ�'><font color=red>".$r[f]."</font></a>";
  			$do="<a href='EditSysF.php?tid=$tid&tbname=$tbname&fid=".$r[fid].$ecms_hashur['ehref']."'><font color=red>[�޸�ϵͳ�ֶ�]</font></a>";
  		}
  		if($r[tbdataf]==1)
  		{
  			$tbdataf=$r[isadd]?"<a href='ChangeDataTableF.php?tid=$tid&tbname=$tbname&fid=".$r[fid].$ecms_hashur['ehref']."' title='������ֶ�ת�Ƶ�����'>����</a>":"����";
  		}
  		else
  		{
			$tbdataf=$r[isadd]?"<a href='ChangeDataTableF.php?tid=$tid&tbname=$tbname&fid=".$r[fid].$ecms_hashur['ehref']."' title='������ֶ�ת�Ƶ�����'>����</a>":"����";
  		}
  ?>
    <tr bgcolor="#ffffff" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"><div align="center"> 
          <input name="myorder[]" type="text" id="myorder[]" value="<?=$r[myorder]?>" size="3">
          <input type=hidden name=fid[] value=<?=$r[fid]?>>
        </div></td>
      <td><div align="center">
          <?=$tbdataf?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[f]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[fname]?>
        </div></td>
      <td><div align="center"> 
          <?=$ftype?>
        </div></td>
      <td><div align="center"> 
          <?=$iscj?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$do?>
        </div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="ffffff"> 
      <td height="25">&nbsp;</td>
      <td height="25" colspan="6"><input type="submit" name="Submit" value="�޸��ֶ�˳��">
        <input name="enews" type="hidden" id="enews" value="EditFOrder"> <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> 
        <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"></td>
    </tr>
    <tr bgcolor="ffffff">
      <td height="25">&nbsp;</td>
      <td height="25" colspan="6"><font color="#666666">˵����˳��ֵԽСԽ��ʾǰ�棬��ɫ�ֶ���Ϊϵͳ�ֶΣ����������/���������Խ����ֶ�ת��.</font></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
      <td><div align="center"> [<a href="javascript:window.close();">�ر�</a>] </div></td>
    </tr>
  </table>
</body>
</html>
<?
db_close();
$empire=null;
?>
