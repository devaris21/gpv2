<?php 
namespace Native;
use Native\SHAMMAN;
use Home\ROLE;
use Home\EMPLOYE;
use Home\ENTREPOT;
use Home\BOUTIQUE;
use Home\PRODUCTION;
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
    public $section = "master";
    public $module = "start";
    public $page = "select";
    public $id ;


    private $token;


    const SECTION_SIMPLE = ["main"];
    const SECTION_ADMIN = ["manager", "master", "boutique", "entrepot", "config"];
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
                $this->module = "main";
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
        if (in_array($this->section, static::SECTION_ADMIN)) {
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

                                            $datas = BOUTIQUE::findBy(["id ="=>$employe->boutique_id]);
                                            if (count($datas) == 1) {
                                                $boutique = $datas[0];
                                                session("boutique_connecte_id", $boutique->id);
                                            }

                                            $datas = ENTREPOT::findBy(["id ="=>$employe->entrepot_id]);
                                            if (count($datas) == 1) {
                                                $entrepot = $datas[0];
                                                session("entrepot_connecte_id", $entrepot->id);
                                            }

                                            if ($employe->boutique_id != null) {
                                                $boutique = $employe->boutique;
                                            }
                                            if ($employe->entrepot_id != null) {
                                                $entrepot = $employe->entrepot;
                                            }

                                        }else{
                                            $this->new_root("main", "home", "erreur500");
                                            $this->render();
                                            return false;
                                        }
                                    }else{
                                        $this->new_root("main", "home", "erreur500");
                                        $this->render();
                                        return false;
                                    }
                                }
                            }else{
                                $this->new_root("main", "home", "erreur500");
                                $this->render();
                                return false;
                            }
                        }else{
                            $this->new_root("main", "access", "login");
                            $this->render();
                            return false;
                        }

                }else{
                    $this->new_root("main", "home", "expired");
                    $this->render();
                    return false; 
                }
            }else{
                $this->new_root("main", "access", "login");
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
            $path = __DIR__."/../../../webapp/main/modules/home/erreur404/index.php";
            $require = __DIR__."/../../../webapp/main/modules/home/erreur404/require.php";
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