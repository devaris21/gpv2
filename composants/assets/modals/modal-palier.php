<div class="modal inmodal fade" id="modal-palier">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Formulaire de palier</h4>
				<small>Veuillez renseigner les champs pour enregistrer le palier</small>
			</div>
			<form method="POST" class="formShamman" classname="palier">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-4">
							<label>Libéllé </label>
							<div class="form-group">
								<input type="text" class="form-control" name="name" required>
							</div>
						</div>
						<div class="col-sm-4">
							<label>Reduction </label>
							<div class="form-group">
								<input type="number" class="form-control" name="reduction" required>
							</div>
						</div>
						<div class="col-sm-4">
							<label>Type de reduction </label>
							<div class="form-group">
								<?php Native\BINDING::html("select", "typereduction") ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label>Prix minimum </label>
							<div class="form-group">
								<input type="number" class="form-control" name="min" required>
							</div>
						</div>
						<div class="col-sm-6">
							<label>Prix minimum </label>
							<div class="form-group">
								<input type="number" class="form-control" name="max" required>
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
