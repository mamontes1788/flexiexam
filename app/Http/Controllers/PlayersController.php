<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Players;

class PlayersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function storeplayers(){
    	$data = file_get_contents("https://fantasy.premierleague.com/api/bootstrap-static/");
    	$playersJson = json_decode($data);
    	$players = $playersJson->elements;
    	$saveCount = 0;
    	$playerCodes = Players::pluck('code')->toArray();
    	foreach($players as $player){
    		if (!in_array($player->code, $playerCodes)){
    			$savePlayer = new Players();
    			$savePlayer->id = $player->id;
    			$savePlayer->code = $player->code;
    			$savePlayer->first_name = $player->first_name;
    			$savePlayer->second_name = $player->second_name;
    			$savePlayer->team = $player->team;
    			$savePlayer->team_code = $player->team_code;
    			$savePlayer->photo = $player->photo;
    			$savePlayer->form = $player->form;
    			$savePlayer->total_points = $player->total_points;
    			$savePlayer->influence = $player->influence;
    			$savePlayer->creativity = $player->creativity;
    			$savePlayer->threat = $player->threat;
    			$savePlayer->ict_index = $player->ict_index;
    			$savePlayer->save();
    			$saveCount++;
    		}
    		if($saveCount==100){
    			break;
    		}
    	}
    }
}
