<?php

namespace App\Http\Controllers;

use App\Models\AuthIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IPController extends Controller
{
    //
    public function showIP(Request $request)
    {
        $ip_info = AuthIp::all();

        return response()->json(['success' => true, 'data' => $ip_info], 200);
    }

    public function addIP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip' => 'required',
            'description' => 'max:50'
        ]);
        $id = $request->input('id');
        $ip = $request->input('ip');
        $status = $request->input('status');
        $description = $request->input('description');

        if ($status == 'd') {
            $status = 0;
        } elseif ($status == 'u') {
            $status = 1;
        }

        $ip_exist = AuthIp::where(['id' => $id])
            ->exists();

        if ($ip_exist) {
            AuthIp::where(['id' => $id])
                ->update(['ip_address' => $ip, 'status' => $status, 'description' => $description]);
        } else {
            AuthIP::create(['id' => $id, 'ip_address' => $ip, 'status' => $status, 'description' => $description]);
        }

        //AuthIp::where('ip_address', $ip)->update(['status' => $status]);
        return response()->json(['success' => true, 'message' => '資料已更新'], 200);
    }
    public function deleteIP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'ip' => 'required',
            'description' => 'max:50'
        ]);
        $id = $request->input('id');

        $res = AuthIP::where('id', $id)
            ->delete();

        if($res){
            return response()->json(['success' => true, 'message' => '資料已更新'], 200);
        }
        else{
            return response()->json(['success' => true, 'message' => '無資料'], 500);
        }
       
    }
}
