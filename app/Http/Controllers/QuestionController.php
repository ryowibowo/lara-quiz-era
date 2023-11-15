<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\eKreative;
use App\Models\User;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;


class QuestionController extends Controller
{
    public function index()
    {
        return view('pages.master.question.index');
    }

    public function storeTopic(Request $request)
    {
        DB::beginTransaction();
        try {
            $request['created_by'] = eKreative::myId();
            $request['updated_by'] = eKreative::myId();

            $result = Topic::create($request->all());

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil disimpan.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }
    public function getDatatables()
    {
        $data = Topic::orderBy('created_at', 'ASC')->get();
        return DataTables::of($data)
            ->addColumn('actions', function ($data) {
                return '<button type="button" class="btn btn-success btn-xs" id="btnEdit" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="' . $data->id . '"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" id="btnDelete" title="Delete" data-id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function editTopic($id)
    {
        $result = Topic::find($id);

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }

    public function updateTopic($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = Topic::find($id);
            $result->name = $request->name;
            $result->time_duration = $request->time_duration;
            $result->updated_by = eKreative::myId();
            $result->save();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil diupdate.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function destroyTopic($id)
    {
        DB::beginTransaction();
        try {
            $result = Topic::find($id);
            $result->updated_by = eKreative::myId();
            $result->delete();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil dihapus.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function detail($id)
    {
        $result = Topic::find($id);
        $question = $result->questions;
        return view('pages.master.question.detail', compact('result', 'question'));
    }

    public function create($id)
    {
        $result = Topic::find($id);
        return view('pages.master.question.create', compact('result'));
    }

    public function storeQuestion($id, Request $request)
    {
        $topic = Topic::find($id);

        $question = Question::create([
            'questions' => $request->questions,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'is_active' => $request->is_active,
            'answer' => $request->answer,
            'created_by' => eKreative::myId(),
            'topic_id' => $topic->id,
        ]);
        Session::flash('message_alert', 'Success Saved');

        return redirect()->route('question.detail', $topic->id);
    }

    public function getDatatablesQuestion($id)
    {
        $topic = Topic::find($id);
        $data = $topic->questions;

        return DataTables::of($data)
            ->addColumn('actions', function ($data) {
                return '<button type="button" class="btn btn-success btn-xs" id="btnEdit" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="' . $data->id . '"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" id="btnDelete" title="Delete" data-id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function edit($id)
    {
        $result = Question::find($id);
        return view('pages.master.question.edit', compact('result'));
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = Question::find($id);
            $result->questions = $request->questions;
            $result->option_a = $request->option_a;
            $result->option_b = $request->option_b;
            $result->option_c = $request->option_c;
            $result->option_d = $request->option_d;
            $result->option_e = $request->option_e;
            $result->answer = $request->answer;
            $result->updated_by = eKreative::myId();
            $result->save();

            DB::commit();
            Session::flash('message_alert', 'Success Saved');
            return redirect()->route('question.detail', $result->topic_id);
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Error: ' . $e->getMessage());
            return redirect()->route('question.detail', $result->topic_id);
        }
    }

    function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        Session::flash('message_alert', 'Success Deleted');
        return redirect()->route('question.detail', $question->topic->id);
    }
}
