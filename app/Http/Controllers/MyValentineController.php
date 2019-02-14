<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MyValentineController extends Controller
{
    public function qrCode(){
        return view( 'valentines.qrcode' );
    }
    
    public function timedEvents(Request $request){
        $time = $request->input('time');
        $viewName = $this->getViewByCurrentTime($time);
        return view($viewName);
    }

    public function getViewByCurrentTime($time = null) {
        $carbonDate = $this->getTime( $time );
        $five_oclock = $this->getTime( "17:00" );
        $five_thirty = $this->getTime( "17:30" );
        $six_oclock = $this->getTime("18:00");
        $view = 'valentines.clues0';
        
        if( $six_oclock->lte( $carbonDate ) ){
            $view = 'valentines.clues3';
        }
        
        else if( $five_thirty->lte( $carbonDate ) ){
            $view = 'valentines.clues2';
        }
        else if( $five_oclock->lte( $carbonDate ) ){
            $view = 'valentines.clues1';
        }
        return $view;
    }

    private function getTime($time) {
        $zone = new \DateTimeZone("America/Los_Angeles");
        $timeString = "now";
        if( $time !== null ){
            $timeString = "2019-02-14 $time";
        }
        $time = new Carbon( $timeString, $zone );
        return $time;
    }

}
