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
CheckLevel($logininid,$loginin,$classid,"m");
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$enews=RepPostStr($_GET['enews'],1);
$docopy=(int)$_GET['docopy'];
$mtype=" checked";
$r['mustqenterf']=",title,";
$r[myorder]=0;
$record="<!--record-->";
$field="<!--field--->";
$postword='����';
$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">ϵͳģ�͹���</a>&nbsp;>&nbsp;����ϵͳģ��";
if($enews=="AddM"&&$docopy)
{
	$postword='����';
	$mid=(int)$_GET['mid'];
	$mtype="";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmod where mid='$mid' and tid='$tid'");
	$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">ϵͳģ�͹���</a>&nbsp;>&nbsp;����ϵͳģ��: ".$r['mname'];
}
//�޸�ϵͳģ��
if($enews=="EditM")
{
	$postword='�޸�';
	$mid=(int)$_GET['mid'];
	$mtype="";
	$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">ϵͳģ�͹���</a>&nbsp;>&nbsp;�޸�ϵͳģ��";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmod where mid='$mid' and tid='$tid'");
}
//ȡ���ֶ�
$no=0;
$fsql=$empire->query("select f,fname,iscj,dotemp,tbdataf from {$dbtbpre}enewsf where isshow=1 and tid='$tid' order by myorder,fid");
while($fr=$empire->fetch($fsql))
{
	$no++;
	$bgcolor="ffffff";
	if($no%2==0)
	{
		$bgcolor="#F8F8F8";
	}
	$like=$field.$fr[f].$record;
	$slike=",".$fr[f].",";
	//¼����
	if(strstr($r[enter],$like))
	{
		$enterchecked=" checked";
		//ȡ���ֶα�ʶ
		$dor=explode($like,$r[enter]);
		if(strstr($dor[0],$record))
		{
			$dor1=explode($record,$dor[0]);
			$last=count($dor1)-1;
			$fr[fname]=$dor1[$last];
		}
		else
		{
			$fr[fname]=$dor[0];
		}
	}
	else
	{
		$enterchecked="";
	}
	//����
	if($enews=="AddM"&&($fr[f]=="title"||$fr[f]=="special.field"))
	{
		$enterchecked=" checked";
	}
	$entercheckbox="<input name=center[] type=checkbox class='docheckbox' value='".$fr[f]."'".$enterchecked.">";
	//Ͷ����
	if(strstr($r[qenter],$like))
	{
		$qenterchecked=" checked";
	}
	else
	{
		$qenterchecked="";
	}
	$qentercheckbox="<input name=cqenter[] type=checkbox class='docheckbox' value='".$fr[f]."'".$qenterchecked.">";
	$listtempfcheckbox="";
	$pagetempfcheckbox="";
	if($fr['dotemp'])
	{
		//�б�ģ����
		if(empty($fr['tbdataf']))//����
		{
			if(strstr($r[listtempvar],$like))
			{
				$listtempfchecked=" checked";
			}
			else
			{
				$listtempfchecked="";
			}
			$listtempfcheckbox="<input name=ltempf[] type=checkbox class='docheckbox' value='".$fr[f]."'".$listtempfchecked.">";
		}
		//����ģ����
		if(strstr($r[tempvar],$like))
		{
			$pagetempfchecked=" checked";
		}
		else
		{
			$pagetempfchecked="";
		}
		$pagetempfcheckbox="<input name=ptempf[] type=checkbox class='docheckbox' value='".$fr[f]."'".$pagetempfchecked.">";
	}
	//�ɼ���
	$cjcheckbox="";
	if($fr[iscj])
	{
		if(strstr($r[cj],$like))
		{$cjchecked=" checked";}
		else
		{$cjchecked="";}
		//����
		if($enews=="AddM"&&$fr[f]=="title")
		{
			$cjchecked=" checked";
		}
		$cjcheckbox="<input name=cchange[] type=checkbox class='docheckbox' value='".$fr[f]."'".$cjchecked.">";
	}
	//������
	$searchcheckbox="";
	if($fr[f]!="special.field"&&empty($fr['tbdataf'])&&empty($fr['tbdataf']))
	{
		if(strstr($r[searchvar],$slike))
		{$searchchecked=" checked";}
		else
		{$searchchecked="";}
		$searchcheckbox="<input name=schange[] type=checkbox class='docheckbox' value='".$fr[f]."'".$searchchecked.">";
	}
	//������
	$mustfcheckbox="";
	if($fr[f]!="special.field")
	{
		$mustfchecked="";
		if(strstr($r[mustqenterf],$slike))
		{$mustfchecked=" checked";}
		if($enews=="AddM"&&$fr[f]=="title")
		{
			$mustfchecked=" checked";
		}
		$mustfcheckbox="<input name=menter[] type=checkbox class='docheckbox' value='".$fr[f]."'".$mustfchecked.">";
	}
	//�����
	$listandfcheckbox="";
	if($fr[f]!="special.field"&&empty($fr['tbdataf']))
	{
		$listandfchecked="";
		if(strstr($r[listandf],$slike))
		{$listandfchecked=" checked";}
		$listandfcheckbox="<input name=listand[] type=checkbox class='docheckbox' value='".$fr[f]."'".$listandfchecked.">";
	}
	//������
	$orderfcheckbox="";
	if($fr[f]!="special.field"&&empty($fr['tbdataf']))
	{
		$orderfchecked="";
		if(strstr($r[orderf],$slike))
		{$orderfchecked=" checked";}
		$orderfcheckbox="<input name=listorder[] type=checkbox class='docheckbox' value='".$fr[f]."'".$orderfchecked.">";
	}
	//������
	$canaddfcheckbox="";
	if($fr[f]!="special.field")
	{
		$canaddfchecked="";
		if(strstr($r[canaddf],$slike))
		{$canaddfchecked=" checked";}
		if($enews=="AddM"&&!$docopy)
		{
			$canaddfchecked=" checked";
		}
		$canaddfcheckbox="<input name=canadd[] type=checkbox class='docheckbox' value='".$fr[f]."'".$canaddfchecked.">";
	}
	//���޸�
	$caneditfcheckbox="";
	if($fr[f]!="special.field")
	{
		$caneditfchecked="";
		if(strstr($r[caneditf],$slike))
		{$caneditfchecked=" checked";}
		if($enews=="AddM"&&!$docopy)
		{
			$caneditfchecked=" checked";
		}
		$caneditfcheckbox="<input name=canedit[] type=checkbox class='docheckbox' value='".$fr[f]."'".$caneditfchecked.">";
	}
	$data.="<tr bgcolor='".$bgcolor."'> 
            <td height=32> <div align=center> 
                <input name=cname[".$fr[f]."] type=text value='".$fr[fname]."'>
              </div></td>
            <td> <div align=center> 
                <input name=cfield type=text value='".$fr[f]."' readonly>
              </div></td>
			<td><div align=center> 
                ".$entercheckbox."
              </div></td>
			<td><div align=center> 
                ".$qentercheckbox."
              </div></td>
			<td><div align=center> 
                ".$mustfcheckbox."
              </div></td>
			<td><div align=center> 
                ".$canaddfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$caneditfcheckbox."
              </div></td>
            <td> <div align=center> 
                ".$cjcheckbox."
              </div></td>
            <td><div align=center> 
                ".$listtempfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$pagetempfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$searchcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$orderfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$listandfcheckbox."
              </div></td>
          </tr>";
}
//Ԥ��ͶƱ
$infovotesql=$empire->query("select voteid,ysvotename from {$dbtbpre}enewsvotemod order by voteid");
while($infovoter=$empire->fetch($infovotesql))
{
	$select="";
	if($r[definfovoteid]==$infovoter[voteid])
	{
		$select=" selected";
	}
	$definfovote.="<option value='".$infovoter[voteid]."'".$select.">".$infovoter[ysvotename]."</option>";
}
//��ӡģ��
$printtemp_options='';
$ptsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsprinttemp")." order by tempid");
while($ptr=$empire->fetch($ptsql))
{
	$select="";
	if($ptr[tempid]==$r[printtempid])
	{
		$select=" selected";
	}
	$printtemp_options.="<option value=".$ptr[tempid].$select.">".$ptr[tempname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ϵͳģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function DoCheckAll(form,chf)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
	if(e.name==chf)
		{
		e.checked=true;
	    }
	}
  }
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmod.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr> 
      <td height="25" colspan="2" class="header">����ϵͳģ�� 
        <input name="add[mid]" type="hidden" id="add[mid]" value="<?=$mid?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="add[tbname]" type="hidden" id="add[tbname]" value="<?=$tbname?>"> 
        <input name="add[tid]" type="hidden" id="add[tid]" value="<?=$tid?>"> 
		<?=$ecms_hashur['form']?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25">ģ������</td>
      <td width="77%" height="25"><input name="add[mname]" type="text" id="add[mname]" value="<?=$r[mname]?>" size="43"> 
        <font color="#666666">(���磺&quot;����ϵͳģ��&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ģ�ͱ���</td>
      <td height="25"><input name="add[qmname]" type="text" id="add[qmname]" value="<?=$r[qmname]?>" size="43"> 
        <font color="#666666">(���磺&quot;����&quot;������ǰ̨��ʾ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�Ƿ�����</td>
      <td height="25"><input type="radio" name="add[usemod]" value="0"<?=$r[usemod]==0?' checked':''?>>
        ���� 
        <input type="radio" name="add[usemod]" value="1"<?=$r[usemod]==1?' checked':''?>>
        ��ʹ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ʾ��ǰ̨����</td>
      <td height="25"><input type="radio" name="add[showmod]" value="0"<?=$r[showmod]==0?' checked':''?>>
        ��ʾ 
        <input type="radio" name="add[showmod]" value="1"<?=$r[showmod]==1?' checked':''?>>
        ����ʾ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ʾ˳��</td>
      <td height="25"><input name="add[myorder]" type="text" id="add[myorder]" value="<?=$r[myorder]?>" size="43"> 
        <font color="#666666">(ֵԽС��ʾԽǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top">ѡ��ģ�͵��ֶ���</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top"> <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DBEAF5">
          <tr> 
            <td width="15%" height="25"> <div align="center">�ֶα�ʶ</div></td>
            <td width="17%" height="25"> <div align="center">�ֶ���</div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'center[]');">¼����</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'cqenter[]');">Ͷ����</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'menter[]');">������</a></div></td>
            <td width="6%"><div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'canadd[]');">������</a></div></td>
            <td width="6%"><div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'canedit[]');">���޸�</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'cchange[]');">�ɼ���</a></div></td>
            <td width="7%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'ltempf[]');">�б�ģ��</a></div></td>
            <td width="7%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'ptempf[]');">����ģ��</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'schange[]');">������</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'listorder[]');">������</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="ȫѡ" onclick="DoCheckAll(document.form1,'listand[]');">�����</a></div></td>
          </tr>
          <?=$data?>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top"><p>��Ŀ�б�ҳ��������ã� 
          <input type="radio" name="add[setandf]" value="0"<?=$r[setandf]==0?' checked':''?>>
          ��ȫƥ�� 
          <input type="radio" name="add[setandf]" value="1"<?=$r[setandf]==1?' checked':''?>>
          ģ��ƥ��</p></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">¼���ģ��<br>
        (<font color="#FF0000"> 
        <input name="add[mtype]" type="checkbox" id="add[mtype]" value="1"<?=$mtype?>>
        �Զ����ɱ�ģ��</font>)</td>
      <td height="25"><textarea name="add[mtemp]" cols="75" rows="20" id="add[mtemp]" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[mtemp]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">ǰ̨Ͷ���ģ��<br>
        (<font color="#FF0000"> 
        <input name="add[qmtype]" type="checkbox" id="add[qmtype]" value="1"<?=$mtype?>>
        �Զ����ɱ�ģ��</font>) </td>
      <td height="25"><textarea name="add[qmtemp]" cols="75" rows="20" id="textarea2" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[qmtemp]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="2" valign="top">��Ϣ�б�����</td>
      <td height="25"><input name="add[listfile]" type="text" id="add[listfile]" value="<?=$r[listfile]?>" size="43">      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><font color="#666666">(������Ϊʹ��Ĭ���б������б����e/data/html/list�������ļ���<a href="../../data/html/list/ReadMe.txt" target="_blank">�������</a>�鿴˵��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��̨������Ϣ������</td>
      <td height="25"><input name="add[maddfun]" type="text" id="add[maddfun]" value="<?=$r[maddfun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��̨�޸���Ϣ������</td>
      <td height="25"><input name="add[meditfun]" type="text" id="add[meditfun]" value="<?=$r[meditfun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">ǰ̨������Ϣ������</td>
      <td height="25"><input name="add[qmaddfun]" type="text" id="add[qmaddfun]" value="<?=$r[qmaddfun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">ǰ̨�޸���Ϣ������</td>
      <td height="25"><input name="add[qmeditfun]" type="text" id="add[qmeditfun]" value="<?=$r[qmeditfun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ϢԤ��ͶƱ</td>
      <td height="25"><select name="add[definfovoteid]" id="add[definfovoteid]">
          <option value="0">������</option>
          <?=$definfovote?>
        </select> <input type="button" name="Submit622" value="����Ԥ��ͶƱ" onclick="window.open('../other/ListVoteMod.php<?=$ecms_hashur['whehref']?>');"> 
        <font color="#666666">(������ϢʱĬ�ϵ�ͶƱ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ӡģ��</td>
      <td height="25"><select name="add[printtempid]" id="add[printtempid]">
	  		<option value="0">ʹ��Ĭ��</option>
          <?=$printtemp_options?>
        </select> 
        <input type="button" name="Submit6222" value="�����ӡģ��" onclick="window.open('../template/ListPrinttemp.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">ע��</td>
      <td height="25"><textarea name="add[mzs]" cols="75" rows="10" id="textarea" style="WIDTH: 100%"><?=stripSlashes($r[mzs])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
