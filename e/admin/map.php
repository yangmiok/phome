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
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��̨��ͼ</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function GoToUrl(url,totarget){
	if(totarget=='')
	{
		totarget='main';
	}
	opener.document.getElementById(totarget).src=url;
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <tr class="header">
    <td width="9%" height="25">ϵͳ����</td>
    <td width="6%">��Ϣ����</td>
    <td width="21%">��Ŀ����</td>
    <td width="34%">ģ�����</td>
    <td width="9%">�û����</td>
    <td width="11%">�������</td>
    <td width="10%">��������</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><strong>ϵͳ����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('SetEnews.php<?=$ecms_hashur['whehref']?>','');">ϵͳ��������</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pub/SetRewrite.php<?=$ecms_hashur['whehref']?>','');">α��̬��������</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pub/SetPageCache.php<?=$ecms_hashur['whehref']?>','');">��̬ҳ��������</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" title="Not for free version.">ҳ��ͬ������</a></td>
        </tr>
		<tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pub/SetDigg.php<?=$ecms_hashur['whehref']?>','');">DIGG������</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pub/ListPubVar.php<?=$ecms_hashur['whehref']?>','');">��չ����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pub/SetSafe.php<?=$ecms_hashur['whehref']?>','');">��ȫ��������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pub/SetFirewall.php<?=$ecms_hashur['whehref']?>','');">��վ����ǽ</a></td>
        </tr>
        <tr> 
          <td><strong>���ݸ���</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>','');">���ݸ�������</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ReHtml/ReInfoUrl.php<?=$ecms_hashur['whehref']?>','');">������Ϣҳ��ַ</a></td>
        </tr>
		<tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ReHtml/ChangePageCache.php<?=$ecms_hashur['whehref']?>','');">���¶�̬ҳ����</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ReHtml/DoUpdateData.php<?=$ecms_hashur['whehref']?>','');">��������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('PostUrlData.php<?=$ecms_hashur['whehref']?>','');">Զ�̷���</a></td>
        </tr>
        <tr> 
          <td><strong>���ݱ���ģ��</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('db/AddTable.php?enews=AddTable<?=$ecms_hashur['ehref']?>','');">�½����ݱ�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('db/ListTable.php<?=$ecms_hashur['whehref']?>','');">�������ݱ�</a></td>
        </tr>
        <tr> 
          <td><strong>�ƻ�����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ListDo.php<?=$ecms_hashur['whehref']?>','');">����ˢ������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/ListTask.php<?=$ecms_hashur['whehref']?>','');">����ƻ�����</a></td>
        </tr>
        <tr> 
          <td><strong>������</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('workflow/AddWf.php?enews=AddWorkflow<?=$ecms_hashur['ehref']?>','');">���ӹ�����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('workflow/ListWf.php<?=$ecms_hashur['whehref']?>','');">��������</a></td>
        </tr>
        <tr> 
          <td><strong>�Ż�����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('db/ListYh.php<?=$ecms_hashur['whehref']?>','');">�����Ż�����</a></td>
        </tr>
		<tr> 
          <td><strong>��վ����ʶ�</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('moreport/ListMoreport.php<?=$ecms_hashur['whehref']?>','');">������վ���ʶ�</a></td>
        </tr>
		<tr> 
          <td><strong>��չ�˵�</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/MenuClass.php<?=$ecms_hashur['whehref']?>','');">����˵�</a></td>
        </tr>
        <tr> 
          <td><strong>����/�ָ�����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ebak/ChangeDb.php<?=$ecms_hashur['whehref']?>','');">��������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ebak/ReData.php<?=$ecms_hashur['whehref']?>','');">�ָ�����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ebak/ChangePath.php<?=$ecms_hashur['whehref']?>','');">������Ŀ¼</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('db/DoSql.php<?=$ecms_hashur['whehref']?>','');">ִ��SQL���</a></td>
        </tr>
      </table></td>
    <td valign="top" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><a href="#ecms" onclick="GoToUrl('AddInfoChClass.php<?=$ecms_hashur['whehref']?>','');">������Ϣ</a></td>
        </tr>
        <tr> 
          <td><a href="#ecms" onclick="GoToUrl('ListAllInfo.php<?=$ecms_hashur['whehref']?>','');">������Ϣ</a></td>
        </tr>
        <tr> 
          <td><a href="#ecms" onclick="GoToUrl('ListAllInfo.php?ecmscheck=1<?=$ecms_hashur['ehref']?>','');">�����Ϣ</a></td>
        </tr>
        <tr> 
          <td><a href="#ecms" onclick="GoToUrl('workflow/ListWfInfo.php<?=$ecms_hashur['whehref']?>','');">ǩ����Ϣ</a></td>
        </tr>
        <tr>
          <td><a href="#ecms" onclick="GoToUrl('sp/UpdateSp.php<?=$ecms_hashur['whehref']?>','');">������Ƭ</a></td>
        </tr>
        <tr>
          <td><a href="#ecms" onclick="GoToUrl('special/UpdateZt.php<?=$ecms_hashur['whehref']?>','');">����ר��</a></td>
        </tr>
        <tr> 
          <td><a href="#ecms" onclick="GoToUrl('openpage/AdminPage.php?leftfile=<?=urlencode('../pl/PlNav.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../pl/PlMain.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('��������')?><?=$ecms_hashur['ehref']?>','');">��������</a></td>
        </tr>
        <tr>
          <td><a href="#ecms" onclick="GoToUrl('info/InfoMain.php<?=$ecms_hashur['whehref']?>','');">����ͳ��</a></td>
        </tr>
        <tr>
          <td><a href="#ecms" onclick="GoToUrl('infotop.php<?=$ecms_hashur['whehref']?>','');">����ͳ��</a></td>
        </tr>
      </table></td>
    <td valign="top" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="50%"><strong>��Ŀ����</strong></td>
          <td><strong>�Զ���ҳ��</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ListClass.php<?=$ecms_hashur['whehref']?>','');">������Ŀ</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/PageClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ���ҳ�����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ListPageClass.php<?=$ecms_hashur['whehref']?>','');">������Ŀ(��ҳ)</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListPage.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ���ҳ��</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" title="Not for free version.">��Ŀ��������</a></td>
          <td><strong>�Զ����б�</strong></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" title="Not for free version.">���÷���ͳ�Ʋ���</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/UserlistClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ����б���� </a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('info/ListClassF.php<?=$ecms_hashur['whehref']?>','');">��Ŀ�Զ����ֶ�</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/ListUserlist.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ����б�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('SetMoreClass.php<?=$ecms_hashur['whehref']?>','');">����������Ŀ����</a></td>
          <td><strong>�Զ���JS</strong></td>
        </tr>
        <tr> 
          <td><strong>ר�����</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/UserjsClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ���JS����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('special/ListZtClass.php<?=$ecms_hashur['whehref']?>','');">����ר�����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/ListUserjs.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ���JS</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('special/ListZt.php<?=$ecms_hashur['whehref']?>','');">����ר��</a></td>
          <td><strong>�ɼ�����</strong></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('special/ListZtF.php<?=$ecms_hashur['whehref']?>','');">ר���Զ����ֶ� 
            </a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('AddInfoC.php<?=$ecms_hashur['whehref']?>','');">���Ӳɼ��ڵ�</a></td>
        </tr>
        <tr>
          <td><strong>����������</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ListInfoClass.php<?=$ecms_hashur['whehref']?>','');">����ɼ��ڵ�</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('info/InfoType.php<?=$ecms_hashur['whehref']?>','');">����������</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('ListPageInfoClass.php<?=$ecms_hashur['whehref']?>','');">����ɼ��ڵ�(��ҳ)</a></td>
        </tr>
        <tr> 
          <td><strong>��Ƭ����</strong></td>
          <td><strong>WAP����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('sp/ListSpClass.php<?=$ecms_hashur['whehref']?>','');">������Ƭ����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/SetWap.php<?=$ecms_hashur['whehref']?>','');">WAP����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('sp/ListSp.php<?=$ecms_hashur['whehref']?>','');">������Ƭ</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/WapStyle.php<?=$ecms_hashur['whehref']?>','');">����WAPģ��</a></td>
        </tr>
        <tr> 
          <td><strong>TAGS����</strong></td>
          <td><strong>��������</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tags/SetTags.php<?=$ecms_hashur['whehref']?>','');">����TAGS����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('TotalData.php<?=$ecms_hashur['whehref']?>','');">ͳ����Ϣ����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tags/TagsClass.php<?=$ecms_hashur['whehref']?>','');">����TAGS����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('user/UserTotal.php<?=$ecms_hashur['whehref']?>','');">�û�����ͳ��</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tags/ListTags.php<?=$ecms_hashur['whehref']?>','');">����TAGS</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('SearchKey.php<?=$ecms_hashur['whehref']?>','');">���������ؼ���</a></td>
        </tr>
        <tr>
          <td><strong>ͷ��/�Ƽ�����</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('db/RepNewstext.php<?=$ecms_hashur['whehref']?>','');">�����滻�ֶ�ֵ</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('info/ListGoodType.php?ttype=1<?=$ecms_hashur['ehref']?>','');">����ͷ������</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('MoveClassNews.php<?=$ecms_hashur['whehref']?>','');">����ת����Ϣ</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('info/ListGoodType.php?ttype=0<?=$ecms_hashur['ehref']?>','');">�����Ƽ�����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('InfoDoc.php<?=$ecms_hashur['whehref']?>','');">��Ϣ�����鵵</a></td>
        </tr>
        <tr> 
          <td><strong>��������</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('db/DelData.php<?=$ecms_hashur['whehref']?>','');">����ɾ����Ϣ</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('openpage/AdminPage.php?leftfile=<?=urlencode('../file/FileNav.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('������')?><?=$ecms_hashur['ehref']?>','');">������</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('other/ListVoteMod.php<?=$ecms_hashur['whehref']?>','');">����Ԥ��ͶƱ</a></td>
        </tr>
        <tr> 
          <td><strong>ȫվȫ������</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('searchall/SetSearchAll.php<?=$ecms_hashur['whehref']?>','');">ȫվ��������</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('searchall/ListSearchLoadTb.php<?=$ecms_hashur['whehref']?>','');">������������Դ</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('searchall/ClearSearchAll.php<?=$ecms_hashur['whehref']?>','');">������������</a></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    <td valign="top" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="32%"><a href="#ecms" onclick="window.open('template/EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=600,scrollbars=yes,resizable=yes');window.close();"><strong>�鿴��ǩ�﷨</strong></a></td>
          <td width="36%"><strong>����ģ��</strong></td>
          <td width="32%"><strong>�Զ���ҳ��ģ��</strong></td>
        </tr>
        <tr> 
          <td><a href="#ecms" onclick="window.open('template/MakeBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=600,scrollbars=yes,resizable=yes');window.close();"><strong>�Զ����ɱ�ǩ</strong></a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=indextemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸���ҳģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/AddPagetemp.php?enews=AddPagetemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ���ҳ��ģ��</a></td>
        </tr>
        <tr>
          <td><a href="#ecms" onclick="window.open('openpage/AdminPage.php?leftfile=<?=urlencode('../template/dttemppageleft.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('��̬ҳ��ģ�����')?><?=$ecms_hashur['ehref']?>','dttemppage','');window.close();"><strong>��̬ҳ��ģ�����</strong></a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=cptemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸Ŀ������ģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListPagetemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����Զ���ҳ��ģ��</a></td>
        </tr>
        <tr> 
          <td><strong>��Ŀ����ģ��</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=schalltemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸�ȫվ����ģ��</a></td>
          <td><strong>ͶƱģ��</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ClassTempClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�������ģ�����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=searchformtemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸ĸ߼�������ģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/AddVotetemp.php?enews=AddVoteTemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">����ͶƱģ��</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListClasstemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�������ģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=searchformjs&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸ĺ�������JSģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListVotetemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">����ͶƱģ��</a></td>
        </tr>
        <tr> 
          <td><strong>�б�ģ��</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=searchformjs1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸���������JSģ��</a></td>
          <td><strong>��ǩ����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListtempClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����б�ģ�����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=otherlinktemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸������Ϣģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/BqClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����ǩ����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListListtemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����б�ģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=gbooktemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸����԰�ģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListBq.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����ǩ</a></td>
        </tr>
        <tr> 
          <td><strong>����ģ��</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=pljstemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸�����JS����ģ��</a></td>
          <td><strong>��������</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/NewstempClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">��������ģ�����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=downpagetemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸���������ҳģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/LoadTemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">����������Ŀģ��</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListNewstemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">��������ģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=downsofttemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸����ص�ַģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ChangeListTemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">���������б�ģ��</a></td>
        </tr>
        <tr> 
          <td><strong>��ǩģ��</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=onlinemovietemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸����߲��ŵ�ַģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/RepTemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����滻ģ���ַ�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/BqtempClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����ǩģ�����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=listpagetemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸��б��ҳģ��</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListBqtemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����ǩģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=loginiframe&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸ĵ�½״̬ģ��</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><strong>����ģ�����</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/EditPublicTemp.php?tname=loginjstemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�޸�JS���õ�½ģ��</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/TempvarClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">����ģ���������</a></td>
          <td><strong>��ӡģ��</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListTempvar.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">����ģ�����</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/AddPrinttemp.php?enews=AddPrintTemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">���Ӵ�ӡģ��</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><strong>JSģ��</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListPrinttemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">�����ӡģ��</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/JsTempClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">����JSģ�����</a></td>
          <td><strong>����ģ��</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListJstemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">����JSģ��</a></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/SearchtempClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">��������ģ�����</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><strong>�����б�ģ��</strong></td>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListSearchtemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">��������ģ��</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/AddPltemp.php?enews=AddPlTemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">��������ģ��</a></td>
          <td><a href="#ecms" onclick="GoToUrl('template/TempGroup.php<?=$ecms_hashur['whehref']?>','');"><strong>ģ�������</strong></a></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/ListPltemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');">��������ģ��</a></td>
          <td><a href="#ecms" onclick="GoToUrl('template/EditTempid.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>','');"><strong>�޸�ģ��ID</strong></a></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    <td valign="top" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><strong>�û�����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('user/EditPassword.php<?=$ecms_hashur['whehref']?>','');">�޸ĸ�������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('user/ListGroup.php<?=$ecms_hashur['whehref']?>','');">�����û���</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('user/UserClass.php<?=$ecms_hashur['whehref']?>','');">������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('user/ListUser.php<?=$ecms_hashur['whehref']?>','');">�����û�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('user/ListLog.php<?=$ecms_hashur['whehref']?>','');">�����½��־</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('user/ListDolog.php<?=$ecms_hashur['whehref']?>','');">���������־</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('template/AdminStyle.php<?=$ecms_hashur['whehref']?>','');">�����̨���</a></td>
        </tr>
        <tr> 
          <td><strong>��Ա����</strong></td>
        </tr>
        <tr> 
          <td> &nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListMember.php<?=$ecms_hashur['whehref']?>','');">�����Ա</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListMemberMore.php<?=$ecms_hashur['whehref']?>','');">�����Ա(��ϸ)</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ClearMember.php<?=$ecms_hashur['whehref']?>','');">���������Ա</a></td>
        </tr>
		<tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListMemberGroup.php<?=$ecms_hashur['whehref']?>','');">��Ա��</a></td>
        </tr>
		<tr>
		  <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListInGroup.php<?=$ecms_hashur['whehref']?>','');">��Ա�ڲ���</a></td>
	    </tr>
		<tr>
		  <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListViewGroup.php<?=$ecms_hashur['whehref']?>','');">��Ա������</a></td>
	    </tr>
		<tr>
		  <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListMAdminGroup.php<?=$ecms_hashur['whehref']?>','');">��Ա������</a></td>
	    </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListMemberF.php<?=$ecms_hashur['whehref']?>','');">�����Ա�ֶ�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListMemberForm.php<?=$ecms_hashur['whehref']?>','');">�����Ա��</a></td>
        </tr>
        <tr> 
          <td><strong>��Ա�ռ����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListSpaceStyle.php<?=$ecms_hashur['whehref']?>','');">����ռ�ģ��</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/MemberGbook.php<?=$ecms_hashur['whehref']?>','');">����ռ�����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/MemberFeedback.php<?=$ecms_hashur['whehref']?>','');">����ռ䷴��</a></td>
        </tr>
        <tr>
          <td><strong>�ⲿ�ӿ�</strong></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/MemberConnect.php<?=$ecms_hashur['whehref']?>','');">�ⲿ��¼�ӿ�</a></td>
        </tr>
        <tr> 
          <td><strong>��������</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListBuyGroup.php<?=$ecms_hashur['whehref']?>','');">�����ֵ����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/ListCard.php<?=$ecms_hashur['whehref']?>','');">����㿨</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/GetFen.php<?=$ecms_hashur['whehref']?>','');">�������͵���</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/SendEmail.php<?=$ecms_hashur['whehref']?>','');">���������ʼ�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/SendMsg.php<?=$ecms_hashur['whehref']?>','');">�������Ͷ���Ϣ</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('member/DelMoreMsg.php<?=$ecms_hashur['whehref']?>','');">����ɾ������Ϣ</a></td>
        </tr>
      </table></td>
    <td valign="top" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><strong>���ϵͳ</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/AdClass.php<?=$ecms_hashur['whehref']?>','');">���������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/ListAd.php<?=$ecms_hashur['whehref']?>','');">������</a></td>
        </tr>
        <tr> 
          <td><strong>ͶƱϵͳ</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/AddVote.php?enews=AddVote<?=$ecms_hashur['ehref']?>','');">����ͶƱ</a></td>
        </tr>
        <tr> 
          <td> &nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/ListVote.php<?=$ecms_hashur['whehref']?>','');">����ͶƱ</a></td>
        </tr>
        <tr> 
          <td><strong>�������ӹ���</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/LinkClass.php<?=$ecms_hashur['whehref']?>','');">�����������ӷ���</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/ListLink.php<?=$ecms_hashur['whehref']?>','');">������������</a></td>
        </tr>
        <tr> 
          <td><strong>���԰����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/GbookClass.php<?=$ecms_hashur['whehref']?>','');">�������Է���</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/gbook.php<?=$ecms_hashur['whehref']?>','');">��������</a></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/DelMoreGbook.php<?=$ecms_hashur['whehref']?>','');">����ɾ������</a></td>
        </tr>
        <tr> 
          <td><strong>��Ϣ��������</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/FeedbackClass.php<?=$ecms_hashur['whehref']?>','');">����������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/ListFeedbackF.php<?=$ecms_hashur['whehref']?>','');">�������ֶ�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('tool/feedback.php<?=$ecms_hashur['whehref']?>','');">������Ϣ����</a></td>
        </tr>
        <tr> 
          <td><a href="#ecms" onclick="GoToUrl('template/NotCj.php<?=$ecms_hashur['whehref']?>','');"><strong>������ɼ�����ַ�</strong></a></td>
        </tr>
      </table></td>
    <td valign="top" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#EBF3FC'"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><strong>����ģ�����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('NewsSys/BeFrom.php<?=$ecms_hashur['whehref']?>','');">������Ϣ��Դ</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('NewsSys/writer.php<?=$ecms_hashur['whehref']?>','');">��������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('NewsSys/key.php<?=$ecms_hashur['whehref']?>','');">�������ݹؼ���</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('NewsSys/word.php<?=$ecms_hashur['whehref']?>','');">��������ַ�</a></td>
        </tr>
        <tr> 
          <td><strong>����ģ�����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('DownSys/url.php<?=$ecms_hashur['whehref']?>','');">�����ַǰ׺</a></td>
        </tr>
        <tr> 
          <td> &nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('DownSys/DelDownRecord.php<?=$ecms_hashur['whehref']?>','');">ɾ�����ؼ�¼</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('DownSys/ListError.php<?=$ecms_hashur['whehref']?>','');">������󱨸�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('DownSys/RepDownLevel.php<?=$ecms_hashur['whehref']?>','');">�����滻��ַȨ��</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('DownSys/player.php<?=$ecms_hashur['whehref']?>','');">����������</a></td>
        </tr>
        <tr> 
          <td><strong>�̳�ģ�����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="window.open('openpage/AdminPage.php?leftfile=<?=urlencode('../ShopSys/pageleft.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../other/OtherMain.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('�̳�ϵͳ����')?><?=$ecms_hashur['ehref']?>','AdminShopSys','');window.close();">�����̳�</a></td>
        </tr>
        <tr> 
          <td><strong>����֧��</strong></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pay/SetPayFen.php<?=$ecms_hashur['whehref']?>','');">֧����������</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pay/PayApi.php<?=$ecms_hashur['whehref']?>','');">����֧���ӿ�</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('pay/ListPayRecord.php<?=$ecms_hashur['whehref']?>','');">����֧����¼</a></td>
        </tr>
        <tr> 
          <td><strong>ͼƬ��Ϣ����</strong></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('NewsSys/PicClass.php<?=$ecms_hashur['whehref']?>','');">����ͼƬ��Ϣ����</a></td>
        </tr>
        <tr> 
          <td>&nbsp;&nbsp;<a href="#ecms" onclick="GoToUrl('NewsSys/ListPicNews.php<?=$ecms_hashur['whehref']?>','');">����ͼƬ��Ϣ</a></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
