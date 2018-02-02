<?php // ������ ��� ����������� ��������� ��� � ��������� � ������� RSS-��������
      // ���������������� ������ Rootman // Miha-ingener@yandex.ru

include ("config.php");


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


function unreplacer($text) { // ������� ������ ������������ ����� ������ �� �������
$text=str_replace("&lt;br&gt;","<br>",$text); return $text;}


// ��������� ������ ��������
$rss="http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$url=str_replace("rss.php","index.php",$rss);

if (!isset($_GET['whatisthis'])) {

$fname=replacer($fname);
$fdesription=replacer($fdesription);
$adminemail=replacer($adminemail);
// ��������� RSS

echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?>
<rss version=\"2.0\">
 <channel>
   <title>$fname</title>
   <link>$url</link>
   <description>$fdesription</description>
   <language>Russian</language>
   <copyright>Rootman</copyright>
   <managingEditor>$adminemail</managingEditor>
   <webMaster>$adminemail</webMaster>
   <generator>WR-Forum 1.9.2 RSS-module</generator>
   <lastBuildDate>$date $time</lastBuildDate>
";

// ������ �������� � �� ����� �� �����
$lines=file("$datadir/news.dat");
$itogo=sizeof($lines); $x=$itogo-1;
do { $dt=explode("|",replacer($lines[$x]));

// ������������ ���� � ������ ����� RSS    
$dt1=explode(".",$dt[2]);
$dt2=explode(":",$dt[3]);
$then=mktime($dt2[0],$dt2[1],$dt2[2],$dt1[1],$dt1[0],$dt1[2]);
$xdate=date("r",$then);

$tname=$dt[9];
$zag=$dt[5];
$name=$dt[4];
$msg=$dt[6];
$msg=str_replace("&","&amp;",$msg);
//$msg=str_replace("&amp;lt;","<",$msg);
//$msg=str_replace("&amp;gt;",">",$msg);
$msg=str_replace('\"','"',$msg);
$msg=str_replace("[b]","<p>",$msg);
$msg=str_replace("[/b]","</p>",$msg);
$msg=str_replace("[RB]","<p>",$msg);
$msg=str_replace("[/RB]","</p>",$msg);
$msg=str_replace("[Code]","<p>",$msg);
$msg=str_replace("[/Code]","</p>",$msg);
$msg=str_replace("[Quote]","<p>",$msg);
$msg=str_replace("[/Quote]","</p>",$msg);
$msg=str_replace("<br>","\r\n", $msg);
//$msg=unreplacer($msg);
$msg=str_replace("&amp;lt;br&amp;gt;","<p></p>", $msg);
$msg="<![CDATA[$msg]]>";

$fid=$dt[0];
$id=$dt[1];

echo "
<item>
 <title>$zag</title>
  <link>$url?fid=$fid&amp;id=$id</link>
   <description>� &lt;b&gt;�������:&lt;/b&gt; &lt;a href=\"$url?fid=$fid\"&gt; $tname&lt;/a&gt; &lt;b&gt;$name&lt;/b&gt; �����: &lt;br&gt;&lt;br&gt; $msg &lt;br&gt;&lt;br&gt;</description>
   <author>$name</author>
  <comments>$url?fid=$fid&amp;id=$id</comments>
 <pubDate>$xdate</pubDate>
</item>
";
$x--;
} while ($x>=0); // end do ... while

echo "
 </channel>
</rss>";

} else { // �������� �� ������������ RSS, ������� ������� ���������� �� RSS 

echo '<html>
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=windows-1251">
<title>��� ����� RSS</title>
</head>
<body bgcolor="#FFFFFF">
<p><font size="5">��� ����� RSS?</font></p>
<p><strong>RSS</strong> - ��� ���������� �� <b>R</b>eally
<b>S</b>imple <b>S</b>yndication, ��� � ��������
�� ������� ������, ��� ������������� �������� ����������?
����, ������, ������������� ������� ��������������, - ��� �����
���������, �� �� ����� �������. </p>
<p>������� �������: </p>
<blockquote>
    <p>Syndicate - 1) ��������� ������,  ������������� ����������, ������
    � �. �. � ��������� �� ���������  ������� ��� �������������
    ����������, (���.) 2) �����������  ���������� � ��. (��.)</p>
</blockquote>
<p>�����, <strong>RSS</strong> - ��� �������
������������ ����������.</p>
<p><strong>RSS </strong>- ��� �������������
XML, ������, ���������� ����������� ��� ����, ����� ����� � ������
�������� ���������. ���������� ����������� Netscape ��� �� �������
Netcenter, �� ������ �������� ������������ � ���� ������������ ������ ��������������.</p>
<p>� ��������� ����� <strong>RSS</strong>
�������� ��������� ��� �������� ���� �������� ����� �� ������� ����
��������� ������������, ��� ����������� �������� ������� ���
������ ������������ (�� ���� ������ ��� ��������� WEB-��������), ��� �
�������.</p> 
<p>��� ������ � <b>RSS</b> �� ���� ������ ���
���������� ����������� ��������� ��� ������ <b>RSS</b>-������. �� �����������
��� ���������� ������� � �������������, ���������� �
���������� ��������� <a  href="http://www.google.ru/search?hl=ru&amp;q=Abilon+RSS&amp;lr=">Abilon</a>
�������� ������� �� ������ � ������ on-line �������� ��� ���������� �
����� ����� � ���������� �� ����� ������ � ������ ������ � �����
�������.</p>
<p>����� <b>RSS</b>-������� ������ - <b>'.$rss.'</b></p>
</body>
</html>
'; }

?>
