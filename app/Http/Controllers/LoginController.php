<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use function Laravel\Prompts\password;

class LoginController extends Controller
{
    public function getView(){
        return view('login');
    }

    public function getRegisterView(){
        return view('register');
    }

    public function validateCredentials(){
        $name = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        $user = User::where('email', $name)->first();



        if ($user == null) return redirect()->back()->with('message', 'Email no registrado.');



        if ( !password_verify($password, $user->password)) return redirect()->back()->with('message', 'Contraseña incorrecta.');

        session_start();

        $_SESSION['userId'] = $user->id;
        $_SESSION['userName'] = $user->name;

        return redirect(route('listBillfold'));
    }

    public function register(Request $request){
        if (!isset($request['password']) ||
            !isset($request['confirm-password']) ||
            !isset($request['email']) ||
            !isset($request['name']) ||
            !isset($request['ruc'])
        ) {
            error_log("Error en los datos");
            return redirect()->back()->with('message', 'Faltan datos necesarios para el proceso de registro.');
        }

        $tempUser = User::where('email', $request['email'])->first();
        if ($tempUser != null) { return redirect()->back()->with('message', 'El email ya existe.'); }

        $newUser = new User();
        $newUser->email = $request['email'];
        $newUser->password = password_hash($request['password'], PASSWORD_DEFAULT);
        $newUser->name = $request['name'];
        $newUser->ruc = $request['ruc'];
        $newUser->save();



        session_start();

        $user = User::where('email', $request['email'])->first();

        $_SESSION['userId'] = $user->id;
        $_SESSION['userName'] = $user->name;

        return redirect(route('listBillfold'));

        //error_log($request['password']);
    }

    public function logout(){
        session_start();
        session_destroy();
        return redirect(route('loginView'));
    }
}
