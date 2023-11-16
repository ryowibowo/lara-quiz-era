<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Topic;
use App\Models\Result;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $getUser = User::where('role_id', '=', 'b319dbc4-5b29-4eef-9ec9-f83d8cb909a3')->count();
        $getTopic = $getTopics = Topic::count();

        $topics = Topic::all();
        $users = User::all();
        $userAverages = [];

        foreach ($users as $user) {
            // Get all scores for the current user
            $scores = Result::where('user_id', $user->id)->get();

            // Calculate average total score
            $average = $scores->avg('total_score');
            $userAverages[$user->id] = [
                'name' => $user->name,
                'average' => $average,
            ];
        }

        // Sort user averages array by average score in descending order
        usort($userAverages, function ($a, $b) {
            return $b['average'] - $a['average'];
        });

        return view('home', compact(
            'getUser',
            'getTopic',
            'userAverages'

        ));
    }
}
