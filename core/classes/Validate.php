<?php
class Validate{

    public static function escape($input){
        $input = trim(strip_tags($input));
        $input = stripslashes($input);
        $input = htmlentities($input, ENT_QUOTES);
        return $input;
    }

    public static function filterEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function length($input, $min, $max){
        if(strlen($input) > $max || strlen($input) < $min)
            return true;
    }


}
?>