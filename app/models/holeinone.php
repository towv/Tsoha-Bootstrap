<?php

class Holeinone extends BaseModel {

    public $id, $golfer, $course, $hole, $date, $description;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_hole', 'validate_date', 'validate_description');
    }

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
                'golfername' => Golfer::find($row->golfer)[0]->name,
                'coursename' => Course::find($row->course)[0]->name,
                'hole' => $row->hole,
                'date' => $row->date,
                'description' => $row->description
            );
        }
        return $holewname;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Holari WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $holeinone[] = new Holeinone(array(
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

    public static function findwname($id) {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        $row = self::find($id)[0];


        if ($row) {
            $holewname[] = array(
                'id' => $row->id,
                'golfer' => $row->golfer,
                'course' => $row->course,
                'golfername' => Golfer::find($row->golfer)[0]->name,
                'coursename' => Course::find($row->course)[0]->name,
                'hole' => $row->hole,
                'date' => $row->date,
                'description' => $row->description
            );
            return $holewname;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Holari (pelaajaid, rataid, vayla, pvm, kuvaus) VALUES (:golfer, :course, :hole, :date, :description) RETURNING id');

        $query->execute(array('golfer' => $this->golfer, 'course' => $this->course,
            'hole' => $this->hole, 'date' => $this->date, 'description' => $this->description));

        $row = $query->fetch();

        $this->id = $row['id'];
    }
    
    public function validate_hole() {
        $errors = array();
        
        if (!is_numeric($this->hole)) {
            $errors[] = 'Väylä tulee syöttää numerona';
        }
    }
    
    public function validate_date() {
        $errors = array();

        if ($this->date != null && $this->date != '') {
            if (!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/", $this->date)) {
                $errors[] = 'Päivämäärä väärässä muodossa';
            }
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
