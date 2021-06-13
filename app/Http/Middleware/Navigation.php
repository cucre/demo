<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Navigation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(Auth::check()) {

            \Session::put('Breadcrumbs',collect([
                'Registrar'      => 'create',
                'Configuración'  => 'config',
                'Catálogos'      => 'list',
                'Control'        => 'control',
                'Editar'         => 'edit',
                'Codificación'   => 'codificacion',
                'Administración' => 'admin',
                'Principal'      => 'home',
            ]));

            \Session::put('Navigation', $this->menu());

        }

        return $next($request);

    }

    private function menu() {
        $url = str_replace(url('/'), '', url()->current());

        if(auth()->user()->hasAnyRole(['Administrador'])) {
            $menu['Configuración'] = [
                'url'     => 'javascript:;',
                'active'  => (strpos($url, str_replace(url('/'), '', '/config')) !== false) ? 'active' : '',
                'icon'    => 'fas fa-cogs',
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Usuarios',
                'url'    => route('usuarios.index'),
                'icon'   => 'fas fa-users',
                'active' => (strpos($url,str_replace(url('/'), '', '/usuarios')) !== false) ? 'active' : ''
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Permisos',
                'url'    => route('permisos.index'),
                'icon'   => 'fas fa-id-card',
                'active' => (strpos($url, str_replace(url('/'),'','/permisos')) !== false) ? 'active' : ''
            ];
        }

        if(auth()->user()->hasAnyRole(['Administrador', 'Coordinación académica'])) {
            $menu['Catálogos'] = [
                'url'     => 'javascript:;',
                'active'  => (strpos($url, str_replace(url('/'), '', '/list')) !== false) ? 'active' : '',
                'icon'    => 'fas fa-list',
            ];

            $menu['Catálogos']['submenu'][] =  [
                'name'   => 'Corporaciones',
                'url'    => route('corporaciones.index'),
                'icon'   => 'fas fa-ellipsis-h',
                'active' => (strpos($url, str_replace(url('/'), '', '/corporaciones')) !== false) ? 'active' : ''
            ];

            $menu['Catálogos']['submenu'][] =  [
                'name'   => 'Instructores',
                'url'    => route('instructores.index'),
                'icon'   => 'fas fa-ellipsis-h',
                'active' => (strpos($url, str_replace(url('/'), '', '/instructores')) !== false) ? 'active' : ''
            ];
        }

        if(auth()->user()->hasAnyRole(['Administrador', 'Instructor', 'Coordinación académica'])) {
            $menu['Control'] = [
                'url'     => 'javascript:;',
                'active'  => (strpos($url, str_replace(url('/'), '', '/list')) !== false) ? 'active' : '',
                'icon'    => 'fas fa-chalkboard-teacher',
            ];

            /*if(auth()->user()->hasPermissionTo('instructores.index')) {*/
                $menu['Control']['submenu'][] =  [
                    'name'   => 'Administrar cursos',
                    'url'    => route('corporaciones.index'),
                    'icon'   => 'fas fa-ellipsis-h',
                    'active' => (strpos($url, str_replace(url('/'), '', '/corporaciones')) !== false) ? 'active' : ''
                ];

                $menu['Control']['submenu'][] =  [
                    'name'   => 'Registro de estudiantes',
                    'url'    => route('corporaciones.index'),
                    'icon'   => 'fas fa-ellipsis-h',
                    'active' => (strpos($url, str_replace(url('/'), '', '/corporaciones')) !== false) ? 'active' : ''
                ];
            //}

            /*if(auth()->user()->hasPermissionTo('instructores.index')) {*/
                $menu['Control']['submenu'][] =  [
                    'name'   => 'Calificaciones por grupo',
                    'url'    => route('corporaciones.index'),
                    'icon'   => 'fas fa-ellipsis-h',
                    'active' => (strpos($url, str_replace(url('/'), '', '/corporaciones')) !== false) ? 'active' : ''
                ];

                $menu['Control']['submenu'][] =  [
                    'name'   => 'Calificaciones por estudiante',
                    'url'    => route('instructores.index'),
                    'icon'   => 'fas fa-ellipsis-h',
                    'active' => (strpos($url, str_replace(url('/'), '', '/instructores')) !== false) ? 'active' : ''
                ];
            //}

            /*if(auth()->user()->hasPermissionTo('instructores.index')) {*/
                $menu['Control']['submenu'][] =  [
                    'name'   => 'Control de estudiante',
                    'url'    => route('instructores.index'),
                    'icon'   => 'fas fa-ellipsis-h',
                    'active' => (strpos($url, str_replace(url('/'), '', '/instructores')) !== false) ? 'active' : ''
                ];
            //}
        }

        return $menu;
    }
}