<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
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
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
//����
if($_GET['sear'])
{
	$search.="&sear=1";
	//�ؼ���
	$keyboard=RepPostVar2($_GET['keyboard']);
	if($keyboard)
	{
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$add=" and (classname like '%$keyboard%')";
		}
		elseif($show==2)
		{
			$add=" and (intro like '%$keyboard%')";
		}
		elseif($show==3)
		{
			$add=" and (bname like '%$keyboard%')";
		}
		elseif($show==4)
		{
			$add=" and (classid='$keyboard')";
		}
		elseif($show==6)
		{
			$add=" and (bclassid='$keyboard')";
		}
		elseif($show==5)
		{
			$add=" and (classpath like '%$keyboard%')";
		}
		else
		{
			$add=" and (classname like '%$keyboard%' or intro like '%$keyboard%' or bname like '%$keyboard%' or classpath like '%$keyboard%' or classid='$keyboard')";
		}
		$search.="&keyboard=$keyboard&show=$show";
	}
	//����
	$scond=(int)$_GET['scond'];
	if($scond)
	{
		if($scond==1)
		{
			$add.=" and islast=1";
		}
		elseif($scond==2)
		{
			$add.=" and islast=0";
		}
		elseif($scond==3)
		{
			$add.=" and islist=1 and islast=0";
		}
		elseif($scond==4)
		{
			$add.=" and islist=0 and islast=0";
		}
		elseif($scond==11)
		{
			$add.=" and islist=2 and islast=0";
		}
		elseif($scond==12)
		{
			$add.=" and islist=3 and islast=0";
		}
		elseif($scond==5)
		{
			$add.=" and islast=1 and openadd=1";
		}
		elseif($scond==6)
		{
			$add.=" and islast=1 and openpl=1";
		}
		elseif($scond==7)
		{
			$add.=" and listdt=1";
		}
		elseif($scond==8)
		{
			$add.=" and showdt=1";
		}
		elseif($scond==9)
		{
			$add.=" and showclass=1";
		}
		elseif($scond==10)
		{
			$add.=" and showdt=2";
		}
		$search.="&scond=$scond";
	}
	//ģ��
	$modid=(int)$_GET['modid'];
	if($modid)
	{
		$add.=" and modid=$modid";
		$search.="&modid=$modid";
	}
}
if($add)
{
	$add=" where".substr($add,4,strlen($add));
}
//ϵͳģ��
$modselect="";
$msql=$empire->query("select mid,mname from {$dbtbpre}enewsmod where usemod=0 order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	$select="";
	if($mr[mid]==$modid)
	{
		$select=" selected";
	}
	$modselect.="<option value='".$mr[mid]."'".$select.">".$mr[mname]."</option>";
}
$totalquery="select count(*) as total from {$dbtbpre}enewsclass".$add;
$query="select * from {$dbtbpre}enewsclass".$add;
$num=$empire->gettotal($totalquery);//ȡ��������
//����
$myorder=(int)$_GET['myorder'];
if($myorder==1)
{
	$doorder="myorder";
}
else
{
	$doorder="classid";
}
$orderby=(int)$_GET['orderby'];
if($orderby==1)
{
	$doorderby="";
	$ordername="����";
	$neworderby=0;
}
else
{
	$doorderby=" desc";
	$ordername="����";
	$neworderby=1;
}
$orderidlink="<a href='ListPageClass.php?myorder=0&orderby=$neworderby".$search."' title='����� ��ĿID ".$ordername."����'><u>ID</u></a>";
$ordertwolink="<a href='ListPageClass.php?myorder=1&orderby=$neworderby".$search."' title='����� ��Ŀ˳�� ".$ordername."����'><u>˳��</u></a>";
$search.="&myorder=$myorder&orderby=$orderby";
$query=$query." order by ".$doorder.$doorderby." limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>������Ŀ</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="18%">λ��: <a href="ListPageClass.php<?=$ecms_hashur['whehref']?>">������Ŀ</a></td>
    <td width="82%"> <div align="right" class="emenubutton">
        <input type="button" name="Submit6" value="������Ŀ" onclick="self.location.href='AddClass.php?enews=AddClass&from=1<?=$ecms_hashur['ehref']?>'">
        <input type="button" name="Submit" value="ˢ����ҳ" onclick="self.location.href='ecmschtml.php?enews=ReIndex<?=$ecms_hashur['href']?>'">
        <input type="button" name="Submit2" value="ˢ��������Ŀҳ" onclick="window.open('ecmschtml.php?enews=ReListHtml_all&from=ListPageClass.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>','','');">
        <input type="button" name="Submit3" value="ˢ��������Ϣҳ��" onclick="window.open('ReHtml/DoRehtml.php?enews=ReNewsHtml&start=0&from=ListPageClass.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>','','');">
        <input type="button" name="Submit4" value="ˢ������JS����" onclick="window.open('ecmschtml.php?enews=ReAllNewsJs&from=ListPageClass.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>','','');">
      </div></td>
  </tr>
</table>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <form name="searchclass" method="GET" action="ListPageClass.php">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="32"><div align="right">����: 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="0"<?=$show==0?' selected':''?>>�����ֶ�</option>
            <option value="1"<?=$show==1?' selected':''?>>��Ŀ��</option>
            <option value="2"<?=$show==2?' selected':''?>>��Ŀ���</option>
            <option value="3"<?=$show==3?' selected':''?>>��Ŀ����</option>
            <option value="4"<?=$show==4?' selected':''?>>��ĿID</option>
			<option value="6"<?=$show==6?' selected':''?>>����ĿID</option>
            <option value="5"<?=$show==5?' selected':''?>>��ĿĿ¼</option>
          </select>
          <select name="scond" id="scond">
            <option value="0"<?=$scond==0?' selected':''?>>��������</option>
            <option value="1"<?=$scond==1?' selected':''?>>�ռ���Ŀ</option>
            <option value="2"<?=$scond==2?' selected':''?>>����Ŀ</option>
            <option value="3"<?=$scond==3?' selected':''?>>�б�ʽ����Ŀ</option>
            <option value="4"<?=$scond==4?' selected':''?>>����ʽ����Ŀ</option>
			<option value="12"<?=$scond==12?' selected':''?>>����Ϣʽ����Ŀ</option>
			<option value="11"<?=$scond==11?' selected':''?>>ҳ������ʽ����Ŀ</option>
            <option value="5"<?=$scond==5?' selected':''?>>δ����Ͷ�����Ŀ</option>
            <option value="6"<?=$scond==6?' selected':''?>>δ�������۵���Ŀ</option>
            <option value="7"<?=$scond==7?' selected':''?>>��̬�б����Ŀ</option>
            <option value="8"<?=$scond==8?' selected':''?>>��̬�������ݵ���Ŀ</option>
			<option value="10"<?=$scond==10?' selected':''?>>��̬����ҳ�����Ŀ</option>
            <option value="9"<?=$scond==9?' selected':''?>>����ʾ����������Ŀ</option>
          </select>
          <select name="modid" id="modid">
            <option value="0">����ģ��</option>
            <?=$modselect?>
          </select>
          <input type="submit" name="Submit8" value="��ʾ">
          <input name="sear" type="hidden" id="sear" value="1">
          <input name="myorder" type="hidden" id="myorder" value="<?=$myorder?>">
          <input name="orderby" type="hidden" id="orderby" value="<?=$orderby?>">
        </div></td>
    </tr>
	</form>
  </table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name=editorder method=post action=ecmsclass.php onsubmit="return confirm('ȷ��Ҫ����?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="5%"><div align="center"> 
          <?=$ordertwolink?>
        </div></td>
      <td width="5%"><div align="center"></div></td>
      <td width="5%" height="25"> <div align="center"> 
          <?=$orderidlink?>
        </div></td>
      <td width="36%" height="25">��Ŀ��</td>
      <td width="6%" height="25"> <div align="center">����</div></td>
      <td width="14%" height="25">��Ŀ����</td>
      <td width="29%" height="25">����</td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
		$docinfo="";
		$classinfotype='';
		$classurl=sys_ReturnBqClassUrl($r);
		if($r[islast]==1)
		{
			$img="<a href='AddNews.php?enews=AddNews&classid=".$r[classid].$ecms_hashur['ehref']."' target=_blank title='������Ϣ'><img src='../data/images/txt.gif' border=0></a>";
			$renewshtml=" <a href='ReHtml/DoRehtml.php?enews=ReNewsHtml&from=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid]."&tbname[]=".$r[tbname].$ecms_hashur['href']."'>".$fun_r['news']."</a> ";
			$docinfo=" <a href='ecmsinfo.php?enews=InfoToDoc&ecmsdoc=1&docfrom=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid].$ecms_hashur['href']."' onclick=\"return confirm('ȷ�Ϲ鵵?');\">�鵵</a>";
			$classinfotype=" <a href='#e' onclick=window.open('ClassInfoType.php?classid=".$r[classid].$ecms_hashur['ehref']."');>����</a>";
		}
		else
		{
			$img="<img src='../data/images/dir.gif'>";
			$renewshtml=" <a href='ReHtml/DoRehtml.php?enews=ReNewsHtml&from=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid]."&tbname[]=".$r[tbname].$ecms_hashur['href']."'>".$fun_r['news']."</a> ";
		}
		//�ⲿ��Ŀ
		$classname=$r[classname];
		if($r[wburl])
		{
			$classname="<font color='#666666'>".$classname."&nbsp;(�ⲿ)</font>";
		}
		//�ϼ���Ŀ
		$bclassname='';
		if($r[bclassid])
		{
			$bcr=$empire->fetch1("select classid,classname from {$dbtbpre}enewsclass where classid='$r[bclassid]'");
			$bclassname=$bcr[classname].'&nbsp;>&nbsp;';
		}
	?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center">
	  <input type=text name=myorder[] value="<?=$r[myorder]?>" size=2>
	  <input type=hidden name=classid[] value="<?=$r[classid]?>">
	  </div></td>
      <td><div align="center"><?=$img?></div></td>
      <td height="25"><div align="center"><?=$r[classid]?></div></td>
      <td height="25"><?="<input type=checkbox name=reclassid[] value='".$r[classid]."'>&nbsp;".$bclassname."<a href='".$classurl."' target=_blank><b>".$classname."</b></a>";?></td>
      <td height="25"><div align="center"><?=$r[onclick]?></div></td>
      <td height="25"><?="<a href='AddClass.php?classid=".$r[classid]."&enews=EditClass&from=1".$ecms_hashur['ehref']."'>�޸�</a> <a href='AddClass.php?classid=".$r[classid]."&enews=AddClass&docopy=1&from=1".$ecms_hashur['ehref']."'>����</a> <a href='ecmsclass.php?classid=".$r[classid]."&enews=DelClass&from=1".$ecms_hashur['href']."' onclick=\"return confirm('".$fun_r['CheckDelClass']."');\">ɾ��</a>"?></td>
      <td height="25"><?="<a href='enews.php?enews=ReListHtml&from=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid].$ecms_hashur['href']."'>ˢ��</a>".$renewshtml."<a href='ecmschtml.php?enews=ReSingleJs&doing=0&classid=".$r[classid].$ecms_hashur['href']."'>JS</a> <a href='#ecms' onclick=window.open('view/ClassUrl.php?classid=".$r[classid].$ecms_hashur['ehref']."','','width=500,height=250');>����</a>".$classinfotype.$docinfo;?>
	  </td>
    </tr>
    <?
	}
  	?>
    <tr bgcolor="#ffffff"> 
      <td height="25" colspan="7"> <div align="right">
          <input type="submit" name="Submit5" value="�޸���Ŀ˳��" onClick="document.editorder.enews.value='EditClassOrder';document.editorder.action='ecmsclass.php';">
          <input name="enews" type="hidden" id="enews" value="EditClassOrder">
          &nbsp;&nbsp; 
          <input type="submit" name="Submit7" value="ˢ����Ŀҳ��" onClick="document.editorder.enews.value='GoReListHtmlMoreA';document.editorder.action='ecmschtml.php';"">
          &nbsp;&nbsp; 
          <input type="submit" name="Submit72" value="�ռ���Ŀ����ת��" onClick="document.editorder.enews.value='ChangeClassIslast';document.editorder.action='ecmsclass.php';"">
        </div></td>
    </tr>
    <tr bgcolor="#ffffff"> 
      <td height="25" colspan="7">&nbsp;&nbsp; 
        <?=$returnpage?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="65" colspan="7"><strong>�ռ���Ŀ����ת��˵��(ֻ��ѡ�񵥸���Ŀ)��</strong><br>
        �����ѡ�����<font color="#FF0000">���ռ���Ŀ</font>����תΪ<font color="#FF0000">�ռ���Ŀ</font><font color="#666666">(����Ŀ����������Ŀ)</font><br>
        �����ѡ�����<font color="#FF0000">�ռ���Ŀ</font>����תΪ<font color="#FF0000">���ռ���Ŀ</font><font color="#666666">(���Ȱѵ�ǰ��Ŀ������ת�ƣ�����������������)<br>
        </font><strong>�޸���Ŀ˳��:˳��ֵԽСԽǰ��</strong></td>
    </tr>
    <input name="from" type="hidden" value="ListPageClass.php<?=$ecms_hashur['whehref']?>">
    <input name="gore" type="hidden" value="0">
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
