<?php

$requiresCA[] = 'app/models/exceptions/LoginException.php';
$requiresCA[] = 'app/models/users/Users.php';
$requiresCA[] = 'app/dao/FilterUsers.php';
$requiresCA[] = 'app/dao/FilterUsers.php';
$requiresCA[] = 'app/dao/UsersDAO.php';

for ($i = 0 ; $i < count($requiresCA) ; $i++) {
    while (!file_exists($requiresCA[$i])) {
        $requiresCA[$i] = '../' . $requiresCA[$i];
    }
    require_once $requiresCA[$i];
}

class ControlAccess {
	private $user;
	
	public function startSession() {
		session_start();
		$email = null;
		$pass = null;
		
		if (isset($_POST['email'])){
			$email = $_REQUEST['email'];
			$pass = hash('sha512', $_REQUEST['pass']);
		} else {
			if (isset($_SESSION['email'])) {
				$email = $_SESSION['email'];
				$pass = $_SESSION['pass'];
			}
		}
		
		$user = $this->autenticaUsuario($email, $pass);
		
		if ($email != null && $user->count() <= 0) {
		    throw new LoginException("Contraseña no válida");
		} 
		
		if (isset($_POST['email'])) {
			$_SESSION['email'] = $_REQUEST['email'];
			$_SESSION['pass'] = hash('sha512', $_REQUEST['pass']);
		}
		if ($email == null) {
			throw new LoginException("");
		}
		
		return $user->offsetGet(0);
	}
	
	public function autenticaUsuario($email, $pass) {
		if ($email != null) {
			$usersDAO = new UsersDAO();
			$users = new Users();
			$users->setEmail($email);
			$users->setPassword($pass);
			
			$filter = new FilterUsers($users);
			$filter->setOrder("ORDER BY Menu");
			
			$user = $usersDAO->getObjects($filter);
			
			return $user;
			
		}
		return null;
	}
}