<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../member/class/user.php");
$link=db_connect();
$empire=new mysqlquery();
//��֤�û�
$lur=is_login();
$logininid=(int)$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=(int)$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//�ҵ�״̬
$user_r=$empire->fetch1("select pretime,preip,loginnum,preipport from {$dbtbpre}enewsuser where userid='$logininid'");
$gr=$empire->fetch1("select groupname from {$dbtbpre}enewsgroup where groupid='$loginlevel'");
//����Աͳ��
$adminnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsuser");
$date=date("Y-m-d");
$noplnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewspl_".$public_r['pldeftb']." where checked=1");
//δ��˻�Ա
$nomembernum=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('checked')."=0");
//���ڹ��
$outtimeadnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsad where endtime<'$date' and endtime<>'0000-00-00'");
//ǩ����Ϣ
$qfinfonum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewswfinfo where checktno=0 and (groupid like '%,".$lur['groupid'].",%' or userclass like '%,".$lur['classid'].",%' or username like '%,".$lur['username'].",%')");
//ϵͳ��Ϣ
	if(function_exists('ini_get')){
        $onoff = ini_get('register_globals');
    } else {
        $onoff = get_cfg_var('register_globals');
    }
    if($onoff){
        $onoff="��";
    }else{
        $onoff="�ر�";
    }
    if(function_exists('ini_get')){
        $upload = ini_get('file_uploads');
    } else {
        $upload = get_cfg_var('file_uploads');
    }
    if ($upload){
        $upload="����";
    }else{
        $upload="������";
    }
	if(function_exists('ini_get')){
        $uploadsize = ini_get('upload_max_filesize');
    } else {
        $uploadsize = get_cfg_var('upload_max_filesize');
    }
	if(function_exists('ini_get')){
        $uploadpostsize = ini_get('post_max_size');
    } else {
        $uploadpostsize = get_cfg_var('post_max_size');
    }
//����
$register_ok="����";
if($public_r[register_ok])
{$register_ok="�ر�";}
$addnews_ok="����";
if($public_r[addnews_ok])
{$addnews_ok="�ر�";}
//�汾
@include("../class/EmpireCMS_version.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�۹���վ����ϵͳ</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center"><strong> 
        <h3>��ӭʹ�õ۹���վ����ϵͳ (EmpireCMS)</h3>
        </strong></div></td>
  </tr>
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">�ҵ�״̬</td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF"> <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td height="22">��¼��:&nbsp;<b>
                  <?=$loginin?>
                  </b>&nbsp;&nbsp;,�����û���:&nbsp;<b>
                  <?=$gr[groupname]?>
                  </b></td>
              </tr>
              <tr>
                <td height="22">�������� <b>
                  <?=$user_r[loginnum]?>
                  </b> �ε�¼���ϴε�¼ʱ�䣺
                  <?=$user_r[pretime]?date('Y-m-d H:i:s',$user_r[pretime]):'---'?>
                  ����¼IP��
                  <?=$user_r[preip]?$user_r[preip].':'.$user_r[preipport]:'---'?>                </td>
              </tr>
            </table>          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td width="100%" height="25"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%"><strong><a href="#ecms">��ݲ˵�</a></strong></td>
                <td><div align="right"><a href="http://www.phome.net/edown25/" target="_blank"><strong>�۹�����ϵͳ</strong></a></div></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF"><strong>��Ϣ����</strong>��&nbsp;&nbsp;<a href="AddInfoChClass.php<?=$ecms_hashur['whehref']?>">������Ϣ</a>&nbsp;&nbsp; 
            <a href="ListAllInfo.php<?=$ecms_hashur['whehref']?>">������Ϣ</a>&nbsp;&nbsp; <a href="ListAllInfo.php?ecmscheck=1<?=$ecms_hashur['ehref']?>">�����Ϣ</a> 
            &nbsp;&nbsp; <a href="workflow/ListWfInfo.php<?=$ecms_hashur['whehref']?>">ǩ����Ϣ</a>(<strong><font color="#FF0000"><?=$qfinfonum?></font></strong>)&nbsp;&nbsp; <a href="openpage/AdminPage.php?leftfile=<?=urlencode('../pl/PlNav.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../pl/PlMain.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('��������')?><?=$ecms_hashur['ehref']?>">��������</a>&nbsp;&nbsp; <a href="sp/UpdateSp.php<?=$ecms_hashur['whehref']?>">������Ƭ</a>&nbsp;&nbsp; <a href="special/UpdateZt.php<?=$ecms_hashur['whehref']?>">����ר��</a>&nbsp;&nbsp; <a href="info/InfoMain.php<?=$ecms_hashur['whehref']?>">����ͳ��</a></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF"><strong>��Ŀ����</strong>��&nbsp;&nbsp;<a href="ListClass.php<?=$ecms_hashur['whehref']?>">������Ŀ</a>&nbsp;&nbsp; 
            <a href="special/ListZt.php<?=$ecms_hashur['whehref']?>">����ר��</a>&nbsp;&nbsp; <a href="ListInfoClass.php<?=$ecms_hashur['whehref']?>">����ɼ�</a> 
            &nbsp;&nbsp; <a href="openpage/AdminPage.php?leftfile=<?=urlencode('../file/FileNav.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('������')?><?=$ecms_hashur['ehref']?>">��������</a>&nbsp;&nbsp; 
            <a href="SetEnews.php<?=$ecms_hashur['whehref']?>">ϵͳ��������</a>&nbsp;&nbsp; <a href="ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>">���ݸ�������</a></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF"><strong>�û�����</strong>��&nbsp;&nbsp;<a href="member/ListMember.php?sear=1&schecked=1<?=$ecms_hashur['ehref']?>">��˻�Ա</a>&nbsp;&nbsp; 
            <a href="member/ListMember.php<?=$ecms_hashur['whehref']?>">�����Ա</a> &nbsp; <a href="user/ListLog.php<?=$ecms_hashur['whehref']?>">�����½��־</a> 
            &nbsp;&nbsp; <a href="user/ListDolog.php<?=$ecms_hashur['whehref']?>">���������־</a>&nbsp;&nbsp; <a href="user/EditPassword.php<?=$ecms_hashur['whehref']?>">�޸ĸ�������</a>&nbsp;&nbsp; 
            <a href="user/UserTotal.php<?=$ecms_hashur['whehref']?>">�û�����ͳ��</a></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF"><strong>��������</strong>��&nbsp;&nbsp;<a href="tool/gbook.php<?=$ecms_hashur['whehref']?>">��������</a>&nbsp;&nbsp; 
            <a href="tool/feedback.php<?=$ecms_hashur['whehref']?>">��������Ϣ</a>&nbsp;&nbsp;<a href="DownSys/ListError.php<?=$ecms_hashur['whehref']?>">������󱨸�</a>&nbsp;&nbsp; 
            <a href="#empirecms" onclick="window.open('openpage/AdminPage.php?leftfile=<?=urlencode('../ShopSys/pageleft.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../ShopSys/ListDd.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('�̳�ϵͳ����')?><?=$ecms_hashur['ehref']?>','AdminShopSys','');">������</a>&nbsp;&nbsp;<a href="pay/ListPayRecord.php<?=$ecms_hashur['whehref']?>">����֧����¼</a>&nbsp;&nbsp; 
            <a href="PathLevel.php<?=$ecms_hashur['whehref']?>">�鿴Ŀ¼Ȩ��״̬</a></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="102">
      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr> 
          <td bgcolor="#FFFFFF"><div align="center"><img src="loginimg/ecmsbanner.gif" border="0"></div></td>
        </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="50%"><a href="#"><strong>ϵͳ��Ϣ</strong></a></td>
                <td><div align="right"><a href="http://ebak.phome.net" target="_blank"><strong>�۹�MYSQL����������</strong></a></div></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td width="43%"><strong>��վ��Ϣ</strong></td>
          <td width="57%"><strong>��������Ϣ</strong></td>
        </tr>
        <tr> 
          <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr> 
                <td width="28%" height="23">��Աע��:</td>
                <td width="72%"> 
                  <?=$register_ok?>                </td>
              </tr>
              <tr> 
                <td height="23">��ԱͶ��:</td>
                <td> 
                  <?=$addnews_ok?>                </td>
              </tr>
              <tr> 
                <td height="23">����Ա����:</td>
                <td><a href="user/ListUser.php<?=$ecms_hashur['whehref']?>"><?=$adminnum?></a> ��</td>
              </tr>
              <tr> 
                <td height="23">δ�������:</td>
                <td><a href="openpage/AdminPage.php?leftfile=<?=urlencode('../pl/PlNav.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../pl/ListAllPl.php?checked=2'.$ecms_hashur['ehref'])?>&title=<?=urlencode('��������')?><?=$ecms_hashur['ehref']?>"><?=$noplnum?></a> ��</td>
              </tr>
              <tr> 
                <td height="23">δ��˻�Ա:</td>
                <td><a href="member/ListMember.php?sear=1&schecked=1<?=$ecms_hashur['ehref']?>"><?=$nomembernum?></a> ��</td>
              </tr>
              <tr> 
                <td height="23">���ڹ��:</td>
                <td><a href="tool/ListAd.php?time=1<?=$ecms_hashur['ehref']?>"><?=$outtimeadnum?></a> ��</td>
              </tr>
              <tr> 
                <td height="23">��½��IP:</td>
                <td><? echo egetip();?></td>
              </tr>
              <tr> 
                <td height="23">����汾:</td>
                <td> <a href="http://www.phome.net" target="_blank"><strong>EmpireCMS 
                  v<?=EmpireCMS_VERSION?> Free</strong></a> <font color="#666666">(<?=EmpireCMS_LASTTIME?>)</font></td>
              </tr>
              <tr>
                <td height="23">�������:</td>
                <td><?=EmpireCMS_CHARVER?></td>
              </tr>
            </table></td>
          <td valign="top" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr> 
                <td width="25%" height="23">���������:</td>
                <td width="75%"> 
                  <?=$_SERVER['SERVER_SOFTWARE']?>                </td>
              </tr>
              <tr> 
                <td height="23">����ϵͳ:</td>
                <td><? echo defined('PHP_OS')?PHP_OS:'δ֪';?></td>
              </tr>
              <tr> 
                <td height="23">PHP�汾:</td>
                <td><? echo @phpversion();?></td>
              </tr>
              <tr> 
                <td height="23">MYSQL�汾:</td>
                <td><? echo do_eGetDBVer(0);?></td>
              </tr>
              <tr> 
                <td height="23">ȫ�ֱ���:</td>
                <td> 
                  <?=$onoff?>
                  <font color="#666666">(����ر�)</font></td>
              </tr>
              <tr>
                <td height="23">ħ������:</td>
                <td> 
                  <?=MAGIC_QUOTES_GPC?'����':'�ر�'?>
                  <font color="#666666">(���鿪��)</font></td>
              </tr>
              <tr> 
                <td height="23">�ϴ��ļ�:</td>
                <td> 
                  <?=$upload?>
                  <font color="#666666">(����ļ���<?=$uploadsize?>������<?=$uploadpostsize?>)</font> </td>
              </tr>
              <tr> 
                <td height="23">��ǰʱ��:</td>
                <td><? echo date("Y-m-d H:i:s");?></td>
              </tr>
              <tr> 
                <td height="23">ʹ������:</td>
                <td> 
                  <?=$_SERVER['HTTP_HOST']?>                </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
      <tr class="header">
        <td height="25" colspan="2">�ٷ���Ϣ</td>
      </tr>
      <tr>
        <td width="43%" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
            <tr bgcolor="#FFFFFF">
              <td width="28%" height="25">�۹��ٷ���ҳ</td>
              <td width="72%" height="25"><a href="http://www.phome.net" target="_blank">http://www.phome.net</a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td height="25">�۹��ٷ���̳</td>
              <td height="25"><a href="http://bbs.phome.net" target="_blank">http://bbs.phome.net</a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td height="25">�۹���Ʒ����</td>
              <td height="25"><a href="http://www.phome.net/product/" target="_blank">http://www.phome.net/product/</a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td height="25">��˾��վ</td>
              <td height="25"><a href="http://www.digod.com" target="_blank">http://www.digod.com</a></td>
            </tr>
        </table></td>
        <td width="57%" height="125" valign="top" bgcolor="#FFFFFF"><IFRAME frameBorder="0" name="getinfo" scrolling="no" src="ginfo.php<?=$ecms_hashur['whehref']?>" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:2"></IFRAME></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
      <tr class="header">
        <td height="25">EmpireCMS �����Ŷ�</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="80%" border="0" cellpadding="3" cellspacing="1">
            <tr bgcolor="#FFFFFF">
              <td width="15%" height="25">��Ȩ����</td>
              <td width="85%"><a href="http://www.digod.com" target="_blank">������ܼ�ǵ�������������޹�˾</a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td height="25">������֧���Ŷ�</td>
              <td>wm_chief��amt�����ˡ�С�Ρ�zeedy</td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td height="25">�ر��л</td>
              <td>�̻�ľ�硢yingnt��hicode��sooden���Ϲ�С�֡����˸衢TryLife��5starsgeneral</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>