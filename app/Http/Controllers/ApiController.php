<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Players;
use DB;

class ApiController extends Controller
{
    public function getplayers(){
    	$players = Players::selectRaw("id, CONCAT(first_name, ' ' ,second_name) AS full_name")
    	->get()
    	->toJson();
    	return $players;
    }

    public function getplayerdata(Request $request){
    	$playerCode = $request->code;
    	$playerCount = Players::where('code', $playerCode)->count();

    	if($playerCount==1){
    		$player = Players::where('code', $playerCode)
    		->get()
    		->toJson();
    		return $player;
    	}
    	else {
    		$result = new \stdClass();
    		$result->result = "Invalid player code";

    		print_r(json_encode($result));
    	}


    }
}
