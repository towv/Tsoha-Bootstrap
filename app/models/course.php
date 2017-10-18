<?php

/*
 * Malli. Mallintaa Rata-oliota.
 */

class Course extends BaseModel {
    /*
     * id = uniikki id, name = Radan nimi, holes = väylien lukumäärä, par = ihannetulos, description = radan kuvaus
     */

    public $id, $name, $holes, $par, $location, $description;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_holes', 'validate_par', 'validate_location', 'validate_description');
    }

    /*
     * Palauttaa kaikki Radat tietokannasta listana.
     */

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

    /*
     * Palauttaa Rata-olion, jonka tunnus on parametrina saatu tunnus, tai null, jos tunnuksella ei ole rataa
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Rata WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $course = new Course(array(
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

    /*
     * Tallentaa radan tietokantaan.
     */

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Rata (nimi, vaylia, ihannetulos, sijainti, kuvaus) VALUES (:name, :holes, :par, :location, :description) RETURNING id');

        $query->execute(array('name' => $this->name, 'holes' => $this->holes,
            'par' => $this->par, 'location' => $this->location, 'description' => $this->description));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    /*
     * Päivittää radan tiedot tietokantaan.
     */

    public function update() {
        $query = DB::connection()->prepare('UPDATE Rata SET nimi = :name, vaylia = :holes, ihannetulos = :par, sijainti = :location, kuvaus = :description WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'holes' => $this->holes,
            'par' => $this->par, 'location' => $this->location, 'description' => $this->description));
    }

    /*
     * Poistaa radan tietokannasta.
     */

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Rata WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    /*
     * Validaattori Radan nimelle.
     */

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

    /*
     * Validaattori väylien määrälle, käyttää apuna yläluokan numerovalidointia
     */

    public function validate_holes() {
        $errors = array();
        if (parent::validatenumber($this->holes)) {
            $errors[] = 'Väylien määrä tulee syöttää numerona max 100 min -100';
        }
        return $errors;
    }

    /*
     * Validaattori ihannetulokselle, käyttää apuna yläluokan numerovalidointia
     */

    public function validate_par() {
        $errors = array();
        if (parent::validatenumber($this->par)) {
            $errors[] = 'Ihannetulos tulee syöttää numerona max 100 min -100';
        }
        return $errors;
    }

    /*
     * Validaattori sijainnille
     */

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

    /*
     * Validaattori kuvaukselle
     */

    public function validate_description() {
        $errors = array();
        if (strlen($this->description) > 300) {
            $errors[] = 'Kuvauksen maksimipituus on 300 merkkiä';
        }
        return $errors;
    }

    /*
     * Validaattori yhteyksille, tarkistaa liittyykö rataan tuloksia, jos liittyy ei sitä voi poistaa
     */

    public function validate_connections() {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE rataid = :rata');
        $query->execute(array('rata' => $this->id));
        $rows = $query->fetchAll();
        $errors = array();
        if (count($rows) > 0) {
            $errors[] = $this->name . ' liittyy ' . count($rows) . ' tulokseen, eikä sitä siksi voi poistaa.';
        }
        return $errors;
    }

}
