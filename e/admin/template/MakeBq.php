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

$doobject=(int)$_GET['doobject'];
$selfdoobject=(int)$_GET['selfdoobject'];
$addselfinfo=(int)$_GET['addselfinfo'];
$selfinfooption='';
$parentclass=(int)$_GET['parentclass'];
$addparentclass='';
if($parentclass)
{
	$addparentclass='��';
}
//��������
if($doobject==2)//����Ŀ
{
	//��������
	$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="0">��Ŀ������Ϣ</option>
			  <option value="1">��Ŀ�������</option>
			  <option value="2">��Ŀ�Ƽ���Ϣ</option>
			  <option value="9">��Ŀ��������</option>
			  <option value="12">��Ŀͷ����Ϣ</option>
			  <option value="15">��Ŀ��������</option>
              </select></td>
          </tr>
        </table>';
	//ѡ����Ŀ
	$fcfile='../../data/fc/ListEnews.php';
	$class="<script src=../../data/fc/cmsclass.js></script>";
	if(!file_exists($fcfile))
	{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
	if($addselfinfo==1)
	{
	}
	elseif($addselfinfo==2)//һ����Ŀ+��ǰ��Ŀ
	{
		$selfinfooption='<option value="\'selfinfo\'">��ǰ��Ŀ</option><option value="\'0\'">һ����Ŀ</option>';
	}
	elseif($addselfinfo==3)//һ����Ŀ
	{
		$selfinfooption='<option value="\'0\'">һ����Ŀ</option>';
	}
	elseif($addselfinfo==4)//������Ŀ
	{
		$selfinfooption='<option value="0">������Ŀ</option>';
	}
	else
	{
		$selfinfooption='<option value="\'selfinfo\'">��ǰ��Ŀ</option>';
	}
	$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ��'.$addparentclass.'��Ŀ��</td>
            <td width="76%"><select name="classid" id="select2">
			  '.$selfinfooption.'
			  '.$class.'
              </select></td>
          </tr>
        </table>';
}
elseif($doobject==3)//��ר��
{
	//��������
	$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="6">ר��������Ϣ</option>
			  <option value="7">ר��������</option>
			  <option value="8">ר���Ƽ���Ϣ</option>
			  <option value="11">ר����������</option>
			  <option value="14">ר��ͷ����Ϣ</option>
			  <option value="17">ר����������</option>
              </select></td>
          </tr>
        </table>';
	//ѡ��ר��
	$ztclass='';
	$ztsql=$empire->query("select ztid,ztname from {$dbtbpre}enewszt order by ztid desc");
	while($ztr=$empire->fetch($ztsql))
	{
		$ztclass.="<option value='".$ztr['ztid']."'>".$ztr['ztname']."</option>";
	}
	if($addselfinfo==1)
	{
	}
	else
	{
		$selfinfooption='<option value="\'selfinfo\'">��ǰר��</option>';
	}
	$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ��ר�⣺</td>
            <td width="76%"><select name="classid" id="select2">
			  '.$selfinfooption.'
			  '.$ztclass.'
              </select></td>
          </tr>
        </table>';
}
elseif($doobject==4)//�����ݱ�
{
	//��������
	$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="18">��������Ϣ</option>
			  <option value="19">��������</option>
			  <option value="20">���Ƽ���Ϣ</option>
			  <option value="21">����������</option>
			  <option value="22">��ͷ����Ϣ</option>
			  <option value="23">����������</option>
              </select></td>
          </tr>
        </table>';
	//ѡ�����ݱ�
	$tb='';
	$tbsql=$empire->query("select tbname,tname from {$dbtbpre}enewstable order by tid");
	while($tbr=$empire->fetch($tbsql))
	{
		$tb.="<option value=\"'".$tbr[tbname]."'\">".$tbr[tname]."</option>";
	}
	$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ�����ݱ�</td>
            <td width="76%"><select name="classid" id="select2">
			  '.$tb.'
              </select></td>
          </tr>
        </table>';
}
elseif($doobject==5)//���������
{
	//��������
	$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="25">�������������Ϣ</option>
			  <option value="26">�������������</option>
			  <option value="27">��������Ƽ���Ϣ</option>
			  <option value="28">���������������</option>
			  <option value="29">�������ͷ����Ϣ</option>
			  <option value="30">���������������</option>
              </select></td>
          </tr>
        </table>';
	//ѡ��������
	$tts='';
	$ttsql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype order by typeid");
	while($ttr=$empire->fetch($ttsql))
	{
		$tts.="<option value='$ttr[typeid]'>$ttr[tname]</option>";
	}
	$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ�������ࣺ</td>
            <td width="76%"><select name="classid" id="select2">
			  '.$tts.'
              </select></td>
          </tr>
        </table>';
}
elseif($doobject==6)//��SQL
{
	//��������
	$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="24">SQL��ѯ</option>
              </select></td>
          </tr>
        </table>';
	//ѡ��SQL
	$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ��</td>
            <td width="76%"><select name="classid" id="select2">
			  <option value="\'sql���\'">SQL��ѯ</option>
              </select></td>
          </tr>
        </table>';
}
else//��Ĭ�ϱ�
{
	//��������
	$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="3">Ĭ�ϱ�������Ϣ</option>
			  <option value="4">Ĭ�ϱ�������</option>
			  <option value="5">Ĭ�ϱ��Ƽ���Ϣ</option>
			  <option value="10">Ĭ�ϱ���������</option>
			  <option value="13">Ĭ�ϱ�ͷ����Ϣ</option>
			  <option value="16">Ĭ�ϱ���������</option>
              </select></td>
          </tr>
        </table>';
	//ѡ��SQL
	$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ��</td>
            <td width="76%"><select name="classid" id="select2">
			  <option value="0">Ĭ�ϱ�('.$public_r[tbname].')</option>
              </select></td>
          </tr>
        </table>';
}

//��ǩģ��
$bqname=RepPostStr($_GET['bqname'],1);
if(empty($bqname))
{
	$bqname='ecmsinfo';
}
$mydotype=RepPostStr($_GET['mydotype'],1);
$defchangeobject=RepPostStr($_GET['defchangeobject'],1);
if($defchangeobject==1)
{
	$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ��</td>
            <td width="76%"><select name="classid" id="select2">
			  <option value="\'\'">Ĭ��</option>
              </select></td>
          </tr>
        </table>';
}
if($bqname=='ecmsinfo'||$bqname=='listsonclass'||$bqname=='otherlink'||$bqname=='eshowphoto'||$bqname=='tagsinfo'||$bqname=='showclasstemp'||$bqname=='eshowzt'||$bqname=='listshowclass'||$bqname=='gbookinfo'||$bqname=='showplinfo')
{
	$bqtemp='';
	$bqtempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsbqtemp")." order by tempid");
	while($bqtempr=$empire->fetch($bqtempsql))
	{
		$bqtemp.="<option value='".$bqtempr[tempid]."'>".$bqtempr[tempname]."</option>";
	}
}
//��ǰʹ�õ�ģ����
$thegid=GetDoTempGid();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�۹���վ����ϵͳ--��ǩ����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script language="javascript">
window.resizeTo(800,600);
window.focus();
</script>
<script>
//���ظ���SQL
function ReturnAddSql(addsql,orderby){
	var addstr='';
	var r;
	var yh="'";
	if(addsql!=''||orderby!='')
	{
		r=addsql.split("'");
		if(r.length!=1)
		{
			yh='"';
		}
		if(addsql!='')
		{
			addstr+=','+yh+addsql+yh;
		}
		else
		{
			addstr+=",''";
		}
		if(orderby!='')
		{
			addstr+=",'"+orderby+"'";
		}
	}
	return addstr;
}

//�����Ƿ�ӵ�����
function ReturnAddYh(tids){
	var r;
	if(tids=='')
	{
		return "''";
	}
	r=tids.split(",");
	if(r.length!=1)
	{
		tids="'"+tids+"'";
	}
	return tids;
}
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td height="25">ѡ���ǩ�� 
      <select name="bq" id="bq" style= "font-size:16px;" onchange="if(this.options[this.selectedIndex].value!=''){self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname='+this.options[this.selectedIndex].value}">
        <option value="" style="background-color:#AFCFF3">��Ϣ���ñ�ǩ</option>
        <option value="ecmsinfo"<?=$bqname=='ecmsinfo'?' selected':''?>>&nbsp; &gt; ���ܱ�ǩ���� (ecmsinfo)</option>
		<option value="eloop"<?=$bqname=='eloop'?' selected':''?>>&nbsp; &gt; �鶯��ǩ (e:loop)</option>
		<option value="eindexloop"<?=$bqname=='eindexloop'?' selected':''?>>&nbsp; &gt; �����鶯��ǩ (e:indexloop)</option>
        <option value="phomenews"<?=$bqname=='phomenews'?' selected':''?>>&nbsp; &gt; ���ֵ��ñ�ǩ (phomenews)</option>
        <option value="phomenewspic"<?=$bqname=='phomenewspic'?' selected':''?>>&nbsp; &gt; ͼ����Ϣ����[����ͼƬ����Ϣ] (phomenewspic)</option>
        <option value="phomeflashpic"<?=$bqname=='phomeflashpic'?' selected':''?>>&nbsp; &gt; FLASH�õ���Ϣ���� (phomeflashpic)</option>
		<option value="listsonclass&doobject=2&addselfinfo=2"<?=$bqname=='listsonclass'?' selected':''?>>&nbsp; &gt; ѭ������Ŀ���ݱ�ǩ (listsonclass)</option>
		<option value="otherlink&defchangeobject=1"<?=$bqname=='otherlink'?' selected':''?>>&nbsp; &gt; ������ӱ�ǩ (otherlink)</option>
		<option value="tagsinfo"<?=$bqname=='tagsinfo'?' selected':''?>>&nbsp; &gt; ����TAGS����Ϣ��ǩ (tagsinfo)</option>
		<option value="spinfo"<?=$bqname=='spinfo'?' selected':''?>>&nbsp; &gt; ������Ƭ����Ϣ��ǩ (spinfo)</option>
		<option value="showtags"<?=$bqname=='showtags'?' selected':''?>>&nbsp; &gt; ����TAGS��ǩ (showtags)</option>
        <option value="totaldata&doobject=2&addselfinfo=1"<?=$bqname=='totaldata'?' selected':''?>>&nbsp; &gt; ��վ��Ϣͳ�� (totaldata)</option>
        <option value="eshowphoto"<?=$bqname=='eshowphoto'?' selected':''?>>&nbsp; &gt; ͼ��ģ�ͷ�ҳ��ǩ (eshowphoto)</option>
        <option value="showsearch&doobject=2&addselfinfo=4"<?=$bqname=='showsearch'?' selected':''?>>&nbsp; &gt; �����ؼ��ֵ��ñ�ǩ (showsearch)</option>
        <option value="" style="background-color:#AFCFF3">��Ŀ���ñ�ǩ</option>
        <option value="showclasstemp&doobject=2&addselfinfo=2&parentclass=1"<?=$bqname=='showclasstemp'?' selected':''?>>&nbsp; &gt; ��ģ�����Ŀ������ǩ (showclasstemp)</option>
        <option value="eshowzt"<?=$bqname=='eshowzt'?' selected':''?>>&nbsp; &gt; ר����ñ�ǩ (eshowzt)</option>
        <option value='listshowclass&doobject=2&addselfinfo=2&parentclass=1'<?=$bqname=='listshowclass'?' selected':''?>>&nbsp; &gt; ѭ����Ŀ������ǩ (listshowclass)</option>
        <option value="" style="background-color:#AFCFF3">����Ϣ���ñ�ǩ</option>
        <option value="phomead"<?=$bqname=='phomead'?' selected':''?>>&nbsp; &gt; �����ñ�ǩ (phomead)</option>
        <option value="phomevote"<?=$bqname=='phomevote'?' selected':''?>>&nbsp; &gt; ͶƱ���ñ�ǩ (phomevote)</option>
        <option value="phomelink"<?=$bqname=='phomelink'?' selected':''?>>&nbsp; &gt; �������ӵ��ñ�ǩ (phomelink)</option>
        <option value="gbookinfo"<?=$bqname=='gbookinfo'?' selected':''?>>&nbsp; &gt; ���԰���ñ�ǩ (gbookinfo)</option>
        <option value="showplinfo"<?=$bqname=='showplinfo'?' selected':''?>>&nbsp; &gt; ���۵��ñ�ǩ (showplinfo)</option>
        <option value="echocheckbox"<?=$bqname=='echocheckbox'?' selected':''?>>&nbsp; &gt; ��ѡ�ֶ�������ݱ�ǩ (echocheckbox)</option>
		<option value="" style="background-color:#AFCFF3">��Ա��ص���</option>
		<option value="ShowMemberInfo"<?=$bqname=='ShowMemberInfo'?' selected':''?>>��Ա��Ϣ���ú��� (ShowMemberInfo)</option>
		<option value="ListMemberInfo"<?=$bqname=='ListMemberInfo'?' selected':''?>>��Ա�б���ú��� (ListMemberInfo)</option>
		<option value="spaceeloop"<?=$bqname=='spaceeloop'?' selected':''?>>��Ա�ռ���Ϣ��ǩ���� (spaceeloop)</option>
        <option value="" style="background-color:#AFCFF3">������ǩ</option>
        <option value="includefile"<?=$bqname=='includefile'?' selected':''?>>&nbsp; &gt; �����ļ���ǩ (includefile)</option>
        <option value="readhttp"<?=$bqname=='readhttp'?' selected':''?>>&nbsp; &gt; ��ȡԶ��ҳ�� (readhttp)</option>
      </select></td>
  </tr>
</table>
<br>
<?php
if($bqname=='ecmsinfo')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var ftitlelen=obj.titlelen.value;
	var fshowclass=obj.showclass.value;
	var fdotype=obj.dotype.value;
	var ftempid=obj.tempid.value;
	var fispic=obj.ispic.value;
	var faddsql=obj.addsql.value;
	var forderby=obj.orderby.value;
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="[ecmsinfo]"+fclassid+","+fline+","+ftitlelen+","+fshowclass+","+fdotype+","+ftempid+","+fispic+addstr+"[/ecmsinfo]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">ecmsinfo��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ����ö��� 
        <select name="doobject" id="doobject" onchange="self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&doobject='+this.options[this.selectedIndex].value">
          <option value="1"<?=$doobject==1?' selected':''?>>��Ĭ�ϱ�(
          <?=$public_r['tbname']?>
          )</option>
          <option value="2"<?=$doobject==2?' selected':''?>>��Ŀ</option>
          <option value="4"<?=$doobject==4?' selected':''?>>���ݱ�</option>
          <option value="5"<?=$doobject==5?' selected':''?>>�������</option>
          <option value="6"<?=$doobject==6?' selected':''?>>��SQL����</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$dotype?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line3" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select3">
                <?=$bqtemp?>
              </select>
              <input type="button" name="Submit6222323" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen2" value="32"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ��Ŀ����</td>
            <td width="76%"><select name="showclass" id="showclass">
                <option value="0">��</option>
                <option value="1">��</option>
              </select> <font color="#666666">(��ǩģ��Ҫ��[!--class.name--])</font> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ֻ�����б���ͼƬ����Ϣ�� 
        <select name="ispic" id="ispic">
          <option value="0">����</option>
          <option value="1">��</option>
        </select></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql2"> <select name="addsqlselect" onchange="document.bqform.addsql.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="isgood=1">1���Ƽ�</option>
<option value="firsttitle=1">1��ͷ��</option>
<option value="field='ֵ'">�ֶε���ĳֵ</option>
</select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby2"> <select name="orderbyselect" onchange="document.bqform.orderby.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="newstime DESC">������ʱ�併������</option>
<option value="newstime ASC">������ʱ����������</option>
<option value="id DESC">��ID��������</option>
<option value="onclick DESC">������ʽ�������</option>
<option value="totaldown DESC">����������������</option>
<option value="plnum DESC">����������������</option>
<option value="diggtop DESC">������(digg)��������</option>
</select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();">
      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#ecmsinfo" target="_blank" title="�鿴��ϸ��ǩ�﷨">[ecmsinfo]��ĿID/�������ID,��ʾ����,�����ȡ��,�Ƿ���ʾ��Ŀ��,��������,ģ��ID,ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����[/ecmsinfo]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='eloop')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var fdotype=obj.dotype.value;
	var fispic=obj.ispic.value;
	var faddsql=obj.addsql.value;
	var forderby=obj.orderby.value;
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="[e:loop={"+fclassid+","+fline+","+fdotype+","+fispic+addstr+"}]\r\n<a href=\"<?="<?=\$bqsr['titleurl']?>"?>\" target=\"_blank\"><?="<?=\$bqr['title']?>"?></a> <br>\r\n[/e:loop]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eloop">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">�鶯��ǩ(e:loop)���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ����ö��� 
        <select name="doobject" id="doobject" onchange="self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&doobject='+this.options[this.selectedIndex].value">
          <option value="1"<?=$doobject==1?' selected':''?>>��Ĭ�ϱ�( 
          <?=$public_r['tbname']?>
          )</option>
          <option value="2"<?=$doobject==2?' selected':''?>>��Ŀ</option>
          <option value="4"<?=$doobject==4?' selected':''?>>���ݱ�</option>
          <option value="5"<?=$doobject==5?' selected':''?>>�������</option>
          <option value="6"<?=$doobject==6?' selected':''?>>��SQL����</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$dotype?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">ֻ�����б���ͼƬ����Ϣ�� 
        <select name="ispic" id="select6">
          <option value="0">����</option>
          <option value="1">��</option>
        </select> </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql"> <select name="addsqlselect" onchange="document.bqform.addsql.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="isgood=1">1���Ƽ�</option>
<option value="firsttitle=1">1��ͷ��</option>
<option value="field='ֵ'">�ֶε���ĳֵ</option>
</select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby"> <select name="orderbyselect" onchange="document.bqform.orderby.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="newstime DESC">������ʱ�併������</option>
<option value="newstime ASC">������ʱ����������</option>
<option value="id DESC">��ID��������</option>
<option value="onclick DESC">������ʽ�������</option>
<option value="totaldown DESC">����������������</option>
<option value="plnum DESC">����������������</option>
<option value="diggtop DESC">������(digg)��������</option>
</select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit3" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#eloop" target="_blank" title="�鿴��ϸ��ǩ�﷨">[e:loop={��ĿID/�������ID,��ʾ����,��������,ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����}]<br>
        ģ���������<br>
      [/e:loop]</a></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="12" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit22" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='eindexloop')
{
	if($selfdoobject==9)//ר������
	{
		$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="4">ר������������Ϣ</option>
			  <option value="5">ר������������Ϣ</option>
			  <option value="6">ר�������Ƽ���Ϣ</option>
              </select></td>
          </tr>
        </table>';
		$changeobject='<input name="classid" type="text" id="classid" value="0"><input type="button" name="Submit42" value="�鿴ר��ID" onclick="window.open(\'../special/ListZt.php'.$ecms_hashur['whehref'].'\');"><font color="#666666">(��ǰר��ID�ã�\'selfinfo\'�����ID�á�,���Ÿ���)</font>';
	}
	elseif($selfdoobject==7)//TAGS
	{
		$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="9">TAGS������Ϣ</option>
			  <option value="10">TAGS������Ϣ</option>
              </select></td>
          </tr>
        </table>';
		$changeobject='<input name="classid" type="text" id="classid" value="0"><input type="button" name="Submit42" value="�鿴TAGS��ID" onclick="window.open(\'../tags/ListTags.php'.$ecms_hashur['whehref'].'\');"><font color="#666666">(���ID�á�,���Ÿ���)</font>';
	}
	elseif($selfdoobject==8)//��Ƭ
	{
		$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="7">��Ƭ������Ϣ</option>
			  <option value="8">��Ƭ������Ϣ</option>
              </select></td>
          </tr>
        </table>';
		$changeobject='<input name="classid" type="text" id="classid" value="0"><input type="button" name="Submit42" value="�鿴��ƬID" onclick="window.open(\'../sp/ListSp.php'.$ecms_hashur['whehref'].'\');"><font color="#666666">(���ID�á�,���Ÿ���)</font>';
	}
	elseif($selfdoobject==6)//��SQL
	{
		//��������
		$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="11">SQL��ѯ</option>
              </select></td>
          </tr>
        </table>';
		//ѡ��SQL
		$changeobject='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">ѡ��</td>
            <td width="76%"><select name="classid" id="select2">
			  <option value="\'sql���\'">SQL��ѯ</option>
              </select></td>
          </tr>
        </table>';
	}
	else//ר��
	{
		$dotype='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select">
			  <option value="1">ר��������Ϣ</option>
			  <option value="2">ר��������Ϣ</option>
			  <option value="3">ר���Ƽ���Ϣ</option>
              </select></td>
          </tr>
        </table>';
		$changeobject='<input name="classid" type="text" id="classid" value="0"><input type="button" name="Submit42" value="�鿴ר��ID" onclick="window.open(\'../special/ListZt.php'.$ecms_hashur['whehref'].'\');"><font color="#666666">(��ǰר��ID�ã�\'selfinfo\'�����ID�á�,���Ÿ���)</font>';
	}
	
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var fdotype=obj.dotype.value;
	var fuseclassid=obj.useclassid.value;
	var fmodid=obj.modid.value;
	var faddsql=obj.addsql.value;
	var forderby='';
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="[e:indexloop={"+fclassid+","+fline+","+fdotype+",'"+fuseclassid+"','"+fmodid+"'"+addstr+"}]\r\n<a href=\"<?="<?=\$bqsr['titleurl']?>"?>\" target=\"_blank\"><?="<?=\$bqr['title']?>"?></a> <br>\r\n[/e:indexloop]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eindexloop">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">�����鶯��ǩ(e:indexloop)���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ����ö��� 
        <select name="selfdoobject" id="selfdoobject" onchange="self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&selfdoobject='+this.options[this.selectedIndex].value">
          <option value="3"<?=$selfdoobject==3?' selected':''?>>ר��</option>
		  <option value="9"<?=$selfdoobject==9?' selected':''?>>ר������</option>
          <option value="7"<?=$selfdoobject==7?' selected':''?>>TAGS</option>
          <option value="8"<?=$selfdoobject==8?' selected':''?>>��Ƭ</option>
		  <option value="6"<?=$selfdoobject==6?' selected':''?>>��SQL����</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF">
	<?=$dotype?>
              </td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="24%">������ĿID��</td>
          <td width="76%"><input name="useclassid" type="text" id="useclassid"> <font color="#666666">(���ID��,�Ÿ���)</font></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="24%">����ϵͳģ��ID��</td>
          <td width="76%"><input name="modid" type="text" id="line6"> <font color="#666666">(���ID��,�Ÿ���)</font></td>
        </tr>
      </table></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit3" value="�����ǩ" onclick="ShowBqFun();">      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#eindexloop" target="_blank" title="�鿴��ϸ��ǩ�﷨">[e:indexloop={��������ID,��ʾ����,��������,��ĿID,ϵͳģ��ID,����SQL����}]<br>
        ģ���������<br>
      [/e:indexloop]</a></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="12" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit22" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='phomenews')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var ftitlelen=obj.titlelen.value;
	var fshowclass=obj.showclass.value;
	var fdotype=obj.dotype.value;
	var fshowtime=obj.showtime.value;
	var fformattime=obj.formattime.value;
	var faddsql=obj.addsql.value;
	var forderby=obj.orderby.value;
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="[phomenews]"+fclassid+","+fline+","+ftitlelen+","+fshowtime+","+fdotype+","+fshowclass+",'"+fformattime+"'"+addstr+"[/phomenews]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">phomenews��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ����ö��� 
        <select name="doobject" id="doobject" onchange="self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&doobject='+this.options[this.selectedIndex].value">
          <option value="1"<?=$doobject==1?' selected':''?>>��Ĭ�ϱ�( 
          <?=$public_r['tbname']?>
          )</option>
          <option value="2"<?=$doobject==2?' selected':''?>>��Ŀ</option>
          <option value="4"<?=$doobject==4?' selected':''?>>���ݱ�</option>
          <option value="5"<?=$doobject==5?' selected':''?>>�������</option>
          <option value="6"<?=$doobject==6?' selected':''?>>��SQL����</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$dotype?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line3" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ��Ŀ����</td>
            <td width="76%"><select name="showclass" id="select2">
                <option value="0">��</option>
                <option value="1">��</option>
              </select> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen2" value="32"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�Ƿ���ʾʱ�䣺</td>
            <td width="76%"><select name="showtime" id="select4">
                <option value="0">��</option>
                <option value="1">��</option>
              </select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ʱ���ʽ��</td>
            <td width="76%"><input name="formattime" type="text" id="formattime" value="(m-d)"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql2"> <select name="addsqlselect" onchange="document.bqform.addsql.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="isgood=1">1���Ƽ�</option>
<option value="firsttitle=1">1��ͷ��</option>
<option value="field='ֵ'">�ֶε���ĳֵ</option>
</select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby2"> <select name="orderbyselect" onchange="document.bqform.orderby.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="newstime DESC">������ʱ�併������</option>
<option value="newstime ASC">������ʱ����������</option>
<option value="id DESC">��ID��������</option>
<option value="onclick DESC">������ʽ�������</option>
<option value="totaldown DESC">����������������</option>
<option value="plnum DESC">����������������</option>
<option value="diggtop DESC">������(digg)��������</option>
</select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#phomenews" target="_blank" title="�鿴��ϸ��ǩ�﷨">[phomenews]��ĿID/�������ID,��ʾ����,�����ȡ��,�Ƿ���ʾʱ��,��������,�Ƿ���ʾ��Ŀ��,'ʱ���ʽ��',����SQL����,��ʾ����[/phomenews]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='phomenewspic')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var flnum=obj.lnum.value;
	var ftitlelen=obj.titlelen.value;
	var fshowtitle=obj.showtitle.value;
	var fdotype=obj.dotype.value;
	var fpicwidth=obj.picwidth.value;
	var fpicheight=obj.picheight.value;
	var faddsql=obj.addsql.value;
	var forderby=obj.orderby.value;
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="[phomenewspic]"+fclassid+","+fline+","+flnum+","+fpicwidth+","+fpicheight+","+fshowtitle+","+ftitlelen+","+fdotype+addstr+"[/phomenewspic]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">phomenewspic��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ����ö��� 
        <select name="doobject" id="doobject" onchange="self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&doobject='+this.options[this.selectedIndex].value">
          <option value="1"<?=$doobject==1?' selected':''?>>��Ĭ�ϱ�( 
          <?=$public_r['tbname']?>
          )</option>
          <option value="2"<?=$doobject==2?' selected':''?>>��Ŀ</option>
          <option value="4"<?=$doobject==4?' selected':''?>>���ݱ�</option>
          <option value="5"<?=$doobject==5?' selected':''?>>�������</option>
          <option value="6"<?=$doobject==6?' selected':''?>>��SQL����</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$dotype?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������������</td>
            <td width="76%"><input name="lnum" type="text" id="line3" value="8"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ÿ����ʾ������</td>
            <td width="76%"><input name="line" type="text" id="num" value="4"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ͼƬ��С��</td>
            <td width="76%">��
<input name="picwidth" type="text" id="picwidth" value="170" size="6">
              ���� 
              <input name="picheight" type="text" id="picheight" value="120" size="6"> </td>
          </tr>
        </table> </td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�Ƿ���ʾ���⣺</td>
            <td width="76%"><select name="showtitle" id="select5">
                <option value="0">��</option>
                <option value="1">��</option>
              </select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen" value="26"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql2"> <select name="addsqlselect" onchange="document.bqform.addsql.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="isgood=1">1���Ƽ�</option>
<option value="firsttitle=1">1��ͷ��</option>
<option value="field='ֵ'">�ֶε���ĳֵ</option>
</select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby2"> <select name="orderbyselect" onchange="document.bqform.orderby.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="newstime DESC">������ʱ�併������</option>
<option value="newstime ASC">������ʱ����������</option>
<option value="id DESC">��ID��������</option>
<option value="onclick DESC">������ʽ�������</option>
<option value="totaldown DESC">����������������</option>
<option value="plnum DESC">����������������</option>
<option value="diggtop DESC">������(digg)��������</option>
</select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#phomenewspic" target="_blank" title="�鿴��ϸ��ǩ�﷨">[phomenewspic]��ĿID/�������ID,ÿ����ʾ����,��ʾ����Ϣ��,ͼƬ���,ͼƬ�߶�,�Ƿ���ʾ����,�����ȡ��,��������,����SQL����,��ʾ����[/phomenewspic]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='phomeflashpic')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var fkeeptime=obj.keeptime.value;
	var ftitlelen=obj.titlelen.value;
	var fshowtitle=obj.showtitle.value;
	var fdotype=obj.dotype.value;
	var fpicwidth=obj.picwidth.value;
	var fpicheight=obj.picheight.value;
	var faddsql=obj.addsql.value;
	var forderby=obj.orderby.value;
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="[phomeflashpic]"+fclassid+","+fline+","+fpicwidth+","+fpicheight+","+fshowtitle+","+ftitlelen+","+fdotype+","+fkeeptime+addstr+"[/phomeflashpic]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">phomeflashpic��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ����ö��� 
        <select name="doobject" id="doobject" onchange="self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&doobject='+this.options[this.selectedIndex].value">
          <option value="1"<?=$doobject==1?' selected':''?>>��Ĭ�ϱ�( 
          <?=$public_r['tbname']?>
          )</option>
          <option value="2"<?=$doobject==2?' selected':''?>>��Ŀ</option>
          <option value="4"<?=$doobject==4?' selected':''?>>���ݱ�</option>
          <option value="5"<?=$doobject==5?' selected':''?>>�������</option>
          <option value="6"<?=$doobject==6?' selected':''?>>��SQL����</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$dotype?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line3" value="5"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ͣ��������</td>
            <td width="76%"><input name="keeptime" type="text" id="num" value="0">
              <font color="#666666">(0ΪĬ��)</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ͼƬ��С��</td>
            <td width="76%">��
<input name="picwidth" type="text" id="picwidth" value="170" size="6">
              ���� 
              <input name="picheight" type="text" id="picheight" value="120" size="6"> </td>
          </tr>
        </table> </td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�Ƿ���ʾ���⣺</td>
            <td width="76%"><select name="showtitle" id="select5">
                <option value="0">��</option>
                <option value="1">��</option>
              </select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen" value="26"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql2"> <select name="addsqlselect" onchange="document.bqform.addsql.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="isgood=1">1���Ƽ�</option>
<option value="firsttitle=1">1��ͷ��</option>
<option value="field='ֵ'">�ֶε���ĳֵ</option>
</select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby2"> <select name="orderbyselect" onchange="document.bqform.orderby.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="newstime DESC">������ʱ�併������</option>
<option value="newstime ASC">������ʱ����������</option>
<option value="id DESC">��ID��������</option>
<option value="onclick DESC">������ʽ�������</option>
<option value="totaldown DESC">����������������</option>
<option value="plnum DESC">����������������</option>
<option value="diggtop DESC">������(digg)��������</option>
</select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#phomeflashpic" target="_blank" title="�鿴��ϸ��ǩ�﷨">[phomeflashpic]��ĿID/�������ID,��ʾ����,ͼƬ���,ͼƬ�߶�,�Ƿ���ʾ����,�����ȡ��,��������,ͣ������,����SQL����,��ʾ����[/phomeflashpic]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='listsonclass')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var ftitlelen=obj.titlelen.value;
	var fshowclass=obj.showclass.value;
	var fdotype=obj.dotype.value;
	var ftempid=obj.tempid.value;
	var fispic=obj.ispic.value;
	var fclassnum=obj.classnum.value;
	var ffirstdotype=obj.firstdotype.value;
	var ffirsttitlelen=obj.firsttitlelen.value;
	var ffirstsmalltextlen=obj.firstsmalltextlen.value;
	var ffirstispic=obj.firstispic.value;
	var faddsql=obj.addsql.value;
	var forderby=obj.orderby.value;
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="[listsonclass]"+fclassid+","+fline+","+ftitlelen+","+fshowclass+","+fdotype+","+ftempid+","+fispic+","+fclassnum+","+ffirstdotype+","+ffirsttitlelen+","+ffirstsmalltextlen+","+ffirstispic+addstr+"[/listsonclass]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">listsonclass��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="dotype">
                <option value="0">��Ŀ����</option>
                <option value="1">��Ŀ����</option>
                <option value="2">��Ŀ�Ƽ�</option>
                <option value="3">��Ŀ��������</option>
                <option value="4">��Ŀͷ��</option>
                <option value="5">��Ŀ��������</option>
              </select></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������Ϣ����</td>
            <td width="76%"><input name="line" type="text" id="line3" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select7">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit62223232" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen3" value="32"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ��Ŀ����</td>
            <td width="76%"><select name="showclass" id="select8">
                <option value="0">��</option>
                <option value="1">��</option>
              </select> <font color="#666666">(��ǩģ��Ҫ��[!--class.name--])</font> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ֻ�����б���ͼƬ����Ϣ�� 
        <select name="ispic" id="select9">
          <option value="0">����</option>
          <option value="1">��</option>
        </select></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������Ŀ������</td>
            <td width="76%"><input name="classnum" type="text" id="titlelen4" value="0"> 
              <font color="#666666">(0Ϊ������)</font></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ͷ���������ͣ�</td>
            <td width="76%"><select name="firstdotype" id="select10">
                <option value="0">����ʾ��Ŀͷ��</option>
                <option value="1">��Ŀ���ݼ��</option>
                <option value="2">��Ŀ�Ƽ���Ϣ</option>
                <option value="3">��Ŀͷ����Ϣ</option>
                <option value="4">��Ŀ������Ϣ</option>
              </select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ͷ�������ȡ������</td>
            <td width="76%"><input name="firsttitlelen" type="text" id="firsttitlelen" value="32"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ͷ������ȡ������</td>
            <td width="76%"><input name="firstsmalltextlen" type="text" id="firstsmalltextlen" value="0"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">ͷ��ֻ�����б���ͼƬ����Ϣ�� 
        <select name="firstispic" id="select11">
          <option value="0">����</option>
          <option value="1">��</option>
        </select></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql2"> <select name="addsqlselect" onchange="document.bqform.addsql.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="isgood=1">1���Ƽ�</option>
<option value="firsttitle=1">1��ͷ��</option>
<option value="field='ֵ'">�ֶε���ĳֵ</option>
</select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby2"> <select name="orderbyselect" onchange="document.bqform.orderby.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="newstime DESC">������ʱ�併������</option>
<option value="newstime ASC">������ʱ����������</option>
<option value="id DESC">��ID��������</option>
<option value="onclick DESC">������ʽ�������</option>
<option value="totaldown DESC">����������������</option>
<option value="plnum DESC">����������������</option>
<option value="diggtop DESC">������(digg)��������</option>
</select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#listsonclass" target="_blank" title="�鿴��ϸ��ǩ�﷨">[listsonclass]��ĿID,��ʾ����,�����ȡ��,�Ƿ���ʾ��Ŀ��,��������,ģ��ID,ֻ��ʾ�б���ͼƬ,��ʾ��Ŀ��,��ʾͷ����������,ͷ�������ȡ��,ͷ������ȡ��,ͷ��ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����[/listsonclass]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='totaldata')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var fclassid=obj.classid.value;
	var flimittime=obj.limittime.value;
	var fdotype=obj.dotype.value;
	var ftotaltype=obj.totaltype.value;
	bqstr="[totaldata]"+fclassid+","+fdotype+","+flimittime+","+ftotaltype+"[/totaldata]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eloop">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">totaldata��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select12" onchange="var addurl='';if(this.options[this.selectedIndex].value==0){addurl='&doobject=2';}else if(this.options[this.selectedIndex].value==1){addurl='&doobject=5';}else if(this.options[this.selectedIndex].value==2){addurl='&doobject=4';}self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&addselfinfo=1&mydotype='+this.options[this.selectedIndex].value+addurl;">
                <option value="0"<?=$mydotype==0?' selected':''?>>ͳ����Ŀ����</option>
                <option value="1"<?=$mydotype==1?' selected':''?>>ͳ�Ʊ������</option>
                <option value="2"<?=$mydotype==2?' selected':''?>>ͳ�����ݱ�</option>
              </select></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ʱ�䷶Χ��</td>
            <td width="76%"><select name="limittime" id="select13">
                <option value="0">����</option>
                <option value="1">����</option>
                <option value="2">����</option>
                <option value="3">����</option>
              </select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="24%">ͳ�����ͣ�</td>
          <td width="76%"><select name="totaltype" id="select29">
            <option value="0">ͳ����Ϣ��</option>
            <option value="1">ͳ��������</option>
            <option value="2">ͳ�Ƶ����</option>
            <option value="3">ͳ��������</option>
                    </select></td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit3" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#totaldata" target="_blank" title="�鿴��ϸ��ǩ�﷨">[totaldata]��ĿID,��������,ʱ�䷶Χ,ͳ������[/totaldata]</a></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit22" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='otherlink')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var ftitlelen=obj.titlelen.value;
	var fshowclass=obj.showclass.value;
	var fdotype=obj.dotype.value;
	var ftempid=obj.tempid.value;
	var fispic=obj.ispic.value;
	bqstr="[otherlink]"+ftempid+","+fclassid+","+fline+","+ftitlelen+","+fshowclass+","+fdotype+","+fispic+"[/otherlink]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">otherlink��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="dotype" onchange="var addurl='';if(this.options[this.selectedIndex].value==0){addurl='&defchangeobject=1';}else if(this.options[this.selectedIndex].value==1){addurl='&doobject=4';}else if(this.options[this.selectedIndex].value==2){addurl='&doobject=2';}else if(this.options[this.selectedIndex].value==3){addurl='&doobject=5';}self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&addselfinfo=1&mydotype='+this.options[this.selectedIndex].value+addurl;">
                <option value="0"<?=$mydotype==0?' selected':''?>>Ĭ��</option>
                <option value="1"<?=$mydotype==1?' selected':''?>>�����ݱ�</option>
                <option value="2"<?=$mydotype==2?' selected':''?>>����Ŀ</option>
                <option value="3"<?=$mydotype==3?' selected':''?>>���������</option>
              </select></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line3" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select3">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit6222323" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen2" value="32"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ��Ŀ����</td>
            <td width="76%"><select name="showclass" id="showclass">
                <option value="0">��</option>
                <option value="1">��</option>
              </select> <font color="#666666">(��ǩģ��Ҫ��[!--class.name--])</font> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ֻ�����б���ͼƬ����Ϣ�� 
        <select name="ispic" id="ispic">
          <option value="0">����</option>
          <option value="1">��</option>
        </select></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#otherlink" target="_blank" title="�鿴��ϸ��ǩ�﷨">[otherlink]��ǩģ��ID,��������,��������,�����ȡ����,�Ƿ���ʾ��Ŀ��,��������,ֻ��ʾ����ͼƬ����Ϣ[/otherlink]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='eshowphoto')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var ftempid=obj.tempid.value;
	var fpicwidth=obj.picwidth.value;
	var fpicheight=obj.picheight.value;
	bqstr="[eshowphoto]"+ftempid+","+fpicwidth+","+fpicheight+"[/eshowphoto]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eshowphoto">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">eshowphoto��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="tempid">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit62223233" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����ͼƬ��С��</td>
            <td width="76%">��
<input name="picwidth" type="text" id="picwidth" value="170" size="6">
              ���� 
              <input name="picheight" type="text" id="picheight" value="120" size="6"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#eshowphoto" target="_blank" title="�鿴��ϸ��ǩ�﷨">[eshowphoto]��ǩģ��ID,����ͼƬ���,����ͼƬ�߶�[/eshowphoto]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='showsearch')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var fclassid=obj.classid.value;
	var fdotype=obj.dotype.value;
	var flnum=obj.lnum.value;
	var fline=obj.line.value;
	bqstr="[showsearch]"+fline+","+flnum+","+fclassid+","+fdotype+"[/showsearch]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="showsearch">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">showsearch��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="dotype">
                <option value="0">������������</option>
                <option value="1">������������</option>
              </select></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������������</td>
            <td width="76%"><input name="lnum" type="text" id="lnum" value="8"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ÿ����ʾ������</td>
            <td width="76%"><input name="line" type="text" id="line" value="4"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit3" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#showsearch" target="_blank" title="�鿴��ϸ��ǩ�﷨">[showsearch]ÿ����ʾ����,������,��Ŀid,��������[/showsearch]</a></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit22" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='tagsinfo')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=ReturnAddYh(obj.classid.value);
	var fline=obj.line.value;
	var ftitlelen=obj.titlelen.value;
	var ftids=ReturnAddYh(obj.tids.value);
	var ftempid=obj.tempid.value;
	var fmids=ReturnAddYh(obj.mids.value);
	bqstr="[tagsinfo]"+ftids+","+fline+","+ftitlelen+","+ftempid+","+fclassid+","+fmids+"[/tagsinfo]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="tagsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">tagsinfo��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">TAGS��ID��</td>
            <td width="76%"><input name="tids" type="text" id="tids"> <input type="button" name="Submit4" value="�鿴TAGS" onclick="window.open('../tags/ListTags.php<?=$ecms_hashur['whehref']?>');">
              <font color="#666666">(���ID��,�Ÿ���)</font></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="tempid">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit62223234" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line3" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������ĿID��</td>
            <td width="76%"><input name="classid" type="text" id="classid" value="0">
              <font color="#666666">
              <input type="button" name="Submit42" value="�鿴��ĿID" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');">
              (0Ϊ���ޣ����ID��,�Ÿ���)</font> </td>
          </tr>
        </table> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen2" value="32"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����ϵͳģ��ID��</td>
            <td width="76%"><input name="mids" type="text" id="mids" value="0">
              <font color="#666666"> (0Ϊ���ޣ����ID��,�Ÿ���)</font> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#tagsinfo" target="_blank" title="�鿴��ϸ��ǩ�﷨">[tagsinfo]TAGS��ID,��ʾ����,�����ȡ��,��ǩģ��ID,��ĿID,ϵͳģ��ID[/tagsinfo]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='spinfo')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fline=obj.line.value;
	var ftitlelen=obj.titlelen.value;
	var fvname=obj.vname.value;
	bqstr="[spinfo]'"+fvname+"',"+fline+","+ftitlelen+"[/spinfo]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="spinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">spinfo��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��Ƭ��������</td>
            <td width="76%"><input name="vname" type="text" id="vname">
              <input type="button" name="Submit43" value="�鿴��Ƭ" onclick="window.open('../sp/ListSp.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line" value="10"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ȡ������</td>
            <td width="76%"><input name="titlelen" type="text" id="titlelen2" value="32"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">&nbsp; </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#spinfo" target="_blank" title="�鿴��ϸ��ǩ�﷨">[spinfo]��Ƭ������,��ʾ����,�����ȡ��[/spinfo]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='showtags')
{
	$tagsclass='';
	$tcsql=$empire->query("select classid,classname from {$dbtbpre}enewstagsclass order by classid");
	while($tcr=$empire->fetch($tcsql))
	{
		$tagsclass.='<option value="'.$tcr[classid].'">'.$tcr[classname].'</option>';
	}
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var tfont='';
	var dh='';
	var fclassid=obj.tagsclassid.value;
	var flnum=obj.lnum.value;
	var fline=obj.line.value;
	var forderby=obj.orderby.value;
	var fisgood=obj.isgood.value;
	var fjg=obj.jg.value;
	var fshownum=obj.shownum.value;
	var faddcs=obj.addcs.value;
	var fvartype=obj.vartype.value;
	//����
	if(obj.tfontb.checked==true)
	{
		tfont+='s';
		dh=',';
	}
	if(obj.tfontr.checked==true)
	{
		tfont+=dh+'r';
	}
	bqstr="[showtags]"+fclassid+","+flnum+","+fline+",'"+forderby+"',"+fisgood+",'"+tfont+"','"+fjg+"',"+fshownum+",'"+faddcs+"','"+fvartype+"'[/showtags]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="showtags">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">showtags��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ѡ��TAGS���ࣺ</td>
            <td width="76%"><select name="tagsclassid" id="tagsclassid">
                <option value="''">����</option>
                <option value="'selfinfo'">���õ�ǰ��ϢTAGS</option>
                <?=$tagsclass?>
              </select> </td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������������</td>
            <td width="76%"><input name="lnum" type="text" id="lnum" value="10"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ÿ����ʾ������</td>
            <td width="76%"><input name="line" type="text" id="titlelen2" value="0">
              <font color="#666666">(0Ϊ������) </font></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby"> <select name="selectorderby" id="select" onchange="document.bqform.orderby.value=document.bqform.selectorderby.value">
                <option value="">Ĭ������</option>
                <option value="tagid desc">��TAGSID����</option>
                <option value="num desc">����Ϣ������</option>
              </select>
              <font color="#666666">(���õ�ǰTAGS��������Ч)</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ֻ��ʾ�Ƽ��ģ�</td>
            <td width="76%"><select name="isgood" id="select14">
                <option value="0">����</option>
                <option value="1">��</option>
              </select>
              <font color="#666666">(���õ�ǰTAGS��������Ч)</font> </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�Ƽ�TAGS���ԣ�</td>
            <td width="76%"><input name="tfontb" type="checkbox" id="tfontb" value="1">
              �Ӵ� <input name="tfontr" type="checkbox" id="tfontr" value="1">
              �Ӻ�<font color="#666666">(���õ�ǰTAGS��������Ч)</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ�������</td>
            <td width="76%"><input name="jg" type="text" id="line2" value="&amp;nbsp;"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ��Ϣ������</td>
            <td width="76%"><select name="shownum" id="select16">
                <option value="0">����ʾ</option>
                <option value="1">��ʾ</option>
              </select>
              <font color="#666666">(���õ�ǰTAGS��������Ч)</font></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">���Ӹ��Ӳ�����</td>
            <td width="76%"><input name="addcs" type="text" id="line4">
              <font color="#666666">(���磺&amp;tempid=ģ��ID) </font></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����ʹ�ñ�����</td>
            <td width="76%"><select name="vartype">
				<option value="tagname">tagname</option>
                <option value="tagid">tagid</option>
              </select>
              <font color="#666666">(���磺tagname=�۹���tagid=1)</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#showtags" target="_blank" title="�鿴��ϸ��ǩ�﷨">[showtags]����ID,��ʾ����,ÿ����ʾ����,��ʾ����,ֻ��ʾ�Ƽ�,�Ƽ�TAGS����,��ʾ�����,�Ƿ���ʾ��Ϣ��,���Ӹ��Ӳ���,����ʹ�ñ���[/showtags]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='showclasstemp')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fshownum=obj.shownum.value;
	var ftempid=obj.tempid.value;
	var fclassnum=obj.classnum.value;
	bqstr="[showclasstemp]"+fclassid+","+ftempid+","+fshownum+","+fclassnum+"[/showclasstemp]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">showclasstemp��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select15">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit62223235" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ��Ŀ��Ϣ����</td>
            <td width="76%"><select name="shownum" id="select17">
                <option value="0">����ʾ</option>
                <option value="1">��ʾ</option>
              </select>
              <font color="#666666">(��ǩģ���[!--num--])</font></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������ʾ��Ŀ����</td>
            <td width="76%"><input name="classnum" type="text" id="titlelen5" value="0">
              <font color="#666666">(0Ϊ������)</font> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#showclasstemp" target="_blank" title="�鿴��ϸ��ǩ�﷨">[showclasstemp]����ĿID,��ǩģ��ID,�Ƿ���ʾ��Ŀ��Ϣ��,��ʾ��Ŀ��[/showclasstemp]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='eshowzt')
{
	//����
	$zcstr='';
	$zcsql=$empire->query("select classid,classname from {$dbtbpre}enewsztclass order by classid");
	while($zcr=$empire->fetch($zcsql))
	{
		$zcstr.="<option value='".$zcr[classid]."'>".$zcr[classname]."</option>";
	}
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=ReturnAddYh(obj.classid.value);
	var fzcid=obj.zcid.value;
	var ftempid=obj.tempid.value;
	var fclassnum=obj.classnum.value;
	bqstr="[eshowzt]"+ftempid+","+fzcid+","+fclassnum+","+fclassid+"[/eshowzt]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">eshowzt��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select20">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit622232353" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����ר����ࣺ</td>
            <td width="76%"><select name="zcid" id="select19">
                <option value="0">����</option>
				<?=$zcstr?>
              </select> <input type="button" name="Submit622232352" value="����ר�����" onclick="window.open('../special/ListZtClass.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������ʾר������</td>
            <td width="76%"><input name="classnum" type="text" id="classnum" value="0"> 
              <font color="#666666">(0Ϊ������)</font> </td>
          </tr>
        </table> </td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������ĿID��</td>
            <td width="76%"><input name="classid" type="text" id="classid" value="0"> 
              <font color="#666666"> 
              <input type="button" name="Submit422" value="�鿴��ĿID" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');">
              (0Ϊ���ޣ����ID��,�Ÿ���)</font> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#eshowzt" target="_blank" title="�鿴��ϸ��ǩ�﷨">[eshowzt]��ǩģ��ID,ר�����ID,��ʾר����,������ĿID[/eshowzt]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='listshowclass')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fshownum=obj.shownum.value;
	var ftempid=obj.tempid.value;
	var fclassnum=obj.classnum.value;
	bqstr="[listshowclass]"+fclassid+","+ftempid+","+fshownum+","+fclassnum+"[/listshowclass]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">listshowclass��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select15">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit62223235" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ��Ŀ��Ϣ����</td>
            <td width="76%"><select name="shownum" id="select17">
                <option value="0">����ʾ</option>
                <option value="1">��ʾ</option>
              </select>
              <font color="#666666">(��ǩģ���[!--num--])</font></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������ʾ��Ŀ����</td>
            <td width="76%"><input name="classnum" type="text" id="titlelen5" value="0">
              <font color="#666666">(0Ϊ������)</font> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#listshowclass" target="_blank" title="�鿴��ϸ��ǩ�﷨">[listshowclass]����ĿID,��ǩģ��ID,�Ƿ���ʾ��Ŀ��Ϣ��,��ʾ��Ŀ��[/listshowclass]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='phomead')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	bqstr="[phomead]"+fclassid+"[/phomead]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">phomead��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">���ID��</td>
            <td width="76%"><input name="classid" type="text" id="classid" value="0">
              <input type="button" name="Submit622232354" value="�鿴���ID" onclick="window.open('../tool/ListAd.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#phomead" target="_blank" title="�鿴��ϸ��ǩ�﷨">[phomead]���ID[/phomead]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='phomevote')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	bqstr="[phomevote]"+fclassid+"[/phomevote]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">phomevote��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ͶƱID��</td>
            <td width="76%"><input name="classid" type="text" id="classid" value="0">
              <input type="button" name="Submit622232354" value="�鿴ͶƱID" onclick="window.open('../tool/ListVote.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#phomevote" target="_blank" title="�鿴��ϸ��ǩ�﷨">[phomevote]ͶƱID[/phomevote]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='phomelink')
{
	//���
	$cstr='';
	$csql=$empire->query("select classid,classname from {$dbtbpre}enewslinkclass order by classid");
	while($cr=$empire->fetch($csql))
	{
		$cstr.="<option value='".$cr[classid]."'>".$cr[classname]."</option>";
	}
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fline=obj.line.value;
	var flnum=obj.lnum.value;
	var fcid=obj.cid.value;
	var fdotype=obj.dotype.value;
	var fshowlink=obj.showlink.value;
	bqstr="[phomelink]"+fline+","+flnum+","+fdotype+","+fcid+","+fshowlink+"[/phomelink]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">phomelink��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select20">
                <option value="0">��������</option>
                <option value="1">ֻ����ͼƬ����</option>
                <option value="2">ֻ������������</option>
              </select> </td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">���Ʒ��ࣺ</td>
            <td width="76%"><select name="cid" id="select19">
                <option value="0">����</option>
                <?=$cstr?>
              </select> <input type="button" name="Submit622232352" value="�����������ӷ���" onclick="window.open('../tool/LinkClass.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������������</td>
            <td width="76%"><input name="lnum" type="text" id="lnum" value="12"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ÿ����ʾ������</td>
            <td width="76%"><input name="line" type="text" id="line5" value="6">
            </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾԭ���ӣ�</td>
            <td width="76%"><select name="showlink" id="select18">
                <option value="0">ͳ�Ƶ������</option>
                <option value="1">��ʾԭ����</option>
              </select> </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#phomelink" target="_blank" title="�鿴��ϸ��ǩ�﷨">[phomelink]ÿ����ʾ��,��ʾ����,��������,����id,�Ƿ���ʾԭ����[/phomelink]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='gbookinfo')
{
	//����
	$cstr='';
	$csql=$empire->query("select bid,bname from {$dbtbpre}enewsgbookclass order by bid");
	while($cr=$empire->fetch($csql))
	{
		$cstr.="<option value='".$cr[bid]."'>".$cr[bname]."</option>";
	}
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fline=obj.line.value;
	var fcid=obj.cid.value;
	var ftempid=obj.tempid.value;
	bqstr="[gbookinfo]"+fline+","+ftempid+","+fcid+"[/gbookinfo]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">gbookinfo��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select20">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit622232353" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������Է��ࣺ</td>
            <td width="76%"><select name="cid" id="select19">
                <option value="0">����</option>
				<?=$cstr?>
              </select> <input type="button" name="Submit622232352" value="�������Է���" onclick="window.open('../tool/GbookClass.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line" value="5">
            </td>
          </tr>
        </table> </td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#gbookinfo" target="_blank" title="�鿴��ϸ��ǩ�﷨">[gbookinfo]��ʾ��Ϣ��,��ǩģ��ID,���Է���ID[/gbookinfo]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='showplinfo')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fline=obj.line.value;
	var fclassid=obj.classid.value;
	var fid=obj.id.value;
	var ftempid=obj.tempid.value;
	var fisgood=obj.isgood.value;
	var fdotype=obj.dotype.value;
	bqstr="[showplinfo]"+fline+","+ftempid+","+fclassid+","+fid+","+fisgood+","+fdotype+"[/showplinfo]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">showplinfo��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ��������</td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="select22">
                <option value="0">������ʱ������</option>
                <option value="1">��֧��������</option>
                <option value="2">������������</option>
              </select> </td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ǩģ�壺</td>
            <td width="76%"><select name="tempid" id="select21">
                <?=$bqtemp?>
              </select> <input type="button" name="Submit6222323532" value="�����ǩģ��" onclick="window.open('ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </table> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line" value="10"> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������ĿID��</td>
            <td width="76%"><input name="classid" type="text" id="classid" value="0">
              [<a href="#empirecms" onclick="document.bqform.classid.value='$GLOBALS[navclassid]';">��ǰ��ĿID</a>] 
              <font color="#666666"> 
              <input type="button" name="Submit4222" value="�鿴��ĿID" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');">
              (0Ϊ����)</font> </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">������ϢID��</td>
            <td width="76%"><input name="id" type="text" id="id" value="0">
              [<a href="#empirecms" onclick="document.bqform.id.value='$navinfor[id]';">��ǰ��ϢID</a>] <font color="#666666"> (0Ϊ����)</font></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">ֻ�����Ƽ����ۣ�</td>
            <td width="76%"><select name="isgood" id="select23">
                <option value="0">����</option>
                <option value="1">ֻ�����Ƽ�����</option>
              </select> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#showplinfo" target="_blank" title="�鿴��ϸ��ǩ�﷨">[showplinfo]��������,��ǩģ��ID,��ĿID,��ϢID,��ʾ�Ƽ�����,��������[/showplinfo]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='echocheckbox')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var flfield=obj.lfield.value;
	var fexpstr=obj.expstr.value;
	bqstr="[echocheckbox]'"+flfield+"','"+fexpstr+"'[/echocheckbox]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">echocheckbox��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ѡ�ֶ�����</td>
            <td width="76%"><input name="lfield" type="text" id="lfield" value="title">
            </td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�ָ�����</td>
            <td width="76%"><input name="expstr" type="text" id="expstr" value="&lt;br&gt;"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#echocheckbox" target="_blank" title="�鿴��ϸ��ǩ�﷨">[echocheckbox]'�ֶ�','�ָ���'[/echocheckbox]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='includefile')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var flfile=obj.lfile.value;
	bqstr="[includefile]'"+flfile+"'[/includefile]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">includefile��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�����ļ���ַ��</td>
            <td width="76%"><input name="lfile" type="text" id="lfile" value="../../header.html">
              <font color="#666666">(����ں�̨Ŀ¼)</font> </td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#includefile" target="_blank" title="�鿴��ϸ��ǩ�﷨">[includefile]'�ļ���ַ'[/includefile]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='readhttp')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var flfile=obj.lfile.value;
	bqstr="[readhttp]'"+flfile+"'[/readhttp]";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ecmsinfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">readhttp��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ȡ��ҳ��ַ��</td>
            <td width="76%"><input name="lfile" type="text" id="lfile" value="http://">
            </td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#readhttp" target="_blank" title="�鿴��ϸ��ǩ�﷨">[readhttp]'ҳ���ַ'[/readhttp]</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='ShowMemberInfo')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var flfield=obj.lfield.value;
	var fmuserid=obj.muserid.value;
	bqstr="<?="<?php\\r\\n\$userr=sys_ShowMemberInfo(\"+fmuserid+\",'\"+flfield+\"');\\r\\n?>"?>\r\n";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ShowMemberInfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">ShowMemberInfo������������ 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��Ա�ʺ�ID��</td>
            <td width="76%"><input name="muserid" type="text" id="muserid" value="0">
              <input type="button" name="Submit62223235222" value="�鿴��ԱID" onclick="window.open('../member/ListMember.php<?=$ecms_hashur['whehref']?>');">
              <font color="#666666">(0Ϊ������ID)</font></td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ѯ�ֶΣ�</td>
            <td width="76%"> 
              <input name="lfield" type="text" id="lfield">
              <font color="#666666">(��Ϊ��ѯ���л�Ա�ֶ�)</font> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#ShowMemberInfo" target="_blank" title="�鿴��ϸ��ǩ�﷨">sys_ShowMemberInfo(�û�ID,��ѯ�ֶ�)</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="5" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='ListMemberInfo')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var tfont='';
	var dh='';
	var fdotype=obj.dotype.value;
	var fline=obj.line.value;
	var fmgroupid=obj.mgroupid.value;
	var fmuserid=obj.muserid.value;
	var flfield=obj.lfield.value;
	bqstr="<?="<?php\\r\\n\$usersql=sys_ListMemberInfo(\"+fline+\",\"+fdotype+\",'\"+fmgroupid+\"','\"+fmuserid+\"','\"+flfield+\"');\\r\\nwhile(\$userr=\$empire->fetch(\$usersql))\\r\\n{\\r\\n?>\\r\\n<a href=\\\"/e/space/?userid=<?=\$userr[userid]?>\\\"><?=\$userr[username]?></a><br>\\r\\n<?php\\r\\n}\\r\\n?>"?>";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ListMemberInfo">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">ListMemberInfo���ú������� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ�������� </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">�������ͣ�</td>
            <td width="76%"><select name="dotype" id="dotype">
                <option value="0">��ע��ʱ������</option>
                <option value="1">��������������</option>
                <option value="2">���ʽ���������</option>
                <option value="3">����Ա�ռ�������������</option>
              </select> </td>
          </tr>
        </table></td>
      <td width="50%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line7" value="10"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">���ƻ�Ա��ID��</td>
            <td width="76%"><input name="mgroupid" type="text" id="mgroupid">
              <input type="button" name="Submit622232352222" value="�鿴��Ա��ID" onclick="window.open('../member/ListMemberGroup.php<?=$ecms_hashur['whehref']?>');"> 
              <font color="#666666">(������Ϊ���ޣ������Ա���ö��Ÿ������磺'1,2') </font></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��Ա�ʺ�ID��</td>
            <td width="76%"><input name="muserid" type="text" id="muserid"> 
              <input type="button" name="Submit622232352223" value="�鿴��ԱID" onclick="window.open('../member/ListMember.php<?=$ecms_hashur['whehref']?>');">
              <font color="#666666">(������Ϊ���ޣ�����û�ID�ö��Ÿ������磺'25,27')</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ѯ�ֶΣ�</td>
            <td width="76%"> <input name="lfield" type="text" id="lfield3"> <font color="#666666">(��Ϊ��ѯ���л�Ա�ֶ�)</font> 
            </td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#333333"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#ListMemberInfo" target="_blank" title="�鿴��ϸ��ǩ�﷨">sys_ListMemberInfo(��������,��������,��Ա��ID,�û�ID,��ѯ�ֶ�)</a></font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="12" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit2" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
elseif($bqname=='spaceeloop')
{
?>
<script>
//���ر�ǩ
function ShowBqFun(){
	var obj=document.bqform;
	var bqstr;
	var addstr='';
	var fclassid=obj.classid.value;
	var fline=obj.line.value;
	var fdotype=obj.dotype.value;
	var fispic=obj.ispic.value;
	var faddsql=obj.addsql.value;
	var forderby=obj.orderby.value;
	addstr=ReturnAddSql(faddsql,forderby);
	bqstr="<?="<?php\\r\\n\$spacesql=espace_eloop(\"+fclassid+\",\"+fline+\",\"+fdotype+\",\"+fispic+addstr+\");\\r\\nwhile(\$spacer=\$empire->fetch(\$spacesql))\\r\\n{\\r\\n        \$spacesr=espace_eloop_sp(\$spacer);\\r\\n?>\\r\\n<a href=\\\"<?=\$spacesr[titleurl]?>\\\" target=\\\"_blank\\\"><?=\$spacer[title]?></a> <br>\\r\\n<?php\\r\\n}\\r\\n?>"?>";
	obj.bqshow.value=bqstr;
}
</script>
<form action="MakeBq.php" method="GET" name="bqform" id="bqform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="spaceeloop">
	<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" colspan="2" class="header">spaceeloop��Ա�ռ��鶯��ǩ���� 
        <input name="bqname" type="hidden" id="bqname" value="<?=$bqname?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ����ö��� 
        <select name="doobject" id="doobject" onchange="self.location.href='MakeBq.php?<?=$ecms_hashur['ehref']?>&bqname=<?=$bqname?>&addselfinfo=1&doobject='+this.options[this.selectedIndex].value">
          <option value="1"<?=$doobject==1?' selected':''?>>��Ĭ�ϱ�( 
          <?=$public_r['tbname']?>
          )</option>
          <option value="2"<?=$doobject==2?' selected':''?>>��Ŀ</option>
          <option value="5"<?=$doobject==5?' selected':''?>>�������</option>
          <option value="4"<?=$doobject==4?' selected':''?>>���ݱ�</option>
          <option value="5"<?=$doobject==5?' selected':''?>>�������</option>
          <option value="6"<?=$doobject==6?' selected':''?>>��SQL����</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" height="25" bgcolor="#FFFFFF"> 
        <?=$dotype?>
      </td>
      <td width="50%" bgcolor="#FFFFFF"> 
        <?=$changeobject?>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����������</td>
            <td width="76%"><input name="line" type="text" id="line" value="10"></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF">ֻ�����б���ͼƬ����Ϣ�� 
        <select name="ispic" id="select6">
          <option value="0">����</option>
          <option value="1">��</option>
        </select> </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">ѡ������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">����SQL������</td>
            <td width="76%"><input name="addsql" type="text" id="addsql"> <select name="addsqlselect" onchange="document.bqform.addsql.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="isgood=1">1���Ƽ�</option>
<option value="firsttitle=1">1��ͷ��</option>
<option value="field='ֵ'">�ֶε���ĳֵ</option>
</select></td>
          </tr>
        </table></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="24%">��ʾ����</td>
            <td width="76%"><input name="orderby" type="text" id="orderby"> <select name="orderbyselect" onchange="document.bqform.orderby.value=this.value">
<option value=""> -- Ԥѡ�� -- </option>
<option value="newstime DESC">������ʱ�併������</option>
<option value="newstime ASC">������ʱ����������</option>
<option value="id DESC">��ID��������</option>
<option value="onclick DESC">������ʽ�������</option>
<option value="totaldown DESC">����������������</option>
<option value="plnum DESC">����������������</option>
<option value="diggtop DESC">������(digg)��������</option>
</select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input type="button" name="Submit3" value="�����ǩ" onclick="ShowBqFun();"> 
      </td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><a href="EnewsBq.php<?=$ecms_hashur['whehref']?>#spaceeloop" target="_blank" title="�鿴��ϸ��ǩ�﷨">&lt;?php<br>
        $spacesql=espace_eloop(��ĿID,��ʾ����,��������,ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����);<br>
        while($spacer=$empire-&gt;fetch($spacesql))<br>
        {<br>
        $spacesr=espace_eloop_sp($spacer);<br>
        ?&gt;<br>
        ģ���������<br>
        &lt;?php<br>
        }<br>
        ?&gt;</a></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><textarea name="bqshow" cols="65" rows="12" id="bqshow" style="width:100%"></textarea></td>
          </tr>
          <tr> 
            <td height="25"><input type="button" name="Submit22" value="���������ǩ����" onclick="window.clipboardData.setData('Text',document.bqform.bqshow.value);document.bqform.bqshow.select()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
}
?>
</body>
</html>
<?php
db_close();
$empire=null;
?>
