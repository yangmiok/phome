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
CheckLevel($logininid,$loginin,$classid,"changedata");
//��Ŀ
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//ˢ�±�
$retable="";
$selecttable="";
$cleartable='';
$i=0;
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable where intb=0 order by tid");
while($tr=$empire->fetch($tsql))
{
	$i++;
	if($i%4==0)
	{
		$br="<br>";
	}
	else
	{
		$br="";
	}
	$retable.="<input type=checkbox name=tbname[] value='$tr[tbname]' checked>$tr[tname]&nbsp;&nbsp;".$br;
	$selecttable.="<option value='".$tr[tbname]."'>".$tr[tname]."</option>";
	$cleartable.="<option value='".$tr[tid]."'>".$tr[tname]."</option>";
}
//ר��
$ztclass="";
$ztsql=$empire->query("select ztid,ztname from {$dbtbpre}enewszt order by ztid desc");
while($ztr=$empire->fetch($ztsql))
{
	$ztclass.="<option value='".$ztr['ztid']."'>".$ztr['ztname']."</option>";
}
//����ʶ�
$moreportpid=(int)$_GET['moreportpid'];
$mphref='';
$mpform='';
$mpwhhref='';
$mpwhhrefck='';
$mpname='�����ʶ�';
if($moreportpid)
{
	$mphref=Moreport_ReturnUrlCsPid($moreportpid,0,0,'');
	$mpform=Moreport_ReturnUrlCsPid($moreportpid,1,0,'');
	$mpwhhref=Moreport_ReturnUrlCsPid($moreportpid,0,1,'');
	$mpwhhrefck=Moreport_ReturnUrlCsPid($moreportpid,0,1,$ecms_hashur['whehref']);
	//���ʶ�
	$mpr=$empire->fetch1("select * from {$dbtbpre}enewsmoreport where pid='$moreportpid'");
	$mpname=$mpr['pname'];
}
//ѡ������
$todaydate=date("Y-m-d");
$todaytime=time();
$changeday="<select name=selectday onchange=\"document.reform.startday.value=this.value;document.reform.endday.value='".$todaydate."'\">
<option value='".$todaydate."'>--ѡ��--</option>
<option value='".$todaydate."'>����</option>
<option value='".ToChangeTime($todaytime,7)."'>һ��</option>
<option value='".ToChangeTime($todaytime,30)."'>һ��</option>
<option value='".ToChangeTime($todaytime,90)."'>����</option>
<option value='".ToChangeTime($todaytime,180)."'>����</option>
<option value='".ToChangeTime($todaytime,365)."'>һ��</option>
</select>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
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
    <td width="14%" height="25">λ�ã�<a href="ChangeData.php<?=$ecms_hashur['whehref']?><?=$mpwhhrefck?>">���ݸ�������</a></td>
    <td width="45%"><table width="420" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> <div align="center">[<a href="#ReAllHtml">����ˢ��</a>]</div></td>
          <td> <div align="center">[<a href="#ReMoreListHtml">����Ŀˢ��</a>]</div></td>
          <td> <div align="center">[<a href="#ReIfInfoHtml">������ˢ������ҳ</a>]</div></td>
        </tr>
    </table></td>
    <td width="41%"><div align="right" class="emenubutton">
      <input type="button" name="Submit52" value="������Ϣҳ��ַ" onclick="self.location.href='ReInfoUrl.php<?=$ecms_hashur['whehref']?>';">
	  &nbsp;&nbsp;
	  <input type="button" name="Submit52" value="��������" onclick="self.location.href='DoUpdateData.php<?=$ecms_hashur['whehref']?>';">
	  &nbsp;&nbsp;
      <input type="button" name="Submit522" value="���¶�̬ҳ�滺��" onclick="self.location.href='ChangePageCache.php<?=$ecms_hashur['whehref']?>';">
    </div></td>
  </tr>
  <?php
  if($ecms_config['sets']['selfmoreportid']<=1&&$public_r['ckhavemoreport'])
  {
  ?>
  <tr>
    <td height="25" colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
	<form name="rechmpform" id="rechmpform" method="GET" action="ChangeData.php">
	<?=$ecms_hashur['eform']?>
      <tr>
        <td width="50%" bgcolor="#FFFFFF">��ѡ���ʶˣ�<b><?=$mpname?></b></td>
        <td width="50%" bgcolor="#FFFFFF">
		  <div align="right">ѡ��Ҫˢ��ҳ��ķ��ʶ�:
		    <?=Moreport_eReturnMoreportSelect($moreportpid,'moreportpid')?>
                <input type="submit" name="Submit" value="ȷ��">
		      </div></td>
      </tr>
	  </form>
    </table></td>
  </tr>
  <?php
  }
  ?>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="6">
  <tr id=ReAllHtml> 
    <td width="69%" valign="top"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25" colspan="2"> <div align="center">ҳ��ˢ�¹���</div></td>
        </tr>
        <tr> 
          <td height="25"><div align="center"><strong>��վ��Ҫҳ��ˢ��</strong></div></td>
          <td height="25"><div align="center"><strong>����ҳ��ˢ��</strong></div></td>
        </tr>
        <tr> 
          <td width="50%" height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <input type="button" name="Submit2" value="ˢ����ҳ" onclick="self.location.href='../ecmschtml.php?enews=ReIndex<?=$ecms_hashur['href']?><?=$mphref?>'" title="������ҳ">
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <input type="button" name="Submit22" value="ˢ��������Ϣ��Ŀҳ" onclick="window.open('../ecmschtml.php?enews=ReListHtml_all&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="����������Ŀҳ��">
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <form action="ecmschtml.php" method="post" name="dorehtml" id="dorehtml">
					  <?=$ecms_hashur['form']?>
					  <?=$mpform?>
                        <tr> 
                          <td><div align="center"> 
                              <input type="button" name="Submit3" value="ˢ��������Ϣ����ҳ��" onclick="var toredohtml=0;if(document.dorehtml.havehtml.checked==true){toredohtml=1;}window.open('DoRehtml.php?enews=ReNewsHtml&start=0&havehtml='+toredohtml+'&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="������������ҳ">
                            </div></td>
                        </tr>
                        <tr> 
                          <td height="25" valign="top"> <div align="center">ȫ��ˢ�� 
                              <input name="havehtml" type="checkbox" id="havehtml" value="1" title="���Ѿ����ɵ�����ҳһ�����">
                            </div></td>
                        </tr>
                      </form>
                    </table>
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <input type="button" name="Submit4" value="ˢ��������ϢJS����" onclick="window.open('../ecmschtml.php?enews=ReAllNewsJs&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="��������JS�����ļ�">
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"><div align="center"> 
                    <input type="button" name="Submit422232" value="�������¶�̬ҳ��" onclick="self.location.href='../ecmschtml.php?enews=ReDtPage<?=$ecms_hashur['href']?><?=$mphref?>';" title="���ɿ������ģ�塢��½״̬����½JS�ȶ�̬ҳ��">
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
                <td height="48"><div align="center">
                  <input type="button" name="Submit222" value="ˢ�����б������ҳ" onclick="window.open('../ecmschtml.php?enews=ReTtListHtml_all&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="�������б������ҳ��">
                </div></td>
              </tr>
            </table></td>
          <td width="50%" valign="top" bgcolor="#FFFFFF"> <table width="100%" border="0" cellpadding="3" cellspacing="1">
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
                <td height="48"><div align="center">
                  <input type="button" name="Submit2222" value="ˢ������ר��ҳ" onClick="window.open('../ecmschtml.php?enews=ReZtListHtml_all&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="��������ר��ҳ��">
                </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <input type="button" name="Submit422" value="����ˢ����Ƭ�ļ�" onclick="window.open('../ecmschtml.php?enews=ReSpAll&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="������Ƭ�ļ�">
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <input type="button" name="Submit422" value="����ˢ��ͶƱJS" onclick="window.open('../tool/ListVote.php?enews=ReVoteJs_all&from=../ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="����ͶƱ�����JS�ļ�">
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <input type="button" name="Submit4222" value="����ˢ�¹��JS" onclick="window.open('../tool/ListAd.php?enews=ReAdJs_all&from=../ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>','','');" title="���ɹ������JS�ļ�">
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"> <div align="center"> 
                    <table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <form action="../ecmsmod.php" method="GET" name="dochangemodform" id="dochangemodform">
					  <?=$ecms_hashur['form']?>
					  <?=$mpform?>
                        <input type=hidden name=enews value="ChangeAllModForm">
                        <tr> 
                          <td><div align="center"> 
                              <input type="submit" name="Submit3" value="��������ģ�ͱ�" title="���ɷ�����Ͷ���(һ������վ���ʱʹ��)">
                            </div></td>
                        </tr>
                        <tr> 
                          <td height="25"> <div align="center">������Ŀ���� 
                              <input name="ChangeClass" type="checkbox" id="ChangeClass" value="1" title="����Ͷ��ʱѡ�����Ŀ">
                            </div></td>
                        </tr>
                      </form>
                    </table>
                  </div></td>
              </tr>
              <tr onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
                <td height="48"><div align="center"> 
                    <input type="button" name="Submit4222322" value="�������·�����" onclick="self.location.href='../tool/FeedbackClass.php?enews=ReMoreFeedbackClassFile<?=$ecms_hashur['href']?><?=$mphref?>';" title="�����Զ��巴���ı�(һ������վ���ʱʹ��)">
                  </div></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td width="31%" valign="top"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr> 
          <td height="25" class="header"> <div align="center">���»�������</div></td>
        </tr>
        <tr> 
          <td height="28" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../enews.php?enews=ChangeEnewsData<?=$ecms_hashur['href']?><?=$mphref?>" title="����ϵͳ�Ļ���(һ������վ���ʱʹ��)">�������ݿ⻺��</a></div></td>
        </tr>
        <tr> 
          <td height="28" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../ecmschtml.php?enews=ReClassPath<?=$ecms_hashur['href']?><?=$mphref?>" title="���½�����ĿĿ¼(һ������վ���ʱʹ��)">�ָ���ĿĿ¼</a></div></td>
        </tr>
        <tr> 
          <td height="28" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../ecmsclass.php?enews=DelFcListClass<?=$ecms_hashur['href']?><?=$mphref?>" title="���¸��¡���Ϣ�����˵��µ���Ŀ�б�����Ŀ�����˵��µĹ�����Ŀҳ�档(һ������վ���ʱʹ��)">ɾ����Ŀ�����ļ�</a></div></td>
        </tr>
        <tr> 
          <td height="28" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../ecmsclass.php?enews=ChangeSonclass<?=$ecms_hashur['href']?><?=$mphref?>" title="һ��Ӧ�����޸���Ŀ��������Ŀ��ʹ�ô˹��ܡ�">������Ŀ��ϵ</a></div></td>
        </tr>
        <tr>
          <td height="28" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><div align="center"><a href="../ecmschtml.php?enews=UpdateClassInfosAll&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>" title="����ͳ����Ŀ����Ϣ������һ��Ӧ��������ɾ����Ϣ��ʹ�ô˹��ܡ�" target="_blank">������Ŀ��Ϣ��</a></div></td>
        </tr>
        <tr> 
          <td height="28" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../ecmscom.php?enews=ClearTmpFileData<?=$ecms_hashur['href']?><?=$mphref?>" onclick="return confirm('���ǰ��ȷ���û�û�����ڲɼ�������ˢ��ҳ����Զ�̷�����ȷ��?');" title="�����ʱ�ͻ����ļ�������ղ�������ʱ�ļ������о��Ǹ��¶�̬ҳ��ģ��ʱʹ�ã�����ʵʱ����ģ��">�����ʱ�ļ�������</a></div></td>
        </tr>
      </table>
      <br>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr> 
          <td height="25" class="header"> <div align="center">�Զ���ҳ��ˢ��</div></td>
        </tr>
        <tr> 
          <td height="30" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../ecmschtml.php?enews=ReUserpageAll&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>" target="_blank" title="���������Զ���ҳ��">ˢ�������Զ���ҳ��</a></div></td>
        </tr>
        <tr> 
          <td height="30" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../ecmschtml.php?enews=ReUserlistAll&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>" target="_blank" title="���������Զ����б�">ˢ�������Զ����б�</a></div></td>
        </tr>
        <tr> 
          <td height="30" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#C3EFFF'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
            <div align="center"><a href="../ecmschtml.php?enews=ReUserjsAll&from=ReHtml/ChangeData.php<?=urlencode($ecms_hashur['whehref'].$mpwhhrefck)?><?=$ecms_hashur['href']?><?=$mphref?>" target="_blank" title="���������Զ���JS">ˢ�������Զ���JS</a></div></td>
        </tr>
      </table> </td>
  </tr>
  <tr id=ReMoreListHtml> 
    <td width="69%" valign="top"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form2" method="post" action="../ecmschtml.php">
		<?=$ecms_hashur['form']?>
		<?=$mpform?>
          <tr class="header"> 
            <td height="25"> <div align="center"><strong>ˢ�¶���Ŀҳ�� </strong></div></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr> 
                    <td><div align="center"> 
                        <select name="classid[]" size="12" multiple id="classid[]" style="width:310">
                          <?=$class?>
                        </select>
                      </div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"> 
                        <input type="submit" name="Submit8" value="��ʼˢ��">
                        <strong> 
                        <input name="enews" type="hidden" id="enews3" value="GoReListHtmlMore">
                        <input name="gore" type="hidden" id="enews4" value="0">
                        <input name="from" type="hidden" id="gore" value="ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?><?=$mpwhhrefck?>">
                        </strong></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><font color="#666666">�����ctrl/shiftѡ��</font></div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </form>
      </table></td>
    <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form2" method="post" action="../ecmschtml.php">
		<?=$ecms_hashur['form']?>
		<?=$mpform?>
          <tr class="header"> 
            <td height="25"> <div align="center"><strong>ˢ�¶�ר��ҳ�� </strong></div></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr> 
                    <td><div align="center"> 
                        <select name="classid[]" size="12" multiple id="select2" style="width:250">
                          <?=$ztclass?>
                        </select>
                      </div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"> 
                        <input name="ecms" type="checkbox" id="ecms" value="1" checked>
                        ���ӷ���
                        <input type="submit" name="Submit82" value="��ʼˢ��">
                        <strong> 
                        <input name="enews" type="hidden" id="enews5" value="GoReListHtmlMore">
                        <input name="gore" type="hidden" id="gore" value="1">
                        <input name="from" type="hidden" id="from" value="ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?><?=$mpwhhrefck?>">
                        </strong></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><font color="#666666">�����ctrl/shiftѡ��</font></div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
<form action="DoRehtml.php" method="get" name="reform" target="_blank" onsubmit="return confirm('ȷ��Ҫˢ��?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=ReIfInfoHtml>
  <?=$ecms_hashur['form']?>
  <?=$mpform?>
    <input name="from" type="hidden" id="from" value="ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?><?=$mpwhhrefck?>">
    <tr class="header"> 
      <td height="25"> <div align="center">������ˢ����Ϣ����ҳ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr> 
              <td height="25">ˢ�����ݱ�
                <input name=chkall type=checkbox onClick=CheckAll(this.form) value=on checked>
                <font color="#666666">ȫѡ</font></td>
              <td height="25">
                <?=$retable?>
              </td>
            </tr>
            <tr> 
              <td height="25">ˢ����Ŀ</td>
              <td height="25"><select name="classid" id="classid">
                  <option value="0">������Ŀ</option>
                  <?=$class?>
                </select>
                <font color="#666666"> (��ѡ����Ŀ����ˢ����������Ŀ)</font></td>
            </tr>
            <tr> 
              <td width="23%" height="25"> <input name="retype" type="radio" value="0" checked>
                ��ʱ��ˢ�£�</td>
              <td width="77%" height="25">�� 
                <input name="startday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                �� 
                <input name="endday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                ֮������� 
                <?=$changeday?>
                <font color="#666666"> (���ˢ������ҳ��)</font></td>
            </tr>
            <tr> 
              <td height="25"> <input name="retype" type="radio" value="1">
                ��IDˢ�£�</td>
              <td height="25">�� 
                <input name="startid" type="text" id="startid" value="0" size="6">
                �� 
                <input name="endid" type="text" id="endid" value="0" size="6">
                ֮������� <font color="#666666">(����ֵΪ0��ˢ������ҳ��)</font></td>
            </tr>
            <tr>
              <td height="25">ȫ��ˢ�£�</td>
              <td height="25"><input name="havehtml" type="checkbox" id="havehtml" value="1">
                ��<font color="#666666"> (��ѡ�񽫲�ˢ�������ɹ�����Ϣ)</font></td>
            </tr>
            <tr> 
              <td height="25">&nbsp;</td>
              <td height="25"><input type="submit" name="Submit6" value="��ʼˢ��"> 
                <input type="reset" name="Submit7" value="����"> <input name="enews" type="hidden" id="enews" value="ReNewsHtml"> 
              </td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
</p>
</body>
</html>
<?
db_close();
$empire=null;
?>
