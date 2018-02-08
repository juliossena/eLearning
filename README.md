# eLearning
Plataforma de aprendizado online (Online learning platform)

Primeiro usuário criado: administrator
senha usuário criado: 123mudar

Código Banco de Dados:




create table Users (
	Id int not null AUTO_INCREMENT,
	Email varchar(100) not null,
    Name varchar(100) not null,
    Password varchar(128) not null,
    DateBirth date not null,
    City varchar(100),
    Country varchar(100),
    Type int not null,
    Unique (Id),
    primary key (Email)
) ENGINE=innodb; 



create table Class (
	Id int not null auto_increment,
    Name varchar(100),
	Description varchar(100),
    primary key (id)

) ENGINE = innodb;

create table UsersClass (
	IdClass int not null,
    EmailUsers varchar(100) not null,
    primary key (IdClass, EmailUsers),
    foreign key (IdClass) references Class(Id),
    foreign key (EmailUsers) references Users(Email)
    
) ENGINE = innodb;

create table Permission (
	Id int not null auto_increment,
    Name varchar(100) not null,
    Description varchar(100),
    IsMenu boolean not null,
    Menu varchar(100),
    Link varchar(100),
    primary key (Id)
    
) ENGINE = innodb;

create table UsersPermission (
	IdPermission int not null,
    EmailUsers varchar(100) not null,
    primary key (IdPermission, EmailUsers),
    foreign key (IdPermission) references Permission(Id),
    foreign key (EmailUsers) references Users(Email)
) ENGINE = innodb;

create table Courses (
	Id int not null auto_increment,
    Name varchar(100) not null,
    Description varchar(100),
    DateNew timestamp,
    DateFinish timestamp,
    Information text,
    Instructor varchar(100) not null,
    Password varchar(128),
    CertifiedPercentage float not null,
    MinimumTime time,
    primary key (Id),
    foreign key (Instructor) references Users(Email)
) engine = innodb;

create table Files (
	Id int not null auto_increment,
    Name varchar(128) not null,
    Link varchar(128) not null,
	IdCourses int not null,
    Thumbnail varchar(128),
    primary key (Id),
    foreign key (IdCourses) references Courses(Id)
) engine = innodb;


create table Forum (
	Id int not null auto_increment,
    UserCreate varchar(100) not null,
    IdCourses int not null,
    DateCreate timestamp not null,
    Title varchar(128) not null,
    primary key (Id),
    foreign key (IdCourses) references Courses(Id),
    foreign key (UserCreate) references Users(Email)
) engine = innodb;

create table Answer (
	Id int not null auto_increment,
    UserCreate varchar(100) not null,
    Answer text not null,
    DateCreate timestamp not null,
    IdForum int not null,
    primary key (Id),
    foreign key (UserCreate) references Users(Email),
    foreign key (IdForum) references Forum(Id)
) engine = innodb;

create table Tasks (
	Id int not null auto_increment,
    IdCourses int not null,
    WeightTask int not null,
    primary key (Id),
    foreign key (IdCourses) references Courses(Id)
) engine = innodb;

create table CoursesAvailableClass (
	IdCourse int not null,
    IdClass int not null,
    primary key (IdCourse, IdClass),
    foreign key (IdCourse) references Courses(Id),
    foreign key (IdClass) references Class(Id)
) engine = innodb;

create table CoursesAvailableUser (
	IdCourse int not null,
    EmailUser varchar(100) not null,
    primary key (IdCourse, EmailUser),
    foreign key (IdCourse) references Courses(Id),
    foreign key (EmailUser) references Users(Email)
) engine = innodb;

create table CoursesRegisteredUser (
	IdCourse int not null,
    EmailUser varchar(100) not null,
    TimeElapse time not null,
    Token varchar(128),
    primary key (IdCourse, EmailUser),
    foreign key (IdCourse) references Courses(Id),
    foreign key (EmailUser) references Users(Email)
) engine = innodb;

create table CoursesConfigUser (
	IdCourse int not null,
    EmailUser varchar(100) not null,
    ElapsedTime time,
    ReceiveEmail boolean,
    primary key (IdCourse, EmailUser),
    foreign key (IdCourse) references Courses(Id),
    foreign key (EmailUser) references Users(Email)
) engine = innodb;

create table TasksUsers (
	IdTasks int not null,
    EmailUser varchar(100) not null,
    Percentagem float not null,
    primary key (IdTasks, EmailUser),
    foreign key (IdTasks) references Tasks(Id),
    foreign key (EmailUser) references Users(Email)
) engine = innodb;

create table NewsCourses (
	Id int not null auto_increment,
	IdCourse int not null,
    EmailUser varchar(100) not null,
    NameUser varchar(100) not null,
    Type int not null,
    ChangeCourse varchar (128),
    TimeChange timestamp,
    primary key (Id),
    foreign key (IdCourse) references Courses(Id),
    foreign key (EmailUser) references Users(Email)
) engine = innodb;

create table Exercises (
	Id int not null auto_increment,
    Name varchar(128) not null,
    DateLimite timestamp,
    Released boolean not null,
    IdTasks int not null,
    foreign key (IdTasks) references Tasks(Id),
    primary key (Id)
) engine = innodb;

create table Question (
	Id int not null auto_increment,
    Difficulty int not null,
    Sequence int,
    IdExercises int not null,
    primary key (Id),
    foreign key (IdExercises) references Exercises(Id)
) engine = innodb;

create table CompositionQuestion (
	IdQuestion int not null,
    Sequence int not null,
    Type int not null,
    Answer boolean,
    Text text,
    Link varchar(256),
    primary key (IdQuestion, Sequence),
    foreign key (IdQuestion) references Question (Id)
) engine = innodb;

create table UserComposition (
	EmailUser varchar(128) not null,
    IdQuestion int not null,
    IdExercises int not null,
    SequenceComposition int not null,
    primary key (EmailUser, IdQuestion, IdExercises),
    foreign key (EmailUser) references Users (Email),
    foreign key (IdQuestion) references Question (Id),
    foreign key (IdExercises) references Exercises(Id)
) engine = innodb;

create table UploadTasks (
	Id Int Not null Auto_increment,
    IdTasks Int Not null,
    Name Varchar (128) not null,
    DateFinish Timestamp,
    DaysDelay Int not null,
    Primary Key (Id),
    Foreign Key (IdTasks) references Tasks(Id)
) engine = innodb;

create table UploadTasksUser (
	IdUploadTasks Int not null,
    EmailUser varchar(100) not null,
    DateSend Timestamp not null,
    File Varchar(128) not null,
    Percentagem float,
    Primary Key (IdUploadTasks, EmailUser),
    Foreign Key (IdUploadTasks) references UploadTasks(Id),
    Foreign Key (EmailUser) references Users(Email)
) engine = innodb;


delimiter |
CREATE TRIGGER InsertFiles AFTER INSERT ON Files
FOR EACH ROW
BEGIN
	DECLARE idCourse int;
    DECLARE nameFile varchar(128);
    DECLARE emailInstructor varchar(128);
    DECLARE nameInstructor varchar(128);
    SET idCourse = NEW.IdCourses;
	SET nameFile = CONCAT ('<strong>' ,NEW.Name , '</strong> se ha insertado para descargar en archivos');
    SET emailInstructor = (SELECT Instructor FROM Courses WHERE Id LIKE idCourse);
    SET nameInstructor = (SELECT Name From Users WHERE Email LIKE emailInstructor);
    BEGIN
		INSERT INTO NewsCourses (IdCourse, EmailUser, NameUser, Type, ChangeCourse, TimeChange) VALUES (idCourse, emailInstructor, nameInstructor, 1, nameFile, NOW());
	END;
END;
|

delimiter ;


delimiter |
CREATE TRIGGER InsertForuns AFTER INSERT ON Forum
FOR EACH ROW
BEGIN
	DECLARE idForum int;
    DECLARE idCourse int;
    DECLARE nameForum varchar(128);
    DECLARE emailUser varchar(128);
    DECLARE NameUser varchar(128);
    SET idForum = NEW.Id;
    SET idCourse = NEW.IdCourses;
	SET nameForum = CONCAT (' Se ha creado el foro <strong>', NEW.Title, '</strong>');
    SET emailUser = (SELECT UserCreate FROM Forum WHERE Id LIKE idForum);
    SET nameUser = (SELECT Name From Users WHERE Email LIKE emailUser);
    BEGIN
		INSERT INTO NewsCourses (IdCourse, EmailUser, NameUser, Type, ChangeCourse, TimeChange) VALUES (idCourse, emailUser, nameUser, 1, nameForum, NOW());
	END;
END;
|

delimiter ;

INSERT INTO Permission (`Id`, `Name`, `Description`, `IsMenu`, `Menu`, `Link`) VALUES
(1, 'Instructores', 'Menú de creación de instructores', 1, 'Instructores', 'instructors'),
(2, 'Estudiante', NULL, 1, 'Estudiante', 'students'),
(3, 'Administradores', NULL, 1, 'Admins', 'administrators'),
(4, 'New Administrator', NULL, 0, NULL, NULL),
(5, 'Create New Administrator', NULL, 0, NULL, NULL),
(6, 'Edit Administrator', NULL, 0, NULL, NULL),
(7, 'View Administrator', NULL, 0, NULL, NULL),
(8, 'Delete Administrator', NULL, 0, NULL, NULL),
(9, 'View Edit Administrator', NULL, 0, NULL, NULL),
(10, 'New Student', NULL, 0, NULL, NULL),
(11, 'Create Student', NULL, 0, NULL, NULL),
(12, 'Edit Student', NULL, 0, NULL, NULL),
(13, 'view Student', NULL, 0, NULL, NULL),
(14, 'Delete Student', NULL, 0, NULL, NULL),
(15, 'View Edit Student', NULL, 0, NULL, NULL),
(16, 'New Instructor', NULL, 0, NULL, NULL),
(17, 'Create New Instructor', NULL, 0, NULL, NULL),
(18, 'Edit Instructor', NULL, 0, NULL, NULL),
(19, 'View Instructor', NULL, 0, NULL, NULL),
(20, 'Delete Instructor', NULL, 0, NULL, NULL),
(21, 'View Edit Instructor', NULL, 0, NULL, NULL),
(22, 'Courses', NULL, 1, 'Cursos', 'courses'),
(23, 'Classes', NULL, 1, 'Clases', 'classes'),
(24, 'New Class', NULL, 0, NULL, NULL),
(25, 'Create New Class', NULL, 0, NULL, NULL),
(26, 'Edit Class', NULL, 0, NULL, NULL),
(27, 'View Class', NULL, 0, NULL, NULL),
(28, 'Delete Class', NULL, 0, NULL, NULL),
(29, 'Edit Class', NULL, 0, NULL, NULL),
(30, 'New Course', NULL, 0, NULL, NULL),
(31, 'Create New Course', NULL, 0, NULL, NULL),
(32, 'Edit Course', NULL, 0, NULL, NULL),
(33, 'View Course', NULL, 0, NULL, NULL),
(34, 'Delete Course', NULL, 0, NULL, NULL),
(35, 'View Edit Course', NULL, 0, NULL, NULL),
(36, 'Menu Estudiante', NULL, 1, 'Cursos', 'coursesStudents'),
(37, 'Cursos', 'Cursos Instrutor', 1, 'Cursos', 'coursesInstructor'),
(38, 'Open Course Instructor', NULL, 0, NULL, NULL),
(39, 'View News Course', NULL, 0, NULL, NULL),
(40, 'View Files Course', NULL, 0, NULL, NULL),
(41, 'View Foruns Course', NULL, 0, NULL, NULL),
(42, 'View Tasks Course', NULL, 0, NULL, NULL),
(43, 'View Classes Instructor', NULL, 0, NULL, NULL),
(44, 'View Live Classes Instructor', NULL, 0, NULL, NULL),
(45, 'Download File Instructor', NULL, 0, NULL, NULL);
INSERT INTO Users (Email, Name, Password, DateBirth, City, Country, Type) VALUES ('administrator', 'Administrator', '93f4a4e86cf842f2a03cd2eedbcd3c72325d6833fa991b895be40204be651427652c78b9cdbdef7c01f80a0acb58f791c36d49fbaa5738970e83772cea18eba1', '2018-01-01', 'Belo Horizonte', 'Brasil', '1');
INSERT INTO UsersPermission (IdPermission, EmailUsers) VALUES ('1', 'administrator'), ('2', 'administrator'), ('3', 'administrator'), ('4', 'administrator'), ('5', 'administrator'), ('6', 'administrator'), ('7', 'administrator'), ('8', 'administrator'), ('9', 'administrator'), ('10', 'administrator'), ('11', 'administrator'), ('12', 'administrator'), ('13', 'administrator'), ('14', 'administrator'), ('15', 'administrator'), ('16', 'administrator'), ('17', 'administrator'), ('18', 'administrator'), ('19', 'administrator'), ('20', 'administrator'), ('21', 'administrator'), ('22', 'administrator'), ('23', 'administrator'), ('24', 'administrator'), ('25', 'administrator'), ('26', 'administrator'), ('27', 'administrator'), ('28', 'administrator'), ('29', 'administrator'), ('30', 'administrator'), ('31', 'administrator'), ('32', 'administrator'), ('33', 'administrator'), ('34', 'administrator'), ('35', 'administrator');
