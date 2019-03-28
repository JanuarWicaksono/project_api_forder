<?php
//display not available tables
$app->get('/api/tables/AvailableTables', function(){
	require_once('dbconnect.php');
	$queryTables = "SELECT * FROM tables JOIN tables_category ON tables.idTableCategory = tables_category.idTableCategory
		WHERE tables.status = 'available'";	
	$resultTables = $mysqli->query($queryTables);
	while($rowTables = $resultTables->fetch_assoc()){
			$return[] = $rowTables;
	}
	if(isset($return)){
		header('Content-Type: application/json');
		echo json_encode($return);
	}
});

?>