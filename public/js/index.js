$(document).ready(function () {
    setInterval(function () {
        let getTimeArr = getCurrentTime();
        $('#now_time').text(getTimeArr[0]);
    }, 1000);

    $('#check_input').on('change', function (e) {
        e.preventDefault();
        let now_time = getCurrentTime();
        $.ajax({
            type: 'POST',
            url: '/check',
            data: {
                inner_code: $('#check_input').val(),
                check_time: now_time[1],
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF Token
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    if (response.name == '查無此人') {
                        $('#person').val(response.name);
                        $('#check_time').val('錯誤');
                        $('#check_status').val(response.message);
                    }
                    else {
                        $('#person').val(response.name);
                        $('#check_time').val(now_time[0]);
                        $('#check_status').val(response.message);
                    }
                    $('#check_input').val('');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

});

function getCurrentTime() {
    const now = new Date();

    // 格式化時間為 YYYY-MM-DD HH:MM:SS
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    return [`${year}-${month}-${day} ${hours}:${minutes}:${seconds}`,
        `${year}-${month}-${day}T${hours}:${minutes}`];
}
