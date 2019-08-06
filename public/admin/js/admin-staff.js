$(document).ready(function () {

    $('.btnInfoModal').on('click', function () {
        var id = $(this).attr('id');

        $.ajax({
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "GET",
            url: "/hapo-intern/admin/staffs/" + id,
            success: function (results) {
                $('#nameStaff').val(results['name']);
                $('#deptStaff').val(results['dept_name']);
                $('#emailStaff').val(results['email']);
                $('#dobStaff').val(results['dob']);
                $('#phoneStaff').val(results['phone']);
                $('#cityStaff').val(results['city']);
                $('#idStaff').val(results['id']);
                console.log(results);
            }
        });

        $('#infoStaffModal').modal('show');

    });

    $('#editInfoStaff').on('click', function () {

        $('.inputInfoModal').attr("readonly", false);
        $('.inputInfoModal').removeClass('form-control-plaintext').addClass('form-control');
        $('#editInfoStaff').hide();
        $('#saveInfoStaff').removeClass('d-none');

        var id = $('#idStaff').val();

    });

    $('#infoStaffModal').on('hidden.bs.modal', function () {
        $('.inputInfoModal').attr("readonly", true);
        $('.inputInfoModal').removeClass('form-control').addClass('form-control-plaintext');
        $('#editInfoStaff').show();
        $('#saveInfoStaff').addClass('d-none');
    })
});