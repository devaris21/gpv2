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
                <h2 class="text-uppercase text-green gras">Mise en boutique de la production</h2>
            </div>
            <div class="col-sm-3">
                <button style="margin-top: 5%;" type="button" data-toggle=modal data-target='#modal-miseenboutique-demande' class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle demende de mise en boutique </button>
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
                                <th></th>
                                <th>Boutique</th>
                                <th data-hide="all">Produits</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach ($encours as $key => $mise) {
                            $mise->actualise(); 
                            $lots = $mise->fourni("lignemiseenboutique");
                            ?>
                            <tr style="border-bottom: 2px solid black">
                                <td class="project-status">
                                    <span class="label label-<?= $mise->etat->class ?>"><?= $mise->etat->name ?></span>
                                </td>
                                <td>
                                    <span class="text-uppercase gras">Mise en boutique</span><br>
                                    <span><?= $mise->reference ?></span>
                                </td>
                                <td>
                                    <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $mise->entrepot->name() ?></h6>
                                    <small>Emise <?= depuis($mise->created) ?></small>
                                </td>
                                <td><i class="fa fa-long-arrow-right fa-2x"></i></td>
                                <td>
                                    <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $mise->boutique->name() ?></h6>
                                    <small>Emise <?= depuis($mise->created) ?></small>
                                </td>
                                <td class="border-right">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td><h4 class="mp0">Démandé : </h4></td>
                                                <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite_demande) ?><br><small><?= $ligne->emballage->name()  ?></small></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><h4 class="mp0">sorti : </h4></td>
                                                <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite_depart) ?><br><small><?= $ligne->emballage->name()  ?></small></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><h4 class="mp0">Livré : </h4></td>
                                                <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite) ?><br><small><?= $ligne->emballage->name()  ?></small></td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <a href="<?= $this->url("fiches", "master", "bonmiseenboutique", $mise->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                        <button onclick="annulerMiseenboutique(<?= $mise->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                    <?php } ?>
                                    <?php if ($mise->etat_id == Home\ETAT::ENCOURS) { ?>
                                        <button onclick="terminer(<?= $mise->id ?>)" class="btn btn-white btn-sm text-green"><i class="fa fa-check"></i> Valider</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php  } ?>
                        <tr />
                        <?php foreach ($datas as $key => $mise) {
                            $mise->actualise(); 
                            $lots = $mise->fourni("lignemiseenboutique");
                            ?>
                            <tr style="border-bottom: 2px solid black">
                                <td class="project-status">
                                    <span class="label label-<?= $mise->etat->class ?>"><?= $mise->etat->name ?></span>
                                </td>
                                <td>
                                    <span class="text-uppercase gras">Mise en boutique</span><br>
                                    <span><?= $mise->reference ?></span>
                                </td>
                                <td>
                                    <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $mise->entrepot->name() ?></h6>
                                    <small>Emise <?= depuis($mise->created) ?></small>
                                </td>
                                <td><i class="fa fa-long-arrow-right fa-2x"></i></td>
                                <td>
                                    <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $mise->boutique->name() ?></h6>
                                    <small>Emise <?= depuis($mise->created) ?></small>
                                </td>
                                <td class="border-right">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="no">
                                                <th></th>
                                                <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) {
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->produit->typeproduit_parfum->name() ?><br><?= $ligne->produit->quantite->name() ?></span></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><h4 class="mp0">Démandé : </h4></td>
                                                <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite_demande) ?><br><small><?= $ligne->emballage->name()  ?></small></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><h4 class="mp0">sorti : </h4></td>
                                                <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite_depart) ?><br><small><?= $ligne->emballage->name()  ?></small></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><h4 class="mp0">Livré : </h4></td>
                                                <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite) ?><br><small><?= $ligne->emballage->name()  ?></small></td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <a href="<?= $this->url("fiches", "master", "bonmiseenboutique", $mise->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
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


<?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?> 
<?php include($this->rootPath("composants/assets/modals/modal-miseenboutique-demande.php")); ?>

<?php 
foreach ($encours as $key => $mise) {
    if ($mise->etat_id == Home\ETAT::ENCOURS) { 
        include($this->rootPath("composants/assets/modals/modal-miseenboutique1.php"));
    } 
} 
?>

</div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
