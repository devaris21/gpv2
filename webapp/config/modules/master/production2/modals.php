

<div class="modal inmodal fade" id="modal-prixdevente-stock">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Formulaire de prix de vente</h4>
			</div>
			<form method="POST" class="formShamman" classname="prixdevente">
				<div class="modal-body">
					<div class="">
						<label>Stock intial </label>
						<div class="form-group">
							<input type="text" class="form-control" name="stock" required>
						</div>
					</div>
				</div><hr>
				<div class="container">
					<input type="hidden" name="id">
					<button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
					<button class="btn btn-sm btn-primary pull-right dim"><i class="fa fa-check"></i> enregistrer</button>
				</div>
				<br>
			</form>
		</div>
	</div>
</div>




<?php foreach ($types_parfums as $key => $type) {
	$lots = $type->fourni('exigenceproduction');
	if (count($lots) > 0) {
		$exi = $lots[0];
		$exi->actualise();
		$lots = $exi->fourni('ligneexigenceproduction'); ?>
		<div class="modal inmodal fade" id="modal-exigence<?= $type->id ?>">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Formulaire des exigence de production</h4>
						<small>Veuillez saisir les quantités de chaque ressources néccessaire pour la production</small>
					</div>
					<form method="POST" class="formExigence">
						<div class="modal-body">
							<div class="text-center">
								<div class="row">
									<div class="offset-sm-5 col-sm-2">
										<input type="number" name="quantite" class="form-control" value="<?= $exi->quantite; ?>">
									</div>	
									<div class="col-sm-1"><?= $exi->typeproduit_parfum->typeproduit->abbr ?></div>	
								</div>
								<h2 class="text-uppercase"><?= $exi->typeproduit_parfum->name() ?> (en <?= $exi->typeproduit_parfum->typeproduit->unite ?>)</h2>
								<h4>utilise <br><i class=" fa fa-2x fa-long-arrow-right"></i></h4>
							</div>

							<div class="row">
								<?php foreach ($lots as $key => $ligne) { 
									$ligne->actualise(); ?>
									<div class="col-sm-2">
										<label><?= $ligne->ressource->name() ?> (<?= $ligne->ressource->abbr ?>)</label>
										<div class="form-group">
											<input type="number" number name="<?= $ligne->id ?>" class="form-control" value="<?= $ligne->quantite; ?>">
										</div>
									</div>					
								<?php } ?>
							</div>

						</div><hr>
						<div class="container">
							<input type="hidden" name="id" value="<?= $exi->id; ?>">
							<button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
							<button class="btn btn-sm btn-primary pull-right dim"><i class="fa fa-check"></i> enregistrer</button>
						</div>
						<br>
					</form>
				</div>
			</div>
		</div>
	<?php } 
} ?>

