<div role="tabpanel" id="pan-rapport" class="tab-pane">

	<div class="ibox-content">
		<br>
		<div class="tabs-container produits">
			<ul class="nav nav-tabs text-uppercase" role="tablist">
				<li ><a class="nav-link active" data-toggle="tab" href="#pan-0"><i class="fa fa-flask" ></i> Global</a></li>
				<?php foreach ($produits as $key => $produit) { ?>
					<li style=" border-bottom: 3px solid <?= $produit->couleur; ?>,"><a class="nav-link" data-toggle="tab" href="#pan-<?= $produit->id ?>"><i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i> <?= $produit->name() ?></a></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="pan-0" class="tab-pane active">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 border-right border-left text-center">
								<div class="row">
									<div class="col-sm-3 border-right">
										<h5 class="text-uppercase">Parfum le plus vendu</h5><br>
										<canvas id="myChart1"></canvas>
									</div>

									<div class="col-sm-6 text-center">
										<div class="flot-chart">
											<div class="flot-chart-content" id="flot-dashboard-chart1"></div>
										</div><br><br>
										<span>Vente directe / vente par prospection</span>
										<hr>
										<div class="row text-center">
											<div class="col">
												<div class="">
													<span class="h5 font-bold block text-primary"><?= money(comptage(Home\VENTE::direct($date1, $date2, $boutique->id), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
													<small class="text-muted block">Ventes directes</small>
												</div>
											</div>
											<div class="col border-right border-left text-danger">
												<span class="h5 font-bold block"><?= money(comptage(Home\VENTE::prospection($date1, $date2, $boutique->id), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
												<small class="text-muted block">Ventes par prospection</small>
											</div>
											<div class="col text-blue">
												<span class="h5 font-bold block"><?= money(comptage(Home\VENTE::cave($date1, $date2, $boutique->id), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
												<small class="text-muted block">Ventes en cave</small>
											</div>
										</div>
									</div>

									<div class="col-sm-3 border-left">
										<h5 class="text-uppercase">Emballage le plus vendu</h5><br>
										<canvas id="myChart3"></canvas>
									</div>
								</div><hr> 
							</div>
						</div>

					</div>
				</div>

				<?php foreach ($produits as $key => $produit) {
					$total = 0; ?>
					<div role="tabpanel" id="pan-<?= $produit->id ?>" class="tab-pane">
						<div class="panel-body"><br>
							<div class="row">
								<div class="col-md-3">
									<h3 class="text-uppercase">Stock de <?= $produit->name() ?></h3>
									<ul class="list-group text-left clear-list m-t">
										<?php foreach ($tableaux[$produit->id] as $key => $pdv) { 
											$total += $pdv->pdv->montantVendu($date1, $date2, $boutique->id); ?>
											<li class="list-group-item">
												<i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i>&nbsp;&nbsp;&nbsp; <?= $pdv->name ?>                                        
												<span class="float-right">
													<span class="label label-<?= ($pdv->boutique>0)?"success":"danger" ?>"><?= money($pdv->boutique) ?></span>&nbsp;&nbsp;
												</span>
											</li>
										<?php } ?>
										<li class="list-group-item"></li>
									</ul>

									<div class="ibox">
										<div class="ibox-content">
											<h5>Estimation des ventes sur la période</h5>
											<h1 class="no-margins"><?= money($total) ?> <?= $params->devise ?></h1>
										</div><br>
									</div>
								</div>

								<div class="col-md-7 border-right border-left">
									<div class="" style="margin-top: 0%">
										<div class="row">
											<div class="col-sm">
												<div class="carre bg-primary"></div><span>Quantité vendue</span>
											</div>
											<div class="col-sm">
												<div class="carre bg-success"></div><span>Quantité livrée</span>
											</div>
											<div class="col-sm">
												<div class="carre bg-danger"></div><span>Quantité perdue</span>
											</div>
										</div><hr class="mp3">
										<table class="table table-bordered table-hover text-center">
											<thead>
												<tr>
													<th rowspan="2" class="border-none"></th>
													<?php 
													$lots = $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI], [], ["quantite_id"=>"ASC"]) ;
													foreach ($tableaux[$produit->id] as $key => $pdv) { ?>
														<th><small><?= $pdv->quantite ?></small></th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
												<?php $i =0;
												foreach ($productionjours as $key => $production) {
													$i++; ?>
													<tr>
														<td><?= datecourt($production->ladate)  ?></td>
														<?php foreach ($tableaux[$produit->id] as $key => $pdv) {
															$pdv->tab[] = $pdv->pdv->montantVendu($production->ladate, $production->ladate, $boutique->id);
															?>
															<td>
																<h5 class="d-inline text-green"><?= start0($pdv->pdv->vendu($production->ladate, $production->ladate, $boutique->id)); ?></h5> &nbsp;&nbsp;|&nbsp;&nbsp;

																<h5 class="d-inline text-success"><?= start0($pdv->pdv->livree($production->ladate, $production->ladate, $boutique->id)) ?></h5> &nbsp;&nbsp;|&nbsp;&nbsp;

																<h5 class="d-inline text-danger"><?= start0($pdv->pdv->perteProspection($production->ladate, $production->ladate, $boutique->id)); ?></h5>
															</td>
														<?php } ?>
													</tr>
												<?php } ?>
												<tr style="height: 18px;"></tr>
												<tr>
													<td class="text-center"><h4 class="text-center gras text-uppercase mp0">Vente totale</h4></td>
													<?php foreach ($tableaux[$produit->id] as $key => $pdv) { ?>
														<td><h3 class="text-green gras" ><?= money($pdv->pdv->montantVendu($date1, $date2, $boutique->id)) ?> <?= $params->devise ?></h3></td>
													<?php } ?>
												</tr>
											</tbody>
										</table>   
									</div>
								</div>

								<div class="col-md-2">
									<?php foreach ($tableaux[$produit->id] as $key => $pdv) { ?>
										<div class="ibox">
											<div class="ibox-content">
												<h5>Courbe des ventes de <?= $pdv->pdv->quantite->name() ?></h5>
												<div id="sparkline-<?= $pdv->id ?>"></div>
											</div>
										</div>
									<?php } ?>
								</div>

							</div>
						</div>
					</div>
					<?php 
					$tabvendu[$produit->id] = $total;
				} ?>

			</div>

		</div>


	</div>
</div>