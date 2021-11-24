<?php

namespace App\Http\Controllers;

use App\Models\KoliItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 404);   
        }

        foreach($request->user as $user){
            $data[] = User::where('email', $user)->with('koli')->first();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data All User',
            'data' => $data,
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Users' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 404);   
        }

        foreach($request->Users as $user){
            User::create([
                'email' => $user,
            ]);
        }

        return response()->json([], 204);
    }

    public function addKoli(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'koli' => 'required',
            'item' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 404);   
        }

        $user = User::where('email', $request->user)->first();
        if($user == null){
            return response()->json(['error' => 'user not found'], 404);
        }

        $user->update([
            'koli' => $request->koli,
        ]);

        foreach($request->item as $item){
            $cek = KoliItems::where([
                ['id_user', $user->id],
                ['name', $item['name']]
            ])->first();
            if($cek == null){
                KoliItems::create([
                    'id_user' => $user->id,
                    'name' => $item['name'],
                    'quantity' => $item['qty'] 
                ]);
            }else{
                $total = $cek->quantity + $item['qty'];
                KoliItems::where([
                    ['id_user', $user->id],
                    ['name', $item['name']]
                ])->update([
                    'quantity' => $total
                ]);
            }
        }

        return response()->json([], 204);
    }
    
    public function removeKoli(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'koli' => 'required',
            'item' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 404);   
        }

        $user = User::where('email', $request->user)->first();
        if($user == null){
            return response()->json(['error' => 'user not found'], 404);
        }

        $user->update([
            'koli' => $request->koli,
        ]);

        foreach($request->item as $item){
            $cek = KoliItems::where([
                ['id_user', $user->id],
                ['name', $item['name']]
            ])->first();
            if($cek == null){
                return response()->json(['error' => 'item not found in koli of this user'], 404);
            }else{
                $total = $cek->quantity - $item['qty'];
                if($total <= 0){
                    KoliItems::where([
                        ['id_user', $user->id],
                        ['name', $item['name']]
                    ])->delete();
                }
                KoliItems::where([
                    ['id_user', $user->id],
                    ['name', $item['name']]
                ])->update([
                    'quantity' => $total
                ]);
            }
        }
        
        return response()->json([], 204);
    }


}
