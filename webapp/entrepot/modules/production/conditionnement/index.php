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
                                    $qua = $pro->enStock(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $pro->id, $entrepot->id);
                                    if ($qua > 0) {
                                        $pro->actualise(); ?>
                                        <tr>
                                            <td>
                                                <button data-toggle="modal" data-target="#modal-conditionnement-<?= $pro->id ?>"  class="btn btn-primary btn-xs pull-right"><?= start0($qua) ?> <?= $type->abbr  ?></button> <?= $pro->name(); ?>
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
                    <h2 class="text-uppercase text-green gras">Conditionnement de la production</h2>
                    <div class="container">
                    </div>
                </div>
                <div class="col-sm-3 text-right">
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
                                    <th>Qté</th>
                                    <th>Entrepôt</th>
                                    <th>Enregistré par</th>
                                    <th data-hide="all"></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($encours as $key => $conditionnement) {
                                    $conditionnement->actualise(); 
                                    $lots = $conditionnement->fourni("ligneconditionnement");
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $conditionnement->etat->class ?>"><?= $conditionnement->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Conditionnement de <?= $conditionnement->typeproduit_parfum->name() ?></span><br>
                                            <small>du <?= depuis($conditionnement->created) ?></small>
                                        </td>
                                        <td><?= start0($conditionnement->quantite) ?> <?= $conditionnement->typeproduit_parfum->typeproduit->abbr ?></td>
                                        <td>
                                            <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $conditionnement->entrepot->name() ?></h6>
                                        </td>
                                        <td><i class="fa fa-user"></i> <?= $conditionnement->employe->name() ?></td>
                                        <td class="border-right">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="no">
                                                        <?php foreach ($lots as $key => $ligne) {
                                                            $ligne->actualise(); ?>
                                                            <th class="text-center" style="padding: 2px"><span class="small gras"><?= $ligne->produit->name2() ?></span></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php foreach ($lots as $key => $ligne) { ?>
                                                            <td class="text-center"><?= start0($ligne->quantite) ?><br><small><?= $ligne->emballage->name() ?></small></td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>  
                                            </table>
                                        </td>
                                        <td>
                                            <a href="<?= $this->url("fiches", "master", "bonconditionnement", $conditionnement->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                <button onclick="annulerConditionnement(<?= $conditionnement->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  } ?>
                                <tr />
                                <?php foreach ($datas as $key => $conditionnement) {
                                    $conditionnement->actualise(); 
                                    $lots = $conditionnement->fourni("ligneconditionnement");
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $conditionnement->etat->class ?>"><?= $conditionnement->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Conditionnement de <?= $conditionnement->typeproduit_parfum->name() ?></span><br>
                                            <small>du <?= depuis($conditionnement->created) ?></small>
                                        </td>
                                        <td><?= start0($conditionnement->quantite) ?> <?= $conditionnement->typeproduit_parfum->typeproduit->abbr ?></td>
                                        <td>
                                            <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $conditionnement->entrepot->name() ?></h6>
                                            <small>Emise <?= depuis($conditionnement->created) ?></small>
                                        </td>
                                        <td><i class="fa fa-user"></i> <?= $conditionnement->employe->name() ?></td>
                                        <td class="border-right">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="no">
                                                        <?php foreach ($lots as $key => $ligne) {
                                                            $ligne->actualise(); ?>
                                                            <th class="text-center" style="padding: 2px"><span class="small gras"><?= $ligne->produit->name2() ?></span></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php foreach ($lots as $key => $ligne) { ?>
                                                            <td class="text-center"><?= start0($ligne->quantite) ?><br><small><?= $ligne->emballage->name() ?></small></td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>  
                                            </table>
                                        </td>
                                        <td>
                                           <a href="<?= $this->url("fiches", "master", "bonconditionnement", $conditionnement->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                           <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                            <button onclick="annulerConditionnement(<?= $conditionnement->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
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
                    <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucun conditionnement pour le moment</h1>
                <?php } ?>

            </div>
        </div>
    </div>


    <?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?> 

    <?php foreach (Home\TYPEPRODUIT_PARFUM::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
        $qua = $pro->enStock(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $pro->id, $entrepot->id);
        if ($qua > 0) { include($this->rootPath("composants/assets/modals/modal-conditionnement.php")); } 
    }  ?>
</div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->rootPath("webapp/boutique/modules/master/client/script.js") ?>"></script>


</body>

</html>
