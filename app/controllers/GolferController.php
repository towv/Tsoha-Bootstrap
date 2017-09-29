<?php

require 'app/models/golfer.php';

class GolferController extends BaseController {

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
        View::make('/golfer/register.html');
    }

}
