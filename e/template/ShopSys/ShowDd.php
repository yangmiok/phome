<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../../data/images/css.css" rel="stylesheet" type="text/css">
<title>�鿴����</title>
<script>
function PrintDd()
{
	pdiv.style.display="none";
	window.print();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="61%" height="27" bgcolor="#FFFFFF"><strong>������: 
      <?=$r[ddno]?>
      </strong></td>
    <td width="39%" bgcolor="#FFFFFF"><strong>�µ�ʱ��: 
      <?=$r[ddtime]?>
      </strong></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>��Ʒ��Ϣ</strong></td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <?php
	  $buycar=$addr['buycar'];
	  $payby=$r['payby'];
	  include('buycar/buycar_showdd.php');
	  ?>
    </td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>������Ϣ</strong></td>
  </tr>
  <tr> 
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="12%" height="25"> 
            <div align="right">�����ţ�</div></td>
          <td width="32%"><strong> 
            <?=$r[ddno]?>
            </strong></td>
          <td width="14%"> 
            <div align="right">����״̬��</div></td>
          <td width="41%"><strong> 
            <?=$ha?>
            </strong>/<strong> 
            <?=$ou?>
            </strong>/<strong> 
            <?=$ch?>
            </strong> 
            <?=$topay?>          </td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">�µ�ʱ�䣺</div></td>
          <td><strong> 
            <?=$r[ddtime]?>
            </strong></td>
          <td><div align="right">��Ʒ�ܽ�</div></td>
          <td><strong>
            <?=$alltotal?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">���ͷ�ʽ��</div></td>
          <td><strong>
            <?=$r[psname]?>
            </strong></td>
          <td><div align="right">+ ��Ʒ�˷ѣ�</div></td>
          <td><strong>
            <?=$pstotal?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">֧����ʽ��</div></td>
          <td><strong>
            <?=$payfsname?>
            </strong></td>
          <td><div align="right">+ ��Ʊ���ã�</div></td>
          <td><?=$r[fptotal]?></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">��Ҫ��Ʊ��</div></td>
          <td><?=$fp?></td>
          <td><div align="right">- �Żݣ�</div></td>
          <td><?=$r[pretotal]?></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">��Ʊ̧ͷ��</div></td>
          <td><strong> 
            <?=stripSlashes($r[fptt])?>
            </strong></td>
          <td><div align="right">�����ܽ�</div></td>
          <td><strong>
            <?=$mytotal?>
          </strong></td>
        </tr>
        <tr>
          <td height="25"><div align="right">��Ʊ���ƣ�</div></td>
          <td colspan="3"><strong>
            <?=stripSlashes($r[fpname])?>
          </strong></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>�ջ�����Ϣ</strong></td>
  </tr>
  <tr> 
    <td colspan="2"><table width="100%%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="20%" height="25">��ʵ����:</td>
          <td width="80%"> 
            <?=stripSlashes($r[truename])?>          </td>
        </tr>
        <tr> 
          <td height="25">QQ:</td>
          <td> 
            <?=stripSlashes($r[oicq])?>          </td>
        </tr>
        <tr> 
          <td height="25">MSN:</td>
          <td> 
            <?=stripSlashes($r[msn])?>          </td>
        </tr>
        <tr> 
          <td height="25">�̶��绰:</td>
          <td> 
            <?=stripSlashes($r[mycall])?>          </td>
        </tr>
        <tr> 
          <td height="25">�ƶ��绰:</td>
          <td> 
            <?=stripSlashes($r[phone])?>          </td>
        </tr>
        <tr> 
          <td height="25">��ϵ����:</td>
          <td> 
            <?=stripSlashes($r[email])?>          </td>
        </tr>
        <tr> 
          <td height="25">��ϵ��ַ:</td>
          <td> 
            <?=stripSlashes($r[address])?>          </td>
        </tr>
        <tr> 
          <td height="25">�ʱ�:</td>
          <td> 
            <?=stripSlashes($r[zip])?>          </td>
        </tr>
        <tr>
          <td height="25">��־����:</td>
          <td><?=stripSlashes($r[signbuild])?></td>
        </tr>
        <tr>
          <td height="25">����ͻ���ַ:</td>
          <td><?=stripSlashes($r[besttime])?></td>
        </tr>
        <tr> 
          <td height="25">��ע:</td>
          <td> 
            <?=nl2br(stripSlashes($addr[bz]))?>          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>����Ա��ע��Ϣ</strong></td>
  </tr>
  <tr> 
    <td colspan="2"><table width="100%%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="20%" height="25">��ע����:</td>
          <td width="80%"> 
            <?=nl2br(stripSlashes($addr['retext']))?>          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"> 
        <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" id="pdiv">
          <tr> 
            <td><div align="center">
                <input type="button" name="Submit" value=" �� ӡ " onclick="javascript:PrintDd();">
              </div></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
</body>
</html>