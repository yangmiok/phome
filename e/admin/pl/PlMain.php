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
//CheckLevel($logininid,$loginin,$classid,"pl");

$plr=$empire->fetch1("select pldatatbs,pldeftb from {$dbtbpre}enewspl_set limit 1");
$tr=explode(',',$plr['pldatatbs']);
//��������
$pur=$empire->fetch1("select lasttimepl,lastnumpl,lastnumpltb,todaytimeinfo,todaytimepl,todaynumpl,yesterdaynumpl from {$dbtbpre}enewspublic_up limit 1");
//����������Ϣ
$todaydate=date('Y-m-d');
if(date('Y-m-d',$pur['todaytimeinfo'])<>$todaydate||date('Y-m-d',$pur['todaytimepl'])<>$todaydate)
{
	DoUpdateYesterdayAddDataNum();
	$pur=$empire->fetch1("select lasttimepl,lastnumpl,lastnumpltb,todaytimeinfo,todaytimepl,todaynumpl,yesterdaynumpl from {$dbtbpre}enewspublic_up limit 1");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="PlMain.php<?=$ecms_hashur['whehref']?>">����ͳ��</a></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="10%" height="25" bgcolor="#C9F1FF"><div align="center"><a href="../info/InfoMain.php<?=$ecms_hashur['whehref']?>">��Ϣͳ��</a></div></td>
    <td width="10%" class="header"><div align="center"><a href="../pl/PlMain.php<?=$ecms_hashur['whehref']?>">����ͳ��</a></div></td>
    <td width="10%" bgcolor="#C9F1FF"><div align="center"><a href="../other/OtherMain.php<?=$ecms_hashur['whehref']?>">����ͳ��</a></div></td>
    <td width="58%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="25" colspan="5">���۷���ͳ�� (������������<?=$pur['todaynumpl']?>��������������<?=$pur['yesterdaynumpl']?>) </td>
  </tr>
  <tr class="header">
    <td width="12%" height="25"><div align="center">�ֱ�</div></td>
    <td width="8%"><div align="center">�����</div></td>
    <td width="8%"><div align="center">�����</div></td>
    <td width="8%"><div align="center">����</div></td>
    <td width="64%">�� 
      <?=date('Y-m-d H:i:s',$pur['lasttimepl'])?> 
    ��ֹ�����ڵ���������</td>
  </tr>
	  <?php
	  $j=0;
	  $alltbpls=0;
	  $count=count($tr)-1;
	  for($i=1;$i<$count;$i++)
	  {
	  	$j++;
		$bgcolor='#FFFFFF';
		if($j%2==0)
		{
			$bgcolor='';
		}
		$thistb=$tr[$i];
		$restbname="���۱�".$thistb;
		$pltbname='enewspl_'.$thistb;
		$alltbpls=eGetTableRowNum($dbtbpre.$pltbname);
		$checktbpls=$empire->gettotal("select count(*) as total from ".$dbtbpre.$pltbname." where checked=1");
		$tbpls=$alltbpls-$checktbpls;
		if($thistb==$plr['pldeftb'])
		{
			$restbname='<b>'.$restbname.'</b>';
		}
		$exp='|'.$thistb.',';
		$addnumr=explode($exp,$pur['lastnumpltb']);
		$addnumrt=explode('|',$addnumr[1]);
		$addnum=(int)$addnumrt[0];
		$totalalltbpls+=$alltbpls;
		$totalchecktbpls+=$checktbpls;
		$totaltbpls+=$tbpls;
	  ?>
  <tr bgcolor="<?=$bgcolor?>"> 
    <td height="25">
		<div align="center"><a href="ListAllPl.php?restb=<?=$tr[$i]?><?=$ecms_hashur['ehref']?>" title="*<?=$pltbname?>" target="_blank">
	    <?=$restbname?>
    </a></div></td>
    <td align="right"><div align="right"><a href="ListAllPl.php?restb=<?=$tr[$i]?>&checked=1<?=$ecms_hashur['ehref']?>" target="_blank"><?=$tbpls?></a></div></td>
    <td align="right"><div align="right"><a href="ListAllPl.php?restb=<?=$tr[$i]?>&checked=2<?=$ecms_hashur['ehref']?>" target="_blank"><?=$checktbpls?></a></div></td>
    <td align="right"><a href="ListAllPl.php?restb=<?=$tr[$i]?><?=$ecms_hashur['ehref']?>" target="_blank"><?=$alltbpls?></a></td>
    <td><table width="320" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40%" align="right"><?=$addnum?></td>
          <td width="60%"><div align="center"></div></td>
        </tr>
    </table></td>
  </tr>
	  <?php
	  }
	  ?>
  <tr class="header">
    <td height="25"><div align="right">�ܼƣ�</div></td>
    <td align="right"><div align="right"><?=$totaltbpls?></div></td>
    <td align="right"><div align="right"><?=$totalchecktbpls?></div></td>
    <td align="right"><?=$totalalltbpls?></td>
    <td><table width="320" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40%" align="right"><font color="#FFFFFF"><b><?=$pur['lastnumpl']?></b></font></td>
          <td width="60%"><div align="center">
            <input type="button" name="Submit" value="���ý�ֹͳ��" onclick="if(confirm('ȷ��Ҫ����������ͳ��?')){self.location.href='../ecmscom.php?enews=ResetAddDataNum&type=pl&from=pl/PlMain.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>';}">
          </div></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="23"><font color="#666666">˵�������������ˡ�����δ��ˡ������������ɽ�����Ӧ�Ĺ���</font></td>
  </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>