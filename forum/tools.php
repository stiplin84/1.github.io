<? // WR-forum v 1.9.3  //  10.06.10 �.  //  Miha-ingener@yandex.ru

error_reporting (E_ALL); //error_reporting(0);
ini_set('register_globals','off');// ��� ������� �������� ��� ���� ��������� php

include "config.php";

$avatardir="./avatars"; // ������� ���� ����������� �������
$maxfsize=round($max_file_size/10.24)/100;
$valid_types=array("gif","jpg","png","jpeg");  // ���������� ����������

// ������� �������� ����������� �����. ����������: addtop();
function addtop() { global $wrfname,$fskin,$date,$time;

// ���� � ����� wrfcookies ����� ������� ���
if (isset($_COOKIE['wrfcookies'])) {$wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc); $wrfc=explode("|", $wrfc);  $wrfname=$wrfc[0];} else {$wrfname=null; $wrfpass=null;}

echo'<TD align=right>';

if ($wrfname!=null) {
$codename=urlencode($wrfname); // �������� ��� � ����������, ��� ��������� ���������� �������� ����� ����� GET-������.
print "<a href='tools.php?event=profile&pname=$codename' class=mainmenu><img src=\"$fskin/icon_mini_profile.gif\" border=0 hspace=3 />��� �������</a>&nbsp;&nbsp;<a href='index.php?event=clearcooke' class=mainmenu><img src=\"$fskin/ico-login.gif\" border=0 hspace=3 />����� [<B>$wrfname</B>]</a>";}

else {print "<span class=mainmenu>
<a href='tools.php?event=reg' class=mainmenu><img src=\"$fskin/icon_mini_register.gif\" border=0 hspace=3 />�����������</a>&nbsp;&nbsp;
<a href='tools.php?event=login' class=mainmenu> <img src=\"$fskin/buttons_spacer.gif\" border=0 hspace=3>����</a></td>";}

if (is_file("$fskin/tiptop.html")) include("$fskin/tiptop.html");  // ���������� ���������� � ��������

print"</span></td></tr></table></td></tr></table><span class=gensmall>�������: $date - $time";
return true;}


function replacer ($text) { // ������� ������� ����
$text=str_replace("&#032;",' ',$text);
$text=str_replace("&",'&amp;',$text); // �������������� ��� ������ ���� �� ����������� �����: ����������, ���������, ���������� � �.�.
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



// --�����������--
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





// �Ѩ, ��� �������� ��� ������� ���������� $_GET['event']
if(isset($_GET['event'])) {



if ($_GET['event']=="login") { // ���� �� ����� ����������
$frname="���� �� ����� .:. "; $frtname="";
include("$fskin/top.html");  addtop();  // ���������� ����� ������

print"<BR><BR><BR><BR><center>
<table bgcolor=navy cellSpacing=1><TR><TD class=row2>
<TABLE class=bakfon cellPadding=4 cellSpacing=1>

<FORM action='tools.php?event=regenter' method=post>
<TR class=toptable><TD align=middle colSpan=2><B>���� �� �����</B></TD></TR>
<TR class=row1><TD>���:</TD><TD><INPUT name=name class=post></TD></TR>
<TR class=row2><TD>������:</TD><TD><INPUT type=password name=pass class=post></TD></TR>
<TR class=row1><TD colspan=2><center><INPUT type=submit class=button value=�����></TD></TR></TABLE></FORM> </TD></TR></TABLE>";

print "<BR><BR><BR>
<table bgcolor=navy cellSpacing=1><TR><TD class=row2>
<TABLE class=bakfon cellPadding=3 cellSpacing=1>
<FORM action='tools.php?event=givmepassword' method=post>
<TR class=toptable><TD align=middle colSpan=3><B>������ ������? ������� �� �����:</B></TD></TR>
<TR class=row1><TD><B>��� �����:</B> <font color=red>*</font></TD><TD><INPUT name=myemail class=post style='width: 170px'></TD>
<TR class=row1><TD><B>��� (���):</B></TD><TD><INPUT name=myname class=post style='width: 170px'></TD></TR>
<TR><TD colspan=2 align=center><INPUT type=submit class=button style='width:150' value='������� ������'></TD></TR>
<TR><TD colspan=3><small><font color=red>*</font> �� ��� ����������� ����� ����� �������<br> ���������� ��� �������������� ������� ������.</TD></TR></TABLE>
</FORM></TD></TR></TABLE><BR><BR><BR><BR><BR>
</TD></TR></TABLE>
</TD></TR></TABLE>"; exit;}


// ��������� - ���� ������: ��� 1
if ($_GET['event']=="repa") {

if (!isset($_GET['name'])) exit("��� ������ ���������� $name.");
if (!isset($_GET['who'])) exit("��� ������ ���������� $who.");
$name=replacer($_GET['name']); $userpn=$_GET['who'];
if (!ctype_digit($userpn) or strlen($userpn)>4) exit("<B>$back. ������� ������. ������� ����� �� �����.</B>");


// ���� ����� ��� - �����, ���� ���� ���� � ����� ����� ����� - �����.
if (!isset($_COOKIE['wrfcookies'])) exit("<html><head><title>��������� ���������</title></head><body><center><br><br><br>��������� ��������� ����� ����������� ������ �������� ������!");
else { $wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc); $wrfc=explode("|", $wrfc);  $wrfname=$wrfc[0];
if ($wrfname===$name) exit("<B>$back. �� �������� ������<br> <font color=red>��������� ��������� ���� ���������!</font>");
print "<html><head><title>��������� ��������� ���������: $name</title></head><body><center>
<FORM action='tools.php?event=repasave' method=post>
<table cellpadding=5 cellspacing=10 border=0><TR height=40>
<TD colspan=6 align=center><font size=+2><I><B>������� ���������<br> ��������� $name</B></I></FONT></TD></TR><TR>
<TD bgcolor=#880003><font size=+2 color=white>-5<INPUT name=repa type=radio value='-5'></TD>
<TD bgcolor=#FF2025><font size=+2 color=white>-2<INPUT name=repa type=radio value='-2'></TD>
<TD bgcolor=#FFB7B9><font size=+2 color=white>-1<INPUT name=repa type=radio value='-1'></TD>
<TD bgcolor=#FFFF00><font size=+2 color=#FF8040>0<INPUT name=repa checked type=radio value='0'></TD>
<TD bgcolor=#A4FFAA><font size=+2 color=white>+1<INPUT name=repa type=radio value='+1'></TD>
<TD bgcolor=#00C10F><font size=+2 color=white>+2<INPUT name=repa type=radio value='+2'></TD>
<TD bgcolor=#00880B><font size=+2 color=white>+5<INPUT name=repa type=radio value='+5'></TD>
</TR></TABLE>
<INPUT type=hidden name=userpn value=$userpn>
<TR><TD bgColor=#FFFFFF colspan=2><center><INPUT type=submit value=���������></TD></TR></TBODY></TABLE>
</FORM>"; exit; }}


// ��������� - ����������: ��� 2
if ($_GET['event']=="repasave")  {
if (!isset($_POST['userpn'])) exit("��� ������ ���������� $userpn.");
if (!isset($_POST['repa'])) exit("��� ������ ���������� $repa.");
$userpn=$_POST['userpn']; if (!ctype_digit($userpn) or strlen($userpn)>4) exit("<B>$back. ������� ������. ������� ����� �� �����.</B>");
$repa=$_POST['repa']; if (!is_numeric($repa)) exit("<B>$back. ������� ������. �� ��������, ����!</B>");
if ($repa>5 or $repa<-5) exit("<B>$back. ������� ������. ���� ����� ������ ������ �� +-5 �������. �� ��������, ����!</B>");
$today=mktime();
// ���� ��������� + � ��������� �����
//���_�����|���|���������|���������|�������������� �/5|����� ��������� ��� ������ ������� � UNIX �������|||
$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1; $ulinenew="";
// ���� ����� �� ����� � ����� userstat.dat, ���� ������� ���������� �� ����, ���������.
for ($i=0;$i<=$ui;$i++) {$udt=explode("|",$ulines[$i]);
if ($i==$userpn) {$udt[3]=$udt[3]+$repa; if (strlen($udt[5])>5) {$next=$today-$udt[5]; sleep(1); if ($next<60) {$last=60-$next; exit("<B>$back. ������� ����� ���������<br> ��� ��� ������ ������ ���.<br> <font color=red>�������� $last ������.</font> </B>");}}
$ulines[$i]="$udt[0]|$udt[1]|$udt[2]|$udt[3]|$udt[4]|$today||||\r\n";}
$ulinenew.="$ulines[$i]";}
// ���������� ������ � ����
$fp=fopen("$ufile","w");
flock ($fp,LOCK_EX);
fputs($fp,"$ulinenew");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
print "<div align=center><BR><BR><BR>������� <B>�������</B> ����������.<BR><BR><BR><a href='' onClick='self.close()'><b>������� ����</b></a></div>";
exit; }





// �������� ��������� �����
if ($_GET['event']=="mailto") {
if ($sendmail!="1") exit("$back. <center><B>��������, �� ������� �������� ����� ������������� ���������������!<BR><BR><BR><a href='' onClick='self.close()'>������� ����</b></a></center>");

if (!isset($_GET['email'])) exit("��� ������ ���������� $email.");
if (!isset($_GET['name'])) exit("��� ������ ���������� $name.");
if (isset($_GET['fid'])) $fid=$_GET['fid'];
if (isset($_GET['id'])) $id=$_GET['id'];
$uemail=replacer($_GET['email']);
$uname=replacer($_GET['name']);

print "<html><head><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'><meta http-equiv='Content-Language' content='ru'>
<title>����������� ��������� ������ ����������</title></head><body topMargin=5>
<center><TABLE bgColor=#aaaaaa cellPadding=2 cellSpacing=1 width=502>
<FORM action='tools.php?event=mailtogo' method=post>
<TBODY><TR><TD align=middle bgColor=#cccccc colSpan=2>���������� ���������: <B>$uname</B></TD></TR>

<TR bgColor=#ffffff><TD>&nbsp; ���� ���:<FONT color=#ff0000>*</FONT> <INPUT name=name style='FONT-SIZE: 14px; WIDTH: 150px'>

� E-mail:<FONT color=#ff0000>*</FONT> <INPUT name=email style='FONT-SIZE: 14px; WIDTH: 180px'></TD></TR>

<TR bgColor=#ffffff><TD>&nbsp; ���������:<FONT color=#ff0000>*</FONT><br>
<TEXTAREA name=msg style='FONT-SIZE: 14px; HEIGHT: 150px; WIDTH: 494px'></TEXTAREA></TD></TR>
<INPUT type=hidden name=uemail value=$uemail><INPUT type=hidden name=uname value=$uname>";


//-�-�-�-�-�-�-�-�-
if (!isset($wrfname)) {
if ($antispam!="0") {

// ����� ����������� �� ����� (��� ���������� - ����� �� ������)
if (array_key_exists("image", $_REQUEST)) { $num=$_REQUEST["image"];
for ($i=0; $i<10; $i++) {if (md5($i+$rand_key)==$num) {imgwr($st,$i); die();}} }

$xkey=""; mt_srand(time()+(double)microtime()*1000000);

echo'<TR><TD bgColor=#ffffff>�������� ���: ';
for ($i=0; $i<$max_key; $i++) {
$snum[$i]=mt_rand(0,9); $psnum=md5($snum[$i]+$rand_key);
$phpself=$_SERVER["PHP_SELF"];
echo "<img src=$phpself?image=$psnum border='0' alt=''>\n";
$xkey=$xkey.$snum[$i];
}
$xkey=md5("$xkey+$rand_key");

print" <input name='usernum' class=post type='text' maxlength=$max_key size=6> (������� �����)
<input name=xkey type=hidden value='$xkey'>";
} // if $antispam!="0"
} // if !isset($wrfname)
//-�-�-�-�-�--�-�-�-�-�-�-�-�-�-

if (isset($_GET['id'])) print"<INPUT type=hidden name=id value=$id><INPUT type=hidden name=fid value=$fid>";

echo'<TR><TD bgColor=#FFFFFF colspan=2><center><INPUT type=submit value=���������></TD></TR></TBODY></TABLE></FORM>'; 
exit; }


// ��� 2 �������� ��������� ������������
if ($_GET['event']=="mailtogo")  {
$name=replacer($_POST['name']);
$email=replacer($_POST['email']);
$msg=$_POST['msg'];
if (isset($_POST['fid'])) $fid=$_POST['fid'];
if (isset($_POST['id'])) $id=$_POST['id'];
$uname=replacer($_POST['uname']);
$uemail=replacer($_POST['uemail']);

//--�-�-�-�-�-�-�-�--�������� ����--
if ($antispam!="0") {
$bada="$back <font color=red>�������� ���� ��� �� �����</font>!";
if (isset($_POST['usernum'])) $usernum=$_POST['usernum']; else exit("$bada");
if (isset($_POST['xkey'])) $xkey=$_POST['xkey']; else exit("$bada");
$userkey=md5("$usernum+$rand_key");
if ($userkey!=$xkey) exit("$bada"); }
//--�-�-�-�-�-�-�-�--�������� ����--

if (!preg_match('/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$/si',$email) and strlen($email)>30 and $email!="") exit("$back � ������� ���������� E-mail �����!</B></center>");
if (!preg_match('/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$/si',$uemail) and strlen($uemail)>30 and $uemail!="") exit("$back � ������������ ����� �������������� �����!</B></center>");
if ($name=="") exit("$back �� �� ����� ��� ���!</B></center>");
if ($msg=="") exit("$back �� �� ����� ���������!</B></center>");

$text="$name|$msg|$uname|$email|";
$text=htmlspecialchars($text);
$text=stripslashes($text);
$text=str_replace("\r\n","<br>",$text);
$exd=explode("|",$text); $name=$exd[0]; $msg=$exd[1]; $uname=$exd[2]; $email=$exd[3];

$headers=null; // ��������� ��� �������� �����
$headers.="From: $name $email\n";
$headers.="X-Mailer: PHP/".phpversion()."\n";
$headers.="Content-Type: text/html; charset=windows-1251";

// �������� ��� ���������� � ���� ������
$host=$_SERVER["HTTP_HOST"]; $self=$_SERVER["PHP_SELF"];
$furl="http://$host$self";
$furl=str_replace("tools.php", "", $furl);

$allmsg="<html><head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'><meta http-equiv='Content-Language' content='ru'>
</head><body>
<BR><BR><center>$uname, ��� ��������� ���������� ��� �� ���������� ������ <BR><B>$fname</B><BR><BR>
<table cellspacing=0 width=700 bgcolor=navy><tr><td><table cellpadding=6 cellspacing=1 width='100%'>
<tr bgcolor=#F7F7F7><td width=130 height=24>���</td><td>$name</td></tr>
<tr bgcolor=#F7F7F7><td>E-mail:</td><td><font size='-1'>$email</td></tr>
<tr bgcolor=#F7F7F7><td> ���������:</td><td><BR>$msg<BR></td></tr>
<tr bgcolor=#F7F7F7><td>���� �������� ���������:</td><td>$time - <B>$date �.</B></td></tr>
<tr bgcolor=#F7F7F7><td>������� �� ������� ��������:</td><td><a href='$furl'>$furl</a></td></tr>
</table></td></tr></table></center><BR><BR>* ������ ������ ������������� � ���������� �������, �������� �� ���� �� �����.
</body></html>";

mail("$uemail", "��������� �� ���������� ������ ($fname) �� $name ", $allmsg, $headers);
print "<div align=center><BR><BR><BR>���� ��������� <B>�������</B> ����������.<BR><BR><BR><a href='' onClick='self.close()'><b>������� ����</b></a></div>";
exit; }





// �������� �����/������ � ���� �� �����
if ($_GET['event']=="regenter")  // if ($event =="regenter")
{
if (!isset($_POST['name']) & !isset($_POST['pass'])) exit("$back ������� ��� � ������!");
$name=str_replace("|","I",$_POST['name']); $pass=replacer($_POST['pass']);
$name=replacer($name); $name=strtolower($name);
if (strlen($name)<1 or strlen($pass)<1) exit("$back �� �� ����� ��� ��� ������!");

// �������� �� ���� ������������� � ������� ������
$lines=file("$datadir/usersdat.php"); $i=count($lines); $regenter=FALSE;
$pass=md5("$pass");
do {$i--; $rdt=explode("|",$lines[$i]);
if (isset($rdt[1])) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������
if ($name===strtolower($rdt[0]) & $pass===$rdt[1]) {
if (strlen($rdt[13])>1 and ctype_digit($rdt[13])) exit("$back. ���� ������� ������ �� <a href='tools.php?event=reg3'>������������</a>. ��� ��������� ��� ���������� ������� �� ������, ������� ������ ������ ��� �� �����.");
$regenter=TRUE;
$tektime=time();
$wrfcookies="$rdt[0]|$rdt[1]|$tektime|$tektime|";
setcookie("wrfcookies", $wrfcookies, time()+1728000);
}} // if-�

} while($i > "1");

if ($regenter==FALSE) exit("$back ��� ������ <B>�� �����</B>!</center>");
Header("Location: index.php");
}








// ����������� ����� ��� 2!! �������� �� ��� ������������� � ���������� � ��
if ($_GET['event']=="reg2") {

if (!isset($_POST['name']) & !isset($_POST['pass'])) exit("$back ������� ��� � ������!");
$name=str_replace("|","I",$_POST['name']); $pass=str_replace("|","I",$_POST['pass']); $dayreg=$date;
$name=trim($name); // �������� ���������� ������� 

if (isset($_POST['email'])) $email=$_POST['email']; else $email="";
$email=strtolower($email);

//--�-�-�-�-�-�-�-�--�������� ����--
if ($antispam!="0") { $bada="$back <font color=red>�������� ���� ��� �� �����</font>!";
if (isset($_POST['usernum'])) $usernum=$_POST['usernum']; else exit("$bada");
if (isset($_POST['xkey'])) $xkey=$_POST['xkey']; else exit("$bada");
$userkey=md5("$usernum+$rand_key");
if ($userkey!=$xkey) exit("$bada"); }
//--�-�-�-�-�-�-�-�--�������� ����--

if (preg_match("/[^(\\w)|(\\x7F-\\xFF)|(\\-)]/",$name)) exit("$back ���� ��� �������� ����������� �������. ��������� ������� � ���������� �����, ����� � �������������!!.");
if ($name=="" or strlen($name)>$maxname) exit("$back ���� ��� ������, ��� ��������� $maxname ��������!</B></center>");
if ($pass=="" or strlen($pass)<1 or strlen($pass)>$maxname) exit("$back �� �� ����� ������. ������ �� ������ ���� ������.</B></center>");
if(!preg_match("/^[a-z0-9\.\-_]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is", $email) or $email=="" or strlen($email)>40) exit("$back � ������� ���������� E-mail �����!</B></center>");
if (isset($_POST['pol'])) $pol=$_POST['pol']; else $pol=""; if ($pol!="�������") $pol="�������";

$email=str_replace("|","I",$email);

$key=mt_rand(100000,999999); if ($useactkey!="1") $key=""; // ������� ��������� ��� ���������? ���� �� ��������� - ��������

$pass=replacer($pass); $ps=md5("$pass");
$text="$name|$ps|0|$email|$dayreg||$pol||||||noavatar.gif|$key|";
$text=replacer($text);
$exd=explode("|",$text); $name=$exd[0]; $email=$exd[3];

if ($name===$pass) exit("$back. � ����� ����� ������������, <B>��������� ��������� ����� � ������!</B>");

// ���� ����� � ����� ������� ��� �������
$loginsm=strtolower($name);
$lines=file("$datadir/usersdat.php"); $i=count($lines);
if ($i>"1") { do {$i--; $rdt=explode("|",$lines[$i]); 
$rdt[0]=strtolower($rdt[0]);
if ($rdt[0]===$loginsm) {$bad="1"; $er="�������";}
if ($rdt[3]===$email) {$bad="1"; $er="�������";}
} while($i > 1);
if (isset($bad)) exit("$back. �������� � ����� <B>$er ��� ��������������� �� ������</B>!</center>"); }

// �������� ������������ ���� ���������
$host=$_SERVER["HTTP_HOST"]; $self=$_SERVER["PHP_SELF"];
$furl="http://$host$self";

$headers=null;  // ��������� ��� �������� �����
$headers.="From: $name <$email>\n";
$headers.="X-Mailer: PHP/".phpversion()."\n";
$headers.="Content-type: text/plain; charset=windows-1251";

// �������� ��� ���������� � ���� ������
if ($useactkey=="1") {
$allmsg=$fname.' (������������� �����������)'.chr(13).chr(10).
 '����������� ������������ �� ������, ��� ����� ��������� �� ������: '.$furl.'?event=reg3&email='.$email.'&key='.$key.chr(13).chr(10).
 '���� ���: '.$name.chr(13).chr(10).
 '��� ������: '.$pass.chr(13).chr(10).
 '��� E-mail: '.$email.chr(13).chr(10).
 '������������� ����: '.$key.chr(13).chr(10).chr(13).chr(10).
 '��������� ������ � ������� ��� ��������� ���.'.chr(13).chr(10).
 '������ �� ������ �������� � ������������� ����, ������� ������ ����������.'.chr(13).chr(10).
 '��� �������������� ������� � ������ ��� ������� ��������������� �������� �������������� ������.'.chr(13).chr(10);
 
} else { $allmsg=$fname.' (������ �����������)'.chr(13).chr(10). '�� ������� ���������������� �� ������: '.$furl.chr(13).chr(10).  '���� ���: '.$name.chr(13).chr(10).  '��� ������: '.$pass.chr(13).chr(10).  '��� E-mail: '.$email.chr(13).chr(10); }

// ���������� ������ ������� �� �������� ;-)
mail("$email", "=?windows-1251?B?" . base64_encode("$fname (������������� �����������)") . "?=", $allmsg, $headers);
if ($sendadmin=="1") {mail("$adminemail", "=?windows-1251?B?" . base64_encode("$fname (����� ��������)") . "?=", $allmsg, $headers);}

$file=file("$datadir/usersdat.php");
$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);//�������� ��������� ������
flock ($fp,LOCK_UN);
fclose($fp);

// ���������� ������� � ������ � ���� �� �����������
$file=file("$datadir/userstat.dat");
$fp=fopen("$datadir/userstat.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$name|0|0|0|0|||\r\n");
fflush ($fp);//�������� ��������� ������
flock ($fp,LOCK_UN);
fclose($fp);

if ($useactkey!="1") { $tektime=time(); $wrfcookies="$name|$pass|$tektime|0|"; setcookie("wrfcookies", $wrfcookies, time()+1728000);
print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>
<script language='Javascript'>function reload() {location = \"index.php\"}; setTimeout('reload()', 2500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
<B>$name, �� ������� ����������������</B>.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� �� ������� �������� ������.<BR><BR>
<B><a href='index.php'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>"; exit;}

print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>
<script language='Javascript'>function reload() {location = \"tools.php?event=reg3\"}; setTimeout('reload()', 2500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
<B>$name, �� ��������� ���� ����� ��� ������ ��� �������������.
��� ���� ����� ������������������ - ������� ��� �� ��������, ���� ��������� �� ������ - ��������� � ������</B>.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� �� �������� ������������� �����������.<BR><BR>
<B><a href='tools.php?event=reg3'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;
}






// ����������� ��� 3 - ���� ����� ���� ������������� �� ������
if ($_GET['event']=="reg3") {

if (isset($_GET['email']) and isset($_GET['key'])) {$key=$_GET['key']; $email=$_GET['email'];} else {
$frname=""; $frtname=""; include("$fskin/top.html");  addtop(); // ���������� ����� ������
print"<center><span class=maintitle>������������� �����������*</span><br>
<br><form action='tools.php' method=GET>
<input type=hidden name=event value='reg3'>
<table cellpadding=3 cellspacing=1 width=100% class=forumline><tr>
<th class=thHead colspan=2 height=25 valign=middle>���� ������ � �������������� �����</th>
</tr><tr><td class=row1><span class=gen>����� e-mail:</span><br><span class=gensmall></span></td><td class=row2><input type=text class=post style='width: 200px' name=email size=25 maxlength=50></td>
</tr><tr><td class=row1><span class=gen>������������� ����:</span><br><span class=gensmall></span></td><td class=row2><input type=text class=post style='width: 200px' name=key size=25 maxlength=6></td></tr><tr>
<td class=catBottom colspan=2 align=center height=28><input type=submit value='����������� �����������' class=mainoption></td>
</tr></table>
* �� ������ ���� ������ ����� � ����, ������� ������ �� �����, ���� ������� �� ������������� ������ � ������.
</form>"; exit; }

// ������ �� ������ �� ����� � ������
if (strlen($key)<6 or strlen($key)>6 or !ctype_digit($key)) exit("$back. �� �������� ��� ����� �����. ���� ����� ��������� ������ 6 ����.");
$email=stripslashes($email); $email=htmlspecialchars($email);
$email=str_replace("|","I",$email); $email=str_replace("\r\n","<br>",$email);
if (strlen($key)>30) exit("������ ��� ����� ������");

// ���� ����� � ����� ������� � ������. ���� ���� - ������ ������ �� ������ ����.
$fnomer=null; $email=strtolower($email); unset($fnomer); unset($ok);
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
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$fnomer) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
// ������������� ����
$tektime=time(); $wrfcookies="$name|$pass|$tektime|0|";
setcookie("wrfcookies", $wrfcookies, time()+1728000);
}
if (!isset($fnomer) and !isset($ok)) exit("$back. �� �������� � ���� �������������� ����� ��� ������.</center>");
if (isset($ok)) $add="���� ������ ��� ������������"; else $add="$name, �� ������� ����������������";

print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>
<script language='Javascript'>function reload() {location = \"index.php\"}; setTimeout('reload()', 2500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$add</B>.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� �� ������� �������� ������.<BR><BR>
<B><a href='index.php'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit; }






// ��������� ������ ����������� - ���������� ������
if ($_GET['event']=="reregist") { // if ($event =="reregist")

if (!isset($_POST['name'])) exit("$back ������� ���� ���!");
$name=str_replace("|","I",$_POST['name']);
if ($name=="" or strlen($name)>$maxname) exit("$back ���� ��� ������, ��� ��������� $maxname ��������!</B></center>");
$name=trim($name); // �������� ���������� ������� 
if (preg_match("/[^(\\w)|(\\x7F-\\xFF)|(\\-)]/",$name)) exit("$back ���� ��� �������� ����������� �������. ��������� ������� � ���������� �����, ����� � �������������!!.");

if (!isset($_POST['pass'])) exit("$back �� �� ����� ������!");
$oldpass=$_POST['oldpass']; // ������ ������
$pass=trim($_POST['pass']);
if (strlen($_POST['newpassword'])<1 ) exit("$back ����������� ����� ������ ������� 1 ������!");
if ($_POST['newpassword']!="�����") {$pass=trim($_POST['newpassword']); 
if (strlen($pass)<1 or strlen($pass)>20) exit("$back �� �� ����� ������. ������ ������ ���� ������ �� 1 �� 20 ��������!</B></center>");
$pass=md5("$pass");}
$pass=replacer($pass); $pass=str_replace("|","I",$pass);

if (isset($_POST['email'])) $email=$_POST['email']; else $email=""; $email=strtolower($email);
if(!preg_match("/^[a-z0-9\.\-_]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is", $email) or $email=="" or strlen($email)>40) exit("$back � ������� ���������� E-mail �����!</B></center>");

if (isset($_POST['dayx'])) $dayx=$_POST['dayx']; else $dayx="";
if (isset($_POST['pol'])) $pol=$_POST['pol']; else $pol="";  if ($pol!="�������") $pol="�������";
if (isset($_POST['icq'])) $icq=$_POST['icq']; else $icq="";
if (isset($_POST['www'])) $www=$_POST['www']; else $www="";
if (isset($_POST['about'])) $about=$_POST['about']; else $about="";
if (isset($_POST['work'])) $work=$_POST['work']; else $work="";
if (isset($_POST['write'])) $write=$_POST['write']; else $write="";
if (isset($_POST['avatar'])) $avatar=$_POST['avatar']; else $avatar="";

$notgood="$back ������� ������� �������� ���������� ";
if (strlen($dayx)>20) {$notgood.="���� ��������!"; exit("$notgood");}
if (strlen($icq)>10) {$notgood.="ICQ!"; exit("$notgood");}
if (strlen($www)>75) {$notgood.="URL �����!"; exit("$notgood");}
if (strlen($about)>75) {$notgood.="������!"; exit("$notgood");}
if (strlen($work)>75) {$notgood.="��������!"; exit("$notgood");}
if (strlen($write)>75) {$notgood.="�������!"; exit("$notgood");}

$email=str_replace("|","I",$email);
$dayx=str_replace("|","I",$dayx);
$icq=str_replace("|","I",$icq);
$www=str_replace("|","I",$www);
$about=str_replace("|","I",$about);
$work=str_replace("|","I",$work);
$write=str_replace("|","I",$write);
$avatar=str_replace("|","I",$avatar);

// �������� ������/������� ������
$ok=null; $lines=file("$datadir/usersdat.php"); $i=count($lines); unset($ok);
do {$i--; $rdt=explode("|", $lines[$i]);
   if (strtolower($name)===strtolower($rdt[0]) & $oldpass===$rdt[1]) $ok="$i"; // ���� ����� �����/������
   else { if ($email===$rdt[3]) $bademail="1"; } // ����� � ������ ��� ���� ����� �����?
} while($i > "1");
if (isset($bademail)) exit("$back. �������� � ������� <B>$email ��� ���������������</B> �� ������!</center>");
if (!isset($ok)) {setcookie("wrfcookies","",time());
exit("$back ��� ����� ����� /������ / ����� �� ��������� �� � ����� �� ��. <BR><BR>
����� ������������ ������ <font color=red><B>���������</B></font><BR><BR>
<font color=red><B>������ ������� ��� ������� ������ - ���������� � ��������������!</B></font>");}
$udt=explode("|",$lines[$ok]); $dayreg=$udt[4]; $kolvomsg=$udt[2]; $status=$udt[13];


// ���� �������� �������
if ($_FILES['file']['name']!="") {
$fotoname = $_FILES['file']['name']; // ���������� ��� �����
$avatar=$fotoname;
$fotosize=$_FILES['file']['size']; // ���������� ������ �����
// ��������� ����������
$ext = strtolower(substr($fotoname, 1 + strrpos($fotoname, ".")));
if (!in_array($ext, $valid_types)) {exit("<B>���� �� ��������.</B> ��������� �������:<BR>
- ��������� �������� ������ ������ � ������ ������������: gif, jpg, jpeg, png<BR>
- �� ��������� ��������� �� ����������� ����;<BR>
- ������� ����� ����� ��� ������ ����;</B><BR>");}
}

$text="$name|$pass|$kolvomsg|$email|$dayreg|$dayx|$pol|$icq|$www|$about|$work|$write|$avatar|$status|";
$text=replacer($text);
$exd=explode("|",$text); $name=$exd[0]; $pass=$exd[1]; $email=$exd[3];

// ������ ���� �����
$tektime=time(); $wrfcookies="$name|$pass|$tektime|$tektime|";
setcookie("wrfcookies", $wrfcookies, time()+1728000);

if ($_FILES['file']['name']!="") {

// ������ �� ������
// 1. ������� ���-�� ����� � ��������� - ���� ������� ����� - ��������!
$findtchka=substr_count($fotoname, "."); if ($findtchka>1) exit("����� ����������� � ����� ����� $findtchka ���(�). ��� ���������! <BR>\r\n");

// 2. ���� � ����� ���� .php, .html, .htm - ��������! 
$bag="��������. � ����� ����� <B>���������</B> ������������ .php, .html, .htm";
if (preg_match("/\.php/i",$fotoname))  exit("��������� <B>\".php\"</B> �������. $bag");
if (preg_match("/\.html/i",$fotoname)) exit("��������� <B>\".html\"</B> �������. $bag");
if (preg_match("/\.htm/i",$fotoname))  exit("��������� <B>\".htm\"</B> �������. $bag");

// 3. �������� �� ������� ���� � ����� ����� � ��������� ���������� ����� 
if (!preg_match("/^[a-z0-9\.\-_]+\.(jpg|gif|png|jpeg)+$/is",$fotoname)) exit("��������� ������������ ������� ����� � ����� �����!");

// 4. ���������, ����� ���� ���� � ����� ������ ��� ���� �� �������
if (file_exists("$avatardir/$fotoname")) exit("���� � ����� ������ ��� ���������� �� �������! �������� ��� �� ������!");
// ����� ����� �� ����� �����

// 5. ������ � ��. < �����������
$fotoksize=round($fotosize/10.24)/100; // ������ ������������ ���� � ��.
$fotomax=round($max_file_size/10.24)/100; // ������������ ������ ���� � ��.
if ($fotoksize>$fotomax) exit("�� ��������� ���������� ������ ����! <BR><B>����������� ����������</B> ������ ����: <B>$fotomax </B>��.<BR> <B>�� ���������</B> ��������� �����������: <B>$fotoksize</B> ��!");

// 6. "��������" ������� > 150 � 150 - �� ��������! :-)
$size=getimagesize($_FILES['file']['tmp_name']);
if ($size[0]>150 or $size[1]>150) exit("�� ���������� �������� �������. ��������� ���� 150 � 150 px!");

if   ($fotosize>"0" and $fotosize<$max_file_size) {
     copy($_FILES['file']['tmp_name'], $avatardir."/".$fotoname);
     print "<br><br>���� ������� ���������: $fotoname (������: $fotosize ����)";}
else {exit("<B>���� �� �������� - ������ �������!
���� �� ������ ��������� - [function.getimagesize]: Filename cannot be empty, ������ � ��� ���������� GD �����������, ���� ������ ������<br>
�����, ������ �� ����� ��� �������� ��������� ��������, ��� �� �������� �������� �������� ������ ����� http ��� ���������!
���������� � ��������������!<B>");}
} // ����� ����� �������� �������



$file=file("$datadir/usersdat.php");
$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//������� ���������� ����� 
for ($i=0;$i< sizeof($file);$i++) { if ($ok!=$i) fputs($fp,$file[$i]); else fputs($fp,"$text\r\n"); }
fflush ($fp);//�������� ��������� ������
flock ($fp,LOCK_UN);
fclose($fp);

print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>
<script language='Javascript'>function reload() {location = \"index.php\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$name, ���� ������ ������� ��������</B>.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� �� ������� �������� ������.<BR><BR>
<B><a href='index.php'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit; }





if ($_GET['event'] =="givmepassword") {  // �������� �������� ������ �� ����

// ������ �� ��������� ������
if (!isset($_POST['myemail']) or !isset($_POST['myname'])) exit("�� ����� �� ��������� ������!");
$myemail=strtolower($_POST['myemail']); $myemail=replacer($myemail);
$myname =strtolower($_POST['myname']);  $myname =replacer($myname);
if (strlen($myemail)>40 or strlen($myname)>40) exit("����� ����� ��� ����� ������ ���� ����� 40 ��������!");

// ���������� ����� ������ �����
$len=8; // ���������� �������� � ����� ������
$base='ABCDEFGHKLMNPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
$max=strlen($base)-1; $pass=''; mt_srand((double)microtime()*1000000);
while (strlen($pass)<$len) $pass.=$base{mt_rand(0,$max)};

$lines=file("$datadir/usersdat.php"); $record="<?die;?>\r\n"; $itogo=count($lines); $i=1; $regenter=FALSE;

do {$rdt=explode("|", $lines[$i]); // �������� �� ���� ������������� � ������� ������
if (isset($rdt[1])) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������
$rdt[3]=strtolower($rdt[3]); $rdt[0]=strtolower($rdt[0]);
if ($myemail===$rdt[3] or $myname===$rdt[0]) {$regenter=TRUE; $myemail=$rdt[3]; $myname=$rdt[0]; $passmd5=md5("$pass"); $lines[$i]=str_replace("$rdt[1]","$passmd5",$lines[$i]);}
} //if  isset
$record.=$lines[$i];
$i++; } while($i < $itogo);

// ����� IP-�������������� ������
$ip=""; $ip=(isset($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:0;

// ������������ ���� ���������� - ��������� ���� ����� ������
$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
fputs($fp,"$record");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

// �������� ������������ ��� ����� � ������ �� ����
if ($regenter==TRUE) {
$headers=null; // ��������� ��� �������� �����
$headers.="From: ������������� <$adminemail>\n";
$headers.="X-Mailer: PHP/".phpversion()."\n";
$headers.="Content-Type: text/plain; charset=windows-1251";

$host=$_SERVER["HTTP_HOST"]; $self=$_SERVER["PHP_SELF"];
$furl="http://$host$self";
$furlm=str_replace("tools.php", "index.php", $furl);
// �������� ��� ���������� � ���� ������
$allmsg=$fname.' (������ ��� �������������� ������� � ������)'.chr(13).chr(10).
        '��, ���� ���-�� ������ � IP-������ '.$ip.' ��������� ������ ��� �������������� ������� � ������ �� ������: '.$furlm.chr(13).chr(10).chr(13).chr(10).
        '���� ���: '.$myname.chr(13).chr(10).
        '��� ����� ������: '.$pass.chr(13).chr(10).chr(13).chr(10).
        '��� ����� �� ����� ��������� �� ������ � ������� ����� � ����� ������: '.$furl.'?event=login'.chr(13).chr(10).chr(13).chr(10).
        '�������� ��� ������ (������ ����� ���� ��� ������) ������ ����� �� ��������: '.$furl.'?event=profile&pname='.$myname.chr(13).chr(10).chr(13).chr(10).
        '* ��� ������ ������������� �������, �������� �� ���� �� �����.'.chr(13).chr(10);
// ���������� ������ ������� �� �������� ;-)
mail("$myemail", "=?windows-1251?B?" . base64_encode("$fname (������ ��� �������������� ������� � ������)") . "?=", $allmsg, $headers);
// ���� ���� �������� � �������� �������
$msgtoopr="<B>$myname</B>, �� ��� ����������� ����� ������� ��������� � ������ � ������� ������� � ������.";
}
// ���� ��� ������ ������ � ��
else $msgtoopr="<B>��������� � ����� ������� ��� �������</B><BR> �� ������ <B>�� ����������������!</B>";
print "<html><body><script language='Javascript'>function reload() {location = \"index.php\"}; setTimeout('reload()', 2000);</script>
<BR><BR><BR><center><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 width=300><tr><td align=center>
<font style='font-size: 15px'>$msgtoopr ����� ��������� ������ �� ������ ������������� ���������� �� ������� ��������.
���� ����� �� ����������, ������� <B><a href='index.php'>�����</a></B></font>.</td></tr></table></center><BR><BR><BR></body></html>";
exit; }






if ($_GET['event']=="moresmiles") {   // ���������� ���� ������� �� ���������� SMILE

$lines=null; unset($lines); if (!is_dir("smile/")) exit("����� smile �� ����������.");
$i=0; if ($handle = opendir("smile/")) {
while (($file = readdir($handle)) !== false)
if (!is_dir($file)) {$lines[$i]=$file; $i++;}
closedir($handle);
}
if (!isset($lines)) exit("� ����� smile ��� �������! ���������� � ������ - ����� ������.");
$itogo=count($lines); $k=0; $text=null;
$host=$_SERVER["HTTP_HOST"]; $self=$_SERVER["PHP_SELF"];
$forurl="http://$host$self";
$forurl=str_replace("/tools.php", "", $forurl);
print"<html><head><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'><meta http-equiv='Content-Language' content='ru'></head><body>
<script language=\"JavaScript\">
  function setSmile(symbol) {
    obj = opener.document.REPLIER.msg;
    obj.value = obj.value + symbol;
  }
</script>
<center><h4>�������������� ������</h4>";
do {
$rdt=explode(".",$lines[$k]);
if ($rdt[1]=="jpg" or $rdt[1]=="gif") {print"<a href=\"javascript:setSmile('[img]$forurl/smile/$lines[$k][/img] ')\"><img src='smile/$lines[$k]' border=0></a>&nbsp; ";}
$k++;
} while ($k<$itogo);
print"<BR><a href='' onClick='self.close()'><b>������� ����</b></a></center><br><small>P.S. �������������! ����� ����� ��������� ����� ������ - ������ ������� ����� ������ � ����� $forurl/smile/</small></body></html>";
exit; }


// ----- ����� ��� ���� ������� ������

if (isset($_COOKIE['wrfcookies']))  {
$wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc);
$wrfc = explode("|", $wrfc);
$wrfname=$wrfc[0];$wrfpass=$wrfc[1];$wrftime1=$wrfc[2];$wrftime2=$wrfc[3];
if (time()>($wrftime1+50)) {$tektime=time();$wrfcookies="$wrfc[0]|$wrfc[1]|$tektime|$wrftime1";setcookie("wrfcookies", $wrfcookies, time()+1728000);}}
 else {unset($wrfname); unset($wrfpass);}

// -----


$frname=""; $frtname=""; include("$fskin/top.html");  addtop(); // ���������� ����� ������

// ��������� ��� ���������� ���������������������
$userlines=file("$datadir/usersdat.php");
$ui=count($userlines)-1;
$tdt=explode("|", $userlines[$ui]);






if ($_GET['event']=="who") {  // �������� ���� ���������� ������

// ���� ��������� - �� �������
if (!isset($_COOKIE['wrfcookies'])) exit("<br><br><br><br><table class=forumline align=center width=700><tr><th class=thHead colspan=4 height=25>������ ���������</th></tr><tr class=row2><td class=row1><center><BR><BR><B><span style='FONT-SIZE: 14px'>��� ��������� ������ ������������� ���������� ������������������.</B></center><BR><BR>$back<BR><BR></td></table><br>");

$t1="row1";
$alllines=file("$datadir/usersdat.php");
$allmaxi=count($alllines)-1; $i=1; $j=0; $flag=0;

if (isset($_GET['pol'])) $pol=replacer($_GET['pol']); else $pol="";
if (isset($_GET['interes'])) $interes=replacer($_GET['interes']); else $interes="";
if (isset($_GET['url'])) $url=replacer($_GET['url']); else $url="";
if (isset($_GET['from'])) $from=replacer($_GET['from']); else $from="";

if($pol!="" or $interes!="" or $url!="" or $from!="") {
do {$dt=explode("|", $alllines[$i]);
// ���� ���� ���������� � ������ - ����������� ����� �������� 1
if ($dt[6]!="" and $pol!="") {if (stristr($dt[6],$pol)) $flag=1;} // ���� ������ �� �����
if ($dt[10]!="" and $interes!="") {if (stristr($dt[10],$interes)) $flag=1;}
if ($dt[8]!="" and $url!="") {if (stristr($dt[8],$url)) $flag=1;}
if ($dt[9]!="" and $from!="") {if (stristr($dt[9],$from)) $flag=1;}

// ���� ���� ���� ���� ����������, �������� ��������� � ������ ����������
if ($flag==1) {$lines[$j]=$alllines[$i]; $flag=0; $j++;}
$i++; 
} while($i<$allmaxi);
$fadd="&pol=$pol&interes=$interes&url=$url&from=$from";
} else {$fadd=""; $lines=$alllines;} // ���� ����� �� �����, ����� ����������� ������

if (!isset($lines)) $maxi=0; else $maxi=count($lines)-1;

print"
<form action='tools.php?event=who' method=GET><div align=right>
<input type=hidden name=event value='who'>
������ ��: <B>����:</B> <input type=text name=pol value='$pol' class=post maxlength=50 size=28>
<B>���������:</B> <input type=text name=interes value='$interes' class=post maxlength=50 size=28>
<B>�����:</B> <input type=text name=url value='$url' class=post maxlength=50 size=28>
<B>������:</B> <input type=text name=from value='$from' class=post maxlength=50 size=28>
<input type=submit class=mainoption value='OK'></form></div>";

echo'<table width=100% cellpadding=3 cellspacing=1 class=forumline><tr> 
<th class=thCornerL height=25 width=20>�</th>
<th class=thCornerL><small>���</small></th>
<th class=thTop><small>������</small></th>
<th class=thTop><small>�� �� �-����</small></th>
<th class=thTop><small>�����������</small></th>
<th class=thTop><small>���� ��������</small></th>
<th class=thTop><small>��������</small></th>
<th class=thTop><small>����</small></th>
<th class=thCornerR><small>������</small></th>
</tr>';
if ($ui=="0") {print"<TR><TD class=$t1 colspan=8 align=center>���������� �� ����������������</TD></TR>";
} else {

// ��������� ������ ������ �������������� ��������
if (!isset($_GET['page'])) $page=1; else { $page=$_GET['page']; if (!ctype_digit($page)) $page=1; if ($page<1) $page=1; }
$maxpage=ceil(($maxi+1)/$uq); if ($page>$maxpage) $page=$maxpage;

$fm=$uq*($page-1); if ($fm>$maxi) $fm=$maxi-$uq;
$lm=$fm+$uq; if ($lm>$maxi) $lm=$maxi+1;

if (isset($lines)) {
do {$dt=explode("|", $lines[$fm]);

$fm++; $num=$fm-1;

if (isset($dt[1])) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������

$codename=urlencode($dt[0]); // �������� ��� � ����������, ��� ��������� ���������� �������� ����� ����� GET-������.
if (isset($wrfname)) {$wfn="<a href=\"tools.php?event=profile&pname=$codename\">$dt[0]</a>";
$mls="<A href='#' title='��������� ������ ���������' onclick=\"window.open('tools.php?event=mailto&email=$dt[3]&name=$dt[0]','email','width=520,height=300,left=170,top=100')\"><img src='$fskin/ico_pm.gif' border=0></A>";} else {$wfn="$dt[0]"; $mls="�������������";}

if (strlen($dt[13])=="6" and ctype_digit($dt[13])) $dt[13]="<B><font color=red>�������� ���������</font></B>";
if (strlen($dt[13])<2) $dt[13]=$users;
if ($dt[6]=="�������") $add="polm.gif"; else $add="polg.gif";

print"<tr>
<td class=$t1>$num</td>
<td class=$t1><b><img src='$fskin/$add' border=0> $wfn</b></td>
<td class=$t1 align=center>$dt[13]</td>
<td class=$t1 align=center>$mls</td>
<td class=$t1 align=center>$dt[4]</td>
<td class=$t1 align=center>$dt[5]</td>
<td class=$t1>$dt[10]</td>
<td class=$t1><small>$dt[8]</small></td>
<td class=$t1>$dt[9]</td></tr>";
if ($t1=="row1") $t1="row2"; else $t1="row1";

} // ���� ������� ����������

} while($fm < $lm);
} // if isset($lines)
} // ����� ���� ���� userdat.php ����

echo'</table><BR><table width=100%><TR><TD>��������:&nbsp; '; // ������� ������ ������� �����
if ($page>=4 and $maxpage>5) print "<a href=tools.php?event=who&page=1$fadd>1</a> ... ";
$f1=$page+2; $f2=$page-2;
if ($page==1) { $f1=$page+4; $f2=$page; }
if ($page==2) { $f1=$page+3; $f2=$page-1; }
if ($page==$maxpage) { $f1=$page; $f2=$page-4; }
if ($page==$maxpage-1) { $f1=$page+1; $f2=$page-3; }
if ($maxpage<4) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) { if ($page==$i) print "<B>$i</B> &nbsp;"; else print "<a href=tools.php?event=who&page=$i$fadd>$i</a> &nbsp;"; }
if ($page<=$maxpage-3 and $maxpage>5) print "... <a href=tools.php?event=who&page=$maxpage$fadd>$maxpage</a>";
print "</TD><TD align=right>����� ���������������� ���������� - <B>$ui</B></TD></TR></TABLE><BR>";}



if ($_GET['event'] =="profile")  { 
if (!isset($_GET['pname'])) exit("������� ������.");
$pname=urldecode($_GET['pname']); // ����������� ��� ������������, ��������� �� GET-�������.
$lines=file("$datadir/usersdat.php");
$i = count($lines); $use="0";
do {$i--; $rdt=explode("|", $lines[$i]);

if (isset($rdt[1])) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������

if (strlen($rdt[13])=="6" and ctype_digit($rdt[13])) $rdt[13]="<B><font color=red>�������� ���������</font></B>";

if ($pname===$rdt[0])  {

if (isset($wrfname) & isset($wrfpass))  { $wrfname=replacer($wrfname); $wrfpass=replacer($wrfpass);
if ($wrfname===$rdt[0] & $wrfpass===$rdt[1])  {
print "<center><span class=maintitle>��������������� ������</span><br>

<br><form action='tools.php?event=reregist' name=creator method=post enctype=multipart/form-data>

<table cellpadding=3 cellspacing=1 width=100% class=forumline>
<tr><th class=thHead colspan=2 height=25 valign=middle>��������������� ����������</th>
</tr><tr>
<td class=row2 colspan=2><span class=gensmall>���� ���������� * ����������� � ����������, ���� �� ������� ��������</span></td>
</tr><tr>
<td class=row1 width=35%><span class=gen>��� ���������: *</span><span class=gensmall><br>������� ���� ���������</span></td>
<td class=row2><span class=nav>$rdt[0]</span></td>
</tr><tr>
<td class=row1><span class=gen>��� ������: *</span></td>
<td class=row2>
<input class=inputmenu type=text value='�����' maxlength=10 name=newpassword size=15><input type=hidden class=inputmenu value='$rdt[1]' name=pass>
 (���� ������ �������, �� ������� ����� ������, ����� �������� ��� ����!)
</td>
</tr><tr>
<td class=row1><span class=gen>����� e-mail: *</span><br><span class=gensmall>������� ������������ ����������� �����! ����� ������� �� �������-��������.</span></td>
<td class=row2> <input type=text class=post style='width: 200px' value='$rdt[3]' name=email size=25 maxlength=50></td>
</tr><tr>
<td class=catSides colspan=2 height=28>&nbsp;</td>
</tr><tr>
<th class=thSides colspan=2 height=25 valign=middle>������� � ����</th>
</tr><tr>
<td class=row2 colspan=2><span class=gensmall>��� ���������� �������������</span></td>
</tr><tr>
<td class=row1><span class=gen>���� �����������:</span></td><td class=row2><span class=gen>$rdt[4]</td>
</tr><tr>
<td class=row1><span class=gen>��� ���:</span><br></td>
<td class=row2><span class=gen>$rdt[6]</span><input type=hidden value='$rdt[6]' name=pol></td>
</tr><tr>
<td class=row1><span class=gen>���� �������:</span><br><span class=gensmall>������� ���� �������� � �������: ��.��.�����, ���� �� ������.</span></td>
<td class=row2><input type=text name=dayx value='$rdt[5]' class=post style='width: 100px' size=10 maxlength=18></td>
</tr><tr>
<td class=row1><span class=gen>����� � ICQ:</span><br><span class=gensmall>������� ����� ICQ, ���� �� � ��� ����.</span></td>
<td class=row2><input type=text value='$rdt[7]' name=icq class=post style='width: 100px' size=10 maxlength=10></td>
</tr><tr>
<td class=row1><span class=gen>�������� ���������:</span><br><span class=gensmall>���� � ��� ���� �������� ��� ������� ��������� � ���������, ������� URL ���� ���������.</span></td>
<td class=row2><input type=text value='$rdt[8]' class=post style='width: 200px' name=www size=25 maxlength=70 value='http://' /></td>
</tr><tr>
<td class=row1><span class=gen>������:</span><br><span class=gensmall>������� ����� ���������� (������, �������, �����).</span></td>
<td class=row2><input type=text class=post style='width: 250px' value='$rdt[9]' name=about size=25 maxlength=70></td>
</tr><tr>
<td class=row1><span class=gen>��������:</span><br><span class=gensmall>�� ������ �������� � ����� ���������</span></td>
<td class=row2><input type=text class=post style='width: 300px' value='$rdt[10]' name=work size=35 maxlength=70></td>
</tr><tr>
<td class=row1><span class=gen>�������:</span><br><span class=gensmall>������� ���� �������, �� ����������� HTML</span></td>
<td class=row2><input type=text class=post style='width: 400px' value='$rdt[11]' name=write size=35 maxlength=70></td>
</tr><tr>
<td class=row1><span class=gen>������:</span><br><span class=gensmall>�������� ������� (��������), ������� ����� ������������ ����� � ����� ������.</span></td>
<td class=row2 height=120>";

$images=null; unset($images);
if (!is_file("avatars/$rdt[12]")) $rdt[12]="noavatar.gif";
$root = str_replace( '\\', '/', getcwd() ) . '/';
$dirtoopen = $root.'avatars';
if ( !($images = get_dir($dirtoopen,'*.{gif,png,jpeg,jpg}',GLOB_BRACE)) ) {
$images=array();
$handle=opendir($dirtoopen);
while ( false !== ($file = readdir($handle)) ) if (strstr($file,'.gif') || strstr($file,'.jpg')) $images[]=$file;
closedir($handle);
}
$selecthtml ="";
foreach ($images as $file) { if ($file == $rdt[12]) {$selecthtml .= '<option value="'.$file.'" selected>'.$file."</option>\n"; $currentface = $rdt[12];} else {$selecthtml .= '<option value="'.$file.'">'.$file."</option>\n";} }

print "<table><TR><TD>
<script language=javascript> function showimage()  { document.images.avatar.src='./avatars/'+document.creator.avatar.options[document.creator.avatar.selectedIndex].value; } </script>
<select name='avatar' size=6 onChange='showimage()'>
$selecthtml
</select>
</td><td><img src='./avatars/$currentface' name=avatar border=0 hspace=15></td></tr></table>
</td></tr>";

print "
<td class=row1><span class=gen>��������� ���� ������:</span><br><span class=gensmall>������� ��������� ���� � ������ �������. <BR>����������� ������������ ��������: <BR> - ���������� �� ����� <B>120 � 120</B>, <BR>- ����������� ������ <B>gif, png, jpg ��� jpeg</B>, <BR> - �������� ����� <B>$maxfsize ��</B>. </B></span></td>
<td class=row2><input type=file name=file class=post style='width: 400px' size=35 maxlength=150></td>
</tr><tr><tr><td colspan=2>
<input type=hidden name=name value='$rdt[0]'>
<input type=hidden name=oldpass value='$rdt[1]'>
</td></tr><tr>
<td class=catBottom colspan=2 align=center height=28><input type=submit name=submit value='��������� ���������' class=mainoption /></td>
</tr></table></form>"; $use="1"; }


if ($use!="1") {

$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1; $msgitogo=0;
for ($i=0;$i<=$ui;$i++) {$udt=explode("|",$ulines[$i]); $msgitogo=$msgitogo+$udt[2]; if ($udt[0]==$rdt[0]) {$msguser=$udt[2];}}
$msgaktiv=round(10000*$msguser/$msgitogo)/100;

$akt=explode(".",$rdt[4]);
$aktiv=mktime(0,0,0,$akt[1],$akt[0],$akt[2]); 
$tekdt=mktime(); $aktiv=round(($tekdt-$aktiv)/86400);
$aktiv=round(100*$msguser/$aktiv)/100;

if (strlen($rdt[13])<2) $rdt[13]=$users;
if (is_file("avatars/$rdt[12]")) $avpr="$rdt[12]"; else $avpr="noavatar.gif";

print "<center><span class=maintitle>������� ���������</span><br><br><table cellpadding=5 cellspacing=1 width=100% class=forumline>
<tr><th class=thHead colspan=2 height=25 valign=middle>��������������� ����������</th></tr>
<tr><td class=row1 width=30%><span class=gen>��� ���������:</span></td><td class=row2><span class=nav>$rdt[0]</span></td></tr>
<tr><td class=row1><span class=gen>��������� ������ ��������� ��  e-mail: </span><br></td><td class=row2><A href='#' onclick=\"window.open('tools.php?event=mailto&email=$rdt[3]&name=$rdt[0]','email','width=520,height=300,left=170,top=100')\"><img src='$fskin/ico_pm.gif' border=0></A></td></tr>
<tr><td class=row1><span class=gen>���� �����������:</span></td><td class=row2><span class=gen>$rdt[4]</span></td></tr>
<tr><td class=row1><span class=gen>����������:</span></td><td class=row2><span class=gen>����� ���������: $msguser [$msgaktiv% �� ������ ����� / $aktiv ��������� � �����]</span></td></tr>
<tr><td class=row1><span class=gen>������:</span></td><td class=row2><span class=gen>$rdt[13]</span></td></tr>
<tr><td class=row1><span class=gen>���:</span></td><td class=row2><span class=gen>$rdt[6]</span></td></tr>
<tr><td class=row1><span class=gen>���� �������:</span><br></td><td class=row2><span class=gen>$rdt[5]</span></td></tr>
<tr><td class=row1><span class=gen>����� � ICQ:</span><br></td><td class=row2><span class=gen>$rdt[7]</td></tr>
<tr><td class=row1><span class=gen>�������� ���������:</span></td><td class=row2><span class=gen><a href='$rdt[8]' target='_blank'>$rdt[8]</a></td></tr>
<tr><td class=row1><span class=gen>������</span> (<span class=gensmall>����� ����������, �����, ������.):</span></td><td class=row2><span class=gen>$rdt[9]</td></tr>
<tr><td class=row1><span class=gen>��������:</span></td><td class=row2><span class=gen>$rdt[10]</td></tr>
<tr><td class=row1><span class=gen>�������:</span></td><td class=row2><span class=gen>$rdt[11]</td></tr>
<tr><td class=row1><span class=gen>������:</span></td><td class=row2 height=120><img src='./avatars/$avpr' border=0 hspace=15></td></tr>
</td></tr></table><BR>"; $use="1";}

}
}
} // if
} while($i > "1");

if (!isset($wrfname)) exit("<BR><BR><font size=+1><center>������ ������������������ ��������� ������ ����� ������������� ������ �������!");

// �� ������ ����� ��� - ��� ����� ������
if ($use!="1") {
echo'<BR><BR><BR><BR><center><font size=-1><B>��������� ����������!</B><BR><BR> 
��������, �� �������� � ����� - <B>������� �� ������ �� ���������������.</B><BR><BR>
������ �����, <B>��� ������ �������������</B>.<BR><BR>
<B>������� �� �������</B> �������� ������ ����� �� <B><a href="index.php">���� ������</a></B>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>'; }
}






if ($_GET['event']=="reg") {
if (!isset($_POST['rules'])) {
echo'
<form action="tools.php?event=reg" method=post>
<center><span class=maintitle>������� � ������� �����������</span><br><br>
<table cellpadding=8 cellspacing=1 width=100% class=forumline><tr><th class=thHead height=25 valign=middle>������� ������ � �������</th></tr><tr>
<td class=row1><span class=gen>';
if (is_file("pravila.html")) include"pravila.html";
echo'</td></tr><tr><td class=row2><INPUT type=checkbox name=rules><B>� ����������� � ��������� � ���������, � �������� ��.</B></td></tr><tr>
<td class=catBottom align=center height=28><input type=submit value="���������� �����������" class=mainoption></td>
</tr></table>
</form>'; 
} else {

print"<center><span class=maintitle>����������� �� ������</span><br>
<br><form action='tools.php?event=reg2' method=post>

<table cellpadding=3 cellspacing=1 width=100% class=forumline><tr>
<th class=thHead colspan=2 height=25 valign=middle>��������������� ����������</th>
</tr><tr>
<td class=row1 width=35%><span class=gen>��� ���������:</span><span class=gensmall><br>��������� ������������ ������ �������, ��������� �����, ����� � ���� �������������</span></td>
<td class=row2><input type=text class=post style='width:200px' name=name size=25 maxlength=$maxname></td>
</tr><tr>
<td class=row1><span class=gen>��� ������:</span></td>
<td class=row2><input type=password class=post style='width:200px' name=pass size=25 maxlength=25></td>
</tr><tr>
<td class=row1><span class=gen>����� e-mail:</span><br><span class=gensmall>������� ������������ ����������� �����! �� ��� ����� ����� ���������� ��������� � ����� ���������.</span></td>
<td class=row2><input type=text class=post style='width: 200px' name=email size=25 maxlength=50></td>
</tr><tr>
<td class=row1><span class=gen>��� ���:</span><br></td>
<td class=row2><input type=radio name=pol value='�������'checked> �������&nbsp;&nbsp; <input type=radio name=pol value='�������'> �������</td>
</tr><tr>";


//-�-�-�-�-�-�-�-�-
if ($antispam!="0") {
// ����� ����������� �� ����� (��� ���������� - ����� �� ������)
if (array_key_exists("image", $_REQUEST)) { $num=$_REQUEST["image"];
for ($i=0; $i<10; $i++) {if (md5($i+$rand_key)==$num) {imgwr($st,$i); die();}} }

$xkey=""; mt_srand(time()+(double)microtime()*1000000);

echo'<td class=row1><span class=gen>�������� ���:</span><br></td><td class=row2>';
for ($i=0; $i<$max_key; $i++) {
$snum[$i]=mt_rand(0,9); $psnum=md5($snum[$i]+$rand_key);
$phpself=$_SERVER["PHP_SELF"];
echo "<img src=$phpself?image=$psnum border='0' alt=''>\n";
$xkey=$xkey.$snum[$i];
}
$xkey=md5("$xkey+$rand_key");

print" <input name='usernum' class=post type='text' maxlength=$max_key size=6> (������� �����, ��������� �� ��������)
<input name=xkey type=hidden value='$xkey'>";
} // if $antispam!="0"
//-�-�-�-�-�--�-�-�-�-�-�-�-�-�-


echo'</td></tr><tr>
<td class=row2 colspan=2><span class=gensmall>* ��� ���� ����������� � ����������<BR>
** ��� ������ ����� ����� ��������� �� ����� ����������� �����, ������� �� ����������</span></td>
</tr><tr>
<td class=catBottom colspan=2 align=center height=28><input type=submit value="����������" class=mainoption></td>
</tr></table></form>';
}
}



if ($_GET['event']=="find") { // �����
$minfindme="3"; //����������� ���-�� �������� � ����� ��� ������
print"<BR><form action='tools.php?event=go&find' method=POST>
<table class=forumline align=center width=700>
<tr><th class=thHead colspan=4 height=25>�����</th></tr>
<tr class=row2>
<td class=row1>������: <input type='text' style='width: 250px' class=post name=findme size=30></TD>
<TD class=row1>���: <select style='FONT-SIZE: 12px; WIDTH: 120px' name=ftype>
<option value='0'>&quot�&quot
<option value='1' selected>&quot���&quot
<option value='2'>��� ����� �������
</select></td>
<td class=row1><INPUT type=checkbox name=withregistr><B>� ������ ��������</B></TD>
<input type=hidden name=gdefinder value='1'>
</tr><tr class=row1>
<td class=row1 colspan=4 width=\"100%\">
���� ��������:<br><UL>
<LI><B>&quot�&quot</B> - ������ �������������� ��� �����;</LI><br>
<LI><B>&quot���&quot</B> - ���� ���� �� ���� �� ����;</LI><br>
<LI><B>&quot��� ����� �������&quot</B> - � ������� ��������� ����� ����� �� 100% ��������������� ������ �������;</LI><BR><BR>
<LI><B>&quot� ������ ��������&quot</B> - ����� ������ � ������ ��������� ���� ��������;</LI><BR><BR>
</UL>������ ���� ��� ������, ������� ���������� � ��������� ���� ������. ��������, ��� ������� &quot�����&quot ����� ������� ����� &quot�����&quot, &quot������&quot, &quot�������&quot � ������ ������.
</td>

</tr><tr><td class=row1 colspan=4 align=center height=28><input type=submit class=post value='  �����  '></td></form>
</tr></table><BR><BR>";
print "����������� �� �����: <BR> - ����������� ���-�� ��������: <B>$minfindme</B>";
}





if (isset($_GET['find']))  {
$minfindme="3"; //����������� ���-�� �������� � ����� ��� ������
$time=explode(' ', microtime()); $start_time=$time[1]+$time[0];  // ��������� ��������� ����� ������� ������

$gdefinder="1";

$ftype=$_POST['ftype']; 
if (!ctype_digit($ftype) or strlen($ftype)>2) exit("<B>$back. ������� ������. ������� ����� �� �����.</B>");
if (!isset($_POST['withregistr'])) $withregistr="0"; else $withregistr="1";

// ������ �� ������
$text=$_POST['findme'];
$text=replacer($text);
$findmeword=explode(" ",$text); // ��������� $findme �� �����
$wordsitogo=count($findmeword);
$findme=trim($text); // �������� ���������� ������� 
if ($findme == "" || strlen($findme) < $minfindme) exit("$back ��� ������ ����, ��� ����� $minfindme ��������!</B>");

// ��������� ���� � ������ ������� � ���������� ����� ������ � �����������

setlocale(LC_ALL,'ru_RU.CP1251'); // ! ��������� ������ �������, ���������� � ���������� � � �������� �������

// ������ ���� - ������� ���-�� ������� (���������� � ���������� $itogofid)
$mainlines = file("$datadir/mainforum.dat");$i=count($mainlines); $itogofid="0";$number="0"; $oldid="0"; $nump="0";
do {$i--; $dt=explode("|", $mainlines[$i]);

if ($dt[1]!="razdel") { $maxzd=$dt[12]; if (!ctype_digit($maxzd)) $maxzd=0; } // ��������� �¨��� ������� �� �����
if ($dt[1]!="razdel" and $maxzd<1) {$itogofid++; $fids[$itogofid]=$dt[0];} // $itogofid - ����� ���-�� �������
} while($i > "0");


do {
$fid=$fids[$itogofid];
// ������ ���� - ��������� ���� � ������� (���� �� ����������) � ��������� � ���������� $topicsid ��� ����� ���
if (is_file("$datadir/topic$fid.dat")) {
$msglines=file("$datadir/topic$fid.dat");

if (count($msglines)>0) {

$lines = file("$datadir/topic$fid.dat"); $i=count($lines);
do {$i--;  $dt = explode("|", $lines[$i]); $topicsid[$i]=$dt[7];} while($i > "0"); }


// ������ ���� - ��������������� ��������� ������ ����

if (isset($topicsid)) {

$ii=count($topicsid);
do {$ii--;
$id = str_replace("\r\n","",$topicsid[$ii]);

if (is_file("$datadir/$id.dat")) { // ���� ���� ����? ������, ��� ����� � ����������� ������, ����� ��� ��������� ��� ���������.
$file=file("$datadir/$id.dat"); $iii=count($file);

// ���¨���� ���� - ��������������� ���� � ������ ���� ������� ���������
if ($iii>0) { // ���� ���� � ����������� �� ������
do {$iii--; 
$lines = file("$datadir/$id.dat");
$dt = explode("|", $lines[$iii]); if (!isset($dt[4])) $dt[4]=" ";

if ($gdefinder=="0") {$msgmass=array($dt[2],$dt[3],$dt[4]); $gi="3"; $add="�� <B>�����, �����, ���������</B> ";}
if ($gdefinder=="1") {$msgmass=array($dt[4]); $gi="1"; $add="� <B>�����</B> ";}
if ($gdefinder=="2") {$msgmass=array($dt[3],$dt[4]); $gi="2"; $add="�� <B>����� � ���������</B> ";}
if ($gdefinder=="3") {$msgmass=array($dt[2]); $gi="1"; $add="� <B>�����</B> ";}
if ($gdefinder=="4") {$msgmass=array($dt[3]); $gi="1"; $add="� <B>���������</B> ";}

// ���� �� ������ ������ (0,1,2,3,4)
do {$gi--;

$msg=$dt[4];
$msdat=$msgmass[$gi];
$stroka="0"; $wi=$wordsitogo;
// ���� �� ������� ����� ������� !
do {$wi--;



// ���� ������� ������
if ($withregistr!="1") // ������������������� ����� - c����� "i" ����� ������������ ������������ ������� - /
   {
    if ($ftype=="2") 
        {
        if (stristr($msdat,$findme))     // ����� �� "���� ����� �������" ��� ����� ��������
            { 
             $stroka++;
             $msg=str_replace($findme," <b><u>$findme</u></b> ",$msg);
            }
        }
     else {
           $str1=strtolower($msdat);  
           $str2=strtolower($findmeword[$wi]); 
           if ($str2!="" and strlen($str2) >= $minfindme)
              {
               if (stristr($str1,$str2)) // ����� ��� ����� �������� ��� ������ ������ ��������
                  {
                   $stroka++;
                   $msg=str_replace($findmeword[$wi]," <b><u>$findmeword[$wi]</u></b> ",$msg);
                  }
              }
          }
        }

else  //  if ($withregistr!="1")
   {
    if ($ftype=="2")
       {
        if (strstr($msdat,$findme))           // ����� �� "���� ����� �������" C ����� ��������
           {
            $stroka++;
            $msg=str_replace($findme," <b><u>$findme</u></b> ",$msg);
           }
       }
     else {
           if ($msdat!="" and strlen($findmeword[$wi]) >= $minfindme)
              {
               if (strstr($msdat,$findmeword[$wi]))     // ����� � ������ �������� ��� ������ ������ ��������
                  {
                   $stroka++;
                   $msg=str_replace($findmeword[$wi]," <b><u>$findmeword[$wi]</u></b> ",$msg);
                  }
              }
          }

   }   //  if ($withregistr!="1")



} while($wi > "0");  // ����� ����� �� ������� ����� �������


// �������������� �������������� ���������, � ���� ��������� ������������� �������� - ������� ���
if ($ftype=="0") { if ($stroka==$wordsitogo) $printflag="1"; }
if ($ftype=="1") { if ($stroka>"0") $printflag="1"; }
if ($ftype=="2") { if ($stroka==$wordsitogo) $printflag="1"; }


if (!isset($printflag)) $printflag="0";
    if ($printflag=="1")
       { $msg=str_replace("<br>", " &nbsp;&nbsp;", $msg); // �������� � ��������� <br> �� ���� ��������


if (strlen($msg)>150)
{
 $ma=strpos($msg,"<b>"); if ($ma > 50) $ma=$ma-50; else $ma=0;
 $mb=strrpos($msg,">b/<"); if (($mb+50) > strlen($msg)) $mb=strlen($msg); else $mb=$mb+50;
 $msgtowrite="..."; $msgtowrite.=substr($msg,$ma,$mb); $msgtowrite.="...";
 $msgtowrite=substr($msg,0,400);
}
else $msgtowrite=$msg;




if (!isset($m)) {
print"
<small><BR>�� ������� '<U><B>$findme</B></U>' � ���$add �������: <HR size=+2 width=99% color=navy>
<BR><form action='tools.php?event=go&find' method=POST>
<table class=forumline align=center width=700>
<tr><th class=thHead colspan=4 height=25>��������� �����</th></tr>
<tr class=row2>
<td class=row1>������: <input type='text' value='$findme' style='width: 250px' class=post name=findme size=30>
<INPUT type=hidden value='1' name=ftype>
<input type=hidden name=gdefinder value='1'>
<input type=submit class=post value='  �����  '></td></table></form><br>
<table width=100% class=forumline><TR align=center class=small><TH class=thCornerL><B>�</B></TH><TH class=thCornerL width=35%><B>���������</B></TH><TH class=thCornerL width=70%><B>����� ���������</B></TH><TH class=thCornerL><B>����������<BR> � ����</B></TH></TR>"; $m="1"; }

if ($iii>$qq) {$in=$iii+2; $page=ceil($in/$qq);} else $page="1";  // ����������� ������ �������� � ����� ���������

if ($oldid!=$id and $number<50) { $number++; $msgnumber=$iii;

if ($nump>1) $anp="$nump"; else $anp="1";
if ($number>1) print"<TD class=row1 align=center>$anp</TD></TR><TR height=25>";

print "<TD class=row1 align=center><B>$number</B></TD>
<TD class=row1><A class=listlink href='index.php?fid=$fid&id=$id&page=$page#m$iii'>$dt[3]</A></TD>
<TD class=row1>$msgtowrite</TD>";
$printflag="0"; $nump="0";} else $nump++;
$oldid=$id;
} // if $printflag==1

} while($gi > "0");  // ����� ����� �� ����� ������

} while($iii > "0");
} // ���� ���� � ����������� ��������

} // if is_file("$datadir/$id.dat")
} while($ii > "0");

} // if isset($topicsid)

} // if ���� topic$fid.dat �� ����


$itogofid--;
} while($itogofid > "0");
if (!isset($m)) echo'<table width=80% align=center><TR><TD>�� ������ ������� ������ �� �������.</TD></TR></table>';

$time=explode(' ',microtime());
$seconds=($time[1]+$time[0]-$start_time);
echo "</TR></table><HR size=+2 width=99% color=navy><BR><p align=center><small>".str_replace("%1", sprintf("%01.3f", $seconds), "����� ������: <b>%1</b> ������.")."</small></p>";

}

} // if isset($_GET['event']) - ��, ��� �������� ��� ������� ���������� $event

echo'</td></tr></table>
<center><font size=-2><small>Powered by <a href="http://www.wr-script.ru" title="������ ������" class="copyright">WR-Forum</a> Professional &copy; 1.9.3 <a href="http://www.master-script.ru/scripty_forumov.html" class="copyright">MS</a><br></small></font></center>
</body>
</html>';


// ������� ������������ ��� ����������� ��������
function get_dir($path = './', $mask = '*.php', $mode = GLOB_NOSORT) {
 if ( version_compare( phpversion(), '4.3.0', '>=' ) ) {if ( chdir($path) ) {$temp = glob($mask,$mode); return $temp;}}
return false;}
?>
