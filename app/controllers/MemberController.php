<?php

require 'app/models/member.php';

class MemberController extends BaseController {
    
    public static function store($id) {
        $params = $_POST;
        
        $members = Member::findMembersWteam($id);
        
        $boolean = FALSE;
        
        foreach ($members as $m) {
            if ($m->golfer == self::get_user_logged_in()->id) {
                $boolean = TRUE;
            }
        }
        if ($boolean) {
            Redirect::to('/teams/' . $id, array('message' => 'Kuulut jo tähän joukkueeseen.'));
        } else {
        $member = new Member(array(
            'golfer' => self::get_user_logged_in()->id,
            'team' => $id
        ));
        
        $member->save();
        
        Redirect::to('/teams/' . $member->team, array('message' => 'Olet liittynyt hyvään joukkueeseen!'));
        }
    }
    
}
