<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    //

    public function showUserFull(Request $request)
    {
        $user_info = Person::orderBy('stu_id')
            ->get();

        return response()->json(['success' => true, 'data' => $user_info], 200);
    }

    public function addUser(Request $request)
    {
        //$name = $request->input('name');
        $inner_code = $request->input('inner_code');
        $stu_id = $request->input('stu_id');
        $status = $request->input('status');

        if ($status == 'd') {
            $status = 0;
        } elseif ($status == 'u') {
            $status = 1;
        }

        $user_exist = Person::where('inner_code', $inner_code)->first();

        if (is_null($user_exist)) {
            // 當沒有資料時的處理
            Person::create([
                //'name' => $name,
                'inner_code' => $inner_code,
                'stu_id' => $stu_id,
                'status' => $status,
                'checked' => false
            ]);
            return response()->json(['success' => true, 'message' => '資料已新增'], 200);
        } else {
            // 當有資料時的處理
            Person::where('inner_code', $inner_code)->update(
                [
                    'status' => $status,
                    //'name' => $name,
                    'stu_id' => $stu_id
                ]
            );
            return response()->json(['success' => true, 'message' => '資料已更新'], 200);
        }
    }
    public function checked(Request $request)
    {

        $request->validate([
            'inner_code' => 'required|string|max:10|min:10',
            'check_time' => 'required|date_format:Y-m-d\TH:i'
        ]);
        $inner_code = $request->input('inner_code');
        $check_time = Carbon::parse($request->input('check_time'));
        $clientIp = $request->ip();

        $check_person = Person::where('inner_code', $inner_code)
            ->where('status', 1)
            ->first();

        if (is_null($check_person)) {
            return response()->json(['success' => true, 'name' => '查無此人', 'message' => '無此卡號或未啟用', 'checkIP' => $clientIp], 200);
        }

        $isChecked = Person::where('inner_code', $inner_code)
            ->where('checked', operator: true)
            ->exists();

        if ($isChecked) {
            return response()->json(['success' => true, 'name' => $check_person->stu_id, 'message' => '已領取過'], 200);
        }

        Person::where('inner_code', $inner_code)
            ->update(
                [
                    'check_time' => $check_time,
                    'checked' => true
                ]
            );

        return response()->json(['success' => true, 'name' => $check_person->stu_id, 'message' => '可領取'], 200);
    }
}
