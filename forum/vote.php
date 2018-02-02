<? // WR-Golos v 1.0  //  28.10.2006 г.  //  Miha-ingener@yandex.ru

error_reporting (E_ALL); // ВРЕМЕННО - на время тестирования и отладки скрипта!
// error_reporting(0); // РАЗКОМЕНТИРУЙТЕ для постоянной работы!!!
@ini_set('register_globals','off');// Все скрипты написаны для этой настройки php

include "config.php";

$antiflud="0"; // задействовать АНТИФЛУД (увеличивает надёжность и защиту от взлома)
$fludtime="10"; // Антифлуд-время
$ipblok="1"; // Запретить голосовать более раза с одного IP 0/1

function replacer ($text) { // ФУНКЦИЯ очистки кода
$text=str_replace("&#032;",' ',$text);
$text=str_replace(">",'&gt;',$text);
$text=str_replace("<",'&lt;',$text);
$text=str_replace("\"",'&quot;',$text);
$text=preg_replace("/\n\n/",'<p>',$text);
$text=preg_replace("/\n/",'<br>',$text);
$text=preg_replace("/\\\$/",'&#036;',$text);
$text=preg_replace("/\r/",'',$text);
$text=preg_replace("/\\\/",'&#092;',$text);
// если magic_quotes включена - чистим везде СЛЭШи в этих случаях: одиночные (') и двойные кавычки ("), обратный слеш (\)
if (get_magic_quotes_gpc()) { $text=str_replace("&#092;&quot;",'&quot;',$text); $text=str_replace("&#092;'",'\'',$text); $text=str_replace("&#092;&#092;",'&#092;',$text); }
$text=str_replace("\r\n","<br> ",$text);
$text=str_replace("\n\n",'<p> ',$text);
$text=str_replace("\n",'<br> ',$text);
$text=str_replace("\t",'',$text);
$text=str_replace("\r",'',$text);
$text=str_replace('   ',' ',$text);
return $text; }



$shapka="<html><head><title>Голосование</title><META HTTP-EQUIV='Pragma' CONTENT='no-cache'><META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'><META content='text/html; charset=windows-1251' http-equiv=Content-Type><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>";




if (isset($_GET['rezultat'])) { // ПРОСМОТР результата голосования

// переделать блок
if (isset($_GET['id'])) {$id=replacer($_GET['id']); if ((!ctype_digit($id)) or (strlen($id)>20)) 
exit("<B>Поддерживаются номера голосований от 1 до 10 включительно!!!</B>");} else $id=1;

$lines = file("$datadir/$id-vote.dat"); $itogo=count($lines); $i=1; $glmax=0;

// Считаем общее кол-во голосов
do {$dt=explode("|",$lines[$i]); $glmax=$glmax+$dt[1]; $i++; } while($i<$itogo); $i=1; $all=$glmax;

$vdt = explode("|",$lines[0]);
print"$shapka
<center><TABLE cellPadding=3 align=center border=0><TBODY><TR><TD vAlign=top align=middle>

<TABLE border=0 bgcolor=navy cellSpacing=1 cellPadding=0 align=center><TR><TD>

<TABLE border=0 bgcolor=#ffffff cellSpacing=0 cellPadding=1 align=center border=0>
<FORM name=wrvote action='submit.php' method=post>
<TR><TD colspan=3 align=middle bgColor=#FFFFFF><FONT face=arial size=2><B>&nbsp;$vdt[0]&nbsp;</B></FONT></TD></TR>
<TR><TD><TABLE border=0 cellSpacing=0 cellPadding=2 width=100%><TBODY>";

do {$dt = explode("|",$lines[$i]);
if ($glmax==0) {$glmax=0.1;}
$glpercent=round(10000*$dt[1]/$glmax)/100;
$hcg=round($glpercent);
if ($glpercent<1) {$hcg=1;} if ($glpercent>100) {$hcg=100;}
print"<TR>
<TD width=25>&nbsp;</TD><TD><B>&nbsp;$dt[0]</B></TD>
<TD><FONT face=arial size=2><B>&nbsp;$dt[1]</B></FONT></TD>
<TD>(<B>$glpercent</B> %)</TD>

<TD

<TABLE border=0 cellSpacing=0 cellPadding=0 width=$hcg height=11><TR bgcolor=#008000><TD>
<img src='$fskin/spacer.gif' border=0>
</TD></TR></TABLE>

</TD>
</TR>";

$i++;
} while($i<$itogo);


print"<TR>
<TD>&nbsp;</TD><TD>Итого проголосовало:</B></TD>
<TD><FONT face=arial size=2><B>&nbsp;$all</B></FONT></TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
</FORM></TBODY></TABLE>
</TBODY></TABLE>
</TBODY></TABLE>
<a href='rezult.php' onClick='self.close()'>Закрыть окно</b></a>
</TD></TR></TABLE>";
exit; } // конец блока результатов
















if (isset($_POST["votec"])) $numv=replacer($_POST["votec"]); else exit("<BR><BR><BR><center> Вы <B>не выбрали ни один пункт</B> голосования!</center>");

$ip=(isset($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:0;

$id=replacer($_POST["id"]); // получаем имя темы


// Проверка на IP-юзера
if (is_file("$datadir/$id-ip.dat")) { 
$iplines=file("$datadir/$id-ip.dat"); $sizef=count($iplines);
if ($sizef > 1) { $itip=$sizef;
do {$itip--; $idt=explode("|",$iplines[$itip]); 
if ($ip==$idt[0]) { $dayx=date("d.m.Y в H:i:s",$idt[1]); $stime=$idt[1]; $today=mktime();
if ($antiflud=="1") {if (($today-$stime)<$fludtime)
exit("<center><br><br><br>Включена <B>защита от ФЛУДА</B>.<br> Чаще <B>$fludtime секунд</B> 
голосовать запрещено.<br><br> <B><a href='vote.php' onClick='self.close()'>Закройте окно</b></a>, 
подождите указаное время<br> и повторите попытку.</B>");
}
$allredy="Вы <B>уже голосовали $dayx!</B></center>";}
} while ($itip>0); } }

if ($ipblok==FALSE) {$allredy=""; unset($allredy);}

if (!isset($allredy)) {$allredy="<B>Ваш голос принят.</B>";
$mkdate=mktime(); // формируем дату голосования в UNIX-формате
$lines=file("$datadir/$id-vote.dat");
$itogo=count($lines); $i=$itogo;

do { $i--; if ($numv==$i) $vote=$i; } while ($i>0);

$i=$itogo;
do {$i--; $dt=explode("|",$lines[$i]); 
if ($vote==$i) {$dt[1]++;}
$lines[$i]="$dt[0]|$dt[1]|\r\n";
} while ($i>0);

$fp=fopen("$datadir/$id-vote.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
for ($i=0; $i<$itogo; $i++) fputs($fp,$lines[$i]);
fflush ($fp);
flock ($fp,LOCK_UN);
@chmod("$fp",0644);

$fp=fopen("$datadir/$id-ip.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$ip|$mkdate|\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
@chmod("$fp",0644);
}

//print "<center><script language='Javascript'>function reload() {location = 'rezult.php'}; setTimeout('reload()', 1500);</script><BR><BR><BR> $allredy";




if (!is_file("$datadir/$id-vote.dat")) exit("<center>Файл данных $idvote.dat отсутствует!");
$lines=file("$datadir/$id-vote.dat");
if (sizeof($lines)<1) exit("<center>Файл данных $id-vote.dat пуст!");

$itogo=count($lines); $i=1; $glmax=0;

// Считаем общее кол-во голосов
do {$dt=explode("|",$lines[$i]); $glmax=$glmax+$dt[1]; $i++; } while($i<$itogo); $i=1; $all=$glmax;

$vdt = explode("|",$lines[0]);
print"$shapka
<center><TABLE cellPadding=3 align=center border=0><TBODY><TR><TD vAlign=top align=middle>

<TABLE border=0 bgcolor=navy cellSpacing=1 cellPadding=0 align=center><TR><TD>

<TABLE border=0 bgcolor=#ffffff  cellSpacing=0 cellPadding=1 align=center border=0>
<FORM name=wrvote action='submit.php' method=post>
<TR><TD colspan=3 align=middle bgColor=#FFFFFF><FONT><B>&nbsp;$vdt[0]&nbsp;</B></FONT></TD></TR>

<TR><TD><TABLE border=1 cellSpacing=0 cellPadding=2 width=100%><TBODY>";

do {$dt = explode("|",$lines[$i]);
if ($glmax==0) {$glmax=0.1;}
$glpercent=round(10000*$dt[1]/$glmax)/100;
$hcg=round($glpercent*4);
if ($glpercent<1) $hcg=1;
if ($glpercent>100) $hcg=100;
print"<TR>
<TD width=55%><B>&nbsp;&nbsp;&nbsp; $dt[0]</B></TD>
<TD width=10%><B>&nbsp;$dt[1]</B></TD>
<TD width=15%>(<B>$glpercent</B> %)</TD>

<TD width=20%>
<table cellPadding=0><TR><TD height=7 width=$hcg bgcolor=#5193BF style='font-size:9px'>&nbsp;</TD></TR></table>

</TD></TR>";

$i++;
} while($i<$itogo);


print"<TR>
<TD align=center colspan=4>Итого проголосовало: &nbsp;$all</B></TD>
</TR></FORM></TBODY></TABLE>

</TBODY></TABLE>
</TBODY></TABLE>
</TD></TR></TABLE>";

?>
