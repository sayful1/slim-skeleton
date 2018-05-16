<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class ApiUserController extends ApiController
{
    public function login(Request $request, Response $response)
    {
        $username = $request->getParam('username');
        $key      = $request->getParam('key');

        if ($username == null || $key == null) {
            return $this->jsonFail('Username and key are required');
        }

        // Find the user's keys and see if the one we have is in it
        $user = User::where(['username' => $username])->first();
        if ($user == null) {
            return $this->jsonFail('Invalid credentials');
        }

        $keys  = $user->keys;
        $found = $keys->pluck('key')->search($key);
        if ($found === false) {
            return $this->jsonFail('Invalid credentials');
        }

        if ($keys[$found]->status !== 'active') {
            return $this->jsonFail('Invalid credentials');
        }

        return $this->jsonSuccess([
            'session' => Session::start($user, $keys[$found])
        ]);
    }
}