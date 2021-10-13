<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Return user information based on login credentials
     * TODO: password authentication using hash/salt(?)
     */
    public function logUserIn(Request $request){
        $email = urldecode($request->email);
        $password = urldecode($request->password);

        $user = User::where('userEmail', $email)->where('userPassword', $password)->first();
        return response()->json($user);
    }


    /**
     * For creating a new user
     * TODO: Error handling if email already exists,
     * TODO: password hashing before storing in db
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
     * TODO: error handling if cannot be saved to db, if user id doesn't exist (optional)
     * TODO: determine if updates done locally or here (if locally, change datetimes)
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
     * TODO: change return to custom object with HTTP status code and message 
     * TODO: error handling if cannot be saved to db, if user id doesn't exist (optional)
     */
    
    public function deleteUser($id){
        $user = User::find($id);
        $user->archiveDateTime = now()->toDateTimeString();
        $user->lastUpdateDateTime = now()->toDateTimeString();

        $user->save();
    }


}
