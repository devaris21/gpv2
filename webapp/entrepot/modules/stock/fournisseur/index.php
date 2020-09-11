<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-8">
                    <div class="ibox">
                        <div class="ibox-content">
                            <p></p>
                            <div class="">                                
                               <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Approvision. en cours</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3"><i class="fa fa-money"></i> Transactions de caisse</a></li>
                            </ul>
                            <div class="tab-content" style="min-height: 300px;">



                               <?php if ($employe->isAutoriser("production")) { ?>

                                <div id="tab-1" class="tab-pane active"><br>
                                    <div class="row container-fluid">

                                    </div>
                                    <div class="">
                                     <?php if (count($datas + $encours) > 0) { ?>
                                        <table class="footable table table-stripped toggle-arrow-tiny">
                                            <thead>
                                                <tr>
                                                    <th data-toggle="true">Status</th>
                                                    <th>Reference</th>
                                                    <th>Enregistré par</th>
                                                    <th>Montant</th>
                                                    <th>Reste à payer</th>
                                                    <th data-hide="all"></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($encours1 as $key => $appro) {
                                                    include($this->rootPath("composants/assets/modals/modal-reglerAppro.php"));
                                                    $appro->actualise();
                                                    $lots = $appro->fourni("ligneapprovisionnement"); ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                                            <small><?= depuis($appro->created) ?></small>
                                                        </td>
                                                        <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-red"><?= money($appro->reste()) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td class="border-right">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="no">
                                                                        <?php foreach ($appro->ligneapprovisionnements as $key => $ligne) {
                                                                            $ligne->actualise(); ?>
                                                                            <th class="text-center gras"><span class="small"><?= $ligne->ressource->name() ?></span></th>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <?php foreach ($lots as $key => $ligne) { ?>
                                                                            <td class="text-center"><?= start0($ligne->quantite) ?> <?= $ligne->ressource->abbr ?></td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </tbody>  
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $this->url("fiches", "master", "bonapprovisonnement", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                                            <?php if ($appro->reste() > 0) { ?>
                                                                <button data-toggle="modal" data-target="#modal-reglerAppro<?= $appro->id  ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> Payer</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>
                                                <?php foreach ($encours2 as $key => $appro) {
                                                    include($this->rootPath("composants/assets/modals/modal-reglerApproEmballage.php"));
                                                    $appro->actualise();
                                                    $lots = $appro->fourni("ligneapproemballage"); ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                                            <small><?= depuis($appro->created) ?></small>
                                                        </td>
                                                        <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-red"><?= money($appro->reste()) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td class="border-right">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="no">
                                                                        <?php foreach ($appro->ligneapproemballages as $key => $ligne) {
                                                                            $ligne->actualise(); ?>
                                                                            <th class="text-center gras"><span class="small"><?= $ligne->emballage->name() ?></span></th>
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
                                                            <a href="<?= $this->url("fiches", "master", "bonapproemballage", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                                            <?php if ($appro->reste() > 0) { ?>
                                                                <button data-toggle="modal" data-target="#modal-reglerApproEmballage<?= $appro->id  ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> Payer</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>
                                                <?php foreach ($encours3 as $key => $appro) {
                                                    include($this->rootPath("composants/assets/modals/modal-reglerApproEtiquette.php"));
                                                    $appro->actualise();
                                                    $lots = $appro->fourni("ligneapproetiquette"); ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                                            <small><?= depuis($appro->created) ?></small>
                                                        </td>
                                                        <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-red"><?= money($appro->reste()) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
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
                                                            <a href="<?= $this->url("fiches", "master", "bonapproetiquette", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                                            <?php if ($appro->reste() > 0) { ?>
                                                                <button data-toggle="modal" data-target="#modal-reglerApproEtiquette<?= $appro->id  ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> Payer</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>


                                                <tr />
                                                <?php foreach ($datas1 as $key => $appro) {
                                                    include($this->rootPath("composants/assets/modals/modal-reglerAppro.php"));
                                                    $appro->actualise();
                                                    $lots = $appro->fourni("ligneapprovisionnement"); ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                                            <small><?= depuis($appro->created) ?></small>
                                                        </td>
                                                        <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-red"><?= money($appro->reste()) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td class="border-right">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="no">
                                                                        <?php foreach ($appro->ligneapprovisionnements as $key => $ligne) {
                                                                            $ligne->actualise(); ?>
                                                                            <th class="text-center gras"><span class="small"><?= $ligne->ressource->name() ?></span></th>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <?php foreach ($lots as $key => $ligne) { ?>
                                                                            <td class="text-center"><?= start0($ligne->quantite) ?> <?= $ligne->ressource->abbr ?></td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </tbody>  
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $this->url("fiches", "master", "bonapprovisonnement", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                                            <?php if ($appro->reste() > 0) { ?>
                                                                <button data-toggle="modal" data-target="#modal-reglerAppro<?= $appro->id  ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> Payer</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>
                                                <?php foreach ($datas2 as $key => $appro) {
                                                    include($this->rootPath("composants/assets/modals/modal-reglerApproEmballage.php"));
                                                    $appro->actualise();
                                                    $lots = $appro->fourni("ligneapproemballage"); ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                                            <small><?= depuis($appro->created) ?></small>
                                                        </td>
                                                        <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-red"><?= money($appro->reste()) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td class="border-right">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="no">
                                                                        <?php foreach ($appro->ligneapproemballages as $key => $ligne) {
                                                                            $ligne->actualise(); ?>
                                                                            <th class="text-center gras"><span class="small"><?= $ligne->emballage->name() ?></span></th>
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
                                                            <a href="<?= $this->url("fiches", "master", "bonapproemballage", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                                            <?php if ($appro->reste() > 0) { ?>
                                                                <button data-toggle="modal" data-target="#modal-reglerApproEmballage<?= $appro->id  ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> Payer</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>
                                                <?php foreach ($datas3 as $key => $appro) {
                                                    include($this->rootPath("composants/assets/modals/modal-reglerApproEtiquette.php"));
                                                    $appro->actualise();
                                                    $lots = $appro->fourni("ligneapproetiquette"); ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $appro->etat->class ?>"><?= $appro->etat->name() ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Appro N°<?= $appro->reference ?></span><br>
                                                            <small><?= depuis($appro->created) ?></small>
                                                        </td>
                                                        <td><i class="fa fa-user"></i> <?= $appro->employe->name() ?></td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-orange"><?= money($appro->montant) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-red"><?= money($appro->reste()) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
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
                                                            <a href="<?= $this->url("fiches", "master", "bonapproetiquette", $appro->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                                            <?php if ($appro->reste() > 0) { ?>
                                                                <button data-toggle="modal" data-target="#modal-reglerApproEtiquette<?= $appro->id  ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> Payer</button>
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
                                        <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucun approvisionnement pour le moment</h1>
                                    <?php } ?>
                                </div>
                            </div>

                        <?php } ?>




                        <?php if ($employe->isAutoriser("caisse")) { ?>
                            <div id="tab-3" class="tab-pane"><br>
                                <?php foreach ($fluxcaisse as $key => $transaction) {
                                    $transaction->actualise(); ?>
                                    <div class="timeline-item">
                                        <div class="row">
                                            <div class="col-2 date" style="padding-right: 1%; padding-left: 1%;">
                                                <i data-toggle="tooltip" tiitle="Imprimer le bon" class="fa fa-file-text"></i>
                                                <?= heurecourt($transaction->created) ?>
                                                <br/>
                                                <small class="text-navy"><?= datecourt($transaction->created) ?></small>
                                            </div>
                                            <div class="col-10 content">
                                                <div>
                                                 <span class="">Bon de caisse N°<strong><?= $transaction->reference ?></strong></span>
                                                 <span class="pull-right text-right <?= ($transaction->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>">
                                                    <span class="gras" style="font-size: 16px"><?= money($transaction->montant) ?> <?= $params->devise ?> <?= ($transaction->etat_id == Home\ETAT::ENCOURS)?"*":"" ?></span> <br>
                                                    <small>Par <?= $transaction->modepayement->name() ?></small><br>
                                                    <?php if ($transaction->mouvement_id != null) { ?>
                                                        <a href="<?= $this->url("fiches", "master", "boncaisse", $transaction->id)  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Bon de caisse</a>
                                                    <?php } ?>
                                                </span>
                                            </div>
                                            <p class="m-b-xs mp0"><?= $transaction->comment ?> </p>
                                            <p class="m-b-xs"><?= $transaction->structure ?> - <?= $transaction->numero ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>                 
                        </div>
                    <?php } ?>


                </div>

            </div>
        </div>
    </div>
</div>

<div class="col-sm-4">
    <div class="ibox selected">

        <div class="ibox-content">
            <div class="tab-content">
                <div id="contact-1" class="tab-pane active">
                    <h2><?= $fournisseur->name() ?> 

                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                        <i onclick="modification('fournisseur', <?= $fournisseur->id ?>)" data-toggle="modal" data-target="#modal-fournisseur" class="pull-right fa fa-pencil cursor"></i>
                    <?php } ?>
                </h2>
                <address>
                    <i class="fa fa-phone"></i>&nbsp; <?= $fournisseur->contact ?><br>
                    <i class="fa fa-map-marker"></i>&nbsp; <?= $fournisseur->adresse ?><br>
                    <i class="fa fa-envelope"></i>&nbsp; <?= $fournisseur->email ?>
                </address><hr>

                <div class="m-b-lg">
                    <span>Acompte actuel chez le fournisseur</span><br>
                    <h2 class="font-bold d-inline"><?= money($fournisseur->acompte) ?> <?= $params->devise  ?></h2> 
                    <button data-toggle="modal" data-target="#modal-acompte-fournisseur" class="cursor simple_tag pull-right"><i class="fa fa-plus"></i> Crediter acompte</button><br><br>

                    <?php if ($fournisseur->acompte > 0) { ?>
                        <button style="font-size: 11px" type="button" data-toggle="modal" data-target="#modal-fournisseur-rembourse" class="btn btn-danger dim btn-block"><i
                            class="fa fa-minus"></i> Se faire rembourser par le fournisseur
                        </button>
                    <?php } ?>

                    <hr>

                    <span>Dette actuelle chez le fournisseur</span><br>
                    <h2 class="font-bold d-inline text-red"><?= money($fournisseur->resteAPayer()) ?> <?= $params->devise  ?></h2> 
                    <?php if ($fournisseur->resteAPayer() > 0) { ?>
                        <button onclick="reglerToutesDettes(<?= $fournisseur->id ?>)" class="btn btn-xs dim btn-outline-danger pull-right"><i class="fa fa-money"></i> Régler toutes les dettes</button>
                    <?php } ?>                   

                </div>

            </div>

        </div>
    </div>
</div>
</div>
</div>
</div>



<?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?>

<?php include($this->rootPath("composants/assets/modals/modal-fournisseur.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-acompte-fournisseur.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-dette-fournisseur.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-fournisseur-rembourse.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-approvisionnement_.php")); ?>  



</div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../production/approvisionnements/script.js") ?>"></script>


</body>

</html>
