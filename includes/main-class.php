<?php

//include alle funtions
require_once("functions.php");

class Authenticate {

   var $db;
   var $naam;
   var $email;
   var $wachtwoord;

   function __construct($db) {
       $this->db = $db;
       return true;
   }

   function login($loginEmail, $loginPassword) {

       $encryptedPassword = $this->encryptIt($loginPassword);

       $this->db->where("email", $loginEmail);
       $this->db->where("wachtwoord", $encryptedPassword);

       if($this->db->has("users")) {

           $gebruiker = $this->db->getOne('users');

           $this->naam = $gebruiker['naam'];
           $this->email = $loginEmail;
           $this->wachtwoord = $encryptedPassword;

           setcookie("email", $loginEmail, time()+3600, '/');  /* expire in 1 hour */
           setcookie("hashedPass", $encryptedPassword, time()+3600, '/');  /* expire in 1 hour */

           return true;
       } else {
           return false;
       }
   }

   function isUserLoggedIn() {

       $loginEmail = $_COOKIE["email"];
       $encryptedPassword = $_COOKIE["hashedPass"];

       $this->db->where("email", $loginEmail);
       $this->db->where("wachtwoord", $encryptedPassword);

       if($this->db->has("users")) {

           $gebruiker = $this->db->getOne('users');

           $this->naam = $gebruiker['naam'];
           $this->email = $loginEmail;
           $this->wachtwoord = $encryptedPassword;

           setcookie("email", $loginEmail, time()+3600, '/');
           setcookie("hashedPass", $encryptedPassword, time()+3600, '/');

           return true;
       } else {
           return false;
       }
   }

   function encryptIt( $q ) {
        $cryptKey  = 'f82739fbubf3wp9fh3f2389';
        $qEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        return( $qEncoded );
   }

   function decryptIt( $q ) {
        $cryptKey  = 'f82739fbubf3wp9fh3f2389';
        $qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
        return( $qDecoded );
   }

   public static function checkAuth($db) {

        $authenticate = new Authenticate($db);

        if(!empty($_POST['loginEmail']) && !empty($_POST['loginPassword'])) {

            //eerst de login gegevens schoon maken
            $loginName = filter_var($_POST['loginEmail'], FILTER_VALIDATE_EMAIL);
            $loginPassword = filter_var($_POST['loginPassword'], FILTER_SANITIZE_STRING);

            try {
                $login = $authenticate->login($loginName, $loginPassword);
            } catch (Exception $e) {
                die("Er ging iets fout: " . $e->getMessage());
            }

            if($login !== true) {
                header("Location: " . $GLOBALS['website_root'] . "/cms/login/?p=f");
                die("Uitgelogd! " . $login);
            }else {
                return true;
            }

        }elseif(!empty($_GET['u']) && !empty($_GET['p'])) {

            //eerst de login gegevens schoon maken
            $loginName = filter_var($_GET['u'], FILTER_VALIDATE_EMAIL);
            $loginPassword = filter_var($_GET['p'], FILTER_SANITIZE_STRING);

            try {
                $login = $authenticate->login($loginName, decryptIt($loginPassword));
            } catch (Exception $e) {
                die("Er ging iets fout: " . $e->getMessage());
            }

            if($login !== true) {
                header("Location: " . $GLOBALS['website_root'] . "/cms/login/?p=f");
                die("Uitgelogd! " . $login);
            }else {
                return true;
            }

        } else {
            if(isset($_COOKIE["email"]) && isset($_COOKIE["hashedPass"])) {

                try {
                    $isUserLoggedIn = $authenticate->isUserLoggedIn();
                } catch (Exception $e) {
                    die("Er ging iets fout: " . $e->getMessage());
                }

                if($isUserLoggedIn !== true) {
                    header("Location: " . $GLOBALS['website_root'] . "/cms/login/");
                    die("Uitgelogd!");
                }else {
                    return true;
                }

            }else {

                header("Location: " . $GLOBALS['website_root'] . "/cms/login/");
                die("Uitgelogd!");
            }
        }
   }

}

class Settings {

    var $database;

    var $websiteNaam;
    var $websiteEmail;
    var $websiteCSS;

    public function __construct($db) {

        if (!$db) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL . "<br>";
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        $this->database = $db;

        try {

            $settings = $db->get('instellingen');

            foreach($settings as $key => $value) {

                if(in_array('titel', $value)) {
                    $this->websiteNaam = $value["Value"];
                }elseif(in_array('email', $value)) {
                    $this->websiteEmail = $value["Value"];
                }elseif(in_array('css', $value)) {
                    $this->websiteCSS = $value["Value"];
                }
            }

        }catch(Exception $e) {
            die("Er ging wat fout: " . $e->getMessage());
        }

        return true;
    }
}

class Pagina {

    var $database;

    var $pageId;

    var $pageTitel;
    var $pageUrl;
    var $pageOmschrijving;
    var $pageZoektermen;
    var $pageCustomCSS;

    var $htmlBlocks;

    public function __construct($db, $pageId = 0) {

        if (!$db) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL . "<br>";
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        $this->database = $db;

        try {
            $db->where('id', $pageId);
            $rowPage = $db->get('pages');
        }catch(Exception $e) {
            die("Er ging wat fout: " . $e->getMessage());
        }

        //Initialiseer waardes
        $this->pageId = $rowPage[0]['id'];
        $this->pageTitel = $rowPage[0]['titel'];
        $this->pageUrl = $rowPage[0]['url'];
        $this->pageOmschrijving = $rowPage[0]['omschrijving'];
        $this->pageZoektermen = $rowPage[0]['zoektermen'];
        $this->pageCustomCSS = $rowPage[0]['customCSS'];

        $paginaHTML = [];
        $sectionCount = 5;

        //Loop door alle attributen om te kijken hoeveel blokken gevuld zijn
        while($sectionCount < 23) {
            if(!empty($rowPage[0]["section" . $sectionCount])) {
                $paginaHTML[$sectionCount - 4] = $rowPage[0]["section" . $sectionCount];
            }else {
                break;
            }
            $sectionCount++;
        }

        $this->htmlBlocks = $paginaHTML;

        return true;
    }

    public function getTitel() {
        return $this->pageTitel;
    }
    public function getUrl() {
        return $this->pageUrl;
    }
    public function getOmschrijving() {
        return $this->pageOmschrijving;
    }
    public function getZoektermen() {
        return $this->pageZoektermen;
    }
    public function getCustomCSS() {
        return $this->pageCustomCSS;
    }

    public static function getNewPageUrl($db, $newPageUrl, $count = 1, $currentPageId = null) {
        try {

            if($count !== 1) {
                $newPageUrl = $newPageUrl . "-" . $count;
            }

            // Hier halen we een html snippet op uit de database
            $db->where('url', $newPageUrl);
            $page = $db->getOne ('pages');

            if($db->count > 0) {
                if($currentPageId === $page['id']) {
                    return $newPageUrl;
                }else {
                    $count++;
                    return Pagina::getNewPageUrl($db, $newPageUrl, $count);
                }
            }else {
                return $newPageUrl;
            }

        }catch(Exception $e) {
            die("{error}: " . $e->getMessage());
        }
    }

}

class Menu {

    var $menuName;

    var $allItems;
    var $menuOrder;

    var $menuHTML;

    var $database;

    public function __construct($db, $orderId, $currentPageId = 0, $cms = false) {

        if(!empty($_GET['p'])) {
            $pageId = $_GET['p'];
        }else {
            $pageId = 1;
        }

        if($cms) {
            $cmsUrl = str_replace('/', '', $GLOBALS['website_root']) . "/cms/";
        }else {
            $cmsUrl = str_replace('/', '', $GLOBALS['website_root']) . "/";
        }

        $this->database = $db;

        // eerst halen we alle menu items op uit de database
        $resultMenu = $db->get('menuItems');

        // dan halen we de gekoze menu volgorde op uit de database
        $db->where('id', $orderId);
        $resultMenuOrder = $db->get('menuOrder');

        // hier slaan we ze als array's op in de globale variabelen van deze class
        $allItems = [];
        foreach($resultMenu as $key => $menuItem) {
            $allItems[$menuItem['id']]['title'] = $menuItem['titel'];
            $allItems[$menuItem['id']]['pageId'] = $menuItem['pageId'];
        }

        $this->allItems = $allItems;
        $this->menuOrder = json_decode($resultMenuOrder[0]['orderJSON']);

        // laad menu in als html
        $htmlMenu = $this->loadMenuAsHTML($this->menuOrder, $currentPageId, $cmsUrl);

        $this->menuHTML = $htmlMenu;
        if($htmlMenu === false) {
           return false;
        }

        // laad menunaam in
        $this->menuName = $resultMenuOrder[0]['menuName'];

        return true;
    }

    private function loadMenuAsHTML($menuOrder, $activePage = 0, $cmsUrl) {

        $mainMenu = "";

        if(empty($menuOrder)) {
            return false;
        }

        foreach($menuOrder as $key => $menu) {

            $p = new Pagina($this->database, $this->allItems[$menu->id]['pageId']);

            if($activePage == $this->allItems[$menu->id]['pageId']) {
                if (isset($menu->children)) {
                    $liClass = "class='dropdown active'";
                    $aClass = "class='dropdown-toggle'";
                }else {
                    $liClass = "class='active'";
                    $aClass = "";
                }
            }else {
                if (isset($menu->children)) {
                    $liClass = "class='dropdown'";
                    $aClass = "class='dropdown-toggle'";
                }else {
                    $liClass = "";
                    $aClass = "";
                }
            }

            $mainMenu .= "<li $liClass><a href=\"/" . $cmsUrl . $p->getUrl() . "\" $aClass>" . $this->allItems[$menu->id]['title'] . "</a>";

            if (isset($menu->children)) {
                $mainMenu .= "<ul class=\"dropdown-menu sub-menu\">";
                $mainMenu .= $this->loadMenuAsHTML($menu->children, $activePage, $cmsUrl);
                $mainMenu .= "</ul>";
            }

            $mainMenu .= "</li>";

        }


       return $mainMenu;
    }

    private function loadMenuForNestable($menuOrder) {

        $mainMenu = "";

        if(empty($menuOrder)) {
            return false;
        }

        foreach($menuOrder as $key => $menu) {

            $mainMenu .= "<li class=\"dd-item dd3-item\" data-id=\"" . $menu->id . "\"><div class=\"dd-handle dd3-handle\"><div class=\"dd3-content\">" . $this->allItems[$menu->id]['title'] . "</div></div>";

            if (isset($menu->children)) {
                $mainMenu .= "<ol class=\"dd-list\">";
                $mainMenu .= $this->loadMenuForNestable($menu->children);
                $mainMenu .= "</ol>";
            }

            $mainMenu .= "</li>";

        }

       return $mainMenu;
    }

    private function loadMenuForNestableAllAvailable($menuOrder, $allItems) {

        foreach($menuOrder as $key => $menu) {

            unset($allItems[$menu->id]);

            if (isset($menu->children)) {
                $allItems = $this->loadMenuForNestableAllAvailable($menu->children, $allItems);
            }

        }

       return $allItems;

    }

    function getMenuName() {
        return $this->menuName;
    }

    function getAllItems() {
        return $this->allItems;
    }

    function getMenu() {
        return $this->menuHTML;
    }

    function getMenuForNestable() {
        return $this->loadMenuForNestable($this->menuOrder);
    }

    function getMenuForNestableAllAvailable() {

        $items = $this->loadMenuForNestableAllAvailable($this->menuOrder, $this->allItems);

        $mainMenu = "";

        foreach($items as $key => $menu) {

            $mainMenu .= "<li class=\"dd-item dd3-item\" data-id=\"" . $key . "\"><div class=\"dd-handle dd3-handle\"><div class=\"dd3-content\">" . $menu['title'] . "</div></div></li>";

        }

        return $mainMenu;
    }

    public static function getPageMenuTitle($db, $pageId) {

        try{
            // hier halen we het menu item op uit de database
            $db->where('pageId', $pageId);
            $menuTitle = $db->getOne('menuItems');
        }catch(Exception $e) {
            $response = array(
                "status"        => "error",
                "errorMessage"  => $e->getMessage()
            );
            die(json_encode($response));
        }

        return $menuTitle['titel'];
    }

}
