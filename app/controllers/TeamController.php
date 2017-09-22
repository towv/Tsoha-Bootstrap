<?php

require 'app/models/team.php';

class TeamController extends BaseController {

    public static function index() {
        $teams = Team::all();
        View::make('team/teams.html', array('teams' => $teams));
    }
    
    public static function show($id) {
        $team = Team::find($id);
        View::make('team/show_team.html', array('team' => $team));
    }
    
    public static function store() {
        $params = $_POST;
        
        $team = new Team(array(
            'name' => $params['name'],
            'description' => $params['description']
        ));
        
        $team->save();
        
        Redirect::to('/teams/' . $team->id, array('message' => 'Uusi joukkue lisätty!'));
    }
    
    public static function create(){
        View::make('team/add_team.html');
    }

}
