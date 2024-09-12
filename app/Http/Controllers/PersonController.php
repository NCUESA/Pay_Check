<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    //

    public function showUserFull(Request $request)
    {
        $user_info = Person::all();

        return response()->json(['success' => true, 'data' => $user_info], 200);
    }

    public function addUser(Request $request)
    {
        $name = $request->input('name');
        $inner_code = $request->input('inner_code');
        $status = $request->input('status');

        if ($status == 'd') {
            $status = 0;
        } elseif ($status == 'u') {
            $status = 1;
        }

        $user_exist = Person::where('name', $name)->first();

        if (is_null($user_exist)) {
            // 當沒有資料時的處理
            Person::insert([
                'name' => $name,
                'inner_code' => $inner_code,
                'status' => $status
            ]);
            return response()->json(['success' => true, 'message' => '資料已新增'], 200);
        } else {
            // 當有資料時的處理
            Person::where('name', $name)->update(['status' => $status]);
            return response()->json(['success' => true, 'message' => '資料已更新'], 200);
        }
    }

}
