<? // WR-forum v 1.9.3  //  10.06.10 г.  //  Miha-ingener@yandex.ru

error_reporting (E_ALL); //error_reporting(0);
ini_set('register_globals','off');// Все скрипты написаны для этой настройки php

include "config.php";

$skey="657567"; // !!! Секретный ключ !!! 
// Поменяйте на свой и фиг кто вскроет админку :-)
// !!! ПОСЛЕ СМЕНЫ - пароли администратора и модератора становятся ошибочными!
// для получения нового пароля разкоменируйте строку № 97
// вставьте полученный код в config.php В ПЕРЕМЕННЫЕ $password и $moderpass

// Авторизация
$adminname="администратор|модератор|"; // НЕ МЕНЯЙТЕ покамисть!!! Ещё тестирую. имя администратора и через знак | имя модератора и в конце |
$adminpass=$password;


//--А-Н-Т-И-С-П-А-М--
if (isset($_GET['image'])) {
// Функция с цифрами защиты
$st="R0lGODlhCgAMAIABAFNTU////yH5BAEAAAEALAAAAAAKAAwAAAI"; // общая часть для всех рисунков
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
// Вывод изображений на экран (все кодированы - робот не пройдёт)
if (array_key_exists("image", $_REQUEST)) { $num=$_REQUEST["image"];
for ($i=0; $i<10; $i++) {if (md5($i+$rand_key)==$num) {imgwr($st,$i); die();}} }
exit;}

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

if (get_magic_quotes_gpc()) {
$text=str_replace("&#092;&quot;",'&quot;',$text);
$text=str_replace("&#092;'",'\'',$text);
$text=str_replace("&#092;&#092;",'&#092;',$text);
} // если magic_quotes включена - чистим везде СЛЭШи в этих случаях автозамены:
  // одиночные (') и двойные кавычки ("), обратный слеш ()

$text=str_replace("\r\n","<br> ",$text);
$text=str_replace("\n\n",'<p>',$text);
$text=str_replace("\n",'<br> ',$text);
$text=str_replace("\t",'',$text);
$text=str_replace("\r",'',$text);
$text=str_replace('   ',' ',$text);
return $text; }


function unreplacer ($text) { // ФУНКЦИЯ замены спецсимволов конца строки на обычные
$text=str_replace("&lt;br&gt;","<br>",$text);
$text=str_replace("&#124;","|",$text);
return $text;}

// Выбран ВЫХОД - очищаем куки
if(isset($_GET['event'])) { if ($_GET['event']=="clearcooke") { setcookie("wrforumm","",time()-3600); Header("Location: index.php"); exit; } }

if (isset($_COOKIE['wrforumm'])) { // Сверяем имя/пароль из КУКИ с заданным в конфиг файле
$text=$_COOKIE['wrforumm'];
$text=trim($text); // Вырезает ПРОБЕЛьные символы 
if (strlen($text)>60) exit("Попытка взлома - длина переменной куки сильно большая!");
$text=replacer($text);
$exd=explode("|",$text); $name1=$exd[0]; $pass1=$exd[1];
$adminname=explode("|",$adminname);

if ($name1!=$adminname[0] and $name1!=$adminname[1] or $pass1!=$adminpass) 
{sleep(1); setcookie("wrforumm", "0", time()-3600); Header("Location: admin.php"); exit;} // убаваем НЕВЕРНУЮ КУКУ!!!

} else { // ЕСЛИ ваще нету КУКИ

if (isset($_POST['name']) & isset($_POST['pass'])) { // Если есть переменные из формы ввода пароля
$name=str_replace("|","I",$_POST['name']); $pass=str_replace("|","I",$_POST['pass']);
$text="$name|$pass|";
$text=trim($text); // Вырезает ПРОБЕЛьные символы 
if (strlen($text)<4) exit("$back Вы не ввели имя или пароль!");
$text=replacer($text);
$exd=explode("|",$text); $name=$exd[0]; $pass=$exd[1];

//$qq=md5("$pass+$skey"); print"$qq"; exit; // РАЗБЛОКИРУЙТЕ для получения MD5 своего пароля!

//--А-Н-Т-И-С-П-А-М--проверка кода--
if ($antispam!="0") {
$bada="$back <font color=red>Введённый вами код НЕ верен</font>!";
if (isset($_POST['usernum'])) $usernum=$_POST['usernum']; else exit("$bada");
if (isset($_POST['xkey'])) $xkey=$_POST['xkey']; else exit("$bada");
$userkey=md5("$usernum+$rand_key");
if ($userkey!=$xkey) exit("$bada"); }
//--А-Н-Т-И-С-П-А-М--проверка кода--


// Сверяем введённое имя/пароль с заданным в конфиг файле
$adminname=explode("|",$adminname);
// АДМИНИСТРАТОРУ присваиваются куки
if ($name==$adminname[0] & md5("$pass+$skey")==$adminpass) 
{$tektime=time(); $wrforumm="$adminname[0]|$adminpass|$tektime|";
setcookie("wrforumm", $wrforumm, time()+18000); Header("Location: admin.php"); exit;}
// МОДЕРАТОРУ присваиваются куки
if ($name==$adminname[1] & md5("$pass+$skey")==$moderpass) 
{$tektime=time(); $wrforumm="$adminname[1]|$adminpass|$tektime|";
setcookie("wrforumm", $wrforumm, time()+18000); Header("Location: admin.php"); exit;}

exit("Ваши данные <B>ОШИБОЧНЫ</B>!</center>");

} else { // если нету данных, то выводим ФОРМУ ввода пароля

echo "<html><head><META HTTP-EQUIV='Pragma' CONTENT='no-cache'><META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'><META content='text/html; charset=windows-1251' http-equiv=Content-Type><style>input, textarea {font-family:Verdana; font-size:12px; text-decoration:none; color:#000000; cursor:default; background-color:#FFFFFF; border-style:solid; border-width:1px; border-color:#000000;}</style></head><body>
<BR><BR><BR><center>
<table border=#C0C0C0 border=1  cellpadding=3 cellspacing=0 bordercolor=#959595>
<form action='admin.php' method=POST name=pswrd>
<TR><TD bgcolor=#C0C0C0 align=center>Администрирование форума</TD></TR>
<TR><TD align=right>Введите логин: <input size=17 name=name value=''></TD></TR>
<TR><TD align=right>Введите пароль: <input type=password size=17 name=pass></TD></TR>";

//-А-Н-Т-И-С-П-А-М-
if ($antispam!="0") {
// Вывод изображений на экран (все кодированы - робот не пройдёт)
if (array_key_exists("image", $_REQUEST)) { $num=$_REQUEST["image"];
for ($i=0; $i<10; $i++) {if (md5($i+$rand_key)==$num) {imgwr($st,$i); die();}} }
$xkey=""; mt_srand(time()+(double)microtime()*1000000);
echo'<TR><TD align=right>Защитный код: ';
for ($i=0; $i<$max_key; $i++) {
$snum[$i]=mt_rand(0,9); $psnum=md5($snum[$i]+$rand_key);
$phpself=$_SERVER["PHP_SELF"];
echo "<img src=$phpself?image=$psnum border='0' alt=''>\n";
$xkey=$xkey.$snum[$i];}
$xkey=md5("$xkey+$rand_key");
print" <input name='usernum' class=post type='text' maxlength=$max_key size=8>
<input name=xkey type=hidden value='$xkey'>";
} // if $antispam!="0"
//-К-О-Н-Е-Ц--А-Н-Т-И-С-П-А-М-А-

print"<TR><TD align=center><input type=submit style='WIDTH: 120px; height:20px;' value='Войти'>
<SCRIPT language=JavaScript>document.pswrd.name.focus();</SCRIPT></TD></TR></table>
<BR><BR><center><font size=-2><small>Powered by <a href=\"http://www.wr-script.ru\" title=\"Скрипт форума\" class='copyright'>WR-Forum</a> Professional &copy; 1.9<br></small></font></center></body></html>";
exit;}

} // АВТОРИЗАЦИЯ ПРОЙДЕНА!

$gbc=$_COOKIE['wrforumm']; $gbc=explode("|", $gbc); $gbname=$gbc[0];$gbpass=$gbc[1];$gbtime=$gbc[2];






// АКТИВАЦИЯ пользователя
if(isset($_GET['event'])) { if ($_GET['event']=="activate") {

$key=$_GET['key']; $email=$_GET['email']; $page=$_GET['page'];

// защиты от взлома по ключу и емайлу
if (strlen($key)<6 or strlen($key)>6 or !ctype_digit($key)) exit("$back. Вы ошиблись при вводе ключа. Ключ может содержать только 6 цифр.");
$email=stripslashes($email); $email=htmlspecialchars($email);
$email=str_replace("|","I",$email); $email=str_replace("\r\n","<br>",$email);
if (strlen($key)>30) exit("Ошибка при вводе емайла");

// Ищем юзера с таким емайлом и ключом. Если есть - меняем статус на пустое поле
$email=strtolower($email); unset($fnomer); unset($ok);
$lines=file("$datadir/usersdat.php"); $ui=count($lines); $i=$ui;
do {$i--; $rdt=explode("|",$lines[$i]); 
$rdt[3]=strtolower($rdt[3]);
if ($rdt[3]===$email and $rdt[13]===$key) {$name=$rdt[0]; $pass=$rdt[1]; $fnomer=$i;}
if ($rdt[3]===$email and $rdt[13]==="") $ok="1";
} while($i > 1);
if (isset($fnomer)) {
// обновление строки юзера в БД
$i=$ui; $dt=explode("|", $lines[$fnomer]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]||";
$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
for ($i=0;$i<=(sizeof($lines)-1);$i++) {if ($i==$fnomer) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]);}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
}
if (!isset($fnomer) and !isset($ok)) exit("$back. Вы ошиблись в воде активационного ключа или емайла.</center>");
if (isset($ok)) $add="Запись активирована ранее"; else $add="$name, Пользователь успешно зарегистрирован.";

print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>
<script language='Javascript'>function reload() {location = \"admin.php?event=userwho&page=$page\"}; setTimeout('reload()', 2500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
Спасибо, <B>$add</B>.<BR><BR>Через несколько секунд Вы будете автоматически перемещены на страницу с участниками форума.<BR><BR>
<B><a href='admin.php?event=userwho&page=$page'>Нажмите здесь, если не хотите больше ждать</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;

}
}






// Блок ПЕРЕСЧЁТА кол-ва тем и сообщений
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

// сохраняем обновлённые данные о кол-ве тем и сообщений в файле
$file=file("$datadir/mainforum.dat");
$fp=fopen("$datadir/mainforum.dat","w");
flock ($fp,LOCK_EX); 
for ($i=0;$i< sizeof($file);$i++) fputs($fp,$lines[$i]);
flock ($fp,LOCK_UN);
fclose($fp);

print "<center><BR><BR><BR>Всё успешно пересчитано.</center><script language='Javascript'><!--
function reload() {location = \"admin.php\"}; setTimeout('reload()', 1000);
--></script>";
exit; }}






// Блок удаления УЧАСТНИКА ФОРУМА



// НОВЫЙ Блок УДАЛЕНИЯ 
if (isset($_GET['usersdelete']))  { $usersdelete=$_GET['usersdelete'];

$first=$_POST['first']; $last=$_POST['last']; $page=$_GET['page']; $delnum=null; $i=0;

// Сравнимаем кол-во строк в файле ЮЗЕРОВ и их СТАТИСТИКУ
if (count(file("$datadir/usersdat.php")) != count(file("$datadir/userstat.dat"))) exit("Статистика участников повреждена! Запустите блок: '<a href='admin.php?newstatistik'>Пересчитать статистику участников</a>',<br> а затем уже можно будет удалять участников!");

do {$dd="del$first"; if (isset($_POST["$dd"])) { $delnum[$i]=$first; $i++;} $first++; } while ($first<=$last);
$itogodel=count($delnum); $newi=0; 
if ($delnum=="") exit("Сделайте выбор хотябы одного объявления!");
$file=file("$datadir/usersdat.php"); $itogo=sizeof($file); $lines=null; $delyes="0";
for ($i=0; $i<$itogo; $i++) { // цикл по файлу с данными
for ($p=0; $p<$itogodel; $p++) {if ($i==$delnum[$p]) $delyes=1;} // цикл по строкам для удаления
// если нет метки на удаление записи - формируем новую строку массива, иначе - нет
if ($delyes!=1) {$lines[$newi]=$file[$i]; $newi++;} else $delyes="0"; }

// пишем новый массив в файл
$newitogo=count($lines); 
$fp=fopen("$datadir/usersdat.php","w");
flock ($fp,LOCK_EX);
// если всех юзеров удаляем, тогда ничего туда ВПУТИТЬ :-))
if (isset($lines[0])) { for ($i=0; $i<$newitogo; $i++) fputs($fp,$lines[$i]); } else fputs($fp,"");
flock ($fp,LOCK_UN);
fclose($fp);

// Удаляем инфу о юзере из блока статистики - ДОРАБОТАТЬ блок!!!!
// сейчас делаю просто удалить ту запись, которая соответствует номеру
// но в  идеале нужно проверять всю статистику и собирать файл
// заново - чтобы исключить любые ошибки

$file=file("$datadir/userstat.dat"); $itogo=sizeof($file); $lines=null; $delyes="0"; $newi=0;
for ($i=0; $i<$itogo; $i++) { // цикл по файлу с данными
for ($p=0; $p<$itogodel; $p++) {if ($i==$delnum[$p]) $delyes=1;} // цикл по строкам для удаления
// если нет метки на удаление записи - формируем новую строку массива, иначе - нет
if ($delyes!=1) {$lines[$newi]=$file[$i]; $newi++;} else $delyes="0"; }

// пишем новый массив в файл
$newitogo=count($lines); 
$fp=fopen("$datadir/userstat.dat","w");
flock ($fp,LOCK_EX);
// если статистику всех юзеров удаляем, тогда ничего туда ВПУТИТЬ :-))
if (isset($lines[0])) {for ($i=0; $i<$newitogo; $i++) fputs($fp,$lines[$i]);} else fputs($fp,"");
flock ($fp,LOCK_UN);
fclose($fp);

Header("Location: admin.php?event=userwho&page=$page"); exit; } 







// Блок ПЕРЕСЧЁТА СТАТИСТИКИ участников

if(isset($_GET['newstatistik'])) {


$lines=null; $ok=null;
// 1. Открываем и считываем в память файл с юзерами
$ulines=file("$datadir/usersdat.php"); $ui=count($ulines);

// 2. Открываем файл статистики
$slines=file("$datadir/userstat.dat"); $si=count($slines)-1;

// Цикл по кол-ву юзеров в базе
for ($i=1;$i<$ui;$i++) {
$udt=explode("|", $ulines[$i]);
if ($i<=$si) $sdt=explode("|",$slines[$i]); else $sdt[0]="";

if ($udt[0]==$sdt[0]) {$udt[0]=str_replace("\r\n","",$udt[0]); $ok=1; if (isset($sdt[1]) and isset($sdt[2]) and isset($sdt[3]) and isset($sdt[4])) {$lines[$i]="$slines[$i]";} else {$lines[$i]="$udt[0]|0|0|0|0|||||\r\n";}} // если имя=имя - значит данные верны

// Цикл в файле статистики - поиск строку текущего юзера
if ($ok!="1") {

for ($j=1;$j<$si;$j++) {
$sdt=explode("|", $slines[$j]);
if ($udt[0]==$sdt[0]) {$ok=1; $lines[$i]=$slines[$j]; }// если имя=имя - значит данные верны
}

if ($ok!="1") $lines[$i]="$udt[0]|0|0|0|0|||||\r\n"; // создаём юзера с нулевой статистикой
}
$ok=null; $ii=count($lines);}

$fp=fopen("$datadir/userstat.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
fputs($fp,"ИМЯ_ЮЗЕРА|Тем|Сообщений|Репутация|Предупреждения Х/5|Когда последний раз меняли рейтинг в UNIX формате|||\r\n");
for ($i=1;$i<=$ii;$i++) fputs($fp,"$lines[$i]");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

Header("Location: admin.php?event=userwho"); exit; }







// Блок изменения СТАТУСА участника
if(isset($_GET['newstatus'])) { if ($_GET['newstatus'] !="") { $newstatus=$_GET['newstatus']-1; $status=$_POST['status'];
if (isset($_GET['page'])) $page=$_GET['page']; else $page=1;
if (strlen($status)<3) exit("новый статус участника <B> < 3 символов </B> - это не серьёзно!");
$status=htmlspecialchars($status); $status=stripslashes($status);
$status=str_replace("|"," ",$status); $status=str_replace("\r\n","<br>",$status);
$lines=file("$datadir/usersdat.php"); $i=count($lines);
$dt=explode("|", $lines[$newstatus]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]|$status|";

$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$newstatus) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; } }




// Блок изменения РЕЙТИНГА участника
if(isset($_GET['newreiting'])) { if ($_GET['newreiting'] !="") { $newreiting=$_GET['newreiting']-1; $reiting=$_POST['reiting'];
if (isset($_GET['page'])) $page=$_GET['page']; else $page=1;
$reiting=htmlspecialchars($reiting); $reiting=stripslashes($reiting);
$reiting=str_replace("|"," ",$reiting); $reiting=str_replace("\r\n","<br>",$reiting);
$lines=file("$datadir/usersdat.php"); $i=count($lines);
$dt=explode("|", $lines[$newreiting]);
$txtdat="$dt[0]|$dt[1]|$reiting|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]|$dt[13]|";

$fp=fopen("$datadir/usersdat.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$newreiting) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; } }




// изменяем РЕПУТАЦИЮ юзера
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
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$usernum) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; }






// Добавляем/снимаем ШТРАФЫ ЮЗЕРУ
if(isset($_GET['userstatus'])) {
if (isset($_GET['page'])) $page=$_GET['page']; else $page=1;
$text=$_POST['submit']; $status=$_POST['status']; $usernum=$_POST['usernum']-1;
$text=htmlspecialchars($text); $text=stripslashes($text);
$text=str_replace("|"," ",$text); $submit=str_replace("\r\n","<br>",$text);
if (!ctype_digit($status)) $status=0;
$status=$status+$submit; // корректируем статус (+1 или -1)
// 0 <= СТАТУС <= 5 (БОЛЬШЕ ЛИБО РАВЕН НУЛЮ, НО МЕНЬШЕ ЛИБО РАВЕН ПЯТИ)
if($status<0 or $status>5) exit("$back статус пользователя БОЛЬШЕ ЛИБО РАВЕН НУЛЮ, НО МЕНЬШЕ ЛИБО РАВЕН ПЯТИ!");
$lines=file("$datadir/userstat.dat");
if (!isset($lines[$usernum])) exit("ошибка! Нет такого пользователя в файле статистики!"); // если нет такой строка в файле статистики
$dt=explode("|", $lines[$usernum]); 
// В версии 1.8.2 ещё было 5 полей в строке файла userstat.dat. 
// Защищаемся от ошибки - вводим пустые поля
if (!isset($dt[6])) $dt[6]="";
if (!isset($dt[7])) $dt[7]="";
$dt[6]=str_replace("\r\n","",$dt[6]); $dt[7]=str_replace("\r\n","",$dt[7]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$status|$dt[5]|$dt[6]|$dt[7]|||";
$fp=fopen("$datadir/userstat.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$usernum) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=userwho&page=$page"); exit; }









// ДОБАВЛЕНИЕ НОВОГО ГОЛОСОВАНИЯ
if (isset($_GET['event'])) { if ($_GET['event']=="voteadd") { 

$id=replacer($_GET['id']); // получаем данные из формы
$fid=replacer($_GET['fid']); $toper=replacer($_POST['toper']);

$i=1; $itgo=0; $text="$toper||\r\n";

do {
 $otv=replacer($_POST["otv$i"]); $otv=str_replace("|","I",$otv); $otv=str_replace("\r\n","<br>",$otv);
 $kolvo=replacer($_POST["kolvo$i"]); $kolvo=str_replace("|","I",$kolvo); $kolvo=str_replace("\r\n","<br>",$kolvo);
 if (strlen($otv)>2) {$itgo++; $text.="$otv|$kolvo|\r\n";}
 $i++;
} while ($i<$golositogo);

if ($itgo<1) exit("Должен быть хотябы ОДИН вариант ответа!");

// создаём файл с голосованием
$fp=fopen("$datadir/$id-vote.dat","w");
flock ($fp,LOCK_EX);
fputs($fp,"$text");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$datadir/$id-vote.dat", 0644);

// создаём файл для записи IPшников голосовавших
$fp=fopen("$datadir/$id-ip.dat","w");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$datadir/$id-ip.dat", 0644);

Header("Location: admin.php?fid=$fid&id=$id"); exit; }} // КОНЕЦ добавления нового голосования










// Блок Добавления/Редактирования/Удаления ГОЛОСОВАНИЯ

// в процессе написания - дописать!!!!

if(isset($_GET['vote'])) { $vote=$_GET['vote'];
$fid=$_GET['fid']; $id=$_GET['id'];

if ($vote=="delete") { // Выбрано - УДАЛЕНИЕ
if (is_file("$datadir/$id-vote.dat")) {unlink ("$datadir/$id-vote.dat"); unlink ("$datadir/$id-ip.dat");}} // удаляем файлы с голосованием



if ($vote=="change") { } // Выбрано - РЕДАКТИРОВАНИЕ

if ($vote=="add") {

if (is_file("$datadir/$id-vote.dat")) exit("$back. Голосование уже добавлено в теме. Более одного голосования добавлять нельзя!");


} // Выбрано - ДОБАВЛЕНИЕ

if ($vote=="addsave") { } // Сохранение после блока добавления или редактирования

Header("Location: admin.php?fid=$fid&id=$id"); exit;}












// Блок ПЕРЕМЕЩЕНИЯ ВВЕРХ/ВНИЗ РАЗДЕЛА или ТОПИКА
if(isset($_GET['movetopic'])) { if ($_GET['movetopic'] !="") {
$move1=$_GET['movetopic']; $where=$_GET['where']; 
if ($where=="0") $where="-1";
$move2=$move1-$where;
$file=file("$datadir/mainforum.dat"); $imax=sizeof($file);
if (($move2>=$imax) or ($move2<"0")) exit(" НИЗЯ туда двигать!");
$data1=$file[$move1]; $data2=$file[$move2];

$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА 
// меняем местами два соседних раздела
for ($i=0; $i<$imax; $i++) {if ($move1==$i) fputs($fp,$data2); else  {if ($move2==$i) fputs($fp,$data1); else fputs($fp,$file[$i]);}}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; }}




// Блок УДАЛЕНИЯ выбранного РАЗДЕЛА или ФОРУМА
if(isset($_GET['fxd'])) { if ($_GET['fxd'] !="") {
$fxd=$_GET['fxd'];
$file=file("$datadir/mainforum.dat");

// удаляем строку, соответствующую теме в файле со всеми темами
$fp=fopen("$datadir/mainforum.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) {if ($i==$fxd) unset($file[$i]);}
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; } }





// Блок удаления выбранной ТЕМЫ
if (isset($_GET['xd'])) { if ($_GET['xd'] !="") {
if (isset($_GET['page'])) $page=$_GET['page']; else $page="0";
$xd=$_GET['xd']; $fid=$_GET['fid']; $id=$_GET['id'];
$file=file("$datadir/topic$fid.dat");

$minmsg=1; $delf=null; if (isset($file[$xd])) {
$dt=explode("|", $file[$xd]);
$delf = str_replace("\r\n", "", $dt[7]);
$mlines=file("$datadir/$delf.dat"); $minmsg=count($mlines);
unlink ("$datadir/$delf.dat");} // удаляем файл с темой

// удаляем строку, соответствующую теме в файле с текущими темами
$fp=fopen("$datadir/topic$fid.dat","w");
$kolvotem=sizeof($file)-1; // кол-во тем для уточнения на главной
flock ($fp,LOCK_EX); 
for ($i=0;$i< sizeof($file);$i++) {if ($i==$xd) unset($file[$i]);}
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);


// Блок вычитает 1-цу из кол-ва тем и вычитает кол-во сообщений
$lines = file("$datadir/mainforum.dat"); $i=count($lines);
// находим по fid номер строки
for ($ii=0;$ii< sizeof($lines);$ii++) {$kdt=explode("|",$lines[$ii]); if ($kdt[0]==$fid) $mnumer=$ii;}
$dt=explode("|",$lines[$mnumer]);
$dt[5]=$dt[5]-$minmsg;
if ($kolvotem=="0") $dt[5]="0";
if ($dt[5]<0) $dt[5]="0";
if ($dt[4]<0) $dt[4]="0";
// если удаляемая тема стоит на главной как последняя, то удаляем её с главной
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


// удаляем объявление из 10-КИ последних
$file=file("$datadir/news.dat");
$fp=fopen("$datadir/news.dat","w");
flock ($fp,LOCK_EX);
for ($i=0; $i< sizeof($file); $i++) { $dt=explode("|",$file[$i]); if ($dt[1]==$id) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);


Header("Location: admin.php?fid=$fid&page=$page"); exit; } }





// Блок УДАЛЕНИЯ выбранного СООБЩЕНИЯ
if (isset($_GET['topicxd'])) { if ($_GET['topicxd'] !="") {
$fid=$_GET['fid']; $id=$_GET['id']; $topicxd=$_GET['topicxd']-1;
if (isset($_GET['page'])) $page=$_GET['page']; else $page="1";
$file=file("$datadir/$id.dat");
if (count($file)==1) exit("В ТЕМЕ должно остаться хотябы <B>одно сообщение!</B>");
$fp=fopen("$datadir/$id.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) { if ($i==$topicxd) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);
$topicxd--;

$file=file("$datadir/$id.dat");
//переписываем автора последнего сообщения в теме
$dt=explode("|",$file[count($file)-1]); $avtor=$dt[0]; $data=$dt[5]; $time=$dt[6];


// Блок вычитает 1-цу из кол-ва сообщений на главной
$lines = file("$datadir/mainforum.dat"); $i=count($lines);
// находим по fid номер строки
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





// Добавление ФОРУМА / РАЗДЕЛА
if(isset($_GET['event'])) { if ($_GET['event'] =="addmainforum") {
$ftype=$_POST['ftype']; $zag=$_POST['zag']; $msg=$_POST['msg'];
if ($zag=="") exit("$back <B>и введите заголовок!</B>");

// пробегаем по файлу с номерами разделов/топиков - ищем наибольшее и добавляем +1
$nextnum="0";
if (is_file("$datadir/mainforum.dat")) { $lines=file("$datadir/mainforum.dat"); $imax = count($lines); $i=0; do {$dt = explode("|", $lines[$i]); if ($nextnum<$dt[0]) {$nextnum=$dt[0];} $i++; } while($i < $imax); $nextnum++;}

$zag=str_replace("|","I",$zag); $msg=str_replace("|","I",$msg);
if ($ftype == "") $txtmf="$nextnum|$zag|$msg||0|0||$date|$time||||||"; else $txtmf="$nextnum|$ftype|$zag|";
$txtmf=htmlspecialchars($txtmf); $txtmf=stripslashes($txtmf); $txtmf=str_replace("\r\n","<br>",$txtmf);

// запись данных на главную страницу
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$txtmf\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; }





// блок СОРТИРОВКИ УЧАСТНИКОВ
if(isset($_GET['event'])) { if ($_GET['event'] =="sortusers") { $kaksort=$_POST['kaksort']; $lines="";

// Считываем оба файла в память
$dat="$datadir/usersdat.php"; $dlines=file("$dat"); $di=count($dlines);
$stat="$datadir/userstat.dat"; $slines=file("$stat"); $si=count($slines);

$msguser=1000; // общее кол-во оставленных сообщений - надо считать!!!!

if ($di!=$si) exit("$back - Необходимо Пересчитать статистику участников!!! Файл стистики повреждён!!!");

for ($i=1;$i<$di;$i++) {
$dt=explode("|",$dlines[$i]);
$st=explode("|",$slines[$i]);

if ($dt[0]!=$st[0]) exit("$back необходимо Пересчитать статистику участников!!! Файл стистики повреждён!!!");
/* kaksort
1 - Имени $dt[0]
2 - Кол-ву сообщений $st[2]
3 - Кол-ву звёзд dt[2]
4 - Репутации $st[3]
5 - Дате регистрации $dt[4]
6 - Активности $dt[4]/$st[2]
*/
// при склеивании на первое место ставим нужный параметр
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

// Склеиваем два файла в одну переменную
$lines[$i].="$dt[0]|$dt[1]|$dt[2]|$dt[3]|$dt[4]|$dt[5]|$dt[6]|$dt[7]|$dt[8]|$dt[9]|$dt[10]|$dt[11]|$dt[12]|$dt[13]|$st[1]|$st[2]|$st[3]|$st[4]|$st[5]|||\r\n";

} // конец FOR

// сортируем массив
setlocale(LC_ALL,'ru_RU.CP1251'); // ! РАЗРЕШАЕМ РАБОТУ ФУНКЦИЙ, работающих с регистором и с РУССКИМИ БУКВАМИ
function prcmp ($a, $b) {if ($a==$b) return 0; if ($a<$b) return -1; return 1;} // Функция сортировки
usort($lines,"prcmp"); // сортируем дни по возрастанию

// разделяем на два массива и по очереди их сохраняем
$dlines=null; $dlines="<?die;?>\r\n"; $slines=null; $slines="ИМЯ_ЮЗЕРА|Тем|Сообщений|Репутация|Предупреждения Х/5|Когда последний раз меняли рейтинг в UNIX формате|||\r\n";

for ($i=0;$i<$di-1;$i++) {
$nt=explode("|",$lines[$i]);
$dlines.="$nt[1]|$nt[2]|$nt[3]|$nt[4]|$nt[5]|$nt[6]|$nt[7]|$nt[8]|$nt[9]|$nt[10]|$nt[11]|$nt[12]|$nt[13]|$nt[14]|||\r\n";
$slines.="$nt[1]|$nt[15]|$nt[16]|$nt[17]|$nt[18]|$nt[19]|||\r\n";
}

// запись данных
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





// Редактирование ФОРУМА / РАЗДЕЛА
if ($_GET['event'] =="frdmainforum") {
$nextnum=$_POST['nextnum'];
$frd=$_POST['frd'];
$ftype=$_POST['ftype'];
$zag=$_POST['zag'];
if ($zag=="") exit("$back <B>и введите заголовок!</B>");
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
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА 
for ($i=0;$i< sizeof($file);$i++) { if ($frd!=$i) fputs($fp,$file[$i]); else fputs($fp,"$txtmf\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php"); exit; }




if ($_GET['event'] =="rdtema") { // Выбрано редактирование ТЕМЫ
$rd=$_POST['rd']; // - номер ячейки, которую необходимо заменить
$fid=$_POST['fid']; $changefid=$_POST['changefid'];
if (isset($_GET['page'])) $page=$_GET['page']; else $page="0";

$name=$_POST['name']; $who=$_POST['who']; $email=$_POST['email'];
$zag=$_POST['zag']; $msg=$_POST['msg']; $datem=$_POST['datem'];
$timem=$_POST['timem']; $id=$_POST['id']; $timetk=$_POST['timetk'];
$status=$_POST['status']; $goto=$_POST['goto'];

if ($goto==1) $goto="admin.php?fid=$changefid"; else $goto="admin.php?fid=$fid&page=$page";

if ($zag=="") exit("$back <B>и введите ТЕМУ, она пустая!</B>");
$text="$name|$who|$email|$zag|$msg|$datem|$timem|$id|$status|$timetk|";
$text=htmlspecialchars($text); $text=stripslashes($text); $text=str_replace("\r\n","<br>",$text);


if ($changefid==$fid) { // Если рубрика остаётся тамже
$file=file("$datadir/topic$fid.dat");
$fp=fopen("$datadir/topic$fid.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА 
for ($i=0;$i<sizeof($file);$i++) { if ($rd!=$i) fputs($fp,$file[$i]); else fputs($fp,"$text\r\n"); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

} else { // если меняем рубрику теме

// $fid - текущий, а  $changefid - это новый фид топика.

// 1. создаём копию темы в новом топике

touch("$datadir/topic$changefid.dat");
$file=file("$datadir/topic$changefid.dat");
$kolvotem1=sizeof($file)+1; // кол-во тем для уточнения на главной
$fp=fopen("$datadir/topic$changefid.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

// 2. удаляем тему в текущем топике

touch("$datadir/topic$fid.dat");
$file=file("$datadir/topic$fid.dat");
$fp=fopen("$datadir/topic$fid.dat","w+");
$kolvotem2=sizeof($file)-1; // кол-во тем для уточнения на главной
flock ($fp,LOCK_EX); 
for ($i=0;$i< sizeof($file);$i++) { if ($i==$rd) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);

// 3. запускаем пересчёт по типу как в доске объявлений

// ДОДЕЛАТЬ в следующей версии!!!
// СЛЕДУЮЩИЕ два блока объединить в один. Сделать переход по массиву,
// корректирование и копирование данных в новый массив
// и последующая его запись в файл mainforum.dat

// Блок вычитает 1-цу из кол-ва тем и вычитает кол-во сообщений
$file=file("$datadir/$id.dat"); $minmsg=count($file);
$lines=file("$datadir/mainforum.dat"); $i=count($lines);
// находим по $changefid номер строки

for ($ii=0;$ii< sizeof($lines);$ii++) { $kdt=explode("|",$lines[$ii]); if ($kdt[0]==$fid) $mnumer=$ii; }
$dt=explode("|",$lines[$mnumer]);
$dt[5]=$dt[5]-$minmsg;
if ($kolvotem2=="0") $dt[5]="0";
if ($dt[5]<0) $dt[5]="0";
if ($dt[4]<0) $dt[4]="0";
// если удаляемая тема стоит на главной как последняя, то удаляем её с главной
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

// Блок прибавляет 1-цу к кол-ву тем и добавляет кол-во сообщений
for ($ii=0;$ii< sizeof($lines);$ii++) { $kdt=explode("|",$lines[$ii]); if ($kdt[0]==$changefid) $mnumer=$ii; }
$dt=explode("|",$lines[$mnumer]);
$dt[5]=$dt[5]+$minmsg;
if ($kolvotem1=="0") $dt[5]="0";
if ($dt[5]<0) $dt[5]="0";
if ($dt[4]<0) $dt[4]="0";
// если удаляемая тема стоит на главной как последняя, то удаляем её с главной
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

// 4. смотрим news.dat. Если есть удаляем нафиг (удаляем объявление из 10-КИ последних)

$file=file("$datadir/news.dat");
$fp=fopen("$datadir/news.dat","w");
flock ($fp,LOCK_EX);
for ($i=0; $i< sizeof($file); $i++) {
$dt=explode("|",$file[$i]); if ($dt[1]==$id) unset($file[$i]); }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: $goto"); exit; }


// Заносим новое название рубрики в каждую строку файла с сообщениями
$linesrdt=file("$datadir/$id.dat");
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ
for ($i=0;$i< sizeof($linesrdt);$i++) {$drdt=explode("|", $linesrdt[$i]); $text1="$drdt[0]|$drdt[1]|$drdt[2]|$zag|$drdt[4]|$drdt[5]|$drdt[6]|$drdt[7]|$drdt[8]|$drdt[9]|"; $text1=str_replace("\r\n", "", $text1); fputs($fp,"$text1\r\n");}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
// если нужно заVIPить тему - прибавляем её ещё 2 года к сегодняшнему дню
if ($_POST['viptema']==="1") { $viptime=strtotime("+2 year"); touch("$datadir/$id.dat",$viptime);}
Header("Location: $goto"); exit; }


} // if $event==rdtema












// ДОБАВЛЕНИЕ ТЕМЫ или ОТВЕТА - ШАГ 1
if(isset($_GET['event'])) {
if (($_GET['event']=="addtopic") or ($_GET['event']=="addanswer")) {
if (isset($_POST['name'])) $name=$_POST['name'];
$name=trim($name); // Вырезает ПРОБЕЛьные символы 
$zag=$_POST['zag']; $msg=$_POST['msg']; $fid=$_GET['fid'];
if (isset($_POST['who'])) $who=$_POST['who']; else $who="";
if (isset($_POST['email'])) $email=$_POST['email']; else $email="";
if (isset($_POST['page'])) $page=$_POST['page'];
if ($_GET['event']=="addanswer") $id=$_POST['id'];
$maxzd=$_POST['maxzd']; if (!ctype_digit($maxzd) or strlen($maxzd)>2) exit("<B>$back. Попытка взлома. Хакерам здесь не место.</B>");

// защита по топику fid
if (!ctype_digit($fid) or strlen($fid)>2) exit("<B>$back. Попытка взлома. Хакерам здесь не место.</B>");

// проходим по всем разделам и топикам - ищем запращиваемый
// на тот случай, если mainforum.dat - пуст, подключаем резервную копию

$realbase="1"; if (is_file("$datadir/mainforum.dat")) $mainlines=file("$datadir/mainforum.dat");
if (!isset($mainlines)) $datasize=0; else $datasize=sizeof($mainlines);
if ($datasize<=0) {if (is_file("$datadir/copy.dat")) {$realbase="0"; $mainlines=file("$datadir/copy.dat"); $datasize=sizeof($mainlines);}}
if ($datasize<=0) exit("$back. Проблемы с Базой данных - обратитесь к администратору");
$i=count($mainlines);

$realfid=null;
do {$i--; $dt=explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$realfid=$i; if ($dt[1]=="razdel") exit("$back. Попытка взлома.");} // присваиваем $realfid - № п/п строки
} while($i>0);

if (!isset($realfid)) exit("$back. Ошибка с номером рубрики. Она не существует в базе.");

$dt=explode("|",$mainlines[$realfid]);
if (is_file("$datadir/topic$fid.dat")) {$tlines=file("$datadir/topic$fid.dat"); $tc=count($tlines)-2; $i=$tc+2; $ok=null;
// нужно пробежаться по топику, найти тему. Если есть - нормуль, нету - значит добавление сообщений ЗАПРЕЩЕНО!
if ($_GET['event']=="addanswer") {
do {$i--; $tdt=explode("|", $tlines[$i]);
if ($tdt[7]==$id) {$ok=1; if ($tdt[8]=="closed") exit("$back тема закрыта и добавление сообщений запрещено!"); }
} while($i>0);
if ($ok!=1) exit("$back тема закрыта и добавление сообщений запрещено!"); }

} else $tc="2";
if ($dt[11]>0 and $tc>=$dt[11]) exit("$back. Превышено ограничение на кол-во допустимых тем в данной рубрике! Не более <B>$dt[11]</B> тем!");

// проверка Логина/Пароля юзера. Может он хакер, тогда облом ему

// Этап 1
if (isset($_COOKIE['wrfcookies'])) {
    $wrfc=$_COOKIE['wrfcookies']; $wrfc=htmlspecialchars($wrfc); $wrfc=stripslashes($wrfc);
    $wrfc=explode("|", $wrfc);  $wrfname=$wrfc[0]; $wrfpass=$wrfc[1];
} else {$who=""; unset($wrfname); unset($wrfpass);}

// Этап 2
if ($who=="да") {
if (isset($wrfname) & isset($wrfpass)) {
$lines=file("$datadir/usersdat.php"); $i=count($lines);
do {$i--; $rdt=explode("|", $lines[$i]);
   if (isset($rdt[1])) { $realname=strtolower($rdt[0]);
   if (strtolower($wrfname)===$realname & $wrfpass===$rdt[1]) $ok="$i"; }
} while($i > "1");
if (!isset($ok)) {setcookie("wrfcookies","",time()); exit("Ошибка при работе с КУКИ! <font color=red><B>Вы не сможете оставить сообщение, попробуйте подать его как гость.</B></font> Ваш логин и пароль не найдены в базе данных, попробуйте зайти на форум вновь. Если ошибка повторяется - обратитесь к администратору форума.");}
}}


if (!isset($name) || strlen($name) > $maxname || strlen($name) <1) exit("$back Ваше <B>ИМЯ пустое, или превышает $maxname</B> символов!</B></center>");
if (strlen(ltrim($zag))<3 || strlen($zag) > 200) exit("$back Слишком короткое название темы или <B>название превышает $maxzag</B> символов!</B></center>");
if (strlen(ltrim($msg))<2 || strlen($msg) > 10000) exit("$back Ваше <B>сообщение короткое или превышает $maxmsg</B> символов.</B></center>");
if (!preg_match('/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$/si',$email) and strlen($email)>30 and $email!="") exit("$back и введите корректный E-mail адрес!</B></center>");

// генерируем имя файлу с темой
if ($_GET['event'] =="addtopic") {$add=null; $z=null; do {$id=mt_rand(1000,9999); if ($fid<10) $add="0"; if (!is_file("$datadir/$add$fid$id.dat") and strlen($id)==4) {$z++;} } while ($z<1); $id="$add$fid$id";}
if ((!ctype_digit($id)) or (strlen($id)>15)) exit("<B>$back. Попытка взлома. $id должно быть числом. Хакерам здесь не место.</B>");
if (strlen(ltrim($zag))<3) exit("$back ! Ошибка в вводе данных заголовка!");

$tektime=time();
$name=wordwrap($name,30,' ',1); // разрываем длинные строки
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



// функция АНТИФЛУД здесь - повторное добавление сообщения/темы запрещено!
if (isset($tlines)) {
if ($tc<"-1") {$sdt[0]=null; $sdt[3]=null;} else {$last=$tlines[$tc+1]; $sdt=explode("|",$last);}

if ($_GET['event'] =="addtopic")  { // ЕСЛИ добавление ТЕМЫ: имя = имя в файле, тема = последняя тема в файле
if ($name==$sdt[0] and $exd[3]==$sdt[3]) exit("$back. Такая тема уже создана. Спамить на форуме запрещено!");

} else { // ЕСЛИ добавление сообщения: имя = имя в файле, сообщение = последнему сообщению в файле
if (is_file("$datadir/$id.dat")) {$linesn=file("$datadir/$id.dat"); $in=count($linesn)-1;
if ($in > 0) { $dtf=explode("|",$linesn[$in]);
if ($name==$dtf[0] and $exd[4]==$dtf[4]) exit("$back. Такое сообщение уже размещено в данной теме. Спамить на форуме запрещено!"); }
}
}} // if $event=="addtopic"



if(isset($_GET['topicrd'])) { // Выбрано редактирование СООБЩЕНИЯ
$topicrd = $_GET['topicrd']; // номер ячейки, которую необходимо заменить
$file=file("$datadir/$id.dat");
$fs=count($file)-1; $i="-1";

$timetek=time(); $timefile=filemtime("$datadir/$id.dat"); 
$timer=$timetek-$timefile; // узнаем сколько прошло времени (в секундах) 
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА 
do {$i++; if ($i==$topicrd) fputs($fp,"$text\r\n"); else fputs($fp,$file[$i]); } while($i < $fs);
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
if ($timer<0) {$viptime=strtotime("+2 year"); touch("$datadir/$id.dat",$viptime);}

Header("Location: admin.php?fid=$fid&id=$id&page=$page"); exit; }

print"<html><head><link rel='stylesheet' href='$fskin/style.css' type='text/css'></head><body>";

// ЕСЛИ введена команда АП, то меняем дату создания файла и тема самая первая будет
if ($_GET['event'] =="addanswer")  { //при ОТВЕТе В ТЕМЕ

// Проверяем, давно ли реактивировали тему
$timetek=time(); $timefile=filemtime("$datadir/$id.dat"); 
$timer=$timetek-$timefile; // узнаем сколько прошло времени (в секундах) 
// $timer<10 - 10 секунд защита от антифлуда
if ($smmsg=="ап!") {
if ($timer<10 and $timer>0) exit("$back тема была активна менее $timer секунд назад.");
touch("$datadir/$id.dat");
print "<script language='Javascript'>function reload() {location = \"admin.php?fid=$fid&id=$id&page=$page#m$in\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
Спасибо, <B>$name</B>, тема реактивирована.<BR><BR>Через несколько секунд Вы будете автоматически перемещены в текущую тему <BR><B>$zag</B>.<BR><BR>
<B><a href='admin.php?fid=$fid&id=$id&page=$page#m$in'>Нажмите здесь, если не хотите больше ждать</a></B></td></tr></table></td></tr></table></center></body></html>";
exit; }

if ($timer<10 and $timer>0) exit("$back тема была активна менее $timer секунд назад.");
}


$razdelname="";
if ($realbase=="1" and $maxzd<1) { // Если подключена рабочая база, а не копия
$lines=file("$datadir/mainforum.dat");
$dt=explode("|", $lines[$realfid]); $dt[5]++;
if ($_GET['event']=="addtopic") $dt[4]++;

// НЕ менять 4-е строки пусть как написано так и будет!
if (!isset($dt[11])) $dt[11]="100"; $dt[11]=str_replace("
", "<br>", $dt[11]);
if (!isset($dt[12])) $dt[12]=""; $dt[12]=str_replace("
", "<br>", $dt[12]);
$txtdat="$dt[0]|$dt[1]|$dt[2]|$id|$dt[4]|$dt[5]|$smname|$date|$time|$tektime|$smzag|$dt[11]|$dt[12]||";
$razdelname=$dt[1];
// запись данных на главную страницу
$fp=fopen("$datadir/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА
for ($i=0;$i<=(sizeof($lines)-1);$i++) { if ($i==$realfid) fputs($fp,"$txtdat\r\n"); else fputs($fp,$lines[$i]); }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
} // if ($realbase=="1")

if ($newmess=="1" and $maxzd<1) { // запись в отдельный файл нового сообщения
if (is_file("$datadir/topic$fid.dat")) $nlines=count(file("$datadir/topic$fid.dat")); else $nlines=1;

if (is_file("$datadir/$id.dat")) $nlines2=count(file("$datadir/$id.dat"))+1; else $nlines2=1;

$newmessfile="$datadir/news.dat";
$newlines=file("$newmessfile"); $ni=count($newlines)-1; $i2=0; $newlineexit="";

$nmsg=substr($msg,0,150); // образаем сообщение до 150 символов
$ntext="$fid|$id|$date|$time|$smname|$zag|$nmsg...|$nlines|$nlines2|$razdelname|$who||||";
$ntext=str_replace("
", "<br>", $ntext);

// Блок проверяет, есть ли уже новое сообщение в этой теме. Если есть - отсеивает. На выходе - массив без этой строки.
for ($i=0;$i<=$ni;$i++)
{ $ndt=explode("|",$newlines[$i]);
if (isset($ndt[1])) {if ($id!=$ndt[1]) {$newlineexit.="$newlines[$i]"; $i2++;}}
}
// Записываем свежее сообщение в массив и далее сохраняем его в файл
if ($maxzd<1) { // Если тема доступна для всех - нет ограничений по звёздам
if ($i2>0) { // Если есть такая тема, то пишем весь массив, иначе тока строку
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


// БЛОК добавляет +1 к репе и +1 к сообщению или +1 к кол-ву тем, созданных юзером

if (isset($_COOKIE['wrfcookies']) and (isset($ok))) {

$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1; $ulinenew="";

// Ищем юзера по имени в файле userstat.dat
for ($i=0;$i<=$ui;$i++) {$udt=explode("|",$ulines[$i]);
if ($udt[0]==$wrfname) {
$udt[3]++; $udt[2]++; if ($_GET['event']=="addtopic") $udt[1]++;
$ulines[$i]="$udt[0]|$udt[1]|$udt[2]|$udt[3]|$udt[4]|$udt[5]||||\r\n";}
$ulinenew.="$ulines[$i]";}
// Пишем данные в файл
$fp=fopen("$ufile","w");
flock ($fp,LOCK_EX);
fputs($fp,"$ulinenew");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

} // if isset($ok)



if ($_GET['event'] =="addtopic")  { // Добавление ТЕМЫ - запись данных
// Пишем В ТОПИК
$fp=fopen("$datadir/topic$fid.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

// Пишем В ТЕМУ
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

print "<script language='Javascript'>function reload() {location = \"admin.php?fid=$fid&id=$id\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
Спасибо, <B>$name</B>, за добавление темы!<BR><BR>Через несколько секунд Вы будете автоматически перемещены в созданную тему.<BR><BR>
<B><a href='admin.php?fid=$fid&id=$id'>Нажмите здесь, если не хотите больше ждать</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;
}



if ($_GET['event'] =="addanswer")  { //ОТВЕТ В ТЕМЕ - запись данных
$timetek=time(); $timefile=filemtime("$datadir/$id.dat"); 
$timer=$timetek-$timefile; // узнаем сколько прошло времени (в секундах) 
$fp=fopen("$datadir/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
if ($timer<0) {$viptime=strtotime("+2 year"); touch("$datadir/$id.dat",$viptime);}

$in=$in+2; $page=ceil($in/$qq); // расчитываем верную страницу и номер сообщения

print "<script language='Javascript'>function reload() {location = \"admin.php?fid=$fid&id=$id&page=$page#m$in\"}; setTimeout('reload()', 1500);</script>
<table width=100% height=80%><tr><td><table border=1 cellpadding=10 cellspacing=0 bordercolor=#224488 align=center valign=center width=60%><tr><td><center>
Спасибо, <B>$name</B>, Ваш ответ успешно добавлен.<BR><BR>Через несколько секунд Вы будете автоматически перемещены в текущую тему <BR><B>$zag</B>.<BR><BR>
<B><a href='admin.php?fid=$fid&id=$id&page=$page#m$in'>Нажмите здесь, если не хотите больше ждать</a></B></td></tr></table></td></tr></table></center></body></html>";
exit;
}











// Сделать копию БД
if ($_GET['event']=="makecopy")  {
if (is_file("$datadir/mainforum.dat")) $lines=file("$datadir/mainforum.dat");
if (!isset($lines)) $datasize=0; else $datasize=sizeof($lines);
if ($datasize<=0) exit("Проблемы с Базой данных - база повреждена. Размер = 0!");
if (copy("$datadir/mainforum.dat", "$datadir/copy.dat")) exit("<center><BR>Копия база данных создана.<BR><BR><h3>$back</h3></center>"); else exit("Ошибка создания копии БАЗЫ Данных. Попробуйте создать вручную файл copy.dat в папке $datadir и выставить ему права на ЗАПИСЬ - 666 или полные права 777 и повторите операцию создания копии!"); }

// Восстановить из копии БД
if ($_GET['event']=="restore")  {
if (is_file("$datadir/copy.dat")) $lines=file("$datadir/copy.dat");
if (!isset($lines)) $datasize=0; else $datasize=sizeof($lines);
if ($datasize<=0) exit("Проблемы с копией базы данных - она повреждена. Восстановление невозможно!");
if (copy("$datadir/copy.dat", "$datadir/mainforum.dat")) exit("<center><BR>БД восстановлена из копии.<BR><BR><h3>$back</h3></center>"); else exit("Ошибка восстановления из копии БАЗЫ Данных. Попробуйте вручную файлам copy.dat и mainforum.dat в папке $datadir выставить права на ЗАПИСЬ - 666 или полные права 777 и повторите операцию восстановления!"); }



// КОНФИГУРИРОВАНИЕ форума, шаг 2: сохранение данных
if ($_GET['event']=="config")  {

// обработка полей пароль админа/модератора
if (strlen($_POST['newpassword'])<1 or strlen($_POST['newmoderpass'])<1) exit("$back разрешается длина пароля МИНИМУМ 1 символ!");
if ($_POST['newpassword']!="скрыт") {$pass=trim($_POST['newpassword']); $_POST['password']=md5("$pass+$skey");}
if ($_POST['newmoderpass']!="скрыт") {$pass=trim($_POST['newmoderpass']); $_POST['moderpass']=md5("$pass+$skey");}

// защита от дурака. Дожились, уже в админке защиту приходится ставить...
$fd=stripslashes($_POST['fdesription']); $fd=str_replace("\\","/",$fd); $fd=str_replace("?>","? >",$fd); $fd=str_replace("\"","'",$fd); $fdesription=str_replace("\r\n","<br>",$fd);

mt_srand(time()+(double)microtime()*1000000); $rand_key=mt_rand(1000,9999); // Генерируем случайное число для цифрозащиты

$gmttime=($_POST['deltahour'] * 60 * 60);  // Считаем смещение

$newsmiles=$_POST['newsmiles'];

$i=count($newsmiles); $smiles="array(";
for($k=0; $k<$i; $k=$k+2) {
  $j=$k+1; $s1=replacer($newsmiles[$k]); $s2=replacer($newsmiles[$j]);
  $smiles.="\"$s1\", \"$s2\""; if ($k!=($i-2)) $smiles.=",";
} $smiles.=");";

$configdata="<? // WR-forum v 1.9.3  //  10.06.10 г.  //  Miha-ingener@yandex.ru\r\n".
"$"."fname=\"".$_POST['fname']."\"; // Название форума показывается в теге TITLE и заголовке\r\n".
"$"."fdesription=\"".$fdesription."\"; // Краткое описание форума\r\n".
"$"."password=\"".$_POST['password']."\"; // Пароль админа защифрован md5()\r\n".
"$"."moderpass=\"".$_POST['moderpass']."\"; // Пароль модератора защифрован md5()\r\n".
"$"."adminemail=\"".$_POST['newadminemail']."\"; // Е-майл администратора\r\n".
"$"."sendmail=\"".$_POST['sendmail']."\"; // Включить отправку сообщений? 1/0\r\n".
"$"."sendadmin=\"".$_POST['sendadmin']."\"; // Мылить админу сообщения зареганных пользователей? 1/0\r\n".
"$"."statistika=\"".$_POST['statistika']."\"; // Показывать статистику на главной странице? 1/0\r\n".
"$"."antispam=\"".$_POST['antispam']."\"; // Задействовать АНТИСПАМ\r\n".
"$"."max_key=\"".$_POST['max_key']."\"; // Кол-во символов в коде ЦИФРОЗАЩИТЫ\r\n".
"$"."absrand=\"".$rand_key."\"; // Случайное число для цифрозащиты\r\n".
"$"."newmess=\"".$_POST['newmess']."\"; // Создавать файл с новыми сообщениями форума?\r\n".
"$"."guest=\"".$_POST['newguest']."\"; // Как называем не зарег-ся пользователей\r\n".
"$"."users=\"".$_POST['newusers']."\"; // Как называем зарег-ся\r\n".
"$"."cangutema=\"".$_POST['cangutema']."\"; // Разрешить гостям создавать темы? 1/0\r\n".
"$"."cangumsg=\"".$_POST['cangumsg']."\"; // Разрешить гостям оставлять сообщения? 1/0\r\n".
"$"."useactkey=\"".$_POST['useactkey']."\"; // Требовать активации через емайл при регистрации? 1/0\r\n".
"$"."maxname=\"".$_POST['newmaxname']."\"; // Максимальное кол-во символов в имени\r\n".
"$"."maxzag=\"".$_POST['maxzag']."\"; // Масимальный кол-во символов в заголовке темы\r\n".
"$"."maxmsg=\"".$_POST['newmaxmsg']."\"; // Максимальное количество символов в сообщении\r\n".
"$"."qqmain=\"".$_POST['newqqmain']."\"; // Кол-во отображаемых тем на страницу (15)\r\n".
"$"."qq=\"".$_POST['newqq']."\"; // Кол-во отображаемых сообщений на каждой странице (10)\r\n".
"$"."uq=\"".$_POST['uq']."\"; // По сколько человек выводить список участников\r\n".
"$"."liteurl=\"".$_POST['liteurl']."\";// Подсвечивать УРЛ? 1/0\r\n".
"$"."max_file_size=\"".$_POST['max_file_size']."\"; // Максимальный размер аватара в байтах\r\n".
"$"."datadir=\"".$_POST['datadir']."\"; // Папка с данными форума\r\n".
"$"."smile=\"".$_POST['smile']."\";// Включить/отключить графические смайлы\r\n".
"$"."canupfile=\"".$_POST['canupfile']."\"; // Разрешить загрузку фото 0 - нет, 1 - только зарегистрированным\r\n".
"$"."filedir=\"".$_POST['filedir']."\"; // Каталог куда будет закачан файл\r\n".
"$"."max_upfile_size=\"".$_POST['max_upfile_size']."\"; // максимальный размер файла в байтах\r\n".
"$"."fskin=\"".$_POST['fskin']."\"; // Текущий скин форума\r\n".
"$"."back=\"<html><head><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'><meta http-equiv='Content-Language' content='ru'></head><body><center>Вернитесь <a href='javascript:history.back(1)'><B>назад</B></a>\"; // Удобная строка\r\n".
"$"."smiles=".$smiles."// СМАЙЛИКИ (имя файла, символ для вставки, -//-)\r\n".
"$"."date=date(\"d.m.Y\", time()+$gmttime); // число.месяц.год\r\n".
"$"."deltahour=\"".$_POST['deltahour']."\"; // Учитываем кол-во часов со смещением относительно хостинга по формуле: ЧЧ * 3600\r\n".
"$"."time=date(\"H:i:s\",time()+$gmttime); // часы:минуты:секунды\r\n?>";
$file=file("config.php");
$fp=fopen("config.php","a+");
flock ($fp,LOCK_EX); 
ftruncate ($fp,0);//УДАЛЯЕМ СОДЕРЖИМОЕ ФАЙЛА 
fputs($fp,$configdata);
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
Header("Location: admin.php?event=configure"); exit;}


} // конец if isset($event)




// шапка для всех страниц форума

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
if ($datasize<=0) exit("<center><h3>Файл РУБРИК несуществует! создайте рубрики!</h3>");

// Блок выводит в статусной строке: ТЕМА -> РАЗДЕЛ -> ФОРУМ
if (isset($_GET['fid'])) { $fid=$_GET['fid'];
if (!ctype_digit($fid) or strlen($fid)>2) exit("<B>$back. Попытка взлома. Хакерам здесь не место.</B>");
$imax=count($mainlines); $i=count($mainlines);
// проходим по всем разделам и топикам - ищем запращиваемый
$raz=""; $rfid=""; $frname=""; do {$i--; $dt=explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$rfid=$i; $raz="$dt[1]"; $frname="$dt[1]"; if (isset($dt[11])) { if($dt[11]>0) $maxtem=$dt[11]; else $maxtem="100"; }}
} while($i >0);


if (isset($_GET['id'])) { $id=$_GET['id'];
if (!ctype_digit($id) or strlen($id)>15) exit("<B>$back. Попытка взлома. Хакерам здесь не место.</B>");
if (is_file("$datadir/$id.dat")) {
 $lines=file("$datadir/$id.dat");
  if (count($lines)>4) {$dtt=explode("|",$lines[0]); $frtname=$dtt[3];} else $frtname="";
 $ft=$frname; $frname="-> $ft ->";} else {$frtname=""; $frname="";}} else {$frtname="";  $frname.="->";} } else {$frname=""; $frtname="";}



 
 


// Админ или модер - задаём переменные ,которые потом будем использовать
if ($gbname==$adminname[0]) $ktotut="1"; else $ktotut="2";


// печатаем ВЕРХУШКУ форума если есть файл
?>
<html>
<head>
<title>Админка :: <?print"$frtname $frname $fname";?></title>
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
<br><div align=center>Вы вошли как <B><font color=red><?print"$gbname";?></font></B></td>
<td align="center" valign="middle"><span class="maintitle"><a href=admin.php><h3><font color=red>Панель администрирования<br></font> <?=$fname?></h3></a></span>
<table width=80%><TR><TD align=center><span class="gen"><?=$fdesription?><br><br></span></TD></TR></TABLE>
<table cellspacing=0 cellpadding=2><tr><td align=center valign=middle>
<a href='admin.php?event=makecopy' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" alt="" hspace="3" />Сделать копию БД</a> 
<a href='admin.php?event=restore' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" alt="" hspace="3" />Восстановить из копии</a> 
<a href='admin.php?event=userwho' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width=12 height=13 border=0 hspace=3 />Участники</a>
<a href='admin.php?event=massmail' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" hspace="3" />Рассылка сообщений участникам</a>
<a href='admin.php?event=revolushion' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" hspace="3" />Пересчитать</a>
<a href='admin.php?newstatistik' class=mainmenu><img src="<?=$fskin?>/buttons_spacer.gif" width="12" height="13" border="0" hspace="3" />Пересчитать статистику участников</a>

<? if ($ktotut==1) print"<a href='admin.php?event=configure' class=mainmenu><img src='$fskin/buttons_spacer.gif' width='12' height='13' border='0' alt='' hspace='3' />Настройки</a>";
print"<a href='admin.php?event=clearcooke' class=mainmenu><img src='$fskin/buttons_spacer.gif' width='12' height='13' border='0' alt='Поиск' hspace='3'>Выход из админки</a>";

// читаем файл с именами пользователей в память чтобы показать последнего
$userlines=file("$datadir/usersdat.php");
$ui=count($userlines)-1;
$tdt = explode("|", $userlines[$ui]);

if (is_file("$datadir/copy.dat")) {
if (count(file("$datadir/copy.dat"))<1) $a2="<font color=red size=+1>НО файл копии ПУСТ! Срочно пересоздайте!</font><br> (смотрите права доступа, если эо сообщение повторяется)"; else $a2="";
$a1=round((mktime()-filemtime("$datadir/copy.dat"))/86400); if ($a1<1) $a1="сегодня</font>, это есть гуд!"; else $a1.="</font> дней назад.";
$add="<br><B><center>Копия была создана <font color=red size=+1>".$a1." $a2</B>"; if ($a1>90) $add.="Да уж, больше 3-х месяцев ниодной копии не делали. Испытываете судьбу? Делайте БЕГОМ!"; if ($a1>10) $add.="Вы что! СРОЧНО делайте копию! А вдруг сбой? Как будете данные восстанавливать?!!"; if ($a1>5) $add.="Пора делать копию. Берегите свои нервы. Чтобы быть спокойным при сбое ;-)"; $add.="</center>";} else $add="";

print"</span>
</td></tr></table>
</td></tr></table>
$add<table width=100% cellspacing=0 cellpadding=2>
<tr><td><span class=gensmall>Сегодня: $date - $time</td></tr></table>";






// выводим ГЛАВНУЮ СТРАНИЦУ ФОРУМА
if (!isset($_GET['event']))  {

if (!isset($_GET['fid'])) {
echo'
<table width=100% cellpadding=2 cellspacing=1 class=forumline>
<tr><th width=60% colspan=2 class=thCornerL height=25 nowrap=nowrap>Форумы</th>
<th width=10% class=thTop nowrap=nowrap>Тем</th>
<th width=7% class=thCornerR nowrap=nowrap>Ответов</th>
<th width=28% class=thCornerR nowrap=nowrap>Обновление</th></tr>';

// Выводим qq сообщений на текущей странице

$addform="<form action='admin.php?event=addmainforum' method=post name=REPLIER1><table width=100% cellpadding=4 cellspacing=1 class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>Добавление Раздела / Форума</span></td></tr><tr><td class=row1 align=right><b><span class=gensmall>Тип добавляемого пункта</span></b></td><td class=row1><input type=radio name=ftype value='razdel'> Раздел &nbsp;&nbsp;<input type=radio name=ftype value=''checked> Форум</tr></td><tr><td class=row1 align=right valign=top><span class=gensmall><B>Заголовок</B></td><td class=row1 align=left valign=middle><input type=text  class=post value='' name=zag size=70></td></tr><tr><td class=row1 align=right valign=top><span class=gensmall>Описание</td><td class=row1 align=left valign=middle><textarea cols=100 rows=6 size=500 class=post name=msg></textarea></td></tr><tr><td class=row1 colspan=2><center><input type=submit class=mainoption value='     Добавить     '></td></span></tr></table></form>";

if (!is_file("$datadir/mainforum.dat")) exit("<h3>Восстановите БД из копии. Файл mainforum.dat несуществует или добавьте форум/раздел.</h3>$addform"); 

$lines = file("$datadir/mainforum.dat"); $datasize = sizeof($lines);

if ($datasize==0) exit("<h3>Файл mainforum.dat пуст - добавьте форум или раздел.</h3>$addform");

$i=count($lines);
$n="0"; $a1="-1"; $u=$i-1;
$fid="0"; $itogotem="0"; $itogomsg="0";

do {$a1++; $dt = explode("|", $lines[$a1]);
$fid=$dt[0];


echo'<tr height=50><td class=row1>&nbsp;';

if ($ktotut==1) { // только админ может управлять разделами
print"<table>
<td width=10 bgcolor=#A6D2FF><B><a href='admin.php?movetopic=$a1&where=1' title='переместить ВВЕРХ'>Вв</a></B></td>
<td width=10 bgcolor=#DEB369><B><a href='admin.php?movetopic=$a1&where=0' title='переместить ВНИЗ'>Нз</a></B></td>
<td width=10 bgcolor=#22FF44><B><a href='admin.php?frd=$a1' title='РЕДАКТИРОВАТЬ'>.P.</a></B></td>
<td width=10 bgcolor=#FF2244><B><a href='admin.php?fxd=$a1' title='УДАЛИТЬ'>.X.</a></B></td>
</tr></table>"; }

echo'</td>';

// определяем тип: форум или заголовок
if ($dt[1]=="razdel") print "<td class=catLeft colspan=1><span class=cattitle><center>$dt[2]</td><td class=rowpic colspan=4 align=right>&nbsp;</td></tr>";

else {

if (is_file("$datadir/$dt[3].dat")) { $msgsize=sizeof(file("$datadir/$dt[3].dat")); // считаем кол-во страниц в файле
if ($msgsize>$qq) $page=ceil($msgsize/$qq); else $page=1; } else {$msgsize=""; $page=1;}

if ($dt[7]==$date) $dt[7]="сегодня";
$maxzvezd=null; if (isset($dt[12])) { if ($dt[12]>0) {$maxzvezd="*Доступна участникам, имеющим <font color=red><B>$dt[12]</B> звезд";
$dt[4]=""; $dt[5]="";
if ($dt[12]==1) $maxzvezd.="у";
if ($dt[12]==2 or $dt[12]==3 or $dt[12]==4) $maxzvezd.="ы"; $maxzvezd.=" минимум</font>";}}

print "
<td width=60% class=row1 valign=middle><span class=forumlink><a href=\"admin.php?fid=$fid\">$dt[1]</a> $maxzvezd<BR></span><small>$dt[2]</small></td>
<td width=7% class=row2 align=center><small>$dt[4] / $dt[11]</small></td>
<td width=7% class=row2 align=center valign=middle><small>$dt[5]</small></td>
<td width=28% class=row2 valign=middle><span class=gensmall>
тема: <a href=\"admin.php?fid=$fid&id=$dt[3]&page=$page#m$msgsize\">$dt[10]</a><BR>
автор: <B>$dt[6]</B><BR>
дата: <B>$dt[7]</B> - $dt[8]</span></td></tr>";

$itogotem=$itogotem+$dt[4]; $itogomsg=$itogomsg+$dt[5]; }
} while($a1 < $u);
echo'</table><BR>';

// Выбрано редактирование ФОРУМА
if (isset($_GET['frd'])) { if ($_GET['frd'] !="") { $frd=$_GET['frd'];
$lines = file("$datadir/mainforum.dat");
$dt = explode("|", $lines[$frd]);
if (isset($dt[11])) { if ($dt[11]>0) $addmax=$dt[11]; else $addmax="100"; }
if (isset($dt[12])) {if ($dt[12]<=0) $dt[12]="0";}
$dt[2]=str_replace("<br>","\r\n",$dt[2]);
print "<form action='admin.php?event=frdmainforum' method=post name=REPLIER1><table width=100% cellpadding=4 cellspacing=1 class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>Редактирование Раздела / Форума</span></td></tr>
<tr><td class=row1 align=right>Тип редактируемого пункта</td><td class=row1><input type=hidden name=nextnum value='$dt[0]'>";
if ($dt[1]=="razdel") print "<input type=hidden name=ftype value='razdel'>Раздел</tr></td><tr><td class=row1 align=right valign=top><span class=gensmall><B>Заголовок</B></td><td class=row1 align=left valign=middle><input type=text value='$dt[2]' name=zag size=70></td></tr>";
else {print "
<input type=hidden name=ftype value=''>Форум</tr></td><tr><td class=row1 align=right valign=top><B>Заголовок</B></td><td class=row1 align=left valign=middle><input class=post type=text value='$dt[1]' name=zag size=70></td></tr>
<tr><td class=row1 align=right valign=top>Описание</td><td class=row1 align=left valign=middle><textarea cols=80 rows=6 class=post size=500 name=msg>$dt[2]</textarea>
<input type=hidden name=idtemka value='$dt[3]'>
<input type=hidden name=kt value='$dt[4]'>
<input type=hidden name=km value='$dt[5]'>
<input type=hidden name=namem value='$dt[6]'>
<input type=hidden name=datem value='$dt[7]'>
<input type=hidden name=timem value='$dt[8]'>
<input type=hidden name=timetk value='$dt[9]'>
<input type=hidden name=temka value='$dt[10]'>
</td></tr>
<TR><TD align=right class=row1>Максимальное  кол-во тем в форуме</TD><TD class=row1><input type=text class=post name=addmax value='$addmax'></TD></TR>
<input type=hidden name=zvezdmax value='$dt[12]'>
<TR><TD align=right class=row1>Заблокировать по звёздам</TD><TD class=row1><input type=text class=post size=5 maxlength=1 name=zvezdmax value='$dt[12]'>
(ТОЛЬКО участники с указанным кол-вом звёзд могут обсуждать этот форум)</TD></TR>";}

print"<tr><td colspan=2 class=row1><input type=hidden name=frd value='$frd'><SCRIPT language=JavaScript>document.REPLIER1.zag.focus();</SCRIPT><center><input type=submit class=mainoption value='     Изменить     '></td></span></tr></table></form><BR>";
} } // Конец редактирования ФОРУМА

else { if ($ktotut==1) print "$addform"; }


if ($statistika=="1")  {
print"<table width=100% cellpadding=3 cellspacing=1 class=forumline><tr><td class=catHead colspan=2 height=28><span class=cattitle>Статистика</span></td></tr><tr>
<td class=row1 align=center valign=middle rowspan=2><img src=\"$fskin/whosonline.gif\"></td>
<td class=row1 align=left width=95%><span class=gensmall>Сообщений: <b>$itogomsg</b><br>Тем: <b>$itogotem</b><br>Всего зарегистрировано участников: <b><a href=\"tools.php?event=who\">$ui</a></b><br>Последним зарегистрировался: <a href=\"tools.php?event=profile&pname=$tdt[0]\">$tdt[0]</a></span></td>
</tr></table>"; 

// СТАТИСТИКА -= Последние сообщения с форума =-

if (is_file("$datadir/news.dat")) { $newmessfile="$datadir/news.dat";
$lines=file($newmessfile); $i=count($lines); //if ($i>10) $i=10; (РАСКОМЕНТИРУЙ - ВОТ ГДЕ СИЛА!!! ;-))
if ($i>1) {
echo('<br><table width=100% cellpadding=3 cellspacing=1 class=forumline><tr><td class=catHead colspan=2 height=28><span class=cattitle>Последние сообщения</span></td></tr><tr>
<td class=row1 align=center valign=middle rowspan=2><img src="'.$fskin.'/whosonline.gif"></td>
<td class=row1 align=left width=95%><span class=gensmall>');

$a1=$i-1;$u="-1"; // выводим данные по возрастанию или убыванию
do {$dt=explode("|", $lines[$a1]); $a1--;

if (isset($dt[1])) { // Если строчка потерялась в скрипте (пустая строка) - то просто её НЕ выводим
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
if ($dt[8]>$qq) $page=ceil($dt[8]/$qq); else $page=1; // Считаем страницу

if ($dt[10]=="да") {$codename=urlencode($dt[4]); $name="<B><a href='tools.php?event=profile&pname=$codename'>$dt[4]</a></B>";} else $name="гость $dt[4]";
print"$dt[2] - $dt[3]: <B><a href='admin.php?fid=$dt[0]'>$dt[9]</a></B> -> <B><a href='admin.php?fid=$dt[0]&id=$dt[1]&page=$page#m$dt[8]' title='$dt[6] \r\n\r\n Отправлено $dt[3], $dt[2] г.'>$dt[5]</a></B> - $name.<br>";
} // если строчка потерялась
$a11=$u; $u11=$a1;
} while($a11 < $u11);
echo'</span></td></tr></table>';}

} // Конец блока последних сообщений
}

} // конец главной страницы









// выводим страницу С ТЕМАМИ выбранной РУБРИКИ
if (isset($_GET['fid']) and !isset($_GET['id'])) { $fid=$_GET['fid'];


$maxzd=null; // Уточняем статус по кол-ву ЗВЁЗД в теме
do {$imax--; $ddt=explode("|", $mainlines[$imax]); if ($ddt[0]==$fid) $maxzd=$ddt[12]; } while($imax>"0");
if (!ctype_digit($maxzd)) $maxzd=0;

print "
<table><tr><td><span class=nav>&nbsp;&nbsp;&nbsp;<a href=admin.php class=nav>$fname</a> -> <a href=admin.php?fid=$fid class=nav>$frname</a></span></td></tr></table>
<table width=100% cellpadding=2 cellspacing=1 class=forumline><tr>
<th width=3% class=thCornerL height=25 nowrap=nowrap>X/P</th>
<th width=57% colspan=2 class=thCornerL height=25 nowrap=nowrap>Тема</th>
<th width=10% class=thTop nowrap=nowrap>Cообщений</th>
<th width=12% class=thCornerR nowrap=nowrap>Автор</th>
<th width=18% class=thCornerR nowrap=nowrap>Обновления</th></tr>";

$addbutton="<table width=100%><tr><td align=left valign=middle><span class=nav><a href=\"admin.php?fid=$fid&newtema=add\"><img src='$fskin/newthread.gif' border=0></a>&nbsp;</span></td>";


// определяем есть ли информация в файле с данными
if (is_file("$datadir/topic$fid.dat"))
{
$msglines=file("$datadir/topic$fid.dat");
if (count($msglines)>0) {

if (count($msglines)>$maxtem-1) $addbutton="<table width=100%><TR><TD>Количество допустимых тем в рубрике исчерпано.";

// Выводим qqmain сообщений на текущей странице
$lines=file("$datadir/topic$fid.dat");
$i=count($lines); $maxi=count($lines)-1; $n="0";

// Исключаем ошибку вызова несуществующей страницы
if (!isset($_GET['page'])) $page=1; else { $page=$_GET['page']; if (!ctype_digit($page)) $page=1; if ($page<1) $page=1; }


// Показываем QQ ТЕМ
$fm=$maxi-$qq*($page-1); if ($fm<"0") $fm=$qq;
$lm=$fm-$qq; if ($lm<"0") $lm="-1";

$timetek=time();

do {$dt=explode("|", $lines[$fm]);

// нужно для определения темы на VIP-статус
if (is_file("$datadir/$dt[7].dat")) $ftime=filemtime("$datadir/$dt[7].dat"); else $ftime="";
$timer=$timetek-$ftime; // узнаем сколько прошло времени (в секундах) 

$fm--; $num=$fm+2; $numid=$fm+1;

$filename=$dt[7]; if (is_file("$datadir/$filename.dat")) { // если файл с темой существует - то показать тему
$msgsize=sizeof(file("$datadir/$filename.dat"));

// --------- Выделяем новые сообщения
$linetmp=file("$datadir/$filename.dat"); if (sizeof($linetmp)!=0) {
$pos=$msgsize-1; $dtt=explode("|", $linetmp[$pos]);
$foldicon="folder.gif";
// Если последнее сообщение в форуме произошло раньше посещения - значит раздел форума - новый
if (isset($wrfname)) {if (isset($dtt[9])) {if ($dtt[9]>$wrftime2) $foldicon="foldernew.gif";}}
if (strlen($dt[8])>1 and $dt[8]=="closed") {if ($msgsize<"20") $foldicon="close.gif"; else $foldicon="closed.gif"; }} else $foldicon="foldernew.gif";
// --------- Конец

print "<tr height=50>
<td width=3% class=row1><table><tr><td width=10 bgcolor=#22FF44><B><a href='admin.php?fid=$fid&rd=$numid&page=$page' title='РЕДАКТИРОВАТЬ'>.P.</a></B></td></tr><tr><td width=10 bgcolor=#FF2244><B><a href='admin.php?fid=$fid&xd=$numid&id=$dt[7]&page=$page' title='УДАЛИТЬ'>.X.</a></B></td></tr></table></td>
<td width=3% class=row1 align=center valign=middle><img src=\"$fskin/$foldicon\" border=0></td>
<td width=57% class=row1 valign=middle><span class=forumlink><b>";

if ($timer<0) echo'<font color=red>VIP </font>';

print"<a href=\"admin.php?fid=$fid&id=$dt[7]\">$dt[3]</a>";

if ($msgsize>$qq) { // выводим список доступных страниц
echo'</b></span><BR><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Страницы: <B>';

// Считаем и отображаем страницы в темах
$maxit=count($linetmp)-1; $maxpaget=ceil(($maxit+1)/$qq);
if ($maxpaget<=5) $f1=$maxpaget; else $f1=5;
for($i=1; $i<=$f1; $i++) print "<a href=admin.php?fid=$fid&id=$dt[7]&page=$i>$i</a> &nbsp;";
if ($maxpaget>5) print "... <a href=admin.php?fid=$fid&id=$dt[7]&page=$maxpaget>$maxpaget</a>";
echo'</B>'; }


print"</span></td><td width=10% class=row2 align=center>$msgsize</td>
<td width=10% class=row2 align=center><span class=gensmall>";


$codename=urlencode($dt[0]);
if ($dt[1]=="да") print "<a href='tools.php?event=profile&pname=$codename':$dt[2]>$dt[0]</a><BR><small>$users</small>"; else  print"$dt[0]<BR><small>$guest</small>";


if ($msgsize>=2) {$linesdat=file("$datadir/$filename.dat"); $dtdat=explode("|", $linesdat[$msgsize-1]);
if (strlen($linesdat[$msgsize-1])>10) {$dt[0]=$dtdat[0]; $dt[1]=$dtdat[1]; $dt[2]=$dtdat[2]; $dt[5]=$dtdat[5]; $dt[6]=$dtdat[6];}} // защита if (strlen...) только если файл есть и имеет верный формат - выводим

$dt[6]=substr($dt[6],0,-3);
if ($dt[5]===$date) $dt[5]="<B>сегодня</B>";
print "</span></td><td width=15% height=50 class=row2 align=left valign=middle nowrap=nowrap><span class=gensmall>&nbsp;
автор: $dt[0]<BR>&nbsp;
дата: $dt[5]<BR>&nbsp;
время: $dt[6]</font>
</td></tr>";
} //if (is_file)

} while($lm < $fm);


// выводим СПИСОК СТРАНИЦ
$lines=file("$datadir/topic$fid.dat"); $maxi=count($lines)-1;
$maxpage=ceil(($maxi+1)/$qq); if ($page>$maxpage) $page=$maxpage;
print "<table width=100%><tr><td align=right colspan=3><span class=nav>Страницы:&nbsp; ";
if ($page>=4 and $maxpage>5) print "<a href=admin.php?fid=$fid&page=1>1</a> ... ";
$f1=$page+2; $f2=$page-2;
if ($page<=2) {$f1=5; $f2=1;} if ($page>=$maxpage-1) {$f1=$maxpage; $f2=$page-3;} if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) { if ($page==$i) print "<B>$i</B> &nbsp;"; else print "<a href=admin.php?fid=$fid&page=$i>$i</a> &nbsp;"; }
if ($page<=$maxpage-3 and $maxpage>5) print "... <a href=admin.php?fid=$fid&page=$maxpage>$maxpage</a>";
echo'</b></span></td></tr></table>';

}}



// ------------ Выбрано редактирование ТЕМЫ
if (isset($_GET['rd'])) { if ($_GET['rd'] !="")  { $rd=$_GET['rd']; $dt=explode("|", $lines[$rd]);

$moddate=filemtime("$datadir/$dt[7].dat"); $tektime=mktime();
if ($moddate<$tektime) {$vt1="checked"; $vt2="";} else {$vt2="checked"; $vt1="";}
if ($dt[8]=="closed") {$ct2="checked"; $ct1="";} else {$ct1="checked"; $ct2="";}

print "<form action='admin.php?event=rdtema&page=$page' method=post name=REPLIER1><table cellpadding=4 cellspacing=1 width=100% class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>Редактирование Темы</span></td></tr>
<tr><td class=row1 align=right valign=top>Название темы</td>
<td class=row1 align=left valign=top><input type=text class=post value='$dt[3]' name=zag size=70>
<input type=radio name=status value=''$ct1/> <font color=blue><B>открыта</B></font>&nbsp;&nbsp; <input type=radio name=status value='closed'$ct2/> <font color=red><B>закрыта</B></font>
<input type=hidden name=rd value='$rd'>
<input type=hidden name=name value='$dt[0]'>
<input type=hidden name=who value='$dt[1]'>
<input type=hidden name=email value='$dt[2]'>
<input type=hidden name=msg value=\"$dt[4]\"><!-- кавычки в коде только двойные!-->
<input type=hidden name=datem value='$dt[5]'>
<input type=hidden name=timem value='$dt[6]'>
<input type=hidden name=id value='$dt[7]'>
<input type=hidden name=timetk value='$dt[9]'>
<input type=hidden name=fid value='$fid'></TD></TR>

<tr><td class=row1 align=right valign=top>Переместить в другой раздел ?</TD><TD class=row1>
<select style='width=440' name='changefid'>
<option value='$fid'>Нет. Оставить в текущем</option><br><br>";

$mainlines=file("$datadir/mainforum.dat");
$mainsize=sizeof($mainlines); if($mainsize<1) exit("$back файл данных повреждён или у вас всего одна рубрика!");
$ii=count($mainlines); $cn=0; $i=0;
do {$mdt=explode("|", $mainlines[$i]);
if ($mdt[1]=="razdel") {if ($cn!=0) {echo'</optgroup>'; $cn=0;} $cn++; print"<optgroup label='$mdt[2]'>";}  else {print" <option value='$mdt[0]' >|-$mdt[1]</option>";}
$i++; } while($i <$ii);
$s2=""; $s1="checked"; // поменяйте и будет по умолчанию переход в новую рубрику
print"</optgroup></select>

<input type=radio name=viptema value='0'$vt1/> <font color=gray><B>обычная тема</B></font>&nbsp;&nbsp; <input type=radio name=viptema value='1'$vt2/> <font color=black><B>VIP-тема</B></font>

</TD></TR><tr><td class=row1 align=right valign=top>После переноса вернуться в какой раздел ?</TD><TD class=row1>
<input type=radio name=goto value='0'$s1> в текущую рубрику &nbsp;&nbsp; <input type=radio name=goto value='1'$s2> туда куда переносим тему
</td></tr><tr><td colspan=2 class=row1>
<SCRIPT language=JavaScript>document.REPLIER1.zag.focus();</SCRIPT><center><input type=submit class=mainoption value='     Изменить     '></td></span></tr></table></form>";
}

} else  {

print "<table width=100% cellpadding=4 cellspacing=1 class=forumline><tr> <td class=catHead colspan=2 height=28><span class=cattitle>Добавление темы</span></td></tr>
<tr><td class=row1 align=right valign=top rowspan=2><span class=gensmall>";

if (!isset($wrfname)) echo'<B>Имя</B> и E-mail<BR>';

print "<B>Заголовок темы</B><BR><B>Сообщение</B></td><td class=row1 align=left valign=middle rowspan=2>
<form action=\"admin.php?event=addtopic&fid=$fid\" method=post name=REPLIER>";
if (isset($wrfname)) {print "<input type=hidden name=name value='$wrfname' class=post><input type=hidden name=who value='да'>";}
else {print "<input type=text  value='' name=name size=23 class=post> <input type=text value='' name=email size=24 class=post><br>";}
print "
<input type=hidden name=maxzd value=$maxzd>
<input type=text class=post value='' name=zag size=50><br>
<textarea cols=100 rows=6 size=500 name=msg class=post></textarea><BR>
<BR><input type=submit class=mainoption value='     Добавить     '></td></form>
<SCRIPT language=JavaScript>document.REPLIER.msg.focus();</SCRIPT>
</span></tr></table><BR>";
}
// --------------

}
}







// выводим СООБЩЕНИЕ в текущей теме
if (isset($_GET['fid']) and isset($_GET['id'])) {$id=$_GET['id']; $fid=$_GET['fid'];

// определяем есть ли информация в файле с данными
if (!is_file("$datadir/$id.dat")) exit("<BR><BR>$back. Извините, но такой темы на форуме не существует.<BR> Скорее всего её удалил администратор.");
$lines=file("$datadir/$id.dat"); $mitogo=count($lines); $i=$mitogo; $maxi=$i-1;

if ($mitogo>0) { $tblstyle="row1"; $printvote=null;

// Считываем СТАТИСТИКУ ВСЕХ УЧАСТНИКОВ
if (is_file("$datadir/userstat.dat")) {$ufile="$datadir/userstat.dat"; $ulines=file("$ufile"); $ui=count($ulines)-1;}

// Ищем тему в topicХХ.dat - проверяем не закрыта ли тема?
$msglines=file("$datadir/topic$fid.dat"); $mg=count($msglines); $closed="no";
do {$mg--; $mt=explode("|",$msglines[$mg]);
if ($mt[7]==$id and $mt[8]=="closed") $closed="yes";
} while($mg > "0");

$maxzd=null; // Уточняем статус по кол-ву ЗВЁЗД в теме
do {$imax--; $ddt=explode("|", $mainlines[$imax]); if ($ddt[0]==$fid) $maxzd=$ddt[12]; } while($imax>"0");
if (!ctype_digit($maxzd)) $maxzd=0;

// Исключаем ошибку вызова несуществующей страницы
if (!isset($_GET['page'])) $page=1; else {$page=$_GET['page']; if (!ctype_digit($page)) $page=1; if ($page<1) $page=1;}

$fm=$qq*($page-1); if ($fm>$maxi) $fm=$maxi-$qq;
$lm=$fm+$qq; if ($lm>$maxi) $lm=$maxi+1;

do {$dt=explode("|", $lines[$fm]);

$fm++; $num=$maxi-$fm+2; $status=""; unset($youwr);

if (strlen($lines[$fm-1])>5) { // Если строчка потерялась в скрипте (пустая строка) - то просто её НЕ выводим

$msg=str_replace("[b]","<b>", $dt[4]);
$msg=str_replace("[/b]","</b>",$msg);
$msg=str_replace("[RB]","<font color=red><B>",$msg);
$msg=str_replace("[/RB]","</B></font>",$msg);
$msg=str_replace("[Quote]","<BR><fieldset align=center style='width:80%; color:#EE4422'><legend><B>Цитата:</B></legend>",$msg);
$msg=str_replace("[/Quote]","</fieldset><BR>",$msg);
$msg=str_replace("[Code]","<BR><fieldset align=center style='width:80%; color:#224488'><legend><B>Код:</B></legend>",$msg);
$msg=str_replace("[/Code]","</fieldset><BR>",$msg);

if ($smile==TRUE) {$i=count($smiles)-1; // заменяем текстовые смайлики на графические если разрешено
for($k=0; $k<$i; $k=$k+2) {$j=$k+1; $msg=str_replace("$smiles[$j]","<img src='smile/$smiles[$k].gif' border=0>",$msg);}}

$msg=str_replace("&lt;br&gt;","<br>",$msg);
$msg=preg_replace('#\[img(.*?)\](.+?)\[/img\]#','<img src="$2" border="0" $1>',$msg);
// Если разрешена публикация УРЛов
if ($liteurl==TRUE) $msg=preg_replace("#(\[url=([^\]]+)\](.*?)\[/url\])|(http://(www.)?[0-9a-z\.-]+\.[a-z]{2,6}[0-9a-z/\?=&\._-]*)#","<a href=\"$4\" >$4</a> ",$msg);


// считываем в память данные по пользователю
if ($dt[1]=="да")  {
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
<th class=thLeft width=150 height=26 nowrap=nowrap>Автор</th>
<th class=thRight nowrap=nowrap>Сообщение</th>"; $m1="1"; }

print"</tr><tr height=150><td class=$tblstyle valign=top><span class=name><BR><center>";


// Проверяем: это гость?
if (!isset($youwr)) {if (strlen($dt[2])>5) print "$dt[0] "; else print"$dt[0] ";
$kuda=$fm-1; print" <a href='javascript:%20x()' onclick=\"DoSmilie('[b]$dt[0][/b], ');\" class=nav>".chr(149)."</a><BR><br>
<a name='m$fm' href='#m$kuda' onclick=\"window.open('tools.php?event=mailto&email=$dt[2]&name=$dt[0]','email','width=520,height=300,left=170,top=100')\"><img src='$fskin/ico_pm.gif' border=0 alt='ЛС'></a><br><BR><small>$guest</small>";}


else {
$codename=urlencode($dt[0]);
print "<a name='m$fm' href='tools.php?event=profile&pname=$codename' class=nav>$dt[0]</a> <a href='javascript:%20x()' onclick=\"DoSmilie('[b]$dt[0][/b], ');\" class=nav>".chr(149)."</a><BR><BR><small>";
if (strlen($status)>2 & $dt[1]=="да" & isset($youwr)) print "$status"; else print"$users";
if (isset($reiting)) {if ($reiting>0) {echo'<BR>'; if (is_file("$fskin/star.gif")) {for ($ri=0;$ri<$reiting;$ri++) {print"<img src='$fskin/star.gif' border=0>";} } }}

if (isset($youavatar)) { if (is_file("avatars/$youavatar")) $avpr="$youavatar"; else $avpr="noavatar.gif";
print "<BR><BR><img src='avatars/$avpr'><BR> <!--
<a href='tools.php?event=profile&pname=$dt[0]'><img src='$fskin/profile.gif' alt='Профиль' border=0></a>
<a href='$site'><img src='$fskin/www.gif' alt='www' border=0></a><BR>
<a href='$icq'><img src='$fskin/icq.gif' alt='ICQ' border=0></a>
<a href='#' onclick=\"window.open('tools.php?event=mailto&email=$dt[3]&name=$dt[0]','email','width=520,height=300,left=170,top=100')\"><img src='$fskin/ico_pm.gif' alt='ЛС'></a>-->";}
} // isset($youwr)

if (isset($youwr) and is_file("$datadir/userstat.dat")) { // ТОЛЬКО участники видят всю репутацию! ;-)
if (isset($ulines[$userpn])) {
if (strlen($ulines[$userpn])>5) {
$ddu=explode("|",$ulines[$userpn]);
print"</small></span><br>
<div style='PADDING-LEFT: 17px' align=left class=gensmall>Тем создано: $ddu[1]<br>
Сообщений: $ddu[2]<br>
Репутация: $ddu[3] <A href='#' onclick=\"window.open('tools.php?event=repa&name=$dt[0]&who=$userpn','repa','width=500,height=190,left=100,top=100')\">-+</A><br>
Предупреждения: $ddu[4]<br></span>"; }}}

print "</span></td><td class=$tblstyle width=100% height=28 valign=top><table width=100% height=100%><tr valign=center><td><span class=postbody>$msg</span>";




//  БЛОК ГОЛОСОВАНИЯ - если есть то выводим!!!! *************************************

// Кнопка для добавления голосования

if ($printvote==null and !is_file("$datadir/$id-vote.dat")) {$printvote=1; print"<table><tr><td width=180 align=center bgcolor=#0080C0><B><a href='admin.php?fid=$fid&id=$id&vote=add'>.Добавить голосование.</a></B></td></tr></table>";}

if ($printvote==null) {$printvote=1; // Печатаем блок только один раз
if (is_file("$datadir/$id-vote.dat")) { $vlines=file("$datadir/$id-vote.dat");
if (sizeof($vlines)<1) exit("<center>Файл данных $id-vote.dat пуст!");
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

print "<INPUT name='id' type=hidden value='$id'><TR><TD colspan=3 align=center><INPUT type=submit value='проголосовать' onclick=\"window.open('vote.php','WRGolos','width=550,height=300,left=250,top=150,toolbar=0,status=0,border=0,scrollbars=0')\" border=0></TD></TR>

</FORM></TBODY></TABLE>

</TBODY></TABLE>

</TBODY></TABLE>

<TD align=right><table><tr><td width=10 bgcolor=#22FF44><B><a href='admin.php?fid=$fid&id=$id&vote=change' title='РЕДАКТИРОВАТЬ'>.P.</a></B></td><td width=10 bgcolor=#FF2244><B><a href='admin.php?fid=$fid&id=$id&vote=delete' title='УДАЛИТЬ'>.X.</a></B></td></tr></table></TD><TR>

</TD></TR></TABLE>";
}}



print"</td></tr>";


if (isset($youwr)) {if (strlen($youwr)>3) {print "<tr><td valign=bottom><span class=postbody>--------------------------------------------------<BR><small>$youwr</small>";}} // печатаем подпись участника

print"</td></tr></table></td></tr><tr>
<td class=row3 valign=middle align=center ><span class=postdetails>
<table><tr><td width=10 bgcolor=#22FF44><B><a href='admin.php?fid=$fid&id=$id&topicrd=$fm&page=$page#m$lm' title='РЕДАКТИРОВАТЬ'>.P.</a></B></td><td width=10 bgcolor=#FF2244><B><a href='admin.php?fid=$fid&id=$id&topicxd=$fm&page=$page' title='УДАЛИТЬ'>.X.</a></B></td></tr></table>
<I>Сообщение # <B>$fm.</B></I></span></td>
<td class=row3 width=100% height=28 nowrap=nowrap><span class=postdetails>Отправлено: <b>$dt[5]</b> - $dt[6]</span></td>
</tr><tr><td class=spaceRow colspan=2 height=1><img src=\"$fskin/spacer.gif\" width=1 height=1></td>";

} // если строчка потерялась

} while($fm < $lm);

echo'</tr></table>';


// выводим СПИСОК СТРАНИЦ
$maxpage=ceil(($maxi+1)/$qq); if ($page>$maxpage) $page=$maxpage;
echo'<table width=100%><tr><td align=center colspan=3><span class=nav>Страницы:&nbsp; ';
if ($page>=4 and $maxpage>5) print "<a href=admin.php?fid=$fid&id=$id&page=1>1</a> ... ";
$f1=$page+2; $f2=$page-2;
if ($page<=2) {$f1=5; $f2=1;} if ($page>=$maxpage-1) {$f1=$maxpage; $f2=$page-3;} if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) {if ($page==$i) print "<B>$i</B> &nbsp;"; else print "<a href=admin.php?fid=$fid&id=$id&page=$i>$i</a> &nbsp;";}
if ($page<=$maxpage-3 and $maxpage>5) print "... <a href=admin.php?fid=$fid&id=$id&page=$maxpage>$maxpage</a>";
echo'</span></td></tr></table>';



// Выбрана метка .P. - редактирование сообщения
if (isset($_GET['topicrd']))  { // выводим сообщение в форму
$topicrd=$_GET['topicrd']-1;
$lines=file("$datadir/$id.dat");
$dt=explode("|", $lines[$topicrd]);  
$dt[4]=str_replace("<br>", "\r\n", $dt[4]);
print "
<form action=\"admin.php?event=addanswer&fid=$fid&topicrd=$topicrd\" method=post name=REPLIER>
<table cellpadding=3 cellspacing=1 width=100% class=forumline>
<tr><th class=thHead colspan=2 height=25><b>Сообщение</b></th></tr>
<tr><td class=row1 width=22% height=25><span class=gen><b>Имя
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
<tr><th class=thHead colspan=2 height=25><b>Сообщение</b></th></tr>
<tr><td class=row1 width=22% height=25><span class=gen><b>Имя ";


if (!isset($wrfname)) echo'и E-mail<BR>';

echo'</b></span></td><td class=row2 width=78%> <span class=genmed>';

if (!isset($wrfname)) echo'<input type=text name=name size=28 class=post> <input type=text name=email size=30 class=post>';
else print "<b>$wrfname</b><input type=hidden name=name value='$wrfname'><input type=hidden name=who value='да'>";
}


print "</span></td></tr><tr>
<td class=row1 valign=top><span class=genmed><b>Сообщение</b><br><br>Для вставки имени, кликните на точку рядом с ним.<br><br>Смайлики:<br>
<table align=center width=100 height=70><tr><td valign=top>";

if ($smile==TRUE) {$i=count($smiles)-1;
for($k=0; $k<$i; $k=$k+2) {$j=$k+1; print"<A href='javascript:%20x()' onclick=\"DoSmilie(' $smiles[$j]');\"><img src='smile/$smiles[$k].gif' border=0></a> ";} }
print"<A href='javascript:%20x()' onclick=\"DoSmilie('[RB]  [/RB] ');\"><font color=red><B>RB</b></font></a>
<a name='add' href='#add' onclick=\"window.open('tools.php?event=moresmiles','smiles','width=250,height=300,left=50,top=150,toolbar=0,status=0,border=0,scrollbars=1')\">Ещё смайлы</a>
</tr></td></table></span></td>
<td class=row2 valign=top><span class=gen><table width=450><tr valign=middle><td><span class=genmed>
<input type=button class=button value=' B ' style='font-weight:bold; width: 30px' onclick=\"DoSmilie(' [b]  [/b] ');\">&nbsp;
<input type=button class=button value=' RB ' style='font-weight:bold; color:red' onclick=\"DoSmilie('[RB] [/RB]');\">&nbsp;
<INPUT type=button class=button value='Цитировать выделенное' style='width: 170px' onclick='REPLIER.msg.value += \"[Quote]\"+(window.getSelection?window.getSelection():document.selection.createRange().text)+\"[/Quote]\"'>&nbsp;
<input type=button class=button value=' Код ' onclick=\"DoSmilie(' [Code]  [/Code] ');\">&nbsp;
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
<tr><td class=catBottom colspan=2 align=center height=28><input type=submit tabindex=5 class=mainoption value='Изменить и сохранить'>&nbsp;&nbsp;&nbsp;<input type=reset tabindex=6 class=mainoption value=' Очистить '></td>
</tr></table></form>";

} else {

echo'<td colspan=9><span class=gen><textarea name=msg cols=103 rows=10 class=post></textarea></span></td>
</tr></table></span></td></tr><tr>
<td class=catBottom colspan=2 align=center height=28><input type=submit tabindex=5 class=mainoption value=" Отправить ">&nbsp;&nbsp;&nbsp;<input type=reset tabindex=6 class=mainoption value=" Очистить "></td>
</tr></table></form>';


$newvote="<br>
<table align=center border=0 class=forumline><form action='admin.php?event=voteadd&fid=$fid&id=$id' method=POST name=VOTE>
<tr><th class=thHead colspan=3 height=25><b>Cоздание нового голосования</b></th></tr>";
$i=0; $j=1; do {
if ($i==0) {$newvote.="<tr><td class=row1><B>Название голосования:</B></td><td class=row1 colspan=2><input maxlength=100 type=text value='' name=toper size=70 class=post></tr></td>";
} else {$newvote.="<TR>
<TD class=row$j align=right>$i ответ:</TD><TD class=row$j><input type=text value='' maxlength=70 name='otv$i' class=post size=63></B></TD>
<TD class=row$j><input type=text value='0' name='kolvo$i' class=post maxlength=4 size=4></TD></TR>";}
$i++; $j++; if ($j>2) $j=1;
} while($i<11);
$newvote.="
<TR><td class=catBottom colspan=3 align=center height=28><input type=hidden name=golositogo value='$i'><input class=mainoption type=submit value='Создать голосование'></TD></TR></table></form>
<br><div align=center>* оставьте поля пустыми, если хотите создать голосование с меньшим кол-вом ответов </div>";

echo $newvote;
}}

} // else if event !=""







if (isset($_GET['event'])) {


// КОНФИГУРИРОВАНИЕ форума - выбор настроек
if ($_GET['event']=="configure") {

if ($ktotut!=1) {exit("$back! Модераторам запрещено изменять настройки форума! Если нужно сменить пароль - обращайтесь к админу!");}

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

print "<center><B>Конфигурирование</b></font>
<form action=admin.php?event=config method=post name=REPLIER>
<table width=700 cellpadding=2 cellspacing=1 class=forumline><tr> 
<th class=thCornerL height=25 nowrap=nowrap>Параметр</th>
<th class=thTop nowrap=nowrap>Значение</th></tr>
<tr><td class=row1>Название форума</td><td class=row1><input type=text value='$fname' name=fname class=post maxlength=50 size=50></tr></td>
<tr><td class=row2 valign=top>Описание<BR><B><small>не рекомендую использовать HTML-теги.</small></td><td class=row2><textarea cols=50 rows=6 size=500 class=post name=fdesription>$fdesription</textarea></tr></td>
<tr><td class=row1>Е-майл администратора</td><td class=row1><input type=text value='$adminemail' class=post name=newadminemail maxlength=40 size=25></tr></td>
<tr><td class=row2>Пароль администратора / модератора *</td><td class=row1><input name=password type=hidden value='$password'><input class=post type=text value='скрыт' maxlength=10 name=newpassword size=15> &nbsp; .:. &nbsp; <input name=moderpass type=hidden value='$moderpass'><input class=post type=text value='скрыт' maxlength=10 name=newmoderpass size=15>(зашифрован и скрыт)</td></tr>

<tr><td class=row2>Включить отправку сообщений?</td><td class=row1><input type=radio name=sendmail value=\"1\"$s1/> да&nbsp;&nbsp; <input type=radio name=sendmail value=\"0\"$s2/> нет</tr></td>
<tr><td class=row1>Мылить админу сообщения и вновь зарегистрированных пользователей?</td><td class=row1><input type=radio name=sendadmin value=\"1\"$sa1/> да&nbsp;&nbsp; <input type=radio name=sendadmin value=\"0\"$sa2/> нет</tr></td>

<tr><td class=row2>Показывать статистику на главной странице?</td><td class=row1><input type=radio name=statistika value=\"1\"$st1/> да&nbsp;&nbsp; <input type=radio name=statistika value=\"0\"$st2/> нет</tr></td>
<tr><td class=row1>Создавать файл с новыми сообщениями?</td><td class=row1><input type=radio name=newmess value=\"1\"$n1/> да&nbsp;&nbsp; <input type=radio name=newmess value=\"0\"$n2/> нет</tr></td>
<tr><td class=row2>Макс. длина имени</td><td class=row1><input type=text value='$maxname' class=post name=newmaxname maxlength=2 size=10></tr></td>
<tr><td class=row1>Макс. длина заголовка темы</td><td class=row2><input type=text value='$maxzag' class=post name=maxzag maxlength=2 size=10></tr></td>
<tr><td class=row2>Макс. длина сообщения</td><td class=row1><input type=text value='$maxmsg' class=post maxlength=4 name=newmaxmsg size=10></tr></td>

<tr><td class=row1>Задействовать АНТИСПАМ / длина кода</td><td class=row2><input type=radio name=antispam value=\"1\"$as1/> да&nbsp;&nbsp; <input type=radio name=antispam value=\"0\"$as2/> нет &nbsp;&nbsp; .:. &nbsp;&nbsp; <input type=text class=post value='$max_key' name=max_key size=4 maxlength=1> (от 1 до 9) цифр</td></tr>

<tr><td class=row2>Тем / Cообщений / Участников на страницу</td><td class=row2><input type=text value='$qqmain' class=post maxlength=2 name=newqqmain size=11> &nbsp; .:. &nbsp; <input type=text value='$qq' class=post maxlength=2 name=newqq size=11> &nbsp; .:. &nbsp; <input type=text value='$uq' maxlength=2 class=post name=uq size=11></tr></td>
<tr><td class=row1>Как называть участников НЕ зареганых / зареганых</td><td class=row2><input type=text value='$guest' class=post maxlength=25 name=newguest size=22> &nbsp;/ &nbsp;<input type=text value='$users' class=post maxlength=25 name=newusers size=22></tr></td>
<tr><td class=row2>Требовать активации через емайл при регистрации?</td><td class=row1><input type=radio name=useactkey value=\"1\"$u1/> да&nbsp;&nbsp; <input type=radio name=useactkey value=\"0\"$u2/> нет</tr></td>
<tr><td class=row1>Создавать темы / Оставлять сообщения гостям можно?</td><td class=row1>Т: <input type=radio name=cangutema value=\"1\"$ct1/> да&nbsp;&nbsp; <input type=radio name=cangutema value=\"0\"$ct2/> нет .:. С: <input type=radio name=cangumsg value=\"1\"$cm1/> да&nbsp;&nbsp; <input type=radio name=cangumsg value=\"0\"$cm2/> нет </tr></td>
<tr><td class=row2>Делать ссылки в тексте <B>активными</B>?</td><td class=row1><input type=radio name=liteurl value=\"1\"$lu1/> да&nbsp;&nbsp; <input type=radio name=liteurl value=\"0\"$lu2/> нет</td></tr>
<tr><td class=row1>Включить / отключить графическеие смайлы?</td><td class=row1><input type=radio name=smile value=\"1\"$sm1/> включить &nbsp;&nbsp; <input type=radio name=smile value=\"0\"$sm2/> отключить</td></tr>

<tr><td class=row1>Смещение GMT относительно времени хостинга</td><td class=row1><input class=post type=text value='$deltahour' maxlength=2 name=deltahour size=15> (GMT + XX часов)</td></tr>

<tr><td class=row2>Папка с данными форума</td><td class=row1><input type=text value='$datadir' class=post maxlength=20 name='datadir' size=10> &nbsp;&nbsp; По умолчанию - <B>./data</B></td></tr>
<tr><td class=row1>Максимальный размер аватара в байтах</td><td class=row1><input type=text value='$max_file_size' class=post maxlength=6 name='max_file_size' size=10></td></tr>


<tr><td class=row1>Разрешить загрузку файлов</td><td class=row2><input type=radio name=canupfile value=\"1\"$cs1/> да, только зарегистрированным &nbsp;&nbsp; <input type=radio name=canupfile value=\"0\"$cs2/> нет </td></tr>

<tr><td class=row2>Папка для загрузки файлов</td><td class=row1><input type=text value='$filedir' class=post maxlength=20 name='filedir' size=10> &nbsp;&nbsp; По умолчанию - <B>./load</B></td></tr>
<tr><td class=row1>Максимальный размер файла в байтах</td><td class=row1><input type=text value='$max_upfile_size' class=post maxlength=6 name='max_upfile_size' size=10></td></tr>

<tr><td class=row2>Скин форума</td><td class=row1><select class=input name=fskin>";

$path = '.'; // Путь до папки. '.' - текущая папка
if ($handle = opendir($path)) {
while (($file = readdir($handle)) !== false)
if (is_dir($file)) { 
$stroka=stristr($file, "images"); if (strlen($stroka)>"6") 
{print "$stroka - str $file <BR>";
$tskin=str_replace("images", "Скин ", $file);
if ($fskin==$file) $marker="selected"; else $marker="";
print"<option $marker value=\"$file\">$tskin</option>";}
}
closedir($handle); } else echo'Ошибка!';

echo"</select></td></tr>

<tr><td class=row1>Смайлы (изображение и код)<br> - меняйте как хотите ***</td><td class=row1><table width=300><TR><TD>\r\n";
if (isset($smiles) and $smile==TRUE) {$i=count($smiles);
for($k=0; $k<$i; $k=$k+2) {
$j=$k+1; if ($k!=($i-1) and is_file("smile/$smiles[$k].gif"))
print"<img src='smile/$smiles[$k].gif' border=0> <input type=hidden name=newsmiles[$k] value='$smiles[$k]'><input type=text value='$smiles[$j]' maxlength=15 name=newsmiles[$j] size=5> \r\n"; } }


echo'</td></tr></table>
</td></tr><tr><td class=row1 colspan=2><BR><center><input type=submit class=mainoption value="Сохранить конфигурацию"></form></td></tr></table>
<center><br>* Если хотите изменить пароль - сотрите слово <B>"скрыт"</B> и введите новый пароль.<br> Рекомендую использовать только буквы и/или цифры.';
}






// ПРОСМОТР ВСЕХ УЧАСТНИКОВ форума
if ($_GET['event']=="userwho") {
$t1="row1"; $t2="row2"; $error=0;
$userlines=file("$datadir/usersdat.php");
$ui=count($userlines)-1;  $first=0; $last=$ui+1;

$statlines=file("$datadir/userstat.dat");
$si=count($statlines)-1;

$bada="<center><font color=red><B>В файле статистики имеются ошибки! ПЕРЕСЧИТАЙТЕ статистику участников!!!</B></font></center><br>";

if ($si!=$ui) print"$bada";

if (isset($_GET['page'])) $page=$_GET['page']; else $page="1";
if (!ctype_digit($page)) $page=1; // защита
if ($page=="0") $page="1"; else $page=abs($page); 
$maxpage=ceil(($ui+1)/$uq); if ($page>$maxpage) $page=$maxpage;

$i=1+$uq*($page-1); if ($i>$ui) $i=$ui-$uq;
  $lm=$i+$uq; if ($lm>$ui) $lm=$ui+1;

echo'<table width=100% valign=top cellpadding=1 cellspacing=0><TR><TD>

<table valign=top width=100% cellpadding=1 cellspacing=0 class=forumline><tr> 
<th class=thCornerL height=25 nowrap=nowrap>№</th>
<th class=thCornerL width=110>Имя</th>
<th class=thCornerR>Пол</th>
<th class=thTop>зарегистрирован</th>
<th class=thTop>Емайл</th>

<th class=thTop>Тем</th>
<th class=thTop>Сообщений</th>
<th class=thTop>Репутация</th>
<th class=thTop>Штрафы</th>

<th class=thTop>Статус / Изменить</th>
<th class=thTop>Звёзды</th></tr>';

$delblok="<FORM action='admin.php?usersdelete=$last&page=$page' method=POST name=delform>
<td colspan=8 class=$t1>
<table valign=top cellpadding=1 cellspacing=0 class=forumline width=25><th class=thCornerL>.X.</th>";

do {$tdt=explode("|",$userlines[$i]); $i++; $npp=$i-1;

if (isset($statlines[$i-1])) {$sdt=explode("|",$statlines[$i-1]);} else {$sdt[0]=""; $sdt[1]="-"; $sdt[2]="-"; $sdt[3]="-"; $sdt[4]="-";}
// Проверяем, если файл статистики повреждён - пишем сообщение о необходимости восстановить его
if ($sdt[0]!=$tdt[0]) {$error++; $sdt[1]="-"; $sdt[2]="-"; $sdt[3]="-"; $sdt[4]="-";}
if ($tdt[6]=="мужчина") $tdt[6]="<font color=blue>М</font>"; else $tdt[6]="<font color=red>Ж</font>";
if (strlen($tdt[13])<2) $tdt[13]=$users;

$delblok.="<TR height=35><td width=10 bgcolor=#FF6C6C><input type=checkbox name='del$npp' value=''"; if (isset($_GET['chekall'])) {$delblok.='CHECKED';} $delblok.="></td></TR>";
print"<tr height=35>
<td class=$t1>$npp</td>
<td class=$t1><B><a href=\"tools.php?event=profile&pname=$tdt[0]\">$tdt[0]</a></td>";
if (strlen($tdt[13])=="6" and ctype_digit($tdt[13])) {
print"<td class=$t1 colspan=9><B>[<a href='admin.php?event=activate&email=$tdt[3]&key=$tdt[13]&page=$page'>Активировать</a>]. Учётная запись не активирована  с $tdt[4]. </B>
(емайл: <B>$tdt[3]</B> ключ: <B>$tdt[13]</B>)"; 
} else {

//ИМЯ_ЮЗЕРА|Тем|Сообщений|Репутация|Предупреждения Х/5|Когда последний раз меняли рейтинг в UNIX формате|||

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
<div align=right><input type=hidden name=first value='$first'><input type=hidden name=last value='$last'><INPUT type=submit class=mainoption value='УДАЛИТЬ выбранных пользователей'></FORM>
&nbsp; <FORM action='admin.php?event=userwho&page=$page&chekall' method=POST name=delform><INPUT class=mainoption type=submit value='Пометить ВСЕХ'></FORM>
&nbsp; <FORM action='admin.php?event=userwho&page=$page' method=POST name=delform><INPUT class=mainoption type=submit value='СНЯТЬ пометку'></FORM></div>";


// выводим СПИСОК СТРАНИЦ
if ($page>$maxpage) $page=$maxpage;
echo'<BR><table width=100%><TR><TD>Страницы:&nbsp; ';
if ($page>=4 and $maxpage>5) print "<a href=admin.php?event=userwho&page=1>1</a> ... ";
$f1=$page+2; $f2=$page-2;
if ($page<=2) {$f1=5; $f2=1;} if ($page>=$maxpage-1) {$f1=$maxpage; $f2=$page-3;} if ($maxpage<=5) {$f1=$maxpage; $f2=1;}
for($i=$f2; $i<=$f1; $i++) {if ($page==$i) print "<B>$i</B> &nbsp;"; else print "<a href=admin.php?event=userwho&page=$i>$i</a> &nbsp;";}
if ($page<=$maxpage-3 and $maxpage>5) print "... <a href=admin.php?event=userwho&page=$maxpage>$maxpage</a>";

print "</TD><TD align=right>Всего зарегистрировано участников - <B>$ui</B></TD></TR></TABLE><br>

Пересортировать участников по: 
<form action='admin.php?event=sortusers' method=post name=REPLIER>
<SELECT name=kaksort>
<OPTION selected value=1>Имени</OPTION>
<OPTION value=2>Кол-ву сообщений</OPTION>
<OPTION value=3>Кол-ву звёзд</OPTION>
<OPTION value=4>Репутации</OPTION>
<OPTION value=5>Дате регистрации</OPTION>
<OPTION value=6>Активности **</OPTION></SELECT>
<input type=submit class=mainoption value='     Пересортировать     '> &nbsp; (сортировать лучше когда с форумом никто из участников не работает)
<br><br>";


if ($error>0) print"$bada";

echo'* Тем - Скрипт считает кол-во тем, созданных участником с момента регистрации/восстановления файла статистики после сбоя<br><br>
Сообщений - сколько участник оставил сообщений<br><br>
Репутация - "Авторитетность" пользователя. Максимум 9999 ед. Автоматически увеличивается на 1 при добавлении сообщения/темы<br><br>

Система штрафов ещё отлаживается. Будет доступна в следующей версии!!!
- ШТРАФЫ:<br>
0 - юзер может всё;<br>
1 - юзеру антифлуд увеличиваем до 60 секунд;<br>
2 - юзер не имеет права менять репу другим;<br>
3 - юзеру запрещаем создавать темы;<br>
4 - блокируем доступ к ответу в темах - только просмотр;<br>
5 - БАН на 1 месяц!<br><br>
** Активность - кол-во сообщений в сутки разделённая на кол-во дней с момента регистрации;
<br><BR>';
}
}






// МАССОВАЯ рассылка информации УЧАСТНИКам форума
if (isset($_GET['event'])) { if ($_GET['event']=="massmail") {

echo'<table width=100% border=0 cellpadding=1 cellspacing=0><TR><TD>
<table border=0 width=100% cellpadding=2 cellspacing=1 class=forumline><tr> 
<th class=thCornerL height=25 nowrap=nowrap>№</th>
<th class=thCornerL width=110>Метка кому отправлять</th>
<th class=thCornerL width=110>Имя</th>
<th class=thTop>Емайл</th>
<th class=thTop>Тем</th>
<th class=thTop>Сообщений</th>
<th class=thTop>Репутация</th>
<th class=thTop>Статус / Изменить</th></tr></table>';

print"<center><TABLE class=forumline cellPadding=2 cellSpacing=1 width=775>
<br><br><FORM action='admin.php?event=massmailgo' method=post>
<TBODY><TR><TD class=thTop align=middle colSpan=2>Введите параметры текста <B>отправляемого пользователям</B></TD></TR>

<TR bgColor=#ffffff><TD>&nbsp; Имя отправителя:<FONT color=#ff0000>*</FONT> <INPUT name=name value='Администратор форума ' style='FONT-SIZE: 14px; WIDTH: 240px'>

и E-mail:<FONT color=#ff0000>*</FONT> <INPUT name=email value='$adminemail' style='FONT-SIZE: 14px; WIDTH: 320px'></TD></TR>

<TR bgColor=#ffffff><TD>&nbsp; Сообщение:<FONT color=#ff0000>*</FONT><br>
<TEXTAREA name=msg style='FONT-SIZE: 14px; HEIGHT: 440px; WIDTH: 765px'>
\r\n
БЛОК ещё НЕ ГОТОВ!!!!\r\n
\r\n
Здравствуйте, %name!\r\n
Вы являетесь зарегистрированным участником форума %fname,
установленного по адресу: %furl.

Как администратор форума хочу Вам сообщить следующую новость:


СЮДА ВПИШИТЕ НОВОСТЬ, например:
- У нас на форуме очень интересное обсуждение Фильма Терминатор-4;
- У нас на форуме выложены ссылки на бесплатные фото Светы Букиной;
- На форуме выложены свежие ссылки на скрипт по php :-) в темах таких-то... и т.д.


----------
Администратор форума ВАСЯ ПУПКИН (здесь впишите своё имя/ник)
</TEXTAREA></TD></TR>
<TR><TD bgColor=#FFFFFF colspan=2><center><INPUT type=submit value=Отправить></TD></TR></TBODY></TABLE></FORM>


<br><br></center>
* Используйте макроподстановку:<br>
<LI><B>%name</B> - имя участника форума;</LI>
<LI><B>%fname</B> - название форума;</LI>
<LI><B>%furl</B> - URL-адрес форума;</LI>

<br><br>Блок в процессе разработки - ещё не работает!!!<br><br><br>"; }}





?><br>
<center><font size=-2><small>Powered by <a href="http://www.wr-script.ru" title="Скрипт форума" class="copyright">WR-Forum</a> Professional &copy; 1.9.3<br></small></font></center>
</body>
</html>
