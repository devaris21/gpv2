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
                <div class="container">
                    <!-- <div class="row">
                        <div class="col-xs-7 gras ">Afficher même les rangements passées</div>
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
                    </div> -->
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
                    <button style="margin-top: -3%;" type="button" data-toggle=modal data-target='#modal-miseenboutique-demande' class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle demende de mise en boutique </button>
                </div>
            </div>
            <div class="ibox-content">
              <?php if (count($datas) > 0) { ?>
               <table class="table table-hover table-mise">
                <tbody>
                    <?php foreach ($datas as $key => $mise) {
                        $mise->actualise(); 
                        $lots = $mise->fourni("lignemiseenboutique");
                        ?>
                        <tr class="<?= ($mise->etat_id != Home\ETAT::ENCOURS)?'fini':'' ?> border-bottom">
                            <td class="project-status">
                                <span class="label label-<?= $mise->etat->class ?>"><?= $mise->etat->name ?></span>
                            </td>
                            <td class="project-title border-right" style="width: 35%;">
                                <h3 class="text-uppercase">Mise en boutique N°<?= $mise->reference ?></h3>
                                <h5 class="text-uppercase text-muted">du <?= datecourt($mise->created) ?></h5>
                                <h6 class="text-uppercase text-muted">Employé :<?= $mise->employe->name() ?></h6>
                                <h6 class="text-uppercase text-muted">Sortie d'entrepot : <?= $mise->entrepot->name() ?></h6>
                                <h6 class="text-uppercase text-muted">Mise en boutique :<?= $mise->boutique->name() ?></h6>
                            </td>
                            <td class="border-right">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <?php foreach ($lots as $key => $ligne) { 
                                                $ligne->actualise(); ?>
                                                <th class="text-center">
                                                    <h5 class="mp0"><?= $ligne->prixdevente->produit->name() ?></h5>
                                                    <h6 class="mp0"><?= $ligne->prixdevente->quantite->name() ?></h6>
                                                </th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><h4 class="mp0">sorti : </h4></td>
                                            <?php foreach ($lots as $key => $ligne) { ?>
                                                <td class="text-center"><?= start0($ligne->quantite_depart) ?></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td><h4 class="mp0">Livré : </h4></td>
                                            <?php foreach ($lots as $key => $ligne) { ?>
                                                <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <br>
                                <?php if ($mise->etat_id == Home\ETAT::ENCOURS) { ?>
                                    <button onclick="terminer(<?= $mise->id ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Terminer</button>
                                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                        <!-- <button onclick="annulerMiseenboutique(<?= $mise->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button> -->
                                    <?php } ?>
                                <?php } ?>
                                <a href="<?= $this->url("boutique", "fiches", "bonmiseenboutique", $mise->id) ?>" target="_blank" class="btn btn-block btn-white btn-sm"><i class="fa fa-file-text text-blue"></i> Voir le bon</a><br>
                            </td>
                        </td>
                    </tr>
                <?php  } ?>
            </tbody>
        </table>
    <?php }else{ ?>
        <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune commande en cours pour le moment</h1>
    <?php } ?>

</div>
</div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?> 
<?php include($this->rootPath("composants/assets/modals/modal-miseenboutique-demande.php")); ?>

<?php 
foreach ($datas as $key => $mise) {
    if ($mise->etat_id == Home\ETAT::ENCOURS) { 
        include($this->rootPath("composants/assets/modals/modal-miseenboutique2.php"));
    } 
} 
?>

</div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
