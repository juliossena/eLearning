<?php

$requiresCTCI[] = 'app/controller/view/CTela.php';
$requiresCTCI[] = 'app/view/courses/VCourses.php';
$requiresCTCI[] = 'app/models/courses/Forum.php';
$requiresCTCI[] = 'app/models/courses/Answer.php';


for ($i = 0 ; $i < count($requiresCTCI) ; $i ++) {
    while (!file_exists($requiresCTCI[$i])) {
        $requiresCTCI[$i] = '../' . $requiresCTCI[$i];
    }
    require_once $requiresCTCI[$i];
}

class CTelaCourseInstructor extends CTela{
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
            
            $instructor = new Users();
            $instructor->setEmail($this->user->getEmail());
            
            $course->setInstructor($instructor);
            
            $courseDAO = new CoursesDAO();
            
            $filter = new FilterCourses($course);
            
            $this->screen->setViewAllCoursesInstructor($courseDAO->getCourses($filter));
        }
        return $this->screen;
    }
    
    public function setRoute($subSite) {
        switch ($subSite) {
            case Rotas::$VIEW_FILES_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_FILES_COURSE)) {
                    $idCourse = $_REQUEST['idCourse'];
                    $course = new Courses();
                    $course->setId($idCourse);
                    
                    $course->setInstructor($this->user);
                    
                    $courseDAO = new CoursesDAO();
                    $filter = new FilterCourses($course);
                    
                    $course = $courseDAO->getObjects($filter)->offsetGet(0);
                    
                    if ($course instanceof Courses) {
                        $this->screen->setViewFilesInstructor($course->getFiles(), $course);
                    }
                }
                break;
            case Rotas::$VIEW_NEWS_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_NEWS_COURSE)) {
                    $idCourse = $_REQUEST['idCourse'];
                    $course = new Courses();
                    $course->setId($idCourse);
                    
                    $course->setInstructor($this->user);
                    
                    $courseDAO = new CoursesDAO();
                    $filter = new FilterCourses($course);
                    $filter->setOrder("ORDER BY TimeChange DESC");
                    
                    $course = $courseDAO->getNews($filter)->offsetGet(0);
                    
                    if ($course instanceof Courses) {
                        $this->screen->setNewsCourse($course->getNews());
                    }
                }
                break;
            case Rotas::$OPEN_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_OPEN_COURSE)) {
                    $idCourse = $_REQUEST['idCourse'];
                    $course = new Courses();
                    $course->setId($idCourse);
                    
                    $course->setInstructor($this->user);
                    
                    $courseDAO = new CoursesDAO();
                    $filter = new FilterCourses($course);
                    
                    $course = $courseDAO->getObjects($filter)->offsetGet(0);
                    
                    if ($course instanceof Courses) {
                        $this->screen->setViewOpenCourseInstructor($course);
                    }
                }
                break;
            case Rotas::$DOWNLOAD_FILE_COURSE:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                
                $course->setInstructor($this->user);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $course = $courseDAO->getObjects($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    for ($i = 0 ; $i < $course->getFiles()->count() ; $i++) {
                        $file = $course->getFiles()->offsetGet($i);
                        if ($file instanceof Files) {
                            if ($file->getName() ==  str_replace("thumbnail/", "", $_REQUEST['idFile'])) {
                                if (count(explode("thumbnail/", $_REQUEST['idFile'])) == 1) {
                                    Commands::downloadArquivo('dados/' , $file->getLocation(), $file->getType());
                                } else {
                                    Commands::downloadArquivo('dados/' , $file->getThumbnail(), $file->getType());
                                }
                            }
                        }
                    }
                }
                break;
            case Rotas::$VIEW_FORUNS_COURSE:
                if ($this->user->possuiPermissao(Rotas::$COD_VIEW_FORUNS_COURSE)) {
                    $idCourse = $_REQUEST['idCourse'];
                    $course = new Courses();
                    $course->setId($idCourse);
                    
                    $course->setInstructor($this->user);
                    
                    $courseDAO = new CoursesDAO();
                    $filter = new FilterCourses($course);
                    $filter->setOrder("ORDER BY A.DateCreate DESC");
                    $course = $courseDAO->getForuns($filter)->offsetGet(0);
                    
                    if ($course instanceof Courses) {
                        $this->screen->setViewForuns($course);
                    }
                }
                break;
            case Rotas::$VIEW_CREATE_FORUM:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                
                $course->setInstructor($this->user);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $course = $courseDAO->getObjects($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewNewForum($course);
                }
                break;
            case Rotas::$CREATE_NEW_FORUM:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                
                $course->setInstructor($this->user);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $course = $courseDAO->getObjects($filter)->offsetGet(0);
                if ($course instanceof Courses) {
                    $forum = new Forum();
                    $forum->setId($courseDAO->getNextAutoIncrementForum());
                    $forum->setTitle($_REQUEST['nameForum']);
                    
                    $answer = new Answer();
                    $answer->setAnswer($_REQUEST['textArea']);
                    
                    $answers = new ArrayObject();
                    $answers->append($answer);
                    
                    $forum->setAnswers($answers);
                    if ($courseDAO->insertForunsDAO($forum, $this->user, $course)) {
                        $this->screen->setInsertSuccess();
                    } else {
                        $this->screen->setInsertFail();
                    }
                }
                break;
            case Rotas::$OPEN_FORUM:
                $idForum = $_REQUEST['idForum'];
                $course = new Courses();
                
                $forum = new Forum();
                $forum->setId($idForum);
                
                $foruns = new ArrayObject();
                $foruns->append($forum);
                
                $course->setForuns($foruns);
                
                $course->setInstructor($this->user);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY A.DateCreate ASC");
                
                $course = $courseDAO->getForuns($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewForum($course->getForuns()->offsetGet(0));
                }
                break;
            case Rotas::$ANSWER_FORUM:
                $idForum = $_REQUEST['idForum'];
                $course = new Courses();
                
                $forum = new Forum();
                $forum->setId($idForum);
                
                $foruns = new ArrayObject();
                $foruns->append($forum);
                
                $course->setForuns($foruns);
                
                $course->setInstructor($this->user);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY A.DateCreate ASC");
                
                $course = $courseDAO->getObjects($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $forum = $course->getForuns()->offsetGet(0);
                    if ($forum instanceof Forum) {
                        $answer = new Answer();
                        $answer->setAnswer($_REQUEST['textArea']);
                        if ($courseDAO->insertAnswerDAO($answer, $this->user, $forum)) {
                            
                            $idForum = $_REQUEST['idForum'];
                            $course = new Courses();
                            
                            $forum = new Forum();
                            $forum->setId($idForum);
                            
                            $foruns = new ArrayObject();
                            $foruns->append($forum);
                            
                            $course->setForuns($foruns);
                            
                            $course->setInstructor($this->user);
                            
                            $courseDAO = new CoursesDAO();
                            $filter = new FilterCourses($course);
                            $filter->setOrder("ORDER BY A.DateCreate DESC");
                            
                            $course = $courseDAO->getObjects($filter)->offsetGet(0);
                            
                            if ($course instanceof Courses) {
                                $forum = $course->getForuns()->offsetGet(0);
                                if ($forum instanceof Forum) {
                                    $this->screen->setViewAnswer($forum->getAnswers()->offsetGet(0), $forum);
                                }
                            }
                            
                        } else {
                            $this->screen->setInsertFail();
                        }
                    }
                }
                break;
            case Rotas::$VIEW_ALL_EXERCISES:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($_REQUEST['idCourse']);
                
                $filterCourse = new FilterCourses($course);
                
                $courseDAO = new CoursesDAO();
                
                $course = $courseDAO->getObjects($filterCourse)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewAllExercises($course->getExercises(), $course);
                }
                
                break;
            case Rotas::$VIEW_CREATE_EXERCISES:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($_REQUEST['idCourse']);
                
                $filterCourse = new FilterCourses($course);
                
                $courseDAO = new CoursesDAO();
                
                $course = $courseDAO->getObjects($filterCourse)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewCreateExercises($course);
                }
                break;
            case Rotas::$CREATE_NEW_EXERCISES:
                $idCourse = $_REQUEST['idCourse'];
                $nameExercise = $_REQUEST['nameExercise'];
                $weightExercise = $_REQUEST['weightExercise'];
                $dateLimit = $_REQUEST['dateLimit'];
                
                $courseDAO = new CoursesDAO();
                
                $course = new Courses();
                $course->setId($idCourse);
                
                $exercises = new ArrayObject();
                
                $exercise = new Exercises();
                $exercise->setDateLimit(DateTime::createFromFormat("d/m/Y H:i:s", $dateLimit));
                $exercise->setIdTask($courseDAO->getNextAutoIncrementTasks());
                $exercise->setName($nameExercise);
                $exercise->setReleased(0);
                $exercise->setWeightTask($weightExercise);
                
                $exercises->append($exercise);
                
                $course->setExercises($exercises);
                
                if ($courseDAO->insertExercisesDAO($course)) {
                    $this->screen->setInsertSuccess();
                } else {
                    $this->screen->setInsertFail();
                }
                
                break;
            case Rotas::$OPEN_EXERCISE_INSTRUCTOR:
                $idExercise = $_REQUEST['idExercise'];
                
                $exercise = new Exercises();
                $exercise->setIdExercise($idExercise);
                
                $courses = new Courses();
                
                $exercises = new ArrayObject();
                $exercises->append($exercise);
                
                $courses->setExercises($exercises);
                
                $courseDAO = new CoursesDAO();
                $filterCourse = new FilterCourses($courses);
                
                $course = $courseDAO->getObjects($filterCourse)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewOpenExercises($course);
                }
                break;
            default:
                break;
        }
    }
    
}