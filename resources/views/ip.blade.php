@extends('layouts.template')

@section('content')
    <h2>IP通過清單管理</h2>

    <hr>
    <form id='add-ip'>
        <h6><strong>請注意，此輸入並不防呆，送出前請先再三確認!!!</strong></h6>
        <div class="row g-3 align-items-center">
            <div class="col-2" hidden>
                <input type="input" id="add_id" class="form-control" placeholder="id">
            </div>
            <div class="col-1">
                <label for="add_ip" class="col-form-label">IP新增(變更)</label>
            </div>
            <div class="col-2">
                <input type="input" id="add_ip" class="form-control" placeholder="輸入IP" required>
            </div>
            <div class="col-1">
                <label for="description" class="col-form-label">IP描述(50字上限)</label>
            </div>
            <div class="col-2">
                <input type="input" id="description" class="form-control" placeholder="做一點描述" required>
            </div>
            <div class="col-1">
                <label for="status" class="col-form-label">狀態</label>
            </div>
            <div class="col-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="u" id="up" required>
                    <label class="form-check-label" for="up">
                        UP
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="d" id="down" required>
                    <label class="form-check-label" for="down">
                        DOWN
                    </label>
                </div>
            </div>
            <div class="col-2 d-grid gap-2">
                <button type="submit" class="btn btn-success btn-block">送出新增(調整)</button>
            </div>
            <div class="col-1 d-grid gap-2">
                <button type="reset" class="btn btn-danger btn-block">取消重填</button>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th scope="col" hidden></th>
                <th scope="col">IP</th>
                <th scope="col">狀態</th>
                <th scope="col">描述</th>
                <th scope="col">異動</th>
            </tr>
        </thead>
        <tbody id='ip_table'>
            <tr>

            </tr>
        </tbody>
    </table>
@endsection
