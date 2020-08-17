  
<div role="tabpanel" id="tab-global" class="tab-pane active">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-5">
                <h1 class="mp0 d-inline">Trésorerie générale</h1> <span> /// <?= datecourt($exercice->created) ?> - <?= datecourt($exercice->datefin) ?></span>
            </div>

            <div class="offset-4 col-sm-3 text-center">
                <div class="form-group">
                    <?php Native\BINDING::html("select-tableau", Home\EXERCICECOMPTABLE::findBy([], [], ["created"=>"DESC"]), null, "exercicecomptable_id"); ?>
                </div>
            </div>
        </div>
        

        <div class="row white-bg dashboard-header">
            <div class="col-md-3" style="font-size: 12px">
                <br><br>
                <button class="btn btn-primary dim btn-block"><i class="fa fa-truck"></i> Bilan comptable </button>
                <button class="btn btn-success dim btn-block"><i class="fa fa-truck"></i> Voir le budget prévisionnel </button>
                <button class="btn btn-warning dim btn-block"><i class="fa fa-truck"></i> Documents de synthèse </button>
                <button data-toggle="modal" data-target="#modal-cloture" class="btn btn-success dim btn-block"><i class="fa fa-truck"></i> Cloture de l'exercice </button>
            </div>
            <div class="col-md-9">
                <div class="flot-chart ">
                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                </div><hr>
                <div class="row text-center">
                    <div class="col">
                        <div class=" m-l-md">
                            <span class="h6 font-bold block text-blue"><?= money(Home\COMPTEBANQUE::tresorerie()) ?> <?= $params->devise ?></span>
                            <small class="text-muted block">Trésorerie nette</small>
                        </div>
                    </div>
                    <div class="col">
                        <span class="h5 font-bold block text-primary"><?= money($caisse->solde()) ?> <?= $params->devise ?></span>
                        <small class="text-muted block">Caisse courante</small>
                    </div>
                    <div class="col">
                        <span class="h6 font-bold block text-warning"><?= money(Home\OPERATION::resultat($exercice->created , $exercice->datefin())) ?> <?= $params->devise ?></span>
                        <small class="text-muted block">Resultat net</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>