<?php

$requiresCTCS[] = 'app/controller/view/CTela.php';
$requiresCTCS[] = 'app/view/courses/VCourses.php';
$requiresCTCS[] = 'app/dao/FilterCourses.php';
$requiresCTCS[] = 'app/dao/CoursesDAO.php';
$requiresCTCS[] = 'app/config/Commands.php';

for ($i = 0 ; $i < count($requiresCTCS) ; $i ++) {
    while (!file_exists($requiresCTCS[$i])) {
        $requiresCTCS[$i] = '../' . $requiresCTCS[$i];
    }
    require_once $requiresCTCS[$i];
}

class CTelaCourseStudent extends CTela{
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
            $students = new ArrayObject();
            $students->append($this->user);
            $course->setStudents($students);
            
            $filterCourse = new FilterCourses($course);
            $filterCourse->setOrder("ORDER BY Name");
            
            $courseRegistered = new Courses();
            $studentsRegistered = new ArrayObject();
            $studentsRegistered->append($this->user);
            $courseRegistered->setStudentsRegistered($studentsRegistered);
            
            $filterCourseRegistered = new FilterCourses($courseRegistered);
            $filterCourseRegistered->setOrder("ORDER BY Name");
            
            $courseDAO = new CoursesDAO();
            
            $this->screen->setViewAllCoursesStudent($courseDAO->getCourses($filterCourse), $courseDAO->getCourses($filterCourseRegistered));
        }
       
        return $this->screen;
    }
    
    public function permissionRegistered (Users $student, Courses $course) {
        for ($i = 0 ; $i < $course->getStudents()->count() ; $i++) {
            $newStudent = $course->getStudents()->offsetGet($i);
            if ($newStudent instanceof Users) {
                if ($newStudent->getEmail() == $student->getEmail()) {
                    return true;
                }
            }
        }
        for ($i = 0 ; $i < $course->getClasses()->count() ; $i++) {
            $newClasse = $course->getClasses()->offsetGet($i);
            if ($newClasse instanceof Classes) {
                for ($k = 0 ; $k < $newClasse->getStudents()->count() ; $k++) {
                    $newStudent = $newClasse->getStudents()->offsetGet($k);
                    if ($newStudent instanceof Users) {
                        if ($newStudent->getEmail() == $student->getEmail()) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    
    public function permissionOpenCourse (Users $student, Courses $course) {
        for ($i = 0 ; $i < $course->getStudentsRegistered()->count() ; $i++) {
            $newStudent = $course->getStudentsRegistered()->offsetGet($i);
            if ($newStudent instanceof Users) {
                if ($newStudent->getEmail() == $student->getEmail()) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function setRoute($subSite) {
        switch ($subSite) {
            case Rotas::$REGISTERED_COURSE:
                $course = new Courses();
                $course->setId($_REQUEST['idCourse']);
                
                $coursesDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                if ($this->permissionRegistered($this->user, $coursesDAO->getObjects($filter)->offsetGet(0))) {
                    if ($coursesDAO->registeredUserClass($course, $this->user)) {
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
            case Rotas::$OPEN_COURSE:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                $students = new ArrayObject();
                $students->append($this->user);
                $course->setStudentsRegistered($students);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $course = $courseDAO->getObjects($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    if ($this->permissionOpenCourse($this->user, $course)) {
                        $this->screen->setViewOpenCourse($course);
                    }
                }
                break;
            case Rotas::$ADD_TIME_COURSE:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                $students = new ArrayObject();
                $students->append($this->user);
                $course->setStudentsRegistered($students);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $course = $courseDAO->getObjects($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    if ($this->permissionOpenCourse($this->user, $course)) {
                        $newUser = $course->getStudentsRegistered()->offsetGet(0);
                        if ($newUser instanceof Users) {
                            $newUser->setTimeElapseCourse(DateTime::createFromFormat("H:i:s", $newUser->getTimeElapseCourse()->add(new DateInterval('PT10S'))->format("H:i:s")));
                            $courseDAO->updateTimeCourse($course, $newUser);
                        }
                    }
                }
                break;
                
            case Rotas::$VIEW_NEWS_COURSE:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                $students = new ArrayObject();
                $students->append($this->user);
                $course->setStudentsRegistered($students);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY TimeChange DESC");
                
                $course = $courseDAO->getNews($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setNewsCourse($course->getNews());
                }
                
                break;
            case Rotas::$VIEW_FILES_COURSE:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                $students = new ArrayObject();
                $students->append($this->user);
                $course->setStudentsRegistered($students);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY FI.Name");
                
                $course = $courseDAO->getFiles($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewFiles($course->getFiles(), $course);
                }
                break;
                
            case Rotas::$DOWNLOAD_FILE_COURSE:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                $students = new ArrayObject();
                $students->append($this->user);
                $course->setStudentsRegistered($students);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY FI.Name");
                
                $course = $courseDAO->getFiles($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    if ($this->permissionOpenCourse($this->user, $course)) {
                        for ($i = 0 ; $i < $course->getFiles()->count() ; $i++) {
                            $file = $course->getFiles()->offsetGet($i);
                            if ($file instanceof Files) {
                                if ($file->getId() == $_REQUEST['idFile']) {
                                    Commands::downloadArquivo('dados/' , $file->getLocation(), $file->getType());
                                }
                            }
                        }
                    }
                }
                break;
            case Rotas::$VIEW_FORUNS_COURSE:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY A.DateCreate DESC");
                $course = $courseDAO->getForuns($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewForunsStudents($course);
                }
                break;
            case Rotas::$VIEW_CREATE_FORUM:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $course = $courseDAO->getForuns($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewNewForumStudents($course);
                }
                break;
            case Rotas::$CREATE_NEW_FORUM:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $course = $courseDAO->getCourses($filter)->offsetGet(0);
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
                
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY A.DateCreate ASC");
                
                $course = $courseDAO->getForuns($filter)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewForumStudents($course->getForuns()->offsetGet(0));
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
                
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                $filter->setOrder("ORDER BY A.DateCreate ASC");
                
                $course = $courseDAO->getForuns($filter)->offsetGet(0);
                
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
                            
                            
                            $courseDAO = new CoursesDAO();
                            $filter = new FilterCourses($course);
                            $filter->setOrder("ORDER BY A.DateCreate DESC");
                            
                            $course = $courseDAO->getForuns($filter)->offsetGet(0);
                            
                            if ($course instanceof Courses) {
                                $forum = $course->getForuns()->offsetGet(0);
                                if ($forum instanceof Forum) {
                                    $this->screen->setViewAnswer($forum->getAnswers()->offsetGet(0));
                                }
                            }
                            
                        } else {
                            $this->screen->setInsertFail();
                        }
                    }
                }
                break;
            case Rotas::$VIEW_ALL_EXERCISES_STUDENTS:
                $idCourse = $_REQUEST['idCourse'];
                $course = new Courses();
                $course->setId($idCourse);
                
                $exercise = new Exercises();
                $exercise->setReleased(1);
                
                $exercises = new ArrayObject();
                $exercises->append($exercise);
                
                $course->setExercises($exercises);
                
                $courseDAO = new CoursesDAO();
                $filter = new FilterCourses($course);
                
                $courses = $courseDAO->getObjects($filter);
                if ($courses->count() > 0) {
                    $course = $courses->offsetGet(0);
                }
                
                
                if ($course instanceof Courses && $courses->count() > 0) {
                    $this->screen->setViewAllExercisesStudent($course->getExercises(), $course);
                }
                break;
            case Rotas::$OPEN_EXERCISE_STUDENT:
                $idExercise = $_REQUEST['idExercise'];
                
                $exercise = new Exercises();
                $exercise->setIdExercise($idExercise);
                
                $exerciseUser = new Exercises();
                for ($i = 0 ; $i < $this->user->getExercises()->count() ; $i++) {
                    $exerciseUser = $this->user->getExercises()->offsetGet($i);
                    if ($exerciseUser instanceof Exercises) {
                        if ($exerciseUser->getIdExercise() == $exercise->getIdExercise()) {
                            break;
                        }
                    }
                }
                
                $courses = new Courses();
                
                $exercises = new ArrayObject();
                $exercises->append($exercise);
                
                $courses->setExercises($exercises);
                
                $courseDAO = new CoursesDAO();
                $filterCourse = new FilterCourses($courses);
                
                $course = $courseDAO->getObjects($filterCourse)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $contentExercise = false;
                    for ($i = 0 ; $i < $this->user->getExercises()->count() ; $i++) {
                        $exerciseUser = $this->user->getExercises()->offsetGet($i);
                        if ($exerciseUser instanceof Exercises && $exerciseUser->getIdTask() == $course->getExercises()->offsetGet(0)->getIdTask()) {
                            $contentExercise = true;
                            break;
                        }
                    }
                    if (!$contentExercise) {
                        $this->screen->setViewOpenExercisesStudents($course, $exerciseUser);
                    } else {
                        $this->screen->setViewOpenExercisesStudentsFinish($course, $exerciseUser);
                    }
                    
                }
                
                break;
            case Rotas::$UPDATE_COMPOSITION_QUESTION:
                $exercise = new Exercises();
                $exercise->setIdExercise($_REQUEST['idExercise']);
                
                $coursesDAO = new CoursesDAO();
                
                $exercise = $coursesDAO->getQuestionsExercises($exercise);
                
                for ($i = 0 ; $i < $exercise->getQuestions()->count() ; $i++) {
                    $question = $exercise->getQuestions()->offsetGet($i);
                    if ($question instanceof Question) {
                        if (isset($_REQUEST['que_' . $question->getId()])) {
                            $userDao = new UsersDAO();
                            
                            $newExercise = new Exercises();
                            $newExercise->setIdExercise($exercise->getIdExercise());
                            
                                $newQuestions = new ArrayObject();
                                
                                    $newQuestion = new Question();
                                    $newQuestion->setId($question->getId());
                                    
                                    $newCompositions = new ArrayObject();
                                    
                                        $newComposition = new CompositionQuestion();
                                        $newComposition->setSequence($_REQUEST['que_' . $question->getId()]);
                                    
                                    $newCompositions->append($newComposition);
                                    
                                    $newQuestion->setCompositionQuestion($newCompositions);
                                
                                $newQuestions->append($newQuestion);
                            
                            $newExercise->setQuestions($newQuestions);
                            
                            $userDao->InsertCompositionUser($newExercise, $this->user);
                            
                        }
                    }
                }
                
                
                
                break;
            case Rotas::$CONFIRM_FINISH_EXERCISES:
                $idExercise = $_REQUEST['idExercise'];
                
                $exercise = new Exercises();
                $exercise->setIdExercise($idExercise);
                
                $exerciseUser = new Exercises();
                for ($i = 0 ; $i < $this->user->getExercises()->count() ; $i++) {
                    $exerciseUser = $this->user->getExercises()->offsetGet($i);
                    if ($exerciseUser instanceof Exercises) {
                        if ($exerciseUser->getIdExercise() == $exercise->getIdExercise()) {
                            break;
                        }
                    }
                }
                
                $courses = new Courses();
                
                $exercises = new ArrayObject();
                $exercises->append($exercise);
                
                $courses->setExercises($exercises);
                
                $courseDAO = new CoursesDAO();
                $filterCourse = new FilterCourses($courses);
                
                $course = $courseDAO->getObjects($filterCourse)->offsetGet(0);
                
                if ($course instanceof Courses) {
                    $this->screen->setViewFinishExercises($course);
                }
                
                break;
            case Rotas::$FINISH_EXERCISES:
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
                
                
                $user = $this->user;
                
                $newExercises = new ArrayObject();
                $newExercise = new Exercises();
                $newExercise->setIdExercise($idExercise);
                $newExercises->append($newExercise);
                
                $user->setExercises($newExercises);
                
                $filterUser = new FilterUsers($user);
                $userDAO = new UsersDAO();
                
                $user = $userDAO->getObjects($filterUser)->offsetGet(0);
                
                
                
                if ($course instanceof Courses && $user instanceof Users) {
                    $hits = $this->questionsHits($course, $user->getExercises()->offsetGet(0));
                    $qtdQuestion = $course->getExercises()->offsetGet(0)->getQuestions()->count();
                    
                    $exerciseUser = $user->getExercises()->offsetGet(0);
                    
                    if ($exerciseUser instanceof Exercises) {
                        $exerciseUser->setPercentagem($hits / $qtdQuestion);
                        $exerciseUser->setIdTask($course->getExercises()->offsetGet(0)->getIdTask());
                        
                        $user->getExercises()->offsetSet(0, $exerciseUser);
                        
                        if ($courseDAO->insertTasksUser($user)) {
                            $this->screen->setViewResultTask($user->getExercises()->offsetGet(0));
                        }
                    }
                }
                
                break;
            case Rotas::$VIEW_DATA_EXERCISES:
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
                    $this->screen->setViewExercise($course->getExercises()->offsetGet(0), $this->user);
                }
                
                break;
            default:
                break;
        }
    }
    
    private function questionsHits (Courses $course, Exercises $exerciseUser) {
        $hits = 0;
        $exercise = $course->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            for ($i = 0 ; $i < $exercise->getQuestions()->count() ; $i++) {
                for ($j = 0 ; $j < $exerciseUser->getQuestions()->count() ; $j++) {
                    $questionUser = $exerciseUser->getQuestions()->offsetGet($j);
                    if ($questionUser instanceof Question) {
                        $question = $exercise->getQuestions()->offsetGet($i);
                        if ($question instanceof Question && $question->getId() == $questionUser->getId()) {
                            for ($k = 0 ; $k < $question->getCompositionQuestion()->count() ; $k++) {
                                $composition = $question->getCompositionQuestion()->offsetGet($k);
                                if ($composition instanceof CompositionQuestion) {
                                    if ($composition->getAnswer()) {
                                        $compositionUser = $questionUser->getCompositionQuestion()->offsetGet(0);
                                        if ($composition->getSequence() == $compositionUser->getSequence()) {
                                            $hits++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
            }
        }
        
        return $hits;
    }
    
}