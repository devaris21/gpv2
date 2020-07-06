<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-6">
                <h2 class="text-uppercase">Recapitulatif de la journée</h2>
                <form id="formFiltrer" class="row" method="POST">
                    <div class="col-4">
                        <input type="date" value="<?= $date ?>" name="date" class="form-control">
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-sm btn-primary dim" onclick="filtrer()"><i class="fa fa-eye"></i> Voir</button>
                    </div>
                </form> 
            </div>
            <div class="col-sm-6">

            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <img style="width: 20%" src="<?= $this->stockage("images", "societe", "logo.png") ?>">
                            </div>
                            <div class="col-sm-8 text-right">
                                <h2 class="title text-uppercase gras">Recapitulatif de la journée</h2>
                                <h3>Du <?= datecourt3($date) ?></h3>
                            </div>
                        </div><hr><br>

                        <div class="row">
                            <div class="col-sm-9" style="border-right: 2px solid black">

                             <?php if ($employe->isAutoriser("production")) { ?>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="ibox ">
                                            <div class="ibox-title">
                                                <h5 class="text-uppercase">Vente par prospection du jour</h5>
                                                <div class="ibox-tools">

                                                </div>
                                            </div>
                                            <div class="ibox-content table-responsive">
                                                <table class="table table-hover no-margins">
                                                    <thead>
                                                        <tr>
                                                            <th>Commercial</th>
                                                            <th class="">Total</th>
                                                            <th class="">vendu</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (Home\PROSPECTION::effectuee($date, $boutique->getId()) as $key => $prospection) {
                                                            $prospection->actualise(); ?>
                                                            <tr>
                                                                <td><?= $prospection->commercial->name()  ?></td>
                                                                <td><?= money($prospection->montant) ?> <?= $params->devise ?></td>
                                                                <td class="gras text-green"><?= money($prospection->vendu) ?> <?= $params->devise ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <td class="text-right" colspan="5">
                                                                <h2><?= money(comptage(Home\VENTE::prospection($date, $date, $boutique->getId()), "vendu", "somme"))  ?> <?= $params->devise ?></h2>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="ibox ">
                                            <div class="ibox-title">
                                                <h5 class="text-uppercase">Vente directe du jour</h5>
                                                <div class="ibox-tools">

                                                </div>
                                            </div>
                                            <div class="ibox-content table-responsive">
                                                <table class="table table-hover no-margins">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $qte) { ?>
                                                                <th class="text-center"><?= $qte->name()  ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (Home\PRODUIT::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $produit) {
                                                            $datas = $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI]); ?>
                                                            <tr>
                                                                <td class="gras" style="color: <?= $produit->couleur ?>"><i class="fa fa-flask"></i> <?= $produit->name() ?></td>
                                                                <?php $total =0; foreach ($datas as $key => $pdv) {
                                                                    $pdv->actualise();
                                                                    $nb = $pdv->vendeDirecte($date, $date, $boutique->getId());
                                                                    $total += $nb * $pdv->prix->price;  ?>
                                                                    <td class="text-center"><?= $nb ?></td>
                                                                <?php } ?>
                                                                <td class="text-right gras"><?= money($total) ?> <?= $params->devise ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <td class="text-right" colspan="5">
                                                                <h2><?= money(comptage(Home\VENTE::direct($date, $date, $boutique->getId()), "vendu", "somme"))  ?> <?= $params->devise ?></h2>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="text-uppercase text-center">Les Commandes</h3>
                                        <?php if (count($commandes) > 0) { ?>
                                            <table class="table table-striped table-hover table-striped">
                                                <tbody>
                                                    <?php foreach ($commandes as $key => $commande) {
                                                        $commande->actualise(); ?>
                                                        <tr>
                                                            <td><a href="<?= $this->url("boutique", "fiches", "boncommande", $commande->getId())  ?>"><i class="fa fa-2x fa-file-text-o"></i></a></td>
                                                            <td>
                                                                <span><?= $commande->groupecommande->client->name() ?></span>
                                                            </td>
                                                            <td>
                                                                <h6 class="mp0"><span class=""><?= $commande->zonedevente->name() ?></span></h6>   
                                                                <h6 class="mp0"><span class=""><?= $commande->lieu ?></span></h6> 
                                                            </td>
                                                            <td><?= money($commande->montant) ?> <?= $params->devise ?></td>
                                                        </tr>
                                                    <?php } ?>  
                                                </tbody>
                                            </table>
                                        <?php }else{ ?>
                                            <p class="text-center text-muted italic">Aucune commande ce jour </p>
                                        <?php } ?>
                                    </div>

                                    <div class="col-sm-6 border-left">
                                        <h3 class="text-uppercase text-center">les livraisons</h3>
                                        <?php if (count($livraisons) > 0) { ?>
                                            <table class="table table-striped table-hover table-striped">
                                                <tbody>
                                                    <?php foreach ($livraisons as $key => $livraison) {
                                                        $livraison->actualise(); ?>
                                                        <tr>
                                                            <td><a href="<?= $this->url("boutique", "fiches", "bonlivraison", $livraison->getId())  ?>"><i class="fa fa-2x text-warning fa-file-text-o"></i></a></td>
                                                            <td>
                                                                <span><?= $livraison->groupelivraison->client->name() ?></span>
                                                            </td>
                                                            <td>
                                                                <h6 class="mp0"><span class=""><?= $livraison->zonedevente->name() ?></span></h6>   
                                                                <h6 class="mp0"><span class=""><?= $livraison->lieu ?></span></h6> 
                                                            </td>
                                                            <td><?= money($livraison->montant) ?> <?= $params->devise ?></td>
                                                        </tr>
                                                    <?php } ?>  
                                                </tbody>
                                            </table>
                                        <?php }else{ ?>
                                            <p class="text-center text-muted italic">Aucune livraison ce jour </p>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php } ?><hr><br>


                                <?php if ($employe->isAutoriser("caisse")) { ?>
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover ">
                                                <thead>
                                                    <tr class="text-center text-uppercase">
                                                        <th colspan="2" style="visibility: hidden; width: 62%"></th>
                                                        <th>Entrée</th>
                                                        <th>Sortie</th>
                                                        <th>Résultats</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2">Repport du solde de la veille (<?= datecourt(dateAjoute(-1)) ?>) </td>
                                                        <td class="text-center">-</td>
                                                        <td class="text-center">-</td>
                                                        <td style="background-color: #fafafa" class="text-center"><?= money($repport = $last = Home\OPERATION::resultat(Home\PARAMS::DATE_DEFAULT , dateAjoute(-1), $boutique->getId())) ?> <?= $params->devise ?></td>
                                                    </tr>
                                                    <?php foreach ($operations as $key => $operation) { ?>
                                                        <tr style="font-size: 11px;">
                                                            <td style="background-color: rgba(<?= hex2rgb($operation->categorieoperation->color) ?>, 0.6);" width="15"><a target="_blank" href="<?= $this->url("boutique", "fiches", "boncaisse", $operation->getId())  ?>"><i class="fa fa-file-text-o fa-2x"></i></a></td>
                                                            <td>
                                                                <h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>"><?= $operation->categorieoperation->name() ?> <span><?= ($operation->etat_id == Home\ETAT::ENCOURS)?"*":"" ?></span> <span class="pull-right"><i class="fa fa-clock-o"></i> <?= heurecourt($operation->created) ?></span></h6>
                                                                <i style="font-size: 11px;"><?= $operation->comment ?></i>
                                                            </td>
                                                            <?php if ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE) { ?>
                                                                <td class="text-center text-green gras" style="padding-top: 12px; font-size: 11px;">
                                                                    <?= money($operation->montant) ?> <?= $params->devise ?>
                                                                </td>
                                                                <td class="text-center"> - </td>
                                                            <?php }elseif ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::SORTIE) { ?>
                                                                <td class="text-center"> - </td>
                                                                <td class="text-center text-red gras" style="padding-top: 12px; font-size: 11px;">
                                                                    <?= money($operation->montant) ?> <?= $params->devise ?>
                                                                </td>
                                                            <?php } ?>
                                                            <?php $last += ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)? $operation->montant : -$operation->montant ; ?>
                                                            <td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr >
                                                        <td colspan="2"><h4 class="text-uppercase mp0 text-right">Total des comptes du jour</h4></td>
                                                        <td><h4 class="text-center text-green"><?= money(comptage($entrees, "montant", "somme") + $repport) ?> <?= $params->devise ?></h4></td>
                                                        <td><h4 class="text-center text-red"><?= money(comptage($depenses, "montant", "somme")) ?> <?= $params->devise ?></h4></td>
                                                        <td><h4 class="text-center"><?= money($last) ?> <?= $params->devise ?></h4></td>
                                                    </tr>
                                                    <tr style="height: 15px;"></tr>
                                                    <tr>
                                                        <td colspan="2"><h4 class="text-uppercase mp0 text-right">Solde du compte au <?= datecourt(dateAjoute()) ?></h4></td>
                                                        <td colspan="3"><h2 class="text-center"><?= money($last) ?> <?= $params->devise ?></h2></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>


                            </div>
                            <div class="col-sm-3 text-right">
                                <h4 class="text-uppercase">Employés connectés</h4>
                                <ul>
                                    <?php foreach ($employes as $key => $emp) { 
                                        $emp->actualise();  ?>
                                        <li><?= $emp->name(); ?></li>
                                    <?php } ?>
                                </ul><br>
                                <hr>


                                <h4 class="text-uppercase">Total des ventes</h4><br>   

                                <h6>Total vente par production</h6>
                                <h4 class="text-info"><?= money($p = comptage(Home\VENTE::prospection($date, $date, $boutique->getId()), "vendu", "somme")); ?> <?= $params->devise ?></h4>

                                <h6>Total vente directe</h6>
                                <h4 class="text-blue"><?= money($v = comptage(Home\VENTE::direct($date, $date, $boutique->getId()), "vendu", "somme")); ?> <?= $params->devise ?></h4>

                                <h5 class="text-uppercase">Total des vente du jour</h5>
                                <h3 class="text-blue"><?= money($p + $v); ?> <?= $params->devise ?></h3>
                                <hr>


                                <?php if ($employe->isAutoriser("caisse")) { ?>
                                    <h4 class="text-uppercase">SOLDE DE LA CAISSE</h4>
                                    <div class="">
                                        <small>Solde en Ouverture</small>
                                        <h2 class="no-margins"><?= money($comptecourant->solde(Home\PARAMS::DATE_DEFAULT , dateAjoute1($date, -1))) ?> <?= $params->devise ?></h2>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar" style="width: 100%;"></div>
                                        </div>
                                    </div><br>

                                    <small>Entrées du jour</small>
                                    <h3 class="no-margins text-green"><?= money($comptecourant->depots($date , $date)) ?></h3>
                                    <br>

                                    <small>Dépenses du jour</small>
                                    <h3 class="no-margins text-red"><?= money($comptecourant->retraits($date , $date)) ?></h3>
                                    <br>

                                    <div class="">
                                        <small>Solde à la fermeture</small>
                                        <h2 class="no-margins"><?= money($comptecourant->solde(Home\PARAMS::DATE_DEFAULT , $date)) ?> <?= $params->devise ?></h2>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar" style="width: 100%;"></div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php } ?>
                                <br>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>


    </div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>


</body>

</html>
