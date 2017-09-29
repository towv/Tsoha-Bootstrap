<?php

class Team extends BaseModel {

    public $id, $name, $description, $created;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->created = substr($this->created, 0, 10);
        $this->validators = array('validate_name', 'validate_description');
    }

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

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Joukkue WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));

        $row = $query->fetch();

        if ($row) {
            $team[] = new Team(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'description' => $row['kuvaus'],
                'created' => $row['luotu']
            ));
            return $team;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Joukkue (nimi, kuvaus) VALUES (:name, :description) RETURNING id');

        $query->execute(array('name' => $this->name, 'description' => $this->description));

        $row = $query->fetch();

        $this->id = $row['id'];
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

}
