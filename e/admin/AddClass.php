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
CheckLevel($logininid,$loginin,$classid,"class");
$enews=ehtmlspecialchars($_GET['enews']);
if($_GET['from'])
{
	$listclasslink="ListPageClass.php";
}
else
{
	$listclasslink="ListClass.php";
}
$url="<a href=".$listclasslink.$ecms_hashur['whehref'].">��Ŀ����</a>&nbsp;>&nbsp;������Ŀ";
$zt="";
$b_ok=1;
$hiddenclass="<script>document.getElementById('smallclass').style.display='none';document.getElementById('smallclasssetinfo').style.display='none';document.getElementById('smallclasssettemp').style.display='none';document.getElementById('smallcgtoinfo').style.display='none';document.getElementById('smallclassbdinfo').style.display='none';</script>";
//��ʹ������
$r[myorder]=0;
$r[listorder]="id DESC";
$r[reorder]="newstime DESC";
$islast="";
$filename0=" checked";
$filename1="";
$filename2="";
$openpl0=" checked";
$openpl1="";
$openadd0="";
$openadd1=" checked";
$r[classtype]=".html";
$r[filetype]=".html";
$r[newspath]="Y-m-d";
$r[link_num]="10";
$r[lencord]=25;
$read="";
$r[newline]=10;
$r[hotline]=10;
$r[goodline]=10;
$r[hotplline]=10;
$r[firstline]=10;
$r[maxnum]=0;
$r[addinfofen]=0;
$r[doctime]=0;
$r[down_num]=2;
$r[online_num]=2;
$checked=" checked";
$r['addreinfo']=1;
$defaultbclassid=" selected";
$islist="";
$islast="<input name=islast type=checkbox id=islast onclick='small_class(this.checked)' value='1'>��";
//������Ŀ
$docopy=ehtmlspecialchars($_GET['docopy']);
if($docopy&&$enews=="AddClass")
{
	$copyclass=1;
}
$ecmsfirstpost=1;
$classid=(int)$_GET['classid'];
if($enews=='EditClass')
{
	$filepass=$classid;
}
else
{
	$filepass=ReturnTranFilepass();
}
//�޸���Ŀ
if($enews=="EditClass"||$copyclass)
{
	$ecmsfirstpost=0;
	if($copyclass)
	{
		$thisdo="����";
	}
	else
	{
		$thisdo="�޸�";
	}
	$read="";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsclass where classid='$classid'");
	$addr=$empire->fetch1("select * from {$dbtbpre}enewsclassadd where classid='$classid'");
	if(!empty($r[bclassid]))
	{$defaultbclassid="";}
	$url="<a href=".$listclasslink.$ecms_hashur['whehref'].">������Ŀ</a>&nbsp;>&nbsp;".$thisdo."��Ŀ��".$r[classname];
	if($r[islist])
	{$islist=" checked";}
	//�޸Ĵ���Ŀ
	if(!$r[islast])
	{
		//����Ŀ
		if(empty($r[bclassid]))
		{
			$b_ok=1;
		}
		//�м���Ŀ
		else
		{
			$b_ok=1;
		}
	}
	//�ռ���Ŀ
	else
	{
		$hiddenclass="<script>document.getElementById('bigclasssettemp').style.display='none';document.getElementById('bigclasssetclasstext').style.display='none';</script>";
		$b_ok=0;
	}
	//�ռ����
	if($r[islast])
	{
		$islast="<b>��</b>";
		$islastcheck=" checked";
	}
	else
	{
		$islast="<b>��</b>";
		$islastcheck="";
	}
	$islast.="<input type=hidden name=islast value='".$r[islast]."'>";
	if($r[filename]==1)
	{
		$filename0="";
		$filename1=" checked";
		$filename2="";
	}
	elseif($r[filename]==2)
	{
		$filename0="";
		$filename1="";
		$filename2=" checked";
	}
	else
	{}
	if($r[openpl])
	{
		$openpl0="";
		$openpl1=" checked";
	}
	if($r[checkpl])
	{
		$checkpl=" checked";
	}
	if($r[openadd])
	{
		$openadd0="";
		$openadd1=" checked";
	}
	else
	{
		$openadd0=" checked";
		$openadd1="";
	}
	//��ĿĿ¼
	$mycr=GetPathname($r[classpath]);
	$pripath=$mycr[1];
	$classpath=$mycr[0];
	$read="";
	//������Ŀ
	if($copyclass)
	{
		$r[classname].="(1)";
		$classpath.="1";
		$read="";
		$islast="<input name=islast type=checkbox id=islast onclick='small_class(this.checked)' value='1'".$islastcheck.">��";
    }
	if($r[checked])
	{$checked=" checked";}
	else
	{$checked="";}
}
//ϵͳģ��
$m_sql=$empire->query("select mid,mname,usemod from {$dbtbpre}enewsmod order by myorder,mid");
while($m_r=$empire->fetch($m_sql))
{
	if(empty($m_r[usemod]))
	{
		if($m_r[mid]==$r[modid])
		{$m_d=" selected";}
		else
		{$m_d="";}
		$mod_options.="<option value=".$m_r[mid].$m_d.">".$m_r[mname]."</option>";
	}
	//�б�ģ��
	$listtemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$dtlisttemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$lt_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewslisttemp")." where modid='$m_r[mid]'");
	while($lt_r=$empire->fetch($lt_sql))
	{
		//��̬
		if($lt_r[tempid]==$r[listtempid])
		{$lt_d=" selected";}
		else
		{$lt_d="";}
		$listtemp_options.="<option value=".$lt_r[tempid].$lt_d."> |-".$lt_r[tempname]."</option>";
		//��̬
		if($lt_r[tempid]==$r[dtlisttempid])
		{$lt_dt=" selected";}
		else
		{$lt_dt="";}
		$dtlisttemp_options.="<option value=".$lt_r[tempid].$lt_dt."> |-".$lt_r[tempname]."</option>";
	}
	//����ģ��
	$searchtemp.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$st_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewssearchtemp")." where modid='$m_r[mid]'");
	while($st_r=$empire->fetch($st_sql))
	{
		if($st_r[tempid]==$r[searchtempid])
		{$st_d=" selected";}
		else
		{$st_d="";}
		$searchtemp.="<option value=".$st_r[tempid].$st_d."> |-".$st_r[tempname]."</option>";
	}
	//����ģ��
	$newstemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$nt_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewsnewstemp")." where modid='$m_r[mid]'");
	while($nt_r=$empire->fetch($nt_sql))
	{
		if($nt_r[tempid]==$r[newstempid])
		{$nt_d=" selected";}
		else
		{$nt_d="";}
		$newstemp_options.="<option value=".$nt_r[tempid].$nt_d."> |-".$nt_r[tempname]."</option>";
	}
}
//��Ŀ
$fcfile="../data/fc/ListEnews.php";
$fcjsfile="../data/fc/cmsclass.js";
if(file_exists($fcjsfile)&&file_exists($fcfile))
{
	$options=GetFcfiletext($fcjsfile);
	$options=str_replace("<option value='$r[bclassid]'","<option value='$r[bclassid]' selected",$options);
}
else
{
	$options=ShowClass_AddClass("",$r[bclassid],0,"|-",0,0);
}
//������
$group='';
$vgsql=$empire->query("select vgid,gname from {$dbtbpre}enewsvg order by vgid");
while($vgr=$empire->fetch($vgsql))
{
	$vselected='';
	$vgid=0-$vgr['vgid'];
	if($r['groupid']==$vgid)
	{
		$vselected=' selected';
	}
	$group.="<option value=".$vgid."".$vselected.">".$vgr['gname']."</option>";
}
if($group)
{
	$group="<option value=''>-- ������ --</option>".$group."<option value=''>-- ��Ա�� --</option>";
}
//��Ա��
$qgroup='';
$qgbr='';
$qgi=0;
$cgroup='';
$sql1=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	if($r[groupid]==$l_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$l_r[groupid].$select.">".$l_r[groupname]."</option>";
	//Ͷ��
	$qgi++;
	if($qgi%6==0)
	{
		$qgbr='<br>';
	}
	else
	{
		$qgbr='';
	}
	$qgchecked='';
	if(strstr($r[qaddgroupid],','.$l_r[groupid].','))
	{
		$qgchecked=' checked';
	}
	$qgroup.="<input type=checkbox name=qaddgroupidck[] value='".$l_r[groupid]."'".$qgchecked.">".$l_r[groupname]."&nbsp;".$qgbr;
	//��ĿҳȨ��
	$cgchecked='';
	if(strstr($r[cgroupid],','.$l_r[groupid].','))
	{
		$cgchecked=' checked';
	}
	$cgroup.="<input type=checkbox name=cgroupidck[] value='".$l_r[groupid]."'".$cgchecked.">".$l_r[groupname]."&nbsp;".$qgbr;
}
//jsģ��
$jstempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsjstemp")." order by tempid");
while($jstempr=$empire->fetch($jstempsql))
{
	$select="";
	if($r[jstempid]==$jstempr[tempid])
	{
		$select=" selected";
	}
	$jstemp.="<option value='".$jstempr[tempid]."'".$select.">".$jstempr[tempname]."</option>";
}
//����ģ��
$classtempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsclasstemp")." order by tempid");
while($classtempr=$empire->fetch($classtempsql))
{
	$select="";
	if($r[classtempid]==$classtempr[tempid])
	{
		$select=" selected";
	}
	$classtemp.="<option value='".$classtempr[tempid]."'".$select.">".$classtempr[tempname]."</option>";
}
//����ģ��
$pltempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewspltemp")." order by tempid");
while($pltempr=$empire->fetch($pltempsql))
{
	$select="";
	if($r[pltempid]==$pltempr[tempid])
	{
		$select=" selected";
	}
	$pltemp.="<option value='".$pltempr[tempid]."'".$select.">".$pltempr[tempname]."</option>";
}
//WAPģ��
$wapstyles='';
$wapstyle_sql=$empire->query("select styleid,stylename from {$dbtbpre}enewswapstyle order by styleid");
while($wapstyle_r=$empire->fetch($wapstyle_sql))
{
	$select="";
	if($r[wapstyleid]==$wapstyle_r[styleid])
	{
		$select=" selected";
	}
	$wapstyles.="<option value='".$wapstyle_r[styleid]."'".$select.">".$wapstyle_r[stylename]."</option>";
}
//Ԥ��ͶƱ
$infovotesql=$empire->query("select voteid,ysvotename from {$dbtbpre}enewsvotemod order by voteid desc");
while($infovoter=$empire->fetch($infovotesql))
{
	$select="";
	if($r[definfovoteid]==$infovoter[voteid])
	{
		$select=" selected";
	}
	$definfovote.="<option value='".$infovoter[voteid]."'".$select.">".$infovoter[ysvotename]."</option>";
}
//�Ż�����
$yh_options='';
$yhsql=$empire->query("select id,yhname from {$dbtbpre}enewsyh order by id");
while($yhr=$empire->fetch($yhsql))
{
	$select='';
	if($r[yhid]==$yhr[id])
	{
		$select=' selected';
	}
	$yh_options.="<option value='".$yhr[id]."'".$select.">".$yhr[yhname]."</option>";
}
//������
$workflows='';
$wfsql=$empire->query("select wfid,wfname from {$dbtbpre}enewsworkflow order by myorder,wfid");
while($wfr=$empire->fetch($wfsql))
{
	$select='';
	if($r[wfid]==$wfr[wfid])
	{
		$select=' selected';
	}
	$workflows.="<option value='".$wfr[wfid]."'".$select.">".$wfr[wfname]."</option>";
}
//�༭��
include('ecmseditor/eshoweditor.php');
$loadeditorjs=ECMS_ShowEditorJS('ecmseditor/infoeditor/');
//��ǰʹ�õ�ģ����
$thegid=GetDoTempGid();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" type="text/css">
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="adminstyle/<?=$loginadminstyleid?>/tab.winclassic.css" disabled="disabled" /> 
<title>������Ŀ</title>
<!-- the id is not needed. It is used here to be able to change css file at runtime -->
<style type="text/css"> 
   .dynamic-tab-pane-control .tab-page { 
          width:                98%;
 } 
  .dynamic-tab-pane-control .tab-page .dynamic-tab-pane-control .tab-page { 
         height:                150px; 
 } 
  form { 
         margin:        0; 
         padding:        0; 
 } 
  /* over ride styles from webfxlayout */ 
  .dynamic-tab-pane-control h2 { 
         font-size:12px;
		 font-weight:normal;
		 text-align:        center; 
         width:                auto;
		 height:            20; 
 } 
   .dynamic-tab-pane-control h2 a { 
         display:        inline; 
         width:                auto; 
 } 
  .dynamic-tab-pane-control a:hover { 
         background: transparent; 
 } 
  </style>
  <?=$loadeditorjs?>
 <script type="text/javascript" src="../data/images/tabpane.js"></script> <script type="text/javascript"> 
  function setLinkSrc( sStyle ) { 
         document.getElementById( "luna-tab-style-sheet" ).disabled = sStyle != "luna"; 
  
         //document.documentElement.style.background = "";
         //document.body.style.background = sStyle == "webfx" ? "white" : "ThreeDFace"; 
 } 
function chgBg(obj,color){
 if (document.all || document.getElementById)
   obj.style.backgroundColor=color;
 else if (document.layers)
   obj.bgColor=color;
}
  setLinkSrc( "luna" ); 
  </script>
  
<script>
function small_class(mycheck)
{
if(mycheck)
{
document.getElementById('smallclass').style.display="";
document.getElementById('smallclasssetinfo').style.display="";
document.getElementById('smallclasssettemp').style.display="";
document.getElementById('bigclasssettemp').style.display="none";
document.getElementById('bigclasssetclasstext').style.display="none";
document.getElementById('smallcgtoinfo').style.display="";
document.getElementById('smallclassbdinfo').style.display="";
}
else
{
document.getElementById('smallclass').style.display="none";
document.getElementById('smallclasssetinfo').style.display="none";
document.getElementById('smallclasssettemp').style.display="none";
document.getElementById('bigclasssettemp').style.display="";
document.getElementById('bigclasssetclasstext').style.display="";
document.getElementById('smallcgtoinfo').style.display="none";
document.getElementById('smallclassbdinfo').style.display="none";
}
}

function mybclass()
{
bclass=new Array();
bclass[0]=new Array();
bclass[0][0]='';
<?
//-----------���js����
$psql=$empire->query("select classid,classpath from {$dbtbpre}enewsclass order by classid");
$i=0;
while($pr=$empire->fetch($psql))
{
?>
bclass[<?=$pr[classid]?>]=new Array();
bclass[<?=$pr[classid]?>][0]="<?=$pr[classpath]?>/";
<?
}
?>
}
mybclass();

function changeitem(myfrm)
{var SelectedBigId;
SelectedBigId=myfrm.bclassid.options[myfrm.bclassid.selectedIndex].value;
myfrm.pripath.value=bclass[SelectedBigId][0];
	if(myfrm.enews.value=='EditClass')
	{
		if(!myfrm.ecmsclasstype.value==1)
		{
			myfrm.classpath.focus();
		}
	}
	else
	{
		if(!myfrm.ecmsclasstype[1].checked)
		{
			myfrm.classpath.focus();
		}
	}
}

//���
function CheckForm(obj)
{
if(obj.classname.value=="")
{
alert("��������Ŀ����");
return false;
}
if(obj.enews.value=='EditClass')
{
	if(obj.ecmsclasstype.value==1)
	{
		return true;
	}
}
else
{
	if(obj.ecmsclasstype[1].checked)
	{
		return true;
	}
}
if(obj.classpath.value=="")
{
alert("��������ĿĿ¼");
return false;
}
//�ռ���Ŀ
if(<?=$enews=='EditClass'?'obj.islast.value==1':'obj.islast.checked'?>)
{
	if(obj.modid.value==0||obj.modid.value=="")
	{
	alert("��ѡ������ϵͳģ��");
	return false;
	}
	if(obj.listtempid.value==0)
	{
	alert("�뵽��ģ��ѡ�ѡ���б�ģ��");
	return false;
	}
	if(obj.newstempid.value==0)
	{
	alert("�뵽��ģ��ѡ�ѡ������ģ��");
	return false;
	}
	if(obj.filetype.value=="")
	{
	alert("��������Ϣ�ļ���չ��");
	return false;
	}
}
//����Ŀ
else
{
	if(obj.islist[1].checked&&obj.listtempid.value==0)//�б�ʽ
	{
		alert("�뵽��ģ��ѡ�ѡ���б�ģ��");
		return false;
	}
	else if(obj.islist[0].checked&&obj.classtempid.value==0)
	{
		alert("����ģ��ѡ�ѡ�����ģ��");
		return false;
	}
	else if(obj.islist[2].checked&&obj.classtext.value=='')
	{
		alert("�뵽��ģ��ѡ�����ҳ������");
		return false;
	}
}
return true;
}

//�޸İ���Ϣ
function EditBdInfo(obj){
	var infoid=obj.bdinfoid.value;
	var r;
	r=infoid.split(',');
	if(infoid==''||r.length==1)
	{
		alert('���������ϢID');
		return false;
	}
	window.open('AddNews.php?<?=$ecms_hashur['ehref']?>&enews=EditNews&classid='+r[0]+'&id='+r[1]);
}

//�޸İ���Ϣ
function EditSmallBdInfo(obj){
	var infoid=obj.smallbdinfoid.value;
	var r;
	r=infoid.split(',');
	if(infoid==''||r.length==1)
	{
		alert('���������ϢID');
		return false;
	}
	window.open('AddNews.php?<?=$ecms_hashur['ehref']?>&enews=EditNews&classid='+r[0]+'&id='+r[1]);
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?> </td>
  </tr>
</table>
  <form name="form1" method="post" action="ecmsclass.php" onsubmit="return CheckForm(document.form1);">
  <?=$ecms_hashur['form']?>
  <div class="tab-pane" id="TabPane1"> <script type="text/javascript">
tb1 = new WebFXTabPane( document.getElementById( "TabPane1" ) );
</script>
<div class="tab-page" id="baseinfo"> 
                    
      <h2 class="tab">&nbsp;<font class=tabcolor>��������</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "baseinfo" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <input type=hidden name=enews value=<?=$enews?>>
        <tr class="header"> 
          <td height="30" colspan="2">������Ŀ</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">��Ŀ����</td>
          <td> <input name="classname" type="text" id="classname" value="<?=$r[classname]?>" size="38"> 
            <?
	  if($enews=="AddClass")
	  {
	  ?>
            <input type="button" name="Submit5" value="����ƴ��Ŀ¼" onclick="window.open('GetPinyin.php?hz='+document.form1.classname.value+'&returnform=opener.document.form1.classpath.value<?=$ecms_hashur['href']?>','','width=160,height=100');"> 
            <?
	  }
	  ?>
            <input name="oldbclassid" type="hidden" id="oldbclassid" value="<?=$r[bclassid]?>"> 
            <input name="classid" type="hidden" id="classid" value="<?=$classid?>"> 
            <input name="oldclassname" type="hidden" id="oldclassname" value="<?=$r[classname]?>"> 
            <input name="oldislast" type="hidden" id="oldislast" value="<?=$r[islast]?>"> 
            <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��Ŀ����</td>
          <td><input name="bname" type="text" id="bname" value="<?=$r[bname]?>" size="38"> 
            <font color="#666666">(Ϊ��������Ŀ����ͬ)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25" valign="top">��������Ŀ</td>
          <td><select name="bclassid" size="12" id="bclassid" onchange='javascript:changeitem(document.form1);' style="width:320">
              <option value="0"<?=$defaultbclassid?>>����Ŀ</option>
              <?=$options?>
            </select> </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��Ŀ����</td>
          <td> 
            <?php
		  $wbclassstyle=' style="display:none"';
		  $nbclassstyle='';
		  if($enews=='EditClass')
		  {
		  	if(empty($r[wburl]))
			{
				$wbclassstyle=' style="display:none"';
				$nbclassstyle='';
				echo"<b>�ڲ���Ŀ</b><input type=hidden name=ecmsclasstype value=0>";
			}
			else
			{
				$wbclassstyle='';
				$nbclassstyle=' style="display:none"';
				echo"<b>�ⲿ��Ŀ</b><input type=hidden name=ecmsclasstype value=1>";
			}
		  }
		  else
		  {
		  	if(empty($r[wburl]))
			{
				$wbclassstyle=' style="display:none"';
				$nbclassstyle='';
			}
			else
			{
				$wbclassstyle='';
				$nbclassstyle=' style="display:none"';
			}
		  ?>
            <input name="ecmsclasstype" type="radio" value="0"<?=empty($r[wburl])?' checked':''?> onclick="wbclass.style.display='none';nbclass.style.display='';">
            �ڲ���Ŀ 
            <input type="radio" name="ecmsclasstype" value="1"<?=empty($r[wburl])?'':' checked'?> onclick="wbclass.style.display='';nbclass.style.display='none';">
            �ⲿ��Ŀ<font color="#666666">(ѡ������޸�)</font> 
            <?php
			}
			?>          </td>
        </tr>
        <tbody id="wbclass"<?=$wbclassstyle?>>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">&nbsp;</td>
            <td>�ⲿ��Ŀ���ӵ�ַ�� 
              <input name="wburl" type="text" id="wburl" value="<?=$r[wburl]?>" size="38">
              <input name="oldwburl" type="hidden" id="oldwburl" value="<?=$r[wburl]?>"></td>
          </tr>
        </tbody>
        <tbody id="nbclass"<?=$nbclassstyle?>>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">�Ƿ��ռ���Ŀ</td>
            <td> 
              <?=$islast?>
              <font color="#FF0000">(�ռ���Ŀ�²���������Ϣ)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25" valign="top">��Ŀ����ļ��� 
              <input name="oldclasspath" type="hidden" id="oldclasspath" value="<?=$r[classpath]?>"> 
              <br> <input name="oldcpath" type="hidden" id="oldcpath" value="<?=$classpath?>"></td>
            <td><table border="0" cellspacing="1" cellpadding="3">
                <tr bgcolor="DBEAF5"> 
                  <td>&nbsp;</td>
                  <td bgcolor="DBEAF5">�ϲ���ĿĿ¼</td>
                  <td>����ĿĿ¼</td>
                  <td bgcolor="DBEAF5">&nbsp;</td>
                </tr>
                <tr> 
                  <td><div align="right">��Ŀ¼/</div></td>
                  <td><input name="pripath" type="text" id="pripath" value="<?=$pripath?>" size="30">                  </td>
                  <td><input name="classpath" type="text" id="classpath3" value="<?=$classpath?>" size="16"<?=$read?>></td>
                  <td> <div align="left"> 
                      <input type="button" name="Submit3" value="���Ŀ¼" onclick="javascript:window.open('ecmscom.php?<?=$ecms_hashur['href']?>&enews=CheckPath&pripath='+document.form1.pripath.value+'&classpath='+document.form1.classpath.value,'','width=100,height=100,top=250,left=450');">
                    </div></td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" height="25">�󶨵�ϵͳģ��</td>
            <td width="77%"><select name="modid" id="modid">
                <?=$mod_options?>
              </select> <input type="button" name="Submit6" value="����ϵͳģ��" onclick="window.open('db/ListTable.php<?=$ecms_hashur['whehref']?>');">
              * 
              <input name="oldmodid" type="hidden" id="oldmodid" value="<?=$r[modid]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">ʹ���Ż�����</td>
            <td><select name="yhid" id="yhid">
				<option name="0">��ʹ��</option>
                <?=$yh_options?>
              </select> 
              <input type="button" name="Submit63" value="�����Ż�����" onclick="window.open('db/ListYh.php<?=$ecms_hashur['whehref']?>');">            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">������</td>
            <td><input name="classurl" type="text" id="classurl" value="<?=$r[classurl]?>" size="38"> 
              <input name="UrlToSmall" type="checkbox" id="UrlToSmall" value="1">
              Ӧ��������Ŀ<font color="#666666"> (û�а󶨣�������.���������&quot;/&quot;)</font></td>
          </tr>
        </tbody>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��Ŀ����ͼ</td>
          <td><input name="classimg" type="text" id="classimg" value="<?=$r[classimg]?>" size="38"> 
            <a onclick="window.open('ecmseditor/FileMain.php?modtype=1&type=1&classid=&doing=2&field=classimg&filepass=<?=$filepass?>&sinfo=1<?=$ecms_hashur['ehref']?>','','width=700,height=550,scrollbars=yes');" title="ѡ�����ϴ���ͼƬ"><img src="../data/images/changeimg.gif" width="22" height="22" border="0" align="absbottom"></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25" valign="top">ҳ��ؼ���</td>
          <td><input name="classpagekey" type="text" id="classpagekey" value="<?=$r[classpagekey]?>" size="38"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25" valign="top">��Ŀ���</td>
          <td><textarea name="intro" cols="70" rows="8" id="intro"><?=stripSlashes($r[intro])?></textarea></td>
        </tr>
		<?php
		if($enews=='EditClass')
		{
		?>
        <tr bgcolor="#FFFFFF">
          <td height="25">��Ŀ����ʱ��</td>
          <td><?=$r['addtime']?date("Y-m-d",$r['addtime']):'---'?></td>
        </tr>
		<?php
		}
		?>
      </table>
  </div>
  <div class="tab-page" id="changevar"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">ѡ������</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "changevar" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="30" colspan="2">��Ŀѡ��</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">�Ƿ���ʾ������</td>
          <td><input type="radio" name="showclass" value="0"<?=$r[showclass]==0?' checked':''?>>
            ��ʾ 
            <input type="radio" name="showclass" value="1"<?=$r[showclass]==1?' checked':''?>>
            ����ʾ<font color="#666666">���磺������ǩ����ͼ��ǩ��</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��ʾ����</td>
          <td><input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>"> 
            <font color="#666666">(ֵԽСԽǰ��)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��Ŀ����Ȩ��</td>
          <td>
            <?=$cgroup?>          </td>
        </tr>
        <tr bgcolor="#FFFFFF" id="smallcgtoinfo"> 
          <td height="25" valign="top">&nbsp;</td>
          <td><input name="cgtoinfo" type="checkbox" id="cgtoinfo" value="1"<?=$r[cgtoinfo]?' checked':''?>>
            ����Ȩ��Ӧ������Ϣ<font color="#666666">(ѡ�����Ϣ�Ĳ鿴Ȩ�޿��Բ�����)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">����ǰ̨Ͷ��</td>
          <td><input type="radio" name="openadd" value="0"<?=$openadd0?>>
            ���� 
            <input type="radio" name="openadd" value="1"<?=$openadd1?>>
            �ر� 
            <input name="oldopenadd" type="hidden" id="oldopenadd" value="<?=$r[openadd]?>">          </td>
        </tr>
        <tbody id="smallclass">
          <tr> 
            <td>ǰ̨Ͷ������</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>��֤��</td>
            <td height="25"> ������֤��: 
              <input name="qaddshowkey" type="checkbox" id="qaddshowkey2" value="1"<?=$r['qaddshowkey']==1?' checked':''?>>            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>Ͷ��Ȩ��<font color="#666666">(��ѡΪ����)</font></td>
            <td height="25"> 
              <?=$qgroup?>            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>Ͷ�������б�</td>
            <td height="25"><p> 
                <select name="qaddlist" id="qaddlist">
                  <option value="0"<?=$r['qaddlist']==0?' selected':''?>>������</option>
                  <option value="1"<?=$r['qaddlist']==1?' selected':''?>>���ɵ�ǰ��Ŀ</option>
                  <option value="2"<?=$r['qaddlist']==2?' selected':''?>>������ҳ</option>
                  <option value="3"<?=$r['qaddlist']==3?' selected':''?>>���ɸ���Ŀ</option>
                  <option value="4"<?=$r['qaddlist']==4?' selected':''?>>���ɵ�ǰ��Ŀ�븸��Ŀ</option>
                  <option value="5"<?=$r['qaddlist']==5?' selected':''?>>���ɸ���Ŀ����ҳ</option>
                  <option value="6"<?=$r['qaddlist']==6?' selected':''?>>���ɵ�ǰ��Ŀ������Ŀ����ҳ</option>
                </select>
              </p></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>Ͷ�����</td>
            <td height="25"> <input type="radio" name="checkqadd" value="0"<?=$r['checkqadd']==0?' checked':''?>>
              ��Ҫ��� 
              <input type="radio" name="checkqadd" value="1"<?=$r['checkqadd']==1?' checked':''?>>
              �������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>������Ϣ����</td>
            <td height="25"> <input name="addinfofen" type="text" id="addinfofen2" value="<?=$r[addinfofen]?>" size="6">
              ���� <font color="#666666">(����������Ϊ0,�۵�����Ϊ������ʹ�ô����轫Ͷ��Ȩ������Ϊ��Ա����)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>��Ա��󷢲���Ϣ��</td>
            <td height="25"><input name="oneinfo" type="text" id="oneinfo" value="<?=$r[oneinfo]?>" size="6">
              ��
              <font color="#666666">(������Ա����ܷ�����������Ϣ��ʹ�ô����轫Ͷ��Ȩ������Ϊ��Ա����)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>����Ͷ��</td>
            <td height="25"><strong> 
              <select name="adminqinfo" id="adminqinfo">
                <option value="0"<?=$r['adminqinfo']==0?' selected':''?>>���ܹ�����Ϣ</option>
                <option value="1"<?=$r['adminqinfo']==1?' selected':''?>>�ɹ���δ�����Ϣ</option>
                <option value="2"<?=$r['adminqinfo']==2?' selected':''?>>ֻ�ɱ༭δ�����Ϣ</option>
                <option value="3"<?=$r['adminqinfo']==3?' selected':''?>>ֻ��ɾ��δ�����Ϣ</option>
                <option value="4"<?=$r['adminqinfo']==4?' selected':''?>>�ɹ���������Ϣ</option>
                <option value="5"<?=$r['adminqinfo']==5?' selected':''?>>ֻ�ɱ༭������Ϣ</option>
                <option value="6"<?=$r['adminqinfo']==6?' selected':''?>>ֻ��ɾ��������Ϣ</option>
              </select>
              <input name="qeditchecked" type="checkbox" id="qeditchecked" value="1"<?=$r['qeditchecked']==1?' checked':''?>>
              </strong>�༭��Ϣ��Ҫ���</td>
          </tr>
          <tr> 
            <td valign="top">��̨��Ϣ��������</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>����/�༭��Ϣ</td>
            <td height="25"> <input name="addreinfo" type="checkbox" id="addreinfo" value="1"<?=$r['addreinfo']==1?' checked':''?>>
              ��������ҳ�������б� 
              <select name="haddlist" id="haddlist">
                <option value="0"<?=$r['haddlist']==0?' selected':''?>>������</option>
                <option value="1"<?=$r['haddlist']==1?' selected':''?>>���ɵ�ǰ��Ŀ</option>
                <option value="2"<?=$r['haddlist']==2?' selected':''?>>������ҳ</option>
                <option value="3"<?=$r['haddlist']==3?' selected':''?>>���ɸ���Ŀ</option>
                <option value="4"<?=$r['haddlist']==4?' selected':''?>>���ɵ�ǰ��Ŀ�븸��Ŀ</option>
                <option value="5"<?=$r['haddlist']==5?' selected':''?>>���ɸ���Ŀ����ҳ</option>
                <option value="6"<?=$r['haddlist']==6?' selected':''?>>���ɵ�ǰ��Ŀ������Ŀ����ҳ</option>
              </select></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;</td>
            <td height="25"><input name="repreinfo" type="checkbox" id="repreinfo2" value="1"<?=$r[repreinfo]==1?' checked':''?>>
              ������һƪ��Ϣ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;</td>
            <td height="25"><input name="sametitle" type="checkbox" id="sametitle" value="1"<?=$r['sametitle']==1?' checked':''?>>
              �������ظ�</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>�������</td>
            <td height="25"><input name="checked" type="checkbox" id="checked" value="1"<?=$checked?>>
              ֱ�����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>ʹ�ù�����</td>
            <td height="25"><select name="wfid" id="wfid">
                <option value="0">��ʹ�ù�����</option>
                <?=$workflows?>
              </select></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">��ϢԤ��ͶƱ</td>
            <td><select name="definfovoteid" id="definfovoteid">
                <option value="0">������</option>
                <?=$definfovote?>
              </select> <input type="button" name="Submit622" value="����Ԥ��ͶƱ" onclick="window.open('other/ListVoteMod.php<?=$ecms_hashur['whehref']?>');"> 
              <font color="#666666">(������ϢʱĬ�ϵ�ͶƱ��)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">Ĭ�ϲ鿴��ϢȨ��</td>
            <td><select name="groupid" id="groupid">
                <option value="0">�ο�</option>
                <?=$group?>
              </select> <font color="#666666">(������ϢʱĬ�ϵĻ�Ա��Ȩ��)</font></td>
          </tr>
          <tr> 
            <td valign="top">��������</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" valign="top">���۹���</td>
            <td height="25"><input type="radio" name="openpl" value="0"<?=$openpl0?>>
              ���� 
              <input type="radio" name="openpl" value="1"<?=$openpl1?>>
              �رգ�������Ҫ���: 
              <input name="checkpl" type="checkbox" id="checkpl2" value="1"<?=$checkpl?>>
              ��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">��Ϣ�鵵</td>
            <td>�鵵���� 
              <input name="doctime" type="text" id="doctime" value="<?=$r[doctime]?>" size="6">
              �����Ϣ<font color="#666666">(0Ϊ���鵵)</font></td>
          </tr>
          <tr> 
            <td>����ģ������</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" height="25">����/Ӱ��ģ��</td>
            <td height="25">ÿ����ʾ 
              <input name="down_num" type="text" id="link_num3" value="<?=$r[down_num]?>" size="5">
              �����ص�ַ�� 
              <input name="online_num" type="text" id="down_num" value="<?=$r[online_num]?>" size="5">
              �����߹ۿ���ַ</td>
          </tr>
        </tbody>
      </table>
  </div>
  <div class="tab-page" id="settemplate"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">ģ��ѡ��</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "settemplate" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="30" colspan="2">ģ������</td>
        </tr>
		<tbody id="smallclassbdinfo">
		  <tr bgcolor="#FFFFFF">
            <td height="25">��Ŀ����Ϣ</td>
            <td height="25">����ϢID��
              <input name="smallbdinfoid" type="text" id="smallbdinfoid" value="<?=$r[bdinfoid]?>">
              <a href="#empirecms" onclick="EditSmallBdInfo(document.form1);">[�޸���Ϣ]</a> <font color="#666666">(��ʽ����ĿID,��ϢID)</font></td>
          </tr>
		</tbody>
        <tbody id="bigclasssettemp">
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" height="25">ҳ����ʾģʽ</td>
            <td height="25"> <input type="radio" name="islist" value="0"<?=$r[islist]==0?' checked':''?>>
              ����ʽ 
              <input type="radio" name="islist" value="1"<?=$r[islist]==1?' checked':''?>>
              �б�ʽ 
              <input type="radio" name="islist" value="2"<?=$r[islist]==2?' checked':''?>>
              ҳ������ʽ 
              <input type="radio" name="islist" value="3"<?=$r[islist]==3?' checked':''?> onclick="bdinfo.style.display='';">
              ��Ŀ����Ϣ 
              <input name="oldislist" type="hidden" id="oldislist" value="<?=$r[islist]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">&nbsp;</td>
            <td height="25"><font color="#666666">˵��������ʽҪѡ�����ģ�塢�б�ʽҪѡ���б�ģ�塢����ʽҪ¼��ҳ������</font></td>
          </tr>
		  <?php
		  $bdinfostyle=$r[islist]==3?'':' style="display:none"';
		  ?>
          <tr id="bdinfo" bgcolor="#FFFFFF"<?=$bdinfostyle?>>
            <td height="25">&nbsp;</td>
            <td height="25">����ϢID�� 
              <input name="bdinfoid" type="text" id="bdinfoid" value="<?=$r[bdinfoid]?>">
              <a href="#empirecms" onclick="EditBdInfo(document.form1);">[�޸���Ϣ]</a> 
              <font color="#666666">(��ʽ����ĿID,��ϢID)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">����ģ��</td>
            <td height="25"><select name="classtempid">
                <?=$classtemp?>
              </select> <input type="button" name="Submit6223" value="�������ģ��" onclick="window.open('template/ListClasstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </tbody>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">�����б�ģ��</td>
          <td> ��̬�� 
            <select name="listtempid" id="listtempid">
              <?=$listtemp_options?>
            </select>
            ����̬�� 
            <select name="dtlisttempid">
              <?=$dtlisttemp_options?>
            </select> <input type="button" name="Submit6222" value="�����б�ģ��" onclick="window.open('template/ListListtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
            *</td>
        </tr>
        <tbody id="smallclasssettemp">
          <tr bgcolor="#FFFFFF"> 
            <td height="25">��������ģ��</td>
            <td><select name="newstempid" id="newstempid">
                <?=$newstemp_options?>
              </select> <input type="button" name="Submit62222" value="��������ģ��" onclick="window.open('template/ListNewstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
              *( 
              <input name="tobetempinfo" type="checkbox" id="tobetempinfo" value="1">
              Ӧ���������ɵ���Ϣ )</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">��������ģ��</td>
            <td><select name="pltempid" id="pltempid">
                <option value="0">ʹ��Ĭ��ģ�� </option>
                <?=$pltemp?>
              </select> <input type="button" name="Submit62" value="��������ģ��" onclick="window.open('template/ListPltemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </tbody>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">����ģ��</td>
          <td><select name="searchtempid" id="searchtempid">
              <option value="0">ʹ��Ĭ��ģ�� </option>
              <?=$searchtemp?>
            </select> <input type="button" name="Submit62" value="��������ģ��" onclick="window.open('template/ListSearchtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">WAPģ��</td>
          <td><select name="wapstyleid" id="wapstyleid">
              <option value="0">ʹ��Ĭ��ģ��</option>
              <?=$wapstyles?>
            </select> <input type="button" name="Submit623" value="����WAPģ��" onclick="window.open('other/WapStyle.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
            ( 
            <input name="wapstylesclass" type="checkbox" id="wapstylesclass" value="1">
            Ӧ��������Ŀ) </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">WAPҳ��ģʽ</td>
          <td><select name="wapislist" id="wapislist">
            <option value="0"<?=$r['wapislist']==0?' selected':''?>>�б�ʽ</option>
            <option value="1"<?=$r['wapislist']==1?' selected':''?>>����ʽ</option>
            <option value="2"<?=$r['wapislist']==2?' selected':''?>>ҳ��ʽ</option>
          </select>
            <font color="#666666">(����ʽ��ģ��Ŀ¼Ҫ����cpage.temp.php��ģ���ļ���ҳ��ʽ��ģ��Ŀ¼Ҫ����c+��ĿID.php��ģ���ļ�������c2.php)</font></td>
        </tr>
        <tbody id="bigclasssetclasstext">
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ҳ������<font color="#666666">(֧�ֱ�ǩͬ����ģ��)</font></td>
            <td>�뽫����<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.classtext.value);document.form1.classtext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('template/editor.php?getvar=opener.document.form1.classtext.value&returnvar=opener.document.form1.classtext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','editclasstext','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="100%" colspan="2"><textarea name="classtext" cols="80" rows="23" id="classtext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($addr[classtext]))?></textarea>                  </td>
                </tr>
              </table></td>
          </tr>
        </tbody>
      </table>
  </div>
  <div class="tab-page" id="sethtml"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">����ѡ��</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "sethtml" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="30" colspan="2">��������</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">��Ŀҳģʽ</td>
          <td><input type="radio" name="listdt" value="0"<?=$r[listdt]==0?' checked':''?>>
            ��̬ҳ�� 
            <input type="radio" name="listdt" value="1"<?=$r[listdt]==1?' checked':''?>>
            ��̬ҳ�� 
            <input name="oldlistdt" type="hidden" id="oldlistdt" value="<?=$r[listdt]?>"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">����ҳģʽ</td>
          <td><input type="radio" name="showdt" value="0"<?=$r[showdt]==0?' checked':''?>>
            ��̬ҳ�� 
            <input type="radio" name="showdt" value="1"<?=$r[showdt]==1?' checked':''?>>
            ��̬����<font color="#666666"> 
            <input type="radio" name="showdt" value="2"<?=$r[showdt]==2?' checked':''?>>
            </font>��̬ҳ��</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">������Ϣ����ʽ</td>
          <td> <input name="listorder" type="text" id="listorder" value="<?=$r[listorder]?>" size="38"> 
            <select name="lorderselect" onchange="document.form1.listorder.value=this.value">
              <option value="id DESC"></option>
              <option value="newstime DESC">������ʱ�併������</option>
              <option value="id DESC">��ID��������</option>
              <option value="onclick DESC">������ʽ�������</option>
              <option value="totaldown DESC">����������������</option>
              <option value="plnum DESC">����������������</option>
            </select> </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">�б�ʽҳ������ʽ</td>
          <td> <input name="reorder" type="text" id="reorder" value="<?=$r[reorder]?>" size="38"> 
            <select name="orderselect" onchange="document.form1.reorder.value=this.value">
              <option value="newstime DESC"></option>
              <option value="newstime DESC">������ʱ�併������</option>
              <option value="id DESC">��ID��������</option>
              <option value="onclick DESC">������ʽ�������</option>
              <option value="totaldown DESC">����������������</option>
              <option value="plnum DESC">����������������</option>
            </select> </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">�б�ʽ��ʾ����SQL����</td>
          <td><input name="addsql" type="text" id="addsql" value="<?=ehtmlspecialchars($r['addsql'])?>" size="38">
            <font color="#666666">(���255���ַ�)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">�Ƿ�����</td>
          <td><input name="nreclass" type="checkbox" value="1"<?=$r[nreclass]==1?' checked':''?>>
            ��������Ŀҳ�� 
            <input name="nreinfo" type="checkbox" value="1"<?=$r[nreinfo]==1?' checked':''?>>
            ����������ҳ�� 
            <input name="nrejs" type="checkbox" value="1"<?=$r[nrejs]==1?' checked':''?>>
            ������JS���ã� 
            <input name="nottobq" type="checkbox" value="1"<?=$r[nottobq]==1?' checked':''?>>
            ��ǩ������</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��Ŀ�ļ���չ��</td>
          <td><input name="classtype" type="text" id="classtype" value="<?=$r[classtype]?>" size="38"> 
            <select name="select" onchange="document.form1.classtype.value=this.value">
              <option value=".html">��չ��</option>
              <option value=".html">.html</option>
              <option value=".htm">.htm</option>
              <option value=".php">.php</option>
              <option value=".shtml">.shtml</option>
            </select> <input name="oldclasstype" type="hidden" id="oldclasstype" value="<?=$r[classtype]?>"> 
            <font color="#666666">(��.html,.xml,.htm��)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��ʾ�ܼ�¼��</td>
          <td> <input name="maxnum" type="text" id="maxnum" value="<?=$r[maxnum]?>" size="38">
            ��<font color="#666666">(0Ϊ��ʾ���м�¼)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">���ɾ�̬ҳ��</td>
          <td><input name="repagenum" type="text" id="repagenum" value="<?=$r[repagenum]?>" size="38">
            ҳ<font color="#666666">(������ҳ���ö�̬���ӣ�0Ϊ����)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">������Ϣÿҳ��ʾ</td>
          <td><input name="lencord" type="text" id="lencord" value="<?=$r[lencord]?>" size="38">
            ����¼ 
            <input name="oldlencord" type="hidden" id="oldlencord3" value="<?=$r[lencord]?>"></td>
        </tr>
        <tbody id="smallclasssetinfo">
          <tr bgcolor="#FFFFFF"> 
            <td height="25">���������ʾ</td>
            <td><input name="link_num" type="text" id="link_num" value="<?=$r[link_num]?>" size="38">
              ����¼<font color="#666666">(0Ϊ�������������)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="26">����ҳ���Ŀ¼</td>
            <td><input type="radio" name="infopath" value="0"<?=$r[ipath]==''?' checked':''?>>
              ��ĿĿ¼ 
              <input type="radio" name="infopath" value="1"<?=$r[ipath]<>''?' checked':''?>>
              �Զ��壺 / 
              <input name="ipath" type="text" id="ipath" value="<?=$r[ipath]?>"> 
              <font color="#666666">(�Ӹ�Ŀ¼��ʼ)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="26">����ҳĿ¼�����ʽ</td>
            <td><input name="newspath" type="text" id="newspath" value="<?=$r[newspath]?>" size="38"> 
              <select name="select2" onchange="document.form1.newspath.value=this.value">
                <option value="Y-m-d">ѡ��</option>
                <option value="Y-m-d">2005-01-27</option>
                <option value="Y/m-d">2005/01-27</option>
                <option value="Y/m/d">2005/01/27</option>
                <option value="Ymd">20050127</option>
                <option value="">������Ŀ¼</option>
              </select> <font color="#666666">(��Y-m-d��Y/m-d����ʽ)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">����ҳ�ļ�������ʽ</td>
            <td>[ǰ׺] 
              <input name="filename_qz" type="text" id="filename_qz" value="<?=$r[filename_qz]?>" size="15">
              ����: 
              <input type="radio" name="filename" value="0"<?=$r[filename]==0?' checked':''?>>
              <a title="��ϢID��1.html">��ϢID</a> 
              <input type="radio" name="filename" value="1"<?=$r[filename]==1?' checked':''?>>
              <a title="unixʱ���+��ϢID��12102462981.html">time()</a> 
              <input type="radio" name="filename" value="4"<?=$r[filename]==4?' checked':''?>>
              <a title="����+��ϢID��201210011.html">date()</a>
              <input type="radio" name="filename" value="5"<?=$r[filename]==5?' checked':''?>>
              <a title="������Ϣ��ͬһ��Ŀ¼�����ظ���1000010000000001.html">������ϢID</a> 
              <input type="radio" name="filename" value="2"<?=$r[filename]==2?' checked':''?>>
              <a title="MD5���ܵ�ַ��c4ca4238a0b923820dcc509a6f75849b.html">md5()</a> 
              <input type="radio" name="filename" value="3"<?=$r[filename]==3?' checked':''?>>
              <a title="��ϢIDĿ¼��/1/">Ŀ¼</a></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">����ҳ�ļ���չ��</td>
            <td><input name="filetype" type="text" id="filetype" value="<?=$r[filetype]?>" size="38"> 
              <select name="select3" onchange="document.form1.filetype.value=this.value">
                <option value=".html">��չ��</option>
                <option value=".html">.html</option>
                <option value=".htm">.htm</option>
                <option value=".php">.php</option>
                <option value=".shtml">.shtml</option>
              </select> <font color="#666666">(��.html,.xml,.htm��)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">���ݹؼ����滻</td>
            <td><select name="keycid" id="keycid">
                <option value="0"<?=$r['keycid']==0?' selected':''?>>�滻����</option>
                <option value="-1"<?=$r['keycid']==-1?' selected':''?>>���滻</option>
				<?php
				$keycsql=$empire->query("select classid,classname from {$dbtbpre}enewskeyclass");
				while($keycr=$empire->fetch($keycsql))
				{
				?>
					<option value="<?=$keycr['classid']?>"<?=$r['keycid']==$keycr['classid']?' selected':''?>><?=$keycr['classname']?></option>
				<?php
				}
				?>
              </select>
              <input type="button" name="Submit6232" value="�������ݹؼ���" onclick="window.open('NewsSys/key.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </tbody>
      </table>
  </div>
  
  <div class="tab-page" id="setsinglepage"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">��ҳ����</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "setsinglepage" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
      <td height="30">��ҳ��������</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">����Ŀ�ǵ�ҳ������ʱ���ã����磺��˾��顢��ϵ��ʽ�ȵ�ҳ����ģ���е��ñ������ã�<strong>&lt;?=ReturnClassAddField(0,'eclasspagetext')?&gt;</strong></td>
      </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25"><?=ECMS_ShowEditorVar("eclasspagetext",$ecmsfirstpost==1?"":$addr['eclasspagetext'],"Default","","500","100%")?></td>
      </tr>
  </table>
  </div>
  
  <div class="tab-page" id="setjs"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">JS��������</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "setjs" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
      <td height="30" colspan="2">JS�����������</td>
    </tr>
    <tr bgcolor="#FFFFFF">
          <td height="25">����JSģ��</td>
      <td><select name="jstempid" id="jstempid">
	  <?=$jstemp?>
        </select>
            <input type="button" name="Submit62223" value="����JSģ��" onclick="window.open('template/ListJstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">������ϢJS��ʾ</td>
          <td> 
            <input name="newline" type="text" id="newline" value="<?=$r[newline]?>" size="38">
            ����¼</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">������ϢJS��ʾ</td>
      <td>
<input name="hotline" type="text" id="hotline" value="<?=$r[hotline]?>" size="38">
            ����¼</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">�Ƽ���ϢJS��ʾ</td>
      <td>
<input name="goodline" type="text" id="goodline" value="<?=$r[goodline]?>" size="38">
            ����¼</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">����������ϢJS��ʾ</td>
      <td>
<input name="hotplline" type="text" id="hotplline" value="<?=$r[hotplline]?>" size="38">
            ����¼</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">ͷ����ϢJS��ʾ</td>
      <td>
<input name="firstline" type="text" id="firstline" value="<?=$r[firstline]?>" size="38">
            ����¼</td>
    </tr>
  </table>
  </div>
  <?php
  $classfnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsclassf");
  if($classfnum)
  {
  ?>
  <div class="tab-page" id="setaddfield"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">�Զ����ֶ�����</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "setaddfield" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td width="23%" height="30">�Զ����ֶ�����</td>
          <td height="30">&nbsp;</td>
        </tr>
        <?php
		@include('../data/html/classaddform.php');
		?>
        <tr bgcolor="#FFFFFF"> 
          <td height="30" colspan="2"><strong>��Ŀ�Զ����ֶε���˵��</strong><br>
            ���õ�����Ŀ�Զ����ֶκ�����ReturnClassAddField(��ĿID,�ֶ���)����ĿID=0Ϊ��ǰ��ĿID��ȡ����ֶ����ݿ��ö��Ÿ��������ӣ�<br>
            ȡ��'classtext'�ֶ����ݣ�$value=ReturnClassAddField(0,'classtext'); //$value�����ֶ����ݡ�<br>
            ȡ�ö���ֶ����ݣ�$value=ReturnClassAddField(1,'classid,classtext'); //$value['classtext']�����ֶ����ݡ�</td>
        </tr>
      </table>
  </div>
  <?php
  }
  ?>
</div>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td width="100%" height="30"><div align="center"><strong> 
          <input type="submit" name="Submit" value="�ύ">
          &nbsp;&nbsp;<input type="reset" name="Submit2" value="����">
          <input type=hidden name=from value="<?=ehtmlspecialchars($_GET['from'])?>"></strong></div></td>
    </tr>
  </table>
  </form>
</body>
</html>
<?php
db_close();
$empire=null;
?>
<?=$hiddenclass?>
