<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-9">
                    <h2 class="text-uppercase text-warning gras">Approvisionnements d'etiquettes</h2>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-7 gras ">Afficher même les approvisionnements passées</div>
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
                  <button style="margin-top: 5%" data-toggle='modal' data-target="#modal-approetiquette" class="btn btn-success dim"><i class="fa fa-plus"></i> Approvisionnement d'etiquette</button>
              </div>
          </div>

          <div class="wrapper wrapper-content">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Tous les approvisionnements</h5>
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
                <div class="ibox-content" style="min-height: 300px;">
                 <?php if (count($datas + $encours) > 0) { ?>
                    <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                            <tr>

                                <th data-toggle="true">Status</th>
                                <th>Reference</th>
                                <th>Entrepôt</th>
                                <th>Enregistré par</th>
                                <th>Montant</th>
                                <th>Fournisseur</th>
                                <th data-hide="all"></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($encours as $key => $appro) {
                                $appro->actualise(); 
                                $lots = $appro->fourni("ligneapproetiquette");
                                ?>
                                <tr style="border-bottom: 2px solid black">
                                    <td class="project-status">
                                        <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                    </td>
                                    <td>
                                        <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $appro->entrepot->name() ?></h6>
                                    </td>
                                    <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                    <td>
                                        <h4>
                                            <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                        </h4>
                                    </td>
                                    <td><i class="fa fa-user"></i> <?= $appro->fournisseur->name() ?></td>
                                    <td class="border-right">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="no">
                                                    <?php foreach ($appro->ligneapproetiquettes as $key => $ligne) {
                                                        $ligne->actualise(); ?>
                                                        <th class="text-center gras"><span class="small"><?= $ligne->etiquette->name() ?></span></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach ($lots as $key => $ligne) { ?>
                                                        <td class="text-center"><?= start0($ligne->quantite) ?> unités</td>
                                                    <?php } ?>
                                                </tr>
                                            </tbody>  
                                        </table>
                                    </td>
                                    <td>
                                        <a href="<?= $this->url("boutique", "fiches", "bonmiseenboutique", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                        <?php if ($appro->etat_id == Home\ETAT::ENCOURS) { ?>
                                            <button onclick="terminer(<?= $appro->id ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Valider</button>
                                        <?php } ?>
                                        <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                            <button onclick="annuler(<?= $appro->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php  } ?>
                            <tr />
                            <?php foreach ($datas as $key => $appro) {
                                $appro->actualise(); 
                                $lots = $appro->fourni("ligneapproetiquette");
                                ?>
                                <tr style="border-bottom: 2px solid black">
                                    <td class="project-status">
                                        <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                    </td>
                                    <td>
                                        <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                        <small><?= depuis($appro->created) ?></small>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $appro->entrepot->name() ?></h6>
                                    </td>
                                    <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                    <td>
                                        <h4>
                                            <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                        </h4>
                                    </td>
                                    <td><i class="fa fa-user"></i> <?= $appro->fournisseur->name() ?></td>
                                    <td class="border-right">
                                     <table class="table table-bordered">
                                        <thead>
                                            <tr class="no">
                                                <?php foreach ($appro->ligneapproetiquettes as $key => $ligne) {
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center gras"><span class="small"><?= $ligne->etiquette->name() ?></span></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php foreach ($lots as $key => $ligne) { ?>
                                                    <td class="text-center"><?= start0($ligne->quantite) ?> unités</td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>  
                                    </table>
                                </td>
                                <td>
                                    <a href="<?= $this->url("boutique", "fiches", "bonmiseenboutique", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
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
<?php include($this->rootPath("composants/assets/modals/modal-approetiquette.php")); ?> 



<?php 
foreach ($encours as $key => $appro) {
    if ($appro->etat_id == Home\ETAT::ENCOURS) { 
        $appro->actualise();
        $appro->fourni("ligneapproetiquette");
        include($this->rootPath("composants/assets/modals/modal-approetiquette2.php"));
    } 
} 
?>

</div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>


</body>

</html>