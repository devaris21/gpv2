<?php 
namespace Home;

unset_session("ressources");

unset_session("produits");
unset_session("commande-encours");

$tableau_mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];


if ($this->id != null) {
    $datas = COMMERCIAL::findBy(["id ="=> $this->id]);
if (count($datas) > 0) {
    $commercial = $datas[0];
    $commercial->actualise();

$date1 = getSession("date1");
$date2 = getSession("date2");
if ($date1  == null) {
    $date1 = date("Y-m")."-01";
}
if ($date2  == null) {
    $date2 = dateAjoute();
}

$lesprospections = $commercial->vendu($date1, $date2);
$nombre = 0;
$index = $date1;
while ($index <= $date2) {
    if (!isJourFerie($index)) {
        $nombre++;
    }
    $index = dateAjoute1($index, 1);
}

$prospections = $commercial->fourni("prospection", ["etat_id ="=>ETAT::ENCOURS]);
$commercial->fourni("prospection");
$stats = $commercial->stats($date1, $date2);

$payes = $commercial->fourni("lignepayement", [], [], ["created"=>"DESC"]);



$title = "GPV | ".$commercial->name();

session("commercial_id", $commercial->id);

}else{
    header("Location: ../master/commercials");
}
}else{
    header("Location: ../master/commercials");
}
?>