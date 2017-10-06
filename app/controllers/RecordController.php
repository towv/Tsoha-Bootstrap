<?php

require 'app/models/record.php';
require 'app/models/course.php';
require 'app/models/team.php';
/*
 * Kontrolleri. Hoitaa Tuloksiin liittyvät toiminnallisuudet.
 */

class RecordController extends BaseController {

    public static function index() {
        $params = $_POST;
        $team = 'all';
        if (isset($params["team"])) {
            $team = $params['team'];
        }
        $course = 'all';
        if (isset($params["course"])) {
            $course = $params['course'];
        }

        if ($course == 'all' && $team == 'all') {
            $records = Record::allWithNames();
        } else if ($course != 'all' && $team == 'all') {
            $records = Record::allWithCourse($course);
        } else if ($course == 'all' && $team != 'all') {
            $records = Record::allWithTeam($team);
        } else {
            $records = Record::allWithTeamAndCourse($team, $course);
        }

        $teams = Team::all();
        $courses = Course::all();

        View::make('record/records.html', array('records' => $records, 'teams' => $teams, 'courses' => $courses));
    }

    public static function store() {
//        $params = $_POST;
//
//        $record = new Record(array(
//            'golfer' => self::get_user_logged_in()->id,
//            'course' => $params['course'],
//            'score' => $params['score'],
//            'date' => $params['date']
//        ));
//
//        $record->save();
//
//        Redirect::to('/records/my');

        $params = $_POST;

        $attributes = array(
            'golfer' => self::get_user_logged_in()->id,
            'course' => $params['course'],
            'score' => $params['score'],
            'date' => $params['date']
        );

        $record = new Record($attributes);
        $errors = $record->errors();

        if (count($errors) == 0) {
            $record->save();
            Redirect::to('/records/my');
        } else {
            View::make('course/add_record.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        $courses = Course::all();

        View::make('/record/add_record.html', array('courses' => $courses));
    }

    public static function my() {
        if (isset($_SESSION['golfer'])) {
            $records = Record::findReturnWithNames(self::get_user_logged_in()->id);
            View::make('record/myrecords.html', array('records' => $records));
        } else {
            Self::index();
        }
    }

    public static function destroy($id) {
        $record = new Record(array('id' => $id));
        $record->destroy();
        Redirect::to('/records/my', array('message' => 'Tulos poistettu.'));
    }

}
