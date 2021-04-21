<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    protected function createuser(Request $req)
    {
        $req->validate([

            'name' => 'required|string|min:2|max:50',   
            'phone' => 'required|numeric|regex:/(01)[0-9]{9}/',          
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',                
            'confirm_password' => 'required|min:6|max:20|same:password',

            ], [

                'name.required' => 'Name Is Required',
                'name.min' => 'Name must be at least 2 characters.',
                'name.max' => 'Name should not be greater than 50 characters.',
                'phone.required' => 'Phone Number Is Required',

            ]);

        $newUser=new User;
        $newUser->name = $req->name;
        $newUser->email = $req->email;  
        $newUser->password = ($req->password); 
         
        echo $newUser->save();  
        return view('loggedhome',['name'=>$newUser->name]);
    
    } 

    protected function loginuser(Request $req2)
    {
       
        $Allusers = DB::table('users');
        $Allusers=$Allusers->get();
        foreach ($Allusers as $thisuser):


            if ($thisuser->email == $req2->email)
            {
                $myUser=$thisuser;   
            }

        endforeach;

        if (empty($myUser)) {
            return view('notfound');
          }

        else{

       if ($myUser->password == $req2->password)
       {
        return view('loggedhome',['name'=>$myUser->name]);
       }

       else {
        return view('wrong');
       }

    }
       
    
    } 
    
           
}
