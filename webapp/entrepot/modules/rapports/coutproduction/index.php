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
                                <h2 class="title text-uppercase gras text-blue">Production</h2>
                                <h3 class="text-uppercase">N°<?= $production->reference  ?></h3>
                                <h5><?= datelong($production->created)  ?></h5>  
                                <h4><small>Bon édité par :</small> <span class="text-uppercase"><?= $production->employe->name() ?></span></h4>                               
                            </div>
                        </div><hr class="mp3">

                        <div class="row">
                            <div class="col-6">
                                <h5><span>Date :</span> <span class="text-uppercase"><?= datecourt($production->created) ?></span></h5> 
                                <h5><span>Heure :</span> <span class="text-uppercase"><?= heurecourt($production->created) ?></span></h5>                             
                            </div>

                            <div class="col-6 text-right">
                                <h5><span>Entrepot  :</span> <span class="text-uppercase"><?= $production->entrepot->name() ?></span></h5>   
                            </div>
                        </div><br><br>

                        <table class="table table-bordered">
                            <thead class="text-uppercase" style="background-color: #dfdfdf">
                                <tr>
                                    <th></th>
                                    <th class="text-center">Quantité produite</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($production->ligneproductions as $key => $ligne) {
                                    $ligne->actualise();
                                    $total = 0; ?>
                                    <tr>
                                        <td class="desc">
                                            <h5 class="mp0 text-uppercase gras"><?= $ligne->typeproduit_parfum->name() ?></h5>
                                        </td>
                                        <td class="text-center">
                                            <h2 class="gras mp0"><?= start0($ligne->quantite) ?> <small class="small"><?= $ligne->typeproduit_parfum->typeproduit->unite ?>(s)</small></h2>
                                        </td>
                                    </tr>
                                    <tr style="height: 15px;" />

                                    <tr>
                                        <td colspan="2">
                                            <div class="row justify-content-center">
                                                <?php foreach ($ligne->typeproduit_parfum->fourni("exigenceproduction") as $key => $exi) {
                                                    foreach ($exi->fourni("ligneexigenceproduction") as $key => $lig) {
                                                        $lig->actualise();
                                                        if ($lig->quantite > 0) {
                                                            $qua = round(($lig->quantite * $ligne->quantite / $exi->quantite), 2);
                                                            $prix = $qua * $lig->ressource->price(); ?>
                                                            <div class="col-sm border-right">
                                                                <?= $lig->ressource->name() ?>: <i><b><?= $qua ?> <?= $lig->ressource->abbr ?></b> (<?= money($prix) ?> <?= $params->devise ?>)</i>
                                                            </div>
                                                            <?php 
                                                            $total+= $prix; }
                                                        }
                                                    } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="text-uppercase gras">Coût d'achat :</h4>
                                            </td>
                                            <td><h4><i><b><?= money($total) ?> <?= $params->devise ?></b></i></h4></td>
                                        </tr>
                                        <tr style="height: 15px;" />

                                        <tr>
                                            <td>
                                                <h4 class="text-uppercase gras">Coût de production :</h4>
                                            </td>
                                            <td>
                                                <h4><i><b><?= money($production->maindoeuvre) ?> <?= $params->devise ?></b></i></h4>
                                            </td>
                                        </tr>
                                        <tr style="height: 15px;" />

                                        <tr>
                                            <td ><h4 class="text-uppercase text-warning">Coût de production total</h4></td>
                                            <td ><h4><i><b><?= money($production->maindoeuvre + $total) ?> <?= $params->devise ?></b></i></h4></td>
                                        </tr>
                                        <tr style="height: 30px;" />

                                        <tr>
                                            <td colspan="2">
                                                <div class="row">
                                                    <?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $qua) { ?>
                                                        <div class="col-sm border-right ">
                                                            Soit <?= $qua->name()  ?> vous coûte environs  = <i><b><?= money(($production->maindoeuvre + $total) / $ligne->quantite * $qua->name ) ?> <?= $params->devise ?></b></i>
                                                        </div>
                                                    <?php } ?>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr style="height: 15px" />

                                        <?php foreach ($ligne->typeproduit_parfum->fourni("produit") as $key => $produit) {
                                            if ($produit->isActive()) {
                                                $produit->actualise(); ?>
                                                <tr>
                                                    <td><?= $produit->name(); ?></td>
                                                    <?php foreach ($produit->getListeEmballageProduit() as $key => $emballage) {
                                                        $prix = $produit->fourni("price", ["emballage_id ="=>$emballage->id])[0];
                                                        $etiquette = $produit->fourni("etiquette")[0];

                                                        $cout = (($production->maindoeuvre + $total) / $ligne->quantite * $produit->quantite->name) + $emballage->price() + $etiquette->price(); ?>
                                                        <td>
                                                            <div class="text-center" style="color: blue">
                                                                <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $emballage->image)  ?>">
                                                                <small><?= $emballage->name(); ?></small>
                                                                <h5 class="text-danger" title="Coût de revient unitaire"><?= money($cout) ?> <?= $params->devise ?></h5>
                                                                <h5 class="text-green" title="Bénéfice unitaire"><?= money($prix->prix - $cout) ?> <?= $params->devise ?> /// <?= money($prix->prix_gros - $cout) ?> <?= $params->devise ?></h5>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php }
                                        } ?>



                                    <?php } ?>                            
                                </tbody>
                            </table><br>

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
                                            <td><?= $production->comment ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-5">
                                <!-- <div class="text-right" style="margin-bottom: 20%;">
                                    <span><u>Signature & Cachet</u></span>
                                </div> -->
                            </div>
                        </div>


                        <hr>




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
