<?php
error_reporting(0);
if(empty($_GET["v_site"])) {
echo 'boş alan ?v_site=';
exit;
}

$ch = curl_init($_GET["v_site"]);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36");
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_NOBODY, 0);
$v4t1 = curl_exec($ch);
if($v4t1=="") {
echo 'Siteye ulaşılamıyor.';
exit;
}

preg_match_all('@/wp-content/themes/(.*?)/@si',$v4t1,$theme);

if($theme[1][0]=="") {
echo 'Tema bulunamadı';
} else {
$wgetir = file_get_contents("https://wordpress.org/themes/search/".$theme[1][0]."/");
preg_match_all('@<span class="count theme-count">(.*?)</span>@si',$wgetir,$nekadar);
preg_match_all('@<h3 class="theme-name entry-title">(.*?)</h3>@si',$wgetir,$tema_adi);
preg_match_all('@<span class="author">(.*?)</span>@si',$wgetir,$tema_sahibi);
preg_match_all('@<a class="url" href="(.*?)"@si',$wgetir,$tema_link_wp);
echo '<h5>Tema klasör adı : '.htmlspecialchars($theme[1][0]).' <br>Wordpress arama sonuçları ;</h5><br>';

echo '<div class="col-md-5">';

if($nekadar[1][0]=="0") {
echo '<h5>Wordpress adresinde tema bulunamadı.</h5><br>';
} else {
echo '<table class="table">
  <thead>
    <tr>
<th scope="col">Tema Adı</td>
<th scope="col">Tema Sahibi</td>
<th scope="col">Temayı İncele</td>
</tr>
<tbody class="table">';
for($i=0; $i<$nekadar[1][0]; $i++)
{
echo '<tr>';
echo '<td>'.htmlspecialchars($tema_adi[1][$i]).'</td>';
echo '<td>'.htmlspecialchars($tema_sahibi[1][$i]).'</td>';
echo '<td><a href="'.htmlspecialchars($tema_link_wp[1][$i]).'" rel="nofollow" target="_blank">Wordpress.org uzantısı</a></td>';
echo '</tr>';
}
echo '</table>
</tbody>';
}

echo '<h5>Themeforest arama sonuçları ilk 5 ;</h5><br>';
$chh = curl_init("https://themeforest.net/search/".$theme[1][0]."");
curl_setopt($chh, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36");
curl_setopt ($chh, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt ($chh, CURLOPT_FOLLOWLOCATION, true);
curl_setopt ($chh, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt ($chh, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chh, CURLOPT_VERBOSE, 1);
curl_setopt($chh, CURLOPT_NOBODY, 0);
$tgetir = curl_exec($chh);
preg_match_all('@<span class="_3HYTF">(.*?)</span>@si',$tgetir,$tnekadar);
preg_match_all('@class="_2Pk9X" tabindex="0">(.*?)</a>@si',$tgetir,$t_adi);
preg_match_all('@<div class="_3XNMI"><a href="(.*?)"@si',$tgetir,$t_link);
if($tnekadar[1][0]=="0") {
echo '<h5>Themeforest adresinde tema bulunamadı.</h5>';
exit;
}
if($tnekadar[1][0]<5) {
$zf = ("1");
} else {
$zf = ("5");
}

echo '<table class="table">
  <thead>
    <tr>
<th scope="col">Tema Adı</td>
<th scope="col">Temayı İncele</td>
</tr>
<tbody class="table">';

for($ti=0; $ti<$zf; $ti++)
{
$str = str_replace('<span class="zS0k1">', "", $t_adi[1][$ti]);
$str1 = str_replace('</span>', "", $str);
echo '<tr>';
echo '<td>'.htmlspecialchars($str1).'</td>';
echo '<td><a href="'.htmlspecialchars($t_link[1][$ti]).'" rel="nofollow" target="_blank">Themeforest uzantısı</a></td>';
echo '</tr>';
}
echo '</table>
</tbody>';
}
?>
