<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <h1 class="logo-name text-center" style="font-size: 50px; letter-spacing: 5px; margin: 0% auto !important; padding: 0% !important;">GPV</h1>
            <li class="nav-header" style="padding: 15px 10px !important; background-color: orange">
                <div class="dropdown profile-element">                        
                    <div class="row">
                        <div class="col-3">
                            <img alt="image" class="rounded-circle" style="width: 35px" src="<?= $this->stockage("images", "employes", $employe->image) ?>"/>
                        </div>
                        <div class="col-9">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold"><?= $employe->name(); ?></span>
                                <span class="text-muted text-xs block"><?= $entrepot->name(); ?></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="<?= $this->url($this->section, "access", "locked") ?>">Vérouiller la session</a></li>
                                <li><a class="dropdown-item" href="#" id="btn-deconnexion" >Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="logo-element">
                    GPV
                </div>
            </li>

            <?php 
            $groupes__ = Home\GROUPECOMMANDE::encours();
            $approvisionnements__ = Home\APPROVISIONNEMENT::encours();

            ?>
            <ul class="nav metismenu" id="side-menu">
                <li class="" id="dashboard">
                    <a href="<?= $this->url($this->section, "master", "dashboard") ?>"><i class="fa fa-tachometer"></i> <span class="nav-label">Tableau de bord</span></a>
                </li>
                <li class="" id="clients">
                    <a href="<?= $this->url($this->section, "master", "clients") ?>"><i class="fa fa-users"></i> <span class="nav-label">Liste des clients</span></a>
                </li>
                <li class="" id="rechercher">
                    <a href="<?= $this->url($this->section, "master", "rechercher") ?>"><i class="fa fa-search"></i> <span class="nav-label">Rechercher</span></a>
                </li>
                <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>


                <?php if ($employe->isAutoriser("ventes")) { ?>
                    <li class="" id="commandes">
                        <a href="<?= $this->url($this->section, "ventes", "commandes") ?>"><i class="fa fa-handshake-o"></i> <span class="nav-label">Commandes de clients</span> <?php if (count($groupes__) > 0) { ?> <span class="label label-warning float-right"><?= count($groupes__) ?></span> <?php } ?></a>
                    </li>

                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>

                    <li class="" id="miseenboutique">
                        <a href="<?= $this->url($this->section, "production", "miseenboutique") ?>"><i class="fa fa-reply"></i> <span class="nav-label">Mise en boutique</span></a>
                    </li>
                    <li class="" id="fournisseurs">
                        <a href="<?= $this->url($this->section, "production", "fournisseurs") ?>"><i class="fa fa-address-book-o"></i> <span class="nav-label">Liste des Fournisseurs</span></a>
                    </li>
                    <li class="groupe">
                        <a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Approvisionnements</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li id="approressource"><a href="<?= $this->url($this->section, "production", "approressource", 7) ?>">Appro de ressources</a></li>
                            <li id="approemballage"><a href="<?= $this->url($this->section, "production", "approemballage", 7) ?>">Appro d'emballage</a></li>
                            <li id="approetiquette"><a href="<?= $this->url($this->section, "production", "approetiquette", 7) ?>">Appro d'etiquette</a></li>
                        </ul>
                    </li>
                    <li class="" id="ressources">
                        <a href="<?= $this->url($this->section, "production", "ressources", "$datea@$dateb") ?>"><i class="fa fa-cubes"></i> <span class="nav-label">Les stocks</span></a>
                    </li>
                <?php } ?>

                <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>

                <li class="" id="rapportjour">
                    <a href="<?= $this->url($this->section, "rapports", "rapportjour") ?>"><i class="fa fa-calendar"></i> <span class="nav-label">Rapport du Jour</span></a>
                </li>
                <li class="" id="rapportproduction">
                    <a href="<?= $this->url($this->section, "rapports", "rapportproduction", "$datea@$dateb") ?>"><i class="fa fa-file-text-o"></i> <span class="nav-label">Rapport de production</span></a>
                </li>
                <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>
                

                <?php if ($employe->isAutoriser("caisse")) { ?>
                    <li class="" id="caisse">
                        <a href="<?= $this->url($this->section, "caisse", "caisse") ?>"><i class="fa fa-money"></i> <span class="nav-label">La caisse</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>

                <?php } ?>

            </ul>

        </ul>

    </div>
</nav>

<style type="text/css">
    li.dropdown-divider{
     !important;
 }
</style>