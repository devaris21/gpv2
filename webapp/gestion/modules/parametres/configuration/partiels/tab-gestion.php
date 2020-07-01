    <div role="tabpanel" id="tab-gestion" class="tab-pane">
        <div class="row">


            <div class="col-md-12 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Exigence de production par ressource</h5>
                        <div class="ibox-tools">

                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Les produits</th>
                                    <?php foreach (Home\RESSOURCE::findBy([], [], ["name"=>"ASC"]) as $key => $ressource) {  ?>
                                        <td class="gras text-center"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "ressources", $ressource->image); ?>"> <?= $ressource->name(); ?></td>
                                    <?php } ?>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (Home\PRODUIT::findBy([], [], ["name"=>"ASC"]) as $key => $prod) { ?> 
                                    <tr>
                                        <td class="gras"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "produits", $prod->image); ?>"> <?= $prod->name(); ?></td>

                                        <?php 
                                        foreach (Home\RESSOURCE::findBy([], [], ["name"=>"ASC"]) as $key => $ressource) {
                                            $item = Home\EXIGENCEPRODUCTION::findBy(["produit_id ="=>$prod->getId(), "ressource_id ="=>$ressource->getId()])[0]; 
                                            $item->actualise(); ?>
                                            <td class="text-center"><?= money($item->quantite_ressource); ?> <?= $item->ressource->abbr ?> pour <b><?= $item->quantite_produit ?></b></td>
                                        <?php } ?>
                                        <td><i class="fa fa-pencil cursor" data-toggle="modal" data-target="#modal-exigence<?= $prod->getId() ?>"> </i></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Paye par production</h5>
                        <div class="ibox-tools">
                            <a data-toggle="modal" data-target="#modal-paye_produit">
                                <i class="fa fa-plus"></i> Modifier les prix
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Production</th>
                                    <th>Rangement</th>
                                    <th>Livraison</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\PAYE_PRODUIT::findBy() as $key => $item) {
                                    $item->actualise() ?>
                                    <tr>
                                        <td class="gras"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "produits", $item->produit->image); ?>"> <?= $item->produit->name(); ?></td>
                                        <td><?= money($item->price) ?> <?= $params->devise ?></td>
                                        <td><?= money($item->price_rangement) ?> <?= $params->devise ?></td>
                                        <td><?= money($item->price_livraison) ?> <?= $params->devise ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Paye par production <span class="text-red">dimanches & jours fériés</span></h5>
                        <div class="ibox-tools">
                            <a data-toggle="modal" data-target="#modal-paye_produit_ferie">
                                <i class="fa fa-plus"></i> Modifier les prix
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Production</th>
                                    <th>Rangement</th>
                                    <th>Livraison</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\PAYEFERIE_PRODUIT::findBy() as $key => $item) {
                                    $item->actualise() ?>
                                    <tr>
                                        <td class="gras"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "produits", $item->produit->image); ?>"> <?= $item->produit->name(); ?></td>
                                        <td class="text-red"><?= money($item->price) ?> <?= $params->devise ?></td>
                                        <td class="text-red"><?= money($item->price_rangement) ?> <?= $params->devise ?></td>
                                        <td class="text-red"><?= money($item->price_livraison) ?> <?= $params->devise ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-12 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Tranche des prix par produit</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php $i =0; foreach (Home\PRIX::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $prix) {  ?>
                                        <td class="gras text-center"><?= $prix->price(); ?> <?= $params->devise ?></td>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\PRODUIT::findBy(["isActive ="=>Home\TABLE::OUI], [], ["name"=>"ASC"]) as $key => $produit) { ?>
                                    <tr>
                                        <td class="gras"><?= $produit->name(); ?></td>
                                        <?php foreach (Home\PRIX::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $prix) { 
                                            $datas = $prix->fourni("prixdevente", ["produit_id ="=>$produit->getId()]);
                                            $pz = $datas[0]; $pz->actualise(); ?>

                                            <td class="text-center">
                                                <div class="switch" style="display: inline-block;">
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" <?= ($pz->isActive())?"checked":""  ?> onchange='changeActive("prixdevente", <?= $pz->getId() ?>)' class="onoffswitch-checkbox" id="pz<?= $pz->getId() ?>">
                                                        <label class="onoffswitch-label" for="pz<?= $pz->getId() ?>">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php if ($pz->isActive()) { ?>
                                                    <div style="display: inline-block; width: 100px; margin: 0%">
                                                        <?php Native\BINDING::html("select", "quantite", $pz, "quantite_id")  ?>
                                                    </div>
                                                <?php } ?>
                                            </td>

                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-md-12 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Stock initial par produit</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php $i =0; foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $qte) {  ?>
                                        <td class="gras text-center"><?= $qte->name(); ?></td>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\PRODUIT::findBy(["isActive ="=>Home\TABLE::OUI], [], ["name"=>"ASC"]) as $key => $produit) { ?>
                                    <tr>
                                        <td class="gras"><?= $produit->name(); ?></td>
                                        <?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $qte) { 
                                            $datas = $qte->fourni("prixdevente", ["produit_id ="=>$produit->getId()]);
                                            if (count($datas) > 0) {
                                                $pz = $datas[0]; ?>
                                                <?php if ($pz->isActive == Home\TABLE::OUI) { ?>
                                                    <td class="text-center">
                                                        <span class="cursor" data-toggle="modal" data-target="#modal-prixdevente-stock" onclick="modification('prixdevente', <?= $pz->getId() ?>)"><?= $pz->stock ?> unités</span>
                                                    </td>
                                                <?php }else{ ?>
                                                    <td class="text-center">
                                                        <span class="cursor" data-toggle="modal" data-target="#modal-prixdevente-stock" onclick="modification('prixdevente', <?= $pz->getId() ?>)"><?= $pz->stock ?> unités</span>
                                                    </td>
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <td class="text-center">
                                                    <span class="cursor btn_modal" data-toggle="modal" data-target="#modal-prixdevente-stock" onclick="session('quantite_id', <?= $qte->getId() ?>)">0 unité</span>
                                                </td>
                                            <?php } ?> 

                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
