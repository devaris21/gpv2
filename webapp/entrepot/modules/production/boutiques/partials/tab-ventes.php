<div role="tabpanel" id="pan-ventes" class="tab-pane">
	<div class="panel-body">

		<?php  
		$index = $date2;
		while ($index >= $date1) { ?>
		<h2><?= datecourt3($index);  ?></h2><hr>
		<div class="row">
			<div class="col-lg-7">
				<div class="ibox ">
					<div class="ibox-title">
						<h5 class="text-uppercase">Programme de prospection du jour</h5>
						<div class="ibox-tools">
							
						</div>
					</div>
					<div class="ibox-content table-responsive">
						<table class="table table-hover no-margins">
							<thead>
								<tr>
									<th>Commercial</th>
									<th class="">Heure de sortie</th>
									<th class="">Total</th>
									<th class="">vendu</th>
									<th class="">heure de retour</th>
									<th class="">statut</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach (Home\PROSPECTION::programmee($index) as $key => $prospection) {
									$prospection->actualise(); ?>
									<tr>
										<td><?= $prospection->commercial->name()  ?></td>
										<td><?= depuis($prospection->created)  ?></td>
										<td><?= money($prospection->montant) ?> <?= $params->devise ?></td>
										<td class="gras text-green"><?= money($prospection->vendu) ?> <?= $params->devise ?></td>
										<td><?= depuis($prospection->dateretour)  ?></td>
										<td class="text-center"><span class="label label-<?= $prospection->etat->class ?>"><?= $prospection->etat->name ?></span> </td>
									</tr>
								<?php } ?>
								<tr>
									<td class="text-right" colspan="5">
										<h2><?= money(comptage(Home\VENTE::prospection($index, $index, $boutique->getId()), "vendu", "somme"))  ?> <?= $params->devise ?></h2>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div> 


			<div class="col-sm-5">
				<div class="ibox ">
					<div class="ibox-title">
						<h5 class="text-uppercase">Ventes directes du jour</h5>
						<div class="ibox-tools">

						</div>
					</div>
					<div class="ibox-content table-responsive">
						<table class="table table-hover no-margins">
							<thead>
								<tr>
									<th></th>
									<?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $qte) { ?>
										<th class="text-center"><?= $qte->name()  ?></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach (Home\PRODUIT::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $produit) {
									$datas = $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI]); ?>
									<tr>
										<td class="gras" style="color: <?= $produit->couleur ?>"><i class="fa fa-flask"></i> <?= $produit->name() ?></td>
										<?php $total =0; foreach ($datas as $key => $pdv) {
											$pdv->actualise();
											$nb = $pdv->vendeDirecte($index, $index, $boutique->getId());
											$total += $nb * $pdv->prix->price;  ?>
											<td class="text-center"><?= $nb ?></td>
										<?php } ?>
										<td class="text-right gras"><?= money($total) ?> <?= $params->devise ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td class="text-right" colspan="5">
										<h2><?= money(comptage(Home\VENTE::direct($index, $index, $boutique->getId()), "vendu", "somme"))  ?> <?= $params->devise ?></h2>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>              
		</div><hr>
			<?php
			$index = dateAjoute1($index, -1);
		}  ?>

	</div>
</div>