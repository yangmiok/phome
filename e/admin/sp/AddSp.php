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
CheckLevel($logininid,$loginin,$classid,"sp");
$enews=ehtmlspecialchars($_GET['enews']);
$postword='������Ƭ';
$noteditword='<font color="#666666">(���ú󲻿��޸�)</font>';
$disabled='';
$sptypehidden='';
$r[maxnum]=0;
$url="<a href=ListSp.php".$ecms_hashur['whehref'].">������Ƭ</a> &gt; ������Ƭ";
$fcid=(int)$_GET['fcid'];
$fclassid=(int)$_GET['fclassid'];
$fsptype=(int)$_GET['fsptype'];
$r['spfile']='html/sp/'.time().'.html';
$spid=(int)$_GET['spid'];
if($enews=='EditSp')
{
	$filepass=$spid;
}
else
{
	$filepass=ReturnTranFilepass();
}
//����
if($enews=="AddSp"&&$_GET['docopy'])
{
	$r=$empire->fetch1("select * from {$dbtbpre}enewssp where spid='$spid'");
	$url="<a href=ListSp.php".$ecms_hashur['whehref'].">������Ƭ</a> &gt; ������Ƭ��<b>".$r[spname]."</b>";
	$username=substr($r[username],1,-1);
}
//�޸�
if($enews=="EditSp")
{
	$r=$empire->fetch1("select * from {$dbtbpre}enewssp where spid='$spid'");
	$postword='�޸���Ƭ';
	$noteditword='';
	$disabled=' disabled';
	$sptypehidden='<input type="hidden" name="sptype" value="'.$r[sptype].'">';
	$url="<a href=ListSp.php".$ecms_hashur['whehref'].">������Ƭ</a> &gt; �޸���Ƭ��<b>".$r[spname]."</b>";
	$username=substr($r[username],1,-1);
}
//��ǩģ��
$bqtemp='';
$bqtempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsbqtemp")." order by tempid");
while($bqtempr=$empire->fetch($bqtempsql))
{
	$select="";
	if($r[tempid]==$bqtempr[tempid])
	{
		$select=" selected";
	}
	$bqtemp.="<option value='".$bqtempr[tempid]."'".$select.">".$bqtempr[tempname]."</option>";
}
//��Ŀ
$options=ShowClass_AddClass("",$r[classid],0,"|-",0,0);
//����
$scstr='';
$scsql=$empire->query("select classid,classname from {$dbtbpre}enewsspclass order by classid");
while($scr=$empire->fetch($scsql))
{
	$select="";
	if($scr[classid]==$r[cid])
	{
		$select=" selected";
	}
	$scstr.="<option value='".$scr[classid]."'".$select.">".$scr[classname]."</option>";
}
//�û���
$group='';
$groupsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsgroup order by groupid");
while($groupr=$empire->fetch($groupsql))
{
	$select='';
	if(strstr($r[groupid],','.$groupr[groupid].','))
	{
		$select=' selected';
	}
	$group.="<option value='".$groupr[groupid]."'".$select.">".$groupr[groupname]."</option>";
}
//����
$userclass='';
$ucsql=$empire->query("select classid,classname from {$dbtbpre}enewsuserclass order by classid");
while($ucr=$empire->fetch($ucsql))
{
	$select='';
	if(strstr($r[userclass],','.$ucr[classid].','))
	{
		$select=' selected';
	}
	$userclass.="<option value='".$ucr[classid]."'".$select.">".$ucr[classname]."</option>";
}
//��ǰʹ�õ�ģ����
$thegid=GetDoTempGid();
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>��Ƭ</title>
<script>
function selectalls(doselect,formvar)
{  
	 var bool=doselect==1?true:false;
	 var selectform=document.getElementById(formvar);
	 for(var i=0;i<selectform.length;i++)
	 { 
		  selectform.all[i].selected=bool;
	 } 
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListSp.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="spid" type="hidden" id="spid" value="<?=$spid?>"> 
        <input name="fcid" type="hidden" id="fcid" value="<?=$fcid?>"> <input name="fclassid" type="hidden" id="fclassid" value="<?=$fclassid?>"> 
        <input name="fsptype" type="hidden" id="fsptype" value="<?=$fsptype?>">
		<input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��Ƭ���ͣ�</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="sptype" id="sptype"<?=$disabled?>>
          <option value="1"<?=$r[sptype]==1?' selected':''?>>��̬��Ϣ��Ƭ</option>
          <option value="2"<?=$r[sptype]==2?' selected':''?>>��̬��Ϣ��Ƭ</option>
          <option value="3"<?=$r[sptype]==3?' selected':''?>>������Ƭ</option>
        </select> 
        <?=$noteditword?>
        <?=$sptypehidden?>
      </td>
    </tr>
    <tr> 
      <td width="18%" height="25" bgcolor="#FFFFFF">��Ƭ����:</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"> <input name="spname" type="text" id="spname" value="<?=$r[spname]?>" size="42"> 
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��Ƭ��������</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="varname" type="text" id="varname" value="<?=$r[varname]?>" size="42"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�������ࣺ</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="cid" id="cid">
          <option value="0">���������κ����</option>
          <?=$scstr?>
        </select> <input type="button" name="Submit6222322" value="�������" onclick="window.open('ListSpClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">������Ϣ��Ŀ��</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="classid" id="classid">
          <option value="0">������������Ŀ</option>
          <?=$options?>
        </select> <input type="button" name="Submit622232" value="������Ŀ" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');"> 
        <font color="#666666">(ѡ����Ŀ����Ӧ��������Ŀ)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�����Ϣ������</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="maxnum" type="text" id="spname3" value="<?=$r[maxnum]?>" size="42"> 
        <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ʹ�ñ�ǩģ�壺</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="tempid" id="tempid">
          <?=$bqtemp?>
        </select> <input type="button" name="Submit6222323" value="�����ǩģ��" onclick="window.open('../template/ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�Ƿ�������Ƭ�ļ���</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="refile" value="0"<?=$r[refile]==0?' checked':''?>>
        ������ 
        <input type="radio" name="refile" value="1"<?=$r[refile]==1?' checked':''?>>
        ����</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">������Ƭ�ļ�����</td>
      <td height="25" bgcolor="#FFFFFF">/ 
        <input name="spfile" type="text" id="spfile" value="<?=$r[spfile]?>" size="42">
        <input name="oldspfile" type="hidden" id="oldspfile" value="<?=$r[spfile]?>"> </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">������Ƭ�ļ��������ã�</td>
      <td height="25" bgcolor="#FFFFFF">��ʾ��Ϣ������
        <input name="spfileline" type="text" id="spfileline" value="<?=$r[spfileline]?>" size="6">
        �������ȡ������
        <input name="spfilesub" type="text" id="spfilesub" value="<?=$r[spfilesub]?>" size="6"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��ƬЧ��ͼ��</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="sppic" type="text" id="sppic" value="<?=$r[sppic]?>" size="42"> 
        <a onclick="window.open('../ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&modtype=7&type=1&classid=&doing=2&field=sppic&filepass=<?=$filepass?>&sinfo=1','','width=700,height=550,scrollbars=yes');" title="ѡ�����ϴ���ͼƬ"><img src="../../data/images/changeimg.gif" alt="ѡ��/�ϴ�ͼƬ" width="22" height="22" border="0" align="absbottom"></a></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��Ƭ������</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="spsay" cols="60" rows="5" id="varname3"><?=ehtmlspecialchars($r[spsay])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��ԽȨ�����ͣ�</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="cladd" value="0"<?=$r[cladd]==0?' checked':''?>>
        �� 
        <input type="radio" name="cladd" value="1"<?=$r[cladd]==1?' checked':''?>>
        �� <font color="#666666">(����Ȩ�����÷�Χ�ڵ��û�Ҳ��������Ϣ)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�Ƿ�����</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="isclose" value="0"<?=$r[isclose]==0?' checked':''?>>
        �� 
        <input type="radio" name="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
        ��</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">Ȩ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�û��飺</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="groupid[]" size="5" multiple id="groupidselect" style="width:180">
          <?=$group?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'groupidselect')">ȫ��ȡ��</a>]</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">���ţ�</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="userclass[]" size="5" multiple id="userclassselect" style="width:180">
          <?=$userclass?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'userclassselect')">ȫ��ȡ��</a>]</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�û���</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="username" type="text" id="username" value="<?=$username?>" size="42"> 
        <font color="#666666"> 
        <input type="button" name="Submit3" value="ѡ��" onclick="window.open('../ChangeUser.php?field=username&form=form1<?=$ecms_hashur['ehref']?>','','width=300,height=520,scrollbars=yes');">
        (����û��á�,�����Ÿ���)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="�ύ"> 
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
