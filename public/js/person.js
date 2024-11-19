$(document).ready(function () {
    $('#add-person').on("submit", function (e) {
        e.preventDefault();
        if ($('#inner_code').val() == '') {
            return;
        }
        if (!$('input[name="status"]:checked').val()) {
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/user/add',
            data: {
                //name: $('#add_person').val(),
                inner_code: $('#inner_code').val(),
                stu_id: $('#stu_id').val(),
                status: $('input[name="status"]:checked').val(),
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF Token
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    alert('新增成功!');
                    location.reload();
                }

            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $.ajax({
        type: 'POST',
        url: '/user/show',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')  // CSRF Token
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                genTable(response.data);
            }

        },
        error: function (error) {
            console.log(error);
        }
    });

    $(document).on('click', '.data-move', function () {
        // 取得當前按鈕所在的資料列
        const currentRow = $(this).closest('tr');

        // 提取每個 td 的內容
        //const name = currentRow.find('td').eq(1).text();  // 第一個 <td> 的內容
        const stu_id = currentRow.find('td').eq(0).text();  // 第一個 <td> 的內容
        const inner_code = currentRow.find('td').eq(1).text();  // 第一個 <td> 的內容
        const status = currentRow.find('td').eq(3).text(); // 第二個 <td> 的內容
        const radio_val = status == 'DOWN' ? 'd' : status == 'UP' ? 'u' : 'N/A';
        // 將第一個 <td> 的內容填入 input #inputA
        //$('#add_person').val(name);
        $('#stu_id').val(stu_id);
        $('#inner_code').val(inner_code);
        console.log(status);
        // 根據第二個 <td> 的內容選擇對應的 radio 按鈕
        $(`input[name="status"][value="${radio_val}"]`).prop('checked', true);
    });
});



function genTable(data) {
    $('#people_status').empty();
    $.each(data, function (index, item) {
        console.log(item);
        const radio_val = item.status == '0' ? 'DOWN' : item.status == '1' ? 'UP' : 'N/A';
        const check = item.checked == '0' ? '未領過' : item.checked == '1' ? '已領過' : 'N/A';
        const check_time = item.check_time == null ? '' : item.check_time;
        var row = '<tr>' +
            '<td>' + item.stu_id + '</td>' +
            //'<td>' + item.name + '</td>' +
            '<td>' + item.inner_code + '</td>' +
            '<td>' + check + '</td>' +
            '<td>' + check_time + '</td>' +
            '<td>' + radio_val + '</td>' +

            '<td>' + '<button type="button" class="data-move btn btn-outline-info">異動</button>' + '</td>' +  // Img Column
            '</tr>';
        // 將生成的行添加到表格的 tbody 中
        $('#people_status').append(row);
    });
}
