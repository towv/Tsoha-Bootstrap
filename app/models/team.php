<?php

/*
 * Malli. Mallintaa Joukkue-oliota.
 */

class Team extends BaseModel {
    /*
     * id = uniikki id, name = joukkueen nimi, description = joukkueen kuvaus,
     * created = luontipäivämäärä
     */

    public $id, $name, $description, $created;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->created = substr($this->created, 0, 10);
        $this->validators = array('validate_name', 'validate_description');
    }

    /*
     * Palauttaa kaikki Joukkueet tietokannasta listana.
     */

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Joukkue');

        $query->execute();

        $rows = $query->fetchAll();

        $teams = array();

        foreach ($rows as $row) {
            $teams[] = new Team(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'description' => $row['kuvaus'],
                'created' => $row['luotu']
            ));
        }

        return $teams;
    }

    /*
     * Palauttaa kaikki Joukkueet tietokannasta listana.
     * Lisää näihin tiedon jäsenten määrästä käyttäen avuksi Jasen -mallia.
     */

    public static function allWamountOmembers() {
        include_once 'app/models/member.php';
        $teams = self::all();
        $teamsWmembers = array();

        foreach ($teams as $row) {
            $teamsWmembers[] = array(
                'id' => $row->id,
                'name' => $row->name,
                'description' => $row->description,
                'created' => $row->created,
                'members' => count(Member::findMembersWteam($row->id), 0)
            );
        }
        return $teamsWmembers;
    }

    /*
     * Palauttaa Joukkue -olion, jonka tunnus on parametrina saatu tunnus, tai null jos tunnusta ei löydy tietokannasta
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Joukkue WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));

        $row = $query->fetch();

        if ($row) {
            $team = new Team(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'description' => $row['kuvaus'],
                'created' => $row['luotu']
            ));
            return $team;
        }

        return null;
    }

    /*
     * Tallentaa joukkueen tietokantaan.
     */

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Joukkue (nimi, kuvaus) VALUES (:name, :description) RETURNING id');

        $query->execute(array('name' => $this->name, 'description' => $this->description));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    /*
     * Päivittää tietokannassa olevan joukkueen nimen ja kuvauksen.
     */

    public function update() {
        $query = DB::connection()->prepare('UPDATE Joukkue SET nimi = :name, kuvaus = :description WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'description' => $this->description));
    }

    /*
     * Poistaa joukkueen tietokannasta.
     */

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Joukkue WHERE id = :id');
        $query->execute(array('id' => $this->id));
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

    public function validate_description() {
        $errors = array();
        if (strlen($this->description) > 300) {
            $errors[] = 'Kuvauksen maksimipituus on 300 merkkiä';
        }
        return $errors;
    }

    public function validate_connections() {
        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos WHERE joukkueid = :joukkue');
        $query->execute(array('joukkue' => $this->id));
        $rows = $query->fetchAll();
        $errors = array();
        if (count($rows) > 0) {
            $errors[] = $this->name . ' joukkueeseen kuuluu ' . count($rows) . ' pelaajaa, eikä sitä siksi voi poistaa.';
        }
        return $errors;
    }

}
