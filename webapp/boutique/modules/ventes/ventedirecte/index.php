<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-warning gras">Toutes les ventes directes</h2>
            </div>
            <div class="col-sm-3">
                <button style="margin-top: 5%;" data-toggle=modal data-target="#modal-vente" class="btn btn-warning dim float-right"> <i class="fa fa-file-text-o"></i> Nouvelle vente directe</button>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 class="text-capitalize">Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
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
                <div class="ibox-content" style="min-height: 300px">
                    <?php if (count($ventes + $encours) > 0) { ?>
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>

                                    <th data-toggle="true">Status</th>
                                    <th>Reference</th>
                                    <th>Commercial</th>
                                    <th></th>
                                    <th>Montant</th>
                                    <th data-hide="all">Produits</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php foreach ($encours as $key => $vente) {
                                $vente->actualise(); 
                                $vente->fourni("lignedevente");
                                ?>
                                <tr style="border-bottom: 2px solid black">
                                    <td class="project-status">
                                        <span class="label label-<?= $vente->etat->class ?>"><?= $vente->etat->name ?></span>
                                    </td>
                                    <td>
                                        <span class="text-uppercase gras">Vente <?= $vente->typevente->name()  ?></span><br>
                                        <span><?= $vente->reference ?></span>
                                    </td>
                                    <td>
                                        <h5 class="text-uppercase"><?= $vente->commercial->name() ?></h5>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-muted" style="margin: 0">Zone de vente :  <?= $vente->zonedevente->name() ?></h6>
                                        <small><?= depuis($vente->created) ?></small>
                                    </td>
                                    <td>
                                        <h3 class="gras text-orange"><?= money($vente->montant) ?> <?= $params->devise  ?></h3>
                                    </td>
                                    <td class="border-right">
                                      <table class="table table-bordered">
                                        <thead>
                                            <tr class="no">
                                                <th></th>
                                                <?php foreach ($vente->lignedeventes as $key => $ligne) { 
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->produit->name() ?></span><br>
                                                        <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                                        <small><?= $ligne->emballage->name() ?></small>
                                                    </th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>                                                    
                                            <tr class="no">
                                                <td class="gras">Qté :</td>
                                                <?php foreach ($vente->lignedeventes as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                <?php   } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <a href="<?= $this->url("boutique", "fiches", "bonvente", $vente->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i> </a>
                                        <!-- <?php if ($vente->etat_id == Home\ETAT::ENCOURS) { ?>
                                            <button onclick="terminer(<?= $vente->id ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Terminer</button>
                                            <?php } ?> -->
                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                <button onclick="annulerVente(<?= $vente->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  } ?>
                                <tr />
                                <?php foreach ($ventes as $key => $vente) {
                                    $vente->actualise(); 
                                    $vente->fourni("lignedevente");
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $vente->etat->class ?>"><?= $vente->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras"><?= $vente->typevente->name()  ?></span><br>
                                            <span><?= $vente->reference ?></span>
                                        </td>
                                        <td>
                                            <h5 class="text-uppercase"><?= $vente->commercial->name() ?></h5>
                                        </td>
                                        <td>
                                            <h6 class="text-uppercase text-muted">Zone de vente :  <?= $vente->zonedevente->name() ?></h6>
                                            <small><?= depuis($vente->created) ?></small>
                                        </td>
                                        <td>
                                            <h3 class="gras text-orange"><?= money($vente->montant) ?> <?= $params->devise  ?></h3>
                                        </td>
                                        <td class="border-right">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="no">
                                                        <th></th>
                                                        <?php foreach ($vente->lignedeventes as $key => $ligne) { 
                                                            $ligne->actualise(); ?>
                                                            <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->produit->name() ?></span><br>
                                                                <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                                                <small><?= $ligne->emballage->name() ?></small>
                                                            </th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                    <tr class="no">
                                                        <td class="gras">Qté :</td>
                                                        <?php foreach ($vente->lignedeventes as $key => $ligne) { ?>
                                                            <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                        <?php   } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <a href="<?= $this->url("boutique", "fiches", "bonvente", $vente->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i> </a>
                                        <!-- <?php if ($vente->etat_id == Home\ETAT::ENCOURS) { ?>
                                            <button onclick="terminer(<?= $vente->id ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Terminer</button>
                                            <?php } ?> -->
                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                <button onclick="annulerVente(<?= $vente->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  } ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php }else { ?>
                        <h1 style="margin-top: 30% auto;" class="text-center text-muted aucun"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune vente directe pour le moment !</h1>
                    <?php } ?>

                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>

        <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 

    </div>
</div>

<?php include($this->rootPath("composants/assets/modals/modal-vente.php")); ?> 



<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>

</body>

</html>
