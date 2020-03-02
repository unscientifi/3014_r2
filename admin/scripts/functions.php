<?php 

function redirect_to($location){
    if($location != null){
        header("Location: ".$location);
        exit;
    }
}

// return the new string while using shuffle
function newString($str, $numString) {
    return substr(str_shuffle($str), 0 , $numString);
}