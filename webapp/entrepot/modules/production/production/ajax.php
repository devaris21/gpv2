<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($action == "calcul") {
	$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		$type = $datas[0];
		$type->actualise();
		?>
		<div class="row justify-content-center">
			<?php 
			foreach ($type->fourni("exigenceproduction") as $key1 => $exi) {
				$res = $exi->fourni("ligneexigenceproduction", ["ressource_id ="=> $type->ressource_id])[0];
				$total = $val * $exi->quantite / $res->quantite;
				$datas = $exi->fourni("ligneexigenceproduction", ["ressource_id !="=> $type->ressource_id, "quantite >"=>0]);
				foreach ($datas as $key2 => $ligne) { 
					$ligne->actualise();
					?>
					<div class="col-sm text-center border-right">
						<label>Quantité de <?= $ligne->ressource->name()  ?></label>
						<h4 class="mp0"><?= round((($total * $ligne->quantite) / $exi->quantite), 2) ?> <?= $ligne->ressource->abbr  ?></h4>
					</div>	
				<?php }
			} ?>
		</div><br><br><br>

		<div class="text-center">
			<h4>Pour une production total de </h4>
			<h2 class="gras mp0"><?= round($total, 1) ?> <?= $type->typeproduit->abbr  ?></h2>
		</div>
		<?php
	}
}





if ($action == "nouvelleProduction") {
	$tests = $listeproduits = explode(",", $listeproduits);
	foreach ($tests as $key => $value) {
		$test = true;
		$lot = explode("-", $value);
		$id = $lot[0];
		$qte = end($lot);
		if ($qte > 0) {
			$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=> $id]);
			if (count($datas) == 1) {
				$type = $datas[0];
				foreach ($type->fourni("exigenceproduction") as $key1 => $exi) {
					$res = $exi->fourni("ligneexigenceproduction", ["ressource_id ="=> $type->ressource_id])[0];
					$total = $qte * $exi->quantite / $res->quantite;
					$datas = $exi->fourni("ligneexigenceproduction", ["quantite >"=>0]);
					foreach ($datas as $key2 => $ligne) {
						if ($ligne->quantite > 0) {
							$ligne->actualise();
							if ($ligne->ressource->isActive() && ($total*$ligne->quantite/$exi->quantite) > $ligne->ressource->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("entrepot_connecte_id")) ) {
								$test = false;
								break 2;
							}
						}
					}
				}
			}
		}
		if ($test) {
			unset($tests[$key]);
		}
	}
	if (count($tests) == 0) {
		$datas = ENTREPOT::findBy(["id ="=>getSession("entrepot_connecte_id")]);
		if (count($datas) == 1) {
			$entrepot = $datas[0];
			$entrepot->actualise();
			if ($entrepot->comptebanque->solde() >= $maindoeuvre) {
				$production = new PRODUCTION();
				$production->hydrater($_POST);
				$data = $production->enregistre();
				if ($data->status) {
					foreach ($listeproduits as $key => $value) {
						$lot = explode("-", $value);
						$id = $lot[0];
						$qte = end($lot);

						$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=> $id]);
						if (count($datas) == 1) {
							$type = $datas[0];
							$ligne = new LIGNEPRODUCTION();
							$ligne->production_id = $production->id;
							$ligne->typeproduit_parfum_id = $type->id;
							$ligne->quantite = intval($total);
							$data = $ligne->enregistre();	
							foreach ($type->fourni("exigenceproduction") as $key1 => $exi) {
								foreach ($exi->fourni("ligneexigenceproduction") as $key2 => $lign) {
									if ($lign->quantite > 0) {
										$lign->actualise();
										$ligne = new LIGNECONSOMMATION();
										$ligne->production_id = $production->id;
										$ligne->ressource_id = $lign->ressource->id;
										$ligne->quantite = $total*$lign->quantite/$exi->quantite;
										$ligne->price = $ligne->quantite * $lign->ressource->price();
										$data = $ligne->enregistre();
									}
								}
							}
						}
					}
				}
			}else{
				$data->status = false;
				$data->message = "Le solde du compte est insuffisant pour regler les frais de main d'oeuvre de la production !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Certaines productions neccessite plus de ressources que vous n'en possédez !";
	}
	echo json_encode($data);
}








if ($action == "annulerMiseenboutique") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = MISEENBOUTIQUE::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$prospection = $datas[0];
				$data = $prospection->annuler();
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
			}
		}else{
			$data->status = false;
			$data->message = "Votre mot de passe ne correspond pas !";
		}
	}else{
		$data->status = false;
		$data->message = "Vous ne pouvez pas effectué cette opération !";
	}
	echo json_encode($data);
}




if ($action == "validerMiseenboutique") {
	$id = getSession("miseenboutique_id");
	$datas = MISEENBOUTIQUE::findBy(["id ="=>$id, "etat_id = "=>ETAT::ENCOURS]);
	if (count($datas) > 0) {
		$mise = $datas[0];
		$mise->actualise();
		$mise->fourni("lignemiseenboutique");

		$produits = explode(",", $tableau);
		foreach ($produits as $key => $value) {
			$lot = explode("-", $value);
			$array[$lot[0]] = end($lot);
		}

		if (count($produits) > 0) {
			$tests = $array;
			foreach ($tests as $key => $value) {
				foreach ($mise->lignemiseenboutiques as $cle => $lgn) {
					if (($lgn->id == $key) && ($lgn->quantite_depart >= $value)) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				foreach ($array as $key => $value) {
					foreach ($mise->lignemiseenboutiques as $cle => $lgn) {
						if ($lgn->id == $key) {
							$lgn->quantite = $value;
							$lgn->perte = $lgn->quantite_depart - $value;
							$lgn->save();
							break;
						}
					}					
				}
				$mise->hydrater($_POST);
				$data = $mise->valider();
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien vérifier les quantités des différents produits, certaines sont incorrectes !";
			}			
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}