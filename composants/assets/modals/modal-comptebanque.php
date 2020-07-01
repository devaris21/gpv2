<div class="modal inmodal fade" id="modal-comptebanque">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Formulaire des comptes & banques</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="comptebanque">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Nom du compte <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>  
                        <div class="col-sm-6">
                            <label>Solde du compte <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="initial" required>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Etablissement si banque</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="etablissement" uppercase>
                            </div>
                        </div>  
                        <div class="col-sm-6">
                            <label>N° de compte</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="numero" uppercase>
                            </div>
                        </div>                        
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