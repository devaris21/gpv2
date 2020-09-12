<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="top-navigation">

    <div id="wrapper">



        <div id="page-wrapper" class="gray-bg">



          <div class="wrapper wrapper-content animated fadeInRight article">
            <div class="row justify-content-md-center">
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-content" style="padding: 5% !important">
                            <div class="row">
                                <div class="col-4">
                                    <img style="width: 120%; margin-top: -15%" src="<?= $this->stockage("images", "societe", $params->image) ?>">
                                </div>
                                <div class="col-8 text-right">
                                    <h6 class="gras text-uppercase text-orange"><?= $params->societe ?></h6>
                                    <h6 class="mp0"><?= $params->adresse ?></h6>
                                    <h6 class="mp0"><?= $params->postale ?></h6>
                                    <h6 class="mp0">Tél: <?= $params->contact ?></h6>
                                    <h6 class="mp0">Email: <?= $params->email ?></h6>
                                </div>
                            </div><hr class="mp3">

                            <div class="row">
                                <div class="col-6">
                                    <h4 class="title text-uppercase gras text-blue mp0">Facture</h4>  
                                    <h5>N°<?= $vente->reference  ?></h5>
                                </div>

                                <div class="col-6 text-right">
                                    <h6 class="gras"><?= $vente->employe->name() ?></h6>   
                                    <h6><?= datelong($vente->created) ?></h6> 
                                </div>
                            </div><br>

                            <table class="table table-striped">
                                <tbody>
                                    <?php foreach ($vente->lignedeventes as $key => $ligne) {
                                        $ligne->actualise(); ?>
                                        <tr>
                                            <td width="70">
                                                <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                            </td>
                                            <td class="desc">
                                                <h6 class="text-uppercase gras"><?= $ligne->produit->name() ?> <?= $params->devise ?></h6>
                                                <i><?= $ligne->emballage->name() ?> X <?= start0($ligne->quantite) ?></i>
                                            </td>
                                            <td class="text-center">
                                                <br><span><?= money($ligne->price) ?> <?= $params->devise ?></span>
                                            </td>
                                        </tr>
                                    <?php } ?>                            
                                </tbody>
                            </table><hr>
                            <div class="row">
                                <div class="offset-sm-6 col-sm-6 text-right">
                                    <h4 class="text-muted gras d-inline mp0"><span>Montant total :</span> <?= money($vente->montant + $vente->reduction - $vente->tva) ?> <?= $params->devise ?></h4>   
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="offset-sm-6 col-sm-6 text-right">
                                    <h5 class="text-muted gras d-inline mp0"><span>TVA (<?= start0($vente->taux_tva) ?>%) :</span> <?= money($vente->tva) ?> <?= $params->devise ?></h5> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-sm-6 col-sm-6 text-right">
                                    <h5 class="text-muted gras d-inline mp0"><span>Reduction :</span> <?= money($vente->reduction) ?> <?= $params->devise ?></h5>                                </div>
                                </div><br>
                                <div class="text-right">
                                    <h5 class="mp0">
                                        <span>Net à payer :</span>
                                        <h4 class="text-red gras d-inline mp0"><?= money($vente->montant) ?> <?= $params->devise ?></h4>
                                    </h5>                  
                                </div><br>

                                <div class="row">
                                    <div class="col-sm">
                                        <h5 class="mp0">
                                            <span>Montant réçu :</span>
                                            <h4 class="gras d-inline mp0"><?= money($vente->recu) ?> <?= $params->devise ?></h4>
                                        </h5>   
                                    </div>
                                    <div class="col-sm text-right">
                                        <h5 class="mp0">
                                            <span>Monnaie rendu :</span>
                                            <h4 class="text-muted gras d-inline mp0"><?= money($vente->rendu) ?> <?= $params->devise ?></h4>
                                        </h5>   
                                    </div>
                                </div>


                                <hr>
                                <p class="text-center"><small><i>Très bonne dégustation et à bientôt !</i></small></p>

                            </div>
                        </div>

                    </div>
                </div>


            </div>


            <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>


        </div>
    </div>


    <?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>

    <button class="btn btn-outline-primary btn-rounded btn-xs d-print-none" onclick="window.print()" style="position: fixed; bottom: 8%; right: 2%; z-index: 8000"><i class="fa fa-print"></i> Imprimer la fiche</button>

</body>

</html>
