<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "filtrer") {
	$data->setUrl("entrepot", "caisse", "etatproduction", "$date1@$date2");
	echo json_encode($data);
}