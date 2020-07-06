<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase gras">Zone de recherche / archivage</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        Rechercher vos prospections, ventes directes, commandes, livraisons, approvisionnements, factures etc.....
                    </li>
                </ol>
            </div>
            <div class="col-sm-3">
                <br>
                <form id="rechercher" method="POST">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label>Zone de recherche</label>
                                <input type="text" placeholder="Que recherchez-vous ?" class="form-control" name="value" >
                            </div>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary dim"><i class="fa fa-search"></i></button>
                        </div>
                    </div>               
                </form>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">
                <div class="box">
                    <!-- rempli en ajax -->
                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>


    </div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>


</body>

</html>
