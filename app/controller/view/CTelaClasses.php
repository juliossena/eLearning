<?php

$requiresCTC[] = 'app/controller/view/CTela.php';
$requiresCTC[] = 'app/view/classes/VClasses.php';
$requiresCTC[] = 'app/models/classes/Classes.php';
$requiresCTC[] = 'app/dao/FilterClasses.php';
$requiresCTC[] = 'app/dao/ClassesDAO.php';

for ($i = 0 ; $i < count($requiresCTC) ; $i ++) {
    while (!file_exists($requiresCTC[$i])) {
        $requiresCTC[$i] = '../' . $requiresCTC[$i];
    }
    require_once $requiresCTC[$i];
}

class CTelaClasses extends CTela{
    private $user;
    private $screen;
    
    public function __construct(Users $user) {
        $this->user = $user;
    }
    
    public function getScreen() {
        $this->screen = new VClasses($this->user);
        if (isset($_REQUEST['subSite'])) {
            $subSite = $_REQUEST['subSite'];
            $this->setRoute($subSite);
        } else {
            $class = new Classes();
            $filter = new FilterClasses($class);
            $classesDAO = new ClassesDAO();
            
            $classes = $classesDAO->getObjects($filter);
            $this->screen->setViewAllClasses($classes);
        }
       
        return $this->screen;
    }
    
    public function setRoute($subSite) {
        switch ($subSite) {
            case Rotas::$CREATE_NEW_CLASS:
                if ($this->user->possuiPermissao(Rotas::$COD_CREATE_NEW_CLASS)) {
                    $nameClass = $_REQUEST['nameClass'];
                    $emailStudents = explode(", ", $_REQUEST['students']);
                    $description = $_REQUEST['description'];
                    unset($emailStudents[count($emailStudents) - 1]);
                    
                    $students = new ArrayObject();
                    for ($i = 0 ; $i < count($emailStudents) ; $i++) {
                        $user = new Users();
                        $user->setEmail($emailStudents[$i]);
                        $students->append($user);
                    }
                    
                    $classDAO = new ClassesDAO();
                    
                    $class = new Classes();
                    $class->setName($nameClass);
                    $class->setDescription($description);
                    $class->setStudents($students);
                    $class->setId($classDAO->getNextAutoIncrement());
                    
                    if ($classDAO->insert($class)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$DELETE_CLASS:
                if ($this->user->possuiPermissao(Rotas::$COD_DELETE_CLASS)) {
                    $class = new Classes();
                    $class->setId($_REQUEST['idClass']);
                    
                    $classDAO = new ClassesDAO();
                    if ($classDAO->drop($class)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$EDIT_CLASS:
                if ($this->user->possuiPermissao(Rotas::$COD_EDIT_CLASS)) {
                    $idClass = $_REQUEST['idClass'];
                    $nameClass = $_REQUEST['nameClass'];
                    $emailStudents = explode(", ", $_REQUEST['students']);
                    $description = $_REQUEST['description'];
                    unset($emailStudents[count($emailStudents) - 1]);
                    
                    $students = new ArrayObject();
                    for ($i = 0 ; $i < count($emailStudents) ; $i++) {
                        $user = new Users();
                        $user->setEmail($emailStudents[$i]);
                        $students->append($user);
                    }
                    
                    $classDAO = new ClassesDAO();
                    
                    $class = new Classes();
                    $class->setName($nameClass);
                    $class->setDescription($description);
                    $class->setStudents($students);
                    $class->setId($idClass);
                    
                    if ($classDAO->update($class)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$NEW_CLASS:
                if ($this->user->possuiPermissao(Rotas::$COD_NEW_CLASS)) {
                    $user = new Users();
                    $user->setType(3);
                    
                    $filterUser = new FilterUsers($user);
                    $userDAO = new UsersDAO();
                    
                    $this->screen->setNewClasses($userDAO->getObjects($filterUser));
                }
                break;
            case Rotas::$VIEW_CLASS:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_CLASS)) {
                    $idClass = $_REQUEST['idClass'];
                    
                    $class = new Classes();
                    $class->setId($idClass);
                    
                    $filter = new FilterClasses($class);
                    
                    $classDAO = new ClassesDAO();
                    $classes = $classDAO->getObjects($filter);
                    
                    $user = new Users();
                    $user->setType(3);
                    
                    $filterUser = new FilterUsers($user);
                    $userDAO = new UsersDAO();
                    
                    $this->screen->setViewClasses($classes->offsetGet(0), $userDAO->getObjects($filterUser));
                }
                break;
            case Rotas::$VIEW_EDIT_CLASS:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_EDIT_CLASS)) {
                    $idClass = $_REQUEST['idClass'];
                    
                    $class = new Classes();
                    $class->setId($idClass);
                    
                    $filter = new FilterClasses($class);
                    
                    $classDAO = new ClassesDAO();
                    $classes = $classDAO->getObjects($filter);
                    
                    $user = new Users();
                    $user->setType(3);
                    
                    $filterUser = new FilterUsers($user);
                    $userDAO = new UsersDAO();
                    
                    $this->screen->setViewEditClasses($classes->offsetGet(0), $userDAO->getObjects($filterUser));
                    
                }
                break;
            default:
                break;
        }
    }
    
}