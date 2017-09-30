<?php

require 'app/models/golfer.php';

class GolferController extends BaseController {
    
    public static function index() {
        $golfers = Golfer::all();
        View::make('golfer/users.html', array('golfers' => $golfers));
    }

    public static function store() {
        $params = $_POST;

        $golfer = new Golfer(array(
            'name' => $params['name'],
            'password' => $params['password']
        ));

        $golfer->save();

        Redirect::to('/records');
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
            $_SESSION['golfer'] = $golfer[0]->id;

            Redirect::to('/holeinones', array('message' => 'Tervetuloa takasin ' . $golfer[0]->name . '! Tulikos holari vai mitäs täällä pyörit?'));
        }
    }

}
