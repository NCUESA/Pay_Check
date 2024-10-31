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

    $('#search').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/show-list-condition',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF Token
                name: $('#search_name').val(),
                stuid: $('#search_stuid').val(),
                year: $('#search_year').val(),
                month: $('#search_month').val(),
                in_place: $('#search_in_place').val(),
                out_place: $('#search_out_place').val()
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

    $('#gen_month_paper').on('click', function (e) {
        e.preventDefault();
        if ($('#search_year').val() == "") {
            alert('請選擇年分');
            return;
        }
        if ($('#search_month').val() == "") {
            alert('請選擇月分');
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/gen-month-table',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF Token
                year: $('#search_year').val(),
                month: $('#search_month').val()
            },
            success: function (response) {
                console.log(response);
                generateReport(response.data);

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
        //item.checkin_ip = item.checkin_ip == '10.21.44.35' ? '進德' : item.checkin_ip == '10.21.44.148' ? '寶山' : '來源不明';

        item.checkin_ip = getIPSource(item.checkin_ip);
        item.checkout_ip = getIPSource(item.checkout_ip);
        var row = '<tr>' +
            '<td style="display:none;">' + item.id + '</td>' +
            '<td>' + item.stu_id + '</td>' +
            '<td>' + item.name + '</td>' +
            '<td>' + item.checkin_time + '</td>' +
            '<td>' + item.checkin_ip + '</td>' +
            '<td>' + item.checkout_time + '</td>' +
            '<td>' + item.checkout_ip + '</td>' +
            '<td>' + '<button type="button" class="data-move btn btn-outline-info">異動</button>' + '</td>' +  // Img Column
            '</tr>';
        // 將生成的行添加到表格的 tbody 中
        $('#all_list').append(row);
    });
}

function getIPSource(ip_string) {
    let ip_table = {
        '10.21.44.35': '寶山',
        '10.21.44.148': '進德',
        '120.107.148.249': '進德Server',
        '120.107.148.253': 'NAS_IP'
    };
    if (ip_table[ip_string]) {
        return ip_table[ip_string]; // 返回對應的 PC 名稱
    } else {
        return '來源不明(' + ip_string + ')'; // 返回找不到的提示
    }
}

function generateReport(data) {
    const rows = [];

    // 標題行
    rows.push(['姓名', '學號', '總津貼', '出勤次數', '簽到時間', '地點', '津貼']);

    // 遍歷每個員工的資料
    //$.each()
    data.forEach(employee => {
        const totalAllowance = employee.totalAllowance;
        const totalWorkCnt = employee.totalWorkCnt;
        const name = employee.name;
        const id = employee.stu_id;

        let firstRow = true;

        // 遍歷每條出勤記錄
        Object.keys(employee).forEach(key => {
            // 只處理數字鍵的記錄
            if (!isNaN(key)) {
                const [checkinTime, location, allowance] = employee[key].split("; ");

                // 加入報表行
                const row = [
                    firstRow ? name : '',  // 只在第一行顯示姓名
                    firstRow ? id : '',    // 只在第一行顯示學號
                    firstRow ? totalAllowance : '',  // 只在第一行顯示總津貼
                    firstRow ? totalWorkCnt : '',    // 只在第一行顯示出勤次數
                    checkinTime,
                    location,
                    allowance
                ];

                rows.push(row);
                firstRow = false;  // 後續行不重複顯示姓名和學號等資訊
            }
        });
    });

    // 生成 Excel 工作表和工作簿
    const worksheet = XLSX.utils.aoa_to_sheet(rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "月報表");

    // 下載 Excel 文件
    XLSX.writeFile(workbook, $("#search_year").val() + "_" + $("#search_month").val() + "_月報表.xlsx");
}
