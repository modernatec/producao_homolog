<div class="scrollable_content clear" style="height:360px;">
<?
$count = count($r);
echo $count. " objetos encontrados. <br/>";
foreach ($r as $key => $msg) {
	echo "<div>".$msg."</div>";
}
?>
</div>