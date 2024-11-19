@extends('layouts.template')

@section('content')
<form id='edit_list'>
    <h6><strong>請注意，此輸入並不防呆，送出前請先再三確認!!!</strong></h6>
    <!--<div class="row g-3 align-items-center">
        <div class="col-1">
            <label for="id" class="col-form-label">ID(系統自帶)</label>
        </div>
        <div class="col-1">
            <input type="input" id="id" class="form-control" placeholder="ID" required disabled>
        </div>
        <div class="col-1">
            <label for="add_person" class="col-form-label">人員名稱(系統自帶)</label>
        </div>
        <div class="col-3">
            <input type="input" id="add_person" class="form-control" placeholder="" required>
        </div>
        <div class="col-1">
            <label for="inner_code" class="col-form-label">學號(系統自帶)</label>
        </div>
        <div class="col-3">
            <input type="input" id="stu_id" class="form-control" placeholder="" required>
        </div>
        <div class="col-2 d-grid gap-2">
            <button type="submit" class="btn btn-success btn-block">手動簽到退</button>
        </div>

        <div class="col-1">
            <label for="checkin_time" class="col-form-label">逼取時間</label>
        </div>
        <div class="col-4">
            <input type="datetime-local" id="checkin_time" class="form-control" placeholder="" required step="60">
        </div>
        <div class="col-1">
            <label for="checkout_time" class="col-form-label">簽退時間</label>
        </div>
        <div class="col-4">
            <input type="datetime-local" id="checkout_time" class="form-control" placeholder="" required step="60">
        </div>


        <div class="col-2 d-grid gap-2">
            <button type="reset" class="btn btn-danger btn-block">取消重填</button>
        </div>
    </div>-->
</form>
<hr>
<form>
    <h6><strong>查詢列表 (留空表示不查詢)</strong></h6>
    <div class="row g-3 align-items-center">

        <!--<div class="col-1">
            <label for="search_name" class="col-form-label">人名</label>
        </div>
        <div class="col-2">
            <input type="input" id="search_name" class="form-control" placeholder="">
        </div>-->

        <div class="col-1">
            <label for="search_stuid" class="col-form-label">學號</label>
        </div>
        <div class="col-2">
            <input type="input" id="search_stuid" class="form-control" placeholder="">
        </div>
        <!--
        <div class="col-1">
            <label for="search_year" class="col-form-label">設定年分</label>
        </div>
        <div class="col-2">
            <select class="form-select" id="search_year">
                <option selected value="">請選擇...</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
            </select>
        </div>
        <div class="col-1">
            <label for="search_month" class="col-form-label">查詢整月</label>
        </div>
        <div class="col-2">
            <select class="form-select" id="search_month">
                <option selected value="">請選擇...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>



        <div class="col-1">
            <label for="search_in_place" class="col-form-label">簽到地點</label>
        </div>
        <div class="col-2">
            <select class="form-select" id="search_in_place">
                <option selected value="">請選擇...</option>
                <option value="jinde">進德</option>
                <option value="baosan">寶山</option>
                <option value="other">其他</option>
            </select>
        </div>

        <div class="col-1">
            <label for="search_out_place" class="col-form-label">簽退地點</label>
        </div>
        <div class="col-2">
            <select class="form-select" id="search_out_place">
                <option selected value="">請選擇...</option>
                <option value="jinde">進德</option>
                <option value="baosan">寶山</option>
                <option value="other">其他</option>
            </select>
        </div>

        <div class="col-3 d-grid gap-2">
            <button type="button" id="gen_month_paper" class="btn btn-warning btn-block">產生月報表</button>
        </div>-->
        <div class="col-3 d-grid gap-2">
            <button type="button" id="search" class="btn btn-primary btn-block">查詢</button>
        </div>

    </div>
</form>

<hr>
<table class="table">
    <thead>
        <tr>
            <th scope="col">學號</th>
            
            <th scope="col">逼卡時間</th>
            <!--<th scope="col">簽到地點</th>
            <th scope="col">簽退時間</th>
            <th scope="col">簽退地點</th>-->
        </tr>
    </thead>
    <tbody id="all_list">

    </tbody>
</table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

@endsection