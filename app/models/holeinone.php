<?php

/*
 * Malli. Mallintaa Holari-oliota.
 */

class Holeinone extends BaseModel {
    /*
     * id = uniikki tunniste, golfer = golffarin id, course = radan id, hole = väylä jolla holari saatu,
     * date = päivämäärä jolloin holari saatu, description = holarin kuvaus
     */

    public $id, $golfer, $course, $hole, $date, $description;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_hole', 'validate_date', 'validate_description');
    }

    /*
     * Palauttaa kaikki Holarit tietokannasta listana.
     */

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Holari');

        $query->execute();

        $rows = $query->fetchAll();
        $holeinones = array();

        foreach ($rows as $row) {
            $holeinones[] = new Holeinone(array(
                'id' => $row['id'],
                'golfer' => $row['pelaajaid'],
                'course' => $row['rataid'],
                'hole' => $row['vayla'],
                'date' => $row['pvm'],
                'description' => $row['kuvaus']
            ));
        }
        return $holeinones;
    }

    /*
     * Palauttaa kaikki Holarit tietokannasta listana, 
     * jossa niihin on liitetty golffari ja rata tunnisteiden lisäksi golffarin ja radan nimi.
     */

    public static function allwnames() {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        $holeinones = self::all();
        $holewname = array();


        foreach ($holeinones as $row) {
            $holewname[] = array(
                'id' => $row->id,
                'golfer' => $row->golfer,
                'course' => $row->course,
                'golfername' => Golfer::find($row->golfer)->name,
                'coursename' => Course::find($row->course)->name,
                'hole' => $row->hole,
                'date' => $row->date,
                'description' => $row->description
            );
        }
        return $holewname;
    }

    /*
     * Palauttaa Holari-olion, jonka tunnus on parametrina saatu tunnus, tai null jos tunnusta ei löydy tietokannasta
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Holari WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $holeinone = new Holeinone(array(
                'id' => $row['id'],
                'golfer' => $row['pelaajaid'],
                'course' => $row['rataid'],
                'hole' => $row['vayla'],
                'date' => $row['pvm'],
                'description' => $row['kuvaus']
            ));
            return $holeinone;
        }


        return null;
    }

    /*
     * Palauttaa Holari-olion, jonka tunnus on parametrina saatu tunnus, tai null jos tunnusta ei löydy tietokannasta.
     * Liittää tähän radan ja golffarin nimet tunnisteiden lisäksi.
     */

    public static function findwname($id) {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        $row = self::find($id);


        if ($row) {
            $holewname = array(
                'id' => $row->id,
                'golfer' => $row->golfer,
                'course' => $row->course,
                'golfername' => Golfer::find($row->golfer)->name,
                'coursename' => Course::find($row->course)->name,
                'hole' => $row->hole,
                'date' => $row->date,
                'description' => $row->description
            );

            return $holewname;
        }
        return null;
    }
/*
     * Tallentaa uuden holarin tietokantaan
     */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Holari (pelaajaid, rataid, vayla, pvm, kuvaus) VALUES (:golfer, :course, :hole, :date, :description) RETURNING id');

        $query->execute(array('golfer' => $this->golfer, 'course' => $this->course,
            'hole' => $this->hole, 'date' => $this->date, 'description' => $this->description));

        $row = $query->fetch();

        $this->id = $row['id'];
    }
/*
     * Päivittää holarin tiedot tietokantaan.
     */
    public function update() {
        $query = DB::connection()->prepare('UPDATE Holari SET pelaajaid = :golfer, rataid = :course, vayla = :hole, pvm = :date, kuvaus = :description WHERE id = :id');
        $query->execute(array('id' => $this->id, 'golfer' => $this->golfer, 'course' => $this->course,
            'hole' => $this->hole, 'date' => $this->date, 'description' => $this->description));
    }
    /*
     * Poistaa holarin tietokannasta.
     */

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Holari WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validate_hole() {
        $errors = array();

        if (parent::validatenumber($this->hole)) {
            $errors[] = 'Väylä syötetty väärin, syötä numero.';
        }

        return $errors;
    }

    public function validate_date() {
        return parent::validatedate($this->date);
    }

    public function validate_description() {
        $errors = array();
        if (strlen($this->description) > 300) {
            $errors[] = 'Kuvauksen maksimipituus on 300 merkkiä';
        }
        return $errors;
    }

}
