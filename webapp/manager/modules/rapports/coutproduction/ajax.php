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
	$moyenne = $operations = $paye = $ressource = $emballage = $etiquette = 0;

	$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]) ;
	$emballages = EMBALLAGE::findBy(["isActive ="=>TABLE::OUI]) ;
	$datas = TYPEPRODUIT_PARFUM::findBy(["typeproduit_id ="=>$typeproduit_id, "parfum_id ="=>$parfum_id]);
	if (count($datas) > 0) {
		$pro = $datas[0];
		$pro->actualise();
		$produits = $pro->fourni("produit", ["isActive ="=>TABLE::OUI]);

		foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
			$item->vendu = PRODUIT::totalProduit($date1, $date2, null, null, $item->id);
			$typeproduits[] = $item;
		}
		$total = comptage($typeproduits, "vendu", "somme");


		foreach ($produits as $key => $produit) {
			$eti = new ETIQUETTE();
			$datas = $produit->fourni("etiquette");
			if (count($datas) > 0) {
				$eti = $datas[0];
			}

			foreach ($produit->fourni("ligneconditionnement") as $keye => $ligne) {
				$ligne->actualise();
				$emballage += $ligne->quantite * $ligne->emballage->totalEmballagePrice();
				$etiquette += $ligne->quantite * $ligne->emballage->nombre() * $eti->price();
			}
		}		

		$production = $pro->production($date1, $date2);

		foreach ($pro->fourni("exigenceproduction") as $key => $exi) {
			if ($exi->quantite > 0) {
				foreach ($exi->fourni("ligneexigenceproduction") as $keye => $ligne) {
					$ligne->actualise();
					$ressource += (($ligne->quantite * $production) / $exi->quantite) * $ligne->ressource->price();
				}
			}
		}

		if ($total > 0) {
			$operations = OPERATION::sortie($date1, $date2) * $production / $total;
			$paye = LIGNEPAYEMENT::total($date1, $date2) * $production / $total;
		}

		$general = $production + $ressource + $emballage + $operations + $paye;
		if ($total > 0) {
			$moyenne = $general / $production;
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
					<h5>Coût de la production</h5>
					<h2 class="no-margins"><?= money() ?> <?= $params->devise  ?></h2>
				</div>
				<div class="ibox-content">
					<h5>Coût du packaging</h5>
					<h2 class="no-margins"><?= money($etiquette + $emballage) ?> <?= $params->devise  ?></h2>
				</div>
			</div>
			<div class="col-sm-6 text-center">
				<div>
					<h1 class="mp0 gras"><?= start0($production) ?> <?= $pro->typeproduit->unite  ?>(s) </h1>
					<span >produits sur la période pour un coût total de production brut d'environs </span>
					<h2 class="mp0 gras"><?= money($general) ?> <?= $params->devise ?></h2>
				</div><br>

				<h3 class="mp0 gras d-inline">1 <?= $pro->typeproduit->abbr ?> </h3>
				<span > brut vous coûte environs </span>
				<h3 class="mp0 gras d-inline"><?= money($moyenne) ?> <?= $params->devise ?></h3>
				<hr class="mp3">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th colspan="2"></th>
							<?php foreach ($quantites as $key => $qua) { ?>
								<th><?= $qua->name() ?></th>
							<?php } ?>
						</tr>
						<?php foreach ($emballages as $key => $embal) { ?>
							<tr>
								<td><img style="height: 30px;" src="<?= $rooter->stockage("images", "emballages", $embal->image) ?>"></td>
								<td><?= $embal->name() ?></td>
								<?php foreach ($quantites as $key => $qua) { ?>
									<td><b><?= money($embal->totalEmballagePrice() + ($moyenne * $qua->name * $embal->nombre())) ?></b> <?= $params->devise ?></td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<hr class="mp3">
			</div>
			<div class="col-sm-3 border-left">
				<h3 class="text-uppercase text-center">Charges indirectes</h3>
				<div class="ibox-content">
					<h5>Charges de fonctionnement</h5>
					<h2 class="no-margins"><?= money($operations)  ?> <?= $params->devise  ?></h2>
				</div>
				<div class="ibox-content">
					<h5>Paye du personnel</h5>
					<h2 class="no-margins"><?= money($paye)  ?> <?= $params->devise  ?></h2>
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