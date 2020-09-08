


<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<?php include($this->rootPath("composants/assets/modals/modal-parfum.php") );  ?>
<?php include($this->rootPath("composants/assets/modals/modal-ressource.php") );  ?>


<div class="modal inmodal fade" id="modal-zonedevente">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">zone de vente</h4>
			</div>
			<form method="POST" class="formShamman" classname="zonedevente">
				<div class="modal-body">
					<div class="">
						<label>Libéllé </label>
						<div class="form-group">
							<input type="text" class="form-control" name="name" required>
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


<div class="modal inmodal fade" id="modal-typeproduit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Type de produit</h4>
				<small>Veuillez renseigner les champs pour enregistrer les informations</small>
			</div>
			<form method="POST" class="formShamman" classname="typeproduit">
				<div class="modal-body">
					<div class="">
						<label>Type de produit </label>
						<div class="form-group">
							<input type="text" class="form-control" name="name" required>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<label>Unité de mesure </label>
							<div class="form-group">
								<input type="text" class="form-control" name="unite" required placeholder="Ex... Litre">
							</div>
						</div>
						<div class="col-sm-6">
							<label>abbréviation </label>
							<div class="form-group">
								<input type="text" class="form-control" name="abbr" placeholder="Ex... L" required>
							</div>
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



<div class="modal inmodal fade" id="modal-quantite">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Quantite de vente</h4>
				<small>Veuillez renseigner les champs pour enregistrer la quantité</small>
			</div>
			<form method="POST" class="formShamman" classname="quantite">
				<div class="modal-body">
					<div class="">
						<label>Quantité de vente </label>
						<div class="form-group">
							<input type="number" step="0.01" class="form-control" name="name" required>
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




<div class="modal inmodal fade" id="modal-emballage">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Les formats d'emballages</h4>
				<small>Veuillez renseigner les champs pour enregistrer les informations</small>
			</div>
			<form method="POST" class="formShamman" classname="emballage">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label>Nom du format d'emballage </label>
							<div class="form-group">
								<input type="text" class="form-control" name="name" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label>Composé de ... (Nombre)</label>
							<div class="form-group">
								<input type="number" class="form-control" name="quantite" required>
							</div>
						</div>
						<div class="col-sm-6">
							<label>Format emballage</label>
							<select class="form-control select2" name="quantite_id" style="width: 100%">
									<option value="">Emballage primaire</option>
									<?php foreach (Home\EMBALLAGE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $item) { ?>
										<option value="<?= $item->id ?>">de <?= $item->name() ?></option>
									<?php } ?>
								</select>	
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label>Qté initial </label>
							<div class="form-group">
								<input type="number" class="form-control" name="initial" required>
							</div>
						</div>
						<div class="col-md-8">
							<label>Image du format </label>
							<div class="">
								<img style="width: 80px;" src="" class="img-thumbnail logo">
								<input class="hide" type="file" name="image">
								<button type="button" class="btn btn-sm bg-orange pull-right btn_image"><i class="fa fa-image"></i> Ajouter une image</button>
							</div>
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



<div class="modal inmodal fade" id="modal-caracteristiqueemballage">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Formulaire des caractéristique de'emballage</h4>
				<small>Veuillez saisir les type de produit que supporte l'emballage</small>
			</div>
			<form method="POST" class="formShamman" classname="caracteristiqueemballage">
				<div class="modal-body">
					<div class="text-center">
						<div class="row justify-content-center">
							<div class="col-sm-4">
							<?php Native\BINDING::html("select", "emballage") ?>
							</div>	
						</div><br>
						<h4>Peut contenir  <br><i class=" fa fa-2x fa-long-arrow-right"></i></h4>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<label>Type de produit</label>
							<div class="form-group">
								<select class="form-control select2" name="typeproduit_id" style="width: 100%">
									<option value="">Tous les produits</option>
									<?php foreach (Home\TYPEPRODUIT::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $item) { ?>
										<option value="<?= $item->id ?>">Seulement les <?= $item->name() ?></option>
									<?php } ?>
								</select>										
							</div>
						</div>	
						<div class="col-sm-4">
							<label>Parfum</label>
							<div class="form-group">
								<select class="form-control select2" name="parfum_id" style="width: 100%">
									<option value="">de Tous les parfums</option>
									<?php foreach (Home\PARFUM::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $item) { ?>
										<option value="<?= $item->id ?>">de <?= $item->name() ?></option>
									<?php } ?>
								</select>										
							</div>
						</div>
						<div class="col-sm-4">
							<label>Quantité</label>
							<div class="form-group">
								<select class="form-control select2" name="quantite_id" style="width: 100%">
									<option value="">de Toutes les quantités</option>
									<?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $item) { ?>
										<option value="<?= $item->id ?>">de <?= $item->name() ?></option>
									<?php } ?>
								</select>										
							</div>
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




