<?php

class Member extends BaseModel {
    public $golfer, $team;
    
    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }
    
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
    
    public static function findTeamsWmembers($id) {
        $query = DB::connection()->prepare('SELECT * FROM Jasenliitos WHERE pelaajaid = :id');
        
        $query->execute(array('id' => $id));
        
        $rows = $query->fetchAll();
        
        $teams = array();
        
        foreach ($rows as $row) {
            $members = new Member(array(
                'golfer' => $row['pelaajaid'],
                'team' => $row['joukkueid']
            ));
        }
        return $teams;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Jasenliitos (pelaajaid, joukkueid) VALUES (:golfer, :team)');
        
        $query->execute(array('golfer' => $this->golfer, 'team' => $this->team));
    }
}
