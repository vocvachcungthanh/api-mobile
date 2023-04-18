$(document).ready(function () {
    $('#change-password').on("change", function () {
        let status = !$(this).is(":checked");

        $('#password').attr('readonly', status);
        $('#password-confirm').attr('readonly', status);

        $('#password').val('')
        $('#password-confirm').val('')


    });

    $('#btn-reset-edit-user').on('click', function () {
        $('#password').attr('readonly', true);
        $('#password-confirm').attr('readonly', true);
        $('#change-password').attr('checked', false);
    })

    $('.btn-del-confirm').on('click', function () {
        let url = $(this).data('url');

        if (!confirm('Dữ liệu sẽ không được khôi phục bạn có muốn xóa không')) {
            return;
        }

        return window.location.href = url;
    });
});