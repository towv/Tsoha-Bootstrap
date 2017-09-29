<?php

require 'app/models/holeinone.php';
require 'app/models/course.php';
require 'app/models/golfer.php';
require 'app/models/team.php';

class HoleinoneController extends BaseController {

    public static function index() {
//        $holeinones = Holeinone::all();
//        View::make('holeinone/holeinones.html', array('holeinones' => $holeinones));
        
        $holewnames = Holeinone::allwnames();
        View::make('holeinone/holeinones.html', array('holewnames' => $holewnames));
    }

    public static function show($id) {
        $holeinone = Holeinone::findwname($id);
        View::make('holeinone/show_holeinone.html', array('holeinone' => $holeinone));
    }

    public static function store() {
        $params = $_POST;

        $holeinone = new Holeinone(array(
            'golfer' => $params['golfer'],
            'course' => $params['course'],
            'hole' => $params['hole'],
            'date' => $params['date'],
            'description' => $params['description']
        ));

        $holeinone->save();

        Redirect::to('/holeinones/' . $holeinone->id, array('message' => 'MITÄÄÄÄ!!??? HOLARI!'));
    }

    public static function create() {
        $courses = Course::all();
        $golfers = Golfer::all();
        
        View::make('holeinone/add_holeinones.html', array('courses' => $courses, 'golfers' => $golfers));
    }

}
