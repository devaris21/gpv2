<div role="tabpanel" id="pan-stock" class="tab-pane">
	<div class="panel-body">

		
        <div class="tabs-container produits">

            <ul class="nav nav-tabs">
                <li><a class="nav-link text-uppercase active" data-toggle="tab" href="#tab-1"><i class="fa fa-globe"></i> Stock des matières premières</a></li>
                <li><a class="nav-link text-uppercase" data-toggle="tab" href="#tab-2"><i class="fa fa-globe"></i> Stock des emballages</a></li>
                <li><a class="nav-link text-uppercase" data-toggle="tab" href="#tab-3"><i class="fa fa-globe"></i> Stock des etiquettes</a></li>
            </ul>
            <div class="tab-content " id="produits">

                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <h3 class="text-uppercase">Stock des matières prémières</h3>
                                <ul class="list-group text-left clear-list m-t">
                                    <?php $total = 0; foreach ($ressources as $key => $ressource) {
                                        $stock = $ressource->stock(dateAjoute());
                                        $prix = $stock * $ressource->price();
                                        $total += $prix ?>
                                        <li class="list-group-item">
                                            <i class="fa fa-cubes" ></i>&nbsp;&nbsp;&nbsp; <?= $ressource->name() ?>       
                                            <span class="float-right">
                                                <span class="label label-<?= ($stock > 0)?"success":"danger" ?>"><?= money($stock) ?> <?= $ressource->abbr ?></span>
                                                &nbsp;&nbsp;&nbsp;<span class="float-right"><?= money($prix) ?> <?= $params->devise ?></span>
                                            </span>
                                        </li>
                                    <?php } ?>
                                    <li class="list-group-item"></li>
                                </ul>

                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Estimation du stock actuel</h5>
                                        <h1 class="no-margins"><?= money($total) ?> <?= $params->devise ?></h1>
                                    </div><br>
                                </div>
                            </div>

                            <div class="col-md-9 border-right border-left">
                                <div class="" style="margin-top: 0%">

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="carre bg-success"></div><span>Quantité consommée</span>
                                        </div>
                                        <div class="col-sm">
                                            <div class="carre bg-warning"></div><span>Quantité approvisionnée</span>
                                        </div>
                                        <div class="col-sm">
                                            <div class="carre bg-green"></div><span>Stock de fin de journée</span>
                                        </div>
                                    </div><hr>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="border-none"></th>
                                                <?php foreach ($ressources as $key => $ressource) {  ?>
                                                    <th><small><?= $ressource->name() ?></small></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =0;
                                            foreach ($productionjours as $key => $production) { ?>
                                                <tr>
                                                    <td><?= datecourt($production->ladate)  ?></td>
                                                    <?php
                                                    $production->fourni("ligneconsommationjour");
                                                    foreach ($ressources as $key => $ressource) {
                                                        foreach ($production->ligneconsommationjours as $key => $ligne) {
                                                            if ($ressource->id == $ligne->ressource_id) { 
                                                                ?>
                                                                <td>
                                                                    <h5 class="d-inline text-success gras"><?= start0($ligne->consommation) ?></h5>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                                    <h5 class="d-inline text-warning gras"><?= start0($ressource->achat($production->ladate, $production->ladate)) ?></h5> |&nbsp;&nbsp; <h5 class="d-inline text-green gras"><?= start0($ressource->stock($production->ladate)) ?></h5>
                                                                </td>
                                                            <?php }
                                                        }
                                                    } ?>
                                                </tr>
                                            <?php } ?>
                                            <tr style="height: 18px;"></tr>
                                        </tbody>
                                    </table> 

                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <div id="tab-2" class="tab-pane ">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <h3 class="text-uppercase">Stock des emballages</h3>
                                <ul class="list-group text-left clear-list m-t">
                                    <?php $total = 0; foreach ($emballages as $key => $ressource) {
                                        $stock = $ressource->stock(dateAjoute());
                                        $prix = $stock * $ressource->price();
                                        $total += $prix ?>
                                        <li class="list-group-item">
                                            <i class="fa fa-cubes" ></i>&nbsp;&nbsp;&nbsp; <?= $ressource->name() ?>       
                                            <span class="float-right">
                                                <span class="label label-<?= ($stock > 0)?"success":"danger" ?>"><?= money($stock) ?></span>
                                                &nbsp;&nbsp;&nbsp;<span class="float-right"><?= money($prix) ?> <?= $params->devise ?></span>
                                            </span>
                                        </li>
                                    <?php } ?>
                                    <li class="list-group-item"></li>
                                </ul>

                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Estimation du stock actuel</h5>
                                        <h1 class="no-margins"><?= money($total) ?> <?= $params->devise ?></h1>
                                    </div><br>
                                </div>
                            </div>

                            <div class="col-md-9 border-right border-left">
                                <div class="" style="margin-top: 0%">

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="carre bg-success"></div><span>Quantité consommée</span>
                                        </div>
                                        <div class="col-sm">
                                            <div class="carre bg-warning"></div><span>Quantité approvisionnée</span>
                                        </div>
                                        <div class="col-sm">
                                            <div class="carre bg-green"></div><span>Stock de fin de journée</span>
                                        </div>
                                    </div><hr>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="border-none"></th>
                                                <?php foreach ($emballages as $key => $ressource) {  ?>
                                                    <th class="text-center"><small><?= $ressource->name() ?></small></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =0;
                                            foreach ($productionjours as $key => $production) { ?>
                                                <tr>
                                                    <td><?= datecourt($production->ladate)  ?></td>
                                                    <?php
                                                    $production->fourni("ligneconsommationjour");
                                                    foreach ($emballages as $key => $ressource) {
                                                        foreach ($production->ligneconsommationjours as $key => $ligne) {
                                                            if ($ressource->id == $ligne->ressource_id) { 
                                                                $achat = $ressource->achat($production->ladate, $production->ladate);
                                                                $stock = $ressource->stock($production->ladate); ?>
                                                                <td class="text-center">
                                                                    <h5 class="d-inline text-success gras"><?= ($ligne->consommation > 0)? start0($ligne->consommation):"" ?></h5>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                                    <h5 class="d-inline text-warning gras"><?= ($achat > 0)?start0($achat):"" ?></h5> |&nbsp;&nbsp; <h5 class="d-inline text-dark gras"><?= ($stock > 0)?start0($stock):"" ?></h5>
                                                                </td>
                                                            <?php }
                                                        }
                                                    } ?>
                                                </tr>
                                            <?php } ?>
                                            <tr style="height: 18px;"></tr>
                                        </tbody>
                                    </table> 

                                </div>
                            </div>

                        </div>
                    </div>
                </div>




                <div id="tab-3" class="tab-pane ">
                    <div class="panel-body">

                        <div class="ibox-content">
                            <br>
                            <div class="tabs-container produits" id="">
                                <ul class="nav nav-tabs text-uppercase" role="tablist">
                                    <?php foreach ($produits as $key => $produit) { ?>
                                        <li style=" border-bottom: 3px solid <?= $produit->couleur; ?>,"><a class="nav-link" data-toggle="tab" href="#pan-<?= $produit->id ?>"><i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i> <?= $produit->name() ?></a></li>
                                    <?php } ?>
                                </ul>
                                <div class="tab-content">
                                    <?php foreach ($produits as $key => $produit) {
                                        $requette = "SELECT * FROM etiquette, prixdevente WHERE etiquette.prixdevente_id = prixdevente.id AND prixdevente.isActive =? AND prixdevente.produit_id = ?";
                                        $etiquettes = Home\ETIQUETTE::execute($requette, [Home\TABLE::OUI, $produit->id]);
                                        $total = 0; ?>
                                        <div role="tabpanel" id="pan-<?= $produit->id ?>" class="tab-pane">
                                            <div class="panel-body"><br>
                                                <div class="row">
                                                    <div class="col-md-4 text-left">
                                                        <h3 class="text-uppercase">Stock des etiquettes</h3>
                                                        <ul class="list-group text-left clear-list m-t">
                                                            <?php $total = 0; foreach ($etiquettes as $key => $etiq) {
                                                                $stock = $etiq->stock(dateAjoute());
                                                                $prix = $stock * $etiq->price();
                                                                $total += $prix ?>
                                                                <li class="list-group-item">
                                                                    <i class="fa fa-cubes" ></i>&nbsp;&nbsp;&nbsp; <?= $etiq->name() ?>       
                                                                    <span class="float-right">
                                                                        <span class="label label-<?= ($stock > 0)?"success":"danger" ?>"><?= money($stock) ?></span>
                                                                        &nbsp;&nbsp;&nbsp;<span class="float-right"><?= money($prix) ?> <?= $params->devise ?></span>
                                                                    </span>
                                                                </li>
                                                            <?php } ?>
                                                            <li class="list-group-item"></li>
                                                        </ul>

                                                        <div class="ibox">
                                                            <div class="ibox-content">
                                                                <h5>Estimation du stock actuel</h5>
                                                                <h1 class="no-margins"><?= money($total) ?> <?= $params->devise ?></h1>
                                                            </div><br>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8 border-right border-left">
                                                        <div class="" style="margin-top: 0%">

                                                            <div class="row">
                                                                <div class="col-sm">
                                                                    <div class="carre bg-success"></div><span>Quantité consommée</span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div class="carre bg-warning"></div><span>Quantité approvisionnée</span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div class="carre bg-green"></div><span>Stock de fin de journée</span>
                                                                </div>
                                                            </div><hr>

                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th rowspan="2" class="border-none"></th>
                                                                        <?php foreach ($etiquettes as $key => $ressource) {  ?>
                                                                            <th class="text-center"><small><?= $ressource->name() ?></small></th>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i =0;
                                                                    foreach ($productionjours as $key => $production) { ?>
                                                                        <tr>
                                                                            <td><?= datecourt($production->ladate)  ?></td>
                                                                            <?php
                                                                            $production->fourni("ligneetiquettejour");
                                                                            foreach ($etiquettes as $key => $etiq) {
                                                                                foreach ($production->ligneetiquettejours as $key => $ligne) {
                                                                                    if ($etiq->id == $ligne->etiquette_id) { 
                                                                                        ?>
                                                                                        <td class="text-center">
                                                                                            <h5 class="d-inline text-success gras"><?= start0($ligne->consommation) ?></h5>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                                                            <h5 class="d-inline text-warning gras"><?= start0($etiq->achat($production->ladate, $production->ladate)) ?></h5> |&nbsp;&nbsp; <h5 class="d-inline text-green gras"><?= start0($etiq->stock($production->ladate)) ?></h5>
                                                                                        </td>
                                                                                    <?php }
                                                                                }
                                                                            } ?>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <tr style="height: 18px;"></tr>
                                                                </tbody>
                                                            </table> 

                                                        </div>
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



                </div>

            </div>

        </div>
    </div>
</div>