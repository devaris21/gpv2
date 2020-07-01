<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

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
                                    <h2 class="title text-uppercase gras text-blue">Bon de mise en boutique</h2>
                                    <h3 class="text-uppercase">N°<?= $mise->reference  ?></h3>
                                    <h5><?= datelong($mise->created)  ?></h5>  
                                    <h4><small>Bon édité par :</small> <span class="text-uppercase"><?= $mise->employe->name() ?></span></h4>                               
                                </div>
                            </div><hr class="mp3">

                            <div class="row">
                                <div class="col-6">
                                    <h5><span>Date :</span> <span class="text-uppercase"><?= datecourt($mise->created) ?></span></h5> 
                                    <h5><span>Heure de mise en boutique :</span> <span class="text-uppercase"><?= heurecourt($mise->created) ?></span></h5>                             
                                </div>

                                <div class="col-6 text-right">
                                    <h5><span>Entrepot de sortie :</span> <span class="text-uppercase"><?= $mise->entrepot->name() ?></span></h5>   
                                    <h5><span>Boutique de destination :</span> <span class="text-uppercase"><?= $mise->boutique->name() ?></span></h5>                                                  </div>
                                </div><br><br>

                                <table class="table table-bordered">
                                    <thead class="text-uppercase" style="background-color: #dfdfdf">
                                        <tr>
                                            <th colspan="2"></th>
                                            <th class="text-center">Quantité récupérée</th>
                                            <th class="text-center">restait en entrepôt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) {
                                            $ligne->actualise(); ?>
                                            <tr>
                                                <td width="80">
                                                    <img style="width: 100%; height: 60px" src="<?= $this->stockage("images", "produits", $ligne->prixdevente->produit->image) ?>">
                                                </td>
                                                <td class="desc">
                                                    <h3 class="mp0 text-uppercase gras"><?= $ligne->prixdevente->produit->name() ?></h3>
                                                    <span><?= $ligne->prixdevente->prix->price() ?> <?= $params->devise  ?></span>
                                                </td>
                                                <td class="text-center"><h2 class="gras"><?= start0(money($ligne->quantite)) ?></h2></td>
                                                <td class="text-center"><h2><?= ($mise->etat_id == Home\ETAT::VALIDEE)? $ligne->restant : "" ?></h2></td>
                                                <!-- <td class="text-center gras text-muted"><br><h3><?= ($mise->etat_id == Home\ETAT::VALIDEE)? $ligne->reste : "" ?></h3></td> -->
                                            </tr>
                                        <?php } ?>                            
                                    </tbody>
                                </table>

                                <br>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-7">
                                        <table class="table">
                                            <thead>
                                       <!--  <tr>
                                            <th colspan="4"><h4 class="gras text-uppercase">Observation du client</h4></th>
                                        </tr> -->
                                    </thead>
                                    <tbody>
                                        <tr style="height: 60px">
                                            <td class="gras">Observation : </td>
                                            <td><?= $mise->comment ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-5">
                                <div class="text-right" style="margin-bottom: 20%;">
                                    <span><u>Signature & Cachet</u></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <hr>




                </div>
            </div>

        </div>
    </div>


</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>


</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>


</body>

</html>
