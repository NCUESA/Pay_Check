@extends('layouts.template')

@section('content')
    <form id='edit_list'>
        <h6><strong>請注意，此輸入並不防呆，送出前請先再三確認!!!</strong></h6>
        <div class="row g-3 align-items-center">
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
                <input type="input" id="add_person" class="form-control" placeholder="" required disabled>
            </div>
            <div class="col-1">
                <label for="inner_code" class="col-form-label">學號(系統自帶)</label>
            </div>
            <div class="col-3">
                <input type="input" id="stu_id" class="form-control" placeholder="" required disabled>
            </div>
            <div class="col-2 d-grid gap-2">
                <button type="submit" class="btn btn-success btn-block">手動簽到退</button>
            </div>

            <div class="col-1">
                <label for="checkin_time" class="col-form-label">簽到時間</label>
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
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">學號</th>
                <th scope="col">姓名</th>
                <th scope="col">簽到時間</th>
                <th scope="col">簽退時間</th>
            </tr>
        </thead>
        <tbody id="all_list">

        </tbody>
    </table>
@endsection
