<!--div class="scrollable clear" style="height:360px; overflow:auto;"-->
<?
$count = count($r);
echo $count. " objetos encontrados. <br/>";
foreach ($r as $key => $msg) {
	echo "<div>".$msg."</div>";
}
?>
<!--/div-->