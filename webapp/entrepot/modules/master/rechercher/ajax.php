<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);




if ($action == "filtrer") {
	$value = strtolower($value);
	$rooter = new ROOTER();
	$params = PARAMS::findLastId();

	$commandes          = COMMANDE::findLike($value, ["reference", "lieu", "datelivraison", "created", "montant", "avance"]);
	$livraisons         = PROSPECTION::findLike($value, ["reference", "lieu", "dateretour", "created"]);
	$ventes             = VENTE::findLike($value, ["reference", "montant", "created"], ["typevente_id ="=>TYPEVENTE::DIRECT]);
	$approvisionnements = APPROVISIONNEMENT::findLike($value, ["reference", "datelivraison", "created", "montant", "avance"]);
	$operations         = OPERATION::findLike($value, ["reference", "created", "montant"]);

	if (count($commandes) + count($livraisons) + count($ventes) + count($approvisionnements) + count($operations) > 0) {
		?>
		<div class="text-center">
			<?php if (count($commandes) > 0) { ?>
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsecommandes">
					<i class="fa fa-file-text-o"></i> Commandes &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-default float-right"><?= count($commandes) ?></span>
				</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }

			if (count($ventes) > 0) { ?>
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseventes">
					<i class="fa fa-cubes"></i> Ventes directes &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-default float-right"><?= count($ventes) ?></span>
				</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }

			if (count($livraisons) > 0) { ?>
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapselivraisons">
					<i class="fa fa-cubes"></i> Prospections/Livraisons &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-default float-right"><?= count($livraisons) ?></span>
				</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }

			if (count($approvisionnements) > 0) { ?>
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseapprovisionnements">
					<i class="fa fa-truck"></i> Approvisionnements &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-default float-right"><?= count($approvisionnements) ?></span>
				</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }

			if (count($operations) > 0) { ?>
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseoperations">
					<i class="fa fa-money"></i> Opérations de caisse &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-default float-right"><?= count($operations) ?></span>
				</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php } 
			?>
		</div><br>

		<div class="ibox">
			<div class="ibox-content" style="min-height: 300px">

				<div class="collapse" id="collapsecommandes">
					<div class="">
						<h2 class="text-uppercase gras">Les commandes</h2>
						<table class="table table-bordered table-commande">
							<tbody>
								<?php foreach ($commandes as $key => $commande) {
									$commande->actualise();
									$commande->fourni("lignecommande"); ?>
									<tr class="<?= ($commande->etat_id != ETAT::ENCOURS)?'fini':'' ?> border-bottom" style="border-bottom: 2px solid black">
										<td class="project-status">
											<span class="label label-<?= $commande->etat->class ?>"><?= $commande->etat->name ?></span><br><br>
											<a target="_blank" href="<?= $rooter->url("gestion", "fiches", "boncommande", $commande->getId()) ?>">
												<i class="d-block fa fa-file-text-o fa-3x"></i></a>
											</td>
											<td class="project-title border-right" style="width: 30%;">
												<h4 class="text-uppercase">Commande N°<?= $commande->reference ?></h4>
												<h6 class="text-uppercase text-muted">Client :  <?= $commande->groupecommande->client->name() ?></h6>
												<h6 class="text-uppercase text-muted">effectuée le :  <?= datelong($commande->created) ?></h6>
											</td>
											<td class="border-right" style="width: 25%">
												<h5 class="mp0"><small><?= $commande->zonedevente->name() ?></small><br> <?= $commande->lieu ?></h5>
											</td>
											<td class="border-right" style="width: 32%">
												<table class="table table-bordered">
													<thead>
														<tr class="no">
															<?php foreach ($commande->lignecommandes as $key => $ligne) { 
																$ligne->actualise(); ?>
																<th class="text-center text-uppercase"><?= $ligne->prixdevente->name() ?></th>
															<?php } ?>
														</tr>
													</thead>
													<tbody>
														<tr class="no">
															<?php foreach ($commande->lignecommandes as $key => $ligne) { ?>
																<td class="text-center"><?= $ligne->quantite ?></td>
															<?php   } ?>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									<?php  } ?>
								</tbody>
							</table>
						</div>
					</div><br><br>

					<div class="collapse" id="collapselivraisons">
						<div class="">
							<h2 class="text-uppercase gras">Les livraisons</h2>
							<table class="table table-bordered table-livraison">
								<tbody>
									<?php foreach ($livraisons as $key => $livraison) {
										$livraison->actualise();
										$livraison->fourni("ligneprospection"); ?>
										<tr class="<?= ($livraison->etat_id != ETAT::ENCOURS)?'fini':'' ?> border-bottom" style="border-bottom: 2px solid black">
											<td class="project-status">
												<span class="label label-<?= $livraison->etat->class ?>"><?= $livraison->etat->name ?></span><br><br>
												<?php if ($livraison->typeprospection_id == TYPEPROSPECTION::LIVRAISON) { ?>
													<a target="_blank" href="<?= $rooter->url("gestion", "fiches", "bonlivraison", $livraison->getId()) ?>"><i class="d-block fa fa-file-text-o fa-3x"></i></a>
												<?php }else{ ?>
													<a target="_blank" href="<?= $rooter->url("gestion", "fiches", "bonsortie", $livraison->getId()) ?>"><i class="d-block fa fa-file-text-o fa-3x"></i></a>
												<?php } ?>
											</td>
											<td class="project-title border-right" style="width: 30%;">
												<h4 class="text-uppercase">Pospection/Livraison N°<?= $livraison->reference ?></h4>
												<h6 class="text-uppercase text-muted">Zone de prospection :  <?= $livraison->zonedevente->name() ?></h6>
												<h6 class="text-uppercase text-muted">Commercial :  <?= $livraison->commercial->name() ?></h6>
												<span>Emise <?= depuis($livraison->created) ?></span>
											</td>
											<td class="border-right" style="width: 60%">
												<table class="table table-bordered">
													<thead>
														<tr class="no">
															<th></th>
															<?php foreach ($livraison->ligneprospections as $key => $ligne) { 
																$ligne->actualise(); ?>
																<th class="text-center">
																	<small><?= $ligne->prixdevente->produit->name() ?></small><br>
																	<small><?= $ligne->prixdevente->prix->price() ?></small>
																</th>
															<?php } ?>
														</tr>
													</thead>
													<tbody>
														<tbody>
															<tr class="no">
																<td><h5 class="mp0">Qté : </h5></td>
																<?php foreach ($livraison->ligneprospections as $key => $ligne) { ?>
																	<td class="text-center"><?= start0($ligne->quantite) ?> // 
																		<?php if ($livraison->etat_id == ETAT::VALIDEE) { ?>
																			<span class="text-green"><?= start0($ligne->quantite_vendu) ?></span>
																		<?php }  ?>
																	</td>
																<?php   } ?>
															</tr>
															<?php if ($livraison->etat_id == ETAT::VALIDEE) { ?>
																<tr class="no">
																	<td><h5 class="mp0">Perte :</h5></td>
																	<?php foreach ($livraison->ligneprospections as $key => $ligne) { ?>
																		<td class="text-center"><?= start0($ligne->perte) ?></td>
																	<?php   } ?>
																</tr>
															<?php } ?>
														</tbody>
													</tbody>
												</table>
											</td>
										</tr>
									<?php  } ?>
								</tbody>
							</table>
						</div><hr>
					</div>


					<div class="collapse" id="collapseventes">
						<div class="">
							<h2 class="text-uppercase gras">Les ventes</h2>
							<table class="table table-bordered table-livraison">
								<tbody>
									<?php foreach ($ventes as $key => $vente) {
										$vente->actualise();
										$vente->fourni("lignedevente"); ?>
										<tr class="<?= (date("Y-m-d", strtotime($vente->created)) != dateAjoute())?'fini':'' ?> border-bottom" style="border-bottom: 2px solid black">
											<td class="project-status">
												<span class="label label-<?= $vente->etat->class ?>"><?= $vente->etat->name ?></span><br><br>
												<a target="_blank" href="<?= $rooter->url("gestion", "fiches", "bonvente", $vente->getId()) ?>">
													<i class="d-block fa fa-file-text-o fa-3x"></i></a>
												</td>
												<td class="project-title border-right">
													<h4 class="text-uppercase">Vente directe N°<?= $vente->reference ?></h4>
													<h6 class="text-uppercase text-muted">Zone de vente :  <?= $vente->zonedevente->name() ?></h6>
													<h6 class="text-uppercase text-muted">Commercial : <?= $vente->commercial->name() ?></h6>
													<span>Emise <?= depuis($vente->created) ?></span>
												</td>
												<td class="border-right" style="width: 60%">
													<table class="table table-bordered">
														<thead>
															<tr class="no">
																<?php foreach ($vente->lignedeventes as $key => $ligne) { 
																	$ligne->actualise(); ?>
																	<th class="text-center text-uppercase"><?= $ligne->prixdevente->name() ?></th>
																<?php } ?>
															</tr>
														</thead>
														<tbody>
															<tr class="no">
																<?php foreach ($vente->lignedeventes as $key => $ligne) { ?>
																	<td class="text-center"><?= $ligne->quantite ?></td>
																<?php   } ?>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										<?php  } ?>
									</tbody>
								</table>
							</div><hr>
						</div>



						<div class="collapse" id="collapseapprovisionnements">
							<div class="">
								<h2 class="text-uppercase gras">Les approvisionnements</h2>
								<table class="table table-hover table-approvisionnement">
									<tbody>
										<?php foreach ($approvisionnements as $key => $appro) {
											$appro->actualise(); 
											$appro->fourni("ligneapprovisionnement");
											?>
											<tr class=" <?= ($appro->etat_id != ETAT::ENCOURS)?'fini':'' ?> border-bottom">
												<td class="project-status">
													<span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name ?></span><br><br>
													<a target="_blank" href="<?= $rooter->url("gestion", "fiches", "bonapprovisionnament", $appro->getId()) ?>">
														<i class="d-block fa fa-file-text-o fa-3x"></i></a>
													</td>
													<td class=" border-right" style="width: 30%;">
														<h4 class="text-uppercase">Appro. N°<?= $appro->reference ?></h4>
														<h6 class="text-uppercase text-muted">Fournisseur :  <?= $appro->fournisseur->name() ?></h6>
														<span>Enregistré le <?= depuis($appro->created) ?></span>
													</td>
													<td class="border-right" style="width: 30%">
														<table class="table table-bordered">
															<thead>
																<tr class="no">
																	<?php foreach ($appro->ligneapprovisionnements as $key => $ligne) { 
																		$ligne->actualise(); ?>
																		<th class="text-center text-uppercase"><?= $ligne->ressource->name() ?></th>
																	<?php } ?>
																</tr>
															</thead>
															<tbody>
																<tr class="no">
																	<?php foreach ($appro->ligneapprovisionnements as $key => $ligne) { ?>
																		<td class="text-center gras <?= ($appro->etat_id == ETAT::VALIDEE)?'text-primary':'' ?>"><?= $ligne->quantite_recu ?> <?= $ligne->ressource->unite ?></td>
																	<?php   } ?>
																</tr>
															</tbody>
														</table>
													</td>
													<td><span>Montant</span> <h3 class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></h3>
														<span><?= $appro->operation->structure ?> - <?= $appro->operation->numero ?></span>
													</td>
												</tr>
											<?php  } ?>
										</tbody>
									</table>
								</div><hr>
							</div>


							<div class="collapse" id="collapseoperations">
								<div class="">
									<h2 class="text-uppercase gras">Les opérations de caisse</h2>
									<table class="table table-bordered table-hover table-operation">
										<tbody class="tableau-attente">
											<?php foreach ($operations as $key => $operation) {
												$operation->actualise(); ?>
												<tr>
													<td style="background-color: rgba(<?= hex2rgb($operation->categorieoperation->color) ?>, 0.6);" width="15"><a target="_blank" href="<?= $rooter->url("gestion", "fiches", "boncaisse", $operation->getId())  ?>"><i class="fa fa-file-text-o fa-3x"></i></a></td>
													<td>
														<h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>"><?= $operation->categorieoperation->name() ?> <span><?= ($operation->etat_id == ETAT::ENCOURS)?"*":"" ?></span> <span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($operation->created) ?></span></h6>
														<i><?= $operation->comment ?></i>
													</td>
													<td class="text-center gras" style="padding-top: 12px;">
														<?= money($operation->montant) ?> <?= $params->devise ?>
													</td>
													<td width="110" class="text-center" >
														<small><?= $operation->structure ?></small><br>
														<small><?= $operation->numero ?></small>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div><hr>
							</div>

						</div>
					</div>

					<?php
				}else{ ?>
					<div class="ibox">
						<div class="ibox-content">
							<h1 style="margin-top: 6%;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-2x"></i> <br> Aucune donnée ne correspond à votre recherche !</h1><br><br><br>
						</div>
					</div>

				<?php } 

			}

			?>
