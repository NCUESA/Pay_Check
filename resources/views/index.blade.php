@extends('layouts.template')

@section('content')
    <br>
    <h2 class="name-cn" style="font-size: 52px">現在時間： <span class="badge bg-secondary" id="now_time"></span></h2>
    <hr>
    <div class="input-group input-group-lg">
        <span class="input-group-text" id="">打卡欄位</span>
        <input type="text" class="form-control" placeholder="請嗶卡" aria-label="" aria-describedby="basic-addon1"
            id="check_input" inputmode="numeric">
    </div>
    <hr>
    <div class="row">
        <div class="input-group input-group-lg">
            <span class="input-group-text" id="">人員</span>
            <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1"
                disabled id="person">
            <span class="input-group-text" id="">打卡時間</span>
            <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1"
                disabled id="check_time">
            <span class="input-group-text" id="">打卡狀態</span>
            <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1"
                disabled id="check_status">
        </div>
    </div>
@endsection
