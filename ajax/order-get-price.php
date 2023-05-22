<?php
require("../mainconfig.php");

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_POST['price'])) {
		exit("No direct scripts access allowed!");
	}
	header('Content-Type: application/json');
	if (empty($_POST['price']) && empty($_POST['quantity']) && empty($_POST['service'])) {
	    $result = array('total_price' => '0');
	} else {
	    if (!empty($_POST['price']) && !empty($_POST['quantity']) && !empty($_POST['service'])) {
	        $service = $model->db_query($db, "*", "services", "id = '".mysqli_real_escape_string($db, $_POST['service'])."'");
	        $price = str_replace('.','',$_POST['price']);
	        $quantity = $_POST['quantity'];
	        $harga = $price / $service['rows']['rate'];
	        $hasil = $harga * $quantity;
	        $result = array('total_price' => number_format($hasil,0,',','.'));
	    }
	}
	print(json_encode($result));
} else {
    exit("No direct script access alloweds!");
}