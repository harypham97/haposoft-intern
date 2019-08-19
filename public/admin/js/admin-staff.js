$(document).ready(function () {
    $.ajaxSetup({
        headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    });

    $('.btnInfoModal').on('click', function () {
        var id = $(this).attr('id');

        $.ajax({
            type: "GET",
            url: "/hapo-intern/admin/staffs/" + id,
            success: function (data) {
                $('#nameStaff').val(data['name']);
                $('#deptStaff').val(data['dept_name']);
                $('#emailStaff').val(data['email']);
                $('#dobStaff').val(data['dob']);
                $('#phoneStaff').val(data['phone']);
                $('#cityStaff').val(data['city']);
                $('#idStaff').val(data['id']);

                var base_url = window.location.origin + '/hapo-intern/public/storage/' + data['avatar'];

                $('#avatarStaff').attr('width', 150);
                $('#avatarStaff').attr('height', 150);
                $('#avatarStaff').attr('src', base_url);

                console.log(data);
            }
        });
        $('#infoStaffModal').modal('show');
    });
});
