<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-warning gras">Les prospections en cours</h2>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-7 gras ">Afficher même les prospections passées</div>
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
                                <span> prospections en cours </span>
                                <h2 class="font-bold"><?= start0(count($prospections__)) ?></h2>
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
                <h5>Toutes les prospections</h5>
                <div class="ibox-tools">
                    <!-- <button style="margin-top: -5%;" type="button" data-toggle=modal data-target='#modal-prospection' class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle prospection </button> -->
                </div>
            </div>
            <div class="ibox-content" style="min-height: 300px">
                <table class="table table-hover table-prospection">
                    <tbody>
                        <?php foreach ($prospections as $key => $prospection) {
                            $prospection->actualise(); 
                            $prospection->fourni("ligneprospection");
                            ?>
                            <tr class="<?= ($prospection->etat_id != Home\ETAT::ENCOURS)?'fini':'' ?> border-bottom" style="border-bottom: 2px solid black">
                                <td class="project-status">
                                    <span class="label label-<?= $prospection->etat->class ?>"><?= $prospection->etat->name ?></span>
                                </td>
                                <td class="project-title border-right" style="width: 30%;">
                                    <h4 class="text-uppercase">Prospection N°<?= $prospection->reference ?></h4>
                                    <h6 class="text-uppercase text-muted">Zone de prospection :  <?= $prospection->zonedevente->name() ?></h6>
                                    <h6 class="text-uppercase text-muted">Commercial :  <?= $prospection->commercial->name() ?></h6>
                                    <span>Emise <?= depuis($prospection->created) ?></span><br>

                                    <h3 class="gras text-orange"><?= money($prospection->montant) ?> <?= $params->devise  ?></h3>
                                    <h3 class="gras text-green"><?= money($prospection->vendu) ?> <?= $params->devise  ?></h3>
                                </td>
                                <td class="border-right" style="width: 35%">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="no">
                                                <th></th>
                                                <?php foreach ($prospection->ligneprospections as $key => $ligne) { 
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center mp0"><?= $ligne->prixdevente->produit->name() ?><br><small><?= $ligne->prixdevente->prix->price() ?> <?= $params->devise  ?></small></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="no">
                                                <td><h4 class="mp0">Qté : </h4></td>
                                                <?php foreach ($prospection->ligneprospections as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite) ?> // 
                                                        <?php if ($prospection->etat_id == Home\ETAT::VALIDEE) { ?>
                                                            <span class="text-green"><?= start0($ligne->quantite_vendu) ?></span>
                                                        <?php }  ?>
                                                    </td>
                                                <?php   } ?>
                                            </tr>
                                            <?php if ($prospection->etat_id == Home\ETAT::VALIDEE) { ?>
                                                <tr class="no">
                                                    <td><h4 class="mp0">Perte :</h4></td>
                                                    <?php foreach ($prospection->ligneprospections as $key => $ligne) { ?>
                                                        <td class="text-center"><?= start0($ligne->perte) ?></td>
                                                    <?php   } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <a href="<?= $this->url("gestion", "fiches", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-block btn-white btn-sm"><i class="fa fa-file-text text-blue"></i> Bon de sortie</a><br>
                                    <?php if ($prospection->etat_id == Home\ETAT::ENCOURS) { ?>
                                        <button onclick="terminer(<?= $prospection->id ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Terminer</button>
                                    <?php } ?>
                                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                        <button onclick="annulerProspection(<?= $prospection->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
                <?php if (count($prospections__) == 0) { ?>
                    <h1 style="margin-top: 30% auto;" class="text-center text-muted aucun"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune prospection en cours pour le moment !</h1>
                <?php } ?>

            </div>
        </div>
    </div>


    <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>

    <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 


    <?php 
    foreach ($prospections as $key => $prospection) {
        if ($prospection->etat_id == Home\ETAT::ENCOURS) { 
            include($this->rootPath("composants/assets/modals/modal-prospection2.php"));
        } 
    } 
    ?>

</div>
</div>


<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>

</body>

</html>
