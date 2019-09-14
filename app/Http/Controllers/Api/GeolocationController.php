<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Console\Input;

class GeolocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request, $lat, $long)
    {
    	$geol1 = array(floatval($lat), floatval($long));        
    	$geol2 = array(56.474267, 84.951506);
        $distance = $this->getDistanceBetweenTwoPoints($geol1, $geol2);

        //echo " ", $distance, " ";

        if ($distance < 300) {
        	return json_encode("OK");
        } else {
        	return json_encode("Too far");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
    	$lattt = 0;
        //dd($lattt);
        
    	$geol1 = array(56.474267, 84.951506);
    	$geol2 = array(56.472092, 84.950715);
        $distance = $this->getDistanceBetweenTwoPoints($geol1, $geol2);

        echo $distance, " ";

        if ($distance < 300) {
        	echo "OK";
        } else {
        	echo "Too far";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDistanceBetweenTwoPoints($point1 , $point2)
    {
	    // array of lat-long i.e  $point1 = [lat,long]
	    $earthRadius = 6371 * 1000;  // earth radius in m
	    $point1Lat = $point1[0];
	    $point2Lat = $point2[0];
	    $deltaLat = deg2rad($point1Lat - $point2Lat);
	    $point1Long = $point1[1];
	    $point2Long = $point2[1];
	    $deltaLong = deg2rad($point2Long - $point1Long);
	    $a = sin($deltaLat/2) * sin($deltaLat/2) + cos(deg2rad($point1Lat)) * cos(deg2rad($point2Lat)) * sin($deltaLong/2) * sin($deltaLong/2);
	    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

	    $distance = $earthRadius * $c;
	    return $distance;    // in m
	}
}
