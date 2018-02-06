<?php

$requiresUH[] = 'app/models/courses/NewsCourse.php';
$requiresUH[] = 'app/models/tasks/CompositionQuestion.php';
$requiresUH[] = 'app/models/tasks/Exercises.php';
$requiresUH[] = 'app/models/tasks/Question.php';
$requiresUH[] = 'app/models/tasks/Tasks.php';
$requiresUH[] = 'app/dao/DAO.php';

for ($i = 0 ; $i < count($requiresUH) ; $i ++) {
    while (!file_exists($requiresUH[$i])) {
        $requiresUH[$i] = '../' . $requiresUH[$i];
    }
    require_once $requiresUH[$i];
}

class CoursesDAO extends DAO{
    private $nextAutoIncrement = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'Courses'";
    private $nextAutoIncrementForum = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'Forum'";
    private $nextAutoIncrementTasks = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'Tasks'";
    private $nextAutoIncrementQuestion = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'Question'";
    private $insertTasksUser = "INSERT INTO TasksUsers (IdTasks, EmailUser, Percentagem) VALUES ('%s', '%s', '%s')";
    private $insertCourse = "INSERT INTO Courses (Id, Name, Description, DateNew, DateFinish, Information, Instructor, Password, CertifiedPercentage, MinimumTime) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    private $insertCourseClass = "INSERT INTO CoursesAvailableClass (IdCourse, IdClass) VALUES %s";
    private $insertCourseUser = "INSERT INTO CoursesAvailableUser (IdCourse, EmailUser) VALUES %s";
    private $insertCourseFile = "INSERT INTO Files (Name, Link, Thumbnail, IdCourses) VALUES ('%s', '%s', '%s', '%s')";
    private $insertTasks = "INSERT INTO Tasks (Id, IdCourses, WeightTask) VALUES ('%s', '%s', '%s')";
    private $insertQuestion = "INSERT INTO Question (Id, Difficulty, Sequence, IdExercises) VALUES ('%s', '%s', '%s', '%s')";
    private $insertCompositionQuestion = "INSERT INTO CompositionQuestion (IdQuestion, Sequence, Type, Answer, Text, Link) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')";
    private $insertExercises = "INSERT INTO Exercises (Name, DateLimite, Released, IdTasks) VALUES ('%s', '%s', '%s', '%s')";
    private $insertCourseUserRegistered = "INSERT INTO CoursesRegisteredUser (IdCourse, EmailUser) VALUES ('%s', '%s')";
    private $insertForum = "INSERT INTO Forum (Id, UserCreate, IdCourses, DateCreate, Title) VALUES ('%s', '%s', '%s', Now(), '%s')";
    private $insertAnswer = "INSERT INTO Answer (UserCreate, Answer, DateCreate, IdForum) VALUES ('%s', '%s', Now(), '%s')";
    private $selectFiles = "SELECT C.Id, FI.Id as IdFile, FI.Name as NameFile, FI.Thumbnail, FI.Link as LinkFile
                           FROM Courses as C
                           left join CoursesRegisteredUser as CRU ON C.Id = CRU.IdCourse 
                           left join Files as FI ON C.Id = FI.IdCourses  WHERE %s %s";
    private $selectForuns = "SELECT C.Id, F.Id as IdForum, F.UserCreate as UserCreateForum, F.DateCreate as DateCreateForum, F.Title as TitleForum, UF.Name as NameUserForum,
                           A.Id as IdAnswer, A.UserCreate as UserCreateAnswer, A.DateCreate as DateCreateAnswer, A.Answer, UA.Name as NameUserAnswer
                           FROM Courses as C
                           left join Forum as F ON C.Id = F.IdCourses
                           left join Answer as A ON A.IdForum = F.Id
                           left join Users as UF ON F.UserCreate = UF.Email
                           left join Users as UA ON A.UserCreate = UA.Email WHERE %s %s";
    private $selectQuestions = "SELECT * FROM Question WHERE IdExercises LIKE '%s'";
    private $selectNews = "SELECT C.Id, NC.Id as IdNewsCourse, NC.Type as TypeNewsCourse, NC.ChangeCourse, NC.TimeChange, NC.EmailUser as EmailUserNews, 
                           NC.NameUser as NameUserNews
                           FROM Courses as C
                           left join CoursesRegisteredUser as CRU ON C.Id = CRU.IdCourse
                           left join NewsCourses as NC ON NC.IdCourse = C.Id WHERE %s %s";
    private $selectCourses = "SELECT C.Id, C.Name, C.Description, C.DateNew, C.DateFinish, C.Information, C.Instructor,
                            C.Password, C.CertifiedPercentage, C.MinimumTime 
                            FROM Courses as C
                            left join CoursesAvailableUser as CAU ON C.Id = CAU.IdCourse 
                            left join CoursesRegisteredUser as CRU ON C.Id = CRU.IdCourse
                            left join UsersClass as UC ON UC.IdClass WHERE %s %s";
    private $select = "SELECT C.Id, C.Name, C.Description, C.DateNew, C.DateFinish, C.Information, C.Instructor, 
                        C.Password, C.CertifiedPercentage, C.MinimumTime, CAC.IdClass, UC.EmailUsers as EmailUsersClass, 
                        CAU.EmailUser as EmailUserAvailable, CCU.EmailUser as EmailUserConfig, CRU.EmailUser as EmailUserRegistered, 
                        CRU.TimeElapse, F.Id as IdForum, F.UserCreate as UserCreateForum, F.DateCreate as DateCreateForum, F.Title as TitleForum, UF.Name as NameUserForum,
                        A.Id as IdAnswer, A.UserCreate as UserCreateAnswer, A.DateCreate as DateCreateAnswer, A.Answer, UA.Name as NameUserAnswer,
                        T.Id as IdTasks, T.WeightTask, TU.Percentagem,
                        FI.Id as IdFile, FI.Name as NameFile, FI.Thumbnail, FI.Link as LinkFile,
                        EX.Id as IdExercises, EX.Name as NameExercises, Ex.DateLimite as DateLimiteExercises, EX.Released as ReleasedExercises,
                        QU.Id as IdQuestion, QU.Difficulty as DifficultyQuestion, QU.Sequence as SequenceQuestion, 
                        CQ.Sequence as SequenceComposition, CQ.Type as TypeCompostion, CQ.Text as TextComposition, CQ.Link as LinkComposition, CQ.Answer as AnswerQuestion,
                        NC.Id as IdNewsCourse, NC.Type as TypeNewsCourse, NC.ChangeCourse, NC.TimeChange, NC.EmailUser as EmailUserNews, 
                        NC.NameUser as NameUserNews
                        FROM Courses as C left join CoursesAvailableClass as CAC ON C.Id = CAC.IdCourse 
                        left join CoursesAvailableUser as CAU ON C.Id = CAU.IdCourse 
                        left join CoursesConfigUser as CCU ON C.Id = CCU.IdCourse 
                        left join CoursesRegisteredUser as CRU ON C.Id = CRU.IdCourse 
                        left join Forum as F ON C.Id = F.IdCourses 
                        left join Answer as A ON A.IdForum = F.Id
                        left join Users as UF ON F.UserCreate = UF.Email
                        left join Users as UA ON A.UserCreate = UA.Email
                        left join Tasks as T ON C.Id = T.IdCourses
                        left join TasksUsers as TU ON T.Id = TU.IdTasks
                        left join Exercises as EX ON T.Id = EX.IdTasks
                        left join Question as QU ON QU.IdExercises = EX.Id
                        left join CompositionQuestion as CQ ON CQ.IdQuestion = QU.Id
                        left join Files as FI ON C.Id = FI.IdCourses 
                        left join UsersClass as UC ON UC.IdClass = CAC.IdClass
                        left join NewsCourses as NC ON NC.IdCourse = C.Id WHERE %s %s";
    
    private $update = "UPDATE Courses SET Name='%s', Description='%s', DateNew='%s', DateFinish='%s', Information='%s', Instructor='%s', Password='%s', CertifiedPercentage='%s', MinimumTime='%s' WHERE Id LIKE '%s'";
    private $updateTimeCourse = "UPDATE CoursesRegisteredUser SET TimeElapse = '%s' WHERE IdCourse Like '%s' AND EmailUser Like '%s'";
    private $updateExercise = "UPDATE Exercises SET Name = '%s', DateLimite = '%s', Released = '%s' WHERE Id LIKE '%s' AND IdTasks LIKE '%s'";
    private $updateTasks = "UPDATE Tasks SET WeightTask = '%s' Where Id LIKE '%s'";
    private $dropCourses = "DELETE FROM Courses WHERE Id LIKE '%s'";
    private $dropCoursesAvailableClass = "DELETE FROM CoursesAvailableClass WHERE IdCourse LIKE '%s'";
    private $dropCoursesAvailableUser = "DELETE FROM CoursesAvailableUser WHERE IdCourse LIKE '%s'";
    private $dropCoursesConfigUser = "DELETE FROM CoursesConfigUser WHERE IdCourse LIKE '%s'";
    private $dropCoursesRegisteredUser = "DELETE FROM CoursesRegisteredUser WHERE IdCourse LIKE '%s'";
    private $dropFiles = "DELETE FROM Files WHERE IdCourses LIKE '%s' AND Name LIKE '%s'";
    private $dropForuns = "DELETE FROM Forum WHERE IdCourses LIKE '%s'";
    private $dropTasks = "DELETE FROM Tasks WHERE IdCourses LIKE '%s'";
    
    public function insert($object) {
        if ($object instanceof Courses) {
            $sql = sprintf($this->insertCourse, 
                $object->getId(),
                $object->getName(),
                $object->getDescription(),
                $object->getDateNew()->format('Y-m-d'),
                $object->getDateFinish()->format('Y-m-d'),
                $object->getInformation(),
                $object->getInstructor()->getEmail(),
                $object->getPassword(),
                $object->getCertifiedPercentage(),
                $object->getMinimumTime()->format("H:i:s"));
            if ($this->runQuery($sql)) {
                $insertSucess = true;
                if ($object->getClasses()->count() > 0) {
                    $sql = sprintf($this->insertCourseClass, $this->multiplesInsertsClasses($object->getClasses(), $object));
                    if (! $this->runQuery($sql)) {
                        $insertSucess = false;
                    }
                }
                if ($object->getFiles() != null) {
                    
                }
                if ($object->getForuns() != null) {
                    
                }
                if ($object->getStudents()->count() > 0) {
                    $sql = sprintf($this->insertCourseUser, $this->multiplesInsertsUsers($object->getStudents(), $object));
                    if (! $this->runQuery($sql)) {
                        $insertSucess = false;
                    }
                }
                if ($object->getTasks() != null) {
                    
                }
                return $insertSucess;
            }
        } else {
            throw new ObjectException("it is necessary that the object be of type course");
        }
    }
    
    public function getQuestionsExercises (Exercises $exercise) {
        $sql = sprintf($this->selectQuestions, $exercise->getIdExercise());
        $rs = $this->runSelect($sql);
        
        $questions = new ArrayObject();
        
        for ($i = 0 ; $i < count($rs) ; $i ++) {
            if (isset($rs[$i]['Id'])) {
                $question = new Question();
                $question->setId($rs[$i]['Id']);
                $questions->append($question);
            }
        }
        
        $exercise->setQuestions($questions);
        
        return $exercise;
        
    }
    
    public function insertTasksUser (Users $user) {
        $exercise = $user->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            $sql = sprintf($this->insertTasksUser, $exercise->getIdTask(), $user->getEmail(), $exercise->getPercentagem());
            return $this->runQuery($sql);
        }
    }
    
    public function insertQuestionDAO (Exercises $exercises) {
        $question = $exercises->getQuestions()->offsetGet(0);
        if ($question instanceof Question) {
            $sql = sprintf($this->insertQuestion, $question->getId(), $question->getDifficulty(), $question->getSequence(), $exercises->getIdExercise());
            if ($this->runQuery($sql)) {
                for ($i = 0 ; $i < $question->getCompositionQuestion()->count() ; $i++) {
                    $composition = $question->getCompositionQuestion()->offsetGet($i);
                    if ($composition instanceof CompositionQuestion) {
                        $sql = sprintf($this->insertCompositionQuestion, $question->getId(), $composition->getSequence(), $composition->getType(), $composition->getAnswer(), Commands::javaScriptForISO($composition->getText()), $composition->getLink());
                        $this->runQuery($sql);
                    }
                }
            }
        }
        return true;
    }
    
    public function insertExercisesDAO (Courses $course) {
        $exercise = $course->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            $sql = sprintf($this->insertTasks, $exercise->getIdTask(), $course->getId(), $exercise->getWeightTask());
            if ($this->runQuery($sql)) {
                $sql = sprintf($this->insertExercises, $exercise->getName(), $exercise->getDateLimit()->format("Y-m-d H:i:s"), $exercise->getReleased(), $exercise->getIdTask());
                return $this->runQuery($sql);
            }
        }
    }
    
    public function insertFilesDAO (Courses $course, $nome) {
        $file = $course->getFiles()->offsetGet(0);
        if ($file instanceof Files) {
            $sql = sprintf($this->insertCourseFile, $file->getName(), $file->getLocation(), $file->getThumbnail(),  $course->getId());
            return $this->runQuery($sql);
        }
    }
    
    public function insertForunsDAO (Forum $forum, Users $user, Courses $course) {
        $sql = sprintf($this->insertForum, $forum->getId(), $user->getEmail(), $course->getId(), $forum->getTitle());
        if ($this->runQuery($sql)) {
            for ($i = 0 ; $i < $forum->getAnswers()->count() ; $i++) {
                return ($this->insertAnswerDAO($forum->getAnswers()->offsetGet($i), $user, $forum));
            }
        }
    }
    
    public function insertAnswerDAO (Answer $answer, Users $user, Forum $forum) {
        $sql = sprintf($this->insertAnswer, $user->getEmail(), $answer->getAnswer(), $forum->getId());
        return $this->runQuery($sql);
    }
    
    public function registeredUserClass (Courses $course, Users $user) {
        $sql = sprintf($this->insertCourseUserRegistered, $course->getId(), $user->getEmail());
        return $this->runQuery($sql);
    }
    
    protected function multiplesInsertsClasses (ArrayObject $ojects, Courses $course) {
        $object = new ArrayObject();
        for ($i = 0 ; $i < $ojects->count() ; $i++) {
            $newArray = $ojects->offsetGet($i);
            if ($newArray instanceof Classes) {
                $newObject[0] = $course->getId();
                $newObject[1] = $newArray->getId();
                
                $object->append($newObject);
            }
        }
        return $this->multiplesInserts($object);
    }
    
    protected function multiplesInsertsUsers (ArrayObject $ojects, Courses $course) {
        $object = new ArrayObject();
        for ($i = 0 ; $i < $ojects->count() ; $i++) {
            $newArray = $ojects->offsetGet($i);
            if ($newArray instanceof Users) {
                $newObject[0] = $course->getId();
                $newObject[1] = $newArray->getEmail();
                
                $object->append($newObject);
            }
        }
        return $this->multiplesInserts($object);
    }
    
    public function getNextAutoIncrementQuestion() {
        $vetor = $this->runSelect($this->nextAutoIncrementQuestion);
        return $vetor[0]['AUTO_INCREMENT'];
    }
    
    public function getNextAutoIncrementTasks() {
        $vetor = $this->runSelect($this->nextAutoIncrementTasks);
        return $vetor[0]['AUTO_INCREMENT'];
    }
    
    public function getNextAutoIncrementForum() {
        $vetor = $this->runSelect($this->nextAutoIncrementForum);
        return $vetor[0]['AUTO_INCREMENT'];
    }
    
    public function getNextAutoIncrement() {
        $vetor = $this->runSelect($this->nextAutoIncrement);
        return $vetor[0]['AUTO_INCREMENT'];
    }
    
    public function update($object) {
        if ($object instanceof Courses) {
            $sql = sprintf($this->update,
                $object->getName(),
                $object->getDescription(),
                $object->getDateNew()->format('Y-m-d'),
                $object->getDateFinish()->format('Y-m-d'),
                $object->getInformation(),
                $object->getInstructor()->getEmail(),
                $object->getPassword(),
                $object->getCertifiedPercentage(),
                $object->getMinimumTime()->format("H:i:s"),
                $object->getId());
            if ($this->runQuery($sql)) {
                if ($this->dropClass($object) &&
                    $this->dropUserAvailable($object)) {
                        $insertSucess = true;
                        if ($object->getClasses()->count() > 0) {
                            $sql = sprintf($this->insertCourseClass, $this->multiplesInsertsClasses($object->getClasses(), $object));
                            if (! $this->runQuery($sql)) {
                                $insertSucess = false;
                            }
                        }
                        if ($object->getStudents()->count() > 0) {
                            $sql = sprintf($this->insertCourseUser, $this->multiplesInsertsUsers($object->getStudents(), $object));
                            if (! $this->runQuery($sql)) {
                                $insertSucess = false;
                            }
                        }
                        return $insertSucess;
                    }
            }
        } else {
            throw new ObjectException("it is necessary that the object be of type course");
        }
    }
    
    public function dropUserRegistered (Courses $course) {
        $sql = sprintf($this->dropCoursesRegisteredUser, $course->getId());
        return $this->runQuery($sql);
    }
    
    public function dropUserAvailable (Courses $course) {
        $sql = sprintf($this->dropCoursesAvailableUser, $course->getId());
        return $this->runQuery($sql);
    }
    
    public function dropForuns (Courses $course) {
        $sql = sprintf($this->dropForuns, $course->getId());
        return $this->runQuery($sql);
    }
    
    public function dropFiles (Courses $course) {
        $sql = sprintf($this->dropFiles, $course->getId(), $course->getFiles()->offsetGet(0)->getName());
        return $this->runQuery($sql);
    }
    
    public function dropClass (Courses $course) {
        $sql = sprintf($this->dropCoursesAvailableClass, $course->getId());
        return $this->runQuery($sql);
    }
    
    public function drop($object) {
        if ($object instanceof Courses) {
            if ($this->dropClass($object) && 
                $this->dropFiles($object) && 
                $this->dropForuns($object) && 
                $this->dropUserAvailable($object) && 
                $this->dropUserRegistered($object)) {
                    $sql = sprintf($this->dropCourses, $object->getId());
                    return $this->runQuery($sql);
            }
        }
    }
    
    protected function getSelect() {
        return $this->select;
    }
    
    
    protected function insertStudents (ArrayObject $array, Users $user) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newUser = $array->offsetGet($i);
            if ($newUser instanceof Users) {
                if ($newUser->getEmail() == $user->getEmail()) {
                    return $array;
                }
            }
        }
        $array->append($user);
        return $array;
    }
    
    protected function insertFiles (ArrayObject $array, Files $files) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newFile = $array->offsetGet($i);
            if ($newFile instanceof Files) {
                if ($newFile->getId() == $files->getId()) {
                    return $array;
                }
            }
        }
        $array->append($files);
        return $array;
    }
    
    protected function insertNews(ArrayObject $array, NewsCourse $newsCourse) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newNewsCourse = $array->offsetGet($i);
            if ($newNewsCourse instanceof NewsCourse) {
                if ($newNewsCourse->getId() == $newsCourse->getId()) {
                    return $array;
                }
            }
        }
        $array->append($newsCourse);
        return $array;
    }
    
    protected function insertStudentClass (ArrayObject $array, Users $users) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newUser = $array->offsetGet($i);
            if ($newUser instanceof Users) {
                if ($newUser->getEmail() == $users->getEmail()) {
                    return $array;
                }
            }
        }
        $array->append($users);
        return $array;
    }
    
    protected function insertAnwersForum (ArrayObject $array, Answer $answer) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newAnswer = $array->offsetGet($i);
            if ($newAnswer instanceof Answer) {
                if ($newAnswer->getId() == $answer->getId()) {
                    return $array;
                }
            }
        }
        $array->append($answer);
        return $array;
    }
    
    protected function insertForuns (ArrayObject $array, Forum $forum) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newForum = $array->offsetGet($i);
            if ($newForum instanceof Forum) {
                if ($newForum->getId() == $forum->getId()) {
                    if ($forum->getAnswers()->count() > 0) {
                        $newForum->setAnswers($this->insertAnwersForum($newForum->getAnswers(), $forum->getAnswers()->offsetGet(0)));
                    }
                    
                    $array->offsetSet($i, $newForum);
                    return $array;
                }
            }
        }
        $array->append($forum);
        return $array;
    }
    
    protected function insertClasses (ArrayObject $array, Classes $class) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newClass = $array->offsetGet($i);
            if ($newClass instanceof Classes) {
                if ($newClass->getId() == $class->getId()) {
                    if ($class->getStudents()->count() > 0) {
                        $newClass->setStudents($this->insertStudentClass($newClass->getStudents(), $class->getStudents()->offsetGet(0)));
                    }
                    
                    $array->offsetSet($i, $newClass);
                    return $array;
                }
            }
        }
        $array->append($class);
        return $array;
    }
    
    protected function insertComposition (ArrayObject $array, CompositionQuestion $composition) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newComposition = $array->offsetGet($i);
            if ($newComposition instanceof CompositionQuestion) {
                if ($newComposition->getSequence() == $composition->getSequence()) {
                    return $array;
                }
            }
        }
        $array->append($composition);
        return $array;
    }
    
    protected function insertQuestion (ArrayObject $array, Question $question) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newQuestion = $array->offsetGet($i);
            if ($newQuestion instanceof Question) {
                if ($newQuestion->getId() == $question->getId()) {
                    if ($question->getCompositionQuestion()->count() > 0) {
                        $newQuestion->setCompositionQuestion($this->insertComposition($newQuestion->getCompositionQuestion(), $question->getCompositionQuestion()->offsetGet(0)));
                    }
                    
                    $array->offsetSet($i, $newQuestion);
                    return $array;
                }
            }
        }
        $array->append($question);
        return $array;
    }
    
    protected function insertExercises (ArrayObject $array, Exercises $exercise) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newExercise = $array->offsetGet($i);
            if ($newExercise instanceof Exercises) {
                if ($newExercise->getIdExercise() == $exercise->getIdExercise()) {
                    if ($exercise->getQuestions()->count() > 0) {
                        $newExercise->setQuestions($this->insertQuestion($newExercise->getQuestions(), $exercise->getQuestions()->offsetGet(0)));
                    }
                    
                    $array->offsetSet($i, $newExercise);
                    return $array;
                }
            }
        }
        $array->append($exercise);
        return $array;
    }
    
    protected function InsertObject (ArrayObject $array, Courses $courses) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newCourse = $array->offsetGet($i);
            if ($newCourse instanceof Courses) {
                if ($newCourse->getId() == $courses->getId()) {
                    if ($courses->getClasses() != null && $courses->getClasses()->count() > 0) {
                        $newCourse->setClasses($this->insertClasses($newCourse->getClasses(), $courses->getClasses()->offsetGet(0)));
                    }
                    if ($courses->getFiles() != null && $courses->getFiles()->count() > 0) {
                        $newCourse->setFiles($this->insertFiles($newCourse->getFiles(), $courses->getFiles()->offsetGet(0)));
                    }
                    if ($courses->getForuns() != null && $courses->getForuns()->count() > 0) {
                        $newCourse->setForuns($this->insertForuns($newCourse->getForuns(), $courses->getForuns()->offsetGet(0)));
                    }
                    if ($courses->getStudents() != null && $courses->getStudents()->count() > 0) {
                        $newCourse->setStudents($this->insertStudents($newCourse->getStudents(), $courses->getStudents()->offsetGet(0)));
                    }
                    if ($courses->getStudentsRegistered() != null && $courses->getStudentsRegistered()->count() > 0) {
                        $newCourse->setStudentsRegistered($this->insertStudents($newCourse->getStudentsRegistered(), $courses->getStudentsRegistered()->offsetGet(0)));
                    }
                    if ($courses->getNews() != null && $courses->getNews()->count() > 0) {
                        $newCourse->setNews($this->insertNews($newCourse->getNews(), $courses->getNews()->offsetGet(0)));
                    }
                    if ($courses->getExercises() != null && $courses->getExercises()->count() > 0) {
                        $newCourse->setExercises($this->insertExercises($newCourse->getExercises(), $courses->getExercises()->offsetGet(0)));
                    }
                    //$newCourse->setTasks($tasks);
                    
                    $array->offsetSet($i, $newCourse);
                    return $array;
                }
            }
        }
        $array->append($courses);
        return $array;
    }
    
    public function updateExercise (Exercises $exercise) {
        $sql = sprintf($this->updateTasks, $exercise->getWeightTask(), $exercise->getIdTask());
        if ($this->runQuery($sql)) {
            $sql = sprintf($this->updateExercise, $exercise->getName(), $exercise->getDateLimit()->format("Y-m-d H:i:s"), $exercise->getReleased(), $exercise->getIdExercise(), $exercise->getIdTask());
            return $this->runQuery($sql);
        }
    }
    
    public function updateTimeCourse(Courses $course, Users $user) {
        $sql = sprintf($this->updateTimeCourse, $user->getTimeElapseCourse()->format("H:i:s"), $course->getId(), $user->getEmail());
        return $this->runQuery($sql);
    }
    
    public function getFiles($filter) {
        $objects = new ArrayObject();
        $sql = sprintf($this->selectFiles, $filter->getWhere(), $filter->getOrder());
        $rs = $this->runSelect($sql);
        
        for ($i = 0 ; $i < count($rs) ; $i++){
            $course = new Courses();
            $course->setId($rs[$i]['Id']);
            
            $classes = new ArrayObject();
            $course->setClasses($classes);
            
            
            $files = new ArrayObject();
            if ($rs[$i]['IdFile'] != null) {
                $file = new Files();
                $file->setId($rs[$i]['IdFile']);
                $file->setLocation($rs[$i]['LinkFile']);
                $file->setName($rs[$i]['NameFile']);
                $file->setThumbnail($rs[$i]['Thumbnail']);
                $files->append($file);
            }
            
            $course->setFiles($files);
            
            $foruns = new ArrayObject();
            $course->setForuns($foruns);
            
            $newsCourses = new ArrayObject();
            $course->setNews($newsCourses);
            
            $instructor = new Users();
            $course->setInstructor($instructor);
            
            
            $students = new ArrayObject();
            $course->setStudents($students);
            
            
            $studentsRegistered = new ArrayObject();
            $course->setStudentsRegistered($studentsRegistered);
            
            $objects = $this->InsertObject($objects, $course);
            
        }
        return $objects;
    }
    
    public function getForuns (FilterCourses $filter) {
        $objects = new ArrayObject();
        $sql = sprintf($this->selectForuns, $filter->getWhere(), $filter->getOrder());
        $rs = $this->runSelect($sql);
        
        for ($i = 0 ; $i < count($rs) ; $i++){
            $course = new Courses();
            $course->setId($rs[$i]['Id']);
            
            $classes = new ArrayObject();
            $course->setClasses($classes);
            
            
            $files = new ArrayObject();
            $course->setFiles($files);
            
            $foruns = new ArrayObject();
            if ($rs[$i]['IdForum'] != null) {
                $forum = new Forum();
                $forum->setDateCreate(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateCreateForum']));
                $forum->setTitle($rs[$i]['TitleForum']);
                $forum->setId($rs[$i]['IdForum']);
                $userForumCreate = new Users();
                $userForumCreate->setEmail($rs[$i]['UserCreateForum']);
                $userForumCreate->setName($rs[$i]['NameUserForum']);
                $forum->setUserCreate($userForumCreate);
                
                $answers = new ArrayObject();
                if ($rs[$i]['IdAnswer'] != null) {
                    $answer = new Answer();
                    $answer->setId($rs[$i]['IdAnswer']);
                    $answer->setAnswer($rs[$i]['Answer']);
                    $answer->setDateCreate(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateCreateAnswer']));
                    
                    $userAnswerCreate = new Users();
                    $userAnswerCreate->setEmail($rs[$i]['UserCreateAnswer']);
                    $userAnswerCreate->setName($rs[$i]['NameUserAnswer']);
                    $answer->setUserCreate($userAnswerCreate);
                    
                    $answers->append($answer);
                }
                $forum->setAnswers($answers);
                $foruns->append($forum);
            }
            
            $course->setForuns($foruns);
            
            $newsCourses = new ArrayObject();
            $course->setNews($newsCourses);
            
            $instructor = new Users();
            $course->setInstructor($instructor);
            
            
            $students = new ArrayObject();
            $course->setStudents($students);
            
            
            $studentsRegistered = new ArrayObject();
            $course->setStudentsRegistered($studentsRegistered);
            
            $objects = $this->InsertObject($objects, $course);
            
        }
        return $objects;
    }
    
    public function getNews (FilterCourses $filter) {
        $objects = new ArrayObject();
        $sql = sprintf($this->selectNews, $filter->getWhere(), $filter->getOrder());
        $rs = $this->runSelect($sql);
        
        for ($i = 0 ; $i < count($rs) ; $i++){
            $course = new Courses();
            $course->setId($rs[$i]['Id']);
            
            $classes = new ArrayObject();
            $course->setClasses($classes);
            
            
            $files = new ArrayObject();
            $course->setFiles($files);
            
            $foruns = new ArrayObject();
            $course->setForuns($foruns);
            
            $newsCourses = new ArrayObject();
            if ($rs[$i]['IdNewsCourse'] != null) {
                $new = new NewsCourse();
                $new->setId($rs[$i]['IdNewsCourse']);
                $new->setTimeChange(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['TimeChange']));
                $new->setType($rs[$i]['TypeNewsCourse']);
                $userNews = new Users();
                $userNews->setName($rs[$i]['NameUserNews']);
                $userNews->setEmail($rs[$i]['EmailUserNews']);
                $new->setUser($userNews);
                $new->setChange($rs[$i]['ChangeCourse']);
                
                $newsCourses->append($new);
            }
            $course->setNews($newsCourses);
            
            $instructor = new Users();
            $course->setInstructor($instructor);
            
            
            $students = new ArrayObject();
            $course->setStudents($students);
            
            
            $studentsRegistered = new ArrayObject();
            $course->setStudentsRegistered($studentsRegistered);
            
            $objects = $this->InsertObject($objects, $course);
            
        }
        return $objects;
    }
    
    public function getCourses(FilterCourses $filter) {
        $objects = new ArrayObject();
        $sql = sprintf($this->selectCourses, $filter->getWhere(), $filter->getOrder());
        $rs = $this->runSelect($sql);
        
        for ($i = 0 ; $i < count($rs) ; $i++){
            $course = new Courses();
            $course->setCertifiedPercentage($rs[$i]['CertifiedPercentage']);
            $course->setDateFinish(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateFinish']));
            $course->setDateNew(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateNew']));
            $course->setDescription($rs[$i]['Description']);
            $course->setId($rs[$i]['Id']);
            $course->setInformation($rs[$i]['Information']);
            $course->setMinimumTime(DateTime::createFromFormat("H:i:s", $rs[$i]['MinimumTime']));
            $course->setName($rs[$i]['Name']);
            $course->setPassword($rs[$i]['Password']);
            
            $classes = new ArrayObject();
            $course->setClasses($classes);
            
            
            $files = new ArrayObject();
            $course->setFiles($files);
            
            $foruns = new ArrayObject();
            $course->setForuns($foruns);
            
            $newsCourses = new ArrayObject();
            $course->setNews($newsCourses);
            
            $instructor = new Users();
            $instructor->setEmail($rs[$i]['Instructor']);
            
            $course->setInstructor($instructor);
            
            
            $students = new ArrayObject();
            $course->setStudents($students);
            
            
            $studentsRegistered = new ArrayObject();
            $course->setStudentsRegistered($studentsRegistered);
            
            $objects = $this->InsertObject($objects, $course);
            
        }
        return $objects;
    }
    
    public function getObjects($filter) {
        
        $objects = new ArrayObject();
        if ($filter instanceof FilterCourses) {
            $rs = $this->select($filter->getWhere(), $filter->getOrder());
            
            for ($i = 0 ; $i < count($rs) ; $i++){
                $course = new Courses();
                $course->setCertifiedPercentage($rs[$i]['CertifiedPercentage']);
                $course->setDateFinish(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateFinish']));
                $course->setDateNew(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateNew']));
                $course->setDescription($rs[$i]['Description']);
                $course->setId($rs[$i]['Id']);
                $course->setInformation($rs[$i]['Information']);
                $course->setMinimumTime(DateTime::createFromFormat("H:i:s", $rs[$i]['MinimumTime']));
                $course->setName($rs[$i]['Name']);
                $course->setPassword($rs[$i]['Password']);
 //               $course->setTasks($tasks);
                
                $classes = new ArrayObject();
                $class = new Classes();
                $class->setId($rs[$i]['IdClass']);
                $studentClass = new Users();
                $studentClass->setEmail($rs[$i]['EmailUsersClass']);
                $studentsClass = new ArrayObject();
                $studentsClass->append($studentClass);
                $class->setStudents($studentsClass);
                
                $classes->append($class);
                
                $course->setClasses($classes);
                
                
                $files = new ArrayObject();
                if ($rs[$i]['IdFile'] != null) {
                    $file = new Files();
                    $file->setId($rs[$i]['IdFile']);
                    $file->setLocation($rs[$i]['LinkFile']);
                    $file->setName($rs[$i]['NameFile']);
                    $file->setThumbnail($rs[$i]['Thumbnail']);
                    $files->append($file);
                }
                
                $course->setFiles($files);
                
                $foruns = new ArrayObject();
                if ($rs[$i]['IdForum'] != null) {
                    $forum = new Forum();
                    $forum->setDateCreate(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateCreateForum']));
                    $forum->setTitle($rs[$i]['TitleForum']);
                    $forum->setId($rs[$i]['IdForum']);
                    $userForumCreate = new Users();
                    $userForumCreate->setEmail($rs[$i]['UserCreateForum']);
                    $userForumCreate->setName($rs[$i]['NameUserForum']);
                    $forum->setUserCreate($userForumCreate);
                    
                    $answers = new ArrayObject();
                    if ($rs[$i]['IdAnswer'] != null) {
                        $answer = new Answer();
                        $answer->setId($rs[$i]['IdAnswer']);
                        $answer->setAnswer($rs[$i]['Answer']);
                        $answer->setDateCreate(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateCreateAnswer']));
                        
                        $userAnswerCreate = new Users();
                        $userAnswerCreate->setEmail($rs[$i]['UserCreateAnswer']);
                        $userAnswerCreate->setName($rs[$i]['NameUserAnswer']);
                        $answer->setUserCreate($userAnswerCreate);
                        
                        $answers->append($answer);
                    }
                    $forum->setAnswers($answers);
                    $foruns->append($forum);
                }
                
                $course->setForuns($foruns);

                $newsCourses = new ArrayObject();
                if ($rs[$i]['IdNewsCourse'] != null) {
                    $new = new NewsCourse();
                    $new->setId($rs[$i]['IdNewsCourse']);
                    $new->setTimeChange(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['TimeChange']));
                    $new->setType($rs[$i]['TypeNewsCourse']);
                    $userNews = new Users();
                    $userNews->setName($rs[$i]['NameUserNews']);
                    $userNews->setEmail($rs[$i]['EmailUserNews']);
                    $new->setUser($userNews);
                    $new->setChange($rs[$i]['ChangeCourse']);
                    
                    $newsCourses->append($new);
                }
                $course->setNews($newsCourses);
                
                $instructor = new Users();
                $instructor->setEmail($rs[$i]['Instructor']);
                
                $course->setInstructor($instructor);
                
                
                $students = new ArrayObject();
                if ($rs[$i]['EmailUserAvailable'] != null) {
                    $student = new Users();
                    $student->setEmail($rs[$i]['EmailUserAvailable']);
                    $students->append($student);
                }
                
                $course->setStudents($students);
                
                $studentsRegistered = new ArrayObject();
                if ($rs[$i]['EmailUserRegistered'] != null) {
                    $studentRegistered = new Users();
                    $studentRegistered->setEmail($rs[$i]['EmailUserRegistered']);
                    $studentRegistered->setTimeElapseCourse(DateTime::createFromFormat("H:i:s", $rs[$i]['TimeElapse']));
                    $studentsRegistered->append($studentRegistered);
                }
                
                $course->setStudentsRegistered($studentsRegistered);
                
                
                $exercises = new ArrayObject();
                if ($rs[$i]['IdExercises'] != null) {
                    $exercise = new Exercises();
                    $exercise->setDateLimit(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateLimiteExercises']));
                    $exercise->setIdExercise($rs[$i]['IdExercises']);
                    $exercise->setIdTask($rs[$i]['IdTasks']);
                    $exercise->setPercentagem($rs[$i]['Percentagem']);
                    $exercise->setName($rs[$i]['NameExercises']);
                    $exercise->setReleased($rs[$i]['ReleasedExercises']);
                    $exercise->setWeightTask($rs[$i]['WeightTask']);
                    $questions = new ArrayObject();
                    if ($rs[$i]['IdQuestion'] != null) {
                        $question = new Question();
                        $question->setDifficulty($rs[$i]['DifficultyQuestion']);
                        $question->setId($rs[$i]['IdQuestion']);
                        $question->setSequence($rs[$i]['SequenceQuestion']);
                        
                        $compositions = new ArrayObject();
                        if ($rs[$i]['SequenceComposition'] != null) {
                            $composition = new CompositionQuestion();
                            $composition->setAnswer($rs[$i]['AnswerQuestion']);
                            $composition->setLink($rs[$i]['LinkComposition']);
                            $composition->setSequence($rs[$i]['SequenceComposition']);
                            $composition->setText($rs[$i]['TextComposition']);
                            $composition->setType($rs[$i]['TypeCompostion']);
                            
                            $compositions->append($composition);
                        }
                        $question->setCompositionQuestion($compositions);
                        $questions->append($question);
                    }
                    $exercise->setQuestions($questions);
                    
                    $exercises->append($exercise);
                }
                
                $course->setExercises($exercises);
                
                $objects = $this->InsertObject($objects, $course);
                
            }
        }
        return $objects;
    }
    
    public function instance($array) {
        
    }
    
}