<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UserController extends Controller
{

    public function __construct(Firebase $firebase)
    {
        $this->firebase = $firebase;
    }

    function register(Request $request) {
        $email = 'metalkaiserpolanco@gmail.com';
        $name = 'Juan';
        $lastname = 'Polanco';
        $role = 0;
        $theme = 0;
        try {
            $newuser = $this->firebase::auth()
            ->createUserWithEmailAndPassword($email,'alarm593f91w');

            $database = $this->firebase::database();

            $newUserRecord = $database->getReference('users')->push([
                'uid' => $newuser->uid,
                'email' => $email,
                'name' => $name,
                'lastname' => $lastname,
                'role' => $role,
                'theme' => $theme,
            ]);
        } catch (\Throwable $th) {
            return $th;
        }

        return $newUserRecord;

        //return $this->firebase::database()->getReference('products')->getValue();
    }

    function database(Request $request) {
        $email = 'metalkaiserpolanco@gmail.com';

        $usersRef = $this->firebase::database()->getReference('users')
        ->orderByChild('email')->equalTo($email)->getValue();

        return $usersRef;
    }
}
