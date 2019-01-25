<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;
use App\CourtCase;
/**
 *
 * @author jaredclemence
 */
trait TakesCases {
    abstract public function addCase( CourtCase $case );
    abstract public function filterByHearingType( string $searchText );
    abstract public function count();
}
