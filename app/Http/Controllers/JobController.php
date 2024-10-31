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
        $check_time = Carbon::parse($request->input('check_time'));
        $clientIp = $request->ip();

        $check_person = Person::select('name')
            ->where('inner_code', $inner_code)
            ->where('status', 1)
            ->first();

        if (is_null($check_person)) {
            return response()->json(['success' => true, 'name' => '查無此人', 'message' => '無此卡號或未啟用', 'checkIP' => $clientIp], 200);
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
                'checkin_time' => $check_time->format('Y-m-d H:i'),
                'checkin_ip' => $clientIp,
                'checkin_operation' => 1

            ]);
            return response()->json(['success' => true, 'name' => $check_person->name, 'message' => '簽到成功', 'checkIP' => $clientIp], 200);
        } else {
            $checkin_time = Carbon::parse($user_exist->checkin_time);

            if ($checkin_time->diffInMinutes($check_time) < 2) {
                return response()->json(['success' => true, 'name' => '打卡間隔時間過快', 'message' => '如有需要請手動簽退'], 200);
            }
            // 當有資料時的處理
            CheckList::where('id', $user_exist->id)
                ->update([
                    'checkout_operation' => 1,
                    'checkout_time' => $check_time->format('Y-m-d H:i'),
                    'checkout_ip' => $clientIp
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
            ->orderByDesc('checkin_time')
            ->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function showListCondition(Request $request)
    {
        $name = $request->input('name');
        $stuid = $request->input('stuid');
        $year = $request->input('year');
        $month = $request->input('month');
        $in_place = $request->input('in_place');
        $out_place = $request->input('out_place');

        $place_to_ip = array(
            'jinde' => '10.21.44.148',
            'baosan' => '10.21.44.35'
        );

        $data = CheckList::leftJoin('person', 'checklist.inner_code', '=', 'person.inner_code');

        if ($name != '') {
            $data->where('name', $name);
        }
        if ($stuid != '') {
            $data->where('stu_id', $stuid);
        }
        if ($year != '') {
            $data->whereYear('checkin_time', $year);
        }
        if ($month != '') {
            $data->whereMonth('checkin_time', $month);
        }
        if ($in_place != '') {
            if ($in_place == 'other') {
                $excludedIps = array_values($place_to_ip);
                $data->whereNotIn('checkin_ip', $excludedIps);
            } else {
                $data->where('checkin_ip', $place_to_ip[$in_place]);
            }
        }
        if ($out_place != '') {
            if ($out_place == 'other') {
                $excludedIps = array_values($place_to_ip);
                $data->whereNotIn('checkout_ip', $excludedIps);
            } else {
                $data->where('checkout_ip', $place_to_ip[$out_place]);
            }
        }

        $result = $data->orderByDesc('checkin_time')->get();
        return response()->json(['success' => true, 'data' => $result]);
    }

    public function genMonthTable(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'month' => 'required'
        ]);

        $year = $request->input('year');
        $month = $request->input('month');

        $ip_to_place = array(
            '10.21.44.148' => 'jinde',
            '10.21.44.35' => 'baosan',
            '120.107.148.249' => 'manual'
        );

        $locationAllowances = [
            'jinde' => 120,
            'baosan' => 30,
            'manual' => 0,
        ];

        $data = CheckList::join('person', 'checklist.inner_code', '=', 'person.inner_code')
            ->whereYear('checkin_time', $year)
            ->whereMonth('checkin_time', $month)
            ->orderBy('person.stu_id')
            ->orderBy('checklist.checkin_time')
            ->get()
            ->groupBy('stu_id');

        $result = [];
        foreach ($data as $employeeId => $records) {
            $employeeInfo = $records->first();
            $totalAllowance = 0;
            $work_cnt = 0;
            $reportRow = [
                'name' => $employeeInfo->name,
                'stu_id' => $employeeId
            ];

            foreach ($records as $record) {
                $place = $ip_to_place[$record->checkin_ip] ?? 'manual';

                $allowance = $locationAllowances[$place] ?? 0;
                $totalAllowance += $allowance;

                $reportRow[] = "{$record->checkin_time}; {$place}; $allowance";
                $work_cnt += 1;
            }
            $reportRow['totalWorkCnt'] = $work_cnt;
            $reportRow['totalAllowance'] = $totalAllowance;
            $result[] = $reportRow;
        }
        return response()->json(['success' => true, 'data' => $result]);
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
                'checkout_time' => $checkout_time,
                'checkin_operation' => 2,
                'checkout_operation' => 2
            ]);
        return response()->json(['success' => true], 200);
    }
}
