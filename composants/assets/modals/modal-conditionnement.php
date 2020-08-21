
<div class="modal inmodal fade" id="modal-conditionnement-<?= $pro->id ?>" style="z-index: 9999999999">
    <div class="modal-dialog modal-xll">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nouveau conditionnement</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer le conditionnement</small>
            </div>
            <form class="formConditionnement">
                <div class="row">
                    <div class="col-md-8">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="text-uppercase">Les differents produits</h5>
                            </div>
                            <div class="ibox-content"><br>
                                <div class="table-responsive">
                                    <table class="table  table-striped">
                                        <tbody class="commande">
                                            <?php $datas = $pro->fourni(["isActive = "=> Home\TABLE::OUI]);
                                            if (count($datas) > 0) {
                                                foreach ($datas as $key => $produit) {
                                                    $produit->actualise(); ?>
                                                    <tr class="border-0 border-bottom">
                                                        <td class="text-left" width="200">
                                                            <br>
                                                            <h5 class="mp0 text-uppercase"><?= $pro->name() ?></h5>
                                                            <h1><?= $produit->quantite->name() ?></h1>
                                                        </td>
                                                        <?php foreach (Home\FORMATEMBALLAGE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $format) {  ?>
                                                            <td class="text-center">
                                                                <img src="http://dummyimage.com/50x50/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image"><br>
                                                                <small><?= $format->name() ?></small><br>
                                                                <input type="text" name="<?= $produit->id ?>-<?= $format->id ?>" number class="form-control text-center gras quantite" style="padding: 3px">
                                                            </td>
                                                        <?php }  ?>                
                                                    </tr>
                                                    <tr style="height: 20px;" />
                                                <?php }
                                            }  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="ibox"  style="background-color: #eee">
                            <div class="ibox-title" style="padding-right: 2%; padding-left: 3%; ">
                                <h5 class="text-uppercase">Finaliser le conditionnement</h5>
                            </div>
                            <div class="ibox-content"  style="background-color: #fafafa">
                                <div>
                                    <label>Ajouter une note</label>
                                    <textarea class="form-control" name="comment" rows="4"></textarea>
                                </div>

                                <input type="hidden" name="entrepot_id" value="<?= $entrepot->id ?>">
                                <hr/>
                                <button class="btn btn-primary btn-block dim"><i class="fa fa-check"></i> Valider le conditionnement</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


