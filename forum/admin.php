<? // WR-forum v 1.9.3  //  10.06.10 �.  //  Miha-ingener@yandex.ru

error_reporting (E_ALL); //error_reporting(0);
ini_set('register_globals','off');// ��� ������� �������� ��� ���� ��������� php

include "config.php";

$skey="657567"; // !!! ��������� ���� !!! 
// ��������� �� ���� � ��� ��� ������� ������� :-)
// !!! ����� ����� - ������ �������������� � ���������� ���������� ����������!
// ��� ��������� ������ ������ �������������� ������ � 97
// �������� ���������� ��� � config.php � ���������� $password � $moderpass

// �����������
$adminname="�������������|���������|"; // �� ������� ���������!!! ��� ��������. ��� �������������� � ����� ���� | ��� ���������� � � ����� |
$adminpass=$password;


//--�-�-�-�-�-�-�-�--
if (isset($_GET['image'])) {
// ������� � ������� ������
$st="R0lGODlhCgAMAIABAFNTU////yH5BAEAAAEALAAAAAAKAAwAAAI"; // ����� ����� ��� ���� ��������
function imgwr($st,$num){
 if ($num=="0") {$len="63"; $number=$st."WjIFgi6e+QpMP0jin1bfv2nFaBlJaAQA7";}
 if ($num=="1") {$len="61"; $number=$st."UjA1wG8noXlJsUnlrXhE/+DXb0RUAOw==";}
 if ($num=="2") {$len="64"; $number=$st."XjIFgi6e+QpMPRlbjvFtnfFnchyVJUAAAOw==";}
 if ($num=="3") {$len="64"; $number=$st."XjIFgi6e+Qovs0RkTzXbj+3yTJnUlVgAAOw==";}
 if ($num=="4") {$len="64"; $number=$st."XjA9wG8mWFIty0amczbVJDVHg9oSlZxQAOw==";}
 if ($num=="5") {$len="63"; $number=$st."WTIAJdsuPHovSKGoprhs67mzaJypMAQA7";}
 if ($num=="6") {$len="63"; $number=$st."WjIFoB6vxmFw0pfpihI3jOW1at3FRAQA7";}
 if ($num=="7") {$len="61"; $number=$st."UDI4Xy6vtAIzTyPpg1ndu9oEdNxUAOw==";}
 if ($num=="8") {$len="63"; $number=$st."WjIFgi6e+QpMP2slSpJbn7mFeWDlYAQA7";}
 if ($num=="9") {$len="64"; $number=$st."XjIFgi6e+QpMP0jinvbT2FGGPxmlkohUAOw==";}
 header("Content-type: image/gif"); 
 header("Content-length: $len");
 echo base64_decode($number); }
// ����� ����������� �� ����� (��� ���������� - ����� �� ������)
if (array_key_exists("image", $_REQUEST)) { $num=$_REQUEST["image"];
for ($i=0; $i<10; $i++) {if (md5($i+$rand_key)==$num) {imgwr($st,$i); die();}} }
exit;}

function replacer ($text) { // ������� ������� ����
$text=str_replace("&#032;",' ',$text);
$text=str_replace(">",'&gt;',$text);
$text=str_replace("<",'&lt;',$text);
$text=str_replace("\"",'&quot;',$text);
$text=preg_replace("/\n\n/",'<p>',$text);
$text=preg_replace("/\n/",'<br>',$text);
$text=preg_replace("/\\\$/",'&#036;',$text);
$text=preg_replace("/\r/",'',$text);
$text=preg_replace("/\\\/",'&#092;',$text);

if (get_magic_quotes_gpc()) {
$text=str_replace("&#092;&quot;",'&quot;',$text);
$text=str_replace("&#092;'",'\'',$text);
$text=str_replace("&#092;&#092;",'&#092;',$text);
} // ���� magic_quotes �������� - ������ ����� ����� � ���� ������� ����������:
  // ��������� (') � ������� ������� ("), �������� ���� ()

$text=str_replace("\r\n","<br> ",$text);
$text=str_replace("\n\n",'<p>',$text);
$text=str_replace("\n",'<br> ',$text);
$text=str_replace("\t",'',$text);
$text=str_replace("\r",'',$text);
$text=str_replace('   ',' ',$text);
return $text; }


function unreplacer ($text) { // ������� ������ ������������ ����� ������ �� �������
$text=str_replace("&lt;br&gt;","<br>",$text);
$text=str_replace("&#124;","|",$text);
return $text;}

// ������ ����� - ������� ����
if(isset($_GET['event'])) { if ($_GET['event']=="clearcooke") { setcookie("wrforumm","",time()-3600); Header("Location: index.php"); exit; } }

if (isset($_COOKIE['wrforumm'])) { // ������� ���/������ �� ���� � �������� � ������ �����
$text=$_COOKIE['wrforumm'];
$text=trim($text); // �������� ���������� ������� 
if (strlen($text)>60) exit("������� ������ - ����� ���������� ���� ������ �������!");
$text=replacer($text);
$exd=explode("|",$text); $name1=$exd[0]; $pass1=$exd[1];
$adminname=explode("|",$adminname);

if ($name1!=$adminname[0] and $name1!=$adminname[1] or $pass1!=$adminpass) 
{sleep(1); setcookie("wrforumm", "0", time()-3600); Header("Location: admin.php"); exit;} // ������� �������� ����!!!

} else { // ���� ���� ���� ����

if (isset($_POST['name']) & isset($_POST['pass'])) { // ���� ���� ���������� �� ����� ����� ������
$name=str_replace("|","I",$_POST['name']); $pass=str_replace("|","I",$_POST['pass']);
$text="$name|$pass|";
$text=trim($text); // �������� ���������� ������� 
if (strlen($text)<4) exit("$back �� �� ����� ��� ��� ������!");
$text=replacer($text);
$exd=explode("|",$text); $name=$exd[0]; $pass=$exd[1];

//$qq=md5("$pass+$skey"); print"$qq"; exit; // ������������� ��� ��������� MD5 ������ ������!

//--�-�-�-�-�-�-�-�--�������� ����--
if ($antispam!="0") {
$bada="$back <font color=red>�������� ���� ��� �� �����</font>!";
if (isset($_POST['usernum'])) $usernum=$_POST['usernum']; else exit("$bada");
if (isset($_POST['xkey'])) $xkey=$_POST['xkey']; else exit("$bada");
$userkey=md5("$usernum+$rand_key");
if ($userkey!=$xkey) exit("$bada"); }
//--�-�-�-�-�-�-�-�--�������� ����--


// ������� �������� ���/������ � �������� � ������ �����
$adminname=explode("|",$adminname);
// �������������� ������������� ����
if ($name==$adminname[0] & md5("$pass+$skey")==$adminpass) 
{$tektime=time(); $wrforumm="$adminname[0]|$adminpass|$tektime|";
setcookie("wrforumm", $wrforumm, time()+18000); Header("Location: admin.php"); exit;}
// ���������� ������������� ����
if ($name==$adminname[1] & md5("$pass+$skey")==$moderpass) 
{$tektime=time(); $wrforumm="$adminname[1]|$adminpass|$tektime|";
setcookie("wrforumm", $wrforumm, time()+18000); Header("Location: admin.php"); exit;}

exit("���� ������ <B>��������</B>!</center>");

} else { // ���� ���� ������, �� ������� ����� ����� ������

echo "<html><head><META HTTP-EQUIV='Pragma' CONTENT='no-cache'><META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'><META content='text/html; charset=windows-1251' http-equiv=Content-Type><style>input, textarea {font-family:Verdana; font-size:12px; text-decoration:none; color:#000000; cursor:default; background-color:#FFFFFF; border-style:solid; border-width:1px; border-color:#000000;}</style></head><body>
<BR><BR><BR><center>
<table border=#C0C0C0 border=1  cellpadding=3 cellspacing=0 bordercolor=#959595>
<form action='admin.php' method=POST name=pswrd>
<TR><TD bgcolor=#C0C0C0 align=center>����������������� ������</TD></TR>
<TR><TD align=right>������� �����: <input size=17 name=name value=''></TD></TR>
<TR><TD align=right>������� ������: <input type=password size=17 name=pass></TD></TR>";

//-�-�-�-�-�-�-�-�-
if ($antispam!="0") {
// ����� ����������� �� ����� (��� ���������� - ����� �� ������)
if (array_key_exists("image", $_REQUEST)) { $num=$_REQUEST["image"];
for ($i=0; $i<10; $i++) {if (md5($i+$rand_key)==$num) {imgwr($st,$i); die();}} }
$xkey=""; mt_srand(time()+(double)microtime()*1000000);
echo'<TR><TD align=right>�������� ���: ';
for ($i=0; $i<$max_key; $i++) {
$snum[$i]=mt_rand(0,9); $psnum=md5($snum[$i]+$rand_key);
$phpself=$_SERVER["PHP_SELF"];
echo "<img src=$phpself?image=$psnum border='0' alt=''>\n";
$xkey=$xkey.$snum[$i];}
$xkey=md5("$xkey+$rand_key");
print" <input name='usernum' class=post type='text' maxlength=$max_key size=8>
<input name=xkey type=hidden value='$xkey'>";
} // if $antispam!="0"
//-�-�-�-�-�--�-�-�-�-�-�-�-�-�-

print"<TR><TD align=center><input type=submit style='WIDTH: 120px; height:20px;' value='�����'>
<SCRIPT language=JavaScript>document.pswrd.name.focus();</SCRIPT></TD></TR></table>
<BR><BR><center><font size=-2><small>Powered by <a href=\"http://www.wr-script.ru\" title=\"������ ������\" class='copyright'>WR-Forum</a> Professional &copy; 1.9<br></small></font></center></body></html>";
exit;}

} // ����������� ��������!

$gbc=$_COOKIE['wrforumm']; $gbc=explode("|", $gbc); $gbname=$gbc[0];$gbpass=$gbc[1];$gbtime=$gbc[2];






// ��������� ������������
if(isset($_GET['event'])) { if ($_GET['event']=="activate") {

$key=$_GET['key']; $email=$_GET['email']; $page=$_GET['page'];

// ������ �� ������ �� ����� � ������
if (strlen($key)<6 or strlen($key)>6 or !ctype_digit($key)) exit("$back. �� �������� ��� ����� �����. ���� ����� ��������� ������ 6 ����.");
$email=stripslashes($email); $email=htmlspecialchars($email);
$email=str_replace("|","I",$email); $email=str_replace("\r\n","<br>",$email);
if (strlen($key)>30) exit("������ ��� ����� ������");

// ���� ����� � ����� ������� � ������. ���� ���� - ������ ������ �� ������ ����
$email=strtolower($email); unset($fnomer); unset($ok);
$lines=file("$datadir/usersdat.php"); $ui=count($lines); $i=$ui;
do {$i--; $rdt=explode("|",$lines[$i]); 
$rdt[3]=strtolower($rdt[3]);
if ($rdt[3]===$email and $rdt[13]===$key) {$name=$rdt[0]; $pass=$rdt[1]; $fnomer=$i;}
if ($rdt[3]===$email and $rdt[13]==="") $ok="1";
} while($i > 1);
if (isset($fnomer)) {
// ���������� ������ ����� � ��
$i=$ui; $dt=explode("|", $lines[$fnomer]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]||";
$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� �����
for ($i=0;$i<=(sizeof($lines)-1);$i++) {if ($i==$fnomer) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]);}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
}
if (!isset($fnomer) and !isset($ok)) exit("$back. �� �������� � ���� �������������� ����� ��� ������.</center>");
if (isset($ok)) $add="������ ������������ �����"; else $add="$name, ������������ ������� ���������������.";

print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>
<script language='Javascript'>function reload() {location = \"admin.php?event=userwho&page=$page\"}; setTimeout('reload()', 2500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$add</B>.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� �� �������� � ����������� ������.<BR><BR>
<B><a href='admin.php?event=userwho&page=$page'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;

}
}






// ���� �����ר�� ���-�� ��� � ���������
if(isset($_GET['event'])) { if ($_GET['event'] =="revolushion") {
$lines = file("$datadir/mainforum.dat");
$countmf=count($lines)-1;
$i="-1";$u=$countmf-1;$k="0";

do {$i++; $dt=explode("|", $lines[$i]);

if (!isset($dt[12])) {$dt[12]=""; $dt[11]="";}

if ($dt[1]!="razdel") {
$fid=$dt[0];
if ((is_file("$datadir/topic$fid.dat")) && (sizeof("$datadir/topic$fid.dat")>0))
{
$fl=file("$datadir/topic$fid.dat");
$kolvotem=count($fl);
$kolvomsg="0";
for ($itf=0; $itf<$kolvotem; $itf++) 
{$forumdt = explode("|", $fl[$itf]);
$cd=$forumdt[7];


$msgfile=file("$datadir/$cd.dat");
$countmsg=count($msgfile); $kolvomsg=$kolvomsg+$countmsg;}
if ($kolvotem=="0") $dt[8]="";
$lines[$i]="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$kolvotem|$kolvomsg|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]|\r\n";
}

else {$kolvotem="0"; $kolvomsg="0"; $lines[$i]="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$kolvotem|$kolvomsg|$dt[6]|$dt[7]|$dt[8]||$dt[10]|$dt[11]|$dt[12]|\r\n";}
}
else $lines[$i]="$dt[0]|$dt[1]|$dt[2]|\r\n";

} while($i < $countmf);

// ��������� ���������� ������ � ���-�� ��� � ��������� � �����
$file=file("$datadir/mainforum.dat");
$fp=fopen("$datadir/mainforum.dat","w");
flock ($fp,LOCK_EX); 
for ($i=0;$i< sizeof($file);$i++) fputs($fp,$lines[$i]);
flock ($fp,LOCK_UN);
fclose($fp);

print "<center><BR><BR><BR>�� ������� �����������.</center><script language='Javascript'><!--
function reload() {location = \"admin.php\"}; setTimeout('reload()', 1000);
--></script>";
exit; }}






// ���� �������� ��������� ������



// ����� ���� �������� 
if (isset($_GET['usersdelete']))  { $usersdelete=$_GET['usersdelete'];

$first=$_POST['first']; $last=$_POST['last']; $page=$_GET['page']; $delnum=null; $i=0;

// ���������� ���-�� ����� � ����� ������ � �� ����������
if (count(file("$datadir/usersdat.php")) != count(file("$datadir/userstat.dat"))) exit("���������� ���������� ����������! ��������� ����: '<a href='admin.php?newstatistik'>����������� ���������� ����������</a>',<br> � ����� ��� ����� ����� ������� ����������!");

do {$dd="del$first"; if (isset($_POST["$dd"])) { $delnum[$i]=$first; $i++;} $first++; } while ($first<=$last);
$itogodel=count($delnum); $newi=0; 
if ($delnum=="") exit("�������� ����� ������ ������ ����������!");
$file=file("$datadir/usersdat.php"); $itogo=sizeof($file); $lines=null; $delyes="0";
for ($i=0; $i<$itogo; $i++) { // ���� �� ����� � �������
for ($p=0; $p<$itogodel; $p++) {if ($i==$delnum[$p]) $delyes=1;} // ���� �� ������� ��� ��������
// ���� ��� ����� �� �������� ������ - ��������� ����� ������ �������, ����� - ���
if ($delyes!=1) {$lines[$newi]=$file[$i]; $newi++;} else $delyes="0"; }

// ����� ����� ������ � ����
$newitogo=count($lines); 
$fp=fopen("$datadir/usersdat.php","w");
flock ($fp,LOCK_EX);
// ���� ���� ������ �������, ����� ������ ���� ������� :-))
if (isset($lines[0])) { for ($i=0; $i<$newitogo; $i++) fputs($fp,$lines[$i]); } else fputs($fp,"");
flock ($fp,LOCK_UN);
fclose($fp);

// ������� ���� � ����� �� ����� ���������� - ���������� ����!!!!
// ������ ����� ������ ������� �� ������, ������� ������������� ������
// �� �  ������ ����� ��������� ��� ���������� � �������� ����
// ������ - ����� ��������� ����� ������

$file=file("$datadir/userstat.dat"); $itogo=sizeof($file); $lines=null; $delyes="0"; $newi=0;
for ($i=0; $i<$itogo; $i++) { // ���� �� ����� � �������
for ($p=0; $p<$itogodel; $p++) {if ($i==$delnum[$p]) $delyes=1;} // ���� �� ������� ��� ��������
// ���� ��� ����� �� �������� ������ - ��������� ����� ������ �������, ����� - ���
if ($delyes!=1) {$lines[$newi]=$file[$i]; $newi++;} else $delyes="0"; }

// ����� ����� ������ � ����
$newitogo=count($lines); 
$fp=fopen("$datadir/userstat.dat","w");
flock ($fp,LOCK_EX);
// ���� ���������� ���� ������ �������, ����� ������ ���� ������� :-))
if (isset($lines[0])) {for ($i=0; $i<$newitogo; $i++) fputs($fp,$lines[$i]);} else fputs($fp,"");
flock ($fp,LOCK_UN);
fclose($fp);

Header("Location: admin.php?event=userwho&page=$page"); exit; } 







// ���� �����ר�� ���������� ����������

if(isset($_GET['newstatistik'])) {


$lines=null; $ok=null;
// 1. ��������� � ��������� � ������ ���� � �������
$ulines=file("$datadir/usersdat.php"); $ui=count($ulines);

// 2. ��������� ���� ����������
$slines=file("$datadir/userstat.dat"); $si=count($slines)-1;

// ���� �� ���-�� ������ � ����
for ($i=1;$i<$ui;$i++) {
$udt=explode("|", $ulines[$i]);
if ($i<=$si) $sdt=explode("|",$slines[$i]); else $sdt[0]="";

if ($udt[0]==$sdt[0]) {$udt[0]=str_replace("\r\n","",$udt[0]); $ok=1; if (isset($sdt[1]) and isset($sdt[2]) and isset($sdt[3]) and isset($sdt[4])) {$lines[$i]="$slines[$i]";} else {$lines[$i]="$udt[0]|0|0|0|0|||||\r\n";}} // ���� ���=��� - ������ ������ �����

// ���� � ����� ���������� - ����� ������ �������� �����
if ($ok!="1") {

for ($j=1;$j<$si;$j++) {
$sdt=explode("|", $slines[$j]);
if ($udt[0]==$sdt[0]) {$ok=1; $lines[$i]=$slines[$j]; }// ���� ���=��� - ������ ������ �����
}

if ($ok!="1") $lines[$i]="$udt[0]|0|0|0|0|||||\r\n"; // ������ ����� � ������� �����������
}
$ok=null; $ii=count($lines);}

$fp=fopen("$datadir/userstat.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� �����
fputs($fp,"���_�����|���|���������|���������|�������������� �/5|����� ��������� ��� ������ ������� � UNIX �������|||\r\n");
for ($i=1;$i<=$ii;$i++) fputs($fp,"$lines[$i]");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

Header("Location: admin.php?event=userwho"); exit; }







// ���� ��������� ������� ���������
if(isset($_GET['newstatus'])) { if ($_GET['newstatus'] !="") { $newstatus=$_GET['newstatus']-1; $status=$_POST['status'];
if (isset($_GET['page'])) $page=$_GET['page']; else $page=1;
if (strlen($status)<3) exit("����� ������ ��������� <B> < 3 �������� </B> - ��� �� ��������!");
$status=htmlspecialchars($status); $status=stripslashes($status);
$status=str_replace("|"," ",$status); $status=str_replace("\r\n","<br>",$status);
$lines=file("$datadir/usersdat.php"); $i=count($lines);
$dt=explode("|", $lines[$newstatus]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]|$status|";

$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� �����
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$newstatus) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; } }




// ���� ��������� �������� ���������
if(isset($_GET['newreiting'])) { if ($_GET['newreiting'] !="") { $newreiting=$_GET['newreiting']-1; $reiting=$_POST['reiting'];
if (isset($_GET['page'])) $page=$_GET['page']; else $page=1;
$reiting=htmlspecialchars($reiting); $reiting=stripslashes($reiting);
$reiting=str_replace("|"," ",$reiting); $reiting=str_replace("\r\n","<br>",$reiting);
$lines=file("$datadir/usersdat.php"); $i=count($lines);
$dt=explode("|", $lines[$newreiting]);
$txtdat="$dt[0]|$dt[1]|$reiting|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]|$dt[13]|";

$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� �����
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$newreiting) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; } }




// �������� ��������� �����
if(isset($_GET['newrepa'])) {
if (isset($_GET['page'])) $page=$_GET['page']; else $page=1;
$text=$_POST['repa']; $usernum=$_POST['usernum']-1;
$text=htmlspecialchars($text); $text=stripslashes($text);
$text=str_replace("|"," ",$text); $repa=str_replace("\r\n","<br>",$text);

$lines=file("$datadir/userstat.dat");
$dt=explode("|", $lines[$usernum]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$repa|$dt[4]|$dt[5]|$dt[6]|$dt[7]|||";
$fp=fopen("$datadir/userstat.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� �����
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$usernum) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; }






// ���������/������� ������ �����
if(isset($_GET['userstatus'])) {
if (isset($_GET['page'])) $page=$_GET['page']; else $page=1;
$text=$_POST['submit']; $status=$_POST['status']; $usernum=$_POST['usernum']-1;
$text=htmlspecialchars($text); $text=stripslashes($text);
$text=str_replace("|"," ",$text); $submit=str_replace("\r\n","<br>",$text);
if (!ctype_digit($status)) $status=0;
$status=$status+$submit; // ������������ ������ (+1 ��� -1)
// 0 <= ������ <= 5 (������ ���� ����� ����, �� ������ ���� ����� ����)
if($status<0 or $status>5) exit("$back ������ ������������ ������ ���� ����� ����, �� ������ ���� ����� ����!");
$lines=file("$datadir/userstat.dat");
if (!isset($lines[$usernum])) exit("������! ��� ������ ������������ � ����� ����������!"); // ���� ��� ����� ������ � ����� ����������
$dt=explode("|", $lines[$usernum]); 
// � ������ 1.8.2 ��� ���� 5 ����� � ������ ����� userstat.dat. 
// ���������� �� ������ - ������ ������ ����
if (!isset($dt[6])) $dt[6]="";
if (!isset($dt[7])) $dt[7]="";
$dt[6]=str_replace("\r\n","",$dt[6]); $dt[7]=str_replace("\r\n","",$dt[7]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$status|$dt[5]|$dt[6]|$dt[7]|||";
$fp=fopen("$datadir/userstat.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� �����
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$usernum) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; }









// ���������� ������ �����������
if (isset($_GET['event'])) { if ($_GET['event']=="voteadd") { 

$id=replacer($_GET['id']); // �������� ������ �� �����
$fid=replacer($_GET['fid']); $toper=replacer($_POST['toper']);

$i=1; $itgo=0; $text="$toper||\r\n";

do {
 $otv=replacer($_POST["otv$i"]); $otv=str_replace("|","I",$otv); $otv=str_replace("\r\n","<br>",$otv);
 $kolvo=replacer($_POST["kolvo$i"]); $kolvo=str_replace("|","I",$kolvo); $kolvo=str_replace("\r\n","<br>",$kolvo);
 if (strlen($otv)>2) {$itgo++; $text.="$otv|$kolvo|\r\n";}
 $i++;
} while ($i<$golositogo);

if ($itgo<1) exit("������ ���� ������ ���� ������� ������!");

// ������ ���� � ������������
$fp=fopen("$datadir/$id-vote.dat","w");
flock ($fp,LOCK_EX);
fputs($fp,"$text");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$datadir/$id-vote.dat", 0644);

// ������ ���� ��� ������ IP������ ������������
$fp=fopen("$datadir/$id-ip.dat","w");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$datadir/$id-ip.dat", 0644);

Header("Location: admin.php?fid=$fid&id=$id"); exit; }} // ����� ���������� ������ �����������










// ���� ����������/��������������/�������� �����������

// � �������� ��������� - ��������!!!!

if(isset($_GET['vote'])) { $vote=$_GET['vote'];
$fid=$_GET['fid']; $id=$_GET['id'];

if ($vote=="delete") { // ������� - ��������
if (is_file("$datadir/$id-vote.dat")) {unlink ("$datadir/$id-vote.dat"); unlink ("$datadir/$id-ip.dat");}} // ������� ����� � ������������



if ($vote=="change") { } // ������� - ��������������

if ($vote=="add") {

if (is_file("$datadir/$id-vote.dat")) exit("$back. ����������� ��� ��������� � ����. ����� ������ ����������� ��������� ������!");


} // ������� - ����������

if ($vote=="addsave") { } // ���������� ����� ����� ���������� ��� ��������������

Header("Location: admin.php?fid=$fid&id=$id"); exit;}












// ���� ����������� �����/���� ������� ��� ������
if(isset($_GET['movetopic'])) { if ($_GET['movetopic'] !="") {
$move1=$_GET['movetopic']; $where=$_GET['where']; 
if ($where=="0") $where="-1";
$move2=$move1-$where;
$file=file("$datadir/mainforum.dat"); $imax=sizeof($file);
if (($move2>=$imax) or ($move2<"0")) exit(" ���� ���� �������!");
$data1=$file[$move1]; $data2=$file[$move2];

$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� ����� 
// ������ ������� ��� �������� �������
for ($i=0; $i<$imax; $i++) {if ($move1==$i) fputs($fp,$data2); else  {if ($move2==$i) fputs($fp,$data1); else fputs($fp,$file[$i]);}}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; }}




// ���� �������� ���������� ������� ��� ������
if(isset($_GET['fxd'])) { if ($_GET['fxd'] !="") {
$fxd=$_GET['fxd'];
$file=file("$datadir/mainforum.dat");

// ������� ������, ��������������� ���� � ����� �� ����� ������
$fp=fopen("$datadir/mainforum.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) {if ($i==$fxd) unset($file[$i]);}
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; } }





// ���� �������� ��������� ����
if (isset($_GET['xd'])) { if ($_GET['xd'] !="") {
if (isset($_GET['page'])) $page=$_GET['page']; else $page="0";
$xd=$_GET['xd']; $fid=$_GET['fid']; $id=$_GET['id'];
$file=file("$datadir/topic$fid.dat");

$minmsg=1; $delf=null; if (isset($file[$xd])) {
$dt=explode("|", $file[$xd]);
$delf = str_replace("\r\n", "", $dt[7]);
$mlines=file("$datadir/$delf.dat"); $minmsg=count($mlines);
unlink ("$datadir/$delf.dat");} // ������� ���� � �����

// ������� ������, ��������������� ���� � ����� � �������� ������
$fp=fopen("$datadir/topic$fid.dat","w");
$kolvotem=sizeof($file)-1; // ���-�� ��� ��� ��������� �� �������
flock ($fp,LOCK_EX); 
for ($i=0;$i< sizeof($file);$i++) {if ($i==$xd) unset($file[$i]);}
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);


// ���� �������� 1-�� �� ���-�� ��� � �������� ���-�� ���������
$lines = file("$datadir/mainforum.dat"); $i=count($lines);
// ������� �� fid ����� ������
for ($ii=0;$ii< sizeof($lines);$ii++) {$kdt=explode("|",$lines[$ii]); if ($kdt[0]==$fid) $mnumer=$ii;}
$dt=explode("|",$lines[$mnumer]);
$dt[5]=$dt[5]-$minmsg;
if ($kolvotem=="0") $dt[5]="0";
if ($dt[5]<0) $dt[5]="0";
if ($dt[4]<0) $dt[4]="0";
// ���� ��������� ���� ����� �� ������� ��� ���������, �� ������� � � �������
if ($dt[3]==$delf or $dt[5]==0) {$dt[6]="";$dt[7]="";$dt[8]="";$dt[9]="";$dt[10]="";}
$text="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$kolvotem|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]||";
$file=file("$datadir/mainforum.dat");
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($ii=0;$ii< sizeof($file);$ii++) { if ($mnumer!=$ii) fputs($fp,$file[$ii]); else fputs($fp,"$text\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);


// ������� ���������� �� 10-�� ���������
$file=file("$datadir/news.dat");
$fp=fopen("$datadir/news.dat","w");
flock ($fp,LOCK_EX);
for ($i=0; $i< sizeof($file); $i++) { $dt=explode("|",$file[$i]); if ($dt[1]==$id) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);


Header("Location: admin.php?fid=$fid&page=$page"); exit; } }





// ���� �������� ���������� ���������
if (isset($_GET['topicxd'])) { if ($_GET['topicxd'] !="") {
$fid=$_GET['fid']; $id=$_GET['id']; $topicxd=$_GET['topicxd']-1;
if (isset($_GET['page'])) $page=$_GET['page']; else $page="1";
$file=file("$datadir/$id.dat");
if (count($file)==1) exit("� ���� ������ �������� ������ <B>���� ���������!</B>");
$fp=fopen("$datadir/$id.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) { if ($i==$topicxd) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);
$topicxd--;

$file=file("$datadir/$id.dat");
//������������ ������ ���������� ��������� � ����
$dt=explode("|",$file[count($file)-1]); $avtor=$dt[0]; $data=$dt[5]; $time=$dt[6];


// ���� �������� 1-�� �� ���-�� ��������� �� �������
$lines = file("$datadir/mainforum.dat"); $i=count($lines);
// ������� �� fid ����� ������
for ($ii=0;$ii< sizeof($lines);$ii++) { $kdt=explode("|",$lines[$ii]); if ($kdt[0]==$fid) $mnumer=$ii; }
$dt=explode("|",$lines[$mnumer]);
$dt[5]--; if ($dt[5]<0) $dt[5]="0";
$text="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$dt[4]|$dt[5]|$avtor|$data|$time|$dt[9]|$dt[10]|$dt[11]||$dt[12]||";
$file=file("$datadir/mainforum.dat");
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($ii=0;$ii< sizeof($file);$ii++) { if ($mnumer!=$ii) fputs($fp,$file[$ii]); else fputs($fp,"$text\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?fid=$fid&id=$id&page=$page#m$topicxd"); exit; } }





// ���������� ������ / �������
if(isset($_GET['event'])) { if ($_GET['event'] =="addmainforum") {
$ftype=$_POST['ftype']; $zag=$_POST['zag']; $msg=$_POST['msg'];
if ($zag=="") exit("$back <B>� ������� ���������!</B>");

// ��������� �� ����� � �������� ��������/������� - ���� ���������� � ��������� +1
$nextnum="0";
if (is_file("$datadir/mainforum.dat")) { $lines=file("$datadir/mainforum.dat"); $imax = count($lines); $i=0; do {$dt = explode("|", $lines[$i]); if ($nextnum<$dt[0]) {$nextnum=$dt[0];} $i++; } while($i < $imax); $nextnum++;}

$zag=str_replace("|","I",$zag); $msg=str_replace("|","I",$msg);
if ($ftype == "") $txtmf="$nextnum|$zag|$msg||0|0||$date|$time||||||"; else $txtmf="$nextnum|$ftype|$zag|";
$txtmf=htmlspecialchars($txtmf); $txtmf=stripslashes($txtmf); $txtmf=str_replace("\r\n","<br>",$txtmf);

// ������ ������ �� ������� ��������
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$txtmf\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; }





// ���� ���������� ����������
if(isset($_GET['event'])) { if ($_GET['event'] =="sortusers") { $kaksort=$_POST['kaksort']; $lines="";

// ��������� ��� ����� � ������
$dat="$datadir/usersdat.php"; $dlines=file("$dat"); $di=count($dlines);
$stat="$datadir/userstat.dat"; $slines=file("$stat"); $si=count($slines);

$msguser=1000; // ����� ���-�� ����������� ��������� - ���� �������!!!!

if ($di!=$si) exit("$back - ���������� ����������� ���������� ����������!!! ���� �������� ��������!!!");

for ($i=1;$i<$di;$i++) {
$dt=explode("|",$dlines[$i]);
$st=explode("|",$slines[$i]);

if ($dt[0]!=$st[0]) exit("$back ���������� ����������� ���������� ����������!!! ���� �������� ��������!!!");
/* kaksort
1 - ����� $dt[0]
2 - ���-�� ��������� $st[2]
3 - ���-�� ���� dt[2]
4 - ��������� $st[3]
5 - ���� ����������� $dt[4]
6 - ���������� $dt[4]/$st[2]
*/
// ��� ���������� �� ������ ����� ������ ������ ��������
if ($kaksort==1) {$name=strtolower($dt[0]); $lines[$i]="$name|";}
if ($kaksort==2) {$msg="0".+9999-$st[2]; $lines[$i]="$msg|";}
if ($kaksort==3) {$msg="0".+99-$dt[2]; $lines[$i]="$msg|";}
if ($kaksort==4) {$msg="0".+9000-$st[3]; $lines[$i]="$msg|";}

if ($kaksort>4) {
$akt=explode(".",$dt[4]); $tekdt=mktime();
$datereg=mktime(0,0,0,$akt[1],$akt[0],$akt[2]);
$aktiv=round(($tekdt-$datereg)/86400);
$aktiv=round(100*$msguser/$aktiv)/100;
if ($kaksort==5) $lines[$i]="$datereg|";
if ($kaksort==6) $lines[$i]="$aktiv|"; }

// ��������� ��� ����� � ���� ����������
$lines[$i].="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]|$dt[13]|$st[1]|$st[2]|$st[3]|$st[4]|$st[5]|||\r\n";

} // ����� FOR

// ��������� ������
setlocale(LC_ALL,'ru_RU.CP1251'); // ! ��������� ������ �������, ���������� � ���������� � � �������� �������
function prcmp ($a, $b) {if ($a==$b) return 0; if ($a<$b) return -1; return 1;} // ������� ����������
usort($lines,"prcmp"); // ��������� ��� �� �����������

// ��������� �� ��� ������� � �� ������� �� ���������
$dlines=null; $dlines="<?die;?>\r\n"; $slines=null; $slines="���_�����|���|���������|���������|�������������� �/5|����� ��������� ��� ������ ������� � UNIX �������|||\r\n";

for ($i=0;$i<$di-1;$i++) {
$nt=explode("|",$lines[$i]);
$dlines.="$nt[1]|$nt[2]|$nt[3]|$nt[4]|$nt[5]|$nt[6]|$nt[7]|$nt[8]|$nt[9]|$nt[10]|$nt[11]|$nt[12]|$nt[13]|$nt[14]|||\r\n";
$slines.="$nt[1]|$nt[15]|$nt[16]|$nt[17]|$nt[18]|$nt[19]|||\r\n";
}

// ������ ������
$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
fputs($fp,"$dlines");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

$fp=fopen("$datadir/userstat.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
fputs($fp,"$slines");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

Header("Location: admin.php?event=userwho"); exit; }}





// �������������� ������ / �������
if ($_GET['event'] =="frdmainforum") {
$nextnum=$_POST['nextnum'];
$frd=$_POST['frd'];
$ftype=$_POST['ftype'];
$zag=$_POST['zag'];
if ($zag=="") exit("$back <B>� ������� ���������!</B>");
$zag=str_replace("|","I",$zag);

if ($ftype == "") { $addmax=$_POST['addmax']; $zvezdmax=$_POST['zvezdmax'];
$msg=$_POST['msg'];$idtemka=$_POST['idtemka'];$kt=$_POST['kt'];$km=$_POST['km'];$namem=$_POST['namem'];$datem=$_POST['datem'];$timem=$_POST['timem'];$temka=$_POST['temka'];$timetk=$_POST['timetk'];
$msg=str_replace("|","I",$msg); $msg=str_replace("\r\n", "<br>", $msg);
$txtmf="$nextnum|$zag|$msg|$idtemka|$kt|$km|$namem|$datem|$timem|$timetk|$temka|$addmax|$zvezdmax||";}
else $txtmf="$nextnum|$ftype|$zag|";

$txtmf=htmlspecialchars($txtmf); $txtmf=stripslashes($txtmf); $txtmf=str_replace("\r\n","<br>",$txtmf);

$file=file("$datadir/mainforum.dat");
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//������� ���������� ����� 
for ($i=0;$i< sizeof($file);$i++) { if ($frd!=$i) fputs($fp,$file[$i]); else fputs($fp,"$txtmf\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; }




if ($_GET['event'] =="rdtema") { // ������� �������������� ����
$rd=$_POST['rd']; // - ����� ������, ������� ���������� ��������
$fid=$_POST['fid']; $changefid=$_POST['changefid'];
if (isset($_GET['page'])) $page=$_GET['page']; else $page="0";

$name=$_POST['name']; $who=$_POST['who']; $email=$_POST['email'];
$zag=$_POST['zag']; $msg=$_POST['msg']; $datem=$_POST['datem'];
$timem=$_POST['timem']; $id=$_POST['id']; $timetk=$_POST['timetk'];
$status=$_POST['status']; $goto=$_POST['goto'];

if ($goto==1) $goto="admin.php?fid=$changefid"; else $goto="admin.php?fid=$fid&page=$page";

if ($zag=="") exit("$back <B>� ������� ����, ��� ������!</B>");
$text="$name|$who|$email|$zag|$msg|$datem|$timem|$id|$status|$timetk|";
$text=htmlspecialchars($text); $text=stripslashes($text); $text=str_replace("\r\n","<br>",$text);


if ($changefid==$fid) { // ���� ������� ������� �����
$file=file("$datadir/topic$fid.dat");
$fp=fopen("$datadir/topic$fid.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� ����� 
for ($i=0;$i<sizeof($file);$i++) { if ($rd!=$i) fputs($fp,$file[$i]); else fputs($fp,"$text\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

} else { // ���� ������ ������� ����

// $fid - �������, �  $changefid - ��� ����� ��� ������.

// 1. ������ ����� ���� � ����� ������

touch("$datadir/topic$changefid.dat");
$file=file("$datadir/topic$changefid.dat");
$kolvotem1=sizeof($file)+1; // ���-�� ��� ��� ��������� �� �������
$fp=fopen("$datadir/topic$changefid.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

// 2. ������� ���� � ������� ������

touch("$datadir/topic$fid.dat");
$file=file("$datadir/topic$fid.dat");
$fp=fopen("$datadir/topic$fid.dat","w+");
$kolvotem2=sizeof($file)-1; // ���-�� ��� ��� ��������� �� �������
flock ($fp,LOCK_EX); 
for ($i=0;$i< sizeof($file);$i++) { if ($i==$rd) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);

// 3. ��������� �������� �� ���� ��� � ����� ����������

// �������� � ��������� ������!!!
// ��������� ��� ����� ���������� � ����. ������� ������� �� �������,
// ��������������� � ����������� ������ � ����� ������
// � ����������� ��� ������ � ���� mainforum.dat

// ���� �������� 1-�� �� ���-�� ��� � �������� ���-�� ���������
$file=file("$datadir/$id.dat"); $minmsg=count($file);
$lines=file("$datadir/mainforum.dat"); $i=count($lines);
// ������� �� $changefid ����� ������

for ($ii=0;$ii< sizeof($lines);$ii++) { $kdt=explode("|",$lines[$ii]); if ($kdt[0]==$fid) $mnumer=$ii; }
$dt=explode("|",$lines[$mnumer]);
$dt[5]=$dt[5]-$minmsg;
if ($kolvotem2=="0") $dt[5]="0";
if ($dt[5]<0) $dt[5]="0";
if ($dt[4]<0) $dt[4]="0";
// ���� ��������� ���� ����� �� ������� ��� ���������, �� ������� � � �������
if ($dt[3]==$id or $dt[5]==0) {$dt[6]="";$dt[7]="";$dt[8]="";$dt[9]="";$dt[10]="";}
$text="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$kolvotem2|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]||";
$file=file("$datadir/mainforum.dat");
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($ii=0;$ii< sizeof($file);$ii++)
{ if ($mnumer!=$ii) fputs($fp,$file[$ii]); else fputs($fp,"$text\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

// ���� ���������� 1-�� � ���-�� ��� � ��������� ���-�� ���������
for ($ii=0;$ii< sizeof($lines);$ii++) { $kdt=explode("|",$lines[$ii]); if ($kdt[0]==$changefid) $mnumer=$ii; }
$dt=explode("|",$lines[$mnumer]);
$dt[5]=$dt[5]+$minmsg;
if ($kolvotem1=="0") $dt[5]="0";
if ($dt[5]<0) $dt[5]="0";
if ($dt[4]<0) $dt[4]="0";
// ���� ��������� ���� ����� �� ������� ��� ���������, �� ������� � � �������
if ($dt[3]==$id or $dt[5]==0) {$dt[6]="";$dt[7]="";$dt[8]="";$dt[9]="";$dt[10]="";}
$text="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$kolvotem1|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]||$dt[12]||";
$file=file("$datadir/mainforum.dat");
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($ii=0;$ii< sizeof($file);$ii++)
{ if ($mnumer!=$ii) fputs($fp,$file[$ii]); else fputs($fp,"$text\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

// 4. ������� news.dat. ���� ���� ������� ����� (������� ���������� �� 10-�� ���������)

$file=file("$datadir/news.dat");
$fp=fopen("$datadir/news.dat","w");
flock ($fp,LOCK_EX);
for ($i=0; $i< sizeof($file); $i++) {
$dt=explode("|",$file[$i]); if ($dt[1]==$id) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: $goto"); exit; }


// ������� ����� �������� ������� � ������ ������ ����� � �����������
$linesrdt=file("$datadir/$id.dat");
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//������� ����������
for ($i=0;$i< sizeof($linesrdt);$i++) {$drdt=explode("|", $linesrdt[$i]); $text1="$drdt[0]|$drdt[1]|$drdt[2]|$zag|$drdt[4]|$drdt[5]|$drdt[6]|$drdt[7]|$drdt[8]|$drdt[9]|"; $text1=str_replace("\r\n", "", $text1); fputs($fp,"$text1\r\n");}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
// ���� ����� ��VIP��� ���� - ���������� � ��� 2 ���� � ������������ ���
if ($_POST['viptema']==="1") { $viptime=strtotime("+2 year"); touch("$datadir/$id.dat",$viptime);}
Header("Location: $goto"); exit; }


} // if $event==rdtema












// ���������� ���� ��� ������ - ��� 1
if(isset($_GET['event'])) {
if (($_GET['event']=="addtopic") or ($_GET['event']=="addanswer")) {
if (isset($_POST['name'])) $name=$_POST['name'];
$name=trim($name); // �������� ���������� ������� 
$zag=$_POST['zag']; $msg=$_POST['msg']; $fid=$_GET['fid'];
if (isset($_POST['who'])) $who=$_POST['who']; else $who="";
if (isset($_POST['email'])) $email=$_POST['email']; else $email="";
if (isset($_POST['page'])) $page=$_POST['page'];
if ($_GET['event']=="addanswer") $id=$_POST['id'];
$maxzd=$_POST['maxzd']; if (!ctype_digit($maxzd) or strlen($maxzd)>2) exit("<B>$back. ������� ������. ������� ����� �� �����.</B>");

// ������ �� ������ fid
if (!ctype_digit($fid) or strlen($fid)>2) exit("<B>$back. ������� ������. ������� ����� �� �����.</B>");

// �������� �� ���� �������� � ������� - ���� �������������
// �� ��� ������, ���� mainforum.dat - ����, ���������� ��������� �����

$realbase="1"; if (is_file("$datadir/mainforum.dat")) $mainlines=file("$datadir/mainforum.dat");
if (!isset($mainlines)) $datasize=0; else $datasize=sizeof($mainlines);
if ($datasize<=0) {if (is_file("$datadir/copy.dat")) {$realbase="0"; $mainlines=file("$datadir/copy.dat"); $datasize=sizeof($mainlines);}}
if ($datasize<=0) exit("$back. �������� � ����� ������ - ���������� � ��������������");
$i=count($mainlines);

$realfid=null;
do {$i--; $dt=explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$realfid=$i; if ($dt[1]=="razdel") exit("$back. ������� ������.");} // ����������� $realfid - � �/� ������
} while($i>0);

if (!isset($realfid)) exit("$back. ������ � ������� �������. ��� �� ���������� � ����.");

$dt=explode("|",$mainlines[$realfid]);
if (is_file("$datadir/topic$fid.dat")) {$tlines=file("$datadir/topic$fid.dat"); $tc=count($tlines)-2; $i=$tc+2; $ok=null;
// ����� ����������� �� ������, ����� ����. ���� ���� - �������, ���� - ������ ���������� ��������� ���������!
if ($_GET['event']=="addanswer") {
do {$i--; $tdt=explode("|", $tlines[$i]);
if ($tdt[7]==$id) {$ok=1; if ($tdt[8]=="closed") exit("$back ���� ������� � ���������� ��������� ���������!"); }
} while($i>0);
if ($ok!=1) exit("$back ���� ������� � ���������� ��������� ���������!"); }

} else $tc="2";
if ($dt[11]>0 and $tc>=$dt[11]) exit("$back. ��������� ����������� �� ���-�� ���������� ��� � ������ �������! �� ����� <B>$dt[11]</B> ���!");

// �������� ������/������ �����. ����� �� �����, ����� ����� ���

// ���� 1
if (isset($_COOKIE['wrfcookies'])) {
    $wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc);
    $wrfc=explode("|", $wrfc);  $wrfname=$wrfc[0]; $wrfpass=$wrfc[1];
} else {$who=""; unset($wrfname); unset($wrfpass);}

// ���� 2
if ($who=="��") {
if (isset($wrfname) & isset($wrfpass)) {
$lines=file("$datadir/usersdat.php"); $i=count($lines);
do {$i--; $rdt=explode("|", $lines[$i]);
   if (isset($rdt[1])) { $realname=strtolower($rdt[0]);
   if (strtolower($wrfname)===$realname & $wrfpass===$rdt[1]) $ok="$i"; }
} while($i > "1");
if (!isset($ok)) {setcookie("wrfcookies","",time()); exit("������ ��� ������ � ����! <font color=red><B>�� �� ������� �������� ���������, ���������� ������ ��� ��� �����.</B></font> ��� ����� � ������ �� ������� � ���� ������, ���������� ����� �� ����� �����. ���� ������ ����������� - ���������� � �������������� ������.");}
}}


if (!isset($name) || strlen($name) > $maxname || strlen($name) <1) exit("$back ���� <B>��� ������, ��� ��������� $maxname</B> ��������!</B></center>");
if (strlen(ltrim($zag))<3 || strlen($zag) > 200) exit("$back ������� �������� �������� ���� ��� <B>�������� ��������� $maxzag</B> ��������!</B></center>");
if (strlen(ltrim($msg))<2 || strlen($msg) > 10000) exit("$back ���� <B>��������� �������� ��� ��������� $maxmsg</B> ��������.</B></center>");
if (!preg_match('/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$/si',$email) and strlen($email)>30 and $email!="") exit("$back � ������� ���������� E-mail �����!</B></center>");

// ���������� ��� ����� � �����
if ($_GET['event'] =="addtopic") {$add=null; $z=null; do {$id=mt_rand(1000,9999); if ($fid<10) $add="0"; if (!is_file("$datadir/$add$fid$id.dat") and strlen($id)==4) {$z++;} } while ($z<1); $id="$add$fid$id";}
if ((!ctype_digit($id)) or (strlen($id)>15)) exit("<B>$back. ������� ������. $id ������ ���� ������. ������� ����� �� �����.</B>");
if (strlen(ltrim($zag))<3) exit("$back ! ������ � ����� ������ ���������!");

$tektime=time();
$name=wordwrap($name,30,' ',1); // ��������� ������� ������
$zag==wordwrap($zag,30,' ',1);
$msg=wordwrap($msg,110,' ',1);

$name=str_replace("|","I",$name);
$who=str_replace("|","&#124;",$who);
$email=str_replace("|","&#124;",$email);
$zag=str_replace("|","&#124;",$zag);
$msg=str_replace("|","&#124;",$msg);

$smname=$name; if (strlen($name)>18) {$smname=substr($name,0,18); $smname.="..";}
$smzag=$zag; if (strlen($zag)>24) {$smzag=substr($zag,0,24); $smzag.="..";}

$text="$name|$who|$email|$zag|$msg|$date|$time|$id||$tektime|$smname|$smzag|||";
$text=replacer($text);
$exd=explode("|",$text); 
$name=$exd[0]; $zag=$exd[3]; $smname=$exd[10]; $smzag=$exd[11]; $smmsg=$exd[4];



// ������� �������� ����� - ��������� ���������� ���������/���� ���������!
if (isset($tlines)) {
if ($tc<"-1") {$sdt[0]=null; $sdt[3]=null;} else {$last=$tlines[$tc+1]; $sdt=explode("|",$last);}

if ($_GET['event'] =="addtopic")  { // ���� ���������� ����: ��� = ��� � �����, ���� = ��������� ���� � �����
if ($name==$sdt[0] and $exd[3]==$sdt[3]) exit("$back. ����� ���� ��� �������. ������� �� ������ ���������!");

} else { // ���� ���������� ���������: ��� = ��� � �����, ��������� = ���������� ��������� � �����
if (is_file("$datadir/$id.dat")) {$linesn=file("$datadir/$id.dat"); $in=count($linesn)-1;
if ($in > 0) { $dtf=explode("|",$linesn[$in]);
if ($name==$dtf[0] and $exd[4]==$dtf[4]) exit("$back. ����� ��������� ��� ��������� � ������ ����. ������� �� ������ ���������!"); }
}
}} // if $event=="addtopic"



if(isset($_GET['topicrd'])) { // ������� �������������� ���������
$topicrd = $_GET['topicrd']; // ����� ������, ������� ���������� ��������
$file=file("$datadir/$id.dat");
$fs=count($file)-1; $i="-1";

$timetek=time(); $timefile=filemtime("$datadir/$id.dat"); 
$timer=$timetek-$timefile; // ������ ������� ������ ������� (� ��������) 
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� ����� 
do {$i++; if ($i==$topicrd) fputs($fp,"$text\r\n"); else fputs($fp,$file[$i]); } while($i < $fs);
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
if ($timer<0) {$viptime=strtotime("+2 year"); touch("$datadir/$id.dat",$viptime);}

Header("Location: admin.php?fid=$fid&id=$id&page=$page"); exit; }

print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>";

// ���� ������� ������� ��, �� ������ ���� �������� ����� � ���� ����� ������ �����
if ($_GET['event'] =="addanswer")  { //��� ������ � ����

// ���������, ����� �� �������������� ����
$timetek=time(); $timefile=filemtime("$datadir/$id.dat"); 
$timer=$timetek-$timefile; // ������ ������� ������ ������� (� ��������) 
// $timer<10 - 10 ������ ������ �� ���������
if ($smmsg=="��!") {
if ($timer<10 and $timer>0) exit("$back ���� ���� ������� ����� $timer ������ �����.");
touch("$datadir/$id.dat");
print "<script language='Javascript'>function reload() {location = \"admin.php?fid=$fid&id=$id&page=$page#m$in\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$name</B>, ���� ��������������.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� � ������� ���� <BR><B>$zag</B>.<BR><BR>
<B><a href='admin.php?fid=$fid&id=$id&page=$page#m$in'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit; }

if ($timer<10 and $timer>0) exit("$back ���� ���� ������� ����� $timer ������ �����.");
}


$razdelname="";
if ($realbase=="1" and $maxzd<1) { // ���� ���������� ������� ����, � �� �����
$lines=file("$datadir/mainforum.dat");
$dt=explode("|", $lines[$realfid]); $dt[5]++;
if ($_GET['event']=="addtopic") $dt[4]++;

// �� ������ 4-� ������ ����� ��� �������� ��� � �����!
if (!isset($dt[11])) $dt[11]="100"; $dt[11]=str_replace("
", "<br>", $dt[11]);
if (!isset($dt[12])) $dt[12]=""; $dt[12]=str_replace("
", "<br>", $dt[12]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$id|$dt[4]|$dt[5]|$smname|$date|$time|$tektime|$smzag|$dt[11]|$dt[12]||";
$razdelname=$dt[1];
// ������ ������ �� ������� ��������
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//������� ���������� �����
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$realfid) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
} // if ($realbase=="1")

if ($newmess=="1" and $maxzd<1) { // ������ � ��������� ���� ������ ���������
if (is_file("$datadir/topic$fid.dat")) $nlines=count(file("$datadir/topic$fid.dat")); else $nlines=1;

if (is_file("$datadir/$id.dat")) $nlines2=count(file("$datadir/$id.dat"))+1; else $nlines2=1;

$newmessfile="$datadir/news.dat";
$newlines=file("$newmessfile"); $ni=count($newlines)-1; $i2=0; $newlineexit="";

$nmsg=substr($msg,0,150); // �������� ��������� �� 150 ��������
$ntext="$fid|$id|$date|$time|$smname|$zag|$nmsg...|$nlines|$nlines2|$razdelname|$who||||";
$ntext=str_replace("
", "<br>", $ntext);

// ���� ���������, ���� �� ��� ����� ��������� � ���� ����. ���� ���� - ���������. �� ������ - ������ ��� ���� ������.
for ($i=0;$i<=$ni;$i++)
{ $ndt=explode("|",$newlines[$i]);
if (isset($ndt[1])) {if ($id!=$ndt[1]) {$newlineexit.="$newlines[$i]"; $i2++;}}
}
// ���������� ������ ��������� � ������ � ����� ��������� ��� � ����
if ($maxzd<1) { // ���� ���� �������� ��� ���� - ��� ����������� �� ������
if ($i2>0) { // ���� ���� ����� ����, �� ����� ���� ������, ����� ���� ������
$newlineexit.=$ntext;
$fp=fopen("$newmessfile","w");
flock ($fp,LOCK_EX);
fputs($fp,"$newlineexit\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
} else {
$fp=fopen("$newmessfile","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$ntext\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp); }

$file=file($newmessfile);$i=count($file);
if ($i>="15") {
$fp=fopen($newmessfile,"w");
flock ($fp,LOCK_EX);
unset($file[0]);
fputs($fp, implode("",$file));
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
}
}
}
} // if ($newmess=="1")


// ���� ��������� +1 � ���� � +1 � ��������� ��� +1 � ���-�� ���, ��������� ������

if (isset($_COOKIE['wrfcookies']) and (isset($ok))) {

$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1; $ulinenew="";

// ���� ����� �� ����� � ����� userstat.dat
for ($i=0;$i<=$ui;$i++) {$udt=explode("|",$ulines[$i]);
if ($udt[0]==$wrfname) {
$udt[3]++; $udt[2]++; if ($_GET['event']=="addtopic") $udt[1]++;
$ulines[$i]="$udt[0]|$udt[1]|$udt[2]|$udt[3]|$udt[4]|$udt[5]||||\r\n";}
$ulinenew.="$ulines[$i]";}
// ����� ������ � ����
$fp=fopen("$ufile","w");
flock ($fp,LOCK_EX);
fputs($fp,"$ulinenew");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

} // if isset($ok)



if ($_GET['event'] =="addtopic")  { // ���������� ���� - ������ ������
// ����� � �����
$fp=fopen("$datadir/topic$fid.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

// ����� � ����
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

print "<script language='Javascript'>function reload() {location = \"admin.php?fid=$fid&id=$id\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$name</B>, �� ���������� ����!<BR><BR>����� ��������� ������ �� ������ ������������� ���������� � ��������� ����.<BR><BR>
<B><a href='admin.php?fid=$fid&id=$id'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;
}



if ($_GET['event'] =="addanswer")  { //����� � ���� - ������ ������
$timetek=time(); $timefile=filemtime("$datadir/$id.dat"); 
$timer=$timetek-$timefile; // ������ ������� ������ ������� (� ��������) 
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
if ($timer<0) {$viptime=strtotime("+2 year"); touch("$datadir/$id.dat",$viptime);}

$in=$in+2; $page=ceil($in/$qq); // ����������� ������ �������� � ����� ���������

print "<script language='Javascript'>function reload() {location = \"admin.php?fid=$fid&id=$id&page=$page#m$in\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$name</B>, ��� ����� ������� ��������.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� � ������� ���� <BR><B>$zag</B>.<BR><BR>
<B><a href='admin.php?fid=$fid&id=$id&page=$page#m$in'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;
}











// ������� ����� ��
if ($_GET['event']=="makecopy")  {
if (is_file("$datadir/mainforum.dat")) $lines=file("$datadir/mainforum.dat");
if (!isset($lines)) $datasize=0; else $datasize=sizeof($lines);
if ($datasize<=0) exit("�������� � ����� ������ - ���� ����������. ������ = 0!");
if (copy("$datadir/mainforum.dat", "$datadir/copy.dat")) exit("<center><BR>����� ���� ������ �������.<BR><BR><h3>$back</h3></center>"); else exit("������ �������� ����� ���� ������. ���������� ������� ������� ���� copy.dat � ����� $datadir � ��������� ��� ����� �� ������ - 666 ��� ������ ����� 777 � ��������� �������� �������� �����!"); }

// ������������ �� ����� ��
if ($_GET['event']=="restore")  {
if (is_file("$datadir/copy.dat")) $lines=file("$datadir/copy.dat");
if (!isset($lines)) $datasize=0; else $datasize=sizeof($lines);
if ($datasize<=0) exit("�������� � ������ ���� ������ - ��� ����������. �������������� ����������!");
if (copy("$datadir/copy.dat", "$datadir/mainforum.dat")) exit("<center><BR>�� ������������� �� �����.<BR><BR><h3>$back</h3></center>"); else exit("������ �������������� �� ����� ���� ������. ���������� ������� ������ copy.dat � mainforum.dat � ����� $datadir ��������� ����� �� ������ - 666 ��� ������ ����� 777 � ��������� �������� ��������������!"); }



// ���������������� ������, ��� 2: ���������� ������
if ($_GET['event']=="config")  {

// ��������� ����� ������ ������/����������
if (strlen($_POST['newpassword'])<1 or strlen($_POST['newmoderpass'])<1) exit("$back ����������� ����� ������ ������� 1 ������!");
if ($_POST['newpassword']!="�����") {$pass=trim($_POST['newpassword']); $_POST['password']=md5("$pass+$skey");}
if ($_POST['newmoderpass']!="�����") {$pass=trim($_POST['newmoderpass']); $_POST['moderpass']=md5("$pass+$skey");}

// ������ �� ������. ��������, ��� � ������� ������ ���������� �������...
$fd=stripslashes($_POST['fdesription']); $fd=str_replace("\\","/",$fd); $fd=str_replace("?>","? >",$fd); $fd=str_replace("\"","'",$fd); $fdesription=str_replace("\r\n","<br>",$fd);

mt_srand(time()+(double)microtime()*1000000); $rand_key=mt_rand(1000,9999); // ���������� ��������� ����� ��� �����������

$gmttime=($_POST['deltahour'] * 60 * 60);  // ������� ��������

$newsmiles=$_POST['newsmiles'];

$i=count($newsmiles); $smiles="array(";
for($k=0; $k<$i; $k=$k+2) {
  $j=$k+1; $s1=replacer($newsmiles[$k]); $s2=replacer($newsmiles[$j]);
  $smiles.="\"$s1\", \"$s2\""; if ($k!=($i-2)) $smiles.=",";
} $smiles.=");";

$configdata="<? // WR-forum v 1.9.3  //  10.06.10 �.  //  Miha-ingener@yandex.ru\r\n".
"$"."fname=\"".$_POST['fname']."\"; // �������� ������ ������������ � ���� TITLE � ���������\r\n".
"$"."fdesription=\"".$fdesription."\"; // ������� �������� ������\r\n".
"$"."password=\"".$_POST['password']."\"; // ������ ������ ���������� md5()\r\n".
"$"."moderpass=\"".$_POST['moderpass']."\"; // ������ ���������� ���������� md5()\r\n".
"$"."adminemail=\"".$_POST['newadminemail']."\"; // �-���� ��������������\r\n".
"$"."sendmail=\"".$_POST['sendmail']."\"; // �������� �������� ���������? 1/0\r\n".
"$"."sendadmin=\"".$_POST['sendadmin']."\"; // ������ ������ ��������� ���������� �������������? 1/0\r\n".
"$"."statistika=\"".$_POST['statistika']."\"; // ���������� ���������� �� ������� ��������? 1/0\r\n".
"$"."antispam=\"".$_POST['antispam']."\"; // ������������� ��������\r\n".
"$"."max_key=\"".$_POST['max_key']."\"; // ���-�� �������� � ���� �����������\r\n".
"$"."absrand=\"".$rand_key."\"; // ��������� ����� ��� �����������\r\n".
"$"."newmess=\"".$_POST['newmess']."\"; // ��������� ���� � ������ ����������� ������?\r\n".
"$"."guest=\"".$_POST['newguest']."\"; // ��� �������� �� �����-�� �������������\r\n".
"$"."users=\"".$_POST['newusers']."\"; // ��� �������� �����-��\r\n".
"$"."cangutema=\"".$_POST['cangutema']."\"; // ��������� ������ ��������� ����? 1/0\r\n".
"$"."cangumsg=\"".$_POST['cangumsg']."\"; // ��������� ������ ��������� ���������? 1/0\r\n".
"$"."useactkey=\"".$_POST['useactkey']."\"; // ��������� ��������� ����� ����� ��� �����������? 1/0\r\n".
"$"."maxname=\"".$_POST['newmaxname']."\"; // ������������ ���-�� �������� � �����\r\n".
"$"."maxzag=\"".$_POST['maxzag']."\"; // ����������� ���-�� �������� � ��������� ����\r\n".
"$"."maxmsg=\"".$_POST['newmaxmsg']."\"; // ������������ ���������� �������� � ���������\r\n".
"$"."qqmain=\"".$_POST['newqqmain']."\"; // ���-�� ������������ ��� �� �������� (15)\r\n".
"$"."qq=\"".$_POST['newqq']."\"; // ���-�� ������������ ��������� �� ������ �������� (10)\r\n".
"$"."uq=\"".$_POST['uq']."\"; // �� ������� ������� �������� ������ ����������\r\n".
"$"."liteurl=\"".$_POST['liteurl']."\";// ������������ ���? 1/0\r\n".
"$"."max_file_size=\"".$_POST['max_file_size']."\"; // ������������ ������ ������� � ������\r\n".
"$"."datadir=\"".$_POST['datadir']."\"; // ����� � ������� ������\r\n".
"$"."smile=\"".$_POST['smile']."\";// ��������/��������� ����������� ������\r\n".
"$"."canupfile=\"".$_POST['canupfile']."\"; // ��������� �������� ���� 0 - ���, 1 - ������ ������������������\r\n".
"$"."filedir=\"".$_POST['filedir']."\"; // ������� ���� ����� ������� ����\r\n".
"$"."max_upfile_size=\"".$_POST['max_upfile_size']."\"; // ������������ ������ ����� � ������\r\n".
"$"."fskin=\"".$_POST['fskin']."\"; // ������� ���� ������\r\n".
"$"."back=\"<html><head><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'><meta http-equiv='Content-Language' content='ru'></head><body><center>��������� <a href='javascript:history.back(1)'><B>�����</B></a>\"; // ������� ������\r\n".
"$"."smiles=".$smiles."// �������� (��� �����, ������ ��� �������, -//-)\r\n".
"$"."date=date(\"d.m.Y\", time()+$gmttime); // �����.�����.���\r\n".
"$"."deltahour=\"".$_POST['deltahour']."\"; // ��������� ���-�� ����� �� ��������� ������������ �������� �� �������: �� * 3600\r\n".
"$"."time=date(\"H:i:s\",time()+$gmttime); // ����:������:�������\r\n?>";
$file=file("config.php");
$fp=fopen("config.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//������� ���������� ����� 
fputs($fp,$configdata);
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=configure"); exit;}


} // ����� if isset($event)




// ����� ��� ���� ������� ������

if (isset($_COOKIE['wrfcookies'])) {
$wrfc=$_COOKIE['wrfcookies']; $wrfc = explode("|", $wrfc);
$wrfname=$wrfc[0];$wrfpass=$wrfc[1];$wrftime1=$wrfc[2];$wrftime2=$wrfc[3];
if (time()>($wrftime1+50)) { $tektime=time();
$wrfcookies="$wrfc[0]|$wrfc[1]|$tektime|$wrftime1|";
setcookie("wrfcookies", $wrfcookies, time()+1728000);
$wrfc=$_COOKIE['wrfcookies']; $wrfc = explode("|", $wrfc);
$wrfname=$wrfc[0];$wrfpass=$wrfc[1];$wrftime1=$wrfc[2];$wrftime2=$wrfc[3]; }}

if (is_file("$datadir/mainforum.dat")) $mainlines=file("$datadir/mainforum.dat");
if (!isset($mainlines)) $datasize=0; else $datasize=sizeof($mainlines);
if ($datasize<=0) {if (is_file("$datadir/copy.dat")) {$mainlines=file("$datadir/copy.dat"); $datasize=sizeof($mainlines);}}
if ($datasize<=0) exit("<center><h3>���� ������ ������������! �������� �������!</h3>");

// ���� ������� � ��������� ������: ���� -> ������ -> �����
if (isset($_GET['fid'])) { $fid=$_GET['fid'];
if (!ctype_digit($fid) or strlen($fid)>2) exit("<B>$back. ������� ������. ������� ����� �� �����.</B>");
$imax=count($mainlines); $i=count($mainlines);
// �������� �� ���� �������� � ������� - ���� �������������
$raz=""; $rfid=""; $frname=""; do {$i--; $dt=explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$rfid=$i; $raz="$dt[1]"; $frname="$dt[1]"; if (isset($dt[11])) { if($dt[11]>0) $maxtem=$dt[11]; else $maxtem="100"; }}
} while($i >0);


if (isset($_GET['id'])) { $id=$_GET['id'];
if (!ctype_digit($id) or strlen($id)>15) exit("<B>$back. ������� ������. ������� ����� �� �����.</B>");
if (is_file("$datadir/$id.dat")) {
 $lines=file("$datadir/$id.dat");
  if (count($lines)>4) {$dtt=explode("|",$lines[0]); $frtname=$dtt[3];} else $frtname="";
 $ft=$frname; $frname="-> $ft ->";} else {$frtname=""; $frname="";}} else {$frtname="";  $frname.="->";} } else {$frname=""; $frtname="";}



 
 


// ����� ��� ����� - ����� ���������� ,������� ����� ����� ������������
if ($gbname==$adminname[0]) $ktotut="1"; else $ktotut="2";


// �������� �������� ������ ���� ���� ����
?>
<html>
<head>
<title>������� :: <?print"$frtname $frname $fname";?></title>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<meta name="description" content="<? print"$fdesription - $fname";?>">
<meta http-equiv="keywords" content="<? print"$frtname $frname $fname";?>">
<meta name="Resource-type" content="document">
<meta name="document-state" content="dynamic">
<meta name="Robots" content="index,follow">
<link rel="stylesheet" href="<?=$fskin?>/style.css" type="text/css">
<SCRIPT language=JavaScript>
<!--
function x () {return;}
function FocusText() {
 document.REPLIER.msg.focus();
 document.REPLIER.msg.select();
 return true; }
function DoSmilie(addSmilie) {
 var revisedMessage;
 var currentMessage=document.REPLIER.msg.value;
 revisedMessage=currentMessage+addSmilie;
 document.REPLIER.msg.value=revisedMessage;
 document.REPLIER.msg.focus();
 return;
}
function DoPrompt(action) { var revisedMessage; var currentMessage=document.REPLIER.msg.value; }
//-->
</SCRIPT>
</head>

<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5493B4" bottomMargin=0 leftMargin=0 topMargin=0 rightMargin=0 marginheight="0" marginwidth="0">

<table width=100% cellspacing=0 cellpadding=10 align=center><tr><td class=bodyline>
<table width=100% cellspacing=0 cellpadding=0>
<tr>
<td><a href="index.php"><img src="<?=$fskin?>/wr-logo.gif" border=0 alt="<?=$fname?>" vspace="1" /></a>
<br><div align=center>�� ����� ��� <B><font color=red><?print"$gbname";?></font></B></td>
<td align="center" valign="middle"><span class="maintitle"><a href=admin.php><h3><font color=red>������ �����������������<br></font> <?=$fname?></h3></a></span>
<table width=80%><TR><TD align=center><span class="gen"><?=$fdesription?><br><br></span></TD></TR></TABLE>
<table cellspacing=0 cellpadding=2><tr><td align=center valign=middle>
<a href='admin.php?event=makecopy' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" alt="" hspace="3" />������� ����� ��</a> 
<a href='admin.php?event=restore' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" alt="" hspace="3" />������������ �� �����</a> 
<a href='admin.php?event=userwho' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width=12 height=13 border=0 hspace=3 />���������</a>
<a href='admin.php?event=massmail' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" hspace="3" />�������� ��������� ����������</a>
<a href='admin.php?event=revolushion' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" hspace="3" />�����������</a>
<a href='admin.php?newstatistik' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" hspace="3" />����������� ���������� ����������</a>

<? if ($ktotut==1) print"<a href='admin.php?event=configure' class=mainmenu><img src='$fskin/buttons_spacer.gif' width='12' height='13' border='0' alt='' hspace='3' />���������</a>";
print"<a href='admin.php?event=clearcooke' class=mainmenu><img src='$fskin/buttons_spacer.gif' width='12' height='13' border='0' alt='�����' hspace='3'>����� �� �������</a>";

// ������ ���� � ������� ������������� � ������ ����� �������� ����������
$userlines=file("$datadir/usersdat.php");
$ui=count($userlines)-1;
$tdt = explode("|", $userlines[$ui]);

if (is_file("$datadir/copy.dat")) {
if (count(file("$datadir/copy.dat"))<1) $a2="<font color=red size=+1>�� ���� ����� ����! ������ ������������!</font><br> (�������� ����� �������, ���� �� ��������� �����������)"; else $a2="";
$a1=round((mktime()-filemtime("$datadir/copy.dat"))/86400); if ($a1<1) $a1="�������</font>, ��� ���� ���!"; else $a1.="</font> ���� �����.";
$add="<br><B><center>����� ���� ������� <font color=red size=+1>".$a1." $a2</B>"; if ($a1>90) $add.="�� ��, ������ 3-� ������� ������� ����� �� ������. ����������� ������? ������� �����!"; if ($a1>10) $add.="�� ���! ������ ������� �����! � ����� ����? ��� ������ ������ ���������������?!!"; if ($a1>5) $add.="���� ������ �����. �������� ���� �����. ����� ���� ��������� ��� ���� ;-)"; $add.="</center>";} else $add="";

print"</span>
</td></tr></table>
</td></tr></table>
$add<table width=100% cellspacing=0 cellpadding=2>
<tr><td><span class=gensmall>�������: $date - $time</td></tr></table>";






// ������� ������� �������� ������
if (!isset($_GET['event']))  {

if (!isset($_GET['fid'])) {
echo'
<table width=100% cellpadding=2 cellspacing=1 class=forumline>
<tr><th width=60% colspan=2 class=thCornerL height=25 nowrap=nowrap>������</th>
<th width=10% class=thTop nowrap=nowrap>���</th>
<th width=7% class=thCornerR nowrap=nowrap>�������</th>
<th width=28% class=thCornerR nowrap=nowrap>����������</th></tr>';

// ������� qq ��������� �� ������� ��������

$addform="<form action='admin.php?event=addmainforum' method=post name=REPLIER1><table width=100% cellpadding=4 cellspacing=1 class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>���������� ������� / ������</span></td></tr><tr><td class=row1 align=right><b><span class=gensmall>��� ������������ ������</span></b></td><td class=row1><input type=radio name=ftype value='razdel'> ������ &nbsp;&nbsp;<input type=radio name=ftype value=''checked> �����</tr></td><tr><td class=row1 align=right valign=top><span class=gensmall><B>���������</B></td><td class=row1 align=left valign=middle><input type=text  class=post value='' name=zag size=70></td></tr><tr><td class=row1 align=right valign=top><span class=gensmall>��������</td><td class=row1 align=left valign=middle><textarea cols=100 rows=6 size=500 class=post name=msg></textarea></td></tr><tr><td class=row1 colspan=2><center><input type=submit class=mainoption value='     ��������     '></td></span></tr></table></form>";

if (!is_file("$datadir/mainforum.dat")) exit("<h3>������������ �� �� �����. ���� mainforum.dat ������������ ��� �������� �����/������.</h3>$addform"); 

$lines = file("$datadir/mainforum.dat"); $datasize = sizeof($lines);

if ($datasize==0) exit("<h3>���� mainforum.dat ���� - �������� ����� ��� ������.</h3>$addform");

$i=count($lines);
$n="0"; $a1="-1"; $u=$i-1;
$fid="0"; $itogotem="0"; $itogomsg="0";

do {$a1++; $dt = explode("|", $lines[$a1]);
$fid=$dt[0];


echo'<tr height=50><td class=row1>&nbsp;';

if ($ktotut==1) { // ������ ����� ����� ��������� ���������
print"<table>
<td width=10 bgcolor=#A6D2FF><B><a href='admin.php?movetopic=$a1&where=1' title='����������� �����'>��</a></B></td>
<td width=10 bgcolor=#DEB369><B><a href='admin.php?movetopic=$a1&where=0' title='����������� ����'>��</a></B></td>
<td width=10 bgcolor=#22FF44><B><a href='admin.php?frd=$a1' title='�������������'>.P.</a></B></td>
<td width=10 bgcolor=#FF2244><B><a href='admin.php?fxd=$a1' title='�������'>.X.</a></B></td>
</tr></table>"; }

echo'</td>';

// ���������� ���: ����� ��� ���������
if ($dt[1]=="razdel") print "<td class=catLeft colspan=1><span class=cattitle><center>$dt[2]</td><td class=rowpic colspan=4 align=right>&nbsp;</td></tr>";

else {

if (is_file("$datadir/$dt[3].dat")) { $msgsize=sizeof(file("$datadir/$dt[3].dat")); // ������� ���-�� ������� � �����
if ($msgsize>$qq) $page=ceil($msgsize/$qq); else $page=1; } else {$msgsize=""; $page=1;}

if ($dt[7]==$date) $dt[7]="�������";
$maxzvezd=null; if (isset($dt[12])) { if ($dt[12]>0) {$maxzvezd="*�������� ����������, ������� <font color=red><B>$dt[12]</B> �����";
$dt[4]=""; $dt[5]="";
if ($dt[12]==1) $maxzvezd.="�";
if ($dt[12]==2 or $dt[12]==3 or $dt[12]==4) $maxzvezd.="�"; $maxzvezd.=" �������</font>";}}

print "
<td width=60% class=row1 valign=middle><span class=forumlink><a href=\"admin.php?fid=$fid\">$dt[1]</a> $maxzvezd<BR></span><small>$dt[2]</small></td>
<td width=7% class=row2 align=center><small>$dt[4] / $dt[11]</small></td>
<td width=7% class=row2 align=center valign=middle><small>$dt[5]</small></td>
<td width=28% class=row2 valign=middle><span class=gensmall>
����: <a href=\"admin.php?fid=$fid&id=$dt[3]&page=$page#m$msgsize\">$dt[10]</a><BR>
�����: <B>$dt[6]</B><BR>
����: <B>$dt[7]</B> - $dt[8]</span></td></tr>";

$itogotem=$itogotem+$dt[4]; $itogomsg=$itogomsg+$dt[5]; }
} while($a1 < $u);
echo'</table><BR>';

// ������� �������������� ������
if (isset($_GET['frd'])) { if ($_GET['frd'] !="") { $frd=$_GET['frd'];
$lines = file("$datadir/mainforum.dat");
$dt = explode("|", $lines[$frd]);
if (isset($dt[11])) { if ($dt[11]>0) $addmax=$dt[11]; else $addmax="100"; }
if (isset($dt[12])) {if ($dt[12]<=0) $dt[12]="0";}
$dt[2]=str_replace("<br>","\r\n",$dt[2]);
print "<form action='admin.php?event=frdmainforum' method=post name=REPLIER1><table width=100% cellpadding=4 cellspacing=1 class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>�������������� ������� / ������</span></td></tr>
<tr><td class=row1 align=right>��� �������������� ������</td><td class=row1><input type=hidden name=nextnum value='$dt[0]'>";
if ($dt[1]=="razdel") print "<input type=hidden name=ftype value='razdel'>������</tr></td><tr><td class=row1 align=right valign=top><span class=gensmall><B>���������</B></td><td class=row1 align=left valign=middle><input type=text value='$dt[2]' name=zag size=70></td></tr>";
else {print "
<input type=hidden name=ftype value=''>�����</tr></td><tr><td class=row1 align=right valign=top><B>���������</B></td><td class=row1 align=left valign=middle><input class=post type=text value='$dt[1]' name=zag size=70></td></tr>
<tr><td class=row1 align=right valign=top>��������</td><td class=row1 align=left valign=middle><textarea cols=80 rows=6 class=post size=500 name=msg>$dt[2]</textarea>
<input type=hidden name=idtemka value='$dt[3]'>
<input type=hidden name=kt value='$dt[4]'>
<input type=hidden name=km value='$dt[5]'>
<input type=hidden name=namem value='$dt[6]'>
<input type=hidden name=datem value='$dt[7]'>
<input type=hidden name=timem value='$dt[8]'>
<input type=hidden name=timetk value='$dt[9]'>
<input type=hidden name=temka value='$dt[10]'>
</td></tr>
<TR><TD align=right class=row1>������������  ���-�� ��� � ������</TD><TD class=row1><input type=text class=post name=addmax value='$addmax'></TD></TR>
<input type=hidden name=zvezdmax value='$dt[12]'>
<TR><TD align=right class=row1>������������� �� ������</TD><TD class=row1><input type=text class=post size=5 maxlength=1 name=zvezdmax value='$dt[12]'>
(������ ��������� � ��������� ���-��� ���� ����� ��������� ���� �����)</TD></TR>";}

print"<tr><td colspan=2 class=row1><input type=hidden name=frd value='$frd'><SCRIPT language=JavaScript>document.REPLIER1.zag.focus();</SCRIPT><center><input type=submit class=mainoption value='     ��������     '></td></span></tr></table></form><BR>";
} } // ����� �������������� ������

else { if ($ktotut==1) print "$addform"; }


if ($statistika=="1")  {
print"<table width=100% cellpadding=3 cellspacing=1 class=forumline><tr><td class=catHead colspan=2 height=28><span class=cattitle>����������</span></td></tr><tr>
<td class=row1 align=center valign=middle rowspan=2><img src=\"$fskin/whosonline.gif\"></td>
<td class=row1 align=left width=95%><span class=gensmall>���������: <b>$itogomsg</b><br>���: <b>$itogotem</b><br>����� ���������������� ����������: <b><a href=\"tools.php?event=who\">$ui</a></b><br>��������� �����������������: <a href=\"tools.php?event=profile&pname=$tdt[0]\">$tdt[0]</a></span></td>
</tr></table>"; 

// ���������� -= ��������� ��������� � ������ =-

if (is_file("$datadir/news.dat")) { $newmessfile="$datadir/news.dat";
$lines=file($newmessfile); $i=count($lines); //if ($i>10) $i=10; (������������� - ��� ��� ����!!! ;-))
if ($i>1) {
echo('<br><table width=100% cellpadding=3 cellspacing=1 class=forumline><tr><td class=catHead colspan=2 height=28><span class=cattitle>��������� ���������</span></td></tr><tr>
<td class=row1 align=center valign=middle rowspan=2><img src="'.$fskin.'/whosonline.gif"></td>
<td class=row1 align=left width=95%><span class=gensmall>');

$a1=$i-1;$u="-1"; // ������� ������ �� ����������� ��� ��������
do {$dt=explode("|", $lines[$a1]); $a1--;

if (isset($dt[1])) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������
$dt[6]=htmlspecialchars($dt[6]);
$dt[6]=str_replace("[b] "," ",$dt[6]);
$dt[6]=str_replace("[/b]"," ",$dt[6]);
$dt[6]=str_replace("[RB] "," ",$dt[6]);
$dt[6]=str_replace("[/RB]"," ",$dt[6]);
$dt[6]=str_replace("[Code] "," ",$dt[6]);
$dt[6]=str_replace("[/Code]"," ",$dt[6]);
$dt[6]=str_replace("[Quote] "," ",$dt[6]);
$dt[6]=str_replace("[/Quote]"," ",$dt[6]);
$dt[6]=str_replace("<br>","\r\n", $dt[6]);
$dt[2]=str_replace(".201",".1", $dt[2]);
$dt[2]=substr($dt[2],0,8);
$dt[3]=substr($dt[3],0,5);
if ($dt[8]>$qq) $page=ceil($dt[8]/$qq); else $page=1; // ������� ��������

if ($dt[10]=="��") {$codename=urlencode($dt[4]); $name="<B><a href='tools.php?event=profile&pname=$codename'>$dt[4]</a></B>";} else $name="����� $dt[4]";
print"$dt[2] - $dt[3]: <B><a href='admin.php?fid=$dt[0]'>$dt[9]</a></B> -> <B><a href='admin.php?fid=$dt[0]&id=$dt[1]&page=$page#m$dt[8]' title='$dt[6] \r\n\r\n ���������� $dt[3], $dt[2] �.'>$dt[5]</a></B> - $name.<br>";
} // ���� ������� ����������
$a11=$u; $u11=$a1;
} while($a11 < $u11);
echo'</span></td></tr></table>';}

} // ����� ����� ��������� ���������
}

} // ����� ������� ��������









// ������� �������� � ������ ��������� �������
if (isset($_GET['fid']) and !isset($_GET['id'])) { $fid=$_GET['fid'];


$maxzd=null; // �������� ������ �� ���-�� �¨�� � ����
do {$imax--; $ddt=explode("|", $mainlines[$imax]); if ($ddt[0]==$fid) $maxzd=$ddt[12]; } while($imax>"0");
if (!ctype_digit($maxzd)) $maxzd=0;

print "
<table><tr><td><span class=nav>&nbsp;&nbsp;&nbsp;<a href=admin.php class=nav>$fname</a> -> <a href=admin.php?fid=$fid class=nav>$frname</a></span></td></tr></table>
<table width=100% cellpadding=2 cellspacing=1 class=forumline><tr>
<th width=3% class=thCornerL height=25 nowrap=nowrap>X/P</th>
<th width=57% colspan=2 class=thCornerL height=25 nowrap=nowrap>����</th>
<th width=10% class=thTop nowrap=nowrap>C��������</th>
<th width=12% class=thCornerR nowrap=nowrap>�����</th>
<th width=18% class=thCornerR nowrap=nowrap>����������</th></tr>";

$addbutton="<table width=100%><tr><td align=left valign=middle><span class=nav><a href=\"admin.php?fid=$fid&newtema=add\"><img src='$fskin/newthread.gif' border=0></a>&nbsp;</span></td>";


// ���������� ���� �� ���������� � ����� � �������
if (is_file("$datadir/topic$fid.dat"))
{
$msglines=file("$datadir/topic$fid.dat");
if (count($msglines)>0) {

if (count($msglines)>$maxtem-1) $addbutton="<table width=100%><TR><TD>���������� ���������� ��� � ������� ���������.";

// ������� qqmain ��������� �� ������� ��������
$lines=file("$datadir/topic$fid.dat");
$i=count($lines); $maxi=count($lines)-1; $n="0";

// ��������� ������ ������ �������������� ��������
if (!isset($_GET['page'])) $page=1; else { $page=$_GET['page']; if (!ctype_digit($page)) $page=1; if ($page<1) $page=1; }


// ���������� QQ ���
$fm=$maxi-$qq*($page-1); if ($fm<"0") $fm=$qq;
$lm=$fm-$qq; if ($lm<"0") $lm="-1";

$timetek=time();

do {$dt=explode("|", $lines[$fm]);

// ����� ��� ����������� ���� �� VIP-������
if (is_file("$datadir/$dt[7].dat")) $ftime=filemtime("$datadir/$dt[7].dat"); else $ftime="";
$timer=$timetek-$ftime; // ������ ������� ������ ������� (� ��������) 

$fm--; $num=$fm+2; $numid=$fm+1;

$filename=$dt[7]; if (is_file("$datadir/$filename.dat")) { // ���� ���� � ����� ���������� - �� �������� ����
$msgsize=sizeof(file("$datadir/$filename.dat"));

// --------- �������� ����� ���������
$linetmp=file("$datadir/$filename.dat"); if (sizeof($linetmp)!=0) {
$pos=$msgsize-1; $dtt=explode("|", $linetmp[$pos]);
$foldicon="folder.gif";
// ���� ��������� ��������� � ������ ��������� ������ ��������� - ������ ������ ������ - �����
if (isset($wrfname)) {if (isset($dtt[9])) {if ($dtt[9]>$wrftime2) $foldicon="foldernew.gif";}}
if (strlen($dt[8])>1 and $dt[8]=="closed") {if ($msgsize<"20") $foldicon="close.gif"; else $foldicon="closed.gif"; }} else $foldicon="foldernew.gif";
// --------- �����

print "<tr height=50>
<td width=3% class=row1><table><tr><td width=10 bgcolor=#22FF44><B><a href='admin.php?fid=$fid&rd=$numid&page=$page' title='�������������'>.P.</a></B></td></tr><tr><td width=10 bgcolor=#FF2244><B><a href='admin.php?fid=$fid&xd=$numid&id=$dt[7]&page=$page' title='�������'>.X.</a></B></td></tr></table></td>
<td width=3% class=row1 align=center valign=middle><img src=\"$fskin/$foldicon\" border=0></td>
<td width=57% class=row1 valign=middle><span class=forumlink><b>";

if ($timer<0) echo'<font color=red>VIP </font>';

print"<a href=\"admin.php?fid=$fid&id=$dt[7]\">$dt[3]</a>";

if ($msgsize>$qq) { // ������� ������ ��������� �������
echo'</b></span><BR><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��������: <B>';

// ������� � ���������� �������� � �����
$maxit=count($linetmp)-1; $maxpaget=ceil(($maxit+1)/$qq);
if ($maxpaget<=5) $f1=$maxpaget; else $f1=5;
for($i=1; $i<=$f1; $i++) print "<a href=admin.php?fid=$fid&id=$dt[7]&page=$i>$i</a> &nbsp;";
if ($maxpaget>5) print "... <a href=admin.php?fid=$fid&id=$dt[7]&page=$maxpaget>$maxpaget</a>";
echo'</B>'; }


print"</span></td><td width=10% class=row2 align=center>$msgsize</td>
<td width=10% class=row2 align=center><span class=gensmall>";


$codename=urlencode($dt[0]);
if ($dt[1]=="��") print "<a href='tools.php?event=profile&pname=$codename':$dt[2]>$dt[0]</a><BR><small>$users</small>"; else  print"$dt[0]<BR><small>$guest</small>";


if ($msgsize>=2) {$linesdat=file("$datadir/$filename.dat"); $dtdat=explode("|", $linesdat[$msgsize-1]);
if (strlen($linesdat[$msgsize-1])>10) {$dt[0]=$dtdat[0]; $dt[1]=$dtdat[1]; $dt[2]=$dtdat[2]; $dt[5]=$dtdat[5]; $dt[6]=$dtdat[6];}} // ������ if (strlen...) ������ ���� ���� ���� � ����� ������ ������ - �������

$dt[6]=substr($dt[6],0,-3);
if ($dt[5]===$date) $dt[5]="<B>�������</B>";
print "</span></td><td width=15% height=50 class=row2 align=left valign=middle nowrap=nowrap><span class=gensmall>&nbsp;
�����: $dt[0]<BR>&nbsp;
����: $dt[5]<BR>&nbsp;
�����: $dt[6]</font>
</td></tr>";
} //if (is_file)

} while($lm < $fm);


// ������� ������ �������
$lines=file("$datadir/topic$fid.dat"); $maxi=count($lines)-1;
$maxpage=ceil(($maxi+1)/$qq); if ($page>$maxpage) $page=$maxpage;
print "<table width=100%><tr><td align=right colspan=3><span class=nav>��������:&nbsp; ";
if ($page>=4 and $maxpage>5) print "<a href=admin.php?fid=$fid&page=1>1</a> ... ";
$f1=$page+2; $f2=$page-2;
if ($page<=2) {$f1=5; $f2=1;} if ($page>=$maxpage-1) {$f1=$maxpage; $f2=$page-3;} if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) { if ($page==$i) print "<B>$i</B> &nbsp;"; else print "<a href=admin.php?fid=$fid&page=$i>$i</a> &nbsp;"; }
if ($page<=$maxpage-3 and $maxpage>5) print "... <a href=admin.php?fid=$fid&page=$maxpage>$maxpage</a>";
echo'</b></span></td></tr></table>';

}}



// ------------ ������� �������������� ����
if (isset($_GET['rd'])) { if ($_GET['rd'] !="")  { $rd=$_GET['rd']; $dt=explode("|", $lines[$rd]);

$moddate=filemtime("$datadir/$dt[7].dat"); $tektime=mktime();
if ($moddate<$tektime) {$vt1="checked"; $vt2="";} else {$vt2="checked"; $vt1="";}
if ($dt[8]=="closed") {$ct2="checked"; $ct1="";} else {$ct1="checked"; $ct2="";}

print "<form action='admin.php?event=rdtema&page=$page' method=post name=REPLIER1><table cellpadding=4 cellspacing=1 width=100% class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>�������������� ����</span></td></tr>
<tr><td class=row1 align=right valign=top>�������� ����</td>
<td class=row1 align=left valign=top><input type=text class=post value='$dt[3]' name=zag size=70>
<input type=radio name=status value=''$ct1/> <font color=blue><B>�������</B></font>&nbsp;&nbsp; <input type=radio name=status value='closed'$ct2/> <font color=red><B>�������</B></font>
<input type=hidden name=rd value='$rd'>
<input type=hidden name=name value='$dt[0]'>
<input type=hidden name=who value='$dt[1]'>
<input type=hidden name=email value='$dt[2]'>
<input type=hidden name=msg value=\"$dt[4]\"><!-- ������� � ���� ������ �������!-->
<input type=hidden name=datem value='$dt[5]'>
<input type=hidden name=timem value='$dt[6]'>
<input type=hidden name=id value='$dt[7]'>
<input type=hidden name=timetk value='$dt[9]'>
<input type=hidden name=fid value='$fid'></TD></TR>

<tr><td class=row1 align=right valign=top>����������� � ������ ������ ?</TD><TD class=row1>
<select style='width=440' name='changefid'>
<option value='$fid'>���. �������� � �������</option><br><br>";

$mainlines=file("$datadir/mainforum.dat");
$mainsize=sizeof($mainlines); if($mainsize<1) exit("$back ���� ������ �������� ��� � ��� ����� ���� �������!");
$ii=count($mainlines); $cn=0; $i=0;
do {$mdt=explode("|", $mainlines[$i]);
if ($mdt[1]=="razdel") {if ($cn!=0) {echo'</optgroup>'; $cn=0;} $cn++; print"<optgroup label='$mdt[2]'>";}  else {print" <option value='$mdt[0]' >|-$mdt[1]</option>";}
$i++; } while($i <$ii);
$s2=""; $s1="checked"; // ��������� � ����� �� ��������� ������� � ����� �������
print"</optgroup></select>

<input type=radio name=viptema value='0'$vt1/> <font color=gray><B>������� ����</B></font>&nbsp;&nbsp; <input type=radio name=viptema value='1'$vt2/> <font color=black><B>VIP-����</B></font>

</TD></TR><tr><td class=row1 align=right valign=top>����� �������� ��������� � ����� ������ ?</TD><TD class=row1>
<input type=radio name=goto value='0'$s1> � ������� ������� &nbsp;&nbsp; <input type=radio name=goto value='1'$s2> ���� ���� ��������� ����
</td></tr><tr><td colspan=2 class=row1>
<SCRIPT language=JavaScript>document.REPLIER1.zag.focus();</SCRIPT><center><input type=submit class=mainoption value='     ��������     '></td></span></tr></table></form>";
}

} else  {

print "<table width=100% cellpadding=4 cellspacing=1 class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>���������� ����</span></td></tr>
<tr><td class=row1 align=right valign=top rowspan=2><span class=gensmall>";

if (!isset($wrfname)) echo'<B>���</B> � E-mail<BR>';

print "<B>��������� ����</B><BR><B>���������</B></td><td class=row1 align=left valign=middle rowspan=2>
<form action=\"admin.php?event=addtopic&fid=$fid\" method=post name=REPLIER>";
if (isset($wrfname)) {print "<input type=hidden name=name value='$wrfname' class=post><input type=hidden name=who value='��'>";}
else {print "<input type=text  value='' name=name size=23 class=post> <input type=text value='' name=email size=24 class=post><br>";}
print "
<input type=hidden name=maxzd value=$maxzd>
<input type=text class=post value='' name=zag size=50><br>
<textarea cols=100 rows=6 size=500 name=msg class=post></textarea><BR>
<BR><input type=submit class=mainoption value='     ��������     '></td></form>
<SCRIPT language=JavaScript>document.REPLIER.msg.focus();</SCRIPT>
</span></tr></table><BR>";
}
// --------------

}
}







// ������� ��������� � ������� ����
if (isset($_GET['fid']) and isset($_GET['id'])) {$id=$_GET['id']; $fid=$_GET['fid'];

// ���������� ���� �� ���������� � ����� � �������
if (!is_file("$datadir/$id.dat")) exit("<BR><BR>$back. ��������, �� ����� ���� �� ������ �� ����������.<BR> ������ ����� � ������ �������������.");
$lines=file("$datadir/$id.dat"); $mitogo=count($lines); $i=$mitogo; $maxi=$i-1;

if ($mitogo>0) { $tblstyle="row1"; $printvote=null;

// ��������� ���������� ���� ����������
if (is_file("$datadir/userstat.dat")) {$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1;}

// ���� ���� � topic��.dat - ��������� �� ������� �� ����?
$msglines=file("$datadir/topic$fid.dat"); $mg=count($msglines); $closed="no";
do {$mg--; $mt=explode("|",$msglines[$mg]);
if ($mt[7]==$id and $mt[8]=="closed") $closed="yes";
} while($mg > "0");

$maxzd=null; // �������� ������ �� ���-�� �¨�� � ����
do {$imax--; $ddt=explode("|", $mainlines[$imax]); if ($ddt[0]==$fid) $maxzd=$ddt[12]; } while($imax>"0");
if (!ctype_digit($maxzd)) $maxzd=0;

// ��������� ������ ������ �������������� ��������
if (!isset($_GET['page'])) $page=1; else {$page=$_GET['page']; if (!ctype_digit($page)) $page=1; if ($page<1) $page=1;}

$fm=$qq*($page-1); if ($fm>$maxi) $fm=$maxi-$qq;
$lm=$fm+$qq; if ($lm>$maxi) $lm=$maxi+1;

do {$dt=explode("|", $lines[$fm]);

$fm++; $num=$maxi-$fm+2; $status=""; unset($youwr);

if (strlen($lines[$fm-1])>5) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������

$msg=str_replace("[b]","<b>", $dt[4]);
$msg=str_replace("[/b]","</b>",$msg);
$msg=str_replace("[RB]","<font color=red><B>",$msg);
$msg=str_replace("[/RB]","</B></font>",$msg);
$msg=str_replace("[Quote]","<BR><fieldset align=center style='width:80%; color:#EE4422'><legend><B>������:</B></legend>",$msg);
$msg=str_replace("[/Quote]","</fieldset><BR>",$msg);
$msg=str_replace("[Code]","<BR><fieldset align=center style='width:80%; color:#224488'><legend><B>���:</B></legend>",$msg);
$msg=str_replace("[/Code]","</fieldset><BR>",$msg);

if ($smile==TRUE) {$i=count($smiles)-1; // �������� ��������� �������� �� ����������� ���� ���������
for($k=0; $k<$i; $k=$k+2) {$j=$k+1; $msg=str_replace("$smiles[$j]","<img src='smile/$smiles[$k].gif' border=0>",$msg);}}

$msg=str_replace("&lt;br&gt;","<br>",$msg);
$msg=preg_replace('#\[img(.*?)\](.+?)\[/img\]#','<img src="$2" border="0" $1>',$msg);
// ���� ��������� ���������� �����
if ($liteurl==TRUE) $msg=preg_replace("#(\[url=([^\]]+)\](.*?)\[/url\])|(http://(www.)?[0-9a-z\.-]+\.[a-z]{2,6}[0-9a-z/\?=&\._-]*)#","<a href=\"$4\" >$4</a> ",$msg);


// ��������� � ������ ������ �� ������������
if ($dt[1]=="��")  {
$userlines=file("$datadir/usersdat.php"); $usercount=count($userlines); $ui=$usercount-1;
$iu=$usercount;
do {$iu--; $du=explode("|", $userlines[$iu]); if ($du[0]==$dt[0])
{ if (isset($du[12])) {$status=$du[13]; $reiting=$du[2]; $youavatar=$du[12]; $email=$du[3]; $icq=$du[7]; $site=$du[8]; $userpn=$iu;} $youwr=preg_replace("#(\[url=([^\]]+)\](.*?)\[/url\])|(http://(www.)?[0-9a-z\.-]+\.[a-z]{2,6}[0-9a-z/\?=&\._-]*)#","<a href=\"$4\" >$4</a> ",$du[11]);}
} while($iu > "0");
}


if ($tblstyle=="row1") $tblstyle="row2"; else $tblstyle="row1";

if (!isset($m1)) {
print "<table><tr><td><span class=nav>&nbsp;&nbsp;&nbsp;<a href=admin.php class=nav>$fname</a> <a href=admin.php?fid=$fid class=nav>$frname</a> <a href='admin.php?fid=$fid&id=$dt[7]' class=nav><strong>$dt[3]</strong></a></span></td></tr></table>";

print"<table class=forumline width=100% cellspacing=1 cellpadding=3><tr>
<th class=thLeft width=150 height=26 nowrap=nowrap>�����</th>
<th class=thRight nowrap=nowrap>���������</th>"; $m1="1"; }

print"</tr><tr height=150><td class=$tblstyle valign=top><span class=name><BR><center>";


// ���������: ��� �����?
if (!isset($youwr)) {if (strlen($dt[2])>5) print "$dt[0] "; else print"$dt[0] ";
$kuda=$fm-1; print" <a href='javascript:%20x()' onclick=\"DoSmilie('[b]$dt[0][/b], ');\" class=nav>".chr(149)."</a><BR><br>
<a name='m$fm' href='#m$kuda' onclick=\"window.open('tools.php?event=mailto&email=$dt[2]&name=$dt[0]','email','width=520,height=300,left=170,top=100')\"><img src='$fskin/ico_pm.gif' border=0 alt='��'></a><br><BR><small>$guest</small>";}


else {
$codename=urlencode($dt[0]);
print "<a name='m$fm' href='tools.php?event=profile&pname=$codename' class=nav>$dt[0]</a> <a href='javascript:%20x()' onclick=\"DoSmilie('[b]$dt[0][/b], ');\" class=nav>".chr(149)."</a><BR><BR><small>";
if (strlen($status)>2 & $dt[1]=="��" & isset($youwr)) print "$status"; else print"$users";
if (isset($reiting)) {if ($reiting>0) {echo'<BR>'; if (is_file("$fskin/star.gif")) {for ($ri=0;$ri<$reiting;$ri++) {print"<img src='$fskin/star.gif' border=0>";} } }}

if (isset($youavatar)) { if (is_file("avatars/$youavatar")) $avpr="$youavatar"; else $avpr="noavatar.gif";
print "<BR><BR><img src='avatars/$avpr'><BR> <!--
<a href='tools.php?event=profile&pname=$dt[0]'><img src='$fskin/profile.gif' alt='�������' border=0></a>
<a href='$site'><img src='$fskin/www.gif' alt='www' border=0></a><BR>
<a href='$icq'><img src='$fskin/icq.gif' alt='ICQ' border=0></a>
<a href='#' onclick=\"window.open('tools.php?event=mailto&email=$dt[3]&name=$dt[0]','email','width=520,height=300,left=170,top=100')\"><img src='$fskin/ico_pm.gif' alt='��'></a>-->";}
} // isset($youwr)

if (isset($youwr) and is_file("$datadir/userstat.dat")) { // ������ ��������� ����� ��� ���������! ;-)
if (isset($ulines[$userpn])) {
if (strlen($ulines[$userpn])>5) {
$ddu=explode("|",$ulines[$userpn]);
print"</small></span><br>
<div style='PADDING-LEFT: 17px' align=left class=gensmall>��� �������: $ddu[1]<br>
���������: $ddu[2]<br>
���������: $ddu[3] <A href='#' onclick=\"window.open('tools.php?event=repa&name=$dt[0]&who=$userpn','repa','width=500,height=190,left=100,top=100')\">-+</A><br>
��������������: $ddu[4]<br></span>"; }}}

print "</span></td><td class=$tblstyle width=100% height=28 valign=top><table width=100% height=100%><tr valign=center><td><span class=postbody>$msg</span>";




//  ���� ����������� - ���� ���� �� �������!!!! *************************************

// ������ ��� ���������� �����������

if ($printvote==null and !is_file("$datadir/$id-vote.dat")) {$printvote=1; print"<table><tr><td width=180 align=center bgcolor=#0080C0><B><a href='admin.php?fid=$fid&id=$id&vote=add'>.�������� �����������.</a></B></td></tr></table>";}

if ($printvote==null) {$printvote=1; // �������� ���� ������ ���� ���
if (is_file("$datadir/$id-vote.dat")) { $vlines=file("$datadir/$id-vote.dat");
if (sizeof($vlines)<1) exit("<center>���� ������ $id-vote.dat ����!");
$vitogo=count($vlines); $vi=1; $vdt=explode("|",$vlines[0]);

print"<center>
<TABLE cellPadding=3 align=center border=0><TBODY><TR><TD vAlign=top align=middle>

<TABLE bgcolor=navy cellSpacing=1 cellPadding=0 align=center border=0><TR><TD>

<TABLE bgcolor=#ffffff cellSpacing=0 cellPadding=1 align=center border=0>
<FORM name=wrvote action='vote.php' method=post target='WRGolos'>
<TR><TD colspan=3 align=middle bgColor=#FFFFFF><B>&nbsp;$vdt[0]&nbsp;</B></TD></TR>
<TR><TD colspan=3><img width=100% height=1></TD></TR>

<TR><TD><TABLE border=0 cellSpacing=0 cellPadding=2 width=100%><TBODY>";

do {$vdt=explode("|",$vlines[$vi]);

print"<TR>
<TD width=55>&nbsp;</TD><TD><INPUT name='votec' type=radio value='$vi'></TD>
<TD>&nbsp;<B>$vdt[0]</B></TD>
</TR>";

$vi++;
} while($vi<$vitogo);

print "<INPUT name='id' type=hidden value='$id'><TR><TD colspan=3 align=center><INPUT type=submit value='�������������' onclick=\"window.open('vote.php','WRGolos','width=550,height=300,left=250,top=150,toolbar=0,status=0,border=0,scrollbars=0')\" border=0></TD></TR>

</FORM></TBODY></TABLE>

</TBODY></TABLE>

</TBODY></TABLE>

<TD align=right><table><tr><td width=10 bgcolor=#22FF44><B><a href='admin.php?fid=$fid&id=$id&vote=change' title='�������������'>.P.</a></B></td><td width=10 bgcolor=#FF2244><B><a href='admin.php?fid=$fid&id=$id&vote=delete' title='�������'>.X.</a></B></td></tr></table></TD><TR>

</TD></TR></TABLE>";
}}



print"</td></tr>";


if (isset($youwr)) {if (strlen($youwr)>3) {print "<tr><td valign=bottom><span class=postbody>--------------------------------------------------<BR><small>$youwr</small>";}} // �������� ������� ���������

print"</td></tr></table></td></tr><tr>
<td class=row3 valign=middle align=center ><span class=postdetails>
<table><tr><td width=10 bgcolor=#22FF44><B><a href='admin.php?fid=$fid&id=$id&topicrd=$fm&page=$page#m$lm' title='�������������'>.P.</a></B></td><td width=10 bgcolor=#FF2244><B><a href='admin.php?fid=$fid&id=$id&topicxd=$fm&page=$page' title='�������'>.X.</a></B></td></tr></table>
<I>��������� # <B>$fm.</B></I></span></td>
<td class=row3 width=100% height=28 nowrap=nowrap><span class=postdetails>����������: <b>$dt[5]</b> - $dt[6]</span></td>
</tr><tr><td class=spaceRow colspan=2 height=1><img src=\"$fskin/spacer.gif\" width=1 height=1></td>";

} // ���� ������� ����������

} while($fm < $lm);

echo'</tr></table>';


// ������� ������ �������
$maxpage=ceil(($maxi+1)/$qq); if ($page>$maxpage) $page=$maxpage;
echo'<table width=100%><tr><td align=center colspan=3><span class=nav>��������:&nbsp; ';
if ($page>=4 and $maxpage>5) print "<a href=admin.php?fid=$fid&id=$id&page=1>1</a> ... ";
$f1=$page+2; $f2=$page-2;
if ($page<=2) {$f1=5; $f2=1;} if ($page>=$maxpage-1) {$f1=$maxpage; $f2=$page-3;} if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) {if ($page==$i) print "<B>$i</B> &nbsp;"; else print "<a href=admin.php?fid=$fid&id=$id&page=$i>$i</a> &nbsp;";}
if ($page<=$maxpage-3 and $maxpage>5) print "... <a href=admin.php?fid=$fid&id=$id&page=$maxpage>$maxpage</a>";
echo'</span></td></tr></table>';



// ������� ����� .P. - �������������� ���������
if (isset($_GET['topicrd']))  { // ������� ��������� � �����
$topicrd=$_GET['topicrd']-1;
$lines=file("$datadir/$id.dat");
$dt=explode("|", $lines[$topicrd]);  
$dt[4]=str_replace("<br>", "\r\n", $dt[4]);
print "
<form action=\"admin.php?event=addanswer&fid=$fid&topicrd=$topicrd\" method=post name=REPLIER>
<table cellpadding=3 cellspacing=1 width=100% class=forumline>
<tr><th class=thHead colspan=2 height=25><b>���������</b></th></tr>
<tr><td class=row1 width=22% height=25><span class=gen><b>���
</b></span></td>
<td class=row2 width=78%> <span class=genmed>
<input type=text value='$dt[0]' name=name size=20>&nbsp;
E-mail <input type=text value='$dt[2]' name=email size=26>"; 

} else {

print "<form action=\"admin.php?event=addanswer&fid=$fid\" method=post name=REPLIER>
<input type=hidden name=maxzd value=$maxzd>
<input type=hidden name=id value=$dt[7]>
<input type=hidden name=page value=$page>
<input type=hidden name=zag value=\"$dt[3]\">

<table cellpadding=3 cellspacing=1 width=100% class=forumline>
<tr><th class=thHead colspan=2 height=25><b>���������</b></th></tr>
<tr><td class=row1 width=22% height=25><span class=gen><b>��� ";


if (!isset($wrfname)) echo'� E-mail<BR>';

echo'</b></span></td><td class=row2 width=78%> <span class=genmed>';

if (!isset($wrfname)) echo'<input type=text name=name size=28 class=post> <input type=text name=email size=30 class=post>';
else print "<b>$wrfname</b><input type=hidden name=name value='$wrfname'><input type=hidden name=who value='��'>";
}


print "</span></td></tr><tr>
<td class=row1 valign=top><span class=genmed><b>���������</b><br><br>��� ������� �����, �������� �� ����� ����� � ���.<br><br>��������:<br>
<table align=center width=100 height=70><tr><td valign=top>";

if ($smile==TRUE) {$i=count($smiles)-1;
for($k=0; $k<$i; $k=$k+2) {$j=$k+1; print"<A href='javascript:%20x()' onclick=\"DoSmilie(' $smiles[$j]');\"><img src='smile/$smiles[$k].gif' border=0></a> ";} }
print"<A href='javascript:%20x()' onclick=\"DoSmilie('[RB]  [/RB] ');\"><font color=red><B>RB</b></font></a>
<a name='add' href='#add' onclick=\"window.open('tools.php?event=moresmiles','smiles','width=250,height=300,left=50,top=150,toolbar=0,status=0,border=0,scrollbars=1')\">��� ������</a>
</tr></td></table></span></td>
<td class=row2 valign=top><span class=gen><table width=450><tr valign=middle><td><span class=genmed>
<input type=button class=button value=' B ' style='font-weight:bold; width: 30px' onclick=\"DoSmilie(' [b]  [/b] ');\">&nbsp;
<input type=button class=button value=' RB ' style='font-weight:bold; color:red' onclick=\"DoSmilie('[RB] [/RB]');\">&nbsp;
<INPUT type=button class=button value='���������� ����������' style='width: 170px' onclick='REPLIER.msg.value += \"[Quote]\"+(window.getSelection?window.getSelection():document.selection.createRange().text)+\"[/Quote]\"'>&nbsp;
<input type=button class=button value=' ��� ' onclick=\"DoSmilie(' [Code]  [/Code] ');\">&nbsp;
<input type=button class=button value=' IMG ' style='font-weight:bold; color:navy' onclick=\"DoSmilie('[img][/img]');\">&nbsp;
</span></td></tr><tr>";

if (isset($_GET['topicrd']))
{
print "
<td colspan=9><span class=gen><textarea name=msg cols=103 rows=10 class=post>$dt[4]</textarea></span></td>
<input type=hidden name=maxzd value=$maxzd>
<input type=hidden name=who value=$dt[1]>
<input type=hidden name=id value=$dt[7]>
<input type=hidden name=zag value=\"$dt[3]\">
<input type=hidden name=fdate value=$dt[5]>
<input type=hidden name=ftime value=$dt[6]>
<input type=hidden name=fnomer value=$topicrd>
<input type=hidden name=timetk value=$dt[9]>
<input type=hidden name=page value=$page>
</tr></table></span></td></tr>
<tr><td class=catBottom colspan=2 align=center height=28><input type=submit tabindex=5 class=mainoption value='�������� � ���������'>&nbsp;&nbsp;&nbsp;<input type=reset tabindex=6 class=mainoption value=' �������� '></td>
</tr></table></form>";

} else {

echo'<td colspan=9><span class=gen><textarea name=msg cols=103 rows=10 class=post></textarea></span></td>
</tr></table></span></td></tr><tr>
<td class=catBottom colspan=2 align=center height=28><input type=submit tabindex=5 class=mainoption value=" ��������� ">&nbsp;&nbsp;&nbsp;<input type=reset tabindex=6 class=mainoption value=" �������� "></td>
</tr></table></form>';


$newvote="<br>
<table align=center border=0 class=forumline><form action='admin.php?event=voteadd&fid=$fid&id=$id' method=POST name=VOTE>
<tr><th class=thHead colspan=3 height=25><b>C������� ������ �����������</b></th></tr>";
$i=0; $j=1; do {
if ($i==0) {$newvote.="<tr><td class=row1><B>�������� �����������:</B></td><td class=row1 colspan=2><input maxlength=100 type=text value='' name=toper size=70 class=post></tr></td>";
} else {$newvote.="<TR>
<TD class=row$j align=right>$i �����:</TD><TD class=row$j><input type=text value='' maxlength=70 name='otv$i' class=post size=63></B></TD>
<TD class=row$j><input type=text value='0' name='kolvo$i' class=post maxlength=4 size=4></TD></TR>";}
$i++; $j++; if ($j>2) $j=1;
} while($i<11);
$newvote.="
<TR><td class=catBottom colspan=3 align=center height=28><input type=hidden name=golositogo value='$i'><input class=mainoption type=submit value='������� �����������'></TD></TR></table></form>
<br><div align=center>* �������� ���� �������, ���� ������ ������� ����������� � ������� ���-��� ������� </div>";

echo $newvote;
}}

} // else if event !=""







if (isset($_GET['event'])) {


// ���������������� ������ - ����� ��������
if ($_GET['event']=="configure") {

if ($ktotut!=1) {exit("$back! ����������� ��������� �������� ��������� ������! ���� ����� ������� ������ - ����������� � ������!");}

if ($sendmail==TRUE) {$s1="checked"; $s2="";} else {$s2="checked"; $s1="";}
if ($sendadmin==TRUE) {$sa1="checked"; $sa2="";} else {$sa2="checked"; $sa1="";}
if ($statistika==TRUE) {$st1="checked"; $st2="";} else {$st2="checked"; $st1="";}
if ($antispam==TRUE) {$as1="checked"; $as2="";} else {$as2="checked"; $as1="";}
if ($newmess==TRUE) {$n1="checked"; $n2="";} else {$n2="checked"; $n1="";}
if ($cangutema==TRUE) {$ct1="checked"; $ct2="";} else {$ct2="checked"; $ct1="";}
if ($cangumsg==TRUE) {$cm1="checked"; $cm2="";} else {$cm2="checked"; $cm1="";}
if ($useactkey==TRUE) {$u1="checked"; $u2="";} else {$u2="checked"; $u1="";}
if ($liteurl==TRUE) {$lu1="checked"; $lu2="";} else {$lu2="checked"; $lu1="";}
if ($canupfile==TRUE) {$cs1="checked"; $cs2="";} else {$cs2="checked"; $cs1="";}
if ($smile==TRUE) {$sm1="checked"; $sm2="";} else {$sm2="checked"; $sm1="";}

print "<center><B>����������������</b></font>
<form action=admin.php?event=config method=post name=REPLIER>
<table width=700 cellpadding=2 cellspacing=1 class=forumline><tr> 
<th class=thCornerL height=25 nowrap=nowrap>��������</th>
<th class=thTop nowrap=nowrap>��������</th></tr>
<tr><td class=row1>�������� ������</td><td class=row1><input type=text value='$fname' name=fname class=post maxlength=50 size=50></tr></td>
<tr><td class=row2 valign=top>��������<BR><B><small>�� ���������� ������������ HTML-����.</small></td><td class=row2><textarea cols=50 rows=6 size=500 class=post name=fdesription>$fdesription</textarea></tr></td>
<tr><td class=row1>�-���� ��������������</td><td class=row1><input type=text value='$adminemail' class=post name=newadminemail maxlength=40 size=25></tr></td>
<tr><td class=row2>������ �������������� / ���������� *</td><td class=row1><input name=password type=hidden value='$password'><input class=post type=text value='�����' maxlength=10 name=newpassword size=15> &nbsp; .:. &nbsp; <input name=moderpass type=hidden value='$moderpass'><input class=post type=text value='�����' maxlength=10 name=newmoderpass size=15>(���������� � �����)</td></tr>

<tr><td class=row2>�������� �������� ���������?</td><td class=row1><input type=radio name=sendmail value=\"1\"$s1/> ��&nbsp;&nbsp; <input type=radio name=sendmail value=\"0\"$s2/> ���</tr></td>
<tr><td class=row1>������ ������ ��������� � ����� ������������������ �������������?</td><td class=row1><input type=radio name=sendadmin value=\"1\"$sa1/> ��&nbsp;&nbsp; <input type=radio name=sendadmin value=\"0\"$sa2/> ���</tr></td>

<tr><td class=row2>���������� ���������� �� ������� ��������?</td><td class=row1><input type=radio name=statistika value=\"1\"$st1/> ��&nbsp;&nbsp; <input type=radio name=statistika value=\"0\"$st2/> ���</tr></td>
<tr><td class=row1>��������� ���� � ������ �����������?</td><td class=row1><input type=radio name=newmess value=\"1\"$n1/> ��&nbsp;&nbsp; <input type=radio name=newmess value=\"0\"$n2/> ���</tr></td>
<tr><td class=row2>����. ����� �����</td><td class=row1><input type=text value='$maxname' class=post name=newmaxname maxlength=2 size=10></tr></td>
<tr><td class=row1>����. ����� ��������� ����</td><td class=row2><input type=text value='$maxzag' class=post name=maxzag maxlength=2 size=10></tr></td>
<tr><td class=row2>����. ����� ���������</td><td class=row1><input type=text value='$maxmsg' class=post maxlength=4 name=newmaxmsg size=10></tr></td>

<tr><td class=row1>������������� �������� / ����� ����</td><td class=row2><input type=radio name=antispam value=\"1\"$as1/> ��&nbsp;&nbsp; <input type=radio name=antispam value=\"0\"$as2/> ��� &nbsp;&nbsp; .:. &nbsp;&nbsp; <input type=text class=post value='$max_key' name=max_key size=4 maxlength=1> (�� 1 �� 9) ����</td></tr>

<tr><td class=row2>��� / C�������� / ���������� �� ��������</td><td class=row2><input type=text value='$qqmain' class=post maxlength=2 name=newqqmain size=11> &nbsp; .:. &nbsp; <input type=text value='$qq' class=post maxlength=2 name=newqq size=11> &nbsp; .:. &nbsp; <input type=text value='$uq' maxlength=2 class=post name=uq size=11></tr></td>
<tr><td class=row1>��� �������� ���������� �� ��������� / ���������</td><td class=row2><input type=text value='$guest' class=post maxlength=25 name=newguest size=22> &nbsp;/ &nbsp;<input type=text value='$users' class=post maxlength=25 name=newusers size=22></tr></td>
<tr><td class=row2>��������� ��������� ����� ����� ��� �����������?</td><td class=row1><input type=radio name=useactkey value=\"1\"$u1/> ��&nbsp;&nbsp; <input type=radio name=useactkey value=\"0\"$u2/> ���</tr></td>
<tr><td class=row1>��������� ���� / ��������� ��������� ������ �����?</td><td class=row1>�: <input type=radio name=cangutema value=\"1\"$ct1/> ��&nbsp;&nbsp; <input type=radio name=cangutema value=\"0\"$ct2/> ��� .:. �: <input type=radio name=cangumsg value=\"1\"$cm1/> ��&nbsp;&nbsp; <input type=radio name=cangumsg value=\"0\"$cm2/> ��� </tr></td>
<tr><td class=row2>������ ������ � ������ <B>���������</B>?</td><td class=row1><input type=radio name=liteurl value=\"1\"$lu1/> ��&nbsp;&nbsp; <input type=radio name=liteurl value=\"0\"$lu2/> ���</td></tr>
<tr><td class=row1>�������� / ��������� ������������ ������?</td><td class=row1><input type=radio name=smile value=\"1\"$sm1/> �������� &nbsp;&nbsp; <input type=radio name=smile value=\"0\"$sm2/> ���������</td></tr>

<tr><td class=row1>�������� GMT ������������ ������� ��������</td><td class=row1><input class=post type=text value='$deltahour' maxlength=2 name=deltahour size=15> (GMT + XX �����)</td></tr>

<tr><td class=row2>����� � ������� ������</td><td class=row1><input type=text value='$datadir' class=post maxlength=20 name='datadir' size=10> &nbsp;&nbsp; �� ��������� - <B>./data</B></td></tr>
<tr><td class=row1>������������ ������ ������� � ������</td><td class=row1><input type=text value='$max_file_size' class=post maxlength=6 name='max_file_size' size=10></td></tr>


<tr><td class=row1>��������� �������� ������</td><td class=row2><input type=radio name=canupfile value=\"1\"$cs1/> ��, ������ ������������������ &nbsp;&nbsp; <input type=radio name=canupfile value=\"0\"$cs2/> ��� </td></tr>

<tr><td class=row2>����� ��� �������� ������</td><td class=row1><input type=text value='$filedir' class=post maxlength=20 name='filedir' size=10> &nbsp;&nbsp; �� ��������� - <B>./load</B></td></tr>
<tr><td class=row1>������������ ������ ����� � ������</td><td class=row1><input type=text value='$max_upfile_size' class=post maxlength=6 name='max_upfile_size' size=10></td></tr>

<tr><td class=row2>���� ������</td><td class=row1><select class=input name=fskin>";

$path = '.'; // ���� �� �����. '.' - ������� �����
if ($handle = opendir($path)) {
while (($file = readdir($handle)) !== false)
if (is_dir($file)) { 
$stroka=stristr($file, "images"); if (strlen($stroka)>"6") 
{print "$stroka - str $file <BR>";
$tskin=str_replace("images", "���� ", $file);
if ($fskin==$file) $marker="selected"; else $marker="";
print"<option $marker value=\"$file\">$tskin</option>";}
}
closedir($handle); } else echo'������!';

echo"</select></td></tr>

<tr><td class=row1>������ (����������� � ���)<br> - ������� ��� ������ ***</td><td class=row1><table width=300><TR><TD>\r\n";
if (isset($smiles) and $smile==TRUE) {$i=count($smiles);
for($k=0; $k<$i; $k=$k+2) {
$j=$k+1; if ($k!=($i-1) and is_file("smile/$smiles[$k].gif"))
print"<img src='smile/$smiles[$k].gif' border=0> <input type=hidden name=newsmiles[$k] value='$smiles[$k]'><input type=text value='$smiles[$j]' maxlength=15 name=newsmiles[$j] size=5> \r\n"; } }


echo'</td></tr></table>
</td></tr><tr><td class=row1 colspan=2><BR><center><input type=submit class=mainoption value="��������� ������������"></form></td></tr></table>
<center><br>* ���� ������ �������� ������ - ������� ����� <B>"�����"</B> � ������� ����� ������.<br> ���������� ������������ ������ ����� �/��� �����.';
}






// �������� ���� ���������� ������
if ($_GET['event']=="userwho") {
$t1="row1"; $t2="row2"; $error=0;
$userlines=file("$datadir/usersdat.php");
$ui=count($userlines)-1;  $first=0; $last=$ui+1;

$statlines=file("$datadir/userstat.dat");
$si=count($statlines)-1;

$bada="<center><font color=red><B>� ����� ���������� ������� ������! ������������ ���������� ����������!!!</B></font></center><br>";

if ($si!=$ui) print"$bada";

if (isset($_GET['page'])) $page=$_GET['page']; else $page="1";
if (!ctype_digit($page)) $page=1; // ������
if ($page=="0") $page="1"; else $page=abs($page); 
$maxpage=ceil(($ui+1)/$uq); if ($page>$maxpage) $page=$maxpage;

$i=1+$uq*($page-1); if ($i>$ui) $i=$ui-$uq;
  $lm=$i+$uq; if ($lm>$ui) $lm=$ui+1;

echo'<table width=100% valign=top cellpadding=1 cellspacing=0><TR><TD>

<table valign=top width=100% cellpadding=1 cellspacing=0 class=forumline><tr> 
<th class=thCornerL height=25 nowrap=nowrap>�</th>
<th class=thCornerL width=110>���</th>
<th class=thCornerR>���</th>
<th class=thTop>���������������</th>
<th class=thTop>�����</th>

<th class=thTop>���</th>
<th class=thTop>���������</th>
<th class=thTop>���������</th>
<th class=thTop>������</th>

<th class=thTop>������ / ��������</th>
<th class=thTop>�����</th></tr>';

$delblok="<FORM action='admin.php?usersdelete=$last&page=$page' method=POST name=delform>
<td colspan=8 class=$t1>
<table valign=top cellpadding=1 cellspacing=0 class=forumline width=25><th class=thCornerL>.X.</th>";

do {$tdt=explode("|",$userlines[$i]); $i++; $npp=$i-1;

if (isset($statlines[$i-1])) {$sdt=explode("|",$statlines[$i-1]);} else {$sdt[0]=""; $sdt[1]="-"; $sdt[2]="-"; $sdt[3]="-"; $sdt[4]="-";}
// ���������, ���� ���� ���������� �������� - ����� ��������� � ������������� ������������ ���
if ($sdt[0]!=$tdt[0]) {$error++; $sdt[1]="-"; $sdt[2]="-"; $sdt[3]="-"; $sdt[4]="-";}
if ($tdt[6]=="�������") $tdt[6]="<font color=blue>�</font>"; else $tdt[6]="<font color=red>�</font>";
if (strlen($tdt[13])<2) $tdt[13]=$users;

$delblok.="<TR height=35><td width=10 bgcolor=#FF6C6C><input type=checkbox name='del$npp' value=''"; if (isset($_GET['chekall'])) {$delblok.='CHECKED';} $delblok.="></td></TR>";
print"<tr height=35>
<td class=$t1>$npp</td>
<td class=$t1><B><a href=\"tools.php?event=profile&pname=$tdt[0]\">$tdt[0]</a></td>";
if (strlen($tdt[13])=="6" and ctype_digit($tdt[13])) {
print"<td class=$t1 colspan=9><B>[<a href='admin.php?event=activate&email=$tdt[3]&key=$tdt[13]&page=$page'>������������</a>]. ������� ������ �� ������������  � $tdt[4]. </B>
(�����: <B>$tdt[3]</B> ����: <B>$tdt[13]</B>)"; 
} else {

//���_�����|���|���������|���������|�������������� �/5|����� ��������� ��� ������ ������� � UNIX �������|||

print"</td><td class=$t1 align=center><B>$tdt[6]</b></td><td class=$t1 align=center>$tdt[4]</td><td class=$t1><a href=\"mailto:$tdt[3]\">$tdt[3]</a></td>
<td class=$t1>$sdt[1]</TD>
<td class=$t1>$sdt[2]</TD>
<td class=$t1><form action='admin.php?newrepa&page=$page' method=post><input type=text class=post name=repa value='$sdt[3]' size=3 maxlength=4><input type=hidden name=usernum value='$i'><input type=submit name=submit value='OK' class=mainoption></td></form>
<td class=$t1 width=88 align=center><form action='admin.php?userstatus&page=$page' method=post><input type=hidden name=usernum value='$i'><input type=hidden name=status value='$sdt[4]'><input type=submit name=submit value='-1' style='width: 30px'>&nbsp; <B>$sdt[4]</B>&nbsp; <input type=submit name=submit value='+1' style='width: 30px'></TD></form>
<td class=$t1><form action='admin.php?newstatus=$i&page=$page' method=post><input type=text class=post name=status value='$tdt[13]' size=16 maxlength=20><input type=submit name=submit value='OK' class=mainoption></td></form>
<td class=$t1><form action='admin.php?newreiting=$i&page=$page' method=post><input type=text class=post name=reiting value='$tdt[2]' size=1 maxlength=1><input type=submit name=submit value='OK' class=mainoption></td></form>
</tr>";}

$t3=$t2; $t2=$t1; $t1=$t3;
} while ($i<$lm);

print"</table>
</TD><TD rowspan=20>


$delblok</table></TR></TABLE><br>
<div align=right><input type=hidden name=first value='$first'><input type=hidden name=last value='$last'><INPUT type=submit class=mainoption value='������� ��������� �������������'></FORM>
&nbsp; <FORM action='admin.php?event=userwho&page=$page&chekall' method=POST name=delform><INPUT class=mainoption type=submit value='�������� ����'></FORM>
&nbsp; <FORM action='admin.php?event=userwho&page=$page' method=POST name=delform><INPUT class=mainoption type=submit value='����� �������'></FORM></div>";


// ������� ������ �������
if ($page>$maxpage) $page=$maxpage;
echo'<BR><table width=100%><TR><TD>��������:&nbsp; ';
if ($page>=4 and $maxpage>5) print "<a href=admin.php?event=userwho&page=1>1</a> ... ";
$f1=$page+2; $f2=$page-2;
if ($page<=2) {$f1=5; $f2=1;} if ($page>=$maxpage-1) {$f1=$maxpage; $f2=$page-3;} if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) {if ($page==$i) print "<B>$i</B> &nbsp;"; else print "<a href=admin.php?event=userwho&page=$i>$i</a> &nbsp;";}
if ($page<=$maxpage-3 and $maxpage>5) print "... <a href=admin.php?event=userwho&page=$maxpage>$maxpage</a>";

print "</TD><TD align=right>����� ���������������� ���������� - <B>$ui</B></TD></TR></TABLE><br>

��������������� ���������� ��: 
<form action='admin.php?event=sortusers' method=post name=REPLIER>
<SELECT name=kaksort>
<OPTION selected value=1>�����</OPTION>
<OPTION value=2>���-�� ���������</OPTION>
<OPTION value=3>���-�� ����</OPTION>
<OPTION value=4>���������</OPTION>
<OPTION value=5>���� �����������</OPTION>
<OPTION value=6>���������� **</OPTION></SELECT>
<input type=submit class=mainoption value='     ���������������     '> &nbsp; (����������� ����� ����� � ������� ����� �� ���������� �� ��������)
<br><br>";


if ($error>0) print"$bada";

echo'* ��� - ������ ������� ���-�� ���, ��������� ���������� � ������� �����������/�������������� ����� ���������� ����� ����<br><br>
��������� - ������� �������� ������� ���������<br><br>
��������� - "��������������" ������������. �������� 9999 ��. ������������� ������������� �� 1 ��� ���������� ���������/����<br><br>

������� ������� ��� ������������. ����� �������� � ��������� ������!!!
- ������:<br>
0 - ���� ����� ��;<br>
1 - ����� �������� ����������� �� 60 ������;<br>
2 - ���� �� ����� ����� ������ ���� ������;<br>
3 - ����� ��������� ��������� ����;<br>
4 - ��������� ������ � ������ � ����� - ������ ��������;<br>
5 - ��� �� 1 �����!<br><br>
** ���������� - ���-�� ��������� � ����� ���������� �� ���-�� ���� � ������� �����������;
<br><BR>';
}
}






// �������� �������� ���������� ���������� ������
if (isset($_GET['event'])) { if ($_GET['event']=="massmail") {

echo'<table width=100% border=0 cellpadding=1 cellspacing=0><TR><TD>
<table border=0 width=100% cellpadding=2 cellspacing=1 class=forumline><tr> 
<th class=thCornerL height=25 nowrap=nowrap>�</th>
<th class=thCornerL width=110>����� ���� ����������</th>
<th class=thCornerL width=110>���</th>
<th class=thTop>�����</th>
<th class=thTop>���</th>
<th class=thTop>���������</th>
<th class=thTop>���������</th>
<th class=thTop>������ / ��������</th></tr></table>';

print"<center><TABLE class=forumline cellPadding=2 cellSpacing=1 width=775>
<br><br><FORM action='admin.php?event=massmailgo' method=post>
<TBODY><TR><TD class=thTop align=middle colSpan=2>������� ��������� ������ <B>������������� �������������</B></TD></TR>

<TR bgColor=#ffffff><TD>&nbsp; ��� �����������:<FONT color=#ff0000>*</FONT> <INPUT name=name value='������������� ������ ' style='FONT-SIZE: 14px; WIDTH: 240px'>

� E-mail:<FONT color=#ff0000>*</FONT> <INPUT name=email value='$adminemail' style='FONT-SIZE: 14px; WIDTH: 320px'></TD></TR>

<TR bgColor=#ffffff><TD>&nbsp; ���������:<FONT color=#ff0000>*</FONT><br>
<TEXTAREA name=msg style='FONT-SIZE: 14px; HEIGHT: 440px; WIDTH: 765px'>
\r\n
���� ��� �� �����!!!!\r\n
\r\n
������������, %name!\r\n
�� ��������� ������������������ ���������� ������ %fname,
�������������� �� ������: %furl.

��� ������������� ������ ���� ��� �������� ��������� �������:


���� ������� �������, ��������:
- � ��� �� ������ ����� ���������� ���������� ������ ����������-4;
- � ��� �� ������ �������� ������ �� ���������� ���� ����� �������;
- �� ������ �������� ������ ������ �� ������ �� php :-) � ����� �����-��... � �.�.


----------
������������� ������ ���� ������ (����� ������� ��� ���/���)
</TEXTAREA></TD></TR>
<TR><TD bgColor=#FFFFFF colspan=2><center><INPUT type=submit value=���������></TD></TR></TBODY></TABLE></FORM>


<br><br></center>
* ����������� ����������������:<br>
<LI><B>%name</B> - ��� ��������� ������;</LI>
<LI><B>%fname</B> - �������� ������;</LI>
<LI><B>%furl</B> - URL-����� ������;</LI>

<br><br>���� � �������� ���������� - ��� �� ��������!!!<br><br><br>"; }}





?><br>
<center><font size=-2><small>Powered by <a href="http://www.wr-script.ru" title="������ ������" class="copyright">WR-Forum</a> Professional &copy; 1.9.3<br></small></font></center>
</body>
</html>
