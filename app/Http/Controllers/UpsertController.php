<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UpsertController extends Controller
{
    public function index()
    {
            // $users = DB::select("exec sp_select_all");
            $users = User::get();
  
        return response()->json([
            'results' => $users
        ], 200);
        
    }

    // public function show(Request $request)
    // {
    //     $AppUsers = DB::select('select * from App_Users where User_Code =?', [$request->UserCode]);
        
    //     return $AppUsers;
    
    //   $userCodes = [];
    //   foreach ($userCodes as $user) {
    //     $userCodes[] = $user->user_code;
    //   }
    
    //   return response()->json([
    //     'results' => $userCodes
    //   ], 200);
    // }

    public function show()
    {
        return Auth::user()->email;
    }
    
    

    public function store(Request $request) 
    {
         try {
            //  $val = json_encode($request);

             $value = $request->input();
             $val = json_encode($value);
          
        
            // DB::select("exec sp_insert 'qwerty'");
            DB::insert('exec sp_ref_zone_upsert ?,?', ['Upsert',$val]);


              return response()->json(['message' => 'Data inserted successfully'], 201);
         } catch (\Exception $e) {
               return response()->json(['message' => 'Error inserting data: ' . $e->getMessage()], 500);
         }
    }

    
    public function update(Request $request)
    {
        try {
            //  $val = json_encode($request);

             $value = $request->input();
             $val = json_encode($value);
          
        
            // DB::select("exec sp_insert 'qwerty'");
            DB::insert('exec sp_ref_zone_upsert ?', [$val]);


              return response()->json(['message' => 'Data inserted successfully'], 201);
         } catch (\Exception $e) {
               return response()->json(['message' => 'Error inserting data: ' . $e->getMessage()], 500);
         }
    }

    public function delete(Request $request, $userCode)
{
    $appUser = DB::table('App_Users')->where('User_Code', $userCode)->first();

    if (!$appUser) {
        return response()->json(['error' => 'User not found'], 404);
    }

    try {
        $appUser->delete();

        Log::info("User with User_Code $userCode deleted.");

        return response()->json(['message' => 'User deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error deleting user: ' . $e->getMessage()], 500);
    }
}   
}


