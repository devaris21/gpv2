
<div role="tabpanel" id="tab-stock" class="tab-pane">
    <div class="panel-body">

        <div class="row">
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
        </div><br>


        <div class="row">
            <div class="col-md-7">
                <h2 class="text-uppercase">Stock des intrants</h2>
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th class="text-left">Libéllé</th>
                            <th>stock init</th>
                            <th>Achat</th>
                            <th>Conso</th>
                            <th>En cours</th>
                            <th>stock final</th>
                            <th>Valeur final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0;
                        foreach (Home\RESSOURCE::getAll() as $key => $ressource) {
                            $prix = $ressource->stock($exercice->datefin()) * $ressource->price();
                            $total += $prix; ?>
                            <tr>
                                <td class="gras text-left">Stock de <?= $ressource->name() ?></td>
                                <td class="text-center"><?= $ressource->stock($exercice->created) ?> <?= $ressource->abbr ?></td>
                                <td class="text-center"><?= $ressource->achat($exercice->created, $exercice->datefin()) ?> <?= $ressource->abbr ?></td>
                                <td class="text-center"><?= $ressource->consommee($exercice->created, $exercice->datefin()) ?> <?= $ressource->abbr ?></td>
                                <td class="text-center"><?= $ressource->en_cours() ?> <?= $ressource->abbr ?></td>
                                <td class="text-center"><?= $ressource->stock($exercice->datefin()) + $ressource->en_cours() ?> <?= $ressource->abbr ?></td>
                                <td class="text-center"><?= money($prix) ?> <?= $params->devise ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="5" class="text-right"><h2 class="mp0">Total =</h2></td>
                            <td colspan="2" class="text-right"><h2 class="mp0"><?= money($total) ?> <?= $params->devise ?></h2></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-5">
                <h2 class="text-uppercase">Stock des produits </h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="2">Libéllé</th>
                            <th>Val début. Exe.</th>
                            <th>Val fin Exe.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach (Home\PRODUIT::getAll() as $key => $produit) {
                            $datas = $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI]);
                            if (count($datas) > 0) {
                                $pdv = $datas[0];
                                $pdv->actualise();
                                unset($datas[0]);
                                $total += $pdv->montantStock();

                                $a = $pdv->stock($exercice->created);
                            } ?>
                            <tr>
                                <td class="gras text-muted text-center" rowspan="<?= count($datas)+1 ?>">
                                    <br><i class="fa fa-flask fa-3x"></i><br><?= $produit->name() ?>
                                </td>
                                <td class="gras text-muted"><?= $pdv->prix->price() ?> <?= $params->devise ?></td>
                                <td><?= money($a * $pdv->prix->price) ?> <?= $params->devise ?></td>                                
                                <td><?= money($pdv->montantStock()) ?> <?= $params->devise ?></td>
                            </tr>
                            <?php foreach ($datas as $key => $pdv) {
                                $pdv->actualise();
                                $total += $pdv->montantStock(); ?>
                                <tr>
                                    <td class="gras text-muted"><?= $pdv->prix->price() ?> <?= $params->devise ?></td>
                                    <td><?= money($a * $pdv->prix->price) ?> <?= $params->devise ?></td>
                                    <td><?= money($pdv->montantStock()) ?> <?= $params->devise ?></td>
                                </tr>
                            <?php } ?>
                            <tr height="25px"></tr>
                        <?php } ?>

                        <tr>
                            <td colspan="2"><h2 class="mp0">Total =</h2></td>
                            <td colspan="2" class="text-right"><h2 class="mp0"><?= money($total) ?> <?= $params->devise ?></h2></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>