<?php

$requiresUD[] = 'app/dao/DAO.php';
$requiresUD[] = 'app/models/exceptions/ObjectException.php';
$requiresUD[] = 'app/models/users/Permission.php';
$requiresUD[] = 'app/models/users/Users.php';
$requiresUD[] = 'app/models/classes/Classes.php';
$requiresUD[] = 'app/models/courses/Courses.php';
$requiresUD[] = 'app/models/courses/Files.php';

for ($i = 0 ; $i < count($requiresUD) ; $i ++) {
    while (!file_exists($requiresUD[$i])) {
        $requiresUD[$i] = '../' . $requiresUD[$i];
    }
    require_once $requiresUD[$i];
}


class UsersDAO extends DAO{
    private $insertUser = "INSERT INTO Users (Email, Name, Password, DateBirth, City, Country, Type) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    private $insertPermission = "INSERT INTO UsersPermission (IdPermission, EmailUsers) VALUES %s";
    private $insertComposition = "INSERT INTO UserComposition (EmailUser, IdQuestion, IdExercises, SequenceComposition) VALUES ('%s', '%s', '%s', '%s')";
    private $insertUploadTasks = "INSERT INTO UploadTasksUser (IdUploadTasks, EmailUser, DateSend, File, NameFile) VALUES ('%s', '%s', '%s', '%s', '%s')";
    private $insertTasksUser = "INSERT INTO TasksUsers (IdTasks, EmailUser) VALUES ('%s', '%s')";
    private $updateUploadTasks = "UPDATE UploadTasksUser SET DateSend = '%s', File = '%s', NameFile = '%s' WHERE IdUploadTasks LIKE '%s' AND EmailUser LIKE '%s'";
    private $select = "SELECT U.Id, U.Email, U.Name, U.Password, U.DateBirth, U.City, U.Country, U.Type, 
                        UC.IdClass, UP.IdPermission, P.IsMenu, P.Menu, P.Link,
                        TU.IdTasks, TU.Percentagem,
                        UCO.IdQuestion as IdQuestionUser, UCO.IdExercises as IdExercisesUser, UCO.SequenceComposition as SequenceCompositionUser
                        FROM Users as U left join UsersClass as UC ON U.Email = UC.EmailUsers 
                        left join UsersPermission as UP ON U.Email = UP.EmailUsers 
                        left join UserComposition as UCO ON UCO.EmailUser = U.Email
                        left join TasksUsers as TU ON TU.EmailUser = U.Email
                        left join Permission as P ON P.id = UP.IdPermission WHERE %s %s";
    private $selecTasks = "SELECT U.Id, U.Email, U.Name, U.Password, U.DateBirth, U.City, U.Country, U.Type,
                        C.Id as IdCourse, C.Name as NameCourse, C.Description, C.DateNew, C.DateFinish, C.Information, C.Instructor,
                        C.Password as PasswordCourse, C.CertifiedPercentage, C.MinimumTime,
                        UTU.IdUploadTasks, UTU.DateSend as DateSendUploadTasks, UTU.File as FileUploadTasks, UTU.NameFile as NameFileUploadTasks,
                        T.Id as IdTasks, T.WeightTask, TU.Percentagem, TU.EmailUser,
                        EX.Id as IdExercises, EX.Name as NameExercises, Ex.DateLimite as DateLimiteExercises, EX.Released as ReleasedExercises
                        FROM Courses as C left join CoursesAvailableClass as CAC ON C.Id = CAC.IdCourse
                        left join Tasks as T ON C.Id = T.IdCourses
                        left join TasksUsers as TU ON T.Id = TU.IdTasks
                        left join Exercises as EX ON T.Id = EX.IdTasks
                        left join Users as U ON U.Email = TU.EmailUser
                        left join UploadTasksUser as UTU ON UTU.EmailUser = U.Email
                        WHERE %s %s";
    private $selecUploadTasks = "SELECT U.Id, U.Email, U.Name, U.Password, U.DateBirth, U.City, U.Country, U.Type,
                        C.Id as IdCourse, C.Name as NameCourse, C.Description, C.DateNew, C.DateFinish, C.Information, C.Instructor,
                        C.Password as PasswordCourse, C.CertifiedPercentage, C.MinimumTime,
                        UTU.IdUploadTasks, UTU.DateSend as DateSendUploadTasks, UTU.File as FileUploadTasks, UTU.NameFile as NameFileUploadTasks,
                        T.Id as IdTasks, T.WeightTask, TU.Percentagem, UTU.EmailUser
                        FROM Courses as C left join CoursesAvailableClass as CAC ON C.Id = CAC.IdCourse
                        left join Tasks as T ON C.Id = T.IdCourses
                        left join UploadTasks as UT ON UT.IdTasks = T.Id
                        left join UploadTasksUser as UTU ON UTU.IdUploadTasks = UT.Id
                        left join TasksUsers as TU ON TU.IdTasks = T.Id
                        left join Users as U ON U.Email = UTU.EmailUser                        
                        WHERE %s %s";
    private $selectUploadTasksUser = "SELECT U.Id, U.Email, U.Name, U.Password, U.DateBirth, U.City, U.Country, U.Type,
                        C.Id as IdCourse, C.Name as NameCourse, C.Description, C.DateNew, C.DateFinish, C.Information, C.Instructor,
                        C.Password as PasswordCourse, C.CertifiedPercentage, C.MinimumTime,
                        UTU.IdUploadTasks, UTU.DateSend as DateSendUploadTasks, UTU.File as FileUploadTasks, UTU.NameFile as NameFileUploadTasks,
                        T.Id as IdTasks, T.WeightTask, TU.Percentagem
                        FROM TasksUsers as TU
                        INNER JOIN UploadTasksUser as UTU ON TU.EmailUser = UTU.EmailUser
                        INNER JOIN UploadTasks as UT ON UT.Id = UTU.IdUploadTasks
                        INNER JOIN Tasks as T ON T.Id = UT.IdTasks
                        INNER JOIN Courses as C ON C.Id = T.IdCourses
                        INNER JOIN Users as U ON U.Email = UTU.EmailUser 
                        WHERE %s %s";
    private $selectPointes = "SELECT U.Id, U.Email, U.Name, U.Password, U.DateBirth, U.City, U.Country, U.Type,
                        T.Id as IdTasks, T.WeightTask, TU.Percentagem, TU.EmailUser,
                        UT.Id as IdUploadTasks, UT.Name as NameUploadTasks, UT.DateFinish as DateFinishUploadTasks, UT.DaysDelay as DaysDelayUploadTasks,
                        EX.Id as IdExercises, EX.Name as NameExercises, EX.DateLimite as DateLimiteExercises, EX.Released as ReleasedExercises
                        FROM Tasks as T
                    	LEFT JOIN TasksUsers as TU ON TU.IdTasks = T.Id
                        LEFT JOIN Exercises as EX ON EX.IdTasks = T.Id
                        Left Join UploadTasks as UT ON UT.IdTasks = T.Id
                        LEFT JOIN Users as U ON TU.EmailUser = U.Email
                        WHERE %s %s";
    private $update = "UPDATE Users SET Name = '%s', Password = '%s', DateBirth = '%s', City = '%s', Country = '%s' WHERE Email = '%s'";
    private $updateCompostion = "UPDATE UserComposition SET SequenceComposition = '%s' WHERE EmailUser LIKE '%s' AND IdQuestion LIKE '%s' AND IdExercises LIKE '%s'";
    private $dropUser = "DELETE FROM Users WHERE Email LIKE '%s'";
    private $dropPermission = "DELETE FROM UsersPermission WHERE EmailUsers LIKE '%s'";
    
    public function insert($object) {
        if ($object instanceof Users) { 
            $sql = sprintf($this->insertUser, $object->getEmail(), $object->getName(), $object->getPassword(), $object->getDateBirth()->format('Y-m-d'), $object->getCity(), $object->getCountry(), $object->getType());
            if ($this->runQuery($sql)) {
                if ($object->getPermissions() != null) {
                    $sql = sprintf($this->insertPermission, $this->multiplesInsertsPermission($object->getPermissions(), $object));
                    return $this->runQuery($sql);
                } else {
                    return true;
                }
            } else {
                return $this->runQuery($sql);
            }
        } else {
            throw new ObjectException("it is necessary that the object be of type user");
        }
    }
    
    public function InsertCompositionUser (Exercises $exercise, Users $user) {
        for ($i = 0 ; $i < $exercise->getQuestions()->count() ; $i++) {
            $question = $exercise->getQuestions()->offsetGet($i);
            if ($question instanceof Question) {
                for ($k = 0 ; $k < $question->getCompositionQuestion()->count() ; $k++) {
                    $composition = $question->getCompositionQuestion()->offsetGet($k);
                    if ($composition instanceof CompositionQuestion) {
                        $sql = sprintf($this->insertComposition, $user->getEmail(), $question->getId(), $exercise->getIdExercise(), $composition->getSequence());
                        if (! $this->runQuery($sql)) {
                            $sql = sprintf($this->updateCompostion, $composition->getSequence(), $user->getEmail(), $question->getId(), $exercise->getIdExercise());
                            return $this->runQuery($sql);
                        }
                    }
                }
            }
        }
        return false;
    }
    
    public function insertUploadTasks (Users $user) {
        $uploadTasks = $user->getUploadTasks()->offsetGet(0);
        if ($uploadTasks instanceof UploadTasks) {
            $sql = sprintf($this->insertUploadTasks, $uploadTasks->getIdUploadTasks(), $user->getEmail(), $uploadTasks->getDateSend()->format("Y-m-d H:i:s"), $uploadTasks->getFile()->getLocation(), $uploadTasks->getFile()->getName());
            if (! $this->runQuery($sql)) {
                $sql = sprintf($this->updateUploadTasks, $uploadTasks->getDateSend()->format("Y-m-d H:i:s"), $uploadTasks->getFile()->getLocation(), $uploadTasks->getFile()->getName(), $uploadTasks->getIdUploadTasks(), $user->getEmail());
                return $this->runQuery($sql);
            } else {
                $sql = sprintf($this->insertTasksUser, $uploadTasks->getIdTask(), $user->getEmail());
                return $this->runQuery($sql);
            }
        }
    }
    
    public function updatePercentagemUpdateTasks (Users $user) {
        $uploadTasks = $user->getUploadTasks()->offsetGet(0);
        if ($uploadTasks instanceof UploadTasks) {
            $sql = sprintf($this->updateUploadTasksPercentagem, $uploadTasks->getPercentagem(), $uploadTasks->getIdUploadTasks(), $user->getEmail());
            return $this->runQuery($sql);
        }
    }
    
    protected function multiplesInsertsPermission (ArrayObject $ojects, Users $user) {
        $object = new ArrayObject();
        for ($i = 0 ; $i < $ojects->count() ; $i++) {
            $newArray = $ojects->offsetGet($i);
            if ($newArray instanceof Permission) {
                $newObject[0] = $newArray->getId();
                $newObject[1] = $user->getEmail();
                
                $object->append($newObject);
            }
        }
        return $this->multiplesInserts($object);
    }
    
    public function insertObjet($object) {
        return $this->insert($object);
    }
    
    public function update($object) {
        if ($object instanceof Users) {
            $sql = sprintf($this->update, $object->getName(), $object->getPassword(), $object->getDateBirth()->format('Y-m-d'), $object->getCity(), $object->getCountry(), $object->getEmail());
            return $this->runQuery($sql);
        } else {
            throw new ObjectException("it is necessary that the object be of type user");
        }
    }
    
    public function drop($object) {
        if ($object instanceof Users) {
            $sql = sprintf($this->dropPermission, $object->getEmail());
            if ($this->runQuery($sql)) {
                $sql = sprintf($this->dropUser, $object->getEmail());
                return $this->runQuery($sql);
            } else {
                return $this->runQuery($sql);
            }
        }
    }
    
    protected function getSelect() {
        return $this->select;
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
    
    protected function insertUpload (ArrayObject $array, UploadTasks $uploadTasks) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newUploadTasks = $array->offsetGet($i);
            if ($newUploadTasks instanceof UploadTasks) {
                if ($newUploadTasks->getIdUploadTasks() == $uploadTasks->getIdUploadTasks()) {
                    return $array;
                }
            }
        }
        $array->append($uploadTasks);
        return $array;
    }
    
    protected function insertClasses (ArrayObject $array, Classes $class) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newClass = $array->offsetGet($i);
            if ($newClass instanceof Classes) {
                if ($newClass->getId() == $class->getId()) {
                    return $array;
                }
            }
        }
        $array->append($class);
        return $array;
    }
    
    protected function insertPermission (ArrayObject $array, Permission $permission) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newPermission = $array->offsetGet($i);
            if ($newPermission instanceof Permission) {
                if ($newPermission->getId() == $permission->getId()) {
                    return $array;
                }
            }
        }
        
        $array->append($permission);
        return $array;
    }
    
    protected function InsertObject (ArrayObject $array, Users $users) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newUser = $array->offsetGet($i);
            if ($newUser instanceof Users) {
                if ($newUser->getEmail() == $users->getEmail()) {
                    if ($users->getPermissions() != null && $users->getPermissions()->count() > 0) {
                        $newUser->setPermissions($this->insertPermission($newUser->getPermissions(), $users->getPermissions()->offsetGet(0)));
                    }
                    
                    if ($users->getClasses() != null && $users->getClasses()->count() > 0) {
                        $newUser->setClasses($this->insertClasses($newUser->getClasses(), $users->getClasses()->offsetGet(0)));
                    }
                    
                    if ($users->getExercises() != null && $users->getExercises()->count() > 0) {
                        $newUser->setExercises($this->insertExercises($newUser->getExercises(), $users->getExercises()->offsetGet(0)));
                    }
                    
                    if ($users->getUploadTasks() != null && $users->getUploadTasks()->count() > 0) {
                        $newUser->setUploadTasks($this->insertUpload($newUser->getUploadTasks(), $users->getUploadTasks()->offsetGet(0)));
                    }
                    
                    $array->offsetSet($i, $newUser);
                    return $array;
                }
            }
        }
        $array->append($users);
        return $array;
    }
    
    public function getUserTasks(FilterUsers $filter) {
        $objects = new ArrayObject();
        $sql = sprintf($this->selecTasks, $filter->getWhere(), $filter->getOrder());
        $rs = $this->runSelect($sql);
        
        for ($i = 0 ; $i < count($rs) ; $i++){
            for ($i = 0 ; $i < count($rs) ; $i++){
                $user = new Users();
                
                
                $exercises = new ArrayObject();
                
                $classes = new ArrayObject();
                if (isset($rs[$i]['IdClass']) && $rs[$i]['IdClass'] != null) {
                    $classe = new Classes();
                    $classe->setId($rs[$i]['IdClass']);
                    
                    $classes->append($classe);
                }
                
                $user->setClasses($classes);
                
                
                $permissions = new ArrayObject();
                if (isset($rs[$i]['IdPermission'] ) && $rs[$i]['IdPermission'] != null) {
                    $permission = new Permission();
                    $permission->setId($rs[$i]['IdPermission']);
                    $permission->setIsMenu($rs[$i]['IsMenu']);
                    $permission->setMenu($rs[$i]['Menu']);
                    $permission->setLink($rs[$i]['Link']);
                    
                    $permissions->append($permission);
                }
                
                $user->setPermissions($permissions);
                
                if (isset($rs[$i]['IdExercises']) && $rs[$i]['IdExercises'] != null) {
                    $exercise = new Exercises();
                    $exercise->setIdExercise($rs[$i]['IdExercises']);
                    if ($rs[$i]['IdTasks'] != null) {
                        $exercise->setIdTask($rs[$i]['IdTasks']);
                        $exercise->setPercentagem($rs[$i]['Percentagem']);
                    }
                    
                    $questions = new ArrayObject();
                    $exercise->setQuestions($questions);
                    
                    $exercises->append($exercise);
                }
                $user->setExercises($exercises);
                
                $uploadTasks = new ArrayObject();
                
                if (isset($rs[$i]['IdUploadTasks']) && $rs[$i]['IdUploadTasks'] != null) {
                    $uploadTask = new UploadTasks();
                    $uploadTask->setIdTask($rs[$i]['IdTasks']);
                    $uploadTask->setDateSend(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateSendUploadTasks']));
                    $file = new Files();
                    $file->setLocation($rs[$i]['FileUploadTasks']);
                    $file->setName($rs[$i]['NameFileUploadTasks']);
                    $uploadTask->setFile($file);
                    $uploadTask->setIdUploadTasks($rs[$i]['IdUploadTasks']);
                    $uploadTask->setPercentagem($rs[$i]['Percentagem']);
                    
                    $uploadTasks->append($uploadTask);
                }
                
                $user->setUploadTasks($uploadTasks);
                
                $user->setId($rs[$i]['Id']);
                $user->setEmail($rs[$i]['Email']);
                $user->setName($rs[$i]['Name']);
                $user->setPassword($rs[$i]['Password']);
                $user->setDateBirth(new DateTime($rs[$i]['DateBirth']));
                $user->setCity($rs[$i]['City']);
                $user->setCountry($rs[$i]['Country']);
                $user->setType($rs[$i]['Type']);
                
                $objects = $this->InsertObject($objects, $user);
            }
        }
        return $objects;
    }
    
    public function getUserUploadTasksPointes(FilterUsers $filter) {
        $objects = new ArrayObject();
        $sql = sprintf($this->selectPointes, $filter->getWhere(), $filter->getOrder());
        $rs = $this->runSelect($sql);
        
        for ($i = 0 ; $i < count($rs) ; $i++){
            for ($i = 0 ; $i < count($rs) ; $i++){
                $user = new Users();
                
                
                $exercises = new ArrayObject();
                
                $classes = new ArrayObject();
                if (isset($rs[$i]['IdClass']) && $rs[$i]['IdClass'] != null) {
                    $classe = new Classes();
                    $classe->setId($rs[$i]['IdClass']);
                    
                    $classes->append($classe);
                }
                
                $user->setClasses($classes);
                
                
                $permissions = new ArrayObject();
                if (isset($rs[$i]['IdPermission'] ) && $rs[$i]['IdPermission'] != null) {
                    $permission = new Permission();
                    $permission->setId($rs[$i]['IdPermission']);
                    $permission->setIsMenu($rs[$i]['IsMenu']);
                    $permission->setMenu($rs[$i]['Menu']);
                    $permission->setLink($rs[$i]['Link']);
                    
                    $permissions->append($permission);
                }
                
                $user->setPermissions($permissions);
                
                if (isset($rs[$i]['IdExercises']) && $rs[$i]['IdExercises'] != null) {
                    $exercise = new Exercises();
                    $exercise->setName($rs[$i]['NameExercises']);
                    $exercise->setIdExercise($rs[$i]['IdExercises']);
                    if ($rs[$i]['IdTasks'] != null) {
                        $exercise->setIdTask($rs[$i]['IdTasks']);
                        $exercise->setPercentagem($rs[$i]['Percentagem']);
                        $exercise->setWeightTask($rs[$i]['WeightTask']);
                    }
                    
                    $questions = new ArrayObject();
                    $exercise->setQuestions($questions);
                    
                    $exercises->append($exercise);
                }
                $user->setExercises($exercises);
                
                $uploadTasks = new ArrayObject();
                
                if (isset($rs[$i]['IdUploadTasks']) && $rs[$i]['IdUploadTasks'] != null) {
                    $uploadTask = new UploadTasks();
                    $uploadTask->setIdTask($rs[$i]['IdTasks']);
                    $uploadTask->setName($rs[$i]['NameUploadTasks']);
                    $uploadTask->setIdUploadTasks($rs[$i]['IdUploadTasks']);
                    $uploadTask->setPercentagem($rs[$i]['Percentagem']);
                    $uploadTask->setWeightTask($rs[$i]['WeightTask']);
                    
                    $uploadTasks->append($uploadTask);
                }
                
                $user->setUploadTasks($uploadTasks);
                
                $user->setId($rs[$i]['Id']);
                $user->setEmail($rs[$i]['Email']);
                $user->setName($rs[$i]['Name']);
                $user->setPassword($rs[$i]['Password']);
                $user->setDateBirth(new DateTime($rs[$i]['DateBirth']));
                $user->setCity($rs[$i]['City']);
                $user->setCountry($rs[$i]['Country']);
                $user->setType($rs[$i]['Type']);
                
                $objects = $this->InsertObject($objects, $user);
            }
        }
        return $objects;
    }
    
    public function getUserUploadTasks(FilterUsers $filter) {
        $objects = new ArrayObject();
        $sql = sprintf($this->selectUploadTasksUser, $filter->getWhere(), $filter->getOrder());
        $rs = $this->runSelect($sql);
        
        for ($i = 0 ; $i < count($rs) ; $i++){
            for ($i = 0 ; $i < count($rs) ; $i++){
                $user = new Users();
                
                
                $exercises = new ArrayObject();
                
                $classes = new ArrayObject();
                if (isset($rs[$i]['IdClass']) && $rs[$i]['IdClass'] != null) {
                    $classe = new Classes();
                    $classe->setId($rs[$i]['IdClass']);
                    
                    $classes->append($classe);
                }
                
                $user->setClasses($classes);
                
                
                $permissions = new ArrayObject();
                if (isset($rs[$i]['IdPermission'] ) && $rs[$i]['IdPermission'] != null) {
                    $permission = new Permission();
                    $permission->setId($rs[$i]['IdPermission']);
                    $permission->setIsMenu($rs[$i]['IsMenu']);
                    $permission->setMenu($rs[$i]['Menu']);
                    $permission->setLink($rs[$i]['Link']);
                    
                    $permissions->append($permission);
                }
                
                $user->setPermissions($permissions);
                
                if (isset($rs[$i]['IdExercises']) && $rs[$i]['IdExercises'] != null) {
                    $exercise = new Exercises();
                    $exercise->setIdExercise($rs[$i]['IdExercises']);
                    if ($rs[$i]['IdTasks'] != null) {
                        $exercise->setIdTask($rs[$i]['IdTasks']);
                        $exercise->setPercentagem($rs[$i]['Percentagem']);
                    }
                    
                    $questions = new ArrayObject();
                    $exercise->setQuestions($questions);
                    
                    $exercises->append($exercise);
                }
                $user->setExercises($exercises);
                
                $uploadTasks = new ArrayObject();
                
                if (isset($rs[$i]['IdUploadTasks']) && $rs[$i]['IdUploadTasks'] != null) {
                    $uploadTask = new UploadTasks();
                    $uploadTask->setIdTask($rs[$i]['IdTasks']);
                    $uploadTask->setDateSend(DateTime::createFromFormat("Y-m-d H:i:s", $rs[$i]['DateSendUploadTasks']));
                    $file = new Files();
                    $file->setLocation($rs[$i]['FileUploadTasks']);
                    $file->setName($rs[$i]['NameFileUploadTasks']);
                    $uploadTask->setFile($file);
                    $uploadTask->setIdUploadTasks($rs[$i]['IdUploadTasks']);
                    $uploadTask->setPercentagem($rs[$i]['Percentagem']);
                    
                    $uploadTasks->append($uploadTask);
                }
                
                $user->setUploadTasks($uploadTasks);
                
                $user->setId($rs[$i]['Id']);
                $user->setEmail($rs[$i]['Email']);
                $user->setName($rs[$i]['Name']);
                $user->setPassword($rs[$i]['Password']);
                $user->setDateBirth(new DateTime($rs[$i]['DateBirth']));
                $user->setCity($rs[$i]['City']);
                $user->setCountry($rs[$i]['Country']);
                $user->setType($rs[$i]['Type']);
                
                $objects = $this->InsertObject($objects, $user);
            }
        }
        return $objects;
    }
    
    public function getObjects($filter) {
        $objects = new ArrayObject();
        if ($filter instanceof FilterUsers) {
            $rs = $this->select($filter->getWhere(), $filter->getOrder());
            
            for ($i = 0 ; $i < count($rs) ; $i++){
                $user = new Users();
                $classe = new Classes();
                $permission = new Permission();
                $exercises = new ArrayObject();
                
                $classe->setId($rs[$i]['IdClass']);
                $classes = new ArrayObject();
                $classes->append($classe);
                
                $permission->setId($rs[$i]['IdPermission']);
                $permission->setIsMenu($rs[$i]['IsMenu']);
                $permission->setMenu($rs[$i]['Menu']);
                $permission->setLink($rs[$i]['Link']);
                $permissions = new ArrayObject();
                $permissions->append($permission);
                
                if ($rs[$i]['IdExercisesUser'] != null) {
                    $exercise = new Exercises();
                    $exercise->setIdExercise($rs[$i]['IdExercisesUser']);
                    if ($rs[$i]['IdTasks'] != null) {
                        $exercise->setIdTask($rs[$i]['IdTasks']);
                        $exercise->setPercentagem($rs[$i]['Percentagem']);
                    }
                    
                    $questions = new ArrayObject();
                    if ($rs[$i]['IdQuestionUser'] != null) {
                        $question = new Question();
                        $question->setId($rs[$i]['IdQuestionUser']);
                        
                        $compositions = new ArrayObject();
                        
                        if ($rs[$i]['SequenceCompositionUser'] != null) {
                            $composition = new CompositionQuestion();
                            $composition->setSequence($rs[$i]['SequenceCompositionUser']);
                            
                            $compositions->append($composition);
                        }
                        
                        $question->setCompositionQuestion($compositions);
                        
                        $questions->append($question);
                    }
                    $exercise->setQuestions($questions);
                    
                    $exercises->append($exercise);
                }
                $user->setExercises($exercises);
                
                $user->setClasses($classes);
                $user->setId($rs[$i]['Id']);
                $user->setEmail($rs[$i]['Email']);
                $user->setName($rs[$i]['Name']);
                $user->setPassword($rs[$i]['Password']);
                $user->setDateBirth(new DateTime($rs[$i]['DateBirth']));
                $user->setCity($rs[$i]['City']);
                $user->setCountry($rs[$i]['Country']);
                $user->setPermissions($permissions);
                $user->setType($rs[$i]['Type']);
                
                $objects = $this->InsertObject($objects, $user);
            }
        }
        return $objects;
    }
    
    public function instance($array) {
        
    }
}