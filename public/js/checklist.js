$(document).ready(function () {
    $('#edit_list').on("submit", function (e) {
        e.preventDefault();
        if ($('#add_person').val() == '') {
            alert('Name Column Can\'t be empty');
            return;
        }
        if ($('#inner_code').val() == '') {
            alert('Code Column Can\'t be empty');
            return;
        }
        console.log($('#checkin_time').val());
        console.log($('#checkout_time').val());
        $.ajax({
            type: 'POST',
            url: '/update-list',
            data: {
                id: $('#id').val(),
                //name: $('#add_person').val(),
                //inner_code: $('#inner_code').val(),
                checkin_time: $('#checkin_time').val(),
                checkout_time: $('#checkout_time').val(),
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF Token
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    alert('手動更新成功!');
                    location.reload();
                }

            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    $(document).on('click', '.data-move', function () {
        // 取得當前按鈕所在的資料列
        const currentRow = $(this).closest('tr');

        // 提取每個 td 的內容
        const id = currentRow.find('td').eq(0).text();
        const stu_id = currentRow.find('td').eq(1).text(); 
        const name = currentRow.find('td').eq(2).text();  
        const checkin_time = currentRow.find('td').eq(3).text(); // 第二個 <td> 的內容
        const checkout_time = currentRow.find('td').eq(4).text(); // 第二個 <td> 的內容
        //const radio_val = status == 'DOWN' ? 'd' : status == 'UP' ? 'u' : 'N/A';
        // 將第一個 <td> 的內容填入 input #inputA
        $('#id').val(id);
        $('#add_person').val(name);
        $('#stu_id').val(stu_id);
        $('#checkin_time').val(checkin_time);
        $('#checkout_time').val(checkout_time);

        // 根據第二個 <td> 的內容選擇對應的 radio 按鈕
        //$(`input[name="status"][value="${radio_val}"]`).prop('checked', true);
    });
    $.ajax({
        type: 'POST',
        url: '/show-list',
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
});

function genTable(data) {
    $('#all_list').empty();
    $.each(data, function (index, item) {
        console.log(item);
        //const radio_val = item.status == '0'? 'DOWN': item.status == '1'? 'UP': 'N/A';
        var row = '<tr>' +
            '<td style="display:none;">' + item.id + '</td>' +
            '<td>' + item.stu_id + '</td>' +
            '<td>' + item.name + '</td>' +
            '<td>' + item.checkin_time + '</td>' +
            '<td>' + item.checkout_time + '</td>' +

            '<td>' + '<button type="button" class="data-move btn btn-outline-info">異動</button>' + '</td>' +  // Img Column
            '</tr>';
        // 將生成的行添加到表格的 tbody 中
        $('#all_list').append(row);
    });
}