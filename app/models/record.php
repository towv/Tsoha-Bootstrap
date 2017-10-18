<?php

/*
 * Malli. Mallintaa Tulos -oliota.
 */

class Record extends BaseModel {
    /*
     * id = tunniste, golfer = pelaajaid, course = rataid, score = tulos,
     * date = päivämäärä jolloin tulos on tehty, added = tuloksen lisäyspäivä
     */

    public $id, $golfer, $course, $score, $date, $added;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->added = substr($this->added, 0, 10);
        $this->validators = array('validate_score', 'validate_date');
    }

    /*
     * Palauttaa kaikki Tulokset tietokannasta listana.
     */

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

    /*
     * Palauttaa parhaan tuloksen jokaiselta pelaajalta, jokaisella radalla tai,
     * parametreista riippuen:
     * -Jos team -parametri ei ole 'all' ainoastaan tietyn joukkueen tulokset.
     * -Jos course -parametri ei ole 'all' ainoastaan tietyn radan tulokset.
     * Lisää tuloksiin nimet eli golffarin nimen ja radan nimen. 
     */

    public static function allWithNamesAndParametresOrdered($team, $course) {
        include_once 'app/models/golfer.php';
        include_once 'app/models/course.php';
        include_once 'app/models/team.php';

        if ($team != 'all') {
            $query = DB::connection()->prepare('SELECT * FROM Jasenliitos JOIN Golffari ON golffari.id = jasenliitos.pelaajaid JOIN Tulos ON golffari.id = tulos.pelaajaid WHERE Jasenliitos.joukkueid = :id AND tulos in (SELECT DISTINCT min(tulos.tulos) FROM tulos GROUP BY pelaajaid, rataid) ORDER BY rataid, tulos');
            $query->execute(array('id' => $team));
        } else {
            $query = DB::connection()->prepare('SELECT DISTINCT * FROM tulos WHERE tulos in (SELECT DISTINCT min(tulos.tulos) FROM tulos GROUP BY pelaajaid, rataid) ORDER BY rataid, tulos');
            $query->execute();
        }

        $rows = $query->fetchAll();

        $records = array();

        foreach ($rows as $row) {
            if ($row['rataid'] != $course && $course != 'all') {
                continue;
            }
            $records[] = array(
                'id' => $row['id'],
                'golfer' => $row['pelaajaid'],
                'course' => $row['rataid'],
                'golfername' => Golfer::find($row['pelaajaid'])->name,
                'coursename' => Course::find($row['rataid'])->name,
                'score' => $row['tulos'],
                'date' => $row['pvm'],
                'added' => substr($row['luotu'], 0, 10)
            );
        }

        return $records;
    }

    /*
     * Palauttaa Tulos-olion, jonka tunnus on parametrina saatu tunnus, tai null jos tunnusta ei löydy tietokannasta
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $record = new Record(array(
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

    /*
     * Hakee golffarin tulokset, järjestettynä ensisijaisesti radan ja toissijaisesti tuloksen mukaan.
     * Lisää näihin golffarin nimen ja radan nimen.
     */

    public static function findReturnWithNames($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tulos WHERE pelaajaid = :id ORDER BY rataid, tulos');
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
                'golfername' => Golfer::find($row['pelaajaid'])->name,
                'coursename' => Course::find($row['rataid'])->name,
                'score' => $row['tulos'],
                'date' => $row['pvm'],
                'added' => substr($row['luotu'], 0, 10)
            );
        }
        return $recordswnames;
    }

    /*
     * Tallentaa tuloksen tietokantaan.
     */

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

    /*
     * Poistaa tuloksen tietokannasta.
     */

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Tulos WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validate_score() {
        $errors = array();

        if (parent::validatenumber($this->score)) {
            $errors[] = 'Tulos tulee syöttää numerona, max 100 min -100';
        }

        return $errors;
    }

    public function validate_date() {
        return parent::validatedate($this->date);
    }

//    /*
//     * Palauttaa kaikilta golffareilta parhaan tuloksen jokaisella radalla.
//     * Nämä lisäksi järjestetään ensisijaisesti radat järjestykseen ja 
//     * toissijaisesti tulokset järjestykseen.
//     */
//
//    public static function allUniqueNameCourseOrdered() {
//        $query = DB::connection()->prepare('SELECT DISTINCT * FROM tulos WHERE tulos in (SELECT DISTINCT min(tulos.tulos) FROM tulos GROUP BY pelaajaid, rataid) ORDER BY rataid, tulos');
//
//        $query->execute();
//
//        $rows = $query->fetchAll();
//
//        $records = array();
//
//        foreach ($rows as $row) {
//            $records[] = new Record(array(
//                'id' => $row['id'],
//                'golfer' => $row['pelaajaid'],
//                'course' => $row['rataid'],
//                'score' => $row['tulos'],
//                'date' => $row['pvm'],
//                'added' => $row['luotu']
//            ));
//        }
//
//        return $records;
//    }
//
//    /*
//     * Lisää tuloksiin nimet eli golffarin nimen ja radan nimen. 
//     * Hakee tulokset allUniqueNameCourseOrdered:lla.
//     */
//
//    public static function allWithNames() {
//        include_once 'app/models/golfer.php';
//        include_once 'app/models/course.php';
//        $records = self::allUniqueNameCourseOrdered();
//        $recordswnames = array();
//
//
//        foreach ($records as $row) {
//            $recordswnames[] = array(
//                'id' => $row->id,
//                'golfer' => $row->golfer,
//                'course' => $row->course,
//                'golfername' => Golfer::find($row->golfer)->name,
//                'coursename' => Course::find($row->course)->name,
//                'score' => $row->score,
//                'date' => $row->date,
//                'added' => $row->added
//            );
//        }
//
//        return $recordswnames;
//    }
//
//    /*
//     * Palauttaa tietyllä radalla tehdyt tulokset.
//     * Lisää tuloksiin nimet eli golffarin nimen ja radan nimen. 
//     * Hakee tulokset allUniqueNameCourseOrdered:lla.
//     */
//
//    public static function allWithCourse($id) {
//        include_once 'app/models/golfer.php';
//        include_once 'app/models/course.php';
//        $records = self::allUniqueNameCourseOrdered();
//        $recordswcourse = array();
//
//
//        foreach ($records as $row) {
//            if ($row->course != $id) {
//                continue;
//            }
//            $recordswcourse[] = array(
//                'id' => $row->id,
//                'golfer' => $row->golfer,
//                'course' => $row->course,
//                'golfername' => Golfer::find($row->golfer)->name,
//                'coursename' => Course::find($row->course)->name,
//                'score' => $row->score,
//                'date' => $row->date,
//                'added' => $row->added
//            );
//        }
//        return $recordswcourse;
//    }
//
//    /*
//     * Palauttaa tietyn Joukkueen tulokset.
//     * Lisää tuloksiin nimet eli golffarin nimen ja radan nimen. 
//     * Hakee tulokset allWithTeamActualRecordNoName:lla.
//     */
//
//    public static function allWithTeam($team) {
//        include_once 'app/models/golfer.php';
//        include_once 'app/models/course.php';
//        $records = self::allWithTeamActualRecordNoName($team);
//        $recordswteam = array();
//
//        foreach ($records as $row) {
//            $recordswteam[] = array(
//                'id' => $row->id,
//                'golfer' => $row->golfer,
//                'course' => $row->course,
//                'golfername' => Golfer::find($row->golfer)->name,
//                'coursename' => Course::find($row->course)->name,
//                'score' => $row->score,
//                'date' => $row->date,
//                'added' => $row->added
//            );
//        }
//        return $recordswteam;
//    }
//
//    /*
//     * Palauttaa tietyn Joukkueen tulokset ilman nimiä.
//     */
//
//    public static function allWithTeamActualRecordNoName($id) {
//        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos JOIN Golffari ON golffari.id = jasenliitos.pelaajaid JOIN Tulos ON golffari.id = tulos.pelaajaid WHERE Jasenliitos.joukkueid = :id ORDER BY rataid, tulos');
//        $query->execute(array('id' => $id));
//
//        $rows = $query->fetchAll();
//
//        $records = array();
//
//        foreach ($rows as $row) {
//            $records[] = new Record(array(
//                'id' => $row['id'],
//                'golfer' => $row['pelaajaid'],
//                'course' => $row['rataid'],
//                'score' => $row['tulos'],
//                'date' => $row['pvm'],
//                'added' => $row['luotu']
//            ));
//        }
//
//        return $records;
//    }
//
//    /*
//     * Palauttaa tulokset, joissa tietty Joukkue ja Rata.
//     * Lisää tuloksiin nimet eli golffarin nimen ja radan nimen. 
//     * Hakee tulokset allWithTeamActualRecordNoName:lla.
//     */
//
//    public static function allWithTeamAndCourse($team, $course) {
//        include_once 'app/models/golfer.php';
//        include_once 'app/models/course.php';
//        include_once 'app/models/team.php';
//        $records = self::allWithTeamActualRecordNoName($team);
//        $recordswithteamandcourse = array();
//
//
//        foreach ($records as $row) {
//            if ($row->course != $course) {
//                continue;
//            }
//            $recordswithteamandcourse[] = array(
//                'id' => $row->id,
//                'golfer' => $row->golfer,
//                'course' => $row->course,
//                'golfername' => Golfer::find($row->golfer)->name,
//                'coursename' => Course::find($row->course)->name,
//                'score' => $row->score,
//                'date' => $row->date,
//                'added' => $row->added
//            );
//        }
//        return $recordswithteamandcourse;
//    }
}
