<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=defined('empirecms')?$public_diyr[pagetitle]:'�û��������'?> - Powered by EmpireCMS</title>
<meta name="keywords" content="<?=defined('empirecms')?$public_diyr[pagetitle]:'�û��������'?>" />
<meta name="description" content="<?=defined('empirecms')?$public_diyr[pagetitle]:'�û��������'?>" />
<link href="/ecms75/skin/default/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ecms75/skin/default/js/tabs.js"></script>
</head>
<body class="listpage">
<!-- ҳͷ -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="top">
<tr>
<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="63%">
<!-- ��¼ -->
<script>
document.write('<script src="/ecms75/e/member/login/loginjs.php?t='+Math.random()+'"><'+'/script>');
</script>
</td>
<td align="right">
<a onclick="window.external.addFavorite(location.href,document.title)" href="#ecms">�����ղ�</a> | <a onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('/ecms75/')" href="#ecms">��Ϊ��ҳ</a> | <a href="/ecms75/e/member/cp/">��Ա����</a> | <a href="/ecms75/e/DoInfo/">��ҪͶ��</a> | <a href="/ecms75/e/web/?type=rss2" target="_blank">RSS<img src="/ecms75/skin/default/images/rss.gif" border="0" hspace="2" /></a>
</td>
</tr>
</table></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="10">
<tr valign="middle">
<td width="240" align="center"><a href="/ecms75/"><img src="/ecms75/skin/default/images/logo.gif" width="200" height="65" border="0" /></a></td>
<td align="center"><a href="http://www.phome.net/OpenSource/" target="_blank"><img src="/ecms75/skin/default/images/opensource.gif" width="100%" height="70" border="0" /></a></td>
</tr>
</table>
<!-- ����tabѡ� -->
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0" class="nav">
  <tr> 
    <td class="nav_global"><ul>
        <li class="curr" id="tabnav_btn_0" onmouseover="tabit(this)"><a href="/ecms75/">��ҳ</a></li>
        <li id="tabnav_btn_1" onmouseover="tabit(this)"><a href="/ecms75/news/">��������</a></li>
        <li id="tabnav_btn_2" onmouseover="tabit(this)"><a href="/ecms75/download/">��������</a></li>
        <li id="tabnav_btn_3" onmouseover="tabit(this)"><a href="/ecms75/movie/">Ӱ��Ƶ��</a></li>
        <li id="tabnav_btn_4" onmouseover="tabit(this)"><a href="/ecms75/shop/">�����̳�</a></li>
        <li id="tabnav_btn_5" onmouseover="tabit(this)"><a href="/ecms75/flash/">FLASHƵ��</a></li>
        <li id="tabnav_btn_6" onmouseover="tabit(this)"><a href="/ecms75/photo/">ͼƬƵ��</a></li>
        <li id="tabnav_btn_7" onmouseover="tabit(this)"><a href="/ecms75/article/">��������</a></li>
        <li id="tabnav_btn_8" onmouseover="tabit(this)"><a href="/ecms75/info/">������Ϣ</a></li>
      </ul></td>
  </tr>
</table> 
<table width="100%" border="0" cellspacing="10" cellpadding="0">
<tr valign="top">
<td class="list_content"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="position">
<tr>
<td>���ڵ�λ�ã�<?=$url?>
</td>
</tr>
</table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="box">
        <tr> 
          <td width="300" valign="top"> 
		  <?php
		  $lguserid=intval(getcvar('mluserid'));//��½�û�ID
		  $lgusername=RepPostVar(getcvar('mlusername'));//��½�û�
		  $lggroupid=intval(getcvar('mlgroupid'));//��Ա��ID
		  if($lggroupid)	//��½��Ա��ʾ�˵�
		  {
		  ?>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
              <tr class="header"> 
                <td height="20" bgcolor="#FFFFFF"> <div align="center"><strong><a href="/ecms75/e/member/cp/">���ܲ˵�</a></strong></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/EditInfo/">�޸�����</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/my/">�ʺ�״̬</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/msg/">վ����Ϣ</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/mspace/SetSpace.php">�ռ�����</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/DoInfo/">������Ϣ</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/fava/">�ղؼ�</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/payapi/">����֧��</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/friend/">�ҵĺ���</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/buybak/">���Ѽ�¼</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/buygroup/">���߳�ֵ</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/card/">�㿨��ֵ</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="#ecms" onclick="window.open('/ecms75/e/ShopSys/buycar/','','width=680,height=500,scrollbars=yes,resizable=yes');">�ҵĹ��ﳵ</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/ShopSys/ListDd/">�ҵĶ���</a></div></td>
              </tr>
			  <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/login/">���µ�½</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/doaction.php?enews=exit" onclick="return confirm('ȷ��Ҫ�˳�?');">�˳���½</a></div></td>
              </tr>
            </table>
			<?php
			}
			else	//�ο���ʾ�˵�
			{
			?>  
            <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
              <tr class="header"> 
                <td height="20" bgcolor="#FFFFFF"> <div align="center"><strong><a href="/ecms75/e/member/cp/">���ܲ˵�</a></strong></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/login/">��Ա��½</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/member/register/">ע���ʺ�</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="/ecms75/e/DoInfo/">����Ͷ��</a></div></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><div align="center"><a href="#ecms" onclick="window.open('/ecms75/e/ShopSys/buycar/','','width=680,height=500,scrollbars=yes,resizable=yes');">�ҵĹ��ﳵ</a></div></td>
              </tr>
            </table>
			<?php
			}
			?>
			</td>
          <td width="85%" valign="top">