<?php 
namespace Native;
use Native\SHAMMAN;
use Home\ROLE;
use Home\EMPLOYE;
use Home\ENTREPOT;
use Home\BOUTIQUE;
use Home\PRODUCTIONJOUR;
use Home\EXERCICECOMPTABLE;
use Home\PARAMS;
use Home\MYCOMPTE;
/**
 * 
 */
class ROOTER extends PATH
{

    public $url;
    private $language = "fr";
    public $section = "devaris21";
    public $module = "start";
    public $page = "select";
    public $id ;


    private $token;


    const SECTION_SIMPLE = ["devaris21"];
    const SECTION_ADMIN = ["master", "manager", "boutique", "entrepot", "configuration"];
    const SECTION_STOCKAGE = ["images", "documents"];


    public function __construct(){
        if (isset($_GET["query"])) {
            $this->url = $_GET["query"];
        }
        $this->createRoot();
    }



    private function createRoot(){
        if ($this->url != "") {
            $tab = explode("/", strtolower($this->url));
            $this->section = $tab[0];
            if (in_array($this->section, static::SECTION_ADMIN)) {
                $this->module = "access";
                $this->page = "login";
            }
            if (isset($tab[1]) && $tab[1] != "") {
                $this->module = $tab[1];
            }

            if (isset($tab[2]) && $tab[2] != "") {
                $tab = explode("|", strtolower($tab[2]));
                $this->page = $tab[0];
                if (isset($tab[1])) {
                    $this->id = $_GET["id"] = $tab[1];
                }
            }
        }
    }




    public function render(){
        $data = new RESPONSE;
        $data->status = true;
        $this->is_admin = in_array($this->section, static::SECTION_ADMIN) ;
        if ($this->is_admin && $this->module != "access") {
            $data = PARAMS::checkTimeout($this->section);
            if ($data->status == true) {
                $params = PARAMS::findLastId();
                $mycompte = MYCOMPTE::findLastId();


                if ($mycompte->expired >= dateAjoute()) {
                    $exercicecomptable = EXERCICECOMPTABLE::encours();

                    $date1 = dateAjoute(-3);
                    $date2 = dateAjoute(1);
                    if (getSession("date1") != null) {
                        $date1 = getSession("date1");
                    }
                    if (getSession("date2") != null) {
                        $date2 = getSession("date2");
                    }



                    if ($this->section == "master" || $this->section == "configuration") {
                        $datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
                        if (count($datas) >0) {
                            $employe = $datas[0];
                            if ($employe->is_allowed()) {
                                $tableauDeRoles = [];
                                foreach ($employe->fourni("role_employe") as $key => $value) {
                                    $tableauDeRoles[] = $value->role_id;
                                };
                                if (!in_array($this->module, ROLE::MODULEEXCEPT)) {
                                    $datas = ROLE::findBy(["name ="=>$this->module]);
                                    if (count($datas) == 1) {
                                        $role = $datas[0];
                                        if (in_array($role->id, $tableauDeRoles)) {
                                            $employe->actualise();
                                            if ($employe->boutique_id != null) {
                                                $maBoutique = $employe->boutique;
                                            }
                                            if ($employe->entrepot_id != null) {
                                                $monEntrepot = $employe->entrepot;
                                            }

                                        }else{
                                            $this->new_root("devaris21", "home", "erreur500");
                                            $this->render();
                                            return false;
                                        }
                                    }else{
                                        $this->new_root("devaris21", "home", "erreur500");
                                        $this->render();
                                        return false;
                                    }
                                }
                            }else{
                                $this->new_root("devaris21", "home", "erreur500");
                                $this->render();
                                return false;
                            }
                        }else{
                            $this->new_root($this->section, "access", "login");
                            $this->render();
                            return false;
                        }
                    }



                    if ($this->section == "boutique") {
                        $datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
                        if (count($datas) >0) {
                            $employe = $datas[0];
                            if ($employe->is_allowed()) {
                                $employe->actualise();

                                $datas = BOUTIQUE::findBy(["id ="=>$employe->boutique_id]);
                                if (count($datas) == 1) {
                                    $boutique = $datas[0];
                                    session("boutique_connecte_id", $boutique->id);
                                }else{
                                    $this->new_root("devaris21", "home", "erreur500");
                                    $this->render();
                                    return false;
                                }
                            }else{
                                $this->new_root("devaris21", "home", "erreur500");
                                $this->render();
                                return false;
                            }
                        }else{
                            $this->new_root($this->section, "access", "login");
                            $this->render();
                            return false;
                        }
                    }


                    if ($this->section == "entrepot") {
                        $datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
                        if (count($datas) >0) {
                            $employe = $datas[0];
                            if ($employe->is_allowed()) {
                                $employe->actualise();
                                $datas = ENTREPOT::findBy(["id ="=>$employe->entrepot_id]);
                                if (count($datas) == 1) {
                                    $entrepot = $datas[0];
                                    session("entrepot_connecte_id", $entrepot->id);
                                }else{
                                    $this->new_root("devaris21", "home", "erreur500");
                                    $this->render();
                                    return false;
                                }

                            }else{
                                $this->new_root("devaris21", "home", "erreur500");
                                $this->render();
                                return false;
                            }
                        }else{
                            $this->new_root($this->section, "access", "login");
                            $this->render();
                            return false;
                        }
                    }

                }else{
                    $this->new_root("devaris21", "home", "expired");
                    $this->render();
                    return false; 
                }
            }else{
                $this->new_root($this->section, "access", "login");
                $this->render();
                return false;
            }
        }


        $path = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/index.php";
        $require = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/require.php";

        if (file_exists($path)) {
            $path = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/index.php";
            $require = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/require.php";

            require realpath($require);
            require realpath($path);

            $token = hasher(bin2hex(random_bytes(32)));
            session("token", $token);
            session("verif_token", $token);

        }else{
            $path = __DIR__."/../../../webapp/devaris21/modules/home/erreur404/index.php";
            $require = __DIR__."/../../../webapp/devaris21/modules/home/erreur404/require.php";
            require realpath($require);
            require realpath($path);
        }
    }




    //redefinir la route
    private function new_root($section, $module, $page="", $id=""){
        $this->section = $section;
        $this->module = $module;
        $this->page   = $page;
        $this->id     = $id;
    }




    public function url($section, $module, $page="", $id=""){
        return $this->url = "../../$section/$module/$page|$id";
    }

    public function setUrl(String $url){
        $this->url = $url;
        return $this;
    }

    public function getUrl(){
        return $this->url;
    }


    public function set_module($module)
    {
        $this->module = $module;
        return $this;
    }

    public function getModule(){
        return $this->module;
    }

    public function getSection(){
        return $this->section;
    }

    public function getPage(){
        return $this->page;
    }

    public function getId()
    {
        return $this->id;
    }



}
?>