<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\CourtCase;
use App\TakesCases;


abstract class CaseBasedCollection extends Model
{
    use TakesCases;
    
    private $data = [];
    
    private function initializeKey( $key ){
        if( !isset( $this->data[ $key ] ) ){
            $className = $this->getKeyedClassType();
            $this->data[ $key ] = new $className();
        }
    }
    
    abstract protected function getKeyedClassType();

    abstract protected function getKeyFromCase(CourtCase $case);

    public function addCase( CourtCase $case ){
        $keyedElement = $this->getKeyedCollection($case);
        /* @var $keyedElement TakesCase */
        $keyedElement->addCase( $case );
    }

    protected function getKeyedCollection(CourtCase $case) {
        $key = $this->getKeyFromCase( $case );
        if( $key !== null ){
            $this->initializeKey($key);
            return $this->data[$key];
        }
    }

}
