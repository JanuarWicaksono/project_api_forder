<?php
$app->get('/api/orders', function(){
	require_once('dbconnect.php');
	$queryOrders = "SELECT * FROM `order` 
		JOIN costumers ON order.idCostumer = costumers.idCostumer 
		JOIN menus ON order.idMenu = menus.idMenu
		JOIN tables ON costumers.idTable = tables.idTable
		JOIN tables_category ON tables.idTableCategory = tables_category.idTableCategory
		ORDER BY costumers.date";	
	$resultOrders = $mysqli->query($queryOrders);
	while($rowOrders = $resultOrders->fetch_assoc()){
			$return[$rowOrders['payment_status']][] = $rowOrders;
	}
	if(isset($return)){
		header('Content-Type: application/json');
		echo json_encode($return);
	}
});

$app->get('/api/orders/costumers', function(){
	require_once('dbconnect.php');
	$queryOrders = "SELECT * FROM costumers
	JOIN tables ON costumers.idTable = tables.idTable
	JOIN tables_category ON tables.idTableCategory = tables_category.idTableCategory";	
	$resultOrders = $mysqli->query($queryOrders);
	while($rowOrders = $resultOrders->fetch_assoc()){
			$return[$rowOrders['payment_status']][] = $rowOrders;
	}
	if(isset($return)){
		header('Content-Type: application/json');
		echo json_encode($return);
	}
});

$app->post('/api/orders', function ($request) {
    require_once('dbconnect.php');
    $data = $request->getParsedBody();

    $table= $mysqli->query("SELECT * FROM tables WHERE noTable='".$data['tableNumber']."'")->fetch_assoc();

    $costumer = $mysqli->query("INSERT INTO costumers values ('', '".$data['costumerName']."', 
    	'".$data['numberVisitor']."', '".date('Y-m-d H:i:s')."', 'unpaid',  '".$table['idTable']."')");

    $customerId = (int)$mysqli->insert_id;

  	foreach ($data['orders'] as $row) {
  		$queryOrders = $mysqli->query("INSERT INTO `order` values 
  			(".$row['idMenu'].", ".$customerId.", ".($row['takeAway'] === 'true' ? 1 : 0).", ".$row['qty'].", '".$row['note']."')");
  	}

  	return json_encode([
  		'message' => 'success'
  	]);
});

?>