
<div class="modal inmodal fade" id="modal-transfertstockboutique<?= $produit->id  ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-blue">Transfert de stock en boutique</h4>
                <small class="font-bold text-blue">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="transfertstockboutique">
                <div class="modal-body">
                    
                    <div>
                        <h2 class="text-center"><?= $produit->name() ?></h2>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-2">
                            <label>Quantité<span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="quantite" >
                            </div>
                        </div> 
                        <div class="col-sm-4">
                            <label>Emballage à convertir <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select-tableau", $produit->getListeEmballageProduit(), null, "emballage_id_source"); ?>
                            </div>
                        </div> 
                        <div class="col-sm-2 text-center">
                            <label>Vers</label><br>
                            <i class="fa fa-long-arrow-right fa-3x"></i>
                        </div>
                        <div class="col-sm-4">
                            <label>Emballage de destination <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select-tableau", $produit->getListeEmballageProduit(), null, "emballage_id_destination"); ?>
                            </div>
                        </div>                      
                    </div><br>
                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn dim btn-primary pull-right"><i class="fa fa-refresh"></i> Valider l'opération</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>