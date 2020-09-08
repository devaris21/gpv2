<div class="modal inmodal fade" id="modal-ressource">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Formulaire de ressource</h4>
				<small>Veuillez renseigner les champs pour enregistrer la ressource</small>
			</div>
			<form method="POST" class="formShamman" classname="ressource">
				<div class="modal-body">
					<div class="row">
						
						<div class="col-sm-4">
							<label>Libéllé </label>
							<div class="form-group">
								<input type="text" class="form-control" name="name" required>
							</div>
						</div>
						<div class="col-sm-4">
							<label>Unité de mesure </label>
							<div class="form-group">
								<input type="text" class="form-control" name="unite" required placeholder="Ex... tonne">
							</div>
						</div>
						<div class="col-sm-4">
							<label>abbréviation </label>
							<div class="form-group">
								<input type="text" class="form-control" name="abbr" placeholder="Ex... T" required>
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
