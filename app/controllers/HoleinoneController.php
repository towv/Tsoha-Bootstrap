<?php

require 'app/models/holeinone.php';
require 'app/models/course.php';
require 'app/models/golfer.php';
require 'app/models/team.php';
/*
 * Kontrolleri. Hoitaa Holareihin liittyvät toiminnallisuudet.
 */

class HoleinoneController extends BaseController {

    public static function index() {
//        $holeinones = Holeinone::all();
//        View::make('holeinone/holeinones.html', array('holeinones' => $holeinones));

        $holewnames = Holeinone::allwnames();
        View::make('holeinone/holeinones.html', array('holewnames' => $holewnames));
    }

    public static function show($id) {
        $holeinone = Holeinone::findwname($id);
        $boolean = FALSE;
        if (isset($_SESSION['golfer'])) {
            if (self::get_user_logged_in()->name === $holeinone['golfername']) {
                $boolean = TRUE;
            }
        }
        View::make('holeinone/show_holeinone.html', array('holeinone' => $holeinone, 'boolean' => $boolean));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'golfer' => $params['golfer'],
            'course' => $params['course'],
            'hole' => $params['hole'],
            'date' => $params['date'],
            'description' => $params['description']
        );

        $holeinone = new Holeinone($attributes);
        $errors = $holeinone->errors();
        if (count($errors) == 0) {
            require_once 'app/models/golfer.php';
            Golfer::updateHoleinoneTrue($holeinone->golfer);
            $holeinone->save();
            Redirect::to('/holeinones/' . $holeinone->id, array('message' => 'MITÄÄÄÄ!!??? HOLARI!'));
        } else {
            $courses = Course::all();
            $golfer = self::get_user_logged_in()->id;
            View::make('holeinone/add_holeinones.html', array('courses' => $courses, 'golfer' => $golfer, 'errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        $courses = Course::all();
        $golfer = self::get_user_logged_in()->id;
//        $golfers = Golfer::all();

        View::make('holeinone/add_holeinones.html', array('courses' => $courses, 'golfer' => $golfer));
    }

    public static function edit($id) {
        $holeinone = Holeinone::findwname($id);
        $attributes = Holeinone::find($id);

        View::make('holeinone/edit_holeinone.html', array('attributes' => $attributes, 'holeinone' => $holeinone));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'golfer' => $params['golfer'],
            'course' => $params['course'],
            'hole' => $params['hole'],
            'date' => $params['date'],
            'description' => $params['description']
        );

        $holeinone = new Holeinone($attributes);
        $errors = $holeinone->errors();

        if (count($errors) > 0) {
            View::make('/holeinone/edit_holeinone.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $holeinone->update();
            Redirect::to('/holeinones/' . $holeinone->id, array('message' => 'Holariasi on nyt muokattu.'));
        }
    }

    public static function destroy($id) {
        $holeinone = new Holeinone(array('id' => $id));
        $holeinone->destroy();
        Redirect::to('/holeinones', array('message' => 'Holari on poistettu, ketjut ei riitä pitää jäädä koriin.'));
    }

}
