<?php

class Golfer extends BaseModel {

    public $id, $name, $password, $joined, $holeinone;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_password');
    }

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

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Golffari WHERE id = :id LIMIT 1');

        $query->execute(array('id' => $id));

        $row = $query->fetch();

        if ($row) {
            $golfer[] = new Golfer(array(
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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Golffari(nimi, salasana) VALUES (:name, :password) RETURNING id');

        $query->execute(array(
            'name' => $this->name,
            'password' => $this->password
        ));

        $row = $query->fetch();

        $this->id = $row['id'];
    }
    
    public static function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Golffari WHERE nimi = :name AND salasana = :password LIMIT 1');
        
        $query->execute(array(
            'name' => $name,
            'password' => $password
        ));
        
        $row = $query->fetch();
        if ($row) {
            $golfer[] = new Golfer(array(
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
