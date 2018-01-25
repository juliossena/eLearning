<?php

$requiresCTA[] = 'app/controller/view/CTela.php';
$requiresCTA[] = 'app/view/administrators/VAdministrators.php';

for ($i = 0 ; $i < count($requiresCTA) ; $i ++) {
    while (!file_exists($requiresCTA[$i])) {
        $requiresCTA[$i] = '../' . $requiresCTA[$i];
    }
    require_once $requiresCTA[$i];
}

class CTelaAdministrator extends CTela{
    private $user;
    private $screen;
    
    public function __construct(Users $user) {
        $this->user = $user;
    }
    
    public function getScreen() {
        $this->screen = new VAdministrators($this->user);
        if (isset($_REQUEST['subSite'])) {
            $subSite = $_REQUEST['subSite'];
            $this->setRoute($subSite);
        } else {
            
            $this->screen->setViewAllAdministrator();
        }
       
        return $this->screen;
    }
    
    public function setRoute($subSite) {
        switch ($subSite) {
            case Rotas::$DELETE_ADMINISTRATOR:
                if ($this->user->possuiPermissao(Rotas::$COD_DELETE_ADMINISTRATOR)){
                    $emailUser = $_REQUEST['emailUser'];
                    $user = new Users();
                    $user->setEmail($emailUser);
                    
                    $userDAO = new UsersDAO();
                    
                    if ($userDAO->drop($user)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                
                break;
            case Rotas::$EDIT_ADMINISTRATOR:
                if ($this->user->possuiPermissao(Rotas::$COD_EDIT_ADMINISTRATOR)) {
                    $emailUser = $_REQUEST['emailUser'];
                    $passUser = $_REQUEST['passUser'];
                    $nameUser = $_REQUEST['nameUser'];
                    $dateBirth = DateTime::createFromFormat('d/m/Y', $_REQUEST['dateBirth']);
                    $city = $_REQUEST['city'];
                    $country = $_REQUEST['country'];
                    
                    $user = new Users();
                    $user->setEmail($emailUser);
                    
                    $userDAO = new UsersDAO();
                    $filterUser = new FilterUsers($user);
                    $filterUser->setWhereAdm();
                    
                    $users = $userDAO->getObjects($filterUser);
                    
                    $newUser = $users->offsetGet(0);
                    
                    if ($newUser instanceof Users) {
                        $newUser->setName($nameUser);
                        $newUser->setDateBirth($dateBirth);
                        $newUser->setCity($city);
                        $newUser->setCountry($country);
                        if (strlen($passUser) == 128) {
                            $newUser->setPassword($passUser);
                        } else {
                            $newUser->setPassword(hash('sha512', $passUser));
                        }
                        
                    }
                    
                    if ($userDAO->update($newUser)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$NEW_ADMINISTRATOR:
                
                if ($this->user->possuiPermissao(Rotas::$COD_NEW_ADMINISTRATOR)){
                    $this->screen->setNewAdministrator();
                }
                
                break;
            case Rotas::$VIEW_EDIT_ADMINISTRATOR:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_EDIT_ADMINISTRATOR)) {
                    $user = new Users();
                    $user->setEmail($_REQUEST['emailUser']);
                    
                    $userDAO = new UsersDAO();
                    $filterUser = new FilterUsers($user);
                    $filterUser->setWhereAdm();
                    
                    $users = $userDAO->getObjects($filterUser);
                    
                    $this->screen->setEditAdministrator($users->offsetGet(0));
                }
                break;
            case Rotas::$VIEW_ADMINISTRATOR:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_ADMINISTRATOR)) {
                    $user = new Users();
                    $user->setEmail($_REQUEST['emailUser']);
                    
                    $userDAO = new UsersDAO();
                    $filterUser = new FilterUsers($user);
                    $filterUser->setWhereAdm();
                    
                    $users = $userDAO->getObjects($filterUser);
                    
                    $this->screen->setViewAdministrator($users->offsetGet(0));
                }
                break;
            case Rotas::$CREATE_NEW_ADMINISTRATOR:
                if ($this->user->possuiPermissao(Rotas::$COD_CREATE_NEW_ADMINISTRATOR)) {
                    $emailUser = $_REQUEST['emailUser'];
                    $nameUser = $_REQUEST['nameUser'];
                    $passUser = hash('sha512', $_REQUEST['passUser']);
                    $dateBirth = DateTime::createFromFormat('d/m/Y', $_REQUEST['dateBirth']);
                    $city = $_REQUEST['city'];
                    $country = $_REQUEST['country'];
                    
                    $user = new Users();
                    $user->setEmail($emailUser);
                    $user->setName($nameUser);
                    $user->setPassword($passUser);
                    $user->setDateBirth($dateBirth);
                    $user->setCity($city);
                    $user->setCountry($country);
                    $user->setType(1);
                    
                    $user->setPermissionsAdministrator();
                    
                    $userDAO = new UsersDAO();
                    
                    if ($userDAO->insertObjet($user)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                
                break;
            default:
                break;
        }
    }
    
}