<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //
    public function checkInOrOut(Request $request)
    {

        $request->validate([
            'inner_code' => 'required|string|max:10|min:10',
            'check_time' => 'required|date_format:Y-m-d\TH:i'
        ]);
        $inner_code = $request->input('inner_code');
        $check_time = Carbon::parse($request->input('check_time'))->format('Y-m-d H:i');
        $clientIp = $request->ip();

        $check_person = Person::select('name')
            ->where('inner_code', $inner_code)
            ->where('status', 1)
            ->first();

        if (is_null($check_person)) {
            return response()->json(['success' => true, 'name' => '查無此人', 'message' => '無此卡號或未啟用'], 200);
        }


        $user_exist = CheckList::where('inner_code', $inner_code)
            ->orderByDesc('checkin_time')
            ->first();

        if (
            is_null($user_exist) ||
            ($user_exist->checkout_operation != 0)
        ) {
            // 當沒有資料時的處理
            CheckList::create([
                'inner_code' => $inner_code,
                'checkin_time' => $check_time,
                'checkin_operation' => 1,
                'checkin_ip' => $clientIp
            ]);
            return response()->json(['success' => true, 'name' => $check_person->name, 'message' => '簽到成功'], 200);
        } else {
            // 當有資料時的處理
            CheckList::where('id', $user_exist->id)
                ->update([
                    'checkout_operation' => 1,
                    'checkout_time' => $check_time
                ]);
            $check_person = Person::select('name')
                ->where('inner_code', $inner_code)
                ->first();

            return response()->json(['success' => true, 'name' => $check_person->name, 'message' => '簽退成功'], 200);
        }
    }

    public function showList()
    {
        $data = CheckList::leftJoin('person', 'checklist.inner_code', '=', 'person.inner_code')
            ->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function manualUpdateList(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'checkin_time' => 'required|date_format:Y-m-d\TH:i',
            'checkout_time' => 'required|date_format:Y-m-d\TH:i'
        ]);
        $id = $request->input('id');
        $checkin_time = Carbon::parse($request->input('checkin_time'))->format('Y-m-d H:i');
        $checkout_time = Carbon::parse($request->input('checkout_time'))->format('Y-m-d H:i');


        // 當有資料時的處理
        CheckList::where('id', $id)
            ->update([
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time
            ]);
        return response()->json(['success' => true], 200);
    }
}
