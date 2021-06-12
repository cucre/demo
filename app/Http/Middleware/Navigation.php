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

        /*$menu['Principal'] = [
            'url'     => route('home'),
            'active'  => (strpos($url, str_replace(url('/'), '', '/estadisticas')) !== false) ? 'active' : '',
            'icon'    => 'fas fa-money-bill-alt',
        ];*/

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

        if(auth()->user()->hasAnyRole(['Administrador'])) {
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

        return $menu;
    }
}