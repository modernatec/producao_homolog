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

$entries = $listFeed->entries[0]->getContentsAsRows();
echo '<pre>';
echo "<hr><h3>Example 1: Get cell data</h3>";

echo var_export($entries, true);


?>
OK