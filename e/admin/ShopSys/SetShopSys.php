<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("class/hShopSysFun.php");
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
CheckLevel($logininid,$loginin,$classid,"public");
$r=$empire->fetch1("select * from {$dbtbpre}enewsshop_set limit 1");
//ˢ�±�
$changetable='';
$i=0;
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
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
	$checked='';
	if(stristr($r['shoptbs'],','.$tr[tbname].','))
	{
		$checked=' checked';
	}
	$changetable.="<input type=checkbox name=tbname[] value='$tr[tbname]'".$checked.">$tr[tname]&nbsp;&nbsp;".$br;
}
//Ȩ��
$shopddgroup='';
$mgsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($mgr=$empire->fetch($mgsql))
{
	if($r[shopddgroupid]==$mgr[groupid])
	{
		$shopddgroup_select=' selected';
	}
	else
	{
		$shopddgroup_select='';
	}
	$shopddgroup.="<option value=".$mgr[groupid].$shopddgroup_select.">".$mgr[groupname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�̳ǲ�������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><p>λ�ã��̳ǲ�������</p>
      </td>
  </tr>
</table>
<form name="plset" method="post" action="ecmsshop.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�̳ǲ������� 
        <input name=enews type=hidden value=SetShopSys></td>
    </tr>
	<tr bgcolor="#FFFFFF">
	  <td height="25">ָ��ʹ���̳ǹ��ܵ����ݱ�</td>
	  <td width="81%"><?=$changetable?></td>
    </tr>
	<tr bgcolor="#FFFFFF">
	  <td height="25">��������</td>
	  <td><select name="buystep" size="1" id="buystep">
	    <option value="0"<?=$r['buystep']==0?' selected':''?>>���ﳵ &gt; ��ϵ��ʽ+���ͷ�ʽ+֧����ʽ &gt; ȷ�϶��� &gt; �ύ����</option>
		<option value="1"<?=$r['buystep']==1?' selected':''?>>���ﳵ &gt; ��ϵ��ʽ+���ͷ�ʽ+֧����ʽ &gt; �ύ����</option>
		<option value="2"<?=$r['buystep']==2?' selected':''?>>��ϵ��ʽ+���ͷ�ʽ+֧����ʽ &gt; �ύ����</option>
	    </select>	  </td>
    </tr>
	<tr bgcolor="#FFFFFF">
	  <td height="25">&nbsp;</td>
	  <td><input name="shoppsmust" type="checkbox" id="shoppsmust" value="1"<?=$r['shoppsmust']==1?' checked':''?>>
      ��ʾ���ͷ�ʽ
      <input name="shoppayfsmust" type="checkbox" id="shoppayfsmust" value="1"<?=$r['shoppayfsmust']==1?' checked':''?>>
      ��ʾ֧����ʽ <font color="#666666">(�ύ����ʱ����ʾ��Ϊ�Ǳ�ѡ��)</font></td>
    </tr>
	<tr bgcolor="#FFFFFF">
          <td height="25">�ύ����Ȩ��</td>
          <td><select name="shopddgroupid" id="shopddgroupid">
              <option value="0"<?=$r['shopddgroupid']==0?' selected':''?>>�ο�</option>
			  <option value="1"<?=$r['shopddgroupid']==1?' selected':''?>>��Ա�����ύ����</option>
            </select></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">���ﳵ�����Ʒ��</td>
          <td><input name="buycarnum" type="text" id="buycarnum" value="<?=$r[buycarnum]?>">
            <font color="#666666">(0Ϊ���ޣ�Ϊ1ʱ���ﳵ������滻ԭ��Ʒ��ʽ)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">����Ʒ�������</td>
          <td><input name="singlenum" type="text" id="singlenum" value="<?=$r[singlenum]?>">
            <font color="#666666">(0Ϊ���ޣ����ƶ����ﵥ����Ʒ���������)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">�����ٽ�����˷�</td>
          <td><input name="freepstotal" type="text" id="freepstotal" value="<?=$r[freepstotal]?>">
            Ԫ
          <font color="#666666">(0Ϊ�����˷�)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">���ﳵ֧�ָ�������</td>
          <td><input type="radio" name="haveatt" value="1"<?=$r['haveatt']==1?' checked':''?>>
����
  <input type="radio" name="haveatt" value="0"<?=$r['haveatt']==0?' checked':''?>>
�ر�<font color="#666666">��������Ʒ���á�addatt������������ݣ����磺&amp;addatt[]=��ɫ��</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">��Ա���Լ�ȡ��������ʱ��</td>
          <td><input name="dddeltime" type="text" id="dddeltime" value="<?=$r[dddeltime]?>">
            ���� <font color="#666666">(�����趨ʱ���Ա�Լ�����ɾ��������0Ϊ����ɾ��)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">����������</td>
          <td><select name="cutnumtype" id="cutnumtype">
            <option value="0"<?=$r[cutnumtype]==0?' selected':''?>>�¶���ʱ���ٿ��</option>
            <option value="1"<?=$r[cutnumtype]==1?' selected':''?>>�¶�����֧��ʱ���ٿ��</option>
          </select>          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">δ�������ʱ���ԭ���</td>
          <td><input name="cutnumtime" type="text" id="cutnumtime" value="<?=$r[cutnumtime]?>">
            ���� <font color="#666666">(0Ϊ���ޣ������趨ʱ���Զ�ȡ������������Դ���)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="22%" height="25">�Ƿ��ṩ��Ʊ</td>
          <td><input name="havefp" type="checkbox" id="havefp" value="1"<?=$r[havefp]==1?' checked':''?>>
            ��,��ȡ 
            <input name="fpnum" type="text" id="fpnum" value="<?=$r[fpnum]?>" size="6">
            % �ķ�Ʊ��</td>
    </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">��Ʊ����<br>
          <br>
          <font color="#666666">(һ��һ�������磺�칫��Ʒ)</font></td>
          <td><textarea name="fpname" cols="38" rows="8" id="fpname"><?=ehtmlspecialchars($r[fpname])?></textarea></td>
        </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">����������</td>
      <td height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="truename"<?=stristr($r['ddmust'],',truename,')?' checked':''?>>
            ����</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="oicq"<?=stristr($r['ddmust'],',oicq,')?' checked':''?>>
            QQ</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="msn"<?=stristr($r['ddmust'],',msn,')?' checked':''?>>
            MSN</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="email"<?=stristr($r['ddmust'],',email,')?' checked':''?>>
            ����</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="mycall"<?=stristr($r['ddmust'],',mycall,')?' checked':''?>>
            �̶��绰</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="phone"<?=stristr($r['ddmust'],',phone,')?' checked':''?>>
            �ֻ�</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="address"<?=stristr($r['ddmust'],',address,')?' checked':''?>>
            ��ϵ��ַ</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="zip"<?=stristr($r['ddmust'],',zip,')?' checked':''?>>
�ʱ�</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="signbuild"<?=stristr($r['ddmust'],',signbuild,')?' checked':''?>>
            ��־����</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="besttime"<?=stristr($r['ddmust'],',besttime,')?' checked':''?>>
            �ͻ����ʱ��</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="bz"<?=stristr($r['ddmust'],',bz,')?' checked':''?>> 
            ��ע</td>
        </tr>
      </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
