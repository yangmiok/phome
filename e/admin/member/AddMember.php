<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
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
$r=array();
$userdate=0;
$enews=ehtmlspecialchars($_GET['enews']);
$changegroupid=(int)$_GET['changegroupid'];
$url="<a href=ListMember.php".$ecms_hashur['whehref'].">�����Ա</a>&nbsp;>&nbsp;���ӻ�Ա";
if($enews=="EditMember")
{
	$userid=(int)$_GET['userid'];
	//ȡ���û�����
	$r=ReturnUserInfo($userid);
	$r['groupid']=$r['groupid']?$r['groupid']:eReturnMemberDefGroupid();
	$addr=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid='$userid' limit 1");
	$url="<a href=ListMember.php".$ecms_hashur['whehref'].">�����Ա</a>&nbsp;>&nbsp;�޸Ļ�Ա���ϣ�<b>".$r[username]."</b>";
	//ʱ��
	if($r[userdate])
	{
		$userdate=$r[userdate]-time();
		if($userdate<=0)
		{
			OutTimeZGroup($userid,$r['zgroupid']);
			if($r['zgroupid'])
			{
				$r['groupid']=$r['zgroupid'];
				$r['zgroupid']=0;
			}
			$userdate=0;
		}
		else
		{
			$userdate=round($userdate/(24*3600));
		}
	}
}
if($changegroupid)
{
	$r['groupid']=$changegroupid;
}
//----------��Ա��
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($sql))
{
	if($r[groupid]==$level_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$level_r[groupid].$select.">".$level_r[groupname]."</option>";
	if($r[zgroupid]==$level_r[groupid])
	{$zselect=" selected";}
	else
	{$zselect="";}
	$zgroup.="<option value=".$level_r[groupid].$zselect.">".$level_r[groupname]."</option>";
}
//�ڲ���
$ingroup='';
$inmsql=$empire->query("select * from {$dbtbpre}enewsingroup order by myorder");
while($inm_r=$empire->fetch($inmsql))
{
	if($r['ingid']==$inm_r['gid'])
	{$select=" selected";}
	else
	{$select="";}
	$ingroup.="<option value=".$inm_r['gid'].$select.">".$inm_r['gname']."</option>";
}
//������
$magname='';
$magadminname='';
if($r['agid'])
{
	$r['agid']=(int)$r['agid'];
	$magr=$empire->fetch1("select * from {$dbtbpre}enewsag where agid='".$r['agid']."'");
	$magname=$magr['agname'];
	if($magname)
	{
		if($magr['isadmin']==9)
		{
			$magadminname='����Ա ('.$magr['isadmin'].')';
		}
		elseif($magr['isadmin']==5)
		{
			$magadminname='���� ('.$magr['isadmin'].')';
		}
		elseif($magr['isadmin']==1)
		{
			$magadminname='ʵϰ���� ('.$magr['isadmin'].')';
		}
		else
		{
			$magadminname='('.$magr['isadmin'].')';
		}
	}
}
//���
$spacestyle='';
$spacesql=$empire->query("select styleid,stylename from {$dbtbpre}enewsspacestyle");
while($spacer=$empire->fetch($spacesql))
{
	$selected='';
	if($spacer[styleid]==$addr[spacestyleid])
	{
		$selected=' selected';
	}
	$spacestyle.="<option value='$spacer[styleid]'".$selected.">".$spacer[stylename]."</option>";
}
//ȡ�ñ�
$formid=GetMemberFormId($r[groupid]);
$formfile='../../data/html/memberform'.$formid.'.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�޸�����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListMember.php" enctype="multipart/form-data">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <input type=hidden name=add[oldusername] value='<?=$r[username]?>'>
    <input type=hidden name=add[userid] value='<?=$userid?>'>
    <tr class="header"> 
      <td height="25" colspan="2">�޸����� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="25%" height="25">�û���</td>
      <td width="75%" height="25"><input name=add[username] type=text id="add[username]" value='<?=$r[username]?>'></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����</td>
      <td height="25"><input name="add[password]" type="password" id="add[password]">
        (�޸�ʱ���粻���޸�,������)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���</td>
      <td height="25"><input name="add[checked]" type="checkbox" id="add[checked]" value="1"<?=$r[checked]==1?' checked':''?>>
        ���ͨ��</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">ʵ��״̬</td>
      <td height="25"><input type="radio" name="add[isern]" value="0"<?=$r['isern']==0?' checked':''?>>δʵ��
        <input type="radio" name="add[isern]" value="1"<?=$r['isern']==1?' checked':''?>>��ʵ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">������Ա��<br> <br> <input type="button" name="Submit3" value="�����Ա��" onclick="window.open('ListMemberGroup.php<?=$ecms_hashur['whehref']?>');">      </td>
      <td height="25"><select name="add[groupid]" size="6" id="add[groupid]" onchange="self.location.href='AddMember.php?<?=$ecms_hashur['ehref']?>&enews=EditMember&userid=<?=$userid?>&changegroupid='+this.options[this.selectedIndex].value;">
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�����ڲ���</td>
      <td height="25"><select name="add[ingid]" id="add[ingid]">
        <option value="0"<?=$r['ingid']==0?' selected':''?>>������</option>
		<?=$ingroup?>
      </select>      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����</td>
      <td height="25"><input name="add[email]" type="text" id="add[email]" value="<?=$r[email]?>" size="35"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ʣ������</td>
      <td height="25"><input name=add[userdate] type=text id="add[userdate]" value='<?=$userdate?>' size="6">
        �죬���ں�ת���û���: 
        <select name="add[zgroupid]" id="add[zgroupid]">
          <option value="0">������</option>
          <?=$zgroup?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����</td>
      <td height="25"><input name=add[userfen] type=text id="add[userfen]" value='<?=$r[userfen]?>' size="6">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�ʻ����</td>
      <td height="25"><input name=add[money] type=text id="add[money]" value='<?=$r[money]?>' size="6">
        Ԫ </td>
    </tr>
    
    <tr bgcolor="#FFFFFF">
      <td height="25">����������</td>
      <td height="25">
	  <?php
	  if($r['agid'])
	  {
	  ?>
	  ��ID��<?=$r['agid']?>�������ƣ�<a href="#ecms" title="<?=$magadminname?>"><?=$magname?></a>
	  <?php
	  }
	  else
	  {
	  ?>
	  ----
	  <?php
	  }
	  ?>	  </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">ע��ʱ��</td>
      <td height="25"><?=eReturnMemberRegtime($r['registertime'],"Y-m-d H:i:s")?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">ע��IP</td>
      <td height="25"><?=$addr[regip]?>:<?=$addr[regipport]?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">����¼</td>
      <td height="25">�ܵ�¼������<?=$addr[loginnum]?>��ʱ�䣺<?=date("Y-m-d H:i:s",$addr[lasttime])?>����¼IP��<?=$addr[lastip]?>:<?=$addr[lastipport]?></td>
    </tr>
    <tr bgcolor="#FFFFFF" class="header"> 
      <td height="25" colspan="2">������Ϣ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"> 
        <?php
	  @include($formfile);
	  ?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" class="header">
      <td height="25" colspan="2">��Ա�ռ�����</td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">�ռ�ʹ��ģ��</td>
      <td height="25"><select name="add[spacestyleid]" id="add[spacestyleid]">
          <?=$spacestyle?>
        </select> <input type="button" name="Submit32" value="����ռ�ģ��" onclick="window.open('ListSpaceStyle.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ռ�����</td>
      <td height="25"><input name="add[spacename]" type="text" id="add[spacename]" value="<?=ehtmlspecialchars(stripSlashes($addr['spacename']))?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ռ乫��</td>
      <td height="25"><textarea name="add[spacegg]" cols="60" rows="6" id="add[spacegg]"><?=stripSlashes($addr['spacegg'])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�޸�"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>