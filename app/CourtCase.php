<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourtCase extends Model
{
    public $name;
    public $number;
    public $datetime;
    public $location;
    public $department;
    public $hearingType;
    
    public function hasType( $text ){
        return strstr( $this->hearingType, $text ) !== false;
    }
    
    public function getDateString(){
        return $this->datetime->format( "l, F jS" );
    }
    
    public function getTimeString(){
        return $this->datetime->format( "g:ia (Hi\h\r\s)" );
    }
    
    public function getCourtName(){
        return $this->location;
    }
}
