<?php

class Course extends BaseModel {

    public $id, $name, $holes, $par, $location, $description;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_holes', 'validate_par', 'validate_location', 'validate_description');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Rata');

        $query->execute();

        $rows = $query->fetchAll();
        $courses = array();

        foreach ($rows as $row) {
            $courses[] = new Course(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'holes' => $row['vaylia'],
                'par' => $row['ihannetulos'],
                'location' => $row['sijainti'],
                'description' => $row['kuvaus']
            ));
        }
        return $courses;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Rata WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $course[] = new Course(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'holes' => $row['vaylia'],
                'par' => $row['ihannetulos'],
                'location' => $row['sijainti'],
                'description' => $row['kuvaus']
            ));
            return $course;
        }


        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Rata (nimi, vaylia, ihannetulos, sijainti, kuvaus) VALUES (:name, :holes, :par, :location, :description) RETURNING id');

        $query->execute(array('name' => $this->name, 'holes' => $this->holes,
            'par' => $this->par, 'location' => $this->location, 'description' => $this->description));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Rata SET nimi = :name, vaylia = :holes, ihannetulos = :par, sijainti = :location, kuvaus = :description WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'holes' => $this->holes,
            'par' => $this->par, 'location' => $this->location, 'description' => $this->description));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Rata WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Nimi on pakollinen';
        }
        if (strlen($this->name) > 30) {
            $errors[] = 'Nimen maksimipituus on 30 merkkiä';
        }
        return $errors;
    }

    public function validate_holes() {
        $errors = array();
        if (!is_numeric($this->holes)) {
            $errors[] = 'Väylien määrä tulee syöttää numerona';
        }
        return $errors;
    }

    public function validate_par() {
        $errors = array();
        if (!is_numeric($this->par)) {
            $errors[] = 'Ihannetulos tulee syöttää numerona';
        }
        return $errors;
    }

    public function validate_location() {
        $errors = array();
        if ($this->location == '' || $this->location == null) {
            $errors[] = 'Sijainti on pakollinen';
        }
        if (strlen($this->location) > 20) {
            $errors[] = 'Sijainnin maksimipituus on 20 merkkiä';
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
