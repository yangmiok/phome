<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
require "../".LoadLang("pub/fun.php");
require("../../data/dbcache/MemberLevel.php");
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

$addgethtmlpath="../";
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
//���봦���Ա����
if($enews)
{
	hCheckEcmsRHash();
	include('../../member/class/member_adminfun.php');
	include('../../member/class/member_modfun.php');
}
//�޸Ļ�Ա
if($enews=="EditMember")
{
	$add=$_POST['add'];
	admin_EditMember($add,$logininid,$loginin);
}
elseif($enews=="DelMember")//ɾ����Ա
{
	$userid=$_GET['userid'];
	admin_DelMember($userid,$logininid,$loginin);
}
elseif($enews=="DelMember_all")//����ɾ����Ա
{
	$userid=$_POST['userid'];
	admin_DelMember_all($userid,$logininid,$loginin);
}
elseif($enews=="DoCheckMember_all")//��˻�Ա
{
	admin_DoCheckMember_all($_POST,$logininid,$loginin);
}
elseif($enews=="DoMoveInGroupMember_all")//ת���ڲ���Ա��
{
	admin_DoMoveInGroupMember_all($_POST,$logininid,$loginin);
}
elseif($enews=="MemberChangeTimeGroup")//�������µ��ڻ�Ա��
{
	admin_MemberChangeTimeGroup($_GET,$logininid,$loginin);
}
else
{}

$search=$ecms_hashur['ehref'];
$line=25;
$page_line=12;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$offset=$page*$line;
$url="<a href=ListMember.php".$ecms_hashur['whehref'].">�����Ա</a>";
$add="";
//����
$sear=$_POST['sear'];
if(empty($sear))
{$sear=$_GET['sear'];}
$sear=RepPostStr($sear,1);
if($sear)
{
	$groupid=$_POST['groupid'];
	if(empty($groupid))
	{$groupid=$_GET['groupid'];}
	$ingid=$_POST['ingid'];
	if(empty($ingid))
	{$ingid=$_GET['ingid'];}
	$agid=$_POST['agid'];
	if(empty($agid))
	{$agid=$_GET['agid'];}
	$keyboard=$_POST['keyboard'];
	if(empty($keyboard))
	{$keyboard=$_GET['keyboard'];}
	$keyboard=RepPostVar2($keyboard);
	$show=(int)$_GET['show'];
	if($keyboard)
	{
		if($show==2)//����
		{
			$add=" where ".egetmf('email')." like '%$keyboard%'";
		}
		elseif($show==3)//ID
		{
			$add=" where ".egetmf('userid')."='$keyboard'";
		}
		else
		{
			$add=" where ".egetmf('username')." like '%$keyboard%'";
		}
	}
	$groupid=(int)$groupid;
	if($groupid)
	{
		if(empty($add))
		{$add.=" where ".egetmf('groupid')."='$groupid'";}
		else
		{$add.=" and ".egetmf('groupid')."='$groupid'";}
	}
	$ingid=(int)$ingid;
	if($ingid)
	{
		if(empty($add))
		{$add.=" where ".egetmf('ingid')."='$ingid'";}
		else
		{$add.=" and ".egetmf('ingid')."='$ingid'";}
	}
	$agid=(int)$agid;
	if($agid)
	{
		if(empty($add))
		{$add.=" where ".egetmf('agid')."='$agid'";}
		else
		{$add.=" and ".egetmf('agid')."='$agid'";}
	}
	$search.="&sear=1&show=$show&groupid=".$groupid."&ingid=".$ingid."&agid=".$agid."&keyboard=".urlencode($keyboard);
}
//���
$schecked=(int)$_GET['schecked'];
if($schecked)
{
	$and=$add?' and ':' where ';
	if($schecked==1)
	{
		$add.=$and.egetmf('checked')."=0";
	}
	else
	{
		$add.=$and.egetmf('checked')."=1";
	}
	$search.="&schecked=$schecked";
}
//ʵ��
$sisern=(int)$_GET['sisern'];
if($sisern)
{
	$and=$add?' and ':' where ';
	if($sisern==1)
	{
		$add.=$and.egetmf('isern')."=0";
	}
	else
	{
		$add.=$and.egetmf('isern')."=1";
	}
	$search.="&sisern=$sisern";
}
$totalquery="select count(*) as total from ".eReturnMemberTable().$add;
$num=$empire->gettotal($totalquery);
$query="select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable().$add;
$query.=" order by ".egetmf('userid')." desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//----------��Ա��
$group='';
$sql1=$empire->query("select * from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	if($groupid==$l_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$l_r[groupid].$select.">".$l_r[groupname]."</option>";
}
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
//----------������
$madmingroup='';
$agsql=$empire->query("select agid,agname from {$dbtbpre}enewsag order by isadmin");
while($ag_r=$empire->fetch($agsql))
{
	if($agid==$ag_r['agid'])
	{$select=" selected";}
	else
	{$select="";}
	$madmingroup.="<option value=".$ag_r['agid'].$select.">".$ag_r['agname']."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����Ա</title>
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
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="ע���Ա" onclick="window.open('../../member/register/');">
		&nbsp;&nbsp;
		<input type="button" name="Submit5" value="ǰ̨��Ա�б�" onclick="window.open('../../member/list/');">
		&nbsp;&nbsp;
		<input type="button" name="Submit5" value="�������µ��ڻ�Ա��" onclick="if(confirm('ȷ��Ҫ�������µ��ڻ�Ա��?')){self.location.href='ListMember.php?enews=MemberChangeTimeGroup<?=$ecms_hashur['href']?>';}">
		&nbsp;
      </div></td>
  </tr>
</table>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <form name="form2" method="GET" action="ListMember.php">
  <?=$ecms_hashur['eform']?>
  <input type=hidden name=sear value=1>
    <tr>
      <td><div align="center">�ؼ���:
          <select name="show" id="show">
            <option value="1"<?=$show==1?' selected':''?>>�û���</option>
			<option value="3"<?=$show==3?' selected':''?>>�û�ID</option>
            <option value="2"<?=$show==2?' selected':''?>>����</option>
          </select>
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="groupid" id="groupid">
            <option value="0">���޻�Ա��</option>
			<?=$group?>
          </select>
		  <select name="ingid" id="ingid">
            <option value="0">�����ڲ���</option>
			<?=$ingroup?>
          </select>
		  <select name="agid" id="agid">
            <option value="0">���޹�����</option>
			<?=$madmingroup?>
          </select>
          <select name="schecked" id="schecked">
            <option value="0"<?=$schecked==0?' selected':''?>>�������</option>
            <option value="1"<?=$schecked==1?' selected':''?>>δ���</option>
            <option value="2"<?=$schecked==2?' selected':''?>>�����</option>
          </select>
		  <select name="sisern" id="sisern">
            <option value="0"<?=$sisern==0?' selected':''?>>����ʵ��</option>
            <option value="1"<?=$sisern==1?' selected':''?>>δʵ��</option>
            <option value="2"<?=$sisern==2?' selected':''?>>��ʵ��</option>
          </select>
          <input type="submit" name="Submit" value="����">
          &nbsp;&nbsp; [<a href="ListMember.php?schecked=1<?=$ecms_hashur['ehref']?>">δ���</a>] [<a href="ListMember.php?schecked=2<?=$ecms_hashur['ehref']?>">�����</a>] [<a href="ListMember.php?sisern=1<?=$ecms_hashur['ehref']?>">δʵ��</a>] [<a href="ListMember.php?sisern=2<?=$ecms_hashur['ehref']?>">��ʵ��</a>] </div></td>
    </tr>
  </form>
</table>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="memberform" method="post" action="ListMember.php" onsubmit="return confirm('ȷ��Ҫ����?');">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td width="2%">&nbsp;</td> 
      <td width="4%" height="25"><div align="center">ID</div></td>
      <td width="17%" height="25"><div align="center">�û���</div></td>
      <td width="9%"><div align="center">��Ա��</div></td>
      <td width="10%"><div align="center">�ڲ���</div></td>
      <td width="9%"><div align="center">������</div></td>
      <td width="4%"><div align="center">���</div></td>
      <td width="4%"><div align="center">ʵ��</div></td>
      <td width="14%"><div align="center">ע��ʱ��</div></td>
      <td width="11%"><div align="center">��¼</div></td>
      <td width="16%" height="25"><div align="center">����</div></td>
    </tr>
	<?
	while($r=$empire->fetch($sql))
	{
		if(empty($r['checked']))
		{
			$checked=" title='δ���' style='background:#99C4E3'";
			$namefont1="<font color='gray'>";
			$namefont2="</font>";
			$checkedstatus='<font color=red>��</font>';
		}
		else
		{
			$checked="";
			$namefont1="";
			$namefont2="";
			$checkedstatus='��';
		}
		$registertime=date("Y-m-d H:i:s",$r['registertime']);
		//������
		$magname='';
		$magadminname='';
		if($r['agid'])
		{
			$magname=$aglevel_r[$r['agid']]['agname'];
			if($magname)
			{
				if($aglevel_r[$r['agid']]['isadmin']==9)
				{
					$magadminname='����Ա ('.$aglevel_r[$r['agid']]['isadmin'].')';
				}
				elseif($aglevel_r[$r['agid']]['isadmin']==5)
				{
					$magadminname='���� ('.$aglevel_r[$r['agid']]['isadmin'].')';
				}
				elseif($aglevel_r[$r['agid']]['isadmin']==1)
				{
					$magadminname='ʵϰ���� ('.$aglevel_r[$r['agid']]['isadmin'].')';
				}
				else
				{
					$magadminname='('.$aglevel_r[$r['agid']]['isadmin'].')';
				}
			}
		}
		//�ڲ���
		$migname='';
		if($r['ingid'])
		{
			$migname=$iglevel_r[$r['ingid']]['gname'];
		}
	  //����ת��
	  $m_username=$r['username'];
	  $email=$r['email'];
  ?>
    <tr bgcolor="ffffff" id=user<?=$r['userid']?>>
      <td><div align="center">
        <input name="userid[]" type="checkbox" id="userid[]" value="<?=$r['userid']?>"<?=$checked?> onclick="if(this.checked){user<?=$r['userid']?>.style.backgroundColor='#DBEAF5';}else{user<?=$r['userid']?>.style.backgroundColor='#ffffff';}">
      </div></td> 
      <td height="25"><div align="center"> 
          <?=$r['userid']?>
        </div></td>
      <td height="25"><div align="center"><a href="../../space/?userid=<?=$r['userid']?>" title="�鿴��Ա�ռ�" target="_blank"><?=$namefont1?><?=$m_username?><?=$namefont2?></a></div></td>
      <td><div align="center"><a href="ListMember.php?sear=1&groupid=<?=$r['groupid']?><?=$ecms_hashur['ehref']?>"><?=$level_r[$r['groupid']][groupname]?></a></div></td>
      <td><div align="center"><a href="ListMember.php?sear=1&ingid=<?=$r['ingid']?><?=$ecms_hashur['ehref']?>"><?=$migname?></a></div></td>
      <td><div align="center"><a href="ListMember.php?sear=1&agid=<?=$r['agid']?><?=$ecms_hashur['ehref']?>" title="<?=$magadminname?>"><?=$magname?></a></div></td>
      <td><div align="center"><?=$checkedstatus?></div></td>
      <td><div align="center"><?=$r['isern']?'��':'<font color=red>��</font>'?></div></td>
      <td><div align="center"> 
          <?=$registertime?>
        </div></td>
      <td><div align="center">[<a href="#ecms" onclick="window.open('ListBuyBak.php?userid=<?=$r['userid']?>&username=<?=$m_username?><?=$ecms_hashur['ehref']?>','','width=650,height=600,scrollbars=yes,top=70,left=100');">����</a>] 
          [<a href="#ecms" onclick="window.open('ListDownBak.php?userid=<?=$r['userid']?>&username=<?=$m_username?><?=$ecms_hashur['ehref']?>','','width=650,height=600,scrollbars=yes,top=70,left=100');">����</a>]</div></td>
      <td height="25"><div align="center">[<a href="AddMember.php?enews=EditMember&userid=<?=$r['userid']?><?=$ecms_hashur['ehref']?>">�޸�</a>]
	   &nbsp;
          [<a href="ListMember.php?enews=DelMember&userid=<?=$r['userid']?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]   
        </div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="ffffff"> 
	<td height="25"><div align="center"><input type=checkbox name=chkall value=on onclick="CheckAll(this.form)" title="ȫѡ"></div></td>
      <td height="25" colspan="10"> <select name="toingid" id="toingid">
        <option value="0">ȡ���ڲ���</option>
		<?=$chingroup?>
      </select>
        <input type="submit" name="Submit32" value="ת���ڲ���" onclick="document.memberform.enews.value='DoMoveInGroupMember_all';">
        &nbsp;&nbsp;&nbsp; 
        <input type="submit" name="Submit3" value="���" onclick="document.memberform.enews.value='DoCheckMember_all';document.memberform.docheck.value='1';"> &nbsp;&nbsp;&nbsp;
		<input type="submit" name="Submit3" value="ȡ�����" onclick="document.memberform.enews.value='DoCheckMember_all';document.memberform.docheck.value='0';"> &nbsp;&nbsp;&nbsp;
		  <input type="submit" name="Submit2" value="ɾ��" onclick="document.memberform.enews.value='DelMember_all';">
        <input name="enews" type="hidden" id="enews" value="DelMember_all">
        &nbsp;
        <input name="docheck" type="hidden" id="docheck" value="1">
&nbsp;        </td>
    </tr>
    <tr bgcolor="ffffff">
      <td height="25" colspan="11"><?=$returnpage?></td>
    </tr>
    <tr bgcolor="ffffff">
      <td height="25" colspan="11"><font color="#666666">˵������ѡ��Ϊ��ɫ���û�����ɫ����δ��˻�Ա. </font></td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
