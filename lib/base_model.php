<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            $validator_errors = $this->{$validator}();
            $errors = array_merge($errors, $validator_errors);
        }

        return $errors;
    }

    public function validate_string_length($string, $length, $errors) {
        if (strlen($string) > $length) {
            $errors[] = 'Liian pitkä mjono';
        }

        return $errors;
    }

// Päivämäärän validointi
    public function validatedate($date) {
        $errors = array();

        try {
            $d = new DateTime($date);
        } catch (Exception $ex) {
            $errors[] = 'Päivämäärä väärässä muodossa, oikea muoto: PP.KK.VVVV tai YYYY-MM-DD';
            return $errors;
        }

        if ($date == null || $date == '') {
            $errors[] = 'Päivämäärä on pakollinen.';
        }

        if ($date != null && $date != '') {
            if (!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/", $this->date) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->date)) {
                $errors[] = 'Päivämäärä väärässä muodossa, oikea muoto: PP.KK.VVVV tai YYYY-MM-DD';
            }
        }
        return $errors;
    }

// EI TOIMI
//    public function date($date) {
//        $errors = array();
//        $d = date_create($date);
//        if (!$d) {
//            $e = date_get_last_errors();
//            foreach ($e['errors'] as $error) {
//                $errors[] = "$error\n";
//            }
//            exit(1);
//        }
//        if ($date == null || $date == '') {
//            $errors[] = 'Päivämäärä on pakollinen.';
//        }
//
//        if ($date != null && $date != '') {
//            if (!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/", $this->date) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->date)) {
//                $errors[] = 'Päivämäärä väärässä muodossa, oikea muoto: PP.KK.VVVV tai YYYY-MM-DD';
//            }
//        }
//
//        return $errors;
//    }

    public function validatenumber($number) {
        $boolean = FALSE;
        if ($number == null || $number == '') {
            $boolean = TRUE;
        }
        if (strpos($number, '.') || strpos($number, ',')) {
            $boolean = TRUE;
        }
        if (is_numeric($number) == FALSE) {
            $boolean = TRUE;
        }
        if ($number > 100) {
            $boolean = TRUE;
        }
        if ($number < -100) {
            $boolean = TRUE;
        }
        return $boolean;
    }

}
