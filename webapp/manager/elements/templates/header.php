      <div class="row border-bottom white-bg header" style="margin-bottom: 6%;">
        <nav class="navbar navbar-wrapper navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                <form role="search" class="navbar-form-custom" action="search_results.html">
                    <div class="form-group">
                        <input type="text" placeholder="Rechercher quelque chose..." class="form-control" name="top-search" id="top-search">
                    </div>
                </form>
            </div>
            <ul class="nav navbar-top-links navbar-right">

            <li class="border-right gras <?= (isJourFerie(dateAjoute(1)))?"text-red":"text-muted" ?>">
                <span class="m-r-sm welcome-message text-uppercase" id="date_actu"></span> 
                <span class="m-r-sm welcome-message gras" id="heure_actu"></span> 
            </li>

            <div>
                <a id="onglet-master" href="<?= $this->url("master", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px;"><i class="fa fa-long-arrow-left"></i> Acceuil</a>
                <?php if ($employe->boutique_id != null && $employe->isAutoriser("boutique")) { ?>
                    <a id="onglet-boutique" href="<?= $this->url("boutique", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px;"><i class="fa fa-bank"></i> Boutique</a>
                <?php } ?>
                <?php if ($employe->entrepot_id != null && $employe->isAutoriser("entrepot")) { ?>
                    <a id="onglet-entrepot" href="<?= $this->url("entrepot", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px;"><i class="fa fa-cubes"></i> Entrepôt</a>
                <?php } ?>
                <?php if ($employe->isAutoriser("manager")) { ?>
                    <a id="onglet-manager" href="<?= $this->url("manager", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px;"><i class="fa fa-gears"></i> Manager</a>
                <?php } ?>
            </div>

            <li></li>
            
        </ul>

    </nav>
</div>