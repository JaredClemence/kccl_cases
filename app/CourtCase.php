<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string number
 * @property Carbon datetime
 * @property string location
 * @property string department
 * @property string hearingType
 */
class CourtCase extends Model
{
    
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
