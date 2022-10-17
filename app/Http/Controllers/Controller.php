<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Route;
use App\Services\Permission;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getRouteAdmin()
    {
        $all = Route::getRoutes();
        $routes = [];
        foreach ($all as $route) {
            $name_route =  $route->getName();
            $admin_route = strpos($name_route, 'admin');
            if ($admin_route !== false) {
                $routes[] = $name_route;
            }
        }
        $permission = new Permission();
        $data = [];
        foreach ($routes as $key => $item) {
            $explodeItem = explode('.', $item);
            if (array_key_exists(2, $explodeItem)) {
                if (array_key_exists($explodeItem[2], $permission::TABLE_ACTION)) {
                    $data[$key]['name'] = $item;
                    $data[$key]['display_name'] = $permission->convertPermissionName($explodeItem);
                }
            }
        }

        return $data;
    }
}
