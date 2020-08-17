
<div role="tabpanel" id="tab-capitaux" class="tab-pane">
    <div class="panel-body">
       <!--  <div class="row">
            <div class="col-lg-3">
                <div class="widget style1 blue-bg">
                    <div class="row">
                        <div class="col-4 text-center">
                            <i class="fa fa-trophy fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> Today income </span>
                            <h2 class="font-bold">$ 4,232</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-cloud fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> Today degrees </span>
                            <h2 class="font-bold">26'C</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-envelope-o fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> New messages </span>
                            <h2 class="font-bold">260</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-music fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> New albums </span>
                            <h2 class="font-bold">12</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> --><br>

        <div class="row">
            <div class="col-md-6">
                <h2 class="text-uppercase">Capitaux <button data-toggle="modal" data-target="#modal-capitaux" class="btn btn-sm btn-primary dim pull-right"><i class="fa fa-plus"></i> Ajouter nouveau</button></h2>
                <table class="table table-stripped table-hover">
                    <thead>
                        <tr>
                            <th>Libéllé</th>
                            <th>Montant</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (Home\CAPITAUX::getAll() as $key => $item) { ?>
                            <tr>
                                <td><?= $item->name() ?></td>
                                <td><?= money($item->montant) ?> <?= $params->devise ?></td>
                                <td data-toggle="modal" data-target="#modal-capitaux" title="modifier" onclick="modification('capitaux', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                <td title="supprimer la zone de livraison" onclick="suppressionWithPassword('capitaux', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><h2 class="mp0">Total =</h2></td>
                            <td><h2 class="mp0"><?= money(Home\CAPITAUX::total()) ?> <?= $params->devise ?></h2></td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6 border-left">
                <h2 class="text-uppercase">Immobilisations <button data-toggle="modal" data-target="#modal-immobilisation" class="btn btn-sm btn-warning dim pull-right"><i class="fa fa-plus"></i> Ajouter nouveau</button></h2>
                <table class="table table-stripped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2">Libéllé</th>
                            <th>Prix de revient</th>
                            <th>Reste à ammortir</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0;
                        foreach (Home\IMMOBILISATION::getAll() as $key => $item) {
                            $reste = $item->resteAmortissement();
                            $total += $reste; ?>
                            <tr>
                                <td><i class="fa fa-file-text-o cursor" data-toggle="modal" data-target="#modal-immobilisation-<?= $item->id ?>"></i></td>
                                <td><?= $item->name() ?></td>
                                <td><?= money($item->montant) ?> <?= $params->devise ?></td>
                                <td><?= money($reste) ?> <?= $params->devise ?></td>
                                <td data-toggle="modal" data-target="#modal-capitaux" title="modifier" onclick="modification('capitaux', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                <td title="supprimer la zone de livraison" onclick="suppressionWithPassword('capitaux', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3"><h2 class="mp0">Total =</h2></td>
                            <td colspan="2"><h2 class="mp0"><?= money($total) ?> <?= $params->devise ?></h2></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
