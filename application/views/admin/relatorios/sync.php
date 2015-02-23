<div id="tabs_content" class="scrollable_content clear">
<pre>           
<?
/*
foreach ($listFeed as $spreadSheet) {
	echo $spreadSheet->getTitle().' <br/>-- '.$spreadSheet->getId().'<br/><br/>';
	foreach ($spreadSheet->getWorksheets() as $worksheet) {
		echo "---- ".$worksheet->getTitle().' -- '.$worksheet->getId().'<br/><br/>';
	}
}
*/
/*
$rowData = $listFeed->entries[1]->getCustom();
foreach($rowData as $customEntry) {
  echo $customEntry->getColumnName() . " = " . $customEntry->getText();
}
*/
/*
$entries = $listFeed->entries[0]->getContentsAsRows();
echo '<pre>';
echo "<hr><h3>Example 1: Get cell data</h3>";

echo var_export($entries, true);
*/

/*
echo "<hr><h3>Example 2: Get column information</h3>";
echo "Nr of columns: $columnCount";
echo "<br>Columns: <pre>";

echo var_export($columns, true);
*/
//echo var_export($entries, true);
/*
$searchFor = array(
	"Taxonomia do arquivo", 
	"Envio para a produtora",
	"Prova 1",
	"Prova 1 Relatório consolidado de conteúdo",
	"Prova 1 Relatório de erros",
	"Prova 2",
	"Prova 2 Relatório consolidado de conteúdo",
	"Prova 2 Relatório de erros",
);

$searchKeys = array();
foreach($entries[1] as $key => $value){
	if(!in_array($value, $searchFor)){
		array_push($searchKeys, $key);
	}	
}
//var_dump($searchKeys);

foreach ($entries as $key => $value) {
	foreach ($searchKeys as $arraykey) {
		unset($value[$arraykey]);
	}

	if(count($value) == count($searchFor)){
		$c = array_combine($searchFor, $value);
		var_dump($c);		
	}
}
*/

//$indexSpam = array_search('Mark As Spam', $array);
//unset($array[$indexSpam]);

/*


$a = array();

$i = 1;
foreach ($entries as $value) {
	$index = $searchKeys[$i - 1];
	if (array_key_exists($index, $value)) {
		$gdocs['gdocs'][$index] = $value[$index]; 
	}
	array_push($a, $gdocs);
	$i++;
}


var_dump($a);
*/
$count = count($r);
echo $count;
var_dump($r);
?>
OK
</div>