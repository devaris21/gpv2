<div role="tabpanel" id="pan-ventes" class="tab-pane">
	<div class="panel-body">

     <?php foreach ($typeproduits as $key => $type) { ?>
        <div class="ibox">
            <div class="ibox-title">
                <h5 class="text-uppercase">Stock de <?= $type->name() ?></h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <?php foreach ($type->fourni("typeproduit_parfum", ["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
                        $pro->actualise(); ?>
                        <div class="col-md border-right">
                            <h6 class="text-uppercase text-center gras" style="color: <?= $pro->couleur; ?>"><?= $pro->name() ?></h6>
                            <ul class="list-group clear-list m-t">
                                <?php foreach ($pro->fourni("produit", ["isActive ="=>Home\TABLE::OUI]) as $key => $produit) {
                                    $produit->actualise();  ?>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <i class="fa fa-flask"></i> <small><?= $produit->quantite->name() ?></small>
                                            </div>  
                                            <div class="col-md-9">
                                                <div class="row text-center">
                                                    <?php foreach ($produit->getListeEmballageProduit() as $key => $emballage) {
                                                        $a = $produit->enEntrepot(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $emballage->id, $entrepot->id);
                                                        if ($a > 0) { ?>
                                                            <div class="col-sm-4 cursor border-right border-bottom" data-toggle="modal" onclick="session('produit_id', <?= $produit->id ?>)" data-target="#modal-transfertstockboutique<?= $produit->id  ?>">
                                                                <span class="gras <?= ($a >= $params->ruptureStock)?"":"text-red clignote" ?>"><?= start0($a) ?></span><br>
                                                                <span class="">     
                                                                    <img style="height: 15px" src="<?= $this->stockage("images", "emballages", $emballage->image)  ?>"> <small><?= $emballage->name() ?></small>
                                                                </span> 
                                                            </div>
                                                        <?php }
                                                    } ?> 
                                                </div>
                                            </div>
                                        </div>                                                                
                                    </li>
                                <?php } ?>
                                <li class="list-group-item"></li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    
</div>
</div>