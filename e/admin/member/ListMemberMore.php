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
CheckLevel($logininid,$loginin,$classid,"member");

include("../../member/class/user.php");
include "../".LoadLang("pub/fun.php");
include("../../data/dbcache/MemberLevel.php");
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=15;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������

//����
$search='';
$search.=$ecms_hashur['ehref'];
//�Զ���ÿҳ����
$showline=(int)$_GET['showline'];
if($showline)
{
	if($showline<10||$showline>100)
	{
		$line=15;
	}
	else
	{
		$line=$showline;
		$search.='&showline='.$showline;
	}
}
$offset=$page*$line;//��ƫ����

$and='';
if($_GET['sear'])
{
	$keyboard=RepPostVar2($_GET['keyboard']);
	if($keyboard)
	{
		$show=RepPostStr($_GET['show'],1);
		if($show==1)//�û�ID
		{
			$and.=" where userid='$keyboard'";	
		}
		elseif($show==2)//ע��IP
		{
			$and.=" where regip like '%$keyboard%'";
		}
		elseif($show==3)//����¼IP
		{
			$and.=" where lastip like '%$keyboard%'";
		}
		elseif($show==4)//�ռ�����
		{
			$and.=" where spacename like '%$keyboard%'";
		}
		elseif($show==5)//�ռ乫��
		{
			$and.=" where spacegg like '%$keyboard%'";
		}
		elseif($show==6)//�ֻ�
		{
			$and.=" where phone like '%$keyboard%'";
		}
		elseif($show==7)//����
		{
			$and.=" where truename like '%$keyboard%'";
		}
		elseif($show==8)//��˾��
		{
			$and.=" where company like '%$keyboard%'";
		}
		elseif($show==9)//��ϵ��ַ
		{
			$and.=" where address like '%$keyboard%'";
		}
		$search.="&sear=1&keyboard=".urlencode($keyboard)."&show=$show";
	}
}
$query="select * from {$dbtbpre}enewsmemberadd".$and;
$totalquery="select count(*) as total from {$dbtbpre}enewsmemberadd".$and;
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by userid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListMemberMore.php".$ecms_hashur['whehref'].">�����Ա(��ϸ)</a>";

//----------�ڲ���
$ingroup='';
$chingroup='';
$inmsql=$empire->query("select * from {$dbtbpre}enewsingroup order by myorder");
while($inm_r=$empire->fetch($inmsql))
{
	if($ingid==$inm_r['gid'])
	{$select=" selected";}
	else
	{$select="";}
	$ingroup.="<option value=".$inm_r['gid'].$select.">".$inm_r['gname']."</option>";
	$chingroup.="<option value=".$inm_r['gid'].">".$inm_r['gname']."</option>";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����Ա(��ϸ)</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right"> </div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="searchm" method="get" action="ListMemberMore.php">
<?=$ecms_hashur['eform']?>
  <tr>
    <td><div align="center">������
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="1"<?=$show==1?' selected':''?>>�û�ID</option>
			<option value="2"<?=$show==2?' selected':''?>>ע��IP</option>
			<option value="3"<?=$show==3?' selected':''?>>����¼IP</option>
			<option value="4"<?=$show==4?' selected':''?>>�ռ�����</option>
			<option value="5"<?=$show==5?' selected':''?>>�ռ乫��</option>
			<option value="6"<?=$show==6?' selected':''?>>�ֻ�</option>
			<option value="7"<?=$show==7?' selected':''?>>����</option>
			<option value="8"<?=$show==8?' selected':''?>>��˾��</option>
			<option value="9"<?=$show==9?' selected':''?>>��ϵ��ַ</option>
          </select>
          ÿҳ��ʾ
          <input name="showline" type="text" id="showline" value="<?=$line?>" size="5">
          <input type="submit" name="Submit" value="����">
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
  </tr>
</form>
</table>
<form name="memberform" method=post action=ListMember.php onsubmit="return confirm('ȷ��Ҫִ�в���?');">
<?=$ecms_hashur['form']?>
<?
while($r=$empire->fetch($sql))
{
	$ur=$empire->fetch1("select ".eReturnSelectMemberF('username,email,groupid,userfen,money,userdate,zgroupid,checked,registertime,ingid,agid,isern')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$r[userid]'");
	$username=$ur['username'];
	if(empty($ur['checked']))
	{
		$checked=" title='δ���' style='background:#99C4E3'";
		$namefont1="<font color='gray'>";
		$namefont2="</font>";
		$checkedtitle=' (<font color=red>δ���</font>)';
	}
	else
	{
		$checked="";
		$namefont1="";
		$namefont2="";
		$checkedtitle=' (�����)';
	}
	if(empty($ur['isern']))
	{
		$isernstatus=' <û��ʵ��>';
		$isernstatus2=' (<font color=red>û��ʵ��</font>)';
	}
	else
	{
		$isernstatus=' <��ʵ��>';
		$isernstatus2=' (��ʵ��)';
	}
	//������
	$magname='';
	$magadminname='';
	if($ur['agid'])
	{
		$magname=$aglevel_r[$ur['agid']]['agname'];
		if($magname)
		{
			if($aglevel_r[$ur['agid']]['isadmin']==9)
			{
				$magadminname='����Ա ('.$aglevel_r[$ur['agid']]['isadmin'].')';
			}
			elseif($aglevel_r[$ur['agid']]['isadmin']==5)
			{
				$magadminname='���� ('.$aglevel_r[$ur['agid']]['isadmin'].')';
			}
			elseif($aglevel_r[$ur['agid']]['isadmin']==1)
			{
				$magadminname='ʵϰ���� ('.$aglevel_r[$ur['agid']]['isadmin'].')';
			}
			else
			{
				$magadminname='('.$aglevel_r[$ur['agid']]['isadmin'].')';
			}
		}
	}
	//�ڲ���
	$migname='';
	if($ur['ingid'])
	{
		$migname=$iglevel_r[$ur['ingid']]['gname'];
	}
?>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
    <tr>
      <td width="3%" bgcolor="#FFFFFF" id=user<?=$r['userid']?>><div align="center">
        <input name="userid[]" type="checkbox" id="userid[]" value="<?=$r['userid']?>"<?=$checked?> onclick="if(this.checked){user<?=$r['userid']?>.style.backgroundColor='#4FB4DE';}else{user<?=$r['userid']?>.style.backgroundColor='#ffffff';}">
      </div></td> 
      <td width="97%" height="27"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="14%">ID��<?=$r['userid']?></td>
          <td width="20%">�û�����<a href="../../space/?userid=<?=$r['userid']?>" title="�鿴��Ա�ռ�" target="_blank"><?=$namefont1?><?=$username?><?=$namefont2?></a></td>
          <td width="14%">�ڲ��飺<?=$migname?></td>
          <td width="20%">ע��ʱ�䣺<?=eReturnMemberRegtime($ur['registertime'],"Y-m-d H:i:s")?></td>
          <td width="20%">ע��IP��<?=$r['regip']?>:<?=$r['regipport']?></td>
          <td width="12%" rowspan="2"><div align="center">[<a href="AddMember.php?enews=EditMember&userid=<?=$r['userid']?><?=$ecms_hashur['ehref']?>" target="_blank">�޸�</a>]
            &nbsp;
            [<a href="ListMember.php?enews=DelMember&userid=<?=$r['userid']?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]
            </div>
          </div></td>
        </tr>
        <tr>
          <td>�����飺<?=$magname?></td>
          <td>��Ա�飺<?=$level_r[$ur['groupid']][groupname]?></td>
          <td>��¼������<?=$r['loginnum']?></td>
          <td>����¼��<?=date("Y-m-d H:i:s",$r['lasttime'])?></td>
          <td>���IP��<?=$r['lastip']?>:<?=$r['lastipport']?></td>
          </tr>
      </table></td>  
    </tr>
  
  <tr bgcolor="#FFFFFF">
    <td height="23" bgcolor="#FFFFFF">&nbsp;      </td>
    <td height="23" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="50%" height="23">ע������<?=$checkedtitle?><?=$isernstatus2?></td>
        <td width="50%">�ռ����ƺ͹���</td>
      </tr>
      <tr>
        <td><textarea name="textarea" cols="60" style="WIDTH:100%" rows="8">�û�����<?=$username."\r\n"?>
�����ַ��<?=$ur['email']."\r\n"?>
��˾���ƣ�<?=stripSlashes($r['company'])."\r\n"?>
��ʵ������<?=stripSlashes($r['truename'])."\r\n"?>
��ϵ�绰��<?=stripSlashes($r['mycall'])."\r\n"?>
������룺<?=stripSlashes($r['fax'])."\r\n"?>
�ֻ����룺<?=stripSlashes($r['phone'])."\r\n"?>
QQ���룺<?=stripSlashes($r['oicq'])."\r\n"?>
MSN��<?=stripSlashes($r['msn'])."\r\n"?>
��Աͷ��<?=$r['userpic']."\r\n"?>
��վ��ַ��<?=stripSlashes($r['homepage'])."\r\n"?>
��ϵ��ַ��<?=stripSlashes($r['address'])."\r\n"?>
�ʱࣺ<?=stripSlashes($r['zip'])."\r\n"?>
��飺<?="\r\n"?>
<?=stripSlashes($r['saytext'])?>
</textarea></td>
        <td><textarea name="textarea2" cols="60" style="WIDTH:100%" rows="8">�ռ����ƣ�<?=stripSlashes($r['spacename'])."\r\n"?>
�ռ乫�棺<?="\r\n"?>
<?=stripSlashes($r['spacegg'])?>
</textarea></td>
      </tr>
    </table></td>
    </tr>
</table>
<br>
<?
}
?>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
    <tr>
      <td width="3%" bgcolor="#FFFFFF"><div align="center"><input type=checkbox name=chkall value=on onclick="CheckAll(this.form)" title="ȫѡ"></div></td> 
      <td height="30" bgcolor="#FFFFFF">
        <select name="toingid" id="toingid">
        <option value="0">ȡ���ڲ���</option>
		<?=$chingroup?>
      </select>
        <input type="submit" name="Submit32" value="ת���ڲ���" onclick="document.memberform.enews.value='DoMoveInGroupMember_all';">
        &nbsp;&nbsp;&nbsp; 
        <input type="submit" name="Submit3" value="���" onclick="document.memberform.enews.value='DoCheckMember_all';document.memberform.docheck.value='1';"> &nbsp;&nbsp;&nbsp;
		<input type="submit" name="Submit3" value="ȡ�����" onclick="document.memberform.enews.value='DoCheckMember_all';document.memberform.docheck.value='0';"> &nbsp;&nbsp;&nbsp;
		  <input type="submit" name="Submit2" value="ɾ��" onclick="document.memberform.enews.value='DelMember_all';">
        &nbsp;
        <input name="enews" type="hidden" id="enews" value="DelMember_all">
		<input name="docheck" type="hidden" id="docheck" value="1">      </td>
  </tr>
    <tr>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td height="30" bgcolor="#FFFFFF">��ҳ: 
        <?=$returnpage?></td>
    </tr>
</table>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td height="30"><font color="#666666">˵������ѡ��Ϊ��ɫ���û�����ɫ����δ��˻�Ա. </font></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
