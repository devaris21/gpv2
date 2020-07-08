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
                                <span class="text-muted text-xs block"><b class="caret"></b></span>
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
            $prospections__ = Home\PROSPECTION::encours();
            $ventecaves__ = Home\PROSPECTION::findBy(["etat_id ="=>Home\ETAT::ENCOURS, "typeprospection_id ="=>Home\TYPEPROSPECTION::VENTECAVE]);
            $livraisons__ = Home\PROSPECTION::findBy(["etat_id ="=>Home\ETAT::ENCOURS, "typeprospection_id ="=>Home\TYPEPROSPECTION::LIVRAISON]);
            $approvisionnements__ = Home\APPROVISIONNEMENT::encours();
            $datas1__ = array_merge(Home\PANNE::encours(), Home\DEMANDEENTRETIEN::encours(), Home\ENTRETIENVEHICULE::encours(), Home\ENTRETIENMACHINE::encours());

            ?>
            <ul class="nav metismenu" id="side-menu">
                <li class="" id="dashboard">
                    <a href="<?= $this->url($this->section, "master", "dashboard") ?>"><i class="fa fa-tachometer"></i> <span class="nav-label">Tableau de bord</span></a>
                </li>
                <li class="" id="clients">
                    <a href="<?= $this->url($this->section, "master", "clients") ?>"><i class="fa fa-users"></i> <span class="nav-label">Liste des clients</span></a>
                </li>
                <li class="" id="commerciaux">
                    <a href="<?= $this->url($this->section, "master", "commerciaux") ?>"><i class="fa fa-bicycle"></i> <span class="nav-label">Liste des commerciaux</span></a>
                </li>
                <li class="" id="rechercher">
                    <a href="<?= $this->url($this->section, "master", "rechercher") ?>"><i class="fa fa-search"></i> <span class="nav-label">Rechercher</span></a>
                </li>
                <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>


                <?php if ($employe->isAutoriser("ventes")) { ?>
                    <li class="" id="ventedirecte">
                        <a href="<?= $this->url($this->section, "ventes", "ventedirecte") ?>"><i class="fa fa-arrow-right"></i> <span class="nav-label">Ventes directes</span> </a>
                    </li>
                    <li class="" id="prospections">
                        <a href="<?= $this->url($this->section, "ventes", "prospections") ?>"><i class="fa fa-archive"></i> <span class="nav-label">Les Prospections</span> <?php if (count($prospections__) > 0) { ?> <span class="label label-warning float-right"><?= count($prospections__) ?></span> <?php } ?></a>
                    </li>
                    <li class="" id="ventecave">
                        <a href="<?= $this->url($this->section, "ventes", "ventecave") ?>"><i class="fa fa-home"></i> <span class="nav-label">Ventes en cave</span> <?php if (count($ventecaves__) > 0) { ?> <span class="label label-warning float-right"><?= count($ventecaves__) ?></span> <?php } ?></a>
                    </li>
                    <li class="" id="commandes">
                        <a href="<?= $this->url($this->section, "ventes", "commandes") ?>"><i class="fa fa-handshake-o"></i> <span class="nav-label">Commandes de clients</span> <?php if (count($groupes__) > 0) { ?> <span class="label label-warning float-right"><?= count($groupes__) ?></span> <?php } ?></a>
                    </li>
                    <li class="" id="livraisons">
                        <a href="<?= $this->url($this->section, "ventes", "livraisons") ?>"><i class="fa fa-truck"></i> <span class="nav-label">Livraisons en cours</span> <?php if (count($livraisons__) > 0) { ?> <span class="label label-warning float-right"><?= count($livraisons__) ?></span> <?php } ?></a>
                    </li>


                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>

                    <li class="" id="boutiques">
                        <a href="<?= $this->url($this->section, "production", "boutiques", Home\BOUTIQUE::PRINCIPAL) ?>"><i class="fa fa-home"></i> <span class="nav-label">Les boutiques</span></a>
                    </li>
                    <li class="" id="entrepots">
                        <a href="<?= $this->url($this->section, "production", "entrepots") ?>"><i class="fa fa-home"></i> <span class="nav-label">Les Entrepôts</span></a>
                    </li>
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
                <li class="" id="rapportvente">
                    <a href="<?= $this->url($this->section, "rapports", "rapportvente", "$datea@$dateb") ?>"><i class="fa fa-file-text-o"></i> <span class="nav-label">Rapport de vente</span></a>
                </li>
                <li class="groupe">
                    <a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Etats récapitulatifs</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li id="etatclients"><a href="<?= $this->url($this->section, "rapports", "etatclients", "$datea@$dateb") ?>">... des clients</a></li>
                        <li id="etatproduction"><a href="<?= $this->url($this->section, "rapports", "etatproduction", "$datea@$dateb") ?>">... de production</a></li>
                        <li id="etatcomptes"><a href="<?= $this->url($this->section, "rapports", "etatcomptes", "$datea@$dateb") ?>">... des comptes</a></li>
                        <!--  <li id="etatpersonnel"><a href="<?= $this->url($this->section, "rapports", "etatpersonnel", "$datea@$dateb") ?>">... du personnel</a></li> -->
                    </ul>
                </li>

                <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>
                
<!-- 
                
                <li class="" id="machines">
                    <a href="<?= $this->url($this->section, "master", "machines") ?>"><i class="fa fa-steam"></i> <span class="nav-label">Véhicules et machines</span></a>
                </li>            
                <li class="" id="pannes">
                    <a href="<?= $this->url($this->section, "master", "pannes") ?>"><i class="fa fa-wrench"></i> <span class="nav-label">Pannes et entretien</span> <?php if (count($datas1__) > 0) { ?> <span class="label label-warning float-right"><?= count($datas1__) ?></span> <?php } ?></a>
                </li>
                <li class="dropdown-divider" style="background-color: #000"></li> -->


                <?php if ($employe->isAutoriser("caisse")) { ?>
                   <!--  <li class="" id="caisse">
                        <a href="<?= $this->url($this->section, "caisse", "caisse") ?>"><i class="fa fa-money"></i> <span class="nav-label">La caisse</span></a>
                    </li> -->
                    <li class="" id="tresorerie">
                        <a href="<?= $this->url($this->section, "caisse", "tresorerie", $exercicecomptable->id) ?>"><i class="fa fa-money"></i> <span class="nav-label">Trésorerie générale</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>

                <?php } ?>


                <?php if ($employe->isAutoriser("parametres")) { ?>
                    <li class="" id="configuration">
                        <a href="<?= $this->url($this->section, "parametres", "configuration") ?>"><i class="fa fa-gears"></i> <span class="nav-label">Configuration</span></a>
                    </li>
              <!--   <li class="" id="historiques">
                    <a href="<?= $this->url($this->section, "parametres", "historiques") ?>"><i class="fa fa-clock-o"></i> <span class="nav-label">Historiques</span></a>
                </li>
                <li class="" id="abonnement">
                    <a href="<?= $this->url($this->section, "parametres", "abonnement") ?>"><i class="fa fa-star"></i> <span class="nav-label">Abonnement</span> <span class="label label-danger float-right"></span></a>
                </li> -->
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