<?php
define('EmpireCMSAdmin','1');
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php');
require('../../data/dbcache/class.php');
require('../../data/dbcache/MemberLevel.php');
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

$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
if(empty($class_r[$classid][classid])||!$id)
{
	printerror("ErrorUrl","history.go(-1)");
}
if(!$class_r[$classid][tbname]||!$class_r[$classid][classid])
{
	printerror("ErrorUrl","history.go(-1)");
}
//���ռ���Ŀ
if(!$class_r[$classid]['islast'])
{
	printerror("AddInfoErrorClassid","history.go(-1)");
}
$bclassid=$class_r[$classid][bclassid];
$fun_r['AdminInfo']='������Ϣ';
//ģ��
$fieldexp="<!--field--->";
$recordexp="<!--record-->";
$tbname=$class_r[$classid][tbname];
$mid=$class_r[$classid][modid];
$mr=$empire->fetch1("select enter,tbname from {$dbtbpre}enewsmod where mid='$mid'");
if(empty($mr['tbname']))
{
	printerror("ErrorUrl","history.go(-1)");
}
$enter=$mr['enter'];
$savetxtf=$emod_r[$mid]['savetxtf'];
//����
$url=AdminReturnClassLink($classid).'&nbsp;>&nbsp;�鿴��Ϣ';
//״̬
$addecmscheck='';
$ecmscheck=(int)$_GET['ecmscheck'];
$indexchecked=1;
if($ecmscheck)
{
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}

//������
$index_r=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$tbname."_index where id='$id' limit 1");
if(!$index_r['id']||$index_r['classid']!=$classid)
{
	printerror("ErrorUrl","history.go(-1)");
}
//���ر�
$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");

$wfinfor=$empire->fetch1("select id,tid,groupid,userclass,username,tstatus,checktno from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid' limit 1");
if(!$wfinfor['id'])
{
	printerror('ErrorUrl','history.go(-1)');
}
//������
$cwfitemr=$empire->fetch1("select wfid,groupid,userclass,username from {$dbtbpre}enewsworkflowitem where tid='$wfinfor[tid]'");
//��֤Ȩ��
if(strstr(','.$cwfitemr[groupid].',',','.$lur[groupid].',')||strstr(','.$cwfitemr[userclass].',',','.$lur[classid].',')||strstr(','.$cwfitemr[username].',',','.$lur[username].','))
{
}
else
{
	$doselfinfo=CheckLevel($logininid,$loginin,$classid,"news");
}

$r[newstime]=date("Y-m-d H:i:s",$r[newstime]);
//���ر���Ϣ
$infodatatb=ReturnInfoDataTbname($tbname,$index_r['checked'],$r['stb']);
//����
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$infodatatb." where id='$id' limit 1");
$r=array_merge($r,$finfor);
//���ݴ��ı�
if($savetxtf)
{
	$r[$savetxtf]=GetTxtFieldText($r[$savetxtf]);
}
//������
if($r[ismember])
{
	$username=empty($r[userid])?'�ο�':"��Ա��<a href='../member/AddMember.php?enews=EditMember&userid=".$r[userid].$ecms_hashur['ehref']."' target='_blank'>".$r[username]."</a>";
}
else
{
	$username="<a href='../user/AddUser.php?enews=EditUser&userid=".$r[userid].$ecms_hashur['ehref']."' target='_blank'>".$r[username]."</a>";
}
//״̬
$st='';
if($index_r[checked])//���
{
	$st.="[�����]&nbsp;&nbsp;";
}
else
{
	$st.="[δ���]&nbsp;&nbsp;";
}
if($r[istop])//�ö�
{
	$st.="[��".$r[istop]."]&nbsp;&nbsp;";
}
if($r[isgood])//�Ƽ�
{
	$st.="[��".$r[isgood]."]&nbsp;&nbsp;";
}
if($r[firsttitle])//ͷ��
{
	$st.="[ͷ".$r[firsttitle]."]";
}
//����
$titleurl=sys_ReturnBqTitleLink($r);
//$r[title]="<a href='$titleurl' target='_blank'>".DoTitleFont($r[titlefont],$r[title])."</a>";
//Ȩ��
$group='';
if($r[groupid])
{
	$group=$level_r[$r[groupid]][groupname];
	if($r[userfen])
	{
		$group.=" ���۳�������".$r[userfen];
	}
}
//��Ŀ����
$classurl=sys_ReturnBqClassname($r,9);
$getclassurlr['classid']=$bclassid;
$bclassurl=sys_ReturnBqClassname($getclassurlr,9);
$classes="<a href='$bclassurl' target='_blank'>".$class_r[$bclassid][classname]."</a>&nbsp;>&nbsp;<a href='$classurl' target='_blank'>".$class_r[$classid][classname]."</a>";
//�������
$titletype=$class_tr[$r[ttid]]['tname'];

//��Ϣ״̬
$einfochecked=$index_r['checked'];
$einfoismember=$r['ismember'];

//------ �༭��������ʾ ------

$seteshoweditorhtml=3;

$eshoweditorhtml=0;
if($seteshoweditorhtml)
{
	if($seteshoweditorhtml==1)//����
	{
		$eshoweditorhtml=1;
	}
	elseif($seteshoweditorhtml==2)//����δ���
	{
		if(!$einfochecked)
		{
			$eshoweditorhtml=1;
		}
	}
	elseif($seteshoweditorhtml==3)//����Ͷ��
	{
		if($einfoismember)
		{
			$eshoweditorhtml=1;
		}
	}
	elseif($seteshoweditorhtml==4)//����δ���Ͷ��
	{
		if($einfoismember&&!$einfochecked)
		{
			$eshoweditorhtml=1;
		}
	}
	else
	{
		$eshoweditorhtml=1;
	}
}

$toshowhtmlbutton=0;
if($eshoweditorhtml)
{
	$toshowhtmlbutton=1;
}

//------ �༭��������ʾ ------

//��ʾ�༭������
$eckshowhtml=(int)$_GET['ckshowhtml'];
$ethisshowhtml='1'.date("md").$logininid;
$ethisshowhtml=(int)$ethisshowhtml;
if($ethisshowhtml==$eckshowhtml)
{
	$eshoweditorhtml=0;
}

//�л���ַ
if(!$eckshowhtml)
{
	$showhtmlbutton='������ӻ�ģʽ��ʾ';
	$showhtmlurl='ShowWfInfo.php?classid='.$r['classid'].'&id='.$r['id'].$addecmscheck.$ecms_hashur['ehref'].'&ckshowhtml='.$ethisshowhtml;
}
else
{
	$showhtmlbutton='���Դ��ģʽ��ʾ';
	$showhtmlurl='ShowWfInfo.php?classid='.$r['classid'].'&id='.$r['id'].$addecmscheck.$ecms_hashur['ehref'];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�鿴��Ϣ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ecmsinfo.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" style="word-wrap: break-word">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="50%"><strong><font color="#FFFFFF">�鿴��Ϣ</font></strong></td>
            <td width="50%"><div align="right">
			<?php
			if($toshowhtmlbutton)
			{
			?>
              <input name="button" type="button" id="button" value="<?=$showhtmlbutton?>" onclick="self.location.href='<?=$showhtmlurl?>';">
			<?php
			}
			?>
            </div></td>
          </tr>
        </table>
      </div></td>
    </tr>
    <tr> 
      <td width="13%" height="25" bgcolor="#FFFFFF">
<div align="right"><strong>������</strong></div></td>
      <td bgcolor="#FFFFFF"> 
        <?=$username?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>����ʱ��</strong></div></td>
      <td bgcolor="#FFFFFF">����ʱ�䣺 
        <?=date("Y-m-d H:i:s",$r[truetime])?>
        ������޸ģ� 
        <?=date("Y-m-d H:i:s",$r[lastdotime])?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>����</strong></div></td>
      <td bgcolor="#FFFFFF">������� 
        <?=$r[onclick]?>
        ���������� 
        <?=$r[plnum]?>
        ���������� 
        <?=$r[totaldown]?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>��Ϣ״̬</strong></div></td>
      <td bgcolor="#FFFFFF"> 
        <?=$st?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>��Ŀ</strong></div></td>
      <td bgcolor="#FFFFFF"> 
        <?=$classes?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>�������</strong></div></td>
      <td bgcolor="#FFFFFF">
        <?=$titletype?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>�ؼ���</strong></div></td>
      <td bgcolor="#FFFFFF"> 
        <?=$r[keyboard]?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>�����ϢID</strong></div></td>
      <td bgcolor="#FFFFFF"> 
        <?=$r[keyid]?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>�鿴Ȩ��</strong></div></td>
      <td bgcolor="#FFFFFF"> 
        <?=$group?>      </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><div align="right"><strong>ҳ������</strong></div></td>
      <td bgcolor="#FFFFFF"><a href="<?=$titleurl?>" target="_blank"><?=$titleurl?></a></td>
    </tr>
    <?php
	$fr=explode($recordexp,$enter);
	$count=count($fr)-1;
	for($i=0;$i<$count;$i++)
	{
		$fr1=explode($fieldexp,$fr[$i]);
		$fname=$fr1[0];
		$f=$fr1[1];
		if($f=="special.field")
		{
			continue;
		}
	?>
    <tr> 
      <td width="13%" height="25" bgcolor="#FFFFFF"><div align="right"> <strong> 
          <?=$fname?>
          </strong> </div></td>
      <td width="87%" bgcolor="#FFFFFF"> 
	  <?php
	  if(!$eshoweditorhtml)
	  {
	  ?>
        <?=stripSlashes($r[$f])?>      
	  <?php
	  }
	  else
	  {
	  ?>
	    <?=nl2br(eDoRepShowStr(stripSlashes($r[$f]),1))?>
	  <?php
	  }
	  ?>
	  </td>
    </tr>
    <?php
	}
	?>
	<tr class="header"> 
      <td height="25" colspan="2"><div align="right">
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="50%">&nbsp;</td>
            <td width="50%"><div align="right">
			<?php
			if($toshowhtmlbutton)
			{
			?>
              <input name="button2" type="button" id="button2" value="<?=$showhtmlbutton?>" onclick="self.location.href='<?=$showhtmlurl?>';">
			<?php
			}
			?>
            </div></td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>