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
    public $tel;

    // CONSTRUCTOR
    public function __construct($id, $login, $password, $email, $firstname, $lastname, $tel)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->tel = $tel;
    }

    // GET
    public function getId()
    {
        return $this->id;
    }


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
    public function getTel()
    {
        return $this->tel;
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
    public function setTel($tel)
    {
        $this->tel = $tel;
    }
    // ___________________________________ //

    // FUNCTION
    public function findAddress($bdd)
    {
        $id = $_SESSION['user']->id;
        $recupAddress = $bdd->prepare("SELECT * FROM address WHERE id_user = ?");
        $recupAddress->execute([$id]);
        if ($recupAddress->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function principalResidence($bdd)
    {

        $id = $_SESSION['user']->id;
        // Si une addresse est trouvé:
        if ($this->findAddress($bdd) == true) {
            $recupAddressPR = $bdd->prepare("SELECT * FROM address WHERE id_user = ? AND PR = 1 ;");
            $recupAddressPR->execute([$id]);
            // Si une addresse principal est trouvé:
            if ($recupAddressPR->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAddressPrincipal($bdd)
    {
        if ($this->principalResidence($bdd) == true) {
            $id = $_SESSION['user']->id;
            $recupAddressPR = $bdd->prepare("SELECT * FROM address WHERE id_user = ? AND PR = 1");
            $recupAddressPR->execute([$id]);
            $resultAddressPR = $recupAddressPR->fetch(PDO::FETCH_ASSOC);
            return $resultAddressPR;
        } else {
            return true;
        }
    }

    public function getAddressSecondary($bdd)
    {
        if ($this->findAddress($bdd) == true) {
            $id = $_SESSION['user']->id;
            $recupAddress = $bdd->prepare("SELECT * FROM address WHERE id_user = ? AND PR = 0");
            $recupAddress->execute([$id]);
            $resultAddress = $recupAddress->fetchAll(PDO::FETCH_ASSOC);
            return $resultAddress;
        } else {
            return true;
        }
    }
    public function deleteAddress($bdd)
    {
        // Supprimer l'addresse dans la base de données
        $delete = $bdd->prepare("DELETE FROM address WHERE `id` = ?");
        $delete->execute([$_POST['deleteaddress']]);
    }

    public function registerAddress($bdd)
    {
        // Si la résidence principal a pas été coché alors automatiquement la valeur par défault est 0
        if (isset($_POST['rp'])) {
            $rp = htmlspecialchars($_POST['rp']);
        } else {
            $rp = 0;
        }
        $name = htmlspecialchars($_POST['name']);
        $street = htmlspecialchars($_POST['street']);
        $city = htmlspecialchars($_POST['city']);
        $zip = htmlspecialchars($_POST['zip']);

        // Si une résidence principal est deja existante alors la valeur par défault est 0 a "PR"
        if ($this->principalResidence($bdd) == true) {
            $address = $bdd->prepare("INSERT INTO `address` (`id_user` , name_address , `PR`, `street`, `city`, `postal_code`, `country`) VALUES (?, ?, ?, ?, ?, ?, ?);");
            $address->execute([$_SESSION['user']->id, $name, "0", $street, $city, $zip, "France"]);
        } else {
            $address = $bdd->prepare("INSERT INTO `address` (`id_user` , name_address , `PR`, `street`, `city`, `postal_code`, `country`) VALUES (?, ?, ?, ?, ?, ?, ?);");
            $address->execute([$_SESSION['user']->id, $name, $rp, $street, $city, $zip, "France"]);
        }

        header("Location: ./cart.php#delivery");
    }


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
        if (empty($_POST['login']) || empty($_POST['email']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['tel'])) {
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
            $register = $bdd->prepare("INSERT INTO `users` (`login` , `password`, `email` , `firstname` , `lastname`, `tel`) VALUES (?, ? , ?, ? ,?, ?);");
            $register->execute([$this->login, $this->password, $this->email, $this->firstname, $this->lastname, $this->tel]);
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
            $this->tel = $result['tel'];
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
