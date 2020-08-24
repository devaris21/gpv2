<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;
$params = PARAMS::findLastId();
$rooter = new ROOTER;
$data = new RESPONSE;
extract($_POST);


if ($action == "filtrer") {
	$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]) ;
	$datas = TYPEPRODUIT_PARFUM::findBy(["typeproduit_id ="=>$typeproduit_id, "parfum_id ="=>$parfum_id]);
	if (count($datas) > 0) {
		$pro = $datas[0];
		$pro->actualise();

		$ressource = $emballage = $etiquette = 0;
		foreach ($pro->fourni("produit", ["isActive ="=>TABLE::OUI]) as $key => $produit) {
			$eti = new ETIQUETTE();
			$datas = $produit->fourni("etiquette");
			if (count($datas) > 0) {
				$eti = $datas[0];
			}

			foreach ($produit->fourni("ligneconditionnement") as $keye => $ligne) {
				$ligne->actualise();
				$emballage += $ligne->quantite * $$ligne->formatemballage->price();
				$emballage += $ligne->quantite * $ligne->formatemballage->nombre() * $eti->price();
			}
		}		

		$production = PRODUCTION::production($date1, $date2, $pro->id);

		foreach ($pro->fourni("exigenceproduction") as $key => $exi) {
			if ($exi->quantite > 0) {
				foreach ($exi->fourni("ligneexigenceproduction") as $keye => $ligne) {
					$ligne->actualise();
					$ressource += (($ligne->quantite * $production) / $exi->quantite) * $ligne->ressource->price();
				}
			}
		}

		?>
		<br><h1 class="display-5 text-center text-uppercase"> Cout de production de <?= $pro->name() ?></h1><br><br>
		<div class="row">
			<div class="col-sm-3 border-right">
				<h4 class="text-uppercase text-center">Charges directes</h4>
				<div class="ibox-content">
					<h5>Coût Matières premières</h5>
					<h2 class="no-margins"><?= money($ressource) ?> <?= $params->devise  ?></h2>
				</div>
				<div class="ibox-content">
					<h5>Coût Emballlages</h5>
					<h2 class="no-margins"><?= money($emballage) ?> <?= $params->devise  ?></h2>
				</div>
				<div class="ibox-content">
					<h5>Coût Etiquettes</h5>
					<h2 class="no-margins"><?= money($etiquette) ?> <?= $params->devise  ?></h2>
				</div>
			</div>
			<div class="col-sm-6 text-center">
				<div>
					<h1 class="mp0 gras d-inline"><?= start0($production) ?> <?= $pro->typeproduit->unite  ?>(s) </h1>
					<span >produits sur la période </span>
				</div>

				<h1 class="mp0 gras d-inline">5L </h1>
				<span >vous coûte environs </span>
				<h1 class="mp0 gras d-inline">1250 Fcfa</h1>
				<hr class="mp3">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<?php foreach ($quantites as $key => $qua) { ?>
								<td><?= $qua->name() ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<h1 class="mp0 gras d-inline">5L <</h1>
				<div >Votre bénéfice unitaire en <br> fonction de vos ventes </div>
				<h1 class="mp0 gras d-inline"> < 1250 Fcfa</h1>
				<hr class="mp3">
			</div>
			<div class="col-sm-3 border-left">
				<h3 class="text-uppercase text-center">Charges indirectes</h3>
				<div class="ibox-content">
					<h5>Charges de fonctionnement</h5>
					<h2 class="no-margins"><?= money(OPERATION::sortie($date1, $date2))  ?> <?= $params->devise  ?></h2>
				</div>
				<div class="ibox-content">
					<h5>Paye des manoeuvres/commerciaux</h5>
					<h2 class="no-margins"><?= money(LIGNEPAYEMENT::sortie($date1, $date2))  ?> <?= $params->devise  ?></h2>
				</div>
				<div class="ibox-content">
					<h5>Coût publicitaire</h5>
					<h2 class="no-margins">00000 <?= $params->devise  ?></h2>
				</div>
			</div>
		</div><hr style="border: dashed 1px orangered"> 

	<?php } else { ?>
		<h1>Une erreur s'est produite, veuillez recommencer !</h1>
	<?php }

}