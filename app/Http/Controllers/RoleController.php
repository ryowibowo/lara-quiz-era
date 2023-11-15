<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RolePrivileges;
use App\Models\Action;
use App\Models\MenuAction;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;
use App\Helpers\eKreative;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.role.index');
    }

    public function getDatatables()
    {
        $data = Role::where('name', '!=', 'Super Admin')->get();
        return DataTables::of($data)
            ->addColumn('actions', function ($data) {
                return '
                    <a href="' . route('roles.privileges', $data->id) . '" class="btn btn-success btn-xs" id="btnPrivileges" title="Set Privileges"><i class="fa fa-key"></i></a>
                    <button type="button" class="btn btn-success btn-xs" id="btnEdit" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="' . $data->id . '"><i class="fa fa-edit"></i></button>
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

            $result = Role::create($request->all());

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil disimpan.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function edit($id)
    {
        $result = Role::find($id);

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = Role::find($id);
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
            $result = Role::find($id);
            $result->updated_by = eKreative::myId();
            $result->delete();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil dihapus.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function privileges($id)
    {
        $roleData = Role::find($id);
        $listAction = Action::orderBy('created_at', 'ASC')->get();
        $listMenu = MenuAction::select([
            'menu_actions.*',
            'menus.id AS mId',
            'menus.name AS mName',
            DB::raw('group_concat(menu_actions.id) AS maId'),
            DB::raw('group_concat(menu_actions.action_id) AS maActionId')
        ])

            // ->with('actions')
            ->leftJoin('menus', 'menu_actions.menu_id', '=', 'menus.id')
            ->leftJoin('actions', 'menu_actions.action_id', '=', 'actions.id')
            ->where('menus.parent_id', '0')
            ->groupBy('menus.id')
            ->get();


        foreach ($listMenu as $menu) {
            $child = MenuAction::select([
                'menus.id AS mId',
                'menus.name AS mName',
                DB::raw('group_concat(menu_actions.id) AS id'),
                DB::raw('group_concat(menu_actions.action_id) AS actionId')
            ])
                // ->with('actions')
                ->leftJoin('menus', 'menu_actions.menu_id', '=', 'menus.id')
                ->leftJoin('actions', 'menu_actions.action_id', '=', 'actions.id')
                ->where('menus.parent_id', $menu->mId)
                ->groupBy('menus.id')
                ->get();

            if (count($child)) {
                $menu->children = $child;
            }
        }

        return view('pages.role.privileges', compact('roleData', 'listAction', 'listMenu'));
    }

    public function storePrivileges(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->has('actions')) {
                $search = RolePrivileges::where('role_id', $request->role_id)->whereNotIn('menuaction_id', $request->actions)->get();
                foreach ($search as $key) {
                    RolePrivileges::where([['role_id', $request->role_id], ['menuaction_id', $key->menuaction_id]])->delete();
                }
                foreach ($request->actions as $action) {
                    RolePrivileges::updateOrCreate(
                        [
                            'role_id' => $request->role_id,
                            'menuaction_id' => $action
                        ],
                        [
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                            'deleted_at' => null
                        ]
                    );

                    $searchParent = MenuAction::join('menus', 'menu_actions.menu_id', '=', 'menus.id')
                        ->where([['menu_actions.id', $action], ['menus.parent_id', '!=', '0']])
                        ->select('menus.parent_id AS id')
                        ->first();

                    if ($searchParent) {
                        $dataParent = MenuAction::join('actions', 'menu_actions.action_id', '=', 'actions.id')
                            ->where([['menu_id', $searchParent->id], ['actions.name', 'View']])
                            ->select('menu_actions.id AS id')
                            ->first();

                        RolePrivileges::updateOrCreate(
                            [
                                'role_id' => $request->role_id,
                                'menuaction_id' => $dataParent->id
                            ],
                            [
                                'created_by' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'deleted_at' => null
                            ]
                        );
                    }
                }
            } else {
                RolePrivileges::where('role_id', $request->role_id)->delete();
            }

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil disimpan.']], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }
}
