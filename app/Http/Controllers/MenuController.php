<?php

namespace App\Http\Controllers;

use App\Helpers\eKreative;
use App\Models\Action;
use App\Models\Icons;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuAction;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $listAction = Action::orderBy('created_at', 'ASC')->get();
        $listIcons = Icons::where('class', 'fa')->orderBy('name', 'ASC')->get();

        return view('pages.menu.index', compact('listAction', 'listIcons'));
    }

    public function getDatatables(Menu $menu)
    {
        $data = $menu->get();
        return DataTables::of($data)
            ->editColumn('icon', function ($data) {
                return $data->icon . " <i class='fa " . $data->icon . " float-right'><i>";
            })
            ->addColumn('actions', function ($data) {
                return '<button type="button" class="btn btn-success btn-xs" id="btnEdit" title="Edit" data-bs-toggle="modal" data-bs-target="#EditModalForm" data-id="' . $data->id . '"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" id="btnDelete" title="Delete" data-id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['icon', 'actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request['created_by'] = eKreative::myId();
            $request['updated_by'] = eKreative::myId();

            $result = Menu::create($request->all());
            $menu_id = $result->id;

            if ($result) {
                if ($request->actions != null) {
                    foreach ($request->actions as $action) {
                        MenuAction::create([
                            'menu_id' => $menu_id,
                            'action_id' => $action,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil disimpan.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function edit($id)
    {
        $result = Menu::with('menuAction')->find($id);

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = Menu::find($id);
            $result->name = $request->name;
            $result->icon = $request->icon;
            $result->url = $request->url;
            $result->parent_id = $request->parent_id;
            $result->updated_by = eKreative::myId();
            $result->save();

            if ($request->actions != null) {
                foreach ($request->actions as $action) {
                    MenuAction::updateOrCreate(
                        [
                            'menu_id' => $id,
                            'action_id' => $action
                        ],
                        [
                            'updated_by' => Auth::user()->id,
                            'deleted_at' => null
                        ]
                    );
                }

                $search = MenuAction::where('menu_id', $id)->whereNotIn('action_id', $request->actions)->get();
                foreach ($search as $key) {
                    MenuAction::where([['menu_id', $id], ['action_id', $key->action_id]])->delete();
                }
            } else {
                MenuAction::where('menu_id', $id)->delete();
            }

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
            $result = Menu::find($id);
            $result->updated_by = eKreative::myId();
            $result->delete();

            MenuAction::where('menu_id', $id)->delete();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil dihapus.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function getParentMenu()
    {
        $result = Menu::where('parent_id', '0')->get();

        if ($result) {
            return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
        } else {
            return response()->json(['metaData' => ['code' => 404, 'message' => 'Data not found']], 200);
        }
    }
}
