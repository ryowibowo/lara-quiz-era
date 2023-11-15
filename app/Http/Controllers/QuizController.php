<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\eKreative;
use App\Models\User;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Result;
use App\Models\ResultDetail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function index()
    {
        $getTopics = Topic::all();
        $topicCounts = [];

        foreach ($getTopics as $topic) {
            $questionsCount = $topic->questions->count();
            $topicCounts[$topic->id] = $questionsCount;
        }

        $averages = [];
        $maxScores = [];
        $totalSubmit = [];

        foreach ($getTopics as $topic) {
            $userId = eKreative::myId();

            // Get all scores for the current user and topic
            $scores = Result::where('topic_id', $topic->id)
                ->where('user_id', $userId)
                ->get();

            // Calculate average total score
            $average = $scores->avg('total_score');
            $averages[$topic->id] = $average;

            // Get maximum score
            $maxScore = $scores->max('total_score');
            $maxScores[$topic->id] = $maxScore;

            //total submit
            $total = $scores->count();
            $totalSubmit[$topic->id] = $total;
        }

        return view('pages.quiz.index', compact(
            'getTopics',
            'topicCounts',
            'averages',
            'maxScores',
            'totalSubmit'
        ));
    }

    public function start($id)
    {
        $result = Topic::find($id);
        $question = $result->questions;

        $startTime = date('Y-m-d H:i:s');
        $timeout = date('Y-m-d H:i:s', strtotime("+$result->time_duration minutes", strtotime($startTime)));
        $resultModel =  Result::create([
            'topic_id' => $result->id,
            'user_id' => eKreative::myId(),
            'start_time' => $startTime,
            'timeout' => $timeout,
            'total_score' => 0,
            'created_by' => eKreative::myId()
        ]);

        return view('pages.quiz.start', compact('result', 'question', 'resultModel'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $resultId = $request->result_id;
            $insertedValues = []; // Initialize an array to store inserted values

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'answer_') === 0) {
                    $questionId = substr($key, strlen('answer_'));

                    // Insert into the database
                    $resultDetail = ResultDetail::create([
                        'result_id' => $resultId,
                        'questions_id' => $questionId,
                        'answer' => $value,
                        'is_correct' => 0,
                        'created_by' => eKreative::myId()
                    ]);

                    // Store the inserted values in the array
                    $insertedValues[] = $resultDetail->toArray();
                }
            }

            // Get the topic and result details
            $getTopic = Result::leftJoin('result_details', 'results.id', '=', 'result_details.result_id')
                ->select('results.topic_id', 'results.id')
                ->first();

            // Get the correct answers for the topic
            $arrayAnswer = Question::where('topic_id', $getTopic->topic_id)
                ->pluck('answer'); // Use pluck to get an array of answers directly

            // Initialize a variable to store the count of correct answers
            $correctCount = 0;

            foreach ($insertedValues as $insertedValue) {
                // Check if the inserted answer is correct
                if (in_array($insertedValue['answer'], $arrayAnswer->toArray())) {
                    // If the answer is correct, update is_correct to 1 in the result_details table
                    ResultDetail::where('id', $insertedValue['id'])
                        ->update([
                            'is_correct' => 1
                        ]);
                    // Increment the correct count
                    $correctCount++;
                }
            }

            // Calculate the total score
            $countQuestion = Question::where('topic_id', $getTopic->topic_id)->count();
            $totalScore = round(($correctCount / $countQuestion) * 100);

            // Update the result with end_time and total_score
            Result::where('id', $resultId)->update([
                'end_time' => now(),
                'total_score' => $totalScore
            ]);

            DB::commit();

            return view('pages.quiz.finish', compact('totalScore'));
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 200);
        }
    }
}
