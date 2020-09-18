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
                    <h2 class="text-uppercase text-green gras">Les prospections en cours</h2>
                </div>
                <div class="col-sm-3">
<!--                     <button style="margin-top: 5%;" type="button" data-toggle=modal data-target='#modal-prospection' class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle prospection </button>
-->                </div>
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
                            <th>Boutique</th>
                            <th>Commercial</th>
                            <th></th>
                            <th>Montant</th>
                            <th data-hide="all"></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($encours as $key => $prospection) {
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
                                    <h5 class="text-uppercase"><?= $vente->boutique->name() ?></h5>
                                </td>
                                <td>
                                    <h5 class="text-uppercase"><?= $prospection->commercial->name() ?></h5>
                                </td>
                                <td>
                                    <h6 class="text-uppercase text-muted" style="margin: 0">Zone de prospection :  <?= $prospection->zonedevente->name() ?></h6>
                                    <small><?= depuis($prospection->created) ?></small>
                                </td>
                                <td>
                                    <h3 class="gras text-orange"><?= money($prospection->montant) ?> <?= $params->devise  ?></h3>
                                </td>
                                <td class="border-right">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="no">
                                                <th></th>
                                                <?php foreach ($prospection->ligneprospections as $key => $ligne) {
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
                                                <td><h4 class="mp0">Qté : </h4></td>
                                                <?php foreach ($prospection->ligneprospections as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                <?php   } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <a href="<?= $this->url("fiches", "master", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
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
                                    <h5 class="text-uppercase"><?= $vente->boutique->name() ?></h5>
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
                                                <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->produit->name() ?></span><br>
                                                    <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                                    <small><?= $ligne->emballage->name() ?></small>
                                                </th>
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
                                <a href="<?= $this->url("fiches", "master", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
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


<?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>

<?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 


<?php 
foreach ($encours as $key => $prospection) {
    include($this->rootPath("composants/assets/modals/modal-prospection2.php"));
} 
?>

</div>
</div>


<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>

</body>

</html>
