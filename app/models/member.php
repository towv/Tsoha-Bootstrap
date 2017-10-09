<?php

/*
 * Malli. Mallintaa Jasen -oliota.
 */

class Member extends BaseModel {
    /*
     * golfer = golffari, team = joukkue
     * Liitostaulu, joten ei ideitä.
     */

    public $golfer, $team;

    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }

    /*
     * Palauttaa kaikki Jäsen -oliot, eli Jasenliitos -taulun sisällön
     */

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos');

        $query->execute();

        $rows = $query->fetchAll();

        $members = array();

        foreach ($rows as $row) {
            $members = new Member(array(
                'golfer' => $row['pelaajaid'],
                'team' => $row['joukkueid']
            ));
        }
        return $members;
    }

    /*
     * Parametrina joukkueid ja pelaajaid, palauttaa true jos pelaaja kuuluu
     * kyseiseen joukkueeseen muuten false
     */

    //returns true if golfer belongs to the team otherwise false
    public static function findOutIfPartOfTeamBoolean($golfer, $team) {
        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos WHERE golferid = :golfer, joukkueid = :team LIMIT 1');

        $query->execute(array('golfer' => $golfer, 'team' => $team));

        $row = $query->fetch();

        $boolean = FALSE;

        if ($row) {
            $boolean = TRUE;
            return $boolean;
        } else {
            return $boolean;
        }
    }

    /*
     * Hakee Jasenliitos -taulusta golffarit eli jäsenet jotka kuuluvat
     * parametrina saatuun Joukkueeseen (id)
     */

    public static function findMembersWteam($id) {
        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos WHERE joukkueid = :id');

        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();

        $members = array();

        foreach ($rows as $row) {
            $members[] = new Member(array(
                'golfer' => $row['pelaajaid'],
                'team' => $row['joukkueid']
            ));
        }
        return $members;
    }

    /*
     * Hakee Jasenliitos -taulusta joukkueet joihin parametrina saadun tunnisteen
     * omaava golffari kuuluu
     */

    public static function findTeamsWmembers($id) {
        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos WHERE pelaajaid = :id');

        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();

        $teams = array();

        foreach ($rows as $row) {
            $teams[] = Team::find($row['joukkueid']);
        }
        return $teams;
    }

    /*
     * Tallentaa jäsenen tietokantaan.
     */

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Jasenliitos (pelaajaid, joukkueid) VALUES (:golfer, :team)');

        $query->execute(array('golfer' => $this->golfer, 'team' => $this->team));
    }

    /*
     * Poistaa jäsenen tietokannasta Jasenliitos-taulusta.
     */

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Jasenliitos WHERE pelaajaid = :golfer AND joukkueid = :team');
        $query->execute(array('golfer' => $this->golfer, 'team' => $this->team));
    }

}
