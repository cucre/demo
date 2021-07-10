<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\ChangePasswordRequest;
use Auth, Hash;

class ChangePasswordController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:change_password')->only(['index', 'changePassword']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('auth.passwords.change');
    }

    public function changePassword(ChangePasswordRequest $request) {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', '¡La contraseña actual no coincide!');
        }

        $user->password = $request->password;
        $user->save();

        return redirect()->route('logout');
    }
}