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

$sql=$empire->query("select bqname,bqsay,funname,bq,issys,bqgs from {$dbtbpre}enewsbq where isclose=0 order by myorder desc,bqid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�۹���վ����ϵͳ��ǩ˵��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script language="javascript">
window.resizeTo(760,600);
window.focus();
</script>
</head>
<body>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr> 
      <td id='bqnav'></td>
    </tr>
  </table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr> 
    <td colspan="2" class="header">��Ϣ��ǩ���ò�������</td>
  </tr>
  <tr> 
    <td width="50%" bgcolor="#FFFFFF"> <table width="100%" border="0">
        <tr> 
          <td width="12%" rowspan="6" bgcolor="dbeaf5"> <div align="center"><strong>��<br>
              ��<br>
              Ŀ<br>
              ��<br>
              ��</strong></div></td>
          <td width="16%" height="20"><div align="center"><strong>0</strong></div></td>
          <td width="72%">��Ŀ������Ϣ <font color="#666666">(��ĿID=��ĿID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>1</strong></div></td>
          <td>��Ŀ������� <font color="#666666">(��ĿID=��ĿID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>2</strong></div></td>
          <td>��Ŀ�Ƽ���Ϣ <font color="#666666">(��ĿID=��ĿID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>9</strong></div></td>
          <td>��Ŀ�������� <font color="#666666">(��ĿID=��ĿID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>12</strong></div></td>
          <td>��Ŀͷ����Ϣ <font color="#666666">(��ĿID=��ĿID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>15</strong></div></td>
          <td>��Ŀ�������� <font color="#666666">(��ĿID=��ĿID)</font></td>
        </tr>
      </table></td>
    <td bgcolor="#FFFFFF"> <table width="100%" border="0">
        <tr> 
          <td width="11%" rowspan="6" bgcolor="dbeaf5"> <div align="center"><strong>��<br>
              Ĭ<br>
              ��<br>
              ��<br>
              ��<br>
              ��</strong></div></td>
          <td width="16%" height="20"><div align="center"><strong>3</strong></div></td>
          <td width="73%">Ĭ�ϱ�������Ϣ <font color="#666666">(��ĿID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>4</strong></div></td>
          <td>Ĭ�ϱ������� <font color="#666666">(��ĿID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>5</strong></div></td>
          <td>Ĭ�ϱ��Ƽ���Ϣ <font color="#666666">(��ĿID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>10</strong></div></td>
          <td>Ĭ�ϱ��������� <font color="#666666">(��ĿID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>13</strong></div></td>
          <td>Ĭ�ϱ�ͷ����Ϣ <font color="#666666">(��ĿID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>16</strong></div></td>
          <td>Ĭ�ϱ��������� <font color="#666666">(��ĿID=0)</font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="100%" border="0">
      <tr>
        <td width="12%" rowspan="6" bgcolor="dbeaf5"><div align="center"><strong>��<br>
          ��<br>
          ��<br>
          ��<br>
          ��<br>
          ��<br>
          ��</strong></div></td>
        <td width="16%" height="20"><div align="center"><strong>25</strong></div></td>
        <td width="72%">�������������Ϣ <font color="#666666">(��ĿID=�������ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>26</strong></div></td>
        <td>������������� <font color="#666666">(��ĿID=�������ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>27</strong></div></td>
        <td>��������Ƽ���Ϣ <font color="#666666">(��ĿID=�������ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>28</strong></div></td>
        <td>��������������� <font color="#666666">(��ĿID=�������ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>29</strong></div></td>
        <td>�������ͷ����Ϣ <font color="#666666">(��ĿID=�������ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>30</strong></div></td>
        <td>��������������� <font color="#666666">(��ĿID=�������ID)</font></td>
      </tr>
    </table></td>
    <td bgcolor="#FFFFFF"> <table width="100%" border="0">
        <tr> 
          <td width="11%" rowspan="6" bgcolor="dbeaf5"> <div align="center"><strong>��<br>
              ��<br>
              ��<br>
              ��<br>
              ��<br>
              ��</strong></div></td>
          <td width="16%" height="20"><div align="center"><strong>18</strong></div></td>
          <td width="73%">����������Ϣ <font color="#666666">(��ĿID='����')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>19</strong></div></td>
          <td>����������<font color="#666666"> (��ĿID='����')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>20</strong></div></td>
          <td>�����Ƽ���Ϣ <font color="#666666">(��ĿID='����')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>21</strong></div></td>
          <td>������������ <font color="#666666">(��ĿID='����')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>22</strong></div></td>
          <td>����ͷ����Ϣ <font color="#666666">(��ĿID='����')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>23</strong></div></td>
          <td>������������ <font color="#666666">(��ĿID='����')</font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="100%" border="0">
      <tr>
        <td width="12%" rowspan="6" bgcolor="dbeaf5"><div align="center"><strong>��<br>
          S<br>
          Q<br>
          L<br>
          ��<br>
          ��</strong></div></td>
        <td width="15%" height="20" rowspan="2"><div align="center"><strong>24</strong></div></td>
        <td width="73%" height="20">��sql��ѯ <font color="#666666">(��ĿID='sql���')</font></td>
      </tr>
      <tr>
        <td height="20"><font color="#666666">���ݱ�ǰ׺���ã���[!db.pre!]&quot;��ʾ</font></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<br>
<?
$bqnav="";
while($r=$empire->fetch($sql))
{
	$bqnav.="<option value='".$r['bq']."'>".$r['bqname']."(".$r['bq'].")</option>";
	$r['bqsay']=str_replace('[!--ehash--]',$ecms_hashur['ehref'],$r['bqsay']);
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="<?=$r[bq]?>">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b><?=$r[bqname]?>&nbsp;(<?=$r[bq]?>)</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td>
<input type=text name="text" size=80 value="<?=stripSlashes($r[bqgs])?>" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td>����˵����</td>
        </tr>
        <tr> 
          <td><?=stripSlashes($r[bqsay])?></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<?
}
$bqnav="<select name='bq' id='bq' onchange=window.location='#'+this.options[this.selectedIndex].value><option value='' selected style='background:#99C4E3'>��ǩ����</option>".$bqnav."<option value='eloop'>�鶯��ǩ (e:loop)</option><option value='eindexloop'>�����鶯��ǩ (e:indexloop)</option><option value='ShowMemberInfo'>��Ա��Ϣ���ú���</option><option value='ListMemberInfo'>��Ա�б���ú���</option><option value='spaceeloop'>��Ա�ռ���Ϣ���ú���</option><option value='wapeloop'>WAP��Ϣ���ú���</option><option value='echeckloginauth'>��֤��Ա��¼�뷵�ص�¼��Ϣ����</option><option value='echeckmembergroup'>��֤��Ա����Ȩ�޺���</option><option value='resizeimg'>������ͼ����</option><option value='egetzy'>ת���ַ�����</option><option value='enewshowmorepic'>��ʾͼ������(ȫ����)</option><option value='emoreplayer'>��ʾ��Ƶ������JS����</option></select>";
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eloop">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>�鶯��ǩ&nbsp;(e:loop)</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td width="86%"><textarea name="text" cols="80" rows="4" style="width:100%">[e:loop={��ĿID,��ʾ����,��������,ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����}]
ģ���������
[/e:loop]</textarea></td>
        </tr>
        <tr>
          <td>����:</td>
          <td><textarea name="textarea" cols="80" rows="9" style="width:100%">&lt;table width="100%" border="0" cellspacing="1" cellpadding="3"&gt;
[e:loop={��ĿID,��ʾ����,��������,ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����}]
&lt;tr&gt;&lt;td&gt;
&lt;a href="&lt;?=$bqsr[titleurl]?&gt;" target="_blank"&gt;&lt;?=$bqr[title]?&gt;&lt;/a&gt;
(&lt;?=date('Y-m-d',$bqr[newstime])?&gt;)
&lt;/td&gt;&lt;/tr&gt;
[/e:loop]
&lt;/table&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td height="23"><strong>��ǩ˵��</strong></td>
        </tr>
        <tr> 
          <td height="23">�鶯��ǩ����������ǩģ�壬��ģ������ΪPHP���룬�����������ʹ��php���д�������<font color="#666666">ʹ�ñ���ǩ���迪��ģ��֧�ֳ������(��������)��</font></td>
        </tr>
        <tr> 
          <td height="23"><strong>����</strong></td>
        </tr>
        <tr> 
          <td><table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td width="23%"> 
                    <div align="center">����</div></td>
                  <td>����˵��</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">��ĿID</div></td>
                  <td height="25">�鿴��ĿID��<a onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');"><strong><u>����</u></strong></a>���鿴�������ID��<a onclick="window.open('../info/InfoType.php<?=$ecms_hashur['whehref']?>');"><strong><u>����</u></strong></a>,��ǰID='selfinfo'<br />
                    �����ĿID��������ID���á�,�����Ÿ������磺'1,2'</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">��ʾ����</div></td>
                  <td height="25">��ʾǰ������¼</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">��������</div></td>
                  <td height="25">���忴��������˵��</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">ֻ��ʾ�б���ͼƬ</div></td>
                  <td height="25">0Ϊ�����ƣ�1Ϊֻ��ʾ�б���ͼƬ����Ϣ</td>
                </tr>
				<tr bgcolor="#ffffff">
            		<td height="25">
            			<div align="center">����SQL����</div>
            		</td>
            		<td height="25">���ӵ����������磺&quot;title='�۹�'&quot;</td>
        		</tr>
        		<tr bgcolor="#ffffff">
            		<td height="25">
            			<div align="center">��ʾ����</div>
            		</td>
            		<td height="25">��ָ������Ӧ���ֶ������磺&quot;id desc&quot;</td>
        		</tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td><strong>����˵��</strong></td>
        </tr>
        <tr>
          <td height="139">
<table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td height="25"><div align="center">��������</div></td>
                  <td height="25">˵��</td>
                </tr>
                <tr> 
                  <td width="23%" height="25" bgcolor="#ffffff"> <div align="center">$bqr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqr[�ֶ���]����ʾ�ֶε�����</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"> <div align="center">$bqsr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqsr[titleurl]����������<br>
                    $bqsr[classname]����Ŀ����<br>
                    $bqsr[classurl]����Ŀ����</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"><div align="center">$bqno</div></td>
                  <td height="25" bgcolor="#ffffff">$bqno��Ϊ�������</td>
                </tr>
                <tr>
                  <td height="25" bgcolor="#ffffff"><div align="center">$public_r</div></td>
                  <td height="25" bgcolor="#ffffff">$public_r[newsurl]����վ��ַ</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr> 
          <td><strong>���ú�������</strong></td>
        </tr>
        <tr> 
          <td>���ֽ�ȡ��<strong>esub(�ַ���,��ȡ����)</strong>�����ӣ�esub($bqr[title],30)��ȡ����ǰ30���ַ�<br>
            ʱ���ʽ��<strong>date('��ʽ�ִ�',ʱ���ֶ�)</strong>�����ӣ�date('Y-m-d',$bqr[newstime])ʱ����ʾ��ʽΪ&quot;2008-10-01&quot;</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eindexloop">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>�����鶯��ǩ&nbsp;(e:indexloop)</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td width="86%"><textarea name="textarea4" cols="80" rows="4" style="width:100%">[e:indexloop={��������ID,��ʾ����,��������,��ĿID,ϵͳģ��ID,����SQL����}]
ģ���������
[/e:indexloop]</textarea></td>
        </tr>
        <tr> 
          <td>����:</td>
          <td><textarea name="textarea4" cols="80" rows="9" style="width:100%">&lt;table width="100%" border="0" cellspacing="1" cellpadding="3"&gt;
[e:indexloop={��������ID,��ʾ����,��������,��ĿID,ϵͳģ��ID,����SQL����}]
&lt;tr&gt;&lt;td&gt;
&lt;a href="&lt;?=$bqsr[titleurl]?&gt;" target="_blank"&gt;&lt;?=$bqr[title]?&gt;&lt;/a&gt;
(&lt;?=date('Y-m-d',$bqr[newstime])?&gt;)
&lt;/td&gt;&lt;/tr&gt;
[/e:indexloop]
&lt;/table&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td height="23"><strong>��ǩ˵��</strong></td>
        </tr>
        <tr> 
          <td height="23">�����鶯��ǩʹ�÷�������ͬ�鶯��ǩ��ֻ�������鶯��ǩ������ϢID����ĿID����ȡ��Ϣ���ݡ�<font color="#666666">ʹ�ñ���ǩ���迪��ģ��֧�ֳ������(��������)��</font></td>
        </tr>
        <tr> 
          <td height="23"><strong>����</strong></td>
        </tr>
        <tr> 
          <td><table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td width="23%"> <div align="center">����</div></td>
                  <td>����˵��</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">��������ID</div></td>
                  <td height="25">�鿴ר��ID��<a onclick="window.open('../special/ListZt.php<?=$ecms_hashur['whehref']?>');"><strong><u>����</u></strong></a>,�鿴TAGS��ID��<a onclick="window.open('../tags/ListTags.php<?=$ecms_hashur['whehref']?>');"><strong><u>����</u></strong></a>���鿴��ƬID��<a onclick="window.open('../sp/ListSp.php<?=$ecms_hashur['whehref']?>');"><strong><u>����</u></strong></a>����ǰר��ID='selfinfo'<br />
                    ���ID���á�,�����Ÿ������磺'1,2'</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">��ʾ����</div></td>
                  <td height="25">��ʾǰ������¼</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">��������</div></td>
                  <td height="25"> 1��ר������ <font color="#666666">(��������ID=ר��ID)</font><br>
                    2��ר������ <font color="#666666">(��������ID=ר��ID)</font><br>
                    3��ר���Ƽ� <font color="#666666">(��������ID=ר��ID)</font><br>
                    4��ר���������� <font color="#666666">(��������ID=ר������ID)</font><br>
                    5��ר���������� <font color="#666666">(��������ID=ר������ID)</font><br>
                    6��ר�������Ƽ� <font color="#666666">(��������ID=ר������ID)</font><br>
                    7����Ƭ���� <font color="#666666">(��������ID=��ƬID)</font><br>
8����Ƭ���� <font color="#666666">(��������ID=��ƬID)</font><br>
                    9��TAGS���� <font color="#666666">(��������ID=TAGS��ID)</font><br>
                    10��TAGS���� <font color="#666666">(��������ID=TAGS��ID)</font><br>
                    11��SQL���� <font color="#666666">(��������ID='sql���') [���ݱ�ǰ׺���ã���[!db.pre!]&quot;��ʾ]</font></td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">��ĿID</div></td>
                  <td height="25">����ֻ����ĳһ��������Ŀ����Ϣ<br>
                    ���ID�����á�,���Ÿ������磺'1,2'</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">ϵͳģ��ID</div></td>
                  <td height="25">����ֻ����ĳһ������ϵͳģ�͵���Ϣ<br>
                    ���ID�����á�,���Ÿ������磺'1,2'<br>
                    <font color="#FF0000">�˲�������Ƭ������Ч����Ƭ����ʱ��ѱ���������Ϊ�գ�''</font></td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"> <div align="center">����SQL����</div></td>
                  <td height="25">���ӵ����������磺&quot;isgood=1&quot;</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr> 
          <td><strong>����˵��</strong></td>
        </tr>
        <tr> 
          <td height="139"> <table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td height="25"><div align="center">��������</div></td>
                  <td height="25">˵��</td>
                </tr>
                <tr>
                  <td height="25" bgcolor="#ffffff"><div align="center">$indexbqr</div></td>
                  <td height="25" bgcolor="#ffffff">$indexbqr[�ֶ���]����ʾ��������ֶ����ݣ���ר������ID��$indexbqr[cid]</td>
                </tr>
                <tr> 
                  <td width="23%" height="25" bgcolor="#ffffff"> <div align="center">$bqr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqr[�ֶ���]����ʾ��Ϣ���ֶε����ݣ�����⣺$bqr[title]</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"> <div align="center">$bqsr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqsr[titleurl]����������<br>
                    $bqsr[classname]����Ŀ����<br>
                    $bqsr[classurl]����Ŀ����</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"><div align="center">$bqno</div></td>
                  <td height="25" bgcolor="#ffffff">$bqno��Ϊ�������</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"><div align="center">$public_r</div></td>
                  <td height="25" bgcolor="#ffffff">$public_r[newsurl]����վ��ַ</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr> 
          <td><strong>���ú�������</strong></td>
        </tr>
        <tr> 
          <td>���ֽ�ȡ��<strong>esub(�ַ���,��ȡ����)</strong>�����ӣ�esub($bqr[title],30)��ȡ����ǰ30���ַ�<br>
            ʱ���ʽ��<strong>date('��ʽ�ִ�',ʱ���ֶ�)</strong>�����ӣ�date('Y-m-d',$bqr[newstime])ʱ����ʾ��ʽΪ&quot;2012-10-01&quot;</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ShowMemberInfo">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>��Ա��Ϣ���ú���</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td>
<input type=text name="text" size=80 value="sys_ShowMemberInfo(�û�ID,��ѯ�ֶ�)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td>�û�ID������Ҫ���õĻ�Ա��Ϣ���û�ID������Ϣ����ҳ�µ��ÿ�������Ϊ0����ʾ������Ϣ�����ߵ����ϡ�<br>
            ��ѯ�ֶΣ�Ĭ��Ϊ��ѯ���л�Ա�ֶΣ��˲���һ�㲻�����ã����Ϊ��Ч�ʸ��߿���ָ����Ӧ���ֶΡ��磺��u.userid,ui.company��(uΪ����uiΪ����)��<br>
            <strong>ʹ�ý̳̣�</strong><a href="http://bbs.phome.net/showthread-13-108558-0.html" target="_blank">http://bbs.phome.net/showthread-13-108558-0.html</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ListMemberInfo">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>��Ա�б���ú���</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td>
<input type=text name="text" size=80 value="sys_ListMemberInfo(��������,��������,��Ա��ID,�û�ID,��ѯ�ֶ�)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td>��������������ǰ������¼��<br>
            �������ͣ�0Ϊ��ע��ʱ�䡢1Ϊ���������С�2Ϊ���ʽ����С�3Ϊ����Ա�ռ���������<br>
            ��Ա��ID��ָ��Ҫ���õĻ�Ա��ID��������Ϊ���ޣ������Ա���ö��Ÿ������磺'1,2'<br>
            �û�ID��ָ��Ҫ���õĻ�ԱID��������Ϊ���ޣ�����û�ID�ö��Ÿ������磺'25,27'<br>
            ��ѯ�ֶΣ�Ĭ��Ϊ��ѯ���л�Ա�ֶΣ��˲���һ�㲻�����ã����Ϊ��Ч�ʸ��߿���ָ����Ӧ���ֶΡ��磺��u.userid,ui.company��(uΪ����uiΪ����)��<br>
            <strong>ʹ�ý̳̣�</strong><a href="http://bbs.phome.net/showthread-13-108558-0.html" target="_blank">http://bbs.phome.net/showthread-13-108558-0.html</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="spaceeloop">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>��Ա�ռ���Ϣ���ú���</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <textarea name="textarea2" cols="80" rows="11" style="width:100%">&lt;?php
$spacesql=espace_eloop(��ĿID,��ʾ����,��������,ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����);
while($spacer=$empire->fetch($spacesql))
{
        $spacesr=espace_eloop_sp($spacer);
?&gt;
ģ���������
&lt;?
}
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td> <strong>ʹ�ý̳̣�</strong><a href="http://bbs.phome.net/showthread-13-109152-0.html" target="_blank">http://bbs.phome.net/showthread-13-109152-0.html</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="wapeloop">
  <tr>
    <td class="header"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr class="header">
        <td width="14%">��ǩ���ƣ�</td>
        <td width="86%"><b>WAP��Ϣ���ú���</b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">��ʽ:</td>
        <td><textarea name="textarea7" cols="80" rows="11" style="width:100%">&lt;?php
$wapsql=ewap_eloop(��ĿID,��ʾ����,��������,ֻ��ʾ�б���ͼƬ,����SQL����,��ʾ����);
while($wapr=$empire->fetch($wapsql))
{
        $wapsr=ewap_eloop_sp($wapr);
?&gt;
ģ���������
&lt;?
}
?&gt;</textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td>�������������鶯��ǩ��ȫһ�������õ�����Ҳ��һ����֧���鶯��ǩ�����в������ͣ�<br>
          ��$wapr[�ֶ���]����ͬ���鶯��ǩ��$bqr[�ֶ���]��������<br>
          ��$wapsr����ͬ���鶯��ǩ��$bqsr����������$wapsr[titleurl]���������ӡ�$wapsr[classname]����Ŀ���ơ�$wapsr[classurl]����Ŀ���ӣ�</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="echeckloginauth">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>Cookie��֤��Ա��¼�뷵�ص�¼��Ϣ����</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <input type=text name="text22" size=80 value="qCheckLoginAuthstr()" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <textarea name="textarea3" cols="80" rows="9" style="width:100%">&lt;?php
$user=qCheckLoginAuthstr();
if(!$user['islogin'])
{
echo"����δ��¼";
exit();
}
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td>���������ش��û���Ϣ�����飺<br>
                �����islogin(0Ϊδ��¼,1Ϊ�ѵ�¼)��userid(�û�ID)��username(�û���)��groupid(��Ա��ID)</td>
              </tr>
            </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="echeckmembergroup">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>��֤��Ա����Ȩ�޺���</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <input type=text name="text22" size=80 value="sys_CheckMemberGroup(���Ʒ��ʵĻ�Ա��ID)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <textarea name="textarea3" cols="80" rows="9" style="width:100%">&lt;?php
$levelst=sys_CheckMemberGroup('1,4');
if($levelst<=0)
{
echo"��û��Ȩ��";
exit();
}
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td>��������֤��ǰ��¼��Ա�Ƿ��з���Ȩ�޺�����sys_CheckMemberGroup(���Ʒ��ʵĻ�Ա��ID)�����ƶ����Ա��ID���ö��Ÿ�����<br>
                ����0��δ��¼������-1��ΪûȨ�ޣ�����0Ϊ��Ȩ�ޡ�</td>
              </tr>
            </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="resizeimg">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>������ͼ����</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <input type=text name="text2" size=80 value="sys_ResizeImg(ԭͼƬ,��ͼ���,��ͼ�߶�,�Ƿ����ͼƬ,Ŀ���ļ���,Ŀ��Ŀ¼��)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <textarea name="textarea2" cols="80" rows="5" style="width:100%">&lt;?php
$resizeimgurl=sys_ResizeImg($bqr[titlepic],170,120,1,'','');
echo"&lt;img src='$resizeimgurl'&gt;";
?&gt;</textarea></td>
        </tr>
      </table> 
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td>ԭͼƬ��Ҫ������ͼ��Դ�ļ���<br>
            ��ͼ��ȡ���ͼ�߶ȣ�������ͼ�Ĺ��<br>
            �Ƿ����ͼƬ����������ͼ�󳬳��������²��ò��巽ʽ��<br>
            Ŀ���ļ����������ʡ�ԣ��������Ŀ���ļ��������Ǵ��ļ�������ֹ�ظ�������ʱͼƬ�ļ���<br>
            Ŀ��Ŀ¼���������ʡ�ԣ�Ĭ��Ϊ��e/data/tmp/titlepic/</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="egetzy">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">��ǩ���ƣ�</td>
          <td width="86%"><b>ת���ַ�����</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <input type=text name="text22" size=80 value="egetzy(ת���ַ�)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">��ʽ:</td>
          <td> <textarea name="textarea3" cols="80" rows="5" style="width:100%">&lt;?php
$zystr=egetzy('rn');
echo"$zystr";
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td>�����������û��ڵ���ģ��ʹ�÷�б��ת�壺<br>
                  (1)�������﷨��egetzy(ת���ַ�)<br>
            (2)��ת���ַ�rnתΪ\r\n��nתΪ\n��rתΪ\r��tתΪ\t��syhתΪ\&quot;��dyhתΪ\'<br>
                  (3)��ת���ַ�Ϊ���֣���תΪ��Ӧ������\�����磺2תΪ\\<br>
                  (4)���ָ�з����ӣ�$er=explode(egetzy('rn'),$navinfor[downpath]); </td>
              </tr>
            </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="enewshowmorepic">
  <tr>
    <td class="header"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr class="header">
        <td width="14%">��ǩ���ƣ�</td>
        <td width="86%"><b><strong>��ʾͼ������(ȫ����)</strong></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">��ʽ:</td>
        <td><input type=text name="text222" size=80 value="sys_ModShowMorepic(����Сͼ���,����Сͼ�߶�,Сͼ����ģ������)" style="width:100%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">����:</td>
        <td><textarea name="textarea5" cols="80" rows="5" style="width:100%">&lt;?=sys_ModShowMorepic(120,80,'')?&gt;</textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td><strong>ʹ�ý̳̣�</strong><a href="../../data/modadd/morepic/ReadMe.html" target="_blank">[�������鿴]</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="emoreplayer">
  <tr>
    <td class="header"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr class="header">
        <td width="14%">��ǩ���ƣ�</td>
        <td width="86%"><b><strong>��ʾ��Ƶ������JS����</strong></b></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">��ʽ:</td>
        <td><textarea name="textarea6" cols="80" rows="5" style="width:100%">&lt;script src=&quot;/e/data/modadd/moreplayer/empirecmsplayer.js&quot;&gt;&lt;/script&gt;
&lt;script&gt;
EmpireCMSPlayVideo('����������','��Ƶ��ַ','��ʾ���','��ʾ�߶�',�Ƿ��Զ�����,'�۹�CMS��վĿ¼��ַ');
&lt;/script&gt;</textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td><strong>ʹ�ý̳̣�</strong><a href="../../data/modadd/moreplayer/ReadMe.html" target="_blank">[�������鿴]</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<script>
document.getElementById("bqnav").innerHTML="<?=$bqnav?>";
</script>
</body>
</html>
<?
db_close();
$empire=null;
?>
