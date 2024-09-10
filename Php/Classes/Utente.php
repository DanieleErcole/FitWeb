<?php

    require_once 'EntityController.php';
    require_once 'Debugger.php';

    class Utente {

        public $id;
        public $nome;
        public $cognome;
        public $email;
        public $immagine;
        public $ruolo;

        public function __construct($attrs) {
            $this->id = $attrs["Id"];
            $this->nome = $attrs["Nome"];
            $this->cognome = $attrs["Cognome"];
            $this->email = $attrs["Email"];
            $this->immagine = $attrs["Immagine"];
            $this->ruolo = $attrs["Ruolo"];
        }

        public static function login($email, $myPsw) {
            $controller = new EntityController(array("utente"), "dbObj");
            $error = (empty($email) && empty($myPsw) ? 3 : (empty($email) ? 1 : (empty($myPsw) ? 2 : 0)));
            if($error > 0)
                return;

            $user = $controller->find("'".$email."'", "Email");
            $controller->closeConnection();

            if($user) {
                $error = $myPsw == $user["Password"] ? 0 : 2;
            } else $error = 1;

            return $error == 0 ? new Utente($user) : $error;
        }

        public static function signUp($name, $surname, $email, $psw, $indVia, $indCittà, $indCivico, $indCAP) {
            $controller = new EntityController(array("utente"), "utente");
            $error = (empty($surname) && empty($email) && empty($psw) && empty($name) ? 6 : (empty($name) ? 5 : (empty($surname) ? 4 : (empty($email) ? 3 : (empty($psw) ? 2 : 0)))));
            if($error > 0)
                return $error;

            $emailFound = false;
            $user = $controller->find("'".$email."'", "Email");

            if($user)
                $emailFound = $user->email == $email;
            $controller->closeConnection();

            $error = $emailFound ? 1 : 0;
            if($error == 0) {
                $indID = Utente::getIndID($indVia, $indCittà, $indCivico, $indCAP);
                if(gettype($indID) == "NULL") {
                    $ind = array(
                        "Via" => "'".$indVia."'",
                        "Citta" => "'".$indCittà."'",
                        "Civico" => $indCivico,
                        "CAP" => $indCAP
                    );

                    $indController = new EntityController(array("indirizzo"), "indirizzo");
                    $indController->create($ind);
                    $indController->closeConnection();
                    $indID = Utente::getIndID($indVia, $indCittà, $indCivico, $indCAP);
                }

                $controller = new EntityController(array("utente"), "utente");
                $controller->create(array(
                    "Nome" => "'".$name."'",
                    "Cognome" => "'".$surname."'",
                    "Email" => "'".$email."'",
                    "Password" => "'".$psw."'",
                    "IndirizzoFat" => $indID,
                    "Ruolo" => 3
                ));
                $user = $controller->find("'".$email."'", "Email");
                $controller->closeConnection();
            }
            return $error == 0 ? $user : $error;
        }

        private static function getIndID($indVia, $indCittà, $indCivico, $indCAP) {
            $indController = new EntityController(array("indirizzo"), "dbObj");
            $inds = $indController->findWhere(array(
                "Via = "."'".$indVia."'",
                "Citta = "."'".$indCittà."'",
                "Civico = ".$indCivico,
                "CAP = ".$indCAP), array("AND", "AND", "AND"));
            $indController->closeConnection();
            return count($inds) == 0 ? null : $inds[0]["Id"];
        }

    }

?>
