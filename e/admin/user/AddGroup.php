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
CheckLevel($logininid,$loginin,$classid,"group");
$url="λ�ã�<a href=ListGroup.php".$ecms_hashur['whehref'].">�����û���</a>&nbsp;>&nbsp;�����û���";
//Ĭ��ֵ
$checked="";
$doall=$checked;
$dopublic=$checked;
$doclass=$checked;
$dotemplate=$checked;
$dopicnews=$checked;
$dofile=$checked;
$douser=$checked;
$dolog=$checked;
$domember=$checked;
$dobefrom=$checked;
$doword=$checked;
$dokey=$checked;
$doad=$checked;
$dovote=$checked;
$dogroup=$checked;
$docj=$checked;
$dobq=$checked;
$domovenews=$checked;
$dopostdata=$checked;
$dochangedata=$checked;
$dopl=$checked;
$doselfinfo=$checked;
$dotable=$checked;
$doexecsql=$checked;
$dodownurl=$checked;
$dodownrecord=$checked;
$doshoppayfs=$checked;
$doshopps=$checked;
$doshopdd=$checked;
$dogbook=$checked;
$dofeedback=$checked;
$donotcj=$checked;
$dodownerror=$checked;
$douserpage=$checked;
$dodelinfodata=$checked;
$doadminstyle=$checked;
$dorepdownpath=$checked;
$douserjs=$checked;
$douserlist=$checked;
$domsg=$checked;
$dosendemail=$checked;
$dosetmclass=$checked;
$doinfodoc=$checked;
$dotempgroup=$checked;
$dofeedbackf=$checked;
$dotask=$checked;
$domemberf=$checked;
$dospacestyle=$checked;
$dospacedata=$checked;
$dovotemod=$checked;
$doplayer=$checked;
$dowap=$checked;
$dopay=$checked;

$enews=ehtmlspecialchars($_GET['enews']);
//�޸��û���
if($enews=="EditGroup")
{
$groupid=(int)$_GET['groupid'];
$r=$empire->fetch1("select * from {$dbtbpre}enewsgroup where groupid='$groupid'");
$url="λ�ã�<a href=ListGroup.php".$ecms_hashur['whehref'].">�����û���</a>&nbsp;>&nbsp;�޸��û��飺<b>".$r[groupname]."</b>";
if($r[doall])
{
$doall=" checked";
}
if($r[dopublic])
{
$dopublic=" checked";
}
if($r[doclass])
{
$doclass=" checked";
}
if($r[dotemplate])
{
$dotemplate=" checked";
}
if($r[dopicnews])
{
$dopicnews=" checked";
}
if($r[dofile])
{
$dofile=" checked";
}
if($r[douser])
{
$douser=" checked";
}
if($r[dolog])
{
$dolog=" checked";
}
if($r[domember])
{
$domember=" checked";
}
if($r[dobefrom])
{
$dobefrom=" checked";
}
if($r[doword])
{
$doword=" checked";
}
if($r[dokey])
{
$dokey=" checked";
}
if($r[doad])
{
$doad=" checked";
}
if($r[dovote])
{
$dovote=" checked";
}
if($r[dogroup])
{
$dogroup=" checked";
}
if($r[docj])
{
$docj=" checked";
}
if($r[dobq])
{
$dobq=" checked";
}
if($r[domovenews])
{
$domovenews=" checked";
}
if($r[dopostdata])
{
$dopostdata=" checked";
}
if($r[dochangedata])
{
$dochangedata=" checked";
}
if($r[dopl])
{
$dopl=" checked";
}

if($r[dof])
{
$dof=" checked";
}
if($r[dom])
{
$dom=" checked";
}
if($r[dodo])
{
$dodo=" checked";
}
if($r[dodbdata])
{
$dodbdata=" checked";
}
if($r[dorepnewstext])
{
$dorepnewstext=" checked";
}
if($r[dotempvar])
{
$dotempvar=" checked";
}
if($r[dostats])
{
$dostats=" checked";
}
if($r[dowriter])
{
$dowriter=" checked";
}
if($r[dototaldata])
{
$dototaldata=" checked";
}
if($r[dosearchkey])
{
$dosearchkey=" checked";
}
if($r[dozt])
{
$dozt=" checked";
}
if($r[docard])
{
$docard=" checked";
}
if($r[dolink])
{
$dolink=" checked";
}
if($r[doselfinfo])
{
$doselfinfo=" checked";
}
if($r[dotable])
{
$dotable=" checked";
}
if($r[doexecsql])
{
$doexecsql=" checked";
}
if($r[dodownurl])
{
$dodownurl=" checked";
}
if($r[dodeldownrecord])
{
$dodeldownrecord=" checked";
}
if($r[doshoppayfs])
{
$doshoppayfs=" checked";
}
if($r[doshopps])
{
$doshopps=" checked";
}
if($r[doshopdd])
{
$doshopdd=" checked";
}
if($r[dogbook])
{
$dogbook=" checked";
}
if($r[dofeedback])
{
$dofeedback=" checked";
}
if($r[donotcj])
{
$donotcj=" checked";
}
if($r[dodownerror])
{
$dodownerror=" checked";
}
if($r[douserpage])
{
$douserpage=" checked";
}
if($r[dodelinfodata])
{
$dodelinfodata=" checked";
}
if($r[doadminstyle])
{
$doadminstyle=" checked";
}
if($r[dorepdownpath])
{
$dorepdownpath=" checked";
}
if($r[douserjs])
{
$douserjs=" checked";
}
if($r[douserlist])
{
$douserlist=" checked";
}
if($r[domsg])
{
$domsg=" checked";
}
if($r[dosendemail])
{
$dosendemail=" checked";
}
if($r[dosetmclass])
{
$dosetmclass=" checked";
}
if($r[doinfodoc])
{
$doinfodoc=" checked";
}
if($r[dotempgroup])
{
$dotempgroup=" checked";
}
if($r[dofeedbackf])
{
$dofeedbackf=" checked";
}
if($r[dotask])
{
$dotask=" checked";
}
if($r[domemberf])
{
$domemberf=" checked";
}
if($r[dospacestyle])
{
$dospacestyle=" checked";
}
if($r[dospacedata])
{
$dospacedata=" checked";
}
if($r[dovotemod])
{
$dovotemod=" checked";
}
if($r[doplayer])
{
$doplayer=" checked";
}
if($r[dowap])
{
$dowap=" checked";
}
if($r[dopay])
{
$dopay=" checked";
}

}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�û���</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
	if(e.name=='gr[doselfinfo]'||e.name=='gr[domustcheck]'||e.name=='gr[docheckedit]')
		{
		continue;
	    }
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListGroup.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�����û��� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
        <input name="groupid" type="hidden" id="groupid" value="<?=$groupid?>">
        </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">����</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">�û������ƣ�</td>
      <td width="80%" height="25"><input name="groupname" type="text" id="groupname" value="<?=$r[groupname]?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">Ȩ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">Ȩ�޷��䣺</td>
      <td height="25"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#C3EFFF">
          <tr> 
            <td>ϵͳ����</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td width="33%" height="23"> <input name="gr[dopublic]" type="checkbox" id="gr[dopublic]" value="1"<?=$dopublic?>>
                    ϵͳ��������</td>
                  <td width="33%" height="23"> <input name="gr[dopostdata]" type="checkbox" id="gr[dopostdata]" value="1"<?=$dopostdata?>>
                    Զ�̷���</td>
                  <td width="33%" height="23"> <input name="gr[dochangedata]" type="checkbox" id="gr[dochangedata]" value="1"<?=$dochangedata?>>
                    ���ݸ���</td>
                </tr>
                <tr> 
                  <td width="33%" height="23"><input name="gr[dof]" type="checkbox" id="gr[dof]" value="1"<?=$dof?>>
                    �Զ����ֶ�</td>
                  <td width="33%" height="23"><input name="gr[dom]" type="checkbox" id="gr[dom]" value="1"<?=$dom?>>
                    ϵͳģ�͹���</td>
                  <td width="33%" height="23"><input name="gr[dotable]" type="checkbox" id="gr[dotable]2" value="1"<?=$dotable?>>
                    ���ݱ����</td>
                </tr>
                <tr> 
                  <td width="33%" height="23"><input name="gr[dodbdata]" type="checkbox" id="gr[dodbdata]" value="1"<?=$dodbdata?>>
                    ���ݱ���</td>
                  <td width="33%" height="23"><input name="gr[dodo]" type="checkbox" id="gr[dodo]2" value="1"<?=$dodo?>>
                    ˢ���������</td>
                  <td width="33%" height="23"><input name="gr[dotask]" type="checkbox" value="1"<?=$dotask?>>
                    �ƻ��������</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[doexecsql]" type="checkbox" id="gr[doexecsql]" value="1"<?=$doexecsql?>>
                    ִ��SQL���</td>
                  <td height="23"><input name="gr[doyh]" type="checkbox" id="gr[doyh]" value="1"<?=$r[doyh]==1?' checked':''?>>
                    �Ż���������</td>
                  <td height="23"><input name="gr[dofirewall]" type="checkbox" id="gr[dofirewall]" value="1"<?=$r[dofirewall]==1?' checked':''?>>
                    ��վ����ǽ</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[dosetsafe]" type="checkbox" id="gr[dosetsafe]" value="1"<?=$r[dosetsafe]==1?' checked':''?>>
                    ��ȫ��������</td>
                  <td height="23"><input name="gr[doworkflow]" type="checkbox" id="gr[doworkflow]" value="1"<?=$r[doworkflow]==1?' checked':''?>>
                    ����������</td>
                  <td height="23"><input name="gr[dopubvar]" type="checkbox" id="gr[dopubvar]" value="1"<?=$r[dopubvar]==1?' checked':''?>>
                    ��չ��������</td>
                </tr>
                <tr>
                  <td height="23"><input name="gr[domenu]" type="checkbox" id="gr[domenu]" value="1"<?=$r[domenu]==1?' checked':''?>>
                    �˵�����</td>
                  <td height="23"><input name="gr[domoreport]" type="checkbox" id="gr[domoreport]" value="1"<?=$r[domoreport]==1?' checked':''?>>
��վ����ʶ˹���</td>
                  <td height="23"><input name="gr[dochmoreport]" type="checkbox" id="gr[dochmoreport]" value="1"<?=$r[dochmoreport]==1?' checked':''?>>
�л����ʶ˺�̨</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>��Ϣ����</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td width="33%" height="23"> <input name="gr[doall]" type="checkbox" id="gr[doall]3" value="1"<?=$doall?>>
                    �ɲ���������Ϣ</td>
                  <td width="33%"><input name="gr[doselfinfo]" type="checkbox" id="gr[doselfinfo]" value="1"<?=$doselfinfo?>> 
                    <strong>ֻ�ܲ����Լ���������Ϣ</strong></td>
                  <td width="33%"><input name="gr[doisqf]" type="checkbox" id="gr[doisqf]" value="1"<?=$r['doisqf']==1?' checked':''?>>
������Ϣ����Ҫǩ��</td>
                </tr>
                <tr> 
                  <td height="23" colspan="3"><input name="gr[doaddinfo]" type="checkbox" id="gr[doaddinfo]" value="1"<?=$r['doaddinfo']==1?' checked':''?>>
                    ����Ȩ�ޣ� 
                    <input name="gr[doeditinfo]" type="checkbox" id="gr[doeditinfo]" value="1"<?=$r['doeditinfo']==1?' checked':''?>>
                    �޸�Ȩ�ޣ� 
                    <input name="gr[dodelinfo]" type="checkbox" id="gr[dodelinfo]" value="1"<?=$r['dodelinfo']==1?' checked':''?>>
                    ɾ��Ȩ�ޣ� 
                    
<input name="gr[dogoodinfo]" type="checkbox" id="gr[dogoodinfo]" value="1"<?=$r['dogoodinfo']==1?' checked':''?>>
�Ƽ�/ͷ��/�ö�Ȩ��<br>
<input name="gr[docheckinfo]" type="checkbox" id="gr[docheckinfo]" value="1"<?=$r['docheckinfo']==1?' checked':''?>>
���Ȩ�ޣ�
<input name="gr[dodocinfo]" type="checkbox" id="gr[dodocinfo]" value="1"<?=$r['dodocinfo']==1?' checked':''?>>
�鵵Ȩ�ޣ�
<input name="gr[domoveinfo]" type="checkbox" id="gr[domoveinfo]" value="1"<?=$r['domoveinfo']==1?' checked':''?>>
�ƶ�/����Ȩ�ޣ�
<input name="gr[domustcheck]" type="checkbox" id="gr[domustcheck]" value="1"<?=$r['domustcheck']==1?' checked':''?>>
��������Ϣ�������<br>
<input name="gr[docheckedit]" type="checkbox" id="gr[docheckedit]" value="1"<?=$r['docheckedit']==1?' checked':''?>>
��˺����Ϣ�����޸ģ�
<input name="gr[docanhtml]" type="checkbox" id="gr[docanhtml]" value="1"<?=$r['docanhtml']==1?' checked':''?>>
֧��¼��HTML��
<input name="gr[doinfofile]" type="checkbox" id="gr[doinfofile]" value="1"<?=$r['doinfofile']==1?' checked':''?>>
�޸��ļ���Ȩ��</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>��Ŀ����</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td width="33%" height="23"><input name="gr[doclass]" type="checkbox" id="gr[doclass]2" value="1"<?=$doclass?>>
                    ��Ŀ����</td>
                  <td width="33%" height="23"><input name="gr[dozt]" type="checkbox" id="gr[doclass]3" value="1"<?=$dozt?>>
                    ר�����</td>
                  <td width="33%" height="23"><input name="gr[docj]" type="checkbox" id="gr[docj]2" value="1"<?=$docj?>>
                    �ɼ�����</td>
                </tr>
                <tr> 
                  <td width="33%" height="23"><input name="gr[dodelclass]" type="checkbox" id="gr[dodelclass]" value="1"<?=$r['dodelclass']==1?' checked':''?>>
ɾ����Ŀ</td>
                  <td width="33%" height="23"><input name="gr[dosetmclass]" type="checkbox" id="gr[dosetmclass]" value="1"<?=$dosetmclass?>>
                    ����������Ŀ����</td>
                  <td width="33%" height="23"><input name="gr[doloadcj]" type="checkbox" id="gr[doloadcj]" value="1"<?=$r[doloadcj]==1?' checked':''?>>
�ɼ��������뵼��</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[domovenews]" type="checkbox" id="gr[domovenews]" value="1"<?=$domovenews?>>
                    ����ת����Ϣ</td>
                  <td height="23"><input name="gr[dorepnewstext]" type="checkbox" id="gr[dorepnewstext]2" value="1"<?=$dorepnewstext?>>
                    �����滻�ֶ�ֵ</td>
                  <td height="23"><input name="gr[dodelinfodata]" type="checkbox" id="gr[dodelinfodata]" value="1"<?=$dodelinfodata?>>
                    ����ɾ����Ϣ</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[dofile]" type="checkbox" id="gr[dofile]2" value="1"<?=$dofile?>>
                    ��������</td>
                  <td height="23"><input name="gr[dototaldata]" type="checkbox" id="gr[dototaldata]2" value="1"<?=$dototaldata?>>
                    ͳ����Ϣ����</td>
                  <td height="23"><input name="gr[dosearchkey]" type="checkbox" id="gr[dosearchkey]2" value="1"<?=$dosearchkey?>>
                    �����ؼ���</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[dovotemod]" type="checkbox" id="gr[dovotemod]" value="1"<?=$dovotemod?>>
                    Ԥ��ͶƱ����</td>
                  <td height="23"><input name="gr[dowap]" type="checkbox" id="gr[dowap]" value="1"<?=$dowap?>>
                    WAP����</td>
                  <td height="23"><input name="gr[dosearchall]" type="checkbox" id="gr[dosearchall]" value="1"<?=$r[dosearchall]==1?' checked':''?>>
                    ȫվ����</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[doinfotype]" type="checkbox" value="1"<?=$r[doinfotype]==1?' checked':''?>>
                    ����������</td>
                  <td height="23"><input name="gr[dopltable]" type="checkbox" id="gr[dopltable]" value="1"<?=$r[dopltable]==1?' checked':''?>>
                    �������۷ֱ�</td>
                  <td height="23"><input name="gr[doplf]" type="checkbox" id="gr[doplf]" value="1"<?=$r[doplf]==1?' checked':''?>>
                    �����Զ����ֶ�</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[dotags]" type="checkbox" id="gr[dotags]" value="1"<?=$r[dotags]==1?' checked':''?>>
                    TAGS����</td>
                  <td height="23"><input name="gr[dosp]" type="checkbox" id="gr[dosp]" value="1"<?=$r[dosp]==1?' checked':''?>>
                    ��Ƭ����</td>
                  <td height="23"><input name="gr[doclassf]" type="checkbox" id="gr[doclassf]" value="1"<?=$r[doclassf]==1?' checked':''?>>
                    ��Ŀ�Զ����ֶ�</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[doztf]" type="checkbox" id="gr[doztf]" value="1"<?=$r[doztf]==1?' checked':''?>>
                    ר���Զ����ֶ�</td>
                  <td height="23"><input name="gr[douserpage]" type="checkbox" id="gr[douserpage]" value="1"<?=$douserpage?>>
                    �Զ���ҳ�����</td>
                  <td height="23"><input name="gr[douserlist]" type="checkbox" value="1"<?=$douserlist?>>
                    �Զ����б����</td>
                </tr>
                <tr> 
                  <td height="22"><input name="gr[douserjs]" type="checkbox" value="1"<?=$douserjs?>>
                    �Զ���JS����</td>
                  <td><input name="gr[dofiletable]" type="checkbox" id="gr[dofiletable]" value="1"<?=$r['dofiletable']==1?' checked':''?>>
                    �����ֱ����</td>
                  <td><input name="gr[doinfodoc]" type="checkbox" id="gr[doinfodoc]" value="1"<?=$doinfodoc?>>
�����鵵��Ϣ</td>
                </tr>
                <tr>
                  <td height="22"><input name="gr[dopl]" type="checkbox" id="gr[dopl]" value="1"<?=$dopl?>>
���۹���</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>ģ�����</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td width="33%" height="23"><font color="#FF0000"> 
                    <input name="gr[dobq]" type="checkbox" id="gr[dobq]2" value="1"<?=$dobq?>>
                    </font>��ǩ���� </td>
                  <td width="33%"><input name="gr[dotemplate]" type="checkbox" id="gr[dotemplate]" value="1"<?=$dotemplate?>>
                    ģ�����</td>
                  <td width="33%"><input name="gr[dotempvar]" type="checkbox" id="gr[dotempvar]" value="1"<?=$dotempvar?>>
                    ģ���������</td>
                </tr>
                <tr> 
                  <td height="22"><input name="gr[dotempgroup]" type="checkbox" id="gr[dotempgroup]2" value="1"<?=$dotempgroup?>>
                    ģ�������</td>
                  <td><input name="gr[dodttemp]" type="checkbox" id="gr[dodttemp]" value="1"<?=$r['dodttemp']==1?' checked':''?>>
��̬ҳ��ģ�����</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>�û����</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td width="33%" height="23"><input name="gr[dogroup]" type="checkbox" id="gr[dogroup]2" value="1"<?=$dogroup?>>
                    �û������</td>
                  <td width="33%"><input name="gr[douser]" type="checkbox" id="gr[douser]2" value="1"<?=$douser?>>
                    �û�����</td>
                  <td width="33%"><input name="gr[dolog]" type="checkbox" id="gr[dolog]" value="1"<?=$dolog?>>
                    ��־����</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[domember]" type="checkbox" id="gr[domember]3" value="1"<?=$domember?>>
                    ��Ա����</td>
                  <td><input name="gr[domemberf]" type="checkbox" value="1"<?=$domemberf?>>
                    ��Ա�ֶι���</td>
                  <td><input name="gr[docard]" type="checkbox" id="gr[docard]3" value="1"<?=$docard?>>
                    �㿨����</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[doadminstyle]" type="checkbox" id="gr[doadminstyle]4" value="1"<?=$doadminstyle?>>
                    ��̨������</td>
                  <td><input name="gr[dospacestyle]" type="checkbox" id="gr[dospacestyle]3" value="1"<?=$dospacestyle?>>
                    ��Ա�ռ�ģ�����</td>
                  <td><input name="gr[dosendemail]" type="checkbox" id="gr[dosendemail]3" value="1"<?=$dosendemail?>>
                    ���������ʼ�</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[domsg]" type="checkbox" value="1"<?=$domsg?>>
                    վ�ڶ���Ϣ����</td>
                  <td><input name="gr[dospacedata]" type="checkbox" value="1"<?=$dospacedata?>>
                    ��Ա�ռ����ݹ���</td>
                  <td><input name="gr[dobuygroup]" type="checkbox" value="1"<?=$r[dobuygroup]==1?' checked':''?>>
                    ��ֵ���͹���</td>
                </tr>
                <tr>
                  <td height="23"><input name="gr[dochadminstyle]" type="checkbox" id="gr[dochadminstyle]" value="1"<?=$r[dochadminstyle]==1?' checked':''?>>
                    �ı��̨���</td>
                  <td><input name="gr[douserclass]" type="checkbox" id="gr[douserclass]" value="1"<?=$r[douserclass]==1?' checked':''?>>
                    ���Ź���</td>
                  <td><input name="gr[domemberconnect]" type="checkbox" id="gr[domemberconnect]" value="1"<?=$r[domemberconnect]==1?' checked':''?>>
�ⲿ��¼����</td>
                </tr>
                <tr>
                  <td height="23"><input name="gr[doingroup]" type="checkbox" id="gr[doingroup]" value="1"<?=$r[doingroup]==1?' checked':''?>>
��Ա�ڲ������</td>
                  <td><input name="gr[domembergroup]" type="checkbox" id="gr[domembergroup]" value="1"<?=$r[domembergroup]==1?' checked':''?>>
��Ա�����</td>
                  <td><input name="gr[doviewgroup]" type="checkbox" id="gr[doviewgroup]" value="1"<?=$r[doviewgroup]==1?' checked':''?>>
��Ա���������</td>
                </tr>
                <tr>
                  <td height="23"><input name="gr[domadmingroup]" type="checkbox" id="gr[domadmingroup]" value="1"<?=$r[domadmingroup]==1?' checked':''?>>
��Ա���������</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>�������</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td width="33%" height="23"><input name="gr[doad]" type="checkbox" id="gr[doad]" value="1"<?=$doad?>>
                    ������</td>
                  <td width="33%"><input name="gr[dovote]" type="checkbox" id="gr[dovote]2" value="1"<?=$dovote?>>
                    ͶƱ����</td>
                  <td width="33%"><input name="gr[dolink]" type="checkbox" id="gr[dolink]2" value="1"<?=$dolink?>>
                    �������ӹ���</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[dogbook]" type="checkbox" id="gr[dogbook]2" value="1"<?=$dogbook?>>
                    ���Թ���</td>
                  <td><input name="gr[dofeedback]" type="checkbox" id="gr[dofeedback]2" value="1"<?=$dofeedback?>>
                    ������Ϣ����</td>
                  <td><input name="gr[dofeedbackf]" type="checkbox" id="gr[dofeedbackf]2" value="1"<?=$dofeedbackf?>>
                    �Զ��巴���ֶ�</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[donotcj]" type="checkbox" id="gr[donotcj]" value="1"<?=$donotcj?>>
                    ���ɼ�����ַ�����</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>��������</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td width="33%" height="23"><input name="gr[dobefrom]" type="checkbox" id="gr[dobefrom]" value="1"<?=$dobefrom?>>
                    ��Ϣ��Դ����</td>
                  <td width="33%" height="23"><input name="gr[dowriter]" type="checkbox" id="gr[dowriter]" value="1"<?=$dowriter?>>
                    ���߹���</td>
                  <td width="33%" height="23"><input name="gr[dokey]" type="checkbox" id="gr[dokey]2" value="1"<?=$dokey?>>
                    ���ݹؼ��ֹ���</td>
                </tr>
                <tr> 
                  <td width="33%" height="23"><input name="gr[doword]" type="checkbox" id="gr[doword]2" value="1"<?=$doword?>>
                    �����ַ�����</td>
                  <td width="33%" height="23"><input name="gr[dodownurl]" type="checkbox" id="gr[dodownurl]2" value="1"<?=$dodownurl?>>
                    ���ص�ַǰ׺����</td>
                  <td width="33%" height="23"><input name="gr[dodeldownrecord]" type="checkbox" id="gr[dodeldownrecord]2" value="1"<?=$dodeldownrecord?>>
                    ɾ�����ؼ�¼</td>
                </tr>
                <tr> 
                  <td width="33%" height="23"><input name="gr[dodownerror]" type="checkbox" id="gr[dodownerror]2" value="1"<?=$dodownerror?>>
                    ���󱨸����</td>
                  <td width="33%" height="23"><input name="gr[dorepdownpath]" type="checkbox" id="gr[dorepdownpath]" value="1"<?=$dorepdownpath?>>
                    �����滻��ַȨ��</td>
                  <td width="33%" height="23"><input name="gr[doplayer]" type="checkbox" id="gr[doplayer]" value="1"<?=$doplayer?>>
                    ��Ӱ����������</td>
                </tr>
                <tr> 
                  <td height="23"><input name="gr[doshopps]" type="checkbox" id="gr[doshopps]" value="1"<?=$doshopps?>>
                    �̳����ͷ�ʽ����</td>
                  <td height="23"><input name="gr[doshoppayfs]" type="checkbox" id="gr[doshoppayfs]" value="1"<?=$doshoppayfs?>>
                    �̳�֧����ʽ����</td>
                  <td height="23"><input name="gr[doshopdd]" type="checkbox" id="gr[doshopdd]" value="1"<?=$doshopdd?>>
                    �̳Ƕ�������</td>
                </tr>
                <tr>
                  <td height="23"><input name="gr[dopicnews]" type="checkbox" id="gr[dopicnews]" value="1"<?=$dopicnews?>>
                    ͼƬ��Ϣ����</td>
                  <td height="23"><input name="gr[dopay]" type="checkbox" id="gr[dopay]" value="1"<?=$dopay?>>
                    ����֧������</td>
                  <td height="23"><input name="gr[doprecode]" type="checkbox" id="gr[doprecode]" value="1"<?=$r[doprecode]==1?' checked':''?>>
�̳��Ż������</td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����">
        <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        ѡ��ȫ��</td>
    </tr>
  </table>
</form>
</body>
</html>
