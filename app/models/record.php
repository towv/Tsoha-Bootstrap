<?php

class Record extends BaseModel {

    public $id, $golfer, $course, $score, $date, $added;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->added = substr($this->added, 0, 10);
        $this->validators = array('validate_score', 'validate_date');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tulos');

        $query->execute();

        $rows = $query->fetchAll();

        $records = array();

        foreach ($rows as $row) {
            $records[] = new Record(array(
                'id' => $row['id'],
                'golfer' => $row['pelaajaid'],
                'course' => $row['rataid'],
                'score' => $row['tulos'],
                'date' => $row['pvm'],
                'added' => $row['luotu']
            ));
        }

        return $records;
    }

    public static function allwnames() {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        $records = self::all();
        $recordswnames = array();


        foreach ($records as $row) {
            $recordswnames[] = array(
                'id' => $row->id,
                'golfer' => $row->golfer,
                'course' => $row->course,
                'golfername' => Golfer::find($row->golfer)[0]->name,
                'coursename' => Course::find($row->course)[0]->name,
                'score' => $row->score,
                'date' => $row->date,
                'added' => $row->added
            );
        }
        return $recordswnames;
    }
    
    public static function allWithCourse($id) {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        $records = self::all();
        $recordswcourse = array();


        foreach ($records as $row) {
            if ($row->course != $id) {
                continue;
            }
            $recordswcourse[] = array(
                'id' => $row->id,
                'golfer' => $row->golfer,
                'course' => $row->course,
                'golfername' => Golfer::find($row->golfer)[0]->name,
                'coursename' => Course::find($row->course)[0]->name,
                'score' => $row->score,
                'date' => $row->date,
                'added' => $row->added
            );
        }
        return $recordswcourse;
    }
    
    public static function allWithTeam($id) {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        $records = self::all();
        $recordswcourse = array();


        foreach ($records as $row) {
            if ($row->course != $id) {
                continue;
            }
            $recordswcourse[] = array(
                'id' => $row->id,
                'golfer' => $row->golfer,
                'course' => $row->course,
                'golfername' => Golfer::find($row->golfer)[0]->name,
                'coursename' => Course::find($row->course)[0]->name,
                'score' => $row->score,
                'date' => $row->date,
                'added' => $row->added
            );
        }
        return $recordswcourse;
    }
    
    public static function allWithTeamAndCourse($course, $team) {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        $records = self::all();
        $recordswcourse = array();


        foreach ($records as $row) {
            if ($row->course != $id) {
                continue;
            }
            $recordswcourse[] = array(
                'id' => $row->id,
                'golfer' => $row->golfer,
                'course' => $row->course,
                'golfername' => Golfer::find($row->golfer)[0]->name,
                'coursename' => Course::find($row->course)[0]->name,
                'score' => $row->score,
                'date' => $row->date,
                'added' => $row->added
            );
        }
        return $recordswcourse;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $record[] = new Record(array(
                'id' => $row['id'],
                'golfer' => $row['pelaajaid'],
                'course' => $row['rataid'],
                'score' => $row['tulos'],
                'date' => $row['pvm'],
                'added' => $row['luotu']
            ));

            return $record;
        }

        return null;
    }

//    public static function findwme($id) {
//        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE pelaajaid = :id LIMIT 1');
//        $query->execute(array('id' => $id));
//        $row = $query->fetch();
//
//        if ($row) {
//            
//            $records[] = new Record(array(
//                'id' => $row['id'],
//                'golfer' => $row['pelaajaid'],
//                'course' => $row['rataid'],
//                'score' => $row['tulos'],
//                'date' => $row['pvm'],
//                'added' => $row['luotu']
//            ));
//
//            include_once 'app/models/golfer.php';
//            include_once 'app/models/course.php';
//
//            return $records;
//        }
//
//        return null;
//    }

    public static function findwme($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE pelaajaid = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        
        $recordswnames = array();


        foreach ($rows as $row) {
            $recordswnames[] = array(
                'id' => $row['id'],
                'golfer' => $row['pelaajaid'],
                'course' => $row['rataid'],
                'golfername' => Golfer::find($row['pelaajaid'])[0]->name,
                'coursename' => Course::find($row['rataid'])[0]->name,
                'score' => $row['tulos'],
                'date' => $row['pvm'],
                'added' => substr($row['luotu'], 0, 10)
            );
        }
        return $recordswnames;

//        if ($row) {
//
//            include_once 'app/models/golfer.php';
//            include_once 'app/models/course.php';
//
//            $records[] = array(
//                'id' => $row['id'],
//                'golfer' => $row['pelaajaid'],
//                'course' => $row['rataid'],
//                'golfername' => Golfer::find($row['pelaajaid'])[0]->name,
//                'coursename' => Course::find($row['rataid'])[0]->name,
//                'score' => $row['tulos'],
//                'date' => $row['pvm'],
//                'added' => substr($row['luotu'], 0, 10)
//            );
//
//
//
//            return $records;
//        }
//
//        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tulos (pelaajaid, rataid, tulos, pvm) VALUES (:golfer, :course, :score, :date) RETURNING id');

        $query->execute(array(
            'golfer' => $this->golfer,
            'course' => $this->course,
            'score' => $this->score,
            'date' => $this->date,
        ));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function validate_score() {
        $errors = array();

        if (!is_numeric($this->score)) {
            $errors[] = 'Tulos tulee syöttää numerona';
        }
        return $errors;
    }

    public function validate_date() {
        $errors = array();

        if ($this->date != null && $this->date != '') {
            if (!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/", $this->date)) {
                $errors[] = 'Päivämäärä väärässä muodossa, oikea muoto: PP.KK.VVVV';
            }
        }
        return $errors;
    }

}
