<?php

require 'app/models/course.php';
require 'app/models/team.php';
require 'app/models/holeinone.php';
require 'app/models/golfer.php';
require 'app/models/record.php';
require 'app/models/member.php';
/*
 * Kontrolleri. Hoitaa etusivun näyttämisen ja toimii apuna testauksessa.
 */

class HelloWorldController extends BaseController {
    
    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        if (isset($_SESSION['golfer'])) {
            $teams = Member::findTeamsWmembers(self::get_user_logged_in()->id);
            
            View::make('home.html', array('teams' => $teams));
        } else {
            View::make('home.html');
        }
//        View::make('home.html');
        //echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Muista sisällyttää malliluokka require-komennolla!
        // ...
//        $meikku = Course::find(1);
//        $courses = Course::all();
//        // Kint-luokan dump-metodi tulostaa muuttujan arvon
//        Kint::dump($courses);
//        Kint::dump($meikku);
//        $meikku = Team::find(1);
//        $courses = Team::all();
//        Kint::dump($courses);
//        Kint::dump($meikku);
//        $meikku = Holeinone::find(1);
//        $courses = Holeinone::all();
//        Kint::dump($courses);
//        Kint::dump($meikku);
//        $meikku = Golfer::find(1);
//        $courses = Golfer::all();
//        Kint::dump($courses);
//        Kint::dump($meikku);
//        $meikku = Record::find(1);
//        $courses = Record::all();
//        Kint::dump($courses);
//        Kint::dump($meikku);
//        $courses = Holeinone::allwnames();
//        Kint::dump($courses);
//        $records = Record::findwme(self::get_user_logged_in()->id);
//        Kint::dump($records);
//        $records = Member::findMembersWteam(1);
//        Kint::dump($records);
//        $joo = Golfer::getMembers($records);
//        Kint::dump($records);
//        $memberamountinteam = Team::allWamountOmembers();
//        Kint::dump($memberamountinteam);
//        $palloseura = Golfer::getTeam(1);
//        Kint::dump($palloseura);
//        $toinenjoukkue = Golfer::getTeam(2);
//        Kint::dump($toinenjoukkue);
        $ennatyjskii = Record::allWithTeamActualRecordNoName(1);
        Kint::dump($ennatyjskii);


        // Testaa koodiasi täällä
        //echo 'Hello World!';
//        View::make('helloworld.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function register() {
        View::make('suunnitelmat/register.html');
    }

    public static function delete() {
        View::make('suunnitelmat/delete.html');
    }

    public static function course_show() {
        View::make('suunnitelmat/course_show.html');
    }

    public static function records_player() {
        View::make('suunnitelmat/records_player.html');
    }

    public static function records_other() {
        View::make('suunnitelmat/records_other.html');
    }

    public static function courses() {
        View::make('suunnitelmat/courses.html');
    }

    public static function teams() {
        View::make('suunnitelmat/teams.html');
    }

    public static function holeinones() {
        View::make('suunnitelmat/holeinones.html');
    }

    public static function add_record() {
        View::make('suunnitelmat/add_record.html');
    }

    public static function add_course() {
        View::make('suunnitelmat/add_course.html');
    }

    public static function add_team() {
        View::make('suunnitelmat/add_team.html');
    }

    public static function add_holeinones() {
        View::make('suunnitelmat/add_holeinones.html');
    }

    public static function show_course() {
        View::make('suunnitelmat/show_course.html');
    }

    public static function show_team() {
        View::make('suunnitelmat/show_team.html');
    }

    public static function show_holeinone() {
        View::make('suunnitelmat/show_holeinone.html');
    }

    public static function edit_record() {
        View::make('suunnitelmat/edit_record.html');
    }

    public static function edit_course() {
        View::make('suunnitelmat/edit_course.html');
    }

    public static function edit_team() {
        View::make('suunnitelmat/edit_team.html');
    }

    public static function edit_holeinone() {
        View::make('suunnitelmat/edit_holeinone.html');
    }

}
