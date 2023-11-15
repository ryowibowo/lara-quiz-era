<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

use App\Models\MenuAction;
use App\Models\RolePrivileges;
use Illuminate\Support\Facades\Request;

class eKreative
{
    public static function myId()
    {
        return Auth::user()->id;
    }

    public static function myName()
    {
        return Auth::user()->name;
    }

    public static function myrole_id()
    {
        return Auth::user()->role->id;
    }

    public static function myRoleName()
    {
        return Auth::user()->role->name;
    }

    public static function myRolePrivileges()
    {
        return Auth::user()->role->rolePrivileges;
    }

    public static function isSuperAdmin()
    {
        if (self::myRoleName() == "Super Admin") {
            return true;
        }

        return false;
    }

    public static function getModulePath()
    {
        return Request::path();
    }

    public static function getModuleUrl($menuaction_id = null, $actionName = null)
    {
        return MenuAction::join('menus', 'menu_actions.menu_id', '=', 'menus.id')
            ->join('actions', 'menu_actions.action_id', '=', 'actions.id')
            ->where([
                ['menu_actions.id', $menuaction_id],
                ['actions.name', $actionName]
            ])
            ->select('menus.url')
            ->first();
    }

    public static function isView()
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        $roles = self::myRolePrivileges();
        foreach ($roles as $role) {
            $data = self::getModuleUrl($role->menuaction_id, 'View');
            if ($data) {
                if ($data->url == self::getModulePath()) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function isCreate()
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        $roles = self::myRolePrivileges();
        foreach ($roles as $role) {
            $data = self::getModuleUrl($role->menuaction_id, 'Create');
            if ($data) {
                if ($data->url == self::getModulePath()) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function isRead()
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        $roles = self::myRolePrivileges();
        foreach ($roles as $role) {
            $data = self::getModuleUrl($role->menuaction_id, 'Read');
            if ($data) {
                if ($data->url == self::getModulePath()) {
                    return true;
                }
            }
        }
    }

    public static function isUpdate()
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        $roles = self::myRolePrivileges();
        foreach ($roles as $role) {
            $data = self::getModuleUrl($role->menuaction_id, 'Update');
            if ($data) {
                if ($data->url == self::getModulePath()) {
                    return true;
                }
            }
        }
    }

    public static function isDelete()
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        $roles = self::myRolePrivileges();
        foreach ($roles as $role) {
            $data = self::getModuleUrl($role->menuaction_id, 'Delete');
            if ($data) {
                if ($data->url == self::getModulePath()) {
                    return true;
                }
            }
        }
    }

    public static function getMenuAction($menu_id = null, $action_id = null)
    {
        return MenuAction::where([['menu_id', $menu_id], ['action_id', $action_id]])->first();
    }

    public static function getRolePrivileges($role_id = null, $menuaction_id = null)
    {
        return RolePrivileges::where([['role_id', $role_id], ['menuaction_id', $menuaction_id]])->first();
    }

    public static function sidebarMenu()
    {
        // $menus = RolePrivileges::join('menu_actions', 'role_privileges.menuaction_id', '=', 'menu_actions.id')
        $menus = MenuAction::join('menus', 'menu_actions.menu_id', '=', 'menus.id')
            ->join('actions', 'menu_actions.action_id', '=', 'actions.id')
            ->when(self::myRoleName() != 'Super Admin', function ($query) {
                $query->whereRaw("menu_actions.id IN (SELECT menuaction_id from role_privileges where role_id = '" . self::myrole_id() . "')");
            })
            ->where([
                ['menus.parent_id', '0'],
                ['actions.name', 'View']
            ])
            ->whereNull('menus.deleted_at')
            ->select('menus.*')
            ->get();

        foreach ($menus as $menu) {
            // $child = RolePrivileges::join('menu_actions', 'role_privileges.menuaction_id', '=', 'menu_actions.id')
            $child = MenuAction::join('menus', 'menu_actions.menu_id', '=', 'menus.id')
                ->join('actions', 'menu_actions.action_id', '=', 'actions.id')
                ->when(self::myRoleName() != 'Super Admin', function ($query) {
                    $query->whereRaw("menu_actions.id IN (SELECT menuaction_id from role_privileges where role_id = '" . self::myrole_id() . "')");
                })
                ->where([
                    ['menus.parent_id', $menu->id],
                    ['actions.name', 'View']
                ])
                ->whereNull('menus.deleted_at')
                ->select('menus.*')
                ->get();

            if (count($child)) {
                $menu->children = $child;
            }
        }

        return $menus;
    }

    // public static function featherIcon($name = null, $print = false)
    // {
    //     $icons = new \Feather\Icons();

    //     return $icons->get($name, ['width' => 18, 'height' => 18], $print);
    // }
}
