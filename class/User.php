<?php
require_once("./include/bdd.php");

session_start();

class User
{
    public $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;

    // CONSTRUCTOR
    public function __construct($id, $login, $password, $email, $firstname, $lastname)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    // GET
    public function getLogin()
    {
        return $this->login;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    // __________________________________ //

    // SET
    public function setLogin($login)
    {
        $this->login = $login;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    // ___________________________________ //

    // FUNCTION

    // VERIFY
    public function verify_password()
    {
        if ($_POST['password'] == $_POST['password_confirm']) {
            return true;
        } else {
            return false;
        }
    }

    public function verify_empty()
    {
        if (empty($_POST['login']) || empty($_POST['email']) || empty($_POST['firstname']) || empty($_POST['lastname'])) {
            return false;
        } else {
            return true;
        }
    }

    public function verify_login($bdd)
    {
        $login = htmlspecialchars($_POST['login']);
        $recupUser = $bdd->prepare("SELECT * FROM users WHERE login = ?");
        $recupUser->execute([$login]);
        if ($recupUser->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    // ---------------------------------------------- //

    // OTHER FUNCTION
    public function register($bdd)
    {
        if ($this->verify_login($bdd) == true && $this->verify_empty() == true && $this->verify_password() == true) {
            $register = $bdd->prepare("INSERT INTO `users` (`login` , `password`, `email` , `firstname` , `lastname`) VALUES (?, ? , ?, ? ,?);");
            $register->execute([$this->login, $this->password, $this->email, $this->firstname, $this->lastname]);
        } else {
            return false;
        }
    }

    public function connect($bdd)
    {
        $connect = $bdd->prepare("SELECT * FROM users WHERE login = ? AND password = ? ");
        $connect->execute([$this->login, $this->password]);
        $result = $connect->fetch(PDO::FETCH_ASSOC);
        if ($result != false) {
            $this->id = $result['id'];
            $this->login = $result['login'];
            $this->password = $result['password'];
            $this->email = $result['email'];
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $_SESSION['user'] = $this;
        }
    }

    public function disconnect()
    {
        unset($_SESSION['user']);
        var_dump($_SESSION);
    }

    public function isConnected()
    {
        if (isset($_SESSION['user'])) {
            echo "--connected--";
            return true;
        } else {
            echo "--disconnect--";
            return false;
        }
    }
    public function Update($bdd)
    {
        if ($this->verify_empty($bdd) == true && $this->verify_password($bdd) == true) {
            $update = $bdd->prepare("UPDATE users SET login = ?, password = ?, email = ?, firstname = ?, lastname = ? WHERE users.id = ? ");
            $update->execute([$this->login, $this->password, $this->email, $this->firstname, $this->lastname, $this->id]);
        } else {
            return false;
        }
    }
}
