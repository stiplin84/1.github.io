<? // WR-forum v 1.9.3  //  10.06.10 �.  //  Miha-ingener@yandex.ru

error_reporting (E_ALL); // �������� - �� ����� ������������ � ������� �������!
// error_reporting(0); // ��������������� ��� ���������� ������!!!
@ini_set('register_globals','off');// ��� ������� �������� ��� ���� ��������� php

include "config.php";

$stop=0; // ��������� ���������� ���������
$antimat=0; // �������� ������� ��/��� - 1/0
$repaaddfile=5; // ������� ����� ��������� ��������� ��� �������� �����?
$repaaddmsg=1; // ������� ����� ��������� ��������� �� ���������� ���������?
$repaaddtem=1; // ������� ����� ��������� ��������� �� ���������� ����?
$random_name=TRUE; // ��� �������� ����� ������������ ��� ��� ��������� �������?

$valid_types=array("zip","rar","7z","jpg","jpeg","bmp","gif","png");  // ���������� ���������� ����������� ������

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
// ���� magic_quotes �������� - ������ ����� ����� � ���� �������: ��������� (') � ������� ������� ("), �������� ���� (\)
if (get_magic_quotes_gpc()) { $text=str_replace("&#092;&quot;",'&quot;',$text); $text=str_replace("&#092;'",'\'',$text); $text=str_replace("&#092;&#092;",'&#092;',$text); }
$text=str_replace("\r\n","<br> ",$text);
$text=str_replace("\n\n",'<p> ',$text);
$text=str_replace("\n",'<br> ',$text);
$text=str_replace("\t",'',$text);
$text=str_replace("\r",'',$text);
$text=str_replace('   ',' ',$text);
return $text; }


// ������� �������� ����������� �����. ����������: addtop();
function addtop() { global $wrfname,$fskin,$date,$time;
// ���� ���� � ������� ���
if (isset($_COOKIE['wrfcookies'])) {$wrfc=$_COOKIE['wrfcookies']; $wrfc=replacer($wrfc); $wrfc=explode("|", $wrfc);  $wrfname=$wrfc[0];} else {unset($wrfname); unset($wrfpass); $wrfpass="";}
print"<TD align=right>";
if (isset($wrfname)) {print "<a href='tools.php?event=profile&pname=$wrfname' class=mainmenu><img src=\"$fskin/icon_mini_profile.gif\" border=0 hspace=3 />��� �������</a>&nbsp; <a href='index.php?event=clearcooke' class=mainmenu><img src=\"$fskin/ico-login.gif\" border=0 hspace=3 />����� [<B>$wrfname</B>]</a>";}
else {print "<span class=mainmenu>
<a href='tools.php?event=reg' class=mainmenu><img src=\"$fskin/icon_mini_register.gif\" border=0 hspace=3 />�����������</a>&nbsp;&nbsp;
<a href='tools.php?event=login' class=mainmenu> <img src=\"$fskin/buttons_spacer.gif\" border=0 hspace=3>����</a></td>";}
if (is_file("$fskin/tiptop.html")) include("$fskin/tiptop.html"); // ���������� ���������� � ��������
print"</span></td></tr></table></td></tr></table><a href=readme.html></a><a href=data/inst.php></a><span class=gensmall>�������: $date - $time";
return true;}


function prcmp ($a, $b) {if ($a==$b) return 0; if ($a<$b) return -1; return 1;} // ������� ����������


function nospam() { global $max_key,$rand_key; // ������� ��������
if (array_key_exists("image", $_REQUEST)) { $num=replacer($_REQUEST["image"]);
for ($i=0; $i<10; $i++) {if (md5("$i+$rand_key")==$num) {imgwr($st,$i); die();}} }
$xkey=""; mt_srand(time()+(double)microtime()*1000000);
$dopkod=mktime(0,0,0,date("m"),date("d"),date("Y")); // ���.���: �������� ������ 24 ����
$stime=md5("$dopkod+$rand_key");// ���.���
echo'�������� ���: ';
for ($i=0; $i<$max_key; $i++) {
$snum[$i]=mt_rand(0,9); $psnum=md5($snum[$i]+$rand_key+$dopkod);
echo "<img src=antispam.php?image=$psnum border='0' alt=''>\n";
$xkey=$xkey.$snum[$i];}
$xkey=md5("$xkey+$rand_key+$dopkod"); //����� + ���� �� config.php + ��� ���������� ����� 24 ����
print" <input name='usernum' class=post type='text' style='WIDTH: 70px;' maxlength=$max_key size=6> (������� �����, ��������� �� ��������)
<input name=xkey type=hidden value='$xkey'>
<input name=stime type=hidden value='$stime'>";
return; }



function addmsg($qm) { // ������� ���������� ����/���������
global $wrfname,$maxname,$canupfile,$antispam,$max_key,$rand_key,$max_upfile_size,$smile,$smiles,$valid_types;

print'<tr><td class=row1 width=14% height=25><span class=gen><b>���</b></span></td>
<td class=row2 width=76%><span class=genmed>';
if (!isset($wrfname)) print "<input type=text name=name class=post maxlength=$maxname size=28> E-mail <input type=text name=email class=post size=30>";
else {
if (isset($_COOKIE['wrfcookies'])) {$wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc); $wrfc=explode("|", $wrfc);  $wrfpass=replacer($wrfc[1]);} else {unset($wrfpass); $wrfpass="";}
print "<b>$wrfname</b><input type=hidden name=name value='$wrfname'><input type=hidden name=who value='��'><input type=hidden name=userpass value=\"$wrfpass\">";}

print "</span></td></tr>
<tr><td class=row1 valign=top><span class=genmed><b>���������</b><br><br>��� ������� �����, �������� �� ����� ����� � ���.<br><br>��������:<br>
<table align=center width=100 height=70><tr><td valign=top>";

if ($smile==TRUE) {$i=count($smiles)-1;
for($k=0; $k<$i; $k=$k+2) {$j=$k+1; print"<A href='javascript:%20x()' onclick=\"DoSmilie(' $smiles[$j]');\"><img src='smile/$smiles[$k].gif' border=0></a> ";} }
print"<A href='javascript:%20x()' onclick=\"DoSmilie('[RB]  [/RB] ');\"><font color=red><B>RB</b></font></a>
<a name='add' href='#add' onclick=\"window.open('tools.php?event=moresmiles','smiles','width=350,height=300,left=50,top=150,toolbar=0,status=0,border=0,scrollbars=1')\">��� ������</a>
</tr></td></table></span></td>
<td class=row2 valign=top><span class=gen><table width=450><tr valign=middle><td><span class=genmed>
<input type=button class=button value='B' style='font-weight:bold; width:30px' onclick=\"DoSmilie(' [b]  [/b] ');\">&nbsp;
<input type=button class=button value='RB' style='font-weight:bold; width:30px; color:red' onclick=\"DoSmilie('[RB] [/RB]');\">&nbsp;
<INPUT type=button class=button value='���������� ����������' style='width: 180px' onclick='REPLIER.msg.value += \"[Quote]\"+(window.getSelection?window.getSelection():document.selection.createRange().text)+\"[/Quote]\"'>&nbsp;
<input type=button class=button value=' ��� ' onclick=\"DoSmilie(' [Code]  [/Code] ');\">&nbsp;
<input type=button class=button value=' IMG ' style='font-weight:bold; color:navy' onclick=\"DoSmilie('[img][/img]');\">&nbsp;
</span></td></tr><tr>
<td colspan=9><span class=gen><textarea name=msg cols=95 rows=10 class=post>$qm</textarea></span></td>";

if ($canupfile==TRUE and isset($wrfname)) { $max=round($max_upfile_size/10.24)/100;
print "<tr><td class=row1 valign=top>���������� ";

foreach($valid_types as $v) print "<B>$v</B>, ";
print" ����������� ��������� ������: <B>$max ��.</B>
<input type=file name=file class=post size=70></td></tr></table></TD>";}

if ($antispam==TRUE and !isset($wrfname)) nospam(); // �������� !

echo'</tr></table></span></td></tr>
<tr><td class=row1 colspan=2 align=center height=28><input type=submit tabindex=5 class=mainoption value=" ��������� ">&nbsp;&nbsp;&nbsp;<input type=reset tabindex=6 class=mainoption value=" �������� "></td>
</tr></table></form>';

return;} // ����� �������-����� ���������� ����/������




// ������ ����� �� ������ - ������� ����
if(isset($_GET['event'])) {if ($_GET['event']=="clearcooke") {setcookie("wrfcookies","",time()); Header("Location: index.php"); exit;}}



// ���������� ���� ��� ������ - ��� 1
if(isset($_GET['event'])) {

if ($stop==TRUE) exit("�������� ���������� ��������� ��������������!");

if (($_GET['event']=="addtopic") or ($_GET['event']=="addanswer")) {
if (isset($_POST['name'])) $name=$_POST['name'];
$name=trim($name); // �������� ���������� ������� 
$zag=$_POST['zag']; $msg=$_POST['msg']; $fid=$_GET['fid'];
if (isset($_POST['who'])) $who=$_POST['who']; else $who="";
if (isset($_POST['email'])) $email=$_POST['email']; else $email="";
if (isset($_POST['page'])) $page=$_POST['page'];
if ($_GET['event']=="addanswer") $id=$_POST['id'];
if (isset($_POST['maxzd'])) $maxzd=$_POST['maxzd']; else $maxzd="0"; if ($maxzd==null) $maxzd="0";
if ((!ctype_digit($maxzd)) or (strlen($maxzd)>2)) exit("<B>$back. ������� ������ �� ������ ��� ������ � ����� ����������</B>");

// ������ �� ������ fid
if (!ctype_digit($fid) or strlen($fid)>3) exit("<B>$back. ������� ������ ����� ����� �������. ����� ������ ��������� ������ ����� � ���� ����� 4 ��������</B>");

//--�-�-�-�-�-�-�-�--�������� ����--
if ($antispam==TRUE and !isset($_COOKIE['wrfcookies'])) {
if (!isset($_POST['usernum']) or !isset($_POST['xkey']) or !isset($_POST['stime']) ) exit("������ �� ����� �� ���������!");
$usernum=replacer($_POST['usernum']); $xkey=replacer($_POST['xkey']); $stime=replacer($_POST['stime']);
$dopkod=mktime(0,0,0,date("m"),date("d"),date("Y")); // ���.���. �������� ������ 24 ����
$usertime=md5("$dopkod+$rand_key");// ���.���
$userkey=md5("$usernum+$rand_key+$dopkod");
if (($usertime!=$stime) or ($userkey!=$xkey)) exit("����� ��������� ���!");}

// �������� �� ���� �������� � ������� - ���� �������������
// �� ��� ������, ���� mainforum.dat - ����, ���������� ��������� �����

$realbase="1"; if (is_file("$datadir/mainforum.dat")) $mainlines=file("$datadir/mainforum.dat");
if (!isset($mainlines)) $datasize=0; else $datasize=sizeof($mainlines);
if ($datasize<=0) {if (is_file("$datadir/copy.dat")) {$realbase="0"; $mainlines=file("$datadir/copy.dat"); $datasize=sizeof($mainlines);}}
if ($datasize<=0) exit("$back. �������� � ����� ������, ���� ������ ���� - ���������� � ��������������");
$i=count($mainlines);

$realfid=null; $fotodetali=null;
do {$i--; $dt=explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$realfid=$i; if ($dt[1]=="razdel") exit("$back. ������ ����� ������ �� ����������");} // ����������� $realfid - � �/� ������
} while($i>0);

if (!isset($realfid)) exit("$back. ������ � ������� �������. ��� �� ���������� � ����");

$dt=explode("|",$mainlines[$realfid]);
if (is_file("$datadir/topic$fid.dat")) {$tlines=file("$datadir/topic$fid.dat"); $tc=count($tlines)-2; $i=$tc+2; $ok=null;
// ����� ����������� �� ������, ����� ����. ���� ���� - �������, ���� - ������ ���������� ��������� ���������!
if ($_GET['event']=="addanswer") {
do {$i--; $tdt=explode("|", $tlines[$i]);
if ($tdt[7]==$id) {$ok=1; if ($tdt[8]=="closed") exit("$back ���� ������� � ���������� ��������� ���������!"); }
} while($i>0);
if ($ok!=1) exit("$back ���� ������� � ���������� ��������� ���������!"); }

} else $tc="2";
if ($dt[11]>0) {if ($tc>=$dt[11]) exit("$back. ��������� ����������� �� ���-�� ���������� ��� � ������ �������! �� ����� <B>$dt[11]</B> ���!");}

// �������� ������/������ �����. ����� �� �����, ����� ����� ���

// ���� 1
$userpass=replacer($_POST['userpass']); // �������� � ������������ ������ ����� �� ������

$realname="";
if (isset($_COOKIE['wrfcookies'])) {
    $wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc);
    $wrfc=explode("|", $wrfc);  $wrfname=$wrfc[0]; $wrfpass=$wrfc[1];
} else {$who=null; $wrfname=null; $wrfpass=null;}

// ���� 2
if ($who!=null) { $who=0;
if ($wrfname!=null & $wrfpass!=null) {
$lines=file("$datadir/usersdat.php"); $i=count($lines);
do {$i--; $rdt=explode("|", $lines[$i]);
   if (isset($rdt[1])) { $realname=strtolower($rdt[0]);
   if (strtolower($wrfname)===$realname & $wrfpass===$rdt[1] & $userpass===$rdt[1]) {
   $name=$wrfname; $who="��"; $ok="$i";}}
} while($i > "1");

if (!isset($ok)) {setcookie("wrfcookies","",time()); exit("������ ��� ������ � ����! <font color=red><B>�� �� ������� �������� ���������, ���������� ������ ��� ��� �����.</B></font> ��� ����� � ������ �� ������� � ���� ������, ���������� ����� �� ����� �����. ���� ������ ����������� - ���������� � �������������� ������.");}
}}


print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>";

if ($_GET['event']=="addtopic" and $cangutema==FALSE and !isset($wrfname)) exit("<center>������������� �������� ������ ��������� ����!</center><BR><BR>");
if ($_GET['event']=="addanswer" and $cangumsg==FALSE and !isset($wrfname)) exit("<center>������������� �������� ������ �������� � �����!</center><BR><BR>");


if (isset($_FILES['file']['name'])) { // ���� ��������� ����
$fotoname=replacer($_FILES['file']['name']); if (strlen($fotoname)>3) { $fotosize=$_FILES['file']['size']; // ��� � ������ �����

//---- ������ �� ������ -----

// 1. ��������� ����������
$ext = strtolower(substr($fotoname, 1 + strrpos($fotoname, ".")));
if (!in_array($ext, $valid_types)) {echo "<B>���� �� ��������.</B> ��������� �������:<BR>
- ��������� �������� ������ ������ � ������ ������������: <B>";
$patern=""; foreach($valid_types as $v) print"$v, ";
print"</B><BR>
- �� ��������� ��������� ���� � ������� �����������;<BR>
- ������� ����� ����� ��� ������ ����������� ����;</B><BR>"; exit;}

// 2. ������� ���-�� ����� � ��������� - ���� ������� ����� - ��������!
$findtchka=substr_count($fotoname, "."); if ($findtchka>1) exit("����� ����������� � ����� ����� $findtchka ���(�). ��� ���������! <BR>\r\n");

// 2. ���� � ����� ���� .php, .html, .htm - ��������! 
$bago="��������, �� � ����� ����� <B>���������</B> ������������ .php, .html, .htm";
if (preg_match("/\.php/i",$fotoname)) exit("��������� <B>.php</B> �������. $bago");
if (preg_match("/\.html/i",$fotoname)) exit("��������� <B>.html</B> �������. $bago");
if (preg_match("/\.htm/i",$fotoname)) exit("��������� <B>.htm</B> �������. $bago");

// 3. �������� �� ������� ���� � ����� ����� � �������� ���������� ����� 
$patern=""; foreach($valid_types as $v) $patern.="$v|";
if (!preg_match("/^[a-z0-9\.\-_]+\.(".$patern.")+$/is",$fotoname)) exit("$fotoname - <br>��������� ������������ ������� ����� � ����� �����, � ����� ��������� ��������� ����� � ����������� �������� �� ��������!!");

// 4. ���������, ����� ���� ���� � ����� ������ ��� ���� �� �������
if (file_exists("$filedir/$fotoname")) exit("<br><br>$back. ���� � ����� ������ ��� ���������� �� �������! ���� �������� ��� �� ������, <br>���� �������� �������� - �������� �� ��������� �������� ��������� � ���� ��������!!");
// ����� ����� �� ����� �����

// 5. ������ �����
$fotoksize=round($fotosize/10.24)/100; // ������ ������������ ����� � ��.
$fotomax=round($max_upfile_size/10.24)/100; // ������������ ������ ����� � ��.
if ($fotoksize>$fotomax) exit("�� ��������� ���������� ������ �����! <BR><B>����������� ����������</B> ������: <B>$fotomax </B>��.<BR> <B>�� ���������</B> ��������� ���� ��������: <B>$fotoksize</B> ��!");

// ���� ������� ������� ���������� ����� ���������� ����� ��� �������� - ���������� ��������� ���
if ($random_name==TRUE) {do $key=mt_rand(100000,999999); while (file_exists("$filedir/$key.$ext")); $fotoname="$key.$ext";}

if (copy($_FILES['file']['tmp_name'], $filedir."/".$fotoname)) {print "<br><br>���� ������� ��������: $fotoname (������: $fotosize ����)"; $fotodetali="1|$fotoname|$fotosize|";}
else echo "������ �������� ����� - $fotoname...\n"; }}

$tektime=time();
$name=wordwrap($name,30,' ',1); // ��������� ������� ������
$zag=wordwrap($zag,50,' ',1);
$name=str_replace("|","I",$name);
$who=str_replace("|","&#124;",$who);
$email=str_replace("|","&#124;",$email);
$zag=str_replace("|","&#124;",$zag);
$msg=str_replace("|","&#124;",$msg);

$smname=$name; if (strlen($name)>18) {$smname=substr($name,0,18); $smname.="..";}
$smzag=$zag; if (strlen($zag)>24) {$smzag=substr($zag,0,24); $smzag.="..";}

// ���������� ��� ����� � �����
if ($_GET['event']=="addtopic") { if ($fid<10) $add="0"; else $add="";
do $id=mt_rand(1000,9999); while (file_exists("$datadir/$add$fid$id.dat"));
$id="$add$fid$id"; }

if ((!ctype_digit($id)) or (strlen($id)>15)) exit("<B>$back. ����� ���� ������ ���� ������. ����������� ������ ������� ��� ������� ������</B>");
if (strlen(ltrim($zag))<3) exit("$back ! ������ � ����� ������ ���������!");

$text="$name|$who|$email|$zag|$msg|$date|$time|$id||$tektime|$smname|$smzag|$fotodetali|||||";
$text=replacer($text); $exd=explode("|",$text); 
$name=$exd[0]; $zag=$exd[3]; $smname=$exd[10]; $smzag=$exd[11]; $smmsg=$exd[4];

if (!isset($name) || strlen($name) > $maxname || strlen($name) <1) exit("$back ���� <B>��� ������, ��� ��������� $maxname</B> ��������!</B></center>");
if (preg_match("/[^(\\w)|(\\x7F-\\xFF)|(\\-)]/",$name)) exit("$back ���� ��� �������� ����������� �������. ��������� ������� � ���������� �����, �����, ������������� � ����.");
if (strlen(ltrim($zag))<3 || strlen($zag) > $maxzag) exit("$back ������� �������� �������� ���� ��� <B>�������� ��������� $maxzag</B> ��������!</B></center>");
if (strlen(ltrim($msg))<2 || strlen($msg) > $maxmsg) exit("$back ���� <B>��������� �������� ��� ��������� $maxmsg</B> ��������.</B></center>");
if (!preg_match('/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$/si',$email) and strlen($email)>30 and $email!="") exit("$back � ������� ���������� E-mail �����!</B></center>");

// ������� �������� ����� - ��������� ���������� ���������/���� ���������!
if (isset($tlines)) {
if ($tc<"-1") {$sdt[0]=null; $sdt[3]=null;} else {$last=$tlines[$tc+1]; $sdt=explode("|",$last);}

if ($_GET['event'] =="addtopic")  { // ���� ���������� ����: ��� = ��� � �����, ���� = ��������� ���� � �����
if ($name==$sdt[0] and $exd[3]==$sdt[3]) exit("$back. ����� ���� ��� �������. ������� �� ������ ���������!");

} else { // ���� ���������� ���������: ��� = ��� � �����, ��������� = ���������� ��������� � �����
if (is_file("$datadir/$id.dat")) {$linesn=file("$datadir/$id.dat"); $in=count($linesn)-1;
if ($in > 0) { $dtf=explode("|",$linesn[$in]);
if ($name==$dtf[0] and $exd[4]==$dtf[4]) exit("$back. ����� ��������� ��� ��������� � ������ ����. ������� �� ������ ���������!");}
}
}} // if $event=="addtopic"


// ���� ������� ������� ��, �� ������ ���� �������� ����� � ���� ����� ������ �����
if ($_GET['event'] =="addanswer")  { //��� ������ � ����

// ���������, ����� �� �������������� ����
$timetek=time(); $timefile=filemtime("$datadir/$id.dat"); 
$timer=$timetek-$timefile; // ������ ������� ������ ������� (� ��������) 
// $timer<10 - 10 ������ ������ �� ���������
if ($smmsg=="��!") {
if ($timer<10 and $timer>0) exit("$back ���� ���� ������� ����� $timer ������ �����. ��������� ����-����.");
touch("$datadir/$id.dat");
print "<script language='Javascript'>function reload() {location = \"index.php?fid=$fid&id=$id&page=$page#m$in\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$name</B>, ���� ��������������.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� � ������� ���� <BR><B>$zag</B>.<BR><BR>
<B><a href='index.php?fid=$fid&id=$id&page=$page#m$in'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit; }

if ($timer<10 and $timer>0) exit("$back ���� ���� ������� ����� $timer ������ �����.");
}


$razdelname="";
if ($realbase==TRUE and $maxzd<1) { // ���� ���������� ������� ����, � �� �����
$lines=file("$datadir/mainforum.dat"); $max=sizeof($lines)-1;
$dt=explode("|", $lines[$realfid]); $dt[5]++;
if ($_GET['event']=="addtopic") $dt[4]++;
$txtdat="$dt[0]|$dt[1]|$dt[2]|$id|$dt[4]|$dt[5]|$smname|$date|$time|$tektime|$smzag|$dt[11]|$dt[12]||||";
$razdelname=$dt[1];
// ������ ������ �� ������� ��������
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//������� ���������� �����
for ($i=0;$i<=$max;$i++) {if ($i==$realfid) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]);}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
} // if ($realbase==TRUE)

if ($newmess==TRUE and $maxzd<1) { // ������ � ��������� ���� ������ ���������
if (is_file("$datadir/topic$fid.dat")) $nlines=count(file("$datadir/topic$fid.dat")); else $nlines=1;

if (is_file("$datadir/$id.dat")) $nlines2=count(file("$datadir/$id.dat"))+1; else $nlines2=1;

$newmessfile="$datadir/news.dat";
$newlines=file("$newmessfile"); $ni=count($newlines)-1; $i2=0; $newlineexit="";
$ntext="$fid|$id|$date|$time|$smname|$zag|$msg|$nlines|$nlines2|$razdelname|$who||||";
$ntext=str_replace("
", "<br>", $ntext);

// ���� ���������, ���� �� ��� ����� ��������� � ���� ����. ���� ���� - ���������. �� ������ - ������ ��� ���� ������.
for ($i=0;$i<=$ni;$i++) { $ndt=explode("|",$newlines[$i]);
if (isset($ndt[1])) {if ($id!=$ndt[1]) {$newlineexit.="$newlines[$i]"; $i2++;}} }

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
fclose($fp);}

$file=file($newmessfile);$i=count($file);
if ($i>="15") {
$fp=fopen($newmessfile,"w");
flock ($fp,LOCK_EX);
unset($file[0]);
fputs($fp, implode("",$file));
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);}
}
}
} // if ($newmess==TRUE)


// ���� ��������� +1 � ���� � +1 � ��������� ��� +1 � ���-�� ���, ��������� ������

if (isset($_COOKIE['wrfcookies']) and (isset($ok))) {
$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1; $ulinenew=""; $fileadd=0;
// ���� ���� ��������� ���� - �� ��� ��� +5 � ����
if (isset($_FILES['file']['name']) and $repaaddfile!=FALSE) {if (strlen($_FILES['file']['name'])>1) $fileadd=$repaaddfile;}

// ���� ����� �� ����� � ����� userstat.dat
for ($i=0;$i<=$ui;$i++) {$udt=explode("|",$ulines[$i]);
if ($udt[0]==$wrfname) {
$udt[3]=$udt[3]+$repaaddmsg+$fileadd;
$udt[2]=$udt[2]+$repaaddtem; if ($_GET['event']=="addtopic") $udt[1]++;
$ulines[$i]="$udt[0]|$udt[1]|$udt[2]|$udt[3]|$udt[4]|$udt[5]||||\r\n";}
$ulinenew.="$ulines[$i]";}
// ����� ������ � ����
$fp=fopen("$ufile","w");
flock ($fp,LOCK_EX);
fputs($fp,"$ulinenew");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp); }



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

print "<script language='Javascript'>function reload() {location = \"index.php?fid=$fid&id=$id\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$name</B>, �� ���������� ����!<BR><BR>����� ��������� ������ �� ������ ������������� ���������� � ��������� ����.<BR><BR>
<B><a href='index.php?fid=$fid&id=$id'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit; }



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

print "<script language='Javascript'>function reload() {location = \"index.php?fid=$fid&id=$id&page=$page#m$in\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
�������, <B>$name</B>, ��� ����� ������� ��������.<BR><BR>����� ��������� ������ �� ������ ������������� ���������� � ������� ���� <BR><B>$zag</B>.<BR><BR>
<B><a href='index.php?fid=$fid&id=$id&page=$page#m$in'>������� �����, ���� �� ������ ������ �����</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;
}
}




//--------------- ����� ��� ���� ������� ������ ------------//
// ���������� ���� ���������� ������. +5 ����� ����������� //

if (isset($_COOKIE['wrfcookies'])) {
$wrfc=$_COOKIE['wrfcookies']; $wrfc=explode("|",replacer($wrfc));
$wrfname=$wrfc[0];$wrfpass=$wrfc[1];$wrftime1=$wrfc[2];$wrftime2=$wrfc[3];
if (time()>($wrftime1+240)) {
$tektime=time(); $wrfcookies="$wrfc[0]|$wrfc[1]|$tektime|$wrftime1|";
setcookie("wrfcookies", $wrfcookies, time()+1728000);
$wrfc=$_COOKIE['wrfcookies']; $wrfc=explode("|",replacer($wrfc));
$wrfname=$wrfc[0];$wrfpass=$wrfc[1];$wrftime1=$wrfc[2];$wrftime2=$wrfc[3];
} }
// ------------





if (!isset($_GET['event']))  {

if (is_file("$datadir/mainforum.dat")) $mainlines=file("$datadir/mainforum.dat");
if (!isset($mainlines)) $datasize=0; else $datasize=sizeof($mainlines);
if ($datasize<=0) {if (is_file("$datadir/copy.dat")) {$mainlines=file("$datadir/copy.dat"); $datasize=sizeof($mainlines);}}
if ($datasize<=0) exit("<center><b>���� ������ ������������! ������� � <a href='admin.php'>�������</a> � �������� �������!</b>");

// ���� ������� � ��������� ������: ���� -> ������ -> �����
$raz=""; $frname="";$rfid="";
if (isset($_GET['fid']) or isset($_GET['razdel'])) {
if (isset($_GET['fid'])) $fid=$_GET['fid']; else $fid=$_GET['razdel'];
if (!ctype_digit($fid) or strlen($fid)>3) exit("<B>$back. ������ ���� ������ ��������� �����, �� ���-�� ����� 4 ��������</B>");
$imax=count($mainlines); if (($fid>999) or (strlen($fid)==0)) exit(" <b>������������ ���-�� �������� - 999. ������ ������ ����� ��� �� ����������.</b>");
$i=count($mainlines);
// �������� �� ���� �������� � ������� - ���� �������������

do {$i--; $dt=explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$rfid=$i; 
if (isset($_GET['razdel'])) {$raz="$dt[2]"; $frname="$dt[2]";} else {$raz="$dt[1]"; $frname="$dt[1]";}
if (isset($dt[11])) { if($dt[11]>0) $maxtem=$dt[11]; else $maxtem="999";}}
} while($i >0);

if (isset($_GET['id'])) { $id=$_GET['id'];
if (!ctype_digit($id) or strlen($id)>15) exit("<B>$back. ���� ���� ������ ��������� ����� 15 ����!</B>");
if (is_file("$datadir/$id.dat")) { $lines=file("$datadir/$id.dat");
  if (count($lines)>4) {$dtt=explode("|",$lines[0]); $frtname=$dtt[3];} else $frtname="";
 $ft=$frname; $frname="-> $ft ->";} else {$frtname=""; $frname="";}} else {$frtname="";  $frname.="->";} } else {$frname=""; $frtname="";}
 
include("$fskin/top.html");  addtop();  // ���������� ����� ������






// ������� ������� �������� ������

if (is_file("$datadir/usersdat.php")) { // ��������� ��� ���������� ���������������������
$userlines=file("$datadir/usersdat.php"); $dayx="";
$usercount=count($userlines); $ui=$usercount-1; $uu=$ui;
$tdt=explode("|", $userlines[$ui]);}  else { $fp=fopen("$datadir/usersdat.php","a+"); fputs($fp,"<?die;?>\r\n"); fflush ($fp); fclose($fp); $ui=""; $tdt[0]="";}
$today=mktime();

if (!isset($_GET['fid']))  {
echo ('<table><tr><td><span class=nav>&nbsp;&nbsp;&nbsp;<a href=index.php class=nav>'.$fname.'</a> ->'.$raz.' </span></td></tr></table>
<table width=100% cellpadding=2 cellspacing=1 class=forumline>
<tr>
<th width=62% colspan=2 class=thCornerL height=25>������</th>
<th width=7% class=thTop>���</th>
<th width=7% class=thCornerR>�������</th>
<th width=28% class=thCornerR nowrap=nowrap>����������</th>
</tr>');

// ������� ��� ������� �� �������
$adminmsg=""; if (is_file("$datadir/mainforum.dat")) $lines=file("$datadir/mainforum.dat");
if (!isset($lines)) $datasize=0; else $datasize=sizeof($lines);
if ($datasize<=0) {if (is_file("$datadir/copy.dat")) {$lines=file("$datadir/copy.dat"); $datasize=sizeof($lines);} $adminmsg="<font color=red><B>�������������, ��������!!!</B> ���� �� � ��������� ��������. ������������ ��� �� ��������� ����� � �������!</font><br>";}
if ($datasize<=0) exit("�������� � ����� ������ - ���������� � ��������������");
$i=count($lines); $n="0"; $a1=$rfid-1; $u=$i-1; $fid="0"; $itogotem="0"; $itogomsg="0"; $alt=""; $konec="";

do {$a1++; $dt=explode("|", $lines[$a1]);

if (isset($dt[1])) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������

if ($dt[1]=="razdel" and isset($_GET['razdel'])) $konec++;  else {

// ���������� ���: ����� ��� ���������
if ($dt[1]=="razdel") {print "<tr height=28><td class=catLeft colspan=2><span class=cattitle><center><a href='index.php?razdel=$dt[0]'>$dt[2]</a></td><td class=rowpic colspan=4 align=right>&nbsp;</td></tr>";}
else {
//$dt[9] - ���� ���������� ���������; $wrftime2 - ��������� ���������
// ���� $dt[9] ������ (�.�. ������) $wrftime2 ������ ������ ������ - �����
$foldicon="folder.gif"; if (isset($wrfname)) {if (isset($dt[9])) {if ($dt[9]>$wrftime2) $foldicon="foldernew.gif";}}


if (is_file("$datadir/$dt[3].dat")) { $msgsize=sizeof(file("$datadir/$dt[3].dat")); // ������� ���-�� ������� � �����
if ($msgsize>$qq) $page=ceil($msgsize/$qq); else $page=1;} else $page=1;

if ($dt[7]==$date) $dt[7]="�������";
$maxzvezd=null; if (isset($dt[12])) { if ($dt[12]>=1) {$maxzvezd="*�������� ����������, ������� <font color=red><B>$dt[12]</B> �����";
$dt[4]=""; $dt[5]="";
if ($dt[12]==1) $maxzvezd.="�";
if ($dt[12]==2 or $dt[12]==3 or $dt[12]==4) $maxzvezd.="�";
$maxzvezd.=" �������</font>";}}
$fid="$dt[0]"; 

// �����: ���� ���� ����� ���� main-FID.gif, ��� FID - �����, �� ������ ������� ���������������, ������ ���� ����
if (is_file("$fskin/main-$fid.gif")) {$foldicon="main-$fid.gif"; $alt="$dt[1]";} else $alt="";

$dt[8]=substr($dt[8],0,-3);
$dt[10]=replacer($dt[10]);
print "<tr align=center valign=middle height=50>
<td width=3% class=row1><img src=\"$fskin/$foldicon\" alt='$alt' border=0></td>
<td width=60% class=row1 align=left><span class=forumlink><a href=\"index.php?fid=$fid\">$dt[1]</a> $maxzvezd<BR></span><small>$dt[2]</small></td>
<td class=row2><small>$dt[4]</small></td>
<td class=row2><small>$dt[5]</small></td>
<td class=row2 align=left><span class=gensmall>����: "; if (strlen($dt[10])>0) print "<a href=\"index.php?fid=$fid&id=$dt[3]&page=$page#m$msgsize\" title='$dt[10]'>$dt[10]</a>"; print"<BR>�����: <B>$dt[6]</B><BR>����: <B>$dt[7]</B> - $dt[8]</span></td></tr>\r\r\n";
$itogotem=$itogotem+$dt[4];$itogomsg=$itogomsg+$dt[5]; }}  if ($konec==2) $a1=$u;
} // if isset($dt[1]
} while($a1 < $u);
echo('</table><BR>');


// ������� ������� � ����
echo '<table width=100% cellpadding=3 cellspacing=1 class=forumline><TR><TD class=catHead><span class=cattitle>���������</span></td></tr>
<tr><td class=row1 align=right><span class=gensmall>
������� ������� �� �������� &nbsp; <select onchange="window.location=(\'index.php?fid=\'+this.options[this.selectedIndex].value)">
<option>�������� �������</option>';
$ii=count($mainlines); $cn=0; $i=0;
do {$dt=explode("|", $mainlines[$i]);
if ($dt[1]=="razdel") {if ($cn!=0) {echo'</optgroup>'; $cn=0;} $cn++; print"<optgroup label='$dt[2]'>";} else {print" <option value='$dt[0]'>|-$dt[1]</option>";}
$i++;} while($i<$ii);
echo'</optgroup></select></TD></TR></TABLE><br>';



if ($statistika==TRUE and !isset($_GET['razdel'])) { // ���������� ����� ���/���������/����� ������

if ($cangutema==TRUE) $c1="���������"; else $c1="���������";
if ($cangumsg ==TRUE) $c2="���������"; else $c2="���������";
$codename=urlencode($tdt[0]);
print"<table width=100% cellpadding=3 cellspacing=1 class=forumline><tr><td class=catHead colspan=2 height=28><span class=cattitle>����������</span></td></tr><tr>
<td class=row1 align=center valign=middle rowspan=2><img src=\"$fskin/whosonline.gif\"></td>
<td class=row1 align=left width=95%><span class=gensmall>
���������: <b>$itogomsg</b><br>���: <b>$itogotem</b><br>����� ���������������� ����������: <b>";
if (!isset($wrfname)) print"$ui"; else print"<a href=\"tools.php?event=who\">$ui</a>";
print"</b><br>��������� �����������������: <B>";
if (!isset($wrfname)) print"$tdt[0]"; else print"<a href=\"tools.php?event=profile&pname=$codename\">$tdt[0]</a>"; 
print"</B><BR> ������ <B>$c1</B> ��������� ���� � <B>$c2</B> �������� � �����<BR>
$adminmsg
</span></td></tr></table>"; 


// ���������� -=��� ��������=-

if (is_file("$datadir/usersdat.php")) { // ��������� ���� ������, ���� ��� �������
$userlines=file("$datadir/usersdat.php");
$usercount=count($userlines); $ui=$usercount-1; $t_people=""; $z_people=""; $s_people=""; $p_people=""; $s_p="0";
do {$udt=explode("|",$userlines[$ui]);
if (isset($udt[1])) {
$udt[5]=substr("$udt[5]",0, 10); // �������� ���� �������� �� �������
if (preg_match("(\d{2}\.\d{2}\.\d{4})",$udt[5])) { // ������������� ������� ��.��.����
$bday=substr("$udt[5]",0,-5);
$dmtoday=date("d.m");
$todaydt=explode(".",$dmtoday);
$codename=urlencode($udt[0]);
// �������� ��� �����������
if ($bday==$dmtoday) $t_people.="<a href='tools.php?event=profile&pname=$codename'>$udt[0]</a>,&nbsp;&nbsp; ";
$dt=explode(".",$udt[5]);
if ($dt[1]==12) $year=1972; else $year=1973; // ��� ����, ����� ����� ������� � ������� �� ������
$newdate=mktime(0,0,0,$dt[1],$dt[0],$year); // ��� ��� ��������
$tekdt=mktime(0,0,0,$todaydt[1],$todaydt[0],$year); // ������� ���� ��������� � ���� ������
$deystodate=round(($newdate-$tekdt)/86400); // ����� ������� ���� �������� �������
// �������� ��� ���������
if ($deystodate=="-1") $z_people.="<a href='tools.php?event=profile&pname=$codename'>$udt[0]</a>,&nbsp; ";
// �������� �������������� � ������ (������ 1 � ������ 7 ����)
if ($deystodate>1 and $deystodate<7) {if ($deystodate<10) $deystodate="0$deystodate"; $s_peo[$s_p]="$deystodate|$udt[0]|"; $s_p++;}
} // if ������ ���� ������� � ���������� $udt[5]
} // if iiset($udt[1])
$ui--; } while ($ui>0);

if (isset($s_peo)) {
usort($s_peo,"prcmp"); // ��������� ��� �� �����������
$i=0; do {$sdt=explode("|",$s_peo[$i]);
$sdt[0]=intval($sdt[0]); // ����������� ������ � �����, ����� ��������� 0 � ������
$codename=urlencode($sdt[1]);
$s_people.="<b><a href='tools.php?event=profile&pname=$codename'>$sdt[1]</a></b> ($sdt[0] ��.), "; $i++;
} while ($i<$s_p); }

// �� ��� ������, ���� ���� �������� ���, ������ ��������
if (strlen($z_people)>1) $z_people="<span class=gensmall><br>�����:<B>$z_people</B><font color=#800040> ����������� � ��� �������!</font><br>";
if (strlen($t_people)>1) $t_people="<span class=gensmall><br>�������: <B>$t_people</B><font color=red>�������� ����������!</font><br>";
if (strlen($s_people)>1) $s_people="<span class=gensmall><br>�����: $s_people <font color=#55002B>������ ����� ���� �������!</font><br>";

if (strlen($z_people)>1 or strlen($t_people)>1 or strlen($s_people)>1){
print"<br><table width=100% cellpadding=3 cellspacing=1 class=forumline>
<tr><td class=catHead colspan=2 height=28><span class=cattitle>��� ��������</span></td></tr><tr>
<td class=row1 align=center valign=middle rowspan=2><img src=\"$fskin/whosonline.gif\"></td>
<td class=row1 align=left width=95%>
$z_people $t_people $s_people<br>
</span></td></tr></table>";}
} // ����� ����� ��� ��������




// ���������� -= ��������� ��������� � ������ =-

if (is_file("$datadir/news.dat")) { $newmessfile="$datadir/news.dat";
$lines=file($newmessfile); $i=count($lines); //if ($i>10) $i=10; (������������� - ��� ��� ����!!! ;-))
if ($i>1) {
echo('<br><table width=100% cellpadding=3 cellspacing=1 class=forumline>
<tr><td class=catHead colspan=2 height=28><span class=cattitle>��������� ���������</span></td></tr><tr>
<td class=row1 align=center valign=middle rowspan=2><img src="'.$fskin.'/whosonline.gif"></td>
<td class=row1 align=left width=95%><span class=gensmall>');

$a1=$i-1;$u="-1"; // ������� ������ �� ����������� ��� ��������
do {$dt=explode("|",$lines[$a1]); $a1--;

if (isset($dt[1])) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������
$msg=htmlspecialchars($dt[6]);
$msg=str_replace("[b] "," ",$msg);
$msg=str_replace("[/b]"," ",$msg);
$msg=str_replace("[RB] "," ",$msg);
$msg=str_replace("[/RB]"," ",$msg);
$msg=str_replace("[Code] "," ",$msg);
$msg=str_replace("[/Code]"," ",$msg);
$msg=str_replace("[Quote] "," ",$msg);
$msg=str_replace("[/Quote]"," ",$msg);
$msg=str_replace("<br>","\r\n", $msg);
$msg=str_replace("&lt;br&gt;&lt;br&gt;","\r\n", $msg);
$dt[2]=str_replace(".201",".1", $dt[2]);
$dt[2]=substr($dt[2],0,8);
$dt[3]=substr($dt[3],0,5);
if ($dt[8]>$qq) $page=ceil($dt[8]/$qq); else $page=1; // ������� ��������

if ($dt[10]=="��") {$codename=urlencode($dt[4]); if (!isset($wrfname)) $name="$dt[4]"; else $name="<B><a href='tools.php?event=profile&pname=$codename'>$dt[4]</a></B>";} else {$name="����� $dt[4]";}
print"$dt[2] - $dt[3]: <B><a href='index.php?fid=$dt[0]'>$dt[9]</a></B> -> <B><a href='index.php?fid=$dt[0]&id=$dt[1]&page=$page#m$dt[8]' title='$msg \r\n\r\n ���������� $dt[3], $dt[2] �.'>$dt[5]</a></B> - $name.<br>";
} // ���� ������� ����������
$a11=$u; $u11=$a1;
} while($a11 < $u11);
echo'</span></td></tr></table>';}

} // ����� ����� ��������� ���������

} // ����� if (statistika==TRUE)

if (is_file("$fskin/bottom.html")) include("$fskin/bottom.html");  // ���������� ������ ���� ������

} // ����� ������� ��������








// �������� � ������ ��������� �������
if (isset($_GET['fid']) and !isset($_GET['id'])) {  $fid=$_GET['fid'];

// ������
if (!ctype_digit($fid) or strlen($fid)>3) exit("<B>$back. ����� ������� ������ ���� �������� � ��������� ����� 4 ��������</B>");
$imax=count($mainlines); if (($fid>99) or (strlen($fid)==0)) exit("<b>������ ������ ����� ��� �� ����������.</b>");

// ��������� ������ ������ �������������� ��������
if (!isset($_GET['page'])) $page=1; else {$page=$_GET['page']; if (!ctype_digit($page)) $page=1; if ($page<1) $page=1;}

if ($raz!="razdel") {

// �������� ������ �� ���-�� �¨�� �����. ���� ������ ���������� N � ���� ������� - �� ����������!
$maxzd=null;
do {$imax--; $ddt=explode("|", $mainlines[$imax]); if ($ddt[0]==$fid) $maxzd=$ddt[12]; } while($imax>"0");
if ($maxzd>=1) {
if (!ctype_digit($maxzd)) exit("$back ����� ����������� � ������. � � ����� ������ - ������!");

$noacsess="<br><br><br><br><table class=forumline align=center width=700><tr><th class=thHead colspan=4 height=25>������ � ������ ���������</th></tr>
<tr class=row2><td class=row1><center><BR><BR><B><span style='FONT-SIZE: 14px'>��� ��������� ������� ������� ���������� ���� ������������������ � ����� ������� �� ����� $maxzd ����.";

// ���� ��������� ����� � ������ �����, ��������� ���-�� ��� ���� � ���������� � �������� � �������
if (isset($_COOKIE['wrfcookies'])) { // ���� ���� �������� ��� ������� ����
$text=$_COOKIE['wrfcookies']; 
$text=replacer($text);
$wrfc=explode("|",$text); $wrfname=$wrfc[0]; if (isset($wrfc[1])) $wrfpass=$wrfc[1]; else exit("$back ������� ������ - � ���� ��� ������. ���� �� ����� ;-) ?");

// ��������� ���� � �������
$iu=$usercount; $ok=null;
do {$iu--; $du=explode("|",$userlines[$iu]);
if (isset($du[1])) { $realname=strtolower($du[0]);
if (strtolower($wrfname)===$realname & $wrfpass===$du[1]) {$ok="$i"; if ($du[2]<$maxzd) exit("$noacsess � ��� ����� $du[2] ����.</B></center><BR><BR>$back<BR><BR></td></table><br>"); }}
} while($iu > "0");
} else exit("$noacsess</B></center><BR><BR>$back<BR><BR></td></table><br>"); // ���� ���� ���, �� ���� ���� ����� �� ��� �������, ����� - ��������
if (!isset($ok)) exit("$noacsess</B></center><BR><BR>$back<BR><BR></td></table><br>");
}

print"
<table><tr><td><span class=nav>&nbsp;&nbsp;&nbsp;<a href=index.php class=nav>$fname</a> -> <a href=index.php?fid=$fid class=nav>$frname</a></span></td></tr></table>
<table width=100% cellpadding=2 cellspacing=1 class=forumline><tr>
<th width=60% colspan=2 class=thCornerL height=25>����</th>
<th width=10% class=thTop nowrap=nowrap>C��������</th>
<th width=12% class=thCornerR nowrap=nowrap>�����</th>
<th width=18% class=thCornerR>����������</th>
</tr>";

if ($stop!=TRUE) $addbutton="<table width=100%><tr><td align=left valign=middle><span class=nav><a name='add' href=\"index.php?fid=$fid&newtema=add#add\"><img src='$fskin/newthread.gif' border=0></a>&nbsp;</span></td>";
else $addbutton="�������� �� ����������, �� �������� �������������� ���������� ���������!";


// ���������� ���� �� ���������� � ����� � �������
if (is_file("$datadir/topic$fid.dat")) {
$msglines=file("$datadir/topic$fid.dat"); $maxi=count($msglines); $i=$maxi;
if ($maxi>0) {

if ($maxi>$maxtem-1) $addbutton="<table width=100%><TR><TD>���������� ���������� ��� � ������� ���������.";


// ���� ����������: ��������� ������ ������ (�� ������� �������� ����� � �����)!
do {$i--; $dt=explode("|", $msglines[$i]);
   $filename="$dt[7].dat"; if (is_file("$datadir/$filename")) $ftime=filemtime("$datadir/$filename");  else $ftime="";
   $newlines[$i]="$ftime|$dt[7]|$i|";
} while($i > 0);
usort($newlines,"prcmp");
// $newlines  - ������ � �������:  ���� | ���_�����_�_����� | � �/� |
// $msglines - ������ �� ����� ������ ��������� �������
$i=$maxi;
do {$i--; $dtn=explode("|", $newlines[$i]);
   $numtp="$dtn[2]"; $lines[$i]="$msglines[$numtp]";
} while($i > 0);
// ����� ����� ����������

// ���������� QQ ���
$fm=$maxi-$qq*($page-1);
if ($fm<"0") $fm=$qq; $lm=$fm-$qq; if ($lm<"0") $lm="0";

do {$fm--; $num=$fm+2;
$dt=explode("|", $lines[$fm]);

// ����� ��� ����������� ���� �� VIP-������
$dtn=explode("|", $newlines[$fm]);
$timer=time()-$dtn[0]; // ������ ������� ������ ������� (� ��������) 


$filename=$dt[7]; 
if (is_file("$datadir/$filename.dat")) { // ���� ���� � ����� ���������� - �� �������� ���� � ������!
$msgsize=sizeof(file("$datadir/$filename.dat"));

// --------- �������� ����� ���������
$linetmp=file("$datadir/$filename.dat"); if (sizeof($linetmp)!=0) {
$pos=$msgsize-1; $dtt=explode("|", $linetmp[$pos]);
$foldicon="folder.gif";
// ���� ��������� ��������� � ������ ��������� ������ ��������� - ������ ������ ������ - �����
if (isset($wrfname)) {if (isset($dtt[9])) {if ($dtt[9]>$wrftime2) $foldicon="foldernew.gif";}}
if (strlen($dt[8])>1 and $dt[8]=="closed") {if ($msgsize<"20") $foldicon="close.gif"; else $foldicon="closed.gif";}} else $foldicon="foldernew.gif";
// --------- �����

print "<tr height=50 align=center valign=middle>
<td width=3% class=row1><img src=\"$fskin/$foldicon\" border=0></td>
<td class=row1 align=left><span class=forumlink><b>";

if ($timer<0) echo'<font color=red>VIP </font>';

$dt[3]=replacer($dt[3]);
print"<a href=\"index.php?fid=$fid&id=$dt[7]\" title='$dt[3]'>$dt[3]</a></B>";


if ($msgsize>$qq) { // ������� ������ ��������� ������� ����
$maxpaget=ceil($msgsize/$qq); $addpage="";
echo'</b></span><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div style="padding:6px;" class=pgbutt>��������: ';
if ($maxpaget<=5) $f1=$maxpaget; else $f1=5;
for($i=1; $i<=$f1; $i++) {if ($i!=1) $addpage="&page=$i"; print"<a href=index.php?fid=$fid&id=$dt[7]$addpage>$i</a> &nbsp;";}
if ($maxpaget>5) print "... <a href=index.php?fid=$fid&id=$dt[7]&page=$maxpaget>$maxpaget</a>";
echo''; }

print"</div></td><td class=row2>$msgsize</td><td class=row2><span class=gensmall>";

$codename=urlencode($dt[0]);
if ($dt[1]=="��") {
if (!isset($wrfname)) print "$dt[0]"; else print "<a href='tools.php?event=profile&pname=$codename':$dt[2]>$dt[0]</a>";
print"<BR><small>$users</small>"; } else  print"$dt[0]<BR><small>$guest</small>";

// ������ if (strlen...) ������ ���� ���� ���� � ����� ������ ������ - �������
if ($msgsize>=2) {$linesdat=file("$datadir/$filename.dat"); $dtdat=explode("|", $linesdat[$msgsize-1]);
if (strlen($linesdat[$msgsize-1])>10) {$dt[0]=$dtdat[0]; $dt[1]=$dtdat[1]; $dt[2]=$dtdat[2]; $dt[5]=$dtdat[5]; $dt[6]=$dtdat[6];}}

$dt[6]=substr($dt[6],0,-3);
if ($dt[5]===$date) $dt[5]="<B>�������</B>";
print "</span></td>
<td class=row2 align=left><span class=gensmall>�����: $dt[0]<BR>����/�����: $dt[5] � $dt[6]</span></td>
</tr>\r\r\n";

} //if is_file

} while($lm < $fm);


// ��������� ���������� $pageinfo - �� ������� �������
$pageinfo=""; $addpage=""; $maxpage=ceil(($maxi+1)/$qq); if ($page>$maxpage) $page=$maxpage;
$pageinfo.="<div style='padding:6px;' class=pgbutt>��������: &nbsp;";
if ($page>3 and $maxpage>5) $pageinfo.="<a href=index.php?fid=$fid>1</a> ... ";
$f1=$page+2; $f2=abs($page-2); if ($f2=="0") $f2=1; if ($page>=$maxpage-1) $f1=$maxpage;
if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) { if ($page==$i) $pageinfo.="<B>$i</B> &nbsp;"; 
else {if ($i!=1) $addpage="&page=$i"; $pageinfo.="<a href=index.php?fid=$fid$addpage>$i</a> &nbsp;";} }
if ($page<=$maxpage-3 and $maxpage>5) $pageinfo.="... <a href=index.php?fid=$fid&page=$maxpage>$maxpage</a>";
$pageinfo.='</div>';

print"
$addbutton<TD><table width=100%><tr><td align=right colspan=3>
$pageinfo</b></span></td></tr></table>";

} else print"$addbutton";

} else print"$addbutton";

echo'</tr></table><BR>';


if (isset($_GET['newtema'])) { if ($cangutema=="0" and !isset($wrfname)) print"<center><h5>������������� �������� ��������� ������ ����! ��� ����������� �������� �� ������: <B><a href='tools.php?event=reg'>������������������</a></B></h5></center><BR><BR>"; else {
$maxzag=$maxzag-10; // ��� �����!!!
print"<form action=\"index.php?event=addtopic&fid=$fid\" method=post enctype=\"multipart/form-data\" name=REPLIER><table width=100% class=forumline><tr><td class=catHead colspan=2 height=28><span class=cattitle>���������� ����</span></td></tr>
<tr><td class=row1 align=right valign=top>��������� ����</TD><TD class=row2>
<input type=hidden name=maxzd value='$maxzd'><input type=text class=post name=zag maxlength=$maxzag size=70>
</TD></TR>";
addmsg(""); } }


// ������� ������� � ����
echo '<br><table width=100% cellpadding=3 cellspacing=1 class=forumline><TR><TD class=catHead><span class=cattitle>���������</span></td></tr>
<tr><td class=row1 align=right><span class=gensmall>
������� ������� �� ����� &nbsp; <select onchange="window.location=(\'index.php?fid='.$fid.'&id=\'+this.options[this.selectedIndex].value)">
<option>�������� ����</option>';
$ii=$maxi; $cn=0; $i=0;
do {$dt=explode("|", $lines[$i]); print" <option value='$dt[7]'>$dt[3]</option>"; $i++;} while($i<$ii);
echo'</optgroup></select></TD></TR></TABLE>';
}
} //if ($raz!="razdel")
} // ���� ���� Fid, �� ���� id





if (isset($_GET['fid']) and isset($_GET['id'])) {$id=replacer($_GET['id']); $fid=replacer($_GET['fid']);

// ���������� ���� �� ���������� � ����� � �������
if (!is_file("$datadir/$id.dat")) exit("<BR>$back. ��������, �� ����� ���� �� ������ �� ����������.<BR> ������ ����� � ������ �������������.");
$lines=file("$datadir/$id.dat"); $mitogo=count($lines); $i=$mitogo; $maxi=$i-1;

if ($mitogo>0) { $tblstyle="row1";  $printvote=null;

// ��������� ���������� ���� ����������
if (is_file("$datadir/userstat.dat")) {$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1;}

// ���� ���� � topic��.dat - ��������� �� ������� �� ����? � ����� �� ���� ���� �� � ������
$ok=FALSE; $closed=FALSE; if (is_file("$datadir/topic$fid.dat")) {
$msglines=file("$datadir/topic$fid.dat"); $mg=count($msglines);
do {$mg--; $mt=explode("|",$msglines[$mg]);
if ($mt[7]==$id and $mt[8]=="closed") $closed=TRUE;
if ($mt[7]==$id) $ok=1; // ���� ���� � ��������� �������?
} while($mg > "0");}

$realbase="1"; if (is_file("$datadir/mainforum.dat")) $mainlines=file("$datadir/mainforum.dat");
if (!isset($mainlines)) $datasize=0; else $datasize=sizeof($mainlines);
if ($datasize<=0) {if (is_file("$datadir/copy.dat")) {$realbase="0"; $mainlines=file("$datadir/copy.dat"); $datasize=sizeof($mainlines);}}
if ($datasize<=0) exit("$back. �������� � ����� ������ - ���������� � ��������������");
$i=count($mainlines);

// �������� ������ �� ���-�� �¨�� �����. ���� ������ ���������� N � ���� ������� - �� ����������!
$maxzd=null;
do {$imax--; $ddt=explode("|",$mainlines[$imax]); if ($ddt[0]==$fid) $maxzd=$ddt[12]; } while($imax>"0");
if ($maxzd>=1) {
if (!ctype_digit($maxzd)) exit("$back ����� ����������� � ������. � � ����� ������ - ������!");
$noacsess="<br><br><br><br><table class=forumline align=center width=700><tr><th class=thHead colspan=4 height=25>������ � ������ ���������</th></tr>
<tr class=row2><td class=row1><center><BR><BR><B><span style='FONT-SIZE: 14px'>��� ��������� ������� ������� ���������� ���� ������������������� � ����� ������� �� ����� $maxzd ����.";

if ($ok==FALSE) exit("<br><br>$back. ����� ������� ������ ��������!<br> � �������� ������� ��� ����� ����!");
// ���� ��������� ����� � ������ �����, ��������� ���-�� ��� ���� � ���������� � �������� � �������
if (isset($_COOKIE['wrfcookies'])) { // ���� ���� �������� ��� ������� ����
$text=$_COOKIE['wrfcookies']; 
$text=replacer($text);
$wrfc=explode("|",$text); $wrfname=$wrfc[0]; if (isset($wrfc[1])) $wrfpass=$wrfc[1]; else exit("$back ������� ������ - � ���� ��� ������. ���� �� ����� ;-) ?");

// ��������� ���� � ������� � ��������� ��� � ������
$iu=$usercount; $ok=null;
do {$iu--; $du=explode("|",$userlines[$iu]);
if (isset($du[1])) { $realname=strtolower($du[0]);
if (strtolower($wrfname)===$realname & $wrfpass===$du[1]) {$ok="$i"; if ($du[2]<$maxzd) exit("$noacsess � ��� ����� $du[2] ����.</B></center><BR><BR>$back<BR><BR></td></table><br>"); }}
} while($iu > "0");
} else exit("$noacsess</B></center><BR><BR>$back<BR><BR></td></table><br>"); // ���� ���� ���, �� ���� ���� ����� �� ��� �������, ����� - ��������
if (!isset($ok)) exit("$noacsess</B></center><BR><BR>$back<BR><BR></td></table><br>");
}



// ��������� ������ ������ �������������� ��������
if (!isset($_GET['page'])) $page=1; else {$page=$_GET['page']; if (!ctype_digit($page)) $page=1; if ($page<1) $page=1;}

$fm=$qq*($page-1); if ($fm>$maxi) $fm=$maxi-$qq;
$lm=$fm+$qq; if ($lm>$maxi) $lm=$maxi+1;

// ��������� ���������� $pageinfo - �� ������� �������
$pageinfo=""; $addpage=""; $maxpage=ceil(($maxi+1)/$qq); if ($page>$maxpage) $page=$maxpage;
$pageinfo.="<div align=center style='padding:6px;' class=pgbutt>��������: &nbsp;";
if ($page>3 and $maxpage>5) $pageinfo.="<a href=index.php?fid=$fid&id=$id>1</a> ... ";
$f1=$page+2; $f2=abs($page-2); if ($f2=="0") $f2=1; if ($page>=$maxpage-1) $f1=$maxpage;
if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) { if ($page==$i) $pageinfo.="<B>$i</B> &nbsp;"; 
else {if ($i!=1) $addpage="&page=$i"; $pageinfo.="<a href=index.php?fid=$fid&id=$id$addpage>$i</a> &nbsp;";} }
if ($page<=$maxpage-3 and $maxpage>5) $pageinfo.="... <a href=index.php?fid=$fid&id=$id&page=$maxpage>$maxpage</a>";
$pageinfo.='</div>';

$qm=null;
do {$dt=explode("|", replacer($lines[$fm]));

$youwr=null; $fm++; $num=$maxi-$fm+2; $status="";

if (strlen($lines[$fm-1])>5) { // ���� ������� ���������� � ������� (������ ������) - �� ������ � �� �������

if (isset($_GET['quotemsg'])) {$quotemsg=replacer($_GET['quotemsg']); if(ctype_digit($quotemsg) and $quotemsg==$fm) $qm="[Quote]".$dt[4]."[/Quote]";}

$msg=str_replace("[b]","<b>",$dt[4]);
$msg=str_replace("[/b]","</b>", $msg);
$msg=str_replace("[RB]","<font color=red><B>", $msg);
$msg=str_replace("[/RB]","</B></font>", $msg);
$msg=str_replace("&lt;br&gt;","<br>",$msg);
$msg=preg_replace("#\[Quote\]\s*(.*?)\s*\[/Quote\]#is","<br><B><U>������:</U></B><table width=80% border=0 cellpadding=5 cellspacing=1 style='padding: 5px; margin: 1px'><tr><td class=quote>$1</td></tr></table>",$msg);
$msg=preg_replace("#\[Code\]\s*(.*?)\s*\[/Code\]#is"," <br><B><U>PHP ���:</U></B><table width=80% border=0 cellpadding=5 cellspacing=1 style='padding: 5px; margin: 1px'><tr><td class=code >$1</td></tr></table>",$msg);
$msg=preg_replace('#\[img(.*?)\](.+?)\[/img\]#','<img src="$2" border="0" $1>',$msg);

if ($antimat==TRUE) { // �������
$pattern="/\w{0,5}[�x]([�x\s\!@#\$%\^&*+-\|\/]{0,6})[�y]([�y\s\!@#\$%\^&*+-\|\/]{0,6})[�i�e�����]\w{0,7}|\w{0,6}[�p]([�p\s\!@#\$%\^&*+-\|\/]{0,6})[i��]([i��\s\!@#\$%\^&*+-\|\/]{0,6})[3��]([3��\s\!@#\$%\^&*+-\|\/]{0,6})[�d]\w{0,10}|[�cs][�y]([�y\!@#\$%\^&*+-\|\/]{0,6})[4�k�]\w{1,3}|\w{0,4}[b�]([b�\s\!@#\$%\^&*+-\|\/]{0,6})[l�]([l�\s\!@#\$%\^&*+-\|\/]{0,6})[y�]\w{0,10}|\w{0,8}[�][b�][����@e���a][���@���]\w{0,8}|\w{0,4}[�e]([�e\s\!@#\$%\^&*+-\|\/]{0,6})[�b]([�b\s\!@#\$%\^&*+-\|\/]{0,6})[u�]([u�\s\!@#\$%\^&*+-\|\/]{0,6})[�4�]\w{0,4}|\w{0,4}[�e�]([�e�\s\!@#\$%\^&*+-\|\/]{0,6})[�b]([�b\s\!@#\$%\^&*+-\|\/]{0,6})[�n]([�n\s\!@#\$%\^&*+-\|\/]{0,6})[�y]\w{0,4}|\w{0,4}[�e]([�e\s\!@#\$%\^&*+-\|\/]{0,6})[�b]([�b\s\!@#\$%\^&*+-\|\/]{0,6})[�o�a@]([�o�a@\s\!@#\$%\^&*+-\|\/]{0,6})[�n�t]\w{0,4}|\w{0,10}[�]([�\!@#\$%\^&*+-\|\/]{0,6})[�]\w{0,6}|\w{0,4}[p�]([p�\s\!@#\$%\^&*+-\|\/]{0,6})[�e�i]([�e�i\s\!@#\$%\^&*+-\|\/]{0,6})[�d]([�d\s\!@#\$%\^&*+-\|\/]{0,6})[o��a@�e�i]([o��a@�e�i\s\!@#\$%\^&*+-\|\/]{0,6})[�r]\w{0,12}/i";
$msg=preg_replace("$pattern","<b><font color='red'>�������</font></b>",$msg); }

if ($smile==TRUE) { // ��������
$i=count($smiles)-1; for($k=0; $k<$i; $k=$k+2)
{$j=$k+1; $msg=str_replace("$smiles[$j]","<img src='smile/$smiles[$k].gif' border=0>",$msg);}}

// ���� ��������� ���������� �����
if ($liteurl==TRUE) $msg=preg_replace("#(\[url=([^\]]+)\](.*?)\[/url\])|(http://(www.)?[0-9a-z\.-]+\.[a-z]{2,6}[0-9a-z/\?=&\._-]*)#","<a href=\"$4\" >$4</a> ",$msg);

// ��������� � ������ ������ �� ������������
if ($dt[1]=="��")  { $iu=$usercount; $predup="0";
do {$iu--; $du=explode("|", $userlines[$iu]); if ($du[0]==$dt[0])
{ if (isset($du[12])) {$status=$du[13]; $reiting=$du[2]; $youavatar=$du[12]; $email=$du[3]; $icq=$du[7]; $site=$du[8]; $userpn=$iu;}
if (isset($_COOKIE['wrfcookies'])) $youwr=preg_replace("#(\[url=([^\]]+)\](.*?)\[/url\])|(http://(www.)?[0-9a-z\.-]+\.[a-z]{2,6}[0-9a-z/\?=&\._-]*)#","<a href=\"$4\" >$4</a> ",$du[11]); else $youwr=$du[11];}
} while($iu > "0");
}

if ($tblstyle=="row1") $tblstyle="row2"; else $tblstyle="row1";

if ($fm==1+$qq*($page-1)) { // ���� �������� ���� ���
print "<table><tr><td>
<span class=nav>&nbsp;&nbsp;&nbsp;<a href=index.php class=nav>$fname</a> <a href=index.php?fid=$fid class=nav>$frname</a> <a href='index.php?fid=$fid&id=$dt[7]' class=nav><strong>$dt[3]</strong></a></span>
</td></tr></table>
$pageinfo
<table class=forumline width=100% cellspacing=1 cellpadding=3><tr>
<th class=thLeft width=160 height=26 nowrap=nowrap>�����</th><th class=thRight>���������</th>"; }

print"</tr>
<tr height=150><td class=$tblstyle valign=top><span class=name><BR><center>";

// ���������: ��� �����?
if (!isset($youwr)) {if (strlen($dt[2])>5) print "$dt[0] "; else print"$dt[0] "; $kuda=$fm-1; print" <a href='javascript:%20x()' name='m$fm' onclick=\"DoSmilie('[b]$dt[0][/b], ');\" class=nav>".chr(149)."</a><BR><br>";
// ���� ����� ������, �������� ����� ��� �������� ��
if (strlen($dt[2])>5) print"<a href='#m$kuda' onclick=\"window.open('tools.php?event=mailto&email=$dt[2]&name=$dt[0]','email','width=520,height=300,left=170,top=100')\"><img src='$fskin/ico_pm.gif' border=0 alt='��'></a>";
print"<br><BR><small>$guest</small>";}


else {
$codename=urlencode($dt[0]);
if (!isset($wrfname)) print"$dt[0]"; else print"<a name='m$fm' href='tools.php?event=profile&pname=$codename' class=nav>$dt[0]</a>";
print" <a href='javascript:%20x()' onclick=\"DoSmilie('[b]$dt[0][/b], ');\" class=nav>".chr(149)."</a><BR><BR><small>";
if (strlen($status)>2 & $dt[1]=="��" & isset($youwr)) print"$status"; else print"$users";
if (isset($reiting)) {if ($reiting>0) {echo'<BR>'; if (is_file("$fskin/star.gif")) {for ($ri=0;$ri<$reiting;$ri++) {print"<img src='$fskin/star.gif' border=0> ";} } }}

if (isset($youavatar)) { if (is_file("avatars/$youavatar")) $avpr="$youavatar"; else $avpr="noavatar.gif";
print "<BR><BR><img src='avatars/$avpr'><BR> <!--
<a href='tools.php?event=profile&pname=$dt[0]'><img src='$fskin/profile.gif' alt='�������' border=0></a>
<a href='$site'><img src='$fskin/www.gif' alt='www' border=0></a><BR>
<a href='$icq'><img src='$fskin/icq.gif' alt='ICQ' border=0></a>
<a href='#$fm' onclick=\"window.open('tools.php?event=mailto&email=$dt[3]&name=$dt[0]','email','width=400,height=390,left=100,top=100')\"><img src='$fskin/ico_pm.gif' alt='��'></a>-->";}
} // isset($youwr)

if (isset($youwr) and is_file("$datadir/userstat.dat")) { // ������ ��������� ����� ��� ���������! ;-)
if (isset($ulines[$userpn])) {
if (strlen($ulines[$userpn])>5) {
$ddu=explode("|",replacer($ulines[$userpn]));
if ($wrfname!=$dt[0]) $winop="window.open('tools.php?event=repa&name=$dt[0]&who=$userpn','repa','width=500,height=190,left=100,top=100')"; else $winop="alert('��������� ������� ������ ���� ���������!!!');";

print"</small></span><br>
<noindex>
<fieldset STYLE='color:#646464'>
<legend STYLE='font-weight:bold;'>����������:</legend>
<div style='PADDING:3px;' align=left class=gensmall>��� �������: $ddu[1]<br>���������: $ddu[2]<br>���������: $ddu[3] <A href='#$fm' style='text-decoration:none' onclick=\"$winop\">&#177;</A><br>��������������: <font color=red>$ddu[4]</div>
</fieldset></noindex>"; }}}

print "</td>
<td class=$tblstyle width=100% height=28 valign=top>
<table width=100% height=100%><tr valign=center><td><span class=postbody>$msg</span>";



//  ���� ����������� (���� ����� ���� �����������, �� �������)
if ($fm==1+$qq*($page-1) and is_file("$datadir/$id-vote.dat")) { // ���� �������� ���� ���
$vlines=file("$datadir/$id-vote.dat");
if (sizeof($vlines)>0) {$vitogo=count($vlines); $vi=1; $vdt=explode("|",$vlines[0]);

print"<center>
<FORM name=wrvote action='vote.php' method=POST target='WRGolos'>
<TABLE class=forumline cellSpacing=1 cellPadding=0 align=center border=0>
<TR><Th colspan=3 class=thHead><B>�����������: &nbsp;$vdt[0]&nbsp;</B></Th></TR>
<TR class=$tblstyle><TD class=$tblstyle>";

do {$vdt=explode("|",$vlines[$vi]);
print"&nbsp;&nbsp;&nbsp;&nbsp; 
<INPUT name='votec' type=radio value='$vi'> &nbsp; <B>$vdt[0]</B><br><br>";
$vi++; } while($vi<$vitogo);

print "<center><INPUT name='id' type=hidden value='$id'>
<INPUT type=submit value='�������������' onclick=\"window.open('vote.php','WRGolos','width=650,height=300,left=200,top=200,toolbar=0,status=0,border=0,scrollbars=0')\" border=0>
<br><br><A href='#' onclick=\"window.open('vote.php?rezultat&id=$id','WRGolos','width=650,height=300,left=200,top=200,toolbar=0,status=0,border=0,scrollbars=0')\" target='WRRezultGolos'>����������</A></center></FORM>
</TD></TR></TABLE>"; }} // ����� ����� �����������


print"</td></tr><TR><TD>";


// ���� �������˨� ���� � ��������� - �� ���������� ������ � ������ �� ���� ��� ��������
if (isset($dt[12])) { if ($dt[12]!="" and is_file("$filedir/$dt[13]")) {
$fsize=round($dt[14]/10.24)/100; echo'<fieldset style="width:30%; color:#008000"><legend>��������� ����:</legend>';
if (preg_match("/.(jpg|jpeg|bmp|gif|png)+$/is",$dt[13]))
print"<img border=0 src='$filedir/$dt[13]'>"; else 
print"<img border=0 src='$fskin/ico_file.gif'> <a href='$filedir/$dt[13]'>$dt[13]</a> ($fsize ��.)</fieldset>"; }}

// �������� ������� ���������
if (isset($youwr)) { if (strlen($youwr)>3) print "<tr><td valign=bottom><span class=postbody>--------------------------------------------------<BR><small>$youwr</small>";}

print"</table></td></tr><tr>
<td class=row3 valign=middle><span class=postdetails><I>��������� # <B>$fm</B></I></span></td>
<td class=row3 width=100% height=28><span class=postdetails>����������: <b>$dt[5]</b> � $dt[6]
<noindex>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href='index.php?fid=$fid&id=$id&quotemsg=$fm&page=$page#add'>���������� ���������</a></noindex>
</span></td></tr>
<tr><td class=spaceRow colspan=2 height=1><img src=\"$fskin/spacer.gif\" width=1 height=1></td>";

} // ���� ������� ����������
} while($fm < $lm);

print" </tr></table> $pageinfo";


if ($cangumsg==FALSE and !isset($wrfname)) {print"<center>������������� �������� �������� ������ �� ���������! ��� ����������� �������� �� ������: <B><a href='tools.php?event=reg'>������������������</a></B></center><BR><BR>"; } else {
if ($closed==FALSE) {

if (isset($_COOKIE['wrfcookies'])) {$wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc); $wrfc=explode("|", $wrfc);  $wrfpass=replacer($wrfc[1]);} else {unset($wrfpass); $wrfpass="";}

print "
<form action=\"index.php?event=addanswer&fid=$fid\" method=post name=REPLIER enctype=\"multipart/form-data\">
<input type=hidden name=id value='$id'>
<input type=hidden name=userpass value=\"$wrfpass\">
<input type=hidden name=page value='$page'>
<input type=hidden name=zag value=\"$dt[3]\">
<input type=hidden name=maxzd value='$maxzd'>
<table cellpadding=3 cellspacing=1 width=100% class=forumline>
<tr><th class=thHead colspan=2 height=25><b>���������</b></th></tr>";

addmsg($qm);

} else echo'<center><font style="font-size: 16px;font-weight:bold;"><BR>���� ������� ��� ����������!<BR><BR>';
}}

} // else isset(event)


?>
</td></tr></table>
<center><font size=-2><small>Powered by <a href="http://www.wr-script.ru" class="copyright">WR-Forum</a> Professional &copy; 1.9.3 <a href="http://www.master-script.ru/scripty_forumov.html" class="copyright">MS</a><br></small></font></center>
</body>
</html>
