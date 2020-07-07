<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-warning gras">Toutes les ventes directes</h2>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-7 gras ">Afficher même les anciennes ventes directes </div>
                        <div class="offset-1"></div>
                        <div class="col-xs-4">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" class="onoffswitch-checkbox" id="example1">
                                    <label class="onoffswitch-label" for="example1">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
             <div class="row">
                <div class="col-md-12">
                    <div class="widget style1 bg-orange">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-truck fa-3x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Ventes du jour </span>
                                <h2 class="font-bold"><?= start0(count($ventes__)) ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Toutes les ventes directes</h5>
                <div class="ibox-tools">
                    <button style="margin-top: -5%;" data-toggle=modal data-target="#modal-vente" class="btn btn-warning dim float-right"> <i class="fa fa-file-text-o"></i> Nouvelle vente directe</button>
                </div>
            </div>
            <div class="ibox-content" style="min-height: 300px">
                <table class="table table-hover table-vente">
                    <tbody>
                        <?php foreach ($ventes as $key => $vente) {
                            $vente->actualise(); 
                            $vente->fourni("lignedevente");
                            ?>
                            <tr class="<?= (date("Y-m-d", strtotime($vente->created)) != dateAjoute())?'fini':'' ?> border-bottom" style="border-bottom: 2px solid black">
                                <td class="project-status">
                                    <span class="label label-<?= $vente->etat->class ?>"><?= $vente->etat->name ?></span>
                                </td>
                                <td class="project-title border-right" style="width: 30%;">
                                    <h4 class="text-uppercase">Vente directe N°<?= $vente->reference ?></h4>
                                    <h6 class="text-uppercase text-muted">Zone de vente :  <?= $vente->zonedevente->name() ?></h6>
                                    <h6 class="text-uppercase text-muted">Commercial :  <?= $vente->commercial->name() ?></h6>
                                    <span>Emise <?= depuis($vente->created) ?></span>
                                </td>
                                <td class="border-right" style="width: 35%">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="no">
                                                <th></th>
                                                <?php foreach ($vente->lignedeventes as $key => $ligne) { 
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center mp0"><?= $ligne->prixdevente->produit->name() ?><br><small><?= $ligne->prixdevente->prix->price() ?> <?= $params->devise  ?></small></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="no">
                                                <td><h4 class="mp0">Qté : </h4></td>
                                                <?php foreach ($vente->lignedeventes as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                <?php   } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td><span>Montant total</span>
                                    <h3 class="gras text-orange"><?= money($vente->montant) ?> <?= $params->devise  ?></h3>
                                    <span><?= $vente->reglementclient->structure ?> - <?= $vente->reglementclient->numero ?></span>
                                </td>
                                <td>
                                    <a href="<?= $this->url("gestion", "fiches", "bonvente", $vente->id) ?>" target="_blank" class="btn btn-block btn-white btn-sm"><i class="fa fa-file-text text-blue"></i> Voir le reçu </a><br>
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
                        </table>
                        <?php if (count($ventes__) == 0) { ?>
                            <h1 style="margin-top: 30% auto;" class="text-center text-muted aucun"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune vente directe pour le moment !</h1>
                        <?php } ?>

                    </div>
                </div>
            </div>


            <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>

            <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 

        </div>
    </div>

    <?php include($this->rootPath("composants/assets/modals/modal-vente.php")); ?> 



    <?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

    <script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>

</body>

</html>
