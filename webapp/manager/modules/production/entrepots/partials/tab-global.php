<div role="tabpanel" id="pan-global" class="tab-pane">
	<div class=" border-bottom white-bg dashboard-header">
		<div class="ibox">
			<div class="ibox-title">
				<h5 class="float-left">Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
				<div class="ibox-tools">
					<form id="formFiltrer" method="POST">
						<div class="row" style="margin-top: -1%">
							<div class="col-5">
								<input type="date" value="<?= $date1 ?>" class="form-control input-sm" name="date1">
							</div>
							<div class="col-5">
								<input type="date" value="<?= $date2 ?>" class="form-control input-sm" name="date2">
							</div>
							<div class="col-2">
								<button type="button" onclick="filtrer()" class="btn btn-sm btn-white"><i class="fa fa-search"></i> Filtrer</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		<br>
			<div class="ibox-content">
				 <div class="row">
                        <div class="col-md-3">
                            <div class="text-center" style="margin-top: 15%;">
                                <img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="width: 70%;" alt=""><br>
                                <h2 class="text-uppercase"><?= $entrepot->name() ?></h2><br>
                            </div>
                        </div>
                        <div class="col-md-9 border-left">
                            <div class="row text-center">
                                <div class="col-sm-4 border-left border-bottom">
                                    <div class="p-lg">
                                        <i class="fa fa-free-code-camp fa-3x text-dark"></i>
                                        <h1 class="m-xs"><?= start0(count(Home\LIGNEPRODUCTION::findBy(["DATE(created) ="=>dateAjoute()])))  ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Production</h3>
                                        <small>Aujourd'hui</small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left border-bottom">
                                    <div class="p-lg">
                                        <i class="fa fa-codepen fa-3x text-danger"></i>
                                        <h2 class="m-xs"><?= start0(count(Home\EMBALLAGE::ruptureEntrepot()))  ?></h2>
                                        <h4 class="no-margins text-uppercase gras">Rupture d'emballages</h4>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left border-bottom">
                                    <div class="p-lg">
                                        <i class="fa fa-cubes fa-3x text-danger"></i>
                                        <h2 class="m-xs"><?= start0(count(Home\RESSOURCE::ruptureEntrepot()))  ?></h2>
                                        <h4 class="no-margins text-uppercase gras">Rupture de ressources</h4>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left">
                                    <div class="p-lg">
                                        <i class="fa fa-stack-overflow fa-3x text-dark"></i>
                                        <h1 class="m-xs"><?= start0(count($approvisionnements__)); ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Appro en cours</h3>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left">
                                    <div class="p-lg">
                                        <i class="fa fa-truck fa-3x text-orange"></i>
                                        <h1 class="m-xs"><?= start0(count($entrepot->fourni("miseenboutique", ["etat_id ="=>Home\ETAT::PARTIEL, "entrepot_id="=>$entrepot->id]))); ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Demandes de depôt</h3>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left">
                                    <div class="p-lg">
                                        <i class="fa fa-truck fa-3x text-green"></i>
                                        <h1 class="m-xs"><?= start0(count($entrepot->fourni("miseenboutique", ["etat_id ="=>Home\ETAT::ENCOURS, "entrepot_id="=>$entrepot->id]))); ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Depôts en cours</h3>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
			</div>
		</div>
	</div><hr>
</div>

