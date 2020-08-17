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
                    <h2 class="text-uppercase text-warning gras">Les prospections en cours</h2>
                    <div class="container">
                        <button style="margin-top: -5%;" type="button" data-toggle=modal data-target='#modal-prospection' class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle prospection </button>
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
                    <?php if (count($prospections + $encours) > 0) { ?>
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
                                    $vente->fourni("ligneprospection");
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $vente->etat->class ?>"><?= $vente->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Prospection</span><br>
                                            <span><?= $vente->reference ?></span>
                                        </td>
                                        <td>
                                            <h5 class="text-uppercase"><?= $vente->commercial->name() ?></h5>
                                        </td>
                                        <td>
                                            <h6 class="text-uppercase text-muted" style="margin: 0">Zone de prospection :  <?= $vente->zonedevente->name() ?></h6>
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
                                                        <?php foreach ($vente->ligneprospections as $key => $ligne) { 
                                                            $ligne->actualise(); ?>
                                                            <th class="text-center mp0"><?= $ligne->prixdevente->produit->name() ?><br><small><?= $ligne->prixdevente->prix->price() ?> <?= $params->devise  ?></small></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="no">
                                                        <td><h4 class="mp0">Qté : </h4></td>
                                                        <?php foreach ($vente->ligneprospections as $key => $ligne) { ?>
                                                            <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                        <?php   } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <a href="<?= $this->url("boutique", "fiches", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>                                        
                                            <?php if ($prospection->etat_id == Home\ETAT::ENCOURS) { ?>
                                                <button onclick="terminer(<?= $prospection->id ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></button>
                                            <?php } ?>
                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                <button onclick="annulerProspection(<?= $prospection->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  } ?>

                                <tr />

                                <?php foreach ($prospections as $key => $prospection) {
                                    $prospection->actualise(); 
                                    $prospection->fourni("ligneprospection");
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $prospection->etat->class ?>"><?= $prospection->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Prospection</span><br>
                                            <span><?= $prospection->reference ?></span>
                                        </td>
                                        <td>
                                            <h5 class="text-uppercase"><?= $prospection->commercial->name() ?></h5>
                                        </td>
                                        <td>
                                            <h6 class="text-uppercase text-muted">Zone de prospection :  <?= $prospection->zonedevente->name() ?></h6>
                                            <small>Validé <?= depuis($prospection->dateretour) ?></small>
                                        </td>
                                        <td>
                                            <h4>
                                                <span class="gras text-orange"><?= money($prospection->montant) ?> <?= $params->devise  ?></span> -
                                                <span class="gras text-green"><?= money($prospection->vendu) ?> <?= $params->devise  ?></span>
                                            </h4>
                                        </td>
                                        <td class="border-right">
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
                                                            <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                        <?php   } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <a href="<?= $this->url("boutique", "fiches", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                <button onclick="annulerProspection(<?= $prospection->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
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
                    <?php }else{ ?>
                        <h1 style="margin-top: 30% auto;" class="text-center text-muted aucun"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune prospection en cours pour le moment !</h1>
                    <?php } ?>

                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>

        <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 


        <?php 
        foreach ($prospections as $key => $prospection) {
            if ($prospection->etat_id == Home\ETAT::ENCOURS) { 
                $prospection->actualise();
                $prospection->fourni("ligneprospection");
                include($this->rootPath("composants/assets/modals/modal-prospection2.php"));
            } 
        } 
        ?>

    </div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>

</body>

</html>
