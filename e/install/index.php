<?php
error_reporting(E_ALL ^ E_NOTICE);

@set_time_limit(1000);

define('InEmpireCMS',TRUE);

$ecms_config=array();
$ecms_config['db']['showerror']=1;
$link='';
$empire='';
$dbtbpre='';

//�����ļ�
require('data/fun.php');
require('../class/EmpireCMS_version.php');
if(function_exists('mysql_connect'))
{
	include('../class/db/db_mysql.php');
}
else
{
	include('../class/db/db_mysqli.php');
}

//------ ������ʼ ------

$char_r=array();
$char_r=InstallReturnDbChar();
$version="7.5,1502985610";
$dbchar=$char_r['dbchar'];
$setchar=$char_r['setchar'];
$headerchar=$char_r['headerchar'];

//------ �������� ------

@header('Content-Type: text/html; charset='.$headerchar);

if(file_exists("install.off"))
{
	echo"���۹���վ����ϵͳ����װ���������������Ҫ���°�װ����ɾ��<b>/e/install/install.off</b>�ļ���";
	exit();
}

$enews=$_GET['enews'];
if(empty($enews))
{
	$enews=$_POST['enews'];
}
//���Բɼ�
if($enews=="TestCj")
{
	echo"<title>TEST</title>";
	TestCj();
}
$ok=$_GET['ok'];
if(empty($ok))
{
	$ok=$_POST['ok'];
}
$f=$_GET['f'];
if(empty($f))
{
	$f=$_POST['f'];
}
if(empty($f))
{
	$f=1;
}
$font="f".$f;
$$font="red";
//����
if($enews=="setdb"&&$ok)
{
	SetDb($_POST);
}
elseif($enews=="firstadmin"&&$ok)
{
	FirstAdmin($_POST);
}
elseif($enews=="defaultdata"&&$ok)
{
	InstallDefaultData($_GET);
}
elseif($enews=="templatedata"&&$ok)
{
	InstallTemplateData($_GET);
}
elseif($enews=="moddata"&&$ok)
{
	InstallModData($_GET);
}

$shorttag=ini_get('short_open_tag');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�۹���վ����ϵͳ��װ���� - Powered by EmpireCMS</title>

<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="C9F1FF" leftmargin="0" topmargin="0">
<?php
if(!$shorttag)
{
?>
<br>
<br><br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr> 
    <td height="25" class="header"><div align="center"><strong><font color="#FFFFFF">������ʾ</font></strong></div></td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td height="25">����PHP�����ļ�php.ini���������⣬�밴����������ɽ����</td>
        </tr>
        <tr>
          <td height="25">1���޸�php.ini������short_open_tag ��Ϊ On</td>
        </tr>
        <tr>
          <td height="25">2���޸ĺ�����apache/iis������Ч��</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php
	echo"</body></html>";
	exit();
}
?>
<table width="776" height="100%" border="0" align="center" cellpadding="6" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td height="56" colspan="2" background="images/topbg.gif"> 
      <div align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80%"><div align="center"><img src="images/installsay.gif" width="500" height="50"></div></td>
            <td width="20%" valign="bottom"><font color="#FFFFFF">������: <?php echo EmpireCMS_LASTTIME;?></font></td>
          </tr>
        </table>
        
      </div></td>
  </tr>
  <tr> 
    <td width="21%" rowspan="3" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="http://www.phome.net" target="_blank"><img src="images/logo.gif" width="170" height="72" border="0"></a></div></td>
        </tr>
      </table>
      <br> 
	  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25" colspan="2"> <div align="left"><strong><font color="#FFFFFF">��Ȩ��Ϣ</font></strong></div></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="34%" height="25">�������</td>
          <td width="66%" height="25">�۹���վ����ϵͳ</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">Ӣ������</td>
          <td height="25">EmpireCMS</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">����汾</td>
          <td height="25">Version 7.5 </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">�����Ŷ�</td>
          <td height="25">�۹���������Ŷ�</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">��˾����</td>
          <td height="25">������ܼ�ǵ�������������޹�˾</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">�ٷ���վ</td>
          <td height="25"><a href="http://www.PHome.Net" target="_blank">www.PHome.Net</a></td>
        </tr>
      </table>
      <br> 
	  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25"><strong><font color="#FFFFFF">��װ����</font></strong></td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr> 
                <td><img src="images/noadd.gif" width="15" height="15">&nbsp;<font color="<?php echo $f1;?>">�Ķ��û�ʹ������</font></td>
              </tr>
              <tr> 
                <td><img src="images/noadd.gif" width="15" height="15">&nbsp;<font color="<?php echo $f2;?>">������л���</font></td>
              </tr>
              <tr> 
                <td><img src="images/noadd.gif" width="15" height="15">&nbsp;<font color="<?php echo $f3;?>">����Ŀ¼Ȩ��</font></td>
              </tr>
              <tr> 
                <td><img src="images/noadd.gif" width="15" height="15">&nbsp;<font color="<?php echo $f4;?>">�������ݿ�</font></td>
              </tr>
              <tr> 
                <td><img src="images/noadd.gif" width="15" height="15">&nbsp;<font color="<?php echo $f5;?>">��ʼ������Ա�˺�</font></td>
              </tr>
              <tr> 
                <td><img src="images/noadd.gif" width="15" height="15">&nbsp;<font color="<?php echo $f6;?>">��װ���</font></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td><div align="center"><strong><font color="#0000FF" size="3">�뵽�������� - �۹���վ����ϵͳ</font></strong></div></td>
  </tr>
  <tr> 
    <td valign="top"> 
    <?php
	//�û�����
	if($enews=="checkfj")
	{
	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">�ڶ�����������л���</font></strong></div></td>
          </tr>
          <tr> 
            <td height="350" bgcolor="#FFFFFF"> <div align="center"> 
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td height="23"><strong>��ʾ��Ϣ</strong></td>
                  </tr>
                  <tr> 
                    <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr> 
                          <td height="21"> <li>��������Ŀ�Ǳ���֧�ֵ���Ŀ��</li></td>
                        </tr>
                        <tr> 
                          <td height="21"> <li>��֧��GD�ⲻӰ��ϵͳ�������У���ͼƬ����ͼ��ˮӡ���ܲ���ʹ�á�</li></td>
                        </tr>
                        <tr> 
                          <td height="21"> <li>��֧�ֲɼ���Ӱ��ϵͳ����ʹ�ã����ɼ�������Զ�̱��渽����������ʹ�á�</li></td>
                        </tr>
                        <tr> 
                          <td height="21"> <li>�����֧�ֲɼ������ӿɶԲɼ����в��ԡ�</li></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <br>
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td width="25%" height="23"> <div align="center"><strong>��Ŀ</strong></div></td>
                    <td width="30%"> <div align="center"><strong>�۹�CMS��������</strong></div></td>
                    <td width="30%"> <div align="center"><strong>��ǰ������</strong></div></td>
                    <td width="15%"> <div align="center"><strong>���Խ��</strong></div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><div align="center">����ϵͳ</div></td>
                    <td><div align="center">����</div></td>
                    <td><div align="center"> 
                        <?php echo GetUseSys();?>
                      </div></td>
                    <td><div align="center">��</div></td>
                  </tr>
					<?php
					$phpr=GetPhpVer();
					?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><div align="center"><strong>PHP�汾</strong></div></td>
                    <td><div align="center"><strong>4.2.3+<br>
                        </strong></div></td>
                    <td><div align="center"> <b> 
                        <?php echo $phpr['ver'];?>
                        </b> </div></td>
                    <td><div align="center"> 
                        <?php echo $phpr['result'];?>
                      </div></td>
                  </tr>
					<?php
  					$mysqlr=CanMysql();
  					?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><div align="center"><strong>MYSQL֧��</strong></div></td>
                    <td><div align="center"><strong>֧��</strong></div></td>
                    <td><div align="center"> <b> 
                        <?php echo $mysqlr['can'];?>
                        </b> </div></td>
                    <td><div align="center"> 
                        <?php echo $mysqlr['result'];?>
                      </div></td>
                  </tr>
					<?php
 					$phpsafer=GetPhpSafemod();
  					?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><div align="center"><strong>PHP�����ڰ�ȫģʽ</strong></div></td>
                    <td><div align="center"><strong>��</strong></div></td>
                    <td><div align="center"> <b> 
                        <?php echo $phpsafer['word'];?>
                        </b> </div></td>
                    <td><div align="center"> 
                        <?php echo $phpsafer['result'];?>
                      </div></td>
                  </tr>
					<?php
  					$gdr=GetGd();
  					?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><div align="center">֧��GD��</div></td>
                    <td><div align="center">����</div></td>
                    <td><div align="center"> 
                        <?php echo $gdr['can'];?>
                      </div></td>
                    <td><div align="center"> 
                        <?php echo $gdr['result'];?>
                      </div></td>
                  </tr>
					<?php
  					$cjr=GetCj();
  					?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="24"> <div align="center"><a title="���Բɼ�" href="#empirecms" onclick="window.open('index.php?enews=TestCj','','width=200,height=80');"><u>֧�ֲɼ�</u></a></div></td>
                    <td><div align="center">����</div></td>
                    <td><div align="center"> 
                        <?php echo $cjr['word'];?>
                      </div></td>
                    <td><div align="center"> 
                        <?php echo $cjr['result'];?>
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <input type="button" name="Submit523" value="��һ��" onclick="javascript:history.go(-1);">
                &nbsp;&nbsp; 
                <input type="button" name="Submit623" value="��һ��" onclick="self.location.href='index.php?enews=path&f=3';">
              </div></td>
          </tr>
        </form>
      </table>
      <?php
	}
	//����Ŀ¼Ȩ��
	elseif($enews=="path")
	{
	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">������������Ŀ¼Ȩ��</font></strong></div></td>
          </tr>
          <tr> 
            <td height="100" bgcolor="#FFFFFF"> <div align="center"> 
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td height="23"><strong>��ʾ��Ϣ</strong></td>
                  </tr>
                  <tr> 
                    <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr> 
                          <td height="25"><li><font color="#FF0000">������ķ�����ʹ�� 
                              Windows ����ϵͳ����������һ����</font></li></td>
                        </tr>
                        <tr> 
                          <td height="25"> <li>������Ŀ¼Ȩ����Ϊ0777, ���˺�ɫĿ¼�⣬��Ŀ¼ȫ��Ҫ��Ȩ��Ӧ������Ŀ¼���ļ��� 
                            </li></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <br>
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td width="34%" height="23"> <div align="center"><strong>Ŀ¼�ļ�����</strong></div></td>
                    <td width="42%"> <div align="center"><strong>˵��</strong></div></td>
                    <td width="24%"> <div align="center"><strong>Ȩ�޼��</strong></div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left"><font color="#FF0000"><strong>/</strong></font></div></td>
                    <td> <div align="center"><font color="#FF0000">ϵͳ��Ŀ¼(��ҪӦ������Ŀ¼)</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/d</div></td>
                    <td> <div align="center"><font color="#666666">����Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../d","../../d/txt");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/s</div></td>
                    <td> <div align="center"><font color="#666666">ר����Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../s");?> 
                      </div></td>
                  </tr>
				  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/t</div></td>
                    <td> <div align="center"><font color="#666666">���������Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../t");?> 
                      </div></td>
                  </tr>
				  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/ecachefiles</div></td>
                    <td> <div align="center"><font color="#666666">��̬ҳ�滺��Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../ecachefiles","../../ecachefiles/empirecms");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/search</div></td>
                    <td> <div align="center"><font color="#666666">������</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../search","../../search/test.txt");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/index.html</div></td>
                    <td> <div align="center"><font color="#666666">��վ��ҳ</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../index.html");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/html</div></td>
                    <td> <div align="center"><font color="#666666">Ĭ�Ͽ�ѡ��HTML���Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../../html");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/admin/ebak/bdata</td>
                    <td> <div align="center"><font color="#666666">�������ݴ��Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../admin/ebak/bdata");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/admin/ebak/zip</td>
                    <td> <div align="center"><font color="#666666">��������ѹ�����Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../admin/ebak/zip");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/e/config/config.php</div></td>
                    <td> <div align="center"><font color="#666666">���ݿ�Ȳ��������ļ�</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../config/config.php");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"> <div align="left">/e/data</div></td>
                    <td> <div align="center"><font color="#666666">���������ļ����Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../data","../data/tmp");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/install</td>
                    <td> <div align="center"><font color="#666666">��װĿ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../install");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/member/iframe/index.php</td>
                    <td><div align="center"><font color="#666666">��½״̬��ʾ</font></div></td>
                    <td><div align="center"> <?php echo CheckFileMod("../member/iframe/index.php");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/member/login/loginjs.php</td>
                    <td><div align="center"><font color="#666666">JS��½״̬��ʾ</font></div></td>
                    <td><div align="center"> <?php echo CheckFileMod("../member/login/loginjs.php");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/pl/more/index.php</td>
                    <td> <div align="center"><font color="#666666">����JS�����ļ�</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../pl/more/index.php");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/sch/index.php</td>
                    <td><div align="center"><font color="#666666">ȫվ�����ļ�</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../sch/index.php");?> 
                      </div></td>
                  </tr>
				  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/template</td>
                    <td> <div align="center"><font color="#666666">��̬ҳ���ģ��Ŀ¼</font></div></td>
                    <td> <div align="center"> <?php echo CheckFileMod("../template");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/tool/feedback/temp</td>
                    <td><div align="center"><font color="#666666">��Ϣ����</font></div></td>
                    <td><div align="center"> <?php echo CheckFileMod("../tool/feedback/temp","../tool/feedback/temp/test.txt");?> 
                      </div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">/e/tool/gbook/index.php</td>
                    <td><div align="center"><font color="#666666">���԰�</font></div></td>
                    <td><div align="center"> <?php echo CheckFileMod("../tool/gbook/index.php");?> 
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <script>
			  function CheckNext()
			  {
			  var ok;
			  //ok=confirm("ȷ����Ӧ������Ŀ¼?");
			  ok=true;
			  if(ok)
			  {
			  self.location.href='index.php?enews=setdb&f=4';
			  }
			  }
			  </script>
                <input type="button" name="Submit523" value="��һ��" onclick="javascript:history.go(-1);">
                &nbsp;&nbsp; 
                <input type="button" name="Submit72" value="ˢ��Ȩ��״̬" onclick="javascript:self.location.href='index.php?enews=path&f=3';">
                &nbsp;&nbsp; 
                <input type="button" name="Submit623" value="��һ��" onclick="javascript:CheckNext();">
              </div></td>
          </tr>
        </form>
      </table>
      <?php
	}
	//�����������ݿ�
	elseif($enews=="setdb")
	{
		$mycookievarpre=strtolower(InstallMakePassword(5));
		$myadmincookievarpre=strtolower(InstallMakePassword(5));
	?>
      <script>
		  function CheckSubmit()
		  {
		  	var ok;
			ok=confirm("ȷ��Ҫ������һ��?");
			if(ok)
			{
		  		document.form1.Submit6223.disabled=true;
				return true;
			}
			return false;
		  }
		  </script> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="index.php?enews=setdb&ok=1&f=5" onsubmit="document.form1.Submit6223.disabled=true;" autocomplete="off">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">���Ĳ����������ݿ�</font></strong></div></td>
          </tr>
          <tr> 
            <td height="100" bgcolor="#FFFFFF"> <div align="center"> 
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td height="23"><strong>��ʾ��Ϣ</strong></td>
                  </tr>
                  <tr> 
                    <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr> 
                          <td height="23"> <li>����������д�������ݿ��˺���Ϣ, ͨ������²���Ҫ�޸���ɫѡ�����ݡ�</li></td>
                        </tr>
                        <tr> 
                          <td height="23"> <li>��*��Ϊ����Ϊ�ա�</li></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <br>
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td width="21%" height="23"> <div align="center"><strong>����ѡ��</strong></div></td>
                    <td width="36%"><div align="center"><strong>��ǰֵ</strong></div></td>
                    <td width="43%"><div align="center"><strong>ע��</strong></div></td>
                  </tr>
					<?php
					$getmysqlver=do_eGetDBVer(0);
					$selectmysqlver=$getmysqlver;
					if(empty($selectmysqlver))
					{
						$selectmysqlver='5.0';
					}
					?>
                    <tr bgcolor="#FFFFFF">
                      <td height="25">MYSQL�ӿ�����:</td>
                      <td><select name="mydbtype" id="mydbtype">
					  	<?php
					  	if(function_exists('mysql_connect'))
					  	{
					  	?>
                        <option value="mysql">mysql</option>
						<?php
						}
						?>
                        <option value="mysqli">mysqli</option>
                      </select>
                      </td>
                      <td><font color="#666666">һ��Ĭ�ϼ���</font></td>
                    </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">MYSQL�汾:</td>
                    <td><table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr> 
                          <td height="22"><input type="radio" name="mydbver" value="auto">
                            �Զ�ʶ��</td>
                        </tr>
                        <tr> 
                          <td height="22"> <input type="radio" name="mydbver" value="4.0">
                            MYSQL 4.0.*/3.*</td>
                        </tr>
                        <tr> 
                          <td height="22"> <input type="radio" name="mydbver" value="4.1">
                            MYSQL 4.1.*</td>
                        </tr>
                        <tr> 
                          <td height="22"> <input type="radio" name="mydbver" value="5.0" checked>
                            MYSQL 5.*������</td>
                        </tr>
                      </table></td>
                    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr> 
                          <td>ϵͳ��⵽�İ汾��: <b> <u> 
                            <?php echo $getmysqlver?$getmysqlver:'';?>
                            </u> </b></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td width="21%" height="25"><font color="#009900">���ݿ������(*):</font></td>
                    <td width="36%"> <input name="mydbhost" type="text" id="mydbhost" value="localhost" size="30"></td>
                    <td width="43%"><font color="#666666">���ݿ��������ַ, һ��Ϊ localhost</font></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><font color="#009900">���ݿ�������˿�:</font></td>
                    <td> <input name="mydbport" type="text" id="mydbport" size="30">                    </td>
                    <td><font color="#666666">MYSQL�˿�,��ΪĬ�϶˿�, һ��Ϊ��</font></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">���ݿ��û���:</td>
                    <td> <input name="mydbusername" type="text" id="mydbusername" value="username" size="30"></td>
                    <td><font color="#666666">MYSQL���ݿ������˺�</font></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">���ݿ�����:</td>
                    <td> <input name="mydbpassword" type="password" id="mydbpassword" size="30"></td>
                    <td><font color="#666666">MYSQL���ݿ���������</font></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">���ݿ���(*):</td>
                    <td> <input name="mydbname" type="text" id="mydbname" value="empirecms" size="30">                    </td>
                    <td><font color="#666666">���ݿ�����</font></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><font color="#009900">����ǰ׺(*):</font></td>
                    <td><input name="mydbtbpre" type="text" id="mydbtbpre" value="phome_" size="30"></td>
                    <td><font color="#666666">ͬһ���ݿⰲװ���CMSʱ�ɸı�Ĭ�ϣ��������ֿ�ͷ</font></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25"><font color="#009900">COOKIEǰ׺(*):</font></td>
                    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                        <tr>
                          <td>ǰ̨��
                            <input name="mycookievarpre" type="text" id="mycookievarpre" value="<?php echo $mycookievarpre;?>" size="22"></td>
                        </tr>
                        <tr>
                          <td>��̨��
                            <input name="myadmincookievarpre" type="text" id="myadmincookievarpre" value="<?php echo $myadmincookievarpre;?>" size="22"></td>
                        </tr>
                      </table>                    </td>
                    <td><font color="#666666">��<strong>Ӣ����ĸ</strong>��ɣ�Ĭ�ϼ���</font></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="25">���ó�ʼ����:</td>
                    <td><input name="defaultdata" type="checkbox" id="defaultdata" value="1">
                      ��</td>
                    <td><font color="#666666">�������ʱѡ��</font></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <input type="button" name="Submit5223" value="��һ��" onclick="javascript:history.go(-1);">
                &nbsp;&nbsp; 
                <input type="submit" name="Submit6223" value="��һ��">
                <input name="mydbchar" type="hidden" id="mydbchar" value="<?php echo $dbchar;?>">
                <input name="mysetchar" type="hidden" id="mysetchar" value="<?php echo $setchar;?>">
              </div></td>
          </tr>
        </form>
      </table>
      <?php
	}
	//��ʹ������Ա
	elseif($enews=="firstadmin")
	{
	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="index.php?enews=firstadmin&ok=1&f=6" onsubmit="document.form1.Submit62222.disabled=true" autocomplete="off">
          <input type="hidden" name="defaultdata" value="<?php echo $_GET['defaultdata'];?>">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">���岽����ʼ������Ա�˺�</font></strong></div></td>
          </tr>
          <tr> 
            <td height="100" bgcolor="#FFFFFF"> <div align="center"> 
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td height="23"><strong>��ʾ��Ϣ</strong></td>
                  </tr>
                  <tr> 
                    <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr> 
                          <td height="25"> <li>����������д��Ҫ���õĹ���Ա�˺���Ϣ��</li></td>
                        </tr>
                        <tr>
                          <td height="25"> <li>���벻�ܰ�����$��&amp;��*��#��&lt;��&gt;��'��&quot;��/��\��%��;���ո�</li></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <br>
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
                  <tr> 
                    <td height="23" colspan="3"><strong>��ʼ������Ա�˺�</strong></td>
                  </tr>
                  <tr> 
                    <td width="21%" height="25" bgcolor="#FFFFFF">�û���:</td>
                    <td width="36%" bgcolor="#FFFFFF"> <input name="username" type="text" id="username" size="30"> 
                    </td>
                    <td width="43%" bgcolor="#FFFFFF"><font color="#666666">����Ա�û���</font></td>
                  </tr>
                  <tr> 
                    <td height="25" bgcolor="#FFFFFF">����:</td>
                    <td bgcolor="#FFFFFF"> <input name="password" type="password" id="password" size="30"></td>
                    <td bgcolor="#FFFFFF"><font color="#666666">����Ա�˺����룬���ִ�Сд</font></td>
                  </tr>
                  <tr> 
                    <td height="25" bgcolor="#FFFFFF"> <p>�ظ�����:</p></td>
                    <td bgcolor="#FFFFFF"> <input name="repassword" type="password" id="repassword" size="30"></td>
                    <td bgcolor="#FFFFFF"><font color="#666666">ȷ���˺�����</font></td>
                  </tr>
                  <tr>
                    <td height="25" bgcolor="#FFFFFF"><font color="#FF0000">��¼��֤��:</font></td>
                    <td bgcolor="#FFFFFF"><input name="loginauth" type="text" id="loginauth" size="30"></td>
                    <td bgcolor="#FFFFFF"><font color="#FF0000">������ú�̨��¼Ҫ������֤�룬����ȫ</font></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <input type="button" name="Submit52223" value="��һ��" onclick="javascript:history.go(-3);">
                &nbsp;&nbsp; 
                <input type="submit" name="Submit62222" value="��һ��">
              </div></td>
          </tr>
        </form>
      </table>
      <?php
	}
	//��װ���
	elseif($enews=="success")
	{
		//������װ����
		$fp=@fopen("install.off","w");
		@fclose($fp);
		$word='��ϲ�������ѳɹ���װ�۹���վ����ϵͳ��';
		if($_GET['defaultdata'])
		{
			$word='��ϲ�������ѳɹ���װ�۹���վ����ϵͳ��<br>�����������ʼ����������(����װ˵��������)��';
		}
	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="index.php?enews=setdb&ok=1&f=7">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">����������װ���</font></strong></div></td>
          </tr>
          <tr> 
            <td height="100"> <div align="center"> 
                <table width="92%" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td bgcolor="#FFFFFF"> <div align="center"> 
                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                          <tr> 
                            <td height="42"> <div align="center"><font color="#FF0000"> 
                                <?php echo $word;?>
                                </font></div></td>
                          </tr>
                          <tr> 
                            <td height="30"> <div align="center">(������ʾ��������ɾ��/e/installĿ¼���Ա��ⱻ�ٴΰ�װ.)</div></td>
                          </tr>
                          <tr> 
                            <td height="42"> <div align="center"> 
                                <input type="button" name="Submit82" value="�����̨�������" onclick="javascript:self.location.href='../admin/index.php'">
                              </div></td>
                          </tr>
                          <tr> 
                            <td height="25"> <div align="center" style="DISPLAY:none"><?=InstallSuccessShowInfo()?></div></td>
                          </tr>
                        </table>
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> </div></td>
          </tr>
        </form>
      </table>
      <?php
	}
	//����
	else
	{
	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">��һ�����۹�CMS�û����Э��</font></strong></div></td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"> <div align="center"> 
                <table width="100%" height="350" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td><div align="center"> 
                        <IFRAME frameBorder=0 name=xy scrolling=auto src="data/xieyi.html" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:2"></IFRAME>
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <input type="button" name="Submit5" value="�Ҳ�ͬ��" onclick="window.close();">
				                &nbsp;&nbsp; 
				<input type="button" name="Submit6" value="��ͬ��" onclick="javascript:self.location.href='index.php?enews=checkfj&f=2';">
              </div></td>
          </tr>
        </form>
      </table>
      <?php
		}
		?>
    </td>
  </tr>
  <tr> 
    <td valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td><hr align="center"></td>
        </tr>
        <tr> 
          <td height="25"><div align="center"><a href="http://www.PHome.Net" target="_blank">�ٷ���վ</a>&nbsp; 
              | &nbsp;<a href="http://bbs.PHome.Net" target="_blank">֧����̳</a>&nbsp; 
              | &nbsp;<a href="http://www.phome.net/EmpireCMS/UserSite/" target="_blank">���ְ���</a>&nbsp; 
              | &nbsp;<a href="http://www.phome.net/ecms72/?ecms=EmpireCMS" target="_blank">ϵͳ����</a>&nbsp; 
              | &nbsp;<a href="http://www.phome.net/zy/template/" target="_blank">ģ������</a>&nbsp; 
              | &nbsp;<a href="http://bbs.phome.net/showthread-13-18902-0.html" target="_blank">�̳�����</a>&nbsp; 
              | &nbsp;<a href="http://www.phome.net/service/about.html" target="_blank">���ڵ۹�</a></div></td>
        </tr>
        <tr> 
          <td height="36"> <div align="center">��������������޹�˾ ��Ȩ����<BR>
              <font face="Arial, Helvetica, sans-serif">Copyright &copy; 2002 
              - 2018<b> <a href="http://www.PHome.net"><font color="#000000">PHome</font><font color="#FF6600">.Net</font></a></b></font></div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
