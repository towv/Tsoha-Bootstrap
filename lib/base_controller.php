<?php

class BaseController {

    public static function get_user_logged_in() {
        require_once 'app/models/golfer.php';
        // Kirjautuneen käyttäjän haku
        if (isset($_SESSION['golfer'])) {
            $id = $_SESSION['golfer'];
            // Pyydetään Golfer-mallilta käyttäjä session mukaisella id:llä
            $golfer = Golfer::find($id)[0];
            return $golfer;
        }
        // Jos käyttäjä ei ole kirjautunut palautetaan null
        return null;
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

}
