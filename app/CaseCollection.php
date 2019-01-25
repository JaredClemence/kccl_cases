<?php

namespace App;

use Illuminate\Support\Collection;
use App\CourtCase;
use App\TakesCases;

class CaseCollection extends Collection
{
    use TakesCases;
    
    public function addCase(CourtCase $case) {
        if( $this->search($case, true) === false ){
            $this->push( $case );
        }
    }
    
    public function filterByHearingType( $partialText ) : Collection {
        $copy = $this->filter( function( CourtCase $case ) use ( $partialText ) {
            /* @var $case CourtCase */
            return $case->hasType($partialText);
        } );
        return $copy;
    }
}
