<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content animated fadeInRight article">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <div class="ibox"  >
                        <div class="ibox-content"  style="min-height: 33cm; background-image: url(<?= $this->stockage("images", "societe", "filigrane.png")  ?>) ; background-size: 50%; background-position: center center; background-repeat: no-repeat;">


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
                                    <?php if ($prospection->typeprospection_id == Home\TYPEPROSPECTION::PROSPECTION) { ?>
                                        <h2 class="title text-uppercase gras text-blue">Bon de sortie</h2>
                                    <?php }else{ ?>                                        
                                        <h2 class="title text-uppercase gras text-blue">Bon de vente en cave</h2>
                                    <?php } ?>
                                    <h3 class="text-uppercase">N°<?= $prospection->reference  ?></h3>
                                    <h5><?= datelong($prospection->created)  ?></h5>  
                                    <h4><small>Bon édité par :</small> <span class="text-uppercase"><?= $prospection->employe->name() ?></span></h4>                                
                                </div>
                            </div><hr class="mp3">

                            <div class="row">
                                <div class="col-6">
                                    <h5><span>Date :</span> <span class="text-uppercase"><?= datecourt($prospection->created) ?></span></h5> 
                                    <h5><span>Heure de depart :</span> <span class="text-uppercase"><?= heurecourt($prospection->created) ?></span></h5>     
                                    <h5><span>Zone de livraison :</span> <span class="text-uppercase"><?= $prospection->zonedevente->name() ?></span></h5>  
                                </div>

                                <div class="col-6 text-right">
                                    <h5><span>Commercial :</span> <span class="text-uppercase"><?= $prospection->commercial->name() ?></span></h5>
                                    <h5><span>Monnaie de prospection :</span> <span class="text-uppercase"><?= money($prospection->monnaie) ?> <?= $params->devise ?></span></h5> 
                                    <h5><span>Transport pour la prospection :</span> <span class="text-uppercase"><?= money($prospection->transport) ?> <?= $params->devise ?></span></h5> 
                                </div>
                            </div><br><br>

                            <table class="table table-bordered">
                                <thead class="text-uppercase" style="background-color: #dfdfdf">
                                    <tr>
                                        <th colspan="2"></th>
                                        <th class="text-center">Quantité emportée</th>
                                        <th class="text-center">quantité vendue</th>
                                        <th class="text-center" width="120">perte</th>
                                        <th class="text-center">Quantité retournée</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($prospection->ligneprospections as $key => $ligne) {
                                        $ligne->actualise(); ?>
                                        <tr>
                                            <td width="70">
                                                <img style="width: 100%; height: 50px" src="<?= $this->stockage("images", "produits", $ligne->prixdevente->produit->image) ?>">
                                            </td>
                                            <td class="desc">
                                                <h5 class="mp0 text-uppercase gras"><?= $ligne->prixdevente->produit->name() ?></h5>
                                                <span><?= $ligne->prixdevente->quantite->name() ?></span>
                                            </td>
                                            <td class="text-center">
                                                <h2 class="gras mp0"><?= start0($ligne->quantite) ?></h2>
                                                <i><?= money($ligne->quantite * $ligne->prixdevente->prix->price) ?> <?= $params->devise ?></i>
                                            </td>
                                            <td class="text-center">
                                                <?php if (($prospection->etat_id == Home\ETAT::VALIDEE)) { ?>
                                                   <h2 class="mp0 text-green"><?= start0($ligne->quantite_vendu)  ?></h2>
                                                   <i><?= money($ligne->quantite_vendu * $ligne->prixdevente->prix->price) ?> <?= $params->devise ?></i>
                                               <?php } ?>                                               
                                           </td>
                                           <td class="text-center text-red"><br><h3><?= ($prospection->etat_id == Home\ETAT::VALIDEE) ? start0($ligne->perte) : "" ?></h3>
                                           </td>
                                           <td class="text-center gras text-muted"><br><h3><?= ($prospection->etat_id == Home\ETAT::VALIDEE)? start0($ligne->reste) : "" ?></h3></td>
                                       </tr>
                                   <?php } ?>                            
                               </tbody>
                           </table>

                           <br><br>
                           <div class="row">
                            <div class="col-7">
                                <h5><span>Total à vendre :</span> <h2 class="text-uppercase text-red gras d-inline"><?= money($prospection->montant) ?> <?= $params->devise ?></h2></h5>  <br><br><br>

                                <h5><span>Total vendu :</span> <h2 class="text-uppercase text-green gras d-inline"><?= ($prospection->etat_id == Home\ETAT::VALIDEE)? money($prospection->vendu)." ".$params->devise : "" ?></h2></h5><br><br>                        
                            </div>
                            <div class="col-5">
                                <div class="text-right">
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


</body>

</html>
