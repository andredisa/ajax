<?php
class GestioneUtenti
{
    public $mysqli;

    /**
     * costruttore
     */
    public function __construct()
    {
        $this->mysqli = new mysqli("localhost", "root", "", "preverifica");
    }

    /**
     * Controlla che le credenziali inserite siano esistenti
     */
    public function checkCredentials($username, $password)
    {
        $userID = 0;
        $query = $this->mysqli->prepare("SELECT ID FROM utente WHERE username=? AND password=?");
        $password = md5($password);
        $query->bind_param("ss", $username, $password);
        $query->execute();
        $query->bind_result($userID);
        $query->fetch();
        $query->close();
        if (!empty($userID)) {
            return $userID;
        }

        return 0;
    }

    /**
     * Aggiunge user al DB
     */
    public function addUser($username, $password)
    {
        $query = $this->mysqli->prepare("INSERT INTO utente (username, password) VALUES (?, ?)");
        $password = md5($password);
        $query->bind_param("ss", $username, $password);
        $query->execute();
        $query->close();
    }
}
