<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  

            <div class="row">
                <?php foreach (Home\TYPEPRODUIT::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $type) { ?>
                    <div class="col border-right">
                        <h5 class="text-uppercase gras text-center">Quantité de <?= $type->name()  ?></h5>
                        <table class="table">
                            <tbody>
                                <?php foreach ($type->fourni("typeproduit_parfum", ["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
                                    $qua = Home\PRODUCTION::enStock(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $pro->id, $entrepot->id);
                                    if ($qua > 0) {
                                        $pro->actualise(); ?>
                                        <tr>
                                            <td>
                                                <button data-toggle="modal" data-target="#modal-conditionnement-<?= $type->id ?>-<?= $parfum->id ?>"  class="btn btn-white btn-xs pull-right"><?= start0($qua) ?> <?= $type->abbr  ?></button> <?= $pro->name(); ?>
                                            </td>
                                        </tr>
                                    <?php } 
                                }  ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-9">
                    <h2 class="text-uppercase text-green gras">Les productions</h2>
                    <div class="container">
                        <button style="margin-top: -3%;" type="button" data-toggle=modal data-target='#modal-production' class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle production </button>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget style1 lazur-bg">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="fa fa-th-large fa-3x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                        <span> Mise en boutique </span>
                                        <h2 class="font-bold"><?= start0(count(Home\MISEENBOUTIQUE::encours()))  ?></h2>
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
                        <h5>Toutes les mises en boutique de la production</h5>
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
                <div class="ibox-content">
                    <?php if (count($datas + $encours) > 0) { ?>
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>

                                    <th data-toggle="true">Status</th>
                                    <th>Reference</th>
                                    <th>Entrepôt</th>
                                    <th>Enregistré par</th>
                                    <th data-hide="all"></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach ($encours as $key => $production) {
                                $production->actualise(); 
                                $lots = $production->fourni("ligneproduction");
                                ?>
                                <tr style="border-bottom: 2px solid black">
                                    <td class="project-status">
                                        <span class="label label-<?= $production->etat->class ?>"><?= $production->etat->name ?></span>
                                    </td>
                                    <td>
                                        <span class="text-uppercase gras">Nouvelle Production </span><br>
                                        <small>du <?= depuis($production->created) ?></small>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $production->entrepot->name() ?></h6>
                                    </td>
                                    <td><i class="fa fa-user"></i> <?= $production->employe->name() ?></td>
                                    <td class="border-right">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="no">
                                                    <?php foreach ($production->ligneproductions as $key => $ligne) {
                                                        $ligne->actualise(); ?>
                                                        <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->typeproduit_parfum->name() ?></span></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach ($lots as $key => $ligne) { ?>
                                                        <td class="text-center"><?= start0($ligne->quantite) ?> <?= $ligne->typeproduit_parfum->typeproduit->abbr ?></td>
                                                    <?php } ?>
                                                </tr>
                                            </tbody>  
                                        </table>
                                    </td>
                                    <td>
                                        <a href="<?= $this->url("boutique", "fiches", "bonmiseenboutique", $production->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                        <?php if ($production->etat_id == Home\ETAT::PARTIEL) { ?>
                                            <button onclick="accepter(<?= $production->id ?>)" class="btn btn-white btn-sm text-green"><i class="fa fa-check"></i> Accepter</button>
                                        <?php } ?>
                                        <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                            <button onclick="annulerMiseenboutique(<?= $production->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php  } ?>
                            <tr />
                            <?php foreach ($datas as $key => $production) {
                                $production->actualise(); 
                                $lots = $production->fourni("ligneproduction");
                                ?>
                                <tr style="border-bottom: 2px solid black">
                                    <td class="project-status">
                                        <span class="label label-<?= $production->etat->class ?>"><?= $production->etat->name ?></span>
                                    </td>
                                    <td>
                                        <span class="text-uppercase gras">Mise en boutique</span><br>
                                        <span><?= $production->reference ?></span>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $production->entrepot->name() ?></h6>
                                        <small>Emise <?= depuis($production->created) ?></small>
                                    </td>
                                    <td><i class="fa fa-user"></i> <?= $production->employe->name() ?></td>
                                    <td class="border-right">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="no">
                                                    <?php foreach ($production->ligneproductions as $key => $ligne) {
                                                        $ligne->actualise(); ?>
                                                        <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->typeproduit_parfum->name() ?> ></span></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach ($lots as $key => $ligne) { ?>
                                                        <td class="text-center"><?= start0($ligne->quantite) ?> <?= $ligne->typeproduit_parfum->typeproduit->abbr ?></td>
                                                    <?php } ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <a href="<?= $this->url("boutique", "fiches", "bonmiseenboutique", $production->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
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
                    <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune mise en boutique pour le moment</h1>
                <?php } ?>

            </div>
        </div>
    </div>


    <?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?> 

    <?php include($this->rootPath("composants/assets/modals/modal-production.php")); ?> 


</div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->rootPath("webapp/boutique/modules/master/client/script.js") ?>"></script>


</body>

</html>
