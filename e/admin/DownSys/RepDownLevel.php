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
CheckLevel($logininid,$loginin,$classid,"repdownpath");
$url="<a href=RepDownLevel.php".$ecms_hashur['whehref'].">�������ĵ�ַȨ��</a>";
//��Ŀ
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//���ݱ�
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
while($tr=$empire->fetch($tsql))
{
	$table.="<option value='".$tr[tbname]."'>".$tr[tname]."</option>";
}
$table="<select name='tbname'><option value='0'>--- ѡ�����ݱ� ---</option>".$table."</select>";
//������
$ygroup='';
$vgsql=$empire->query("select vgid,gname from {$dbtbpre}enewsvg order by vgid");
while($vgr=$empire->fetch($vgsql))
{
	$ygroup.="<option value=-".$vgr['vgid'].">".$vgr['gname']."</option>";
}
if($ygroup)
{
	$ygroup="<option value=''>--- ������ ---</option>".$ygroup."<option value=''>--- ��Ա�� ---</option>";
}
//----------��Ա��
$sql1=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	$ygroup.="<option value=".$l_r[groupid].">".$l_r[groupname]."</option>";
}
//----------��ַǰ׺
$qz="";
$downsql=$empire->query("select urlname,urlid from {$dbtbpre}enewsdownurlqz order by urlid");
while($downr=$empire->fetch($downsql))
{
	$qz.="<option value='".$downr[urlid]."'>".$downr[urlname]."</option>";
}

db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������ĵ�ַȨ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="../ecmscom.php" target="_blank" onsubmit="return confirm('ȷ��Ҫ������');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> <div align="center">������������/���ߵ�ַȨ�� 
          <input name="enews" type="hidden" id="enews" value="RepDownLevel">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="21%" height="25">�������ݱ�(*)��</td>
      <td width="79%" height="25"> 
        <?=$table?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������Ŀ��</td>
      <td height="25"><select name="classid" id="classid">
          <option value=0>������Ŀ</option>
          <?=$class?>
        </select>
        <font color="#666666"> (��ѡ�����Ŀ����Ӧ������������Ŀ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����ֶ�(*)��</td>
      <td height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td width="32%"><input name="downpath" type="checkbox" id="downpath" value="1">
              ���ص�ַ(downpath)</td>
            <td width="68%"><input name="onlinepath" type="checkbox" id="onlinepath" value="1">
              ���ߵ�ַ(onlinepath)</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">Ȩ��ת���� 
        <input name="dogroup" type="checkbox" id="dogroup" value="1"></td>
      <td height="25"><div align="left"> 
          <table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
            <tr> 
              <td width="49%"><div align="center">ԭ��Ա��</div></td>
              <td width="51%"><div align="center">�»�Ա��</div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td><div align="center"> 
                  <select name="oldgroupid" id="oldgroupid">
                    <option value="no">������</option>
                    <option value="0">�ο�</option>
					<?=$ygroup?>
                  </select>
                </div></td>
              <td><div align="center"> 
                  <select name="newgroupid" id="newgroupid">
                    <option value="0">�ο�</option>
					<?=$ygroup?>
                  </select>
                </div></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ת���� 
        <input name="dofen" type="checkbox" id="dofen" value="1"></td>
      <td height="25"><table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">ԭ����</div></td>
            <td width="51%"><div align="center">�µ���</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <input name="oldfen" type="text" id="oldfen" value="no" size="6">
              </div></td>
            <td><div align="center"> 
                <input name="newfen" type="text" id="newfen" value="0" size="6">
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ǰ׺ת���� 
        <input name="doqz" type="checkbox" id="doqz" value="1"></td>
      <td height="25"><table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">ԭǰ׺</div></td>
            <td width="51%"><div align="center">��ǰ׺</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <select name="oldqz" id="oldqz">
                  <option value="no">������</option>
				  <option value="0">��ǰ׺</option>
                  <?=$qz?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="newqz">
				<option value="0">��ǰ׺</option>
                  <?=$qz?>
                </select>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ַ�滻��
        <input name="dopath" type="checkbox" id="dopath" value="1"></td>
      <td height="25"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">ԭ���ص�ַ�ַ�</div></td>
            <td width="51%"><div align="center">�����ص�ַ�ַ�</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <input name="oldpath" type="text" id="oldpath">
              </div></td>
            <td><div align="center"> 
                <input name="newpath" type="text" id="newpath">
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�����滻��
        <input name="doname" type="checkbox" id="doname" value="1"></td>
      <td height="25"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">ԭ���������ַ�</div></td>
            <td width="51%"><div align="center">�����������ַ�</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <input name="oldname" type="text" id="oldname">
              </div></td>
            <td><div align="center"> 
                <input name="newname" type="text" id="newname">
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����SQL������</td>
      <td height="25"><input name="query" type="text" id="query" size="75"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><font color="#666666">�磺title='����' and writer='����'</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25">˵������ԭ����Ϊno����������Ϣ�ĵ�����Ϊ�µ��������ѡ��Ϊ�����ã���������Ϣ��Ϊ�µ�ֵ��<br>
        ע�⣺<font color="#FF0000">ʹ�ô˹��ܣ���ñ���һ�����ݣ��Է���һ</font></td>
    </tr>
  </table>
</form>
</body>
</html>
