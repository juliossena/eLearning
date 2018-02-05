<?php

$requiresCTC[] = 'app/controller/view/CTela.php';
$requiresCTC[] = 'app/view/courses/VCourses.php';
$requiresCTC[] = 'app/dao/FilterCourses.php';
$requiresCTC[] = 'app/dao/CoursesDAO.php';
$requiresCTC[] = 'app/config/Commands.php';

for ($i = 0 ; $i < count($requiresCTC) ; $i ++) {
    while (!file_exists($requiresCTC[$i])) {
        $requiresCTC[$i] = '../' . $requiresCTC[$i];
    }
    require_once $requiresCTC[$i];
}

class CTelaCourse extends CTela{
    private $user;
    private $screen;
    
    public function __construct(Users $user) {
        $this->user = $user;
    }
    
    public function getScreen() {
        $this->screen = new VCourses($this->user);
        if (isset($_REQUEST['subSite'])) {
            $subSite = $_REQUEST['subSite'];
            $this->setRoute($subSite);
        } else {
            $course = new Courses();
            
            $filterCourse = new FilterCourses($course);
            $filterCourse->setOrder("ORDER BY Name");
            
            $courseDAO = new CoursesDAO();
            
            $this->screen->setViewAllCourses($courseDAO->getObjects($filterCourse));
        }
       
        return $this->screen;
    }
    
    public function setRoute($subSite) {
        switch ($subSite) {
            case Rotas::$CREATE_NEW_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_CREATE_NEW_COURSE)) {
                    $nameClass = $_REQUEST['nameClass'];
                    $instructors = $_REQUEST['instructors'];
                    $dateFinish = DateTime::createFromFormat('d/m/Y', $_REQUEST['dateFinish']);
                    $password = hash('sha512', $_REQUEST['password']); 
                    $certifiedPercentage = $_REQUEST['certifiedPercentage'];
                    $dateNew = DateTime::createFromFormat('d/m/Y', $_REQUEST['dateNew']);
                    $idClasses = explode(", ", $_REQUEST['selectActiveClass']);
                    unset($idClasses[count($idClasses) - 1]);
                    $emailStudents = explode(", ", $_REQUEST['selectActive']);
                    unset($emailStudents[count($emailStudents) - 1]);
                    $minimumTime = Commands::passMinutesForDateTime($_REQUEST['minimumTime']);
                    
                    $students = new ArrayObject();
                    for ($i = 0 ; $i < count($emailStudents) ; $i++) {
                        $user = new Users();
                        $user->setEmail($emailStudents[$i]);
                        $students->append($user);
                    }
                    
                    $classes = new ArrayObject();
                    for ($i = 0 ; $i < count($idClasses) ; $i++) {
                        $class = new Classes();
                        $class->setId($idClasses[$i]);
                        $classes->append($class);
                    }
                    
                    $courseDAO = new CoursesDAO();
                    
                    $instructor = new Users();
                    $instructor->setEmail($instructors);
                    
                    $course = new Courses();
                    $course->setCertifiedPercentage($certifiedPercentage);
                    $course->setClasses($classes);
                    $course->setDateFinish($dateFinish);
                    $course->setDateNew($dateNew);
                    $course->setId($courseDAO->getNextAutoIncrement());
                    $course->setInstructor($instructor);
                    $course->setMinimumTime($minimumTime);
                    $course->setName($nameClass);
                    $course->setPassword($password);
                    $course->setStudents($students);
                    
                    if ($courseDAO->insert($course)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$DELETE_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_DELETE_COURSE)) {
                    $idCourse = $_REQUEST['idCourse'];
                    $course = new Courses();
                    $course->setId($idCourse);
                    
                    $courseDAO = new CoursesDAO();
                    
                    if ($courseDAO->drop($course)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$EDIT_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_EDIT_COURSE)) {
                    $nameClass = $_REQUEST['nameClass'];
                    $instructors = $_REQUEST['instructors'];
                    $dateFinish = DateTime::createFromFormat('d/m/Y', $_REQUEST['dateFinish']);
                    $password = hash('sha512', $_REQUEST['password']);
                    $certifiedPercentage = $_REQUEST['certifiedPercentage'];
                    $dateNew = DateTime::createFromFormat('d/m/Y', $_REQUEST['dateNew']);
                    $idClasses = explode(", ", $_REQUEST['selectActiveClass']);
                    unset($idClasses[count($idClasses) - 1]);
                    $emailStudents = explode(", ", $_REQUEST['selectActive']);
                    unset($emailStudents[count($emailStudents) - 1]);
                    $minimumTime = Commands::passMinutesForDateTime($_REQUEST['minimumTime']);
                    
                    $students = new ArrayObject();
                    for ($i = 0 ; $i < count($emailStudents) ; $i++) {
                        $user = new Users();
                        $user->setEmail($emailStudents[$i]);
                        $students->append($user);
                    }
                    
                    $classes = new ArrayObject();
                    for ($i = 0 ; $i < count($idClasses) ; $i++) {
                        $class = new Classes();
                        $class->setId($idClasses[$i]);
                        $classes->append($class);
                    }
                    
                    $courseDAO = new CoursesDAO();
                    
                    $instructor = new Users();
                    $instructor->setEmail($instructors);
                    
                    $course = new Courses();
                    $course->setCertifiedPercentage($certifiedPercentage);
                    $course->setClasses($classes);
                    $course->setDateFinish($dateFinish);
                    $course->setDateNew($dateNew);
                    $course->setId($_REQUEST['idCourse']);
                    $course->setInstructor($instructor);
                    $course->setMinimumTime($minimumTime);
                    $course->setName($nameClass);
                    $course->setPassword($password);
                    $course->setStudents($students);
                    
                    if ($courseDAO->update($course)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$NEW_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_NEW_COURSE)) {
                    $instructors = new Users();
                    $instructors->setType(2);
                    
                    $filterInstructor = new FilterUsers($instructors);
                    
                    $students = new Users();
                    $students->setType(3);
                    
                    $filterStudents = new FilterUsers($students);
                    
                    $classes = new Classes();
                    
                    $filterClasses = new FilterClasses($classes);
                    
                    $classesDAO = new ClassesDAO();
                    $usersDAO = new UsersDAO();
                    
                    $this->screen->setNewCourse($usersDAO->getObjects($filterInstructor), $usersDAO->getObjects($filterStudents), $classesDAO->getObjects($filterClasses));
                }
                break;
            case Rotas::$VIEW_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_COURSE)) {
                    $idCourse = $_REQUEST['idCourse'];
                    
                    $course = new Courses();
                    $course->setId($idCourse);
                    
                    $filterCourse = new FilterCourses($course);
                    
                    $courseDAO = new CoursesDAO();
                    
                    $courses = $courseDAO->getObjects($filterCourse);
                    
                    $instructors = new Users();
                    $instructors->setType(2);
                    
                    $filterInstructor = new FilterUsers($instructors);
                    
                    $students = new Users();
                    $students->setType(3);
                    
                    $filterStudents = new FilterUsers($students);
                    
                    $classes = new Classes();
                    
                    $filterClasses = new FilterClasses($classes);
                    
                    $classesDAO = new ClassesDAO();
                    $usersDAO = new UsersDAO();
                    
                    
                    $this->screen->setViewCourse($courses->offsetGet(0), $usersDAO->getObjects($filterInstructor), $usersDAO->getObjects($filterStudents), $classesDAO->getObjects($filterClasses));
                }
                break;
            case Rotas::$VIEW_EDIT_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_EDIT_COURSE)) {
                    $idCourse = $_REQUEST['idCourse'];
                    
                    $course = new Courses();
                    $course->setId($idCourse);
                    
                    $filterCourse = new FilterCourses($course);
                    
                    $courseDAO = new CoursesDAO();
                    
                    $courses = $courseDAO->getObjects($filterCourse);
                    
                    $instructors = new Users();
                    $instructors->setType(2);
                    
                    $filterInstructor = new FilterUsers($instructors);
                    
                    $students = new Users();
                    $students->setType(3);
                    
                    $filterStudents = new FilterUsers($students);
                    
                    $classes = new Classes();
                    
                    $filterClasses = new FilterClasses($classes);
                    
                    $classesDAO = new ClassesDAO();
                    $usersDAO = new UsersDAO();
                    
                    
                    $this->screen->setViewEditCourse($courses->offsetGet(0), $usersDAO->getObjects($filterInstructor), $usersDAO->getObjects($filterStudents), $classesDAO->getObjects($filterClasses));
                }
                break;
            default:
                break;
        }
    }
    
}