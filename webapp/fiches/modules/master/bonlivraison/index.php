<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="top-navigation">

    <div id="wrapper">



        <div id="page-wrapper" class="gray-bg">



          <div class="wrapper wrapper-content animated fadeInRight article">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <div class="ibox"  >
                        <div class="ibox-content"  style="height: 33cm; background-image: url(<?= $this->stockage("images", "societe", "filigrane.png")  ?>) ; background-size: 50%; background-position: center center; background-repeat: no-repeat;">


                           <div>
                              <div class="row">
                                <div class="col-sm-5">
                                    <div class="row">
                                        <div class="col-3">
                                            <img style="width: 120%" src="<?= $this->stockage("images", "societe", $params->image) ?>">
                                        </div>
                                        <div class="col-9">
                                            <h5 class="gras text-uppercase text-orange"><?= $params->societe ?></h5>
                                            <h5 class="mp0"><?= $params->adresse ?></h5>
                                            <h5 class="mp0"><?= $params->postale ?></h5>
                                            <h5 class="mp0">Tél: <?= $params->contact ?></h5>
                                            <h5 class="mp0">Email: <?= $params->email ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7 text-right">
                                    <h2 class="title text-uppercase gras text-blue">Bon de livraison</h2>
                                    <h3 class="text-uppercase">N°<?= $livraison->reference  ?></h3>
                                    <h5><?= datelong($livraison->created)  ?></h5>  
                                    <h4><small>Bon édité par :</small> <span class="text-uppercase"><?= $livraison->employe->name() ?></span></h4>                                
                                </div>
                            </div><hr class="mp3">

                            <div class="row">
                                <div class="col-6">
                                    <h5><span>Client :</span> <span class="text-uppercase"><?= $livraison->groupecommande->client->name() ?></span></h5>   
                                    <h5><span>Zone de livraison :</span> <span class="text-uppercase"><?= $livraison->zonedevente->name() ?></span></h5>   
                                    <h5><span>Lieu de livraison :</span> <span class="text-uppercase"><?= $livraison->lieu ?></span></h5>                              
                                </div>

                                <div class="col-6 text-right">
                                    <h5><span>Commercial :</span> <span class="text-uppercase"><?= $livraison->commercial->name() ?></span></h5>
                                </div>
                            </div><br><br>

                            <table class="table table-bordered">
                                <thead class="text-uppercase" style="background-color: #dfdfdf">
                                    <tr>
                                        <th colspan="2"></th>
                                        <th class="text-center">Quantité à livrer</th>
                                        <th class="text-center">Quantité livrées</th>
                                        <th class="text-center" width="120">perte</th>
                                        <!-- <th class="text-center">Reste à livrer</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($livraison->ligneprospections as $key => $ligne) {
                                        $ligne->actualise(); ?>
                                        <tr>
                                            <td class="desc">
                                                <h5 class="mp0 text-uppercase gras"><?= $ligne->produit->name() ?></h5>
                                                <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                                <small><?= $ligne->emballage->name() ?></small>
                                            </td>
                                            <td class="text-center">
                                                <h2 class="gras mp0"><?= start0($ligne->quantite) ?></h2>
                                                <!-- <i><?= money($ligne->price) ?> <?= $params->devise ?></i> -->
                                            </td>
                                            <td class="text-center"><h2 class="gras"><?= start0(money($ligne->quantite)) ?></h2></td>
                                            <td class="text-center"><h2><?= ($livraison->etat_id == Home\ETAT::VALIDEE)? $ligne->quantite_vendu : "" ?></h2></td>
                                            <td class="text-center text-red"><br><h3><h3><?= ($livraison->etat_id == Home\ETAT::VALIDEE) ? start0($ligne->quantite - $ligne->quantite_vendu) : "" ?></h3></td>
                                            <!-- <td class="text-center gras text-muted"><br><h3><?= ($livraison->etat_id == Home\ETAT::VALIDEE)? $ligne->reste : "" ?></h3></td> -->
                                        </tr>
                                    <?php } ?>                            
                                </tbody>
                            </table>

                            <br>
                            <div class="row">
                                <div class="col-7">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="4"><h4 class="gras text-uppercase">Observation du client</h4></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="gras">Livraison reçue le : </td>
                                                <td><?= datecourt($livraison->dateretour) ?></td>
                                            </tr>
                                            <tr style="height: 60px">
                                                <td class="gras">Observation : </td>
                                                <td><?= $livraison->comment ?></td>
                                            </tr>
                                            <tr style="height: 80px">
                                                <td class="gras">Noms, contacts & signature : </td>
                                                <td>
                                                    <span><?= $livraison->nom_receptionniste ?></span><br>
                                                    <span><?= $livraison->contact_receptionniste ?></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-5">
                                    <div class="text-right" style="margin-top: 14%;">
                                        <span><u>Signature & Cachet</u></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr>
                        <p class="text-center"><small><i>* Nous vous prions de vérifier l'exactitude de toutes les informations qui ont été mentionnées sur cette facture avant de quitter la boutique !</i></small></p>




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
