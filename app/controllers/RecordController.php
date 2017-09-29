<?php

require 'app/models/record.php';
require 'app/models/course.php';
require 'app/models/team.php';

class RecordController extends BaseController {

    public static function index() {
//        $records = Record::all();
        $records = Record::allwnames();
        $teams = Team::all();
        $courses = Course::all();

        View::make('record/records.html', array('records' => $records, 'teams' => $teams, 'courses' => $courses));
    }

    public static function store() {
        $params = $_POST;

        $record = new Record(array(
            'golfer' => $params['golfer'],
            'course' => $params['course'],
            'score' => $params['score'],
            'date' => $params['date']
        ));

        $record->save();

        Redirect::to('/records/my');
    }

    public static function create() {
        $courses = Course::all();

        View::make('/record/add_record.html', array('courses' => $courses));
    }

    public static function my() {
        if (isset($_SESSION['golfer'])) {
            $records = Record::findwme(self::get_user_logged_in()->id);
            View::make('record/myrecords.html', array('records' => $records));
        } else {
            View::make('record/records.html');
        }
//        $records = Record::findwme(1);
//        $courses = Course::all();
//
//        View::make('record/myrecords.html', array('records' => $records, 'courses' => $courses));
    }

}
