<?php

require 'app/models/golfer.php';
/*
 * Kontrolleri. Hoitaa käyttäjään, eli Golffariin, liittyvät toiminnallisuudet.
 */

class GolferController extends BaseController {

    public static function index() {
//        self::check_logged_in();
        $golfers = Golfer::all();
        View::make('golfer/users.html', array('golfers' => $golfers));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
            'password' => $params['password']
        );

        $golfer = new Golfer($attributes);
        $errors = $golfer->errors();

        if (count($errors) == 0) {
            $golfer->save();
            Redirect::to('/login');
        } else {
            View::make('golfer/register.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        View::make('golfer/register.html');
    }

    public static function login() {
        View::make('golfer/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $golfer = Golfer::authenticate($params['name'], $params['password']);

        if (!$golfer) {
            View::make('golfer/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana tai molemmat', 'name' => $params['name']));
        } else {
            $_SESSION['golfer'] = $golfer->id;

            Redirect::to('/holeinones', array('message' => 'Tervetuloa takasin ' . $golfer->name . '! Tulikos holari vai mitäs täällä pyörit?'));
        }
    }

    public static function logout() {
        $_SESSION['golfer'] = null;
        Redirect::to('/login', array('message' => 'Pirteää kierrosta!'));
    }

}
