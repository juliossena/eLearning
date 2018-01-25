<?php

$requiresUH[] = 'app/models/courses/NewsCourse.php';
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
    private $insertCourse = "INSERT INTO Courses (Id, Name, Description, DateNew, DateFinish, Information, Instructor, Password, CertifiedPercentage, MinimumTime) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    private $insertCourseClass = "INSERT INTO CoursesAvailableClass (IdCourse, IdClass) VALUES %s";
    private $insertCourseUser = "INSERT INTO CoursesAvailableUser (IdCourse, EmailUser) VALUES %s";
    private $insertCourseFile = "INSERT INTO Files (Name, Link, Thumbnail, IdCourses) VALUES ('%s', '%s', '%s', '%s')";
    private $insertCourseUserRegistered = "INSERT INTO CoursesRegisteredUser (IdCourse, EmailUser) VALUES ('%s', '%s')";
    private $insertForum = "INSERT INTO Forum (Id, UserCreate, IdCourses, DateCreate, Title) VALUES ('%s', '%s', '%s', Now(), '%s')";
    private $insertAnswer = "INSERT INTO Answer (UserCreate, Answer, DateCreate, IdForum) VALUES ('%s', '%s', Now(), '%s')";
    private $select = "SELECT C.Id, C.Name, C.Description, C.DateNew, C.DateFinish, C.Information, C.Instructor, 
                        C.Password, C.CertifiedPercentage, C.MinimumTime, CAC.IdClass, UC.EmailUsers as EmailUsersClass, 
                        CAU.EmailUser as EmailUserAvailable, CCU.EmailUser as EmailUserConfig, CRU.EmailUser as EmailUserRegistered, 
                        CRU.TimeElapse, F.Id as IdForum, F.UserCreate as UserCreateForum, F.DateCreate as DateCreateForum, F.Title as TitleForum, UF.Name as NameUserForum,
                        A.Id as IdAnswer, A.UserCreate as UserCreateAnswer, A.DateCreate as DateCreateAnswer, A.Answer, UA.Name as NameUserAnswer,
                        T.Id as IdTasks, FI.Id as IdFile, FI.Name as NameFile, FI.Thumbnail, FI.Link as LinkFile, 
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
                        left join Files as FI ON C.Id = FI.IdCourses 
                        left join UsersClass as UC ON UC.IdClass = CAC.IdClass 
                        left join NewsCourses as NC ON NC.IdCourse = C.Id WHERE %s %s";
    
    private $update = "UPDATE Courses SET Name='%s', Description='%s', DateNew='%s', DateFinish='%s', Information='%s', Instructor='%s', Password='%s', CertifiedPercentage='%s', MinimumTime='%s' WHERE Id LIKE '%s'";
    private $updateTimeCourse = "UPDATE CoursesRegisteredUser SET TimeElapse = '%s' WHERE IdCourse Like '%s' AND EmailUser Like '%s'";
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
    
    protected function InsertObject (ArrayObject $array, Courses $courses) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newCourse = $array->offsetGet($i);
            if ($newCourse instanceof Courses) {
                if ($newCourse->getId() == $courses->getId()) {
                    if ($courses->getClasses()->count() > 0) {
                        $newCourse->setClasses($this->insertClasses($newCourse->getClasses(), $courses->getClasses()->offsetGet(0)));
                    }
                    if ($courses->getFiles()->count() > 0) {
                        $newCourse->setFiles($this->insertFiles($newCourse->getFiles(), $courses->getFiles()->offsetGet(0)));
                    }
                    if ($courses->getForuns()->count() > 0) {
                        $newCourse->setForuns($this->insertForuns($newCourse->getForuns(), $courses->getForuns()->offsetGet(0)));
                    }
                    if ($courses->getStudents()->count() > 0) {
                        $newCourse->setStudents($this->insertStudents($newCourse->getStudents(), $courses->getStudents()->offsetGet(0)));
                    }
                    if ($courses->getStudentsRegistered()->count() > 0) {
                        $newCourse->setStudentsRegistered($this->insertStudents($newCourse->getStudentsRegistered(), $courses->getStudentsRegistered()->offsetGet(0)));
                    }
                    if ($courses->getNews()->count() > 0) {
                        $newCourse->setNews($this->insertNews($newCourse->getNews(), $courses->getNews()->offsetGet(0)));
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
    
    public function updateTimeCourse(Courses $course, Users $user) {
        $sql = sprintf($this->updateTimeCourse, $user->getTimeElapseCourse()->format("H:i:s"), $course->getId(), $user->getEmail());
        return $this->runQuery($sql);
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
                
                $objects = $this->InsertObject($objects, $course);
                
            }
        }
        return $objects;
    }
    
    public function instance($array) {
        
    }
    
}