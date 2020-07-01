  
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
            <div class="col-md-3">
                <ul class="list-group clear-list">
                    <li class="list-group-item">
                        Total Actif
                        <span class="float-right">145 000 Fcfa</span>
                    </li>
                    <li class="list-group-item">
                        Total passif
                        <span class="float-right">145 000 Fcfa</span>
                    </li><br>
                    <li class="list-group-item fist-item">
                        Solde prévisionnel
                        <span class="float-right">154 015 000</span>
                    </li>
                    <li class="list-group-item">
                        Impôts et TVA
                        <span class="float-right">
                            10:16 am
                        </span>
                    </li><br>
                    <li class="list-group-item">
                        Masse salariale
                        <span class="float-right">
                            08:22 pm
                        </span>
                    </li>
                    <li class="list-group-item">
                        Dette de clients
                        <span class="float-right">
                            11:06 pm
                        </span>
                    </li>                    
                    <li class="list-group-item">
                        Dette de fournisseurs
                        <span class="float-right">145 000 Fcfa</span>
                    </li>
                </ul>
            </div>
            <div class="offset-1 col-md-8">
                <div class="flot-chart">
                    <div class="flot-chart-content" id="flot-dashboard-chart" height="700px"></div>
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
        </div><hr>

        <div class="row text-center" style="font-size: 11px">
            <div class="col-md">
                <button class="btn btn-primary dim"><i class="fa fa-cart-plus"></i> Faire nouvelle commande</button>
            </div>
            <div class="col-md">
                <button class="btn btn-success dim"><i class="fa fa-truck"></i> Bilan comptable </button>
            </div>
            <div class="col-md">
                <button class="btn btn-success dim"><i class="fa fa-truck"></i> Voir le budget prévisionnel </button>
            </div>
            <div class="col-md">
                <button class="btn btn-warning dim"><i class="fa fa-truck"></i> Documents de synthèse </button>
            </div>
            <div class="col-md">
                <button data-toggle="modal" data-target="#modal-cloture" class="btn btn-success dim"><i class="fa fa-truck"></i> Cloture de l'exercice </button>
            </div>
        </div>
    </div>
</div>