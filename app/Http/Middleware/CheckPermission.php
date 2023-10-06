<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Closure;
use App\Models\Permission;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $admin = authAdmin();

        if ($admin != NULL) {
            $routeName = Route::currentRouteName();
            $link = Permission::where('guard_name', 'admin')->where('link', $routeName)->first();

            if ($link != NULL) {
                $hasLink = $admin->hasPermissionTo($link->name);
                if (!$hasLink) {
                    if (request()->wantsJson() || request()->ajax())
                        return response_api(false, 403, 'error you don\'t have permission to do that', []);
                    else {
                        session()->flash('error', 'You don\'t have permission to do that');

                        if (authAdmin()) {
                            $firstPermission = authAdmin()->getAllPermissions()->where('link', '<>', '#')->first();
                        }

                        if (isset($firstPermission)) {
                            return redirect()->route($firstPermission->link);
                        }

                        return redirect(route('no-access'));
                    }
                } else {
                    session()->flash('permission_id', $link->id);
                    return $next($request);
                }
            }
        }

        return $next($request);
    }
}
