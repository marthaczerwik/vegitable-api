<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Return user information based on login credentials
     * Currently no authentication/hashing is used - for basic prototyping purposes
     */
    public function logUserIn(Request $request){
        $email = urldecode($request->email);
        $password = urldecode($request->password);

        $user = User::where('userEmail', $email)->where('userPassword', $password)->first();
        return response()->json($user);
    }


    /**
     * For creating a new user
     * Still need: methods to check if email exists, methods to hash password, methods to not allow null values where required
     */
    public function createUser(Request $request){
        $user = new User();

        $user->userEmail = $request->input('userEmail');
        $user->userPassword = $request->input('userPassword');
        $user->userFirstName = $request->input('userFirstName');
        $user->userLastName = $request->input('userLastName');
        $user->imageURL = $request->input('imageURL');
        $user->createDateTime = now()->toDateTimeString(); 
        $user->lastUpdateDateTime = now()->toDateTimeString();
        $user->save();

        return response()->json($user);
    }

    /**
     * Return single user to view their profile
     */
    public function getUser($id){
        return User::find($id);
    }

    /**
     * Update fields when user edits their profile
     * make sure front end displays password (hidden) otherwise will pass in password as null
     */ 
    public function updateUser(Request $request, $id){
        $user = User::find($id);
        
        $user->userEmail = $request->input('userEmail');
        $user->userPassword = $request->input('userPassword');
        $user->userFirstName = $request->input('userFirstName');
        $user->userLastName = $request->input('userLastName');
        $user->imageURL = $request->input('imageURL');
        $user->lastUpdateDateTime = now()->toDateTimeString();
        $user->save();

        return response()->json($user);
    }

    /**
     * if giving user option to delete their account, will archive them in user table
     */
    
    public function deleteUser($id){
        $user = User::find($id);
        $user->archiveDateTime = now()->toDateTimeString();
        $user->lastUpdateDateTime = now()->toDateTimeString();

        $user->save();
    }


}
