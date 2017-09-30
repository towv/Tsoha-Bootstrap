<?php

require 'app/models/team.php';

class TeamController extends BaseController {

    public static function index() {
        $teams = Team::allWamountOmembers();
        View::make('team/teams.html', array('teams' => $teams));
    }
    
    public static function show($id) {
//        require_once 'app/models/golfer.php';
//        require_once 'app/models/member.php';
//        $team = Team::find($id);
//        $members = Member::findMembersWteam($id);
//        $golfers = Golfer::getMembers($members);
//        View::make('team/show_team.html', array('team' => $team, 'golfers' => $golfers));
        
        require_once 'app/models/golfer.php';
        $team = Team::find($id);
        $golfers = Golfer::getTeam($id);
        View::make('team/show_team.html', array('team' => $team, 'golfers' => $golfers));
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
