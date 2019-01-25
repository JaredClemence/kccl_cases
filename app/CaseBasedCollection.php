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
    
    public function __clone() {
        foreach( $this->data as &$value ){
            $value = clone $value;
        }
    }
    
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
    

    public function count() {
        $count = 0;
        foreach( $this->data as $countable ){
            $count += $countable->count();
        }
        return $count;
    }

    public function filterByHearingType(string $searchText) {
        $clone = clone $this;
        foreach( $clone->data as $key=>$value ){
            $newValue = $value->filterByHearingType( $searchText );
            $clone->data[$key] = $value;
            if( $value->count() == 0 ){
                unset( $clone->data[$key] );
            }
        }
    }

}
