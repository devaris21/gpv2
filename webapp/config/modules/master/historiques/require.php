<?php 
namespace Home;


$title = "GPV | Historiques & Traçabilité ";

$datas = HISTORY::findBy(["DATE(created) >="=>dateAjoute(-1)], [], ["created"=>"DESC"]);

?>