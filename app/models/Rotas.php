<?php
class Rotas {
	//
	/// Rotas primarias
	//
	
	public static $LOGOFF = "logoff";
	public static $ADMINISTRATORS = "administrators"; //1
	public static $STUDENTS = "students"; //2
	public static $INSTRUCTORS = "instructors"; //3
	public static $COURSES = "courses"; //22
	public static $CLASSES = "classes"; //23
	public static $COURSES_STUDENTS = "coursesStudents"; //36
	public static $COURSES_INSTRUCTOR = "coursesInstructor"; //37
	public static $OPEN_IMG_PERFIL = "openImgPerfil";
	public static $OPEN_IMG = "openImg";
	
	//Códigos Rotas primárias
	
	public static $COD_ADMINISTRATORS = 1; //1
	public static $COD_STUDENTS = 2; //2
	public static $COD_INSTRUCTORS = 3; //3
	public static $COD_COURSES = 22; //22
	public static $COD_CLASSES = 23; //23
	public static $COD_COURSES_STUDENTS = 36; //36
	public static $COD_COURSES_INSTRUCTOR = 37;
	
	
	
	//SubRotas Administrators
	public static $NEW_ADMINISTRATOR = "newAdministrator";
	public static $CREATE_NEW_ADMINISTRATOR = "createNewAdministrator"; //Coloca Administrador no banco de dados
	public static $EDIT_ADMINISTRATOR = "editAdmnistrator";
	public static $VIEW_ADMINISTRATOR = "viewAdministrator";
	public static $DELETE_ADMINISTRATOR = "deleteAdministrator";
	public static $VIEW_EDIT_ADMINISTRATOR = "viewEditAdministrator";
	
	//Códigos SubRotas Administrators
	public static $COD_NEW_ADMINISTRATOR = 4;
	public static $COD_CREATE_NEW_ADMINISTRATOR = 5;
	public static $COD_EDIT_ADMINISTRATOR = 6;
	public static $COD_VIEW_ADMINISTRATOR = 7;
	public static $COD_DELETE_ADMINISTRATOR = 8;
	public static $COD_VIEW_EDIT_ADMINISTRATOR = 9;
	
	//SubRotas Estudantes
	public static $NEW_STUDENT = "newStudent";
	public static $CREATE_NEW_STUDENT = "createNewStudent"; //Coloca estudante no banco de dados
	public static $EDIT_STUDENT = "editStudent";
	public static $VIEW_STUDENT = "viewStudent";
	public static $DELETE_STUDENT = "deleteStudent";
	public static $VIEW_EDIT_STUDENT = "viewEditStudent";
	
	//Códigos SubRotas Estudante
	public static $COD_NEW_STUDENT = 10;
	public static $COD_CREATE_NEW_STUDENT = 11;
	public static $COD_EDIT_STUDENT = 12;
	public static $COD_VIEW_STUDENT = 13;
	public static $COD_DELETE_STUDENT = 14;
	public static $COD_VIEW_EDIT_STUDENT = 15;
	
	//SubRotas Instrutor
	public static $NEW_INSTRUCTOR = "newInstructor";
	public static $CREATE_NEW_INSTRUCTOR = "createNewInstructor"; //Coloca instrutor no banco de dados
	public static $EDIT_INSTRUCTOR = "editInstructor";
	public static $VIEW_INSTRUCTOR = "viewInstructor";
	public static $DELETE_INSTRUCTOR = "deleteInstructor";
	public static $VIEW_EDIT_INSTRUCTOR = "viewEditInstructor";
	
	//Códigos SubRotas Instrutor
	public static $COD_NEW_INSTRUCTOR = 16;
	public static $COD_CREATE_NEW_INSTRUCTOR = 17;
	public static $COD_EDIT_INSTRUCTOR = 18;
	public static $COD_VIEW_INSTRUCTOR = 19;
	public static $COD_DELETE_INSTRUCTOR = 20;
	public static $COD_VIEW_EDIT_INSTRUCTOR = 21;
	
	
	//SubRotas Turmas
	public static $NEW_CLASS = "newClass";
	public static $CREATE_NEW_CLASS = "createNewClass"; //Coloca turma no banco de dados
	public static $EDIT_CLASS = "editClass";
	public static $VIEW_CLASS = "viewClass";
	public static $DELETE_CLASS = "deleteClass";
	public static $VIEW_EDIT_CLASS = "viewEditClass";
	
	//Códigos SubRotas Turmas
	public static $COD_NEW_CLASS = 24;
	public static $COD_CREATE_NEW_CLASS = 25;
	public static $COD_EDIT_CLASS = 26;
	public static $COD_VIEW_CLASS = 27;
	public static $COD_DELETE_CLASS = 28;
	public static $COD_VIEW_EDIT_CLASS = 29;
	
	
	//SubRotas Cursos
	public static $NEW_COURSE = "newCourse";
	public static $CREATE_NEW_COURSE = "createNewCourse"; //Coloca o curso no banco de dados
	public static $EDIT_COURSE = "editCourse";
	public static $VIEW_COURSE = "viewCourse";
	public static $DELETE_COURSE = "deleteCourse";
	public static $VIEW_EDIT_COURSE = "viewEditCourse";
	
	//Códigos SubRotas Cursos
	public static $COD_NEW_COURSE = 30;
	public static $COD_CREATE_NEW_COURSE = 31;
	public static $COD_EDIT_COURSE = 32;
	public static $COD_VIEW_COURSE = 33;
	public static $COD_DELETE_COURSE = 34;
	public static $COD_VIEW_EDIT_COURSE = 35;
	
	//SubRotas Cursos Students
	public static $REGISTERED_COURSE = "registeredCourse";
	public static $OPEN_COURSE = "openCourse";
	public static $VIEW_NEWS_COURSE = "viewNewsCourse";
	public static $VIEW_FILES_COURSE = "viewFilesCourse";
	public static $VIEW_FORUNS_COURSE = "viewForunsCourse";
	public static $VIEW_TASKS_COURSE = "viewTasksCourse";
	public static $VIEW_CLASSES_COURSE = "viewClassesCourse";
	public static $VIEW_LIVE_CLASSES_COURSE = "viewLiveClassesCourse";
	public static $ADD_TIME_COURSE = "addTimeCourse";
	public static $DOWNLOAD_FILE_COURSE = "downloadFileCourse";
	public static $EDIT_FILES_COURSE = "editFilesCourse";
	public static $UPLOAD_FILES_COURSE = "uploadFilesCourse";
	public static $DELETE_FORUM = "deleteForum";
	public static $OPEN_FORUM = "openForum";
	public static $ANSWER_FORUM = "answerForum";
	public static $VIEW_CREATE_FORUM = "viewCreateForum";
	public static $CREATE_NEW_FORUM = 'createNewForum';
	public static $VIEW_ALL_EXERCISES = "viewAllExercises";
	public static $VIEW_CREATE_EXERCISES = "viewCreateExercises";
	public static $CREATE_NEW_EXERCISES = "createNewExercises";
	public static $OPEN_EXERCISE_INSTRUCTOR = "openExerciseInstructor";
	public static $INSERT_IMAGE = "insertImage";
	public static $INSERT_QUESTION = "insertQuestion";
	public static $SET_NEW_QUESTION = "setNewQuestion";
	
	//SubRotas Cursos Instrutor
	public static $COD_OPEN_COURSE = 38;
	public static $COD_VIEW_NEWS_COURSE = 39;
	public static $COD_VIEW_FILES_COURSE = 40;
	public static $COD_VIEW_FORUNS_COURSE = 41;
	public static $COD_VIEW_TASKS_COURSE = 42;
	public static $COD_VIEW_CLASSES_COURSE = 43;
	public static $COD_VIEW_LIVE_CLASSES_COURSE = 44;
	public static $COD_DOWNLOAD_FILE_COURSE = 45;
	
	
}