  <div role="tabpanel" id="tab-banques" class="tab-pane">
    <div class="panel-body">
       <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5 class="text-uppercase">Comptes & Banques</h5>
                    <div class="float-right">
                        <div class="btn-group">
                            <button type="button" data-toggle="modal" data-target="#modal-comptebanque" class="btn btn-xs btn-white active"><i class="fa fa-plus"></i> Ajouter un compte/banque</button>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="flot-chart" style="height: 250px">
                                <div class="flot-chart-content" id="flot-line-chart-multi"></div>
                            </div><hr>
                            <div class="row text-center">
                                <div class="col-md">
                                    <button data-toggle="modal" data-target="#modal-transfertfond" class="btn btn-warning dim"><i class="fa fa-exchange"></i> Transfert de fonds </button>
                                </div>
                            </div>
                        </div>
                        <div class="offset-1 col-lg-3">
                            <ul class="stat-list">
                                <?php foreach (Home\COMPTEBANQUE::getAll() as $key => $banque) { ?>
                                    <li onclick="session('comptebanque_id', <?= $banque->id ?>)" class="cursor" data-toggle="modal" data-target="#modal-optioncompte-<?= $banque->id ?>">
                                        <h2 class="no-margins"><?= money($banque->solde(Home\PARAMS::DATE_DEFAULT, dateAjoute())) ?> <?= $params->devise ?></h2>
                                        <small><?= $banque->name() ?></small>
                                        <div class="stat-percent">à jour <i class="fa fa-calendar text-navy"></i></div>
                                        <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div>
                                    </li><br>
                                <?php } ?>
                            </ul>
                        </div>
                    </div><hr><br>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
