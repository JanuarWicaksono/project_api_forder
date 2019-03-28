<?php
//display all row
$app->get('/api/menus', function(){
	require_once('dbconnect.php');
	$queryMenuCat = "SELECT * FROM menus_category ORDER BY idCategory";
	$resultMenuCat = $mysqli->query($queryMenuCat);
	while($rowMenuCat = $resultMenuCat->fetch_assoc()){
		$queryMenu = "SELECT * FROM menus WHERE idCategory='".$rowMenuCat['idCategory']."'";
		$resultMenu = $mysqli->query($queryMenu);
		while($rowMenu = $resultMenu->fetch_assoc()){
			// print_r($rowMenu);
			$return[$rowMenuCat['name']][] = $rowMenu;
		}
	}
	if(isset($return)){
		header('Content-Type: application/json');
		echo json_encode($return);
	}
});

//display not available menu
$app->get('/api/menus/notavailablemenu', function(){
	require_once('dbconnect.php');
	$queryMenuNa = "SELECT * FROM menus WHERE status ='not available'
		ORDER BY menuName";
	$resultMenuNa = $mysqli->query($queryMenuNa);
	while($rowMenuNa = $resultMenuNa->fetch_assoc()){
		$return[] = $rowMenuNa;
	}
	if(isset($return)){
		header('Content-Type: application/json');
		echo json_encode($return);
	}
});

//display a single row
$app->get('/api/menus/{id}', function($request){
	require_once('dbconnect.php');
	$id = $request->getAttribute('id');

	$query = "SELECT * FROM menus WHERE id='$id'";
	$result = $mysqli->query($query);
	$row = $result->fetch_assoc();
	$data[] = $row;
	header('Content-Type: application/json');
	echo json_encode($data);
});

//update a record on database
$app->delete('/api/menus/{id}', function($request){
	require_once('dbconnect.php');
	$id = $request->getAttribute('id');
	$query = "DELETE FROM books WHERE id = '$id';";
	$result = $mysqli->query($query);
});
?>