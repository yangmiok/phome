<?
if(!defined('InEmpireCMS'))
{exit();}
?><? include("../../data/template/cp_1.php");?>
<table width=100% align=center cellpadding=3 cellspacing=1 class="tableborder">
  <form name='feedback' method='post' enctype='multipart/form-data' action='../../enews/index.php'>
    <input name='enews' type='hidden' value='AddFeedback'>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��������:</div></td>
      <td bgcolor='ffffff'><input name='name' type='text' size='42'>
        (*)</td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">ְ��:</div></td>
      <td bgcolor='ffffff'><input name='job' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��˾����:</div></td>
      <td bgcolor='ffffff'><input name='company' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��ϵ����:</div></td>
      <td bgcolor='ffffff'><input name='email' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��ϵ�绰:</div></td>
      <td bgcolor='ffffff'><input name='mycall' type='text' size='42'>
        (*)</td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��վ:</div></td>
      <td bgcolor='ffffff'><input name='homepage' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��ϵ��ַ:</div></td>
      <td bgcolor='ffffff'><input name='address' type='text' size="42"></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��Ϣ����:</div></td>
      <td bgcolor='ffffff'><input name='title' type='text' size="42"> (*)</td>
    </tr>
    <tr> 
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">��Ϣ����(*):</div></td>
      <td bgcolor='ffffff'><textarea name='saytext' cols='60' rows='12'></textarea> 
      </td>
    </tr>
    <tr>
      <td bgcolor='ffffff'></td>
      <td bgcolor='ffffff'><input type='submit' name='submit' value='�ύ'></td>
    </tr>
  </form>
</table>
<? include("../../data/template/cp_2.php");?>