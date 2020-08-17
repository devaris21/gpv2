<div role="tabpanel" id="pan-ventes" class="tab-pane">
	<div class="panel-body">

		<?php  
		$index = $date2;
		while ($index >= $date1) { ?>
		<h2><?= datecourt3($index);  ?></h2><hr>
		  <div class="row">
                        <div class="col-lg-7">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">Sorties d'entrepots du jour</h5>
                                    <div class="ibox-tools">
                                        
                                    </div>
                                </div>
                                <div class="ibox-content table-responsive">
                                    <table class="table table-hover no-margins">
                                        <thead>
                                            <tr>
                                                <th>Reference</th>
                                                <th class="">Boutique</th>
                                                <th class="">Départ à</th>
                                                <th class="">vendu</th>
                                                <th class="">heure de retour</th>
                                                <th class="">statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (Home\MISEENBOUTIQUE::programmee(dateAjoute()) as $key => $mise) {
                                                $mise->actualise(); ?>
                                                <tr>
                                                    <td><?= $mise->reference ?></td>
                                                    <td><?= $mise->boutique->name()  ?></td>
                                                    <td><?= depuis($mise->created)  ?></td>
                                                    <td><?= depuis($mise->datereception)  ?></td>
                                                    <td class="text-center"><span class="label label-<?= $mise->etat->class ?>"><?= $mise->etat->name ?></span> </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 


                        <div class="col-sm-5">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">Production du jour</h5>
                                    <div class="ibox-tools">
                                       
                                    </div>
                                </div>
                                <div class="ibox-content table-responsive">
                                    <table class="table table-hover no-margins">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <?php foreach ($quantites as $key => $qte) { ?>
                                                    <th class="text-center"><?= $qte->name()  ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($produits as $key => $produit) {
                                                $datas = $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI]); ?>
                                                <tr>
                                                    <td class="gras" style="color: <?= $produit->couleur ?>"><i class="fa fa-flask"></i> <?= $produit->name() ?></td>
                                                    <?php $total =0; foreach ($datas as $key => $pdv) {
                                                        $pdv->actualise();
                                                        $nb = $pdv->vendeDirecte(dateAjoute(), dateAjoute(), $entrepot->id);
                                                        $total += $nb * $pdv->prix->price;  ?>
                                                        <td class="text-center"><?= $nb ?></td>
                                                    <?php } ?>
                                                    <td class="text-right gras"><?= money($total) ?> <?= $params->devise ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="text-right" colspan="5">
                                                    <h2><?= money(comptage(Home\VENTE::direct(dateAjoute(), dateAjoute(), $entrepot->id), "vendu", "somme"))  ?> <?= $params->devise ?></h2>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>              

                    </div><hr>
			<?php
			$index = dateAjoute1($index, -1);
		}  ?>

	</div>
</div>