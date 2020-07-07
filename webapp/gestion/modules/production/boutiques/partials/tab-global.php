<div role="tabpanel" id="pan-global" class="tab-pane">

	<div class=" border-bottom white-bg dashboard-header">
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-4">
						<img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="height: 60px;" alt=""><br>
						<h2 class="text-uppercase"><?= $boutique->name() ?></h2>
						<small><?= $boutique->lieu ?> </small>
						<ul class="list-group clear-list m-t">
							<li class="list-group-item fist-item">
								Commandes en cours <span class="label label-success float-right"><?= start0(count($groupes__)); ?></span> 
							</li>
							<li class="list-group-item">
								Livraisons en cours <span class="label label-success float-right"><?= start0(count(Home\PROSPECTION::findBy(["etat_id ="=>Home\ETAT::ENCOURS, "boutique_id ="=>$boutique->id, "typeprospection_id ="=>Home\TYPEPROSPECTION::LIVRAISON]))); ?></span> 
							</li>
							<li class="list-group-item">
								Prospections en cours <span class="label label-success float-right"><?= start0(count(Home\PROSPECTION::findBy(["etat_id ="=>Home\ETAT::ENCOURS, "boutique_id ="=>$boutique->id, "typeprospection_id ="=>Home\TYPEPROSPECTION::PROSPECTION]))); ?></span> 
							</li>
							<li class="list-group-item"></li>
						</ul>
					</div>
					<div class="col-md-8">
						<div class="flot-chart" style="height: 220px">
							<div class="flot-chart-content" id="flot-dashboard-chart"></div>
						</div><hr>
						<div class="row text-center">
							<div class="col">
								<div class="">
									<span class="h5 font-bold block"><?= money(comptage(Home\VENTE::todayDirect($boutique->id), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
									<small class="text-muted block">Ventes directes</small>
								</div>
							</div>
							<div class="col border-right border-left">
								<span class="h5 font-bold block"><?= money(comptage(Home\PROSPECTION::effectuee(dateAjoute(), $boutique->id), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
								<small class="text-muted block">Ventes par prospection</small>
							</div>
							<div class="col text-danger">
								<span class="h5 font-bold block"><?= money(Home\OPERATION::sortie(dateAjoute() , dateAjoute(+1), $boutique->id)) ?> <small><?= $params->devise ?></small></span>
								<small class="text-muted block">Dépense du jour</small>
							</div>
						</div>
					</div>
				</div><hr>
				<div class="text-center row">
					<div class="col">
						<button data-toggle=modal data-target="#modal-vente" class="btn btn-warning dim"> <i class="fa fa-long-arrow-right"></i> Nouvelle vente directe</button>
					</div>
					<div class="col">
						<button data-toggle="modal" data-target="#modal-prospection" class="btn btn-primary dim"><i class="fa fa-bicycle"></i> Nouvelle prospection</button>
					</div>
					<div class="col">
						<button data-toggle="modal" data-target="#modal-ventecave" class="btn btn-success dim"><i class="fa fa-home"></i> Nouvelle vente en cave</button>
					</div>
				</div>
			</div>
			<div class="col-md-3 border-left">
				<div class="statistic-box" style="margin-top: 0%">
					<div class="ibox">
						<div class="ibox-content">
							<h5>Courbe des ventes</h5>
							<div id="sparkline2"></div>
						</div>

						<div class="ibox-content">
							<h5>Dette chez les clients</h5>
							<h2 class="no-margins"><?= money(Home\CLIENT::Dettes()); ?> <?= $params->devise  ?></h2>
						</div>

						<div class="ibox-content">
							<h5>En rupture de Stock</h5>
							<h2 class="no-margins"><?= start0($rupture) ?> produit(s)</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr><hr class="mp0"><br>

		<div class="row">
			<?php foreach ($produits as $key => $produit) { ?>
				<div class="col-md border-right">
					<h6 class="text-uppercase text-center gras" style="color: <?= $produit->couleur; ?>">Stock de <?= $produit->name() ?></h6>
					<ul class="list-group clear-list m-t">
						<?php foreach ($tableaux[$produit->id] as $key => $pdv) { ?>
							<li class="list-group-item <?= ($pdv->rupture)?"rupture":""  ?>" >
								<i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i> <small><?= $pdv->quantite ?></small>          
								<span class="float-right">
									<span title="en boutique" class="gras text-<?= ($pdv->boutique > 0)?"green":"danger" ?>"><?= money($pdv->boutique) ?></span>
								</span>
							</li>
						<?php } ?>
						<li class="list-group-item"></li>
					</ul>
				</div>
			<?php } ?>
		</div>
	</div>
</div>