<?php
require 'app/models/course.php';
require 'app/models/team.php';
class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
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
        
        $meikku = Team::find(1);
        $courses = Team::all();
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($courses);
        Kint::dump($meikku);




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
