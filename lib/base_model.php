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

//    public function validatedate($string, $errors) {
//        if (!preg_match('[0-3][0-9].(([0][1-9])|([1][0-2])).[0-9][0-9][0-9][0-9]', $string)) {
//            $errors[] = 'Päivämäärä väärässä muodossa';
//        }
//        return $errors;
//    }
    public function validatedate($date) {
        $errors = array();

        if ($this->date != null && $this->date != '') {
            if (!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/", $this->date) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->date)) {
                $errors[] = 'Päivämäärä väärässä muodossa, oikea muoto: PP.KK.VVVV tai YYYY-MM-DD';
            }
        }
        return $errors;
    }

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
        return $boolean;
    }

}
