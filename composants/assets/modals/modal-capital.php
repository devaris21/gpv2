<div class="modal inmodal fade" id="modal-capitaux">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Formulaire des capitaux</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="capitaux">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Libéllé <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>  
                        <div class="col-sm-6">
                            <label>Montant du capital <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="montant" required>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <label>Compte à approvisionnement <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "comptebanque") ?>
                            </div>
                        </div>                       
                    </div>
                    <div class="">
                        <label>Ajouter un commentaire </label>
                        <textarea class="form-control" name="comment" rows="4"></textarea>
                    </div>
                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn dim btn-primary pull-right"><i class="fa fa-refresh"></i> Valider le formulaire</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>