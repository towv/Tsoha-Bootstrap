<?php

require 'app/models/team.php';
/*
 * Kontrolleri. Hoitaa Joukkueisiin liittyvät toiminnallisuudet.
 */

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
        $member = FALSE;
        if (self::check_logged_in()) {
            $golfer = self::get_user_logged_in();
            require_once 'app/models/member.php';
            $member = Member::findOutIfPartOfTeamBoolean($golfer, $id);
        }

        require_once 'app/models/golfer.php';
        $team = Team::find($id);
        $golfers = Golfer::getTeam($id);
        View::make('team/show_team.html', array('team' => $team, 'golfers' => $golfers, 'member' => $member));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
            'description' => $params['description']
        );

        $team = new Team($attributes);
        $errors = $team->errors();
        if (count($errors) == 0) {
            $team->save();
            Redirect::to('/teams/' . $team->id, array('message' => 'Uusi joukkue lisätty!'));
        } else {
            View::make('team/add_team.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        View::make('team/add_team.html');
    }

    public static function edit($id) {
        $team = Team::find($id);
        View::make('team/edit_team.html', array('attributes' => $team));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'description' => $params['description']
        );

        $team = new Team($attributes);
        $errors = $team->errors();

        if (count($errors) > 0) {
            View::make('/team/edit_team.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $team->update();
            Redirect::to('/teams/' . $team->id, array('message' => 'Joukkuetta on nyt muokattu.'));
        }
    }

    public static function destroy($id) {
        $team = Team::find($id);
        $errors = $team->validate_connections();
        if (count($errors) == 0) {
            $team = new Team(array('id' => $id));
            $team->destroy();
            Redirect::to('/teams', array('message' => 'Joukkue on poistettu :('));
        } else {
            Redirect::to('/teams/' . $id, array('errors' => $errors));
        }
    }

}
