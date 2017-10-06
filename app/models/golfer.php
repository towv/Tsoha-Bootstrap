<?php

/*
 * Malli. Mallintaa Golffari-oliota eli käyttäjää.
 */

class Golfer extends BaseModel {
    /*
     * id = uniikki tunnus, name = nimi/nimimerkki, password = salasana, 
     * joined = liittymispäivämäärä, holeinone = boolean arvo, joka kertoo onko käyttäjällä holaria
     */

    public $id, $name, $password, $joined, $holeinone;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_password');
        $this->joined = substr($this->joined, 0, 10);
    }

    /*
     * Palauttaa kaikki Golffarit tietokannasta listana.
     */

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Golffari');

        $query->execute();

        $rows = $query->fetchAll();
        $golfers = array();

        foreach ($rows as $row) {
            $golfers[] = new Golfer(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'password' => $row['salasana'],
                'joined' => $row['luotu'],
                'holeinone' => $row['holari']
            ));
        }

        return $golfers;
    }

    /*
     * Palauttaa Golffari-olion, jonka tunnus on parametrina saatu tunnus, tai null jos tunnusta ei löydy tietokannasta
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Golffari WHERE id = :id LIMIT 1');

        $query->execute(array('id' => $id));

        $row = $query->fetch();

        if ($row) {
            $golfer = new Golfer(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'password' => $row['salasana'],
                'joined' => $row['luotu'],
                'holeinone' => $row['holari']
            ));
            return $golfer;
        }
        return null;
    }

    /*
     * Hakee golffarit, parametrina jasenliitos -taulusta saatu lista jasenia
     */

    public static function getMembers($members) {
        $golfers = array();
        require_once 'app/models/member.php';

        foreach ($members as $member) {
            $query = DB::connection()->prepare('SELECT * FROM Golffari WHERE id = :id');
            $query->execute(array('id' => $member->golfer));

            $row = $query->fetch();

            $golfer = new Golfer(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'password' => $row['salasana'],
                'joined' => $row['luotu'],
                'holeinone' => $row['holari']
            ));

            $golfers[] = $golfer;
        }
        return $golfers;
    }

    /*
     * Hakee golffarit, jotka kuuluvat joukkueeseen, jonka tunniste on parametrina saatu id
     */

    public static function getTeam($id) {
        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos JOIN Golffari ON golffari.id = jasenliitos.pelaajaid WHERE Jasenliitos.joukkueid = :id');
        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();

        $golfers = array();

        foreach ($rows as $row) {
            $golfers[] = new Golfer(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'password' => $row['salasana'],
                'joined' => $row['luotu'],
                'holeinone' => $row['holari']
            ));
        }

        return $golfers;
    }

    /*
     * Tallentaa uuden käyttäjän/golffarin tietokantaan
     */

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Golffari(nimi, salasana) VALUES (:name, :password) RETURNING id');

        $query->execute(array(
            'name' => $this->name,
            'password' => $this->password
        ));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    /*
     * Merkitsee golffarin holari-arvoksi TRUE
     */

    public static function updateHoleinoneTrue($id) {

        $query = DB::connection()->prepare('UPDATE Golffari SET holari = :holari WHERE id = :id');

        $query->execute(array(
            'id' => $id,
            'holari' => TRUE
        ));
    }

    /*
     * Tarkastetaan löytyykö tietokannasta käyttäjä/golffari tällä nimellä ja salasanalla
     */

    public static function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Golffari WHERE nimi = :name AND salasana = :password LIMIT 1');

        $query->execute(array(
            'name' => $name,
            'password' => $password
        ));

        $row = $query->fetch();
        if ($row) {
            $golfer = new Golfer(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'password' => $row['salasana'],
                'joined' => $row['luotu'],
                'holeinone' => $row['holari']
            ));
            return $golfer;
        } else {
            return null;
        }
    }

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Nimi on pakollinen';
        }
        if (strlen($this->name) > 20) {
            $errors[] = 'Nimen maksimipituus on 20 merkkiä';
        }
        return $errors;
    }

    public function validate_password() {
        $errors = array();
        if ($this->password == '' || $this->password == null) {
            $errors[] = 'Salasana on pakollinen';
        }
        if (strlen($this->name) > 20) {
            $errors[] = 'Salasanan maksimipituus on 20 merkkiä';
        }
        return $errors;
    }

}
