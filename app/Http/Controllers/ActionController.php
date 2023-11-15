<?php

namespace App\Http\Controllers;

use App\Helpers\eKreative;
use Illuminate\Http\Request;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    public function index()
    {
        return view('pages.action.index');
    }

    public function getDatatables()
    {
        $data = Action::orderBy('created_at', 'ASC')->get();
        return DataTables::of($data)
            ->addColumn('actions', function ($data) {
                return '<button type="button" class="btn btn-success btn-xs" id="btnEdit" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="' . $data->id . '"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" id="btnDelete" title="Delete" data-id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request['created_by'] = eKreative::myId();
            $request['updated_by'] = eKreative::myId();

            $result = Action::create($request->all());

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil disimpan.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function edit($id)
    {
        $result = Action::find($id);

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = Action::find($id);
            $result->name = $request->name;
            $result->updated_by = eKreative::myId();
            $result->save();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil diupdate.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $result = Action::find($id);
            $result->updated_by = eKreative::myId();
            $result->delete();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil dihapus.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function getActions()
    {
        $result = Action::get();

        if ($result) {
            return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
        } else {
            return response()->json(['metaData' => ['code' => 404, 'message' => 'Data not found.'], 'response' => $result], 200);
        }
    }
}
