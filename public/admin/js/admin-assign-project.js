$(document).ready(function () {
    $('#inputProjectAssign').on('change', function () {
        $('#inputSelectUser').empty();
        let projectId = $('#inputProjectAssign').val();
        let url = $('#urlGetUserByProject').val().replace('projectId', projectId);
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                let htmlSelect = `<option>---Choose user---</option>`;
                if (data.success === true) {
                    let arrUsers = data.data.project_users.users;
                    $.each(arrUsers, function (i, user) {
                        htmlSelect += `<option value="${user.id}" class="selectUser">${user.name}</option>`;
                    });
                }
                $('#inputSelectUser').append(htmlSelect);
            },
            error: function (e) {
            }
        });
    });

    $('#inputSelectUser').on('change', function () {
        $('#tableAssign tbody').empty();
        let projectId = $('#inputProjectAssign').val();
        let userId = $("#inputSelectUser :selected").val();
        let url = $('#urlGetProjectAssignByUser').val().replace('projectId', projectId).replace('userId', userId);
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                let htmlTable = '';
                let arrUsers = data.data.user_assigned.users;
                $.each(arrUsers, function (i, user) {
                    htmlTable +=
                        `<tr>
                            <td>${data.data.user_assigned.date_start}</td>
                            <td>${data.data.user_assigned.date_finish}</td>
                            <td>${user.name}</td>
                            <td class="date-join">${user.pivot.date_start}</td>
                            <td class="date-leave">${user.pivot.date_finish}</td>
                            <td>
                                <button class="btn btn-outline-danger delete-assign"> <i class="fa fa-fw fa-trash"></i> </button></td>
                         </tr>`;
                });
                $('#tableAssign').append(htmlTable);
            },
            error: function (e) {
            }
        });
    });

    $('#btnAssign').on('click', function (e) {
        e.preventDefault();
        let formData = new FormData($('form#formAssign')[0]);
        let url = $('#formAssign').attr('action');
        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                if (data.success === true) {
                    console.log(data);
                    alert('done!');
                    $('#errorAssign').text('');
                    $('#tableAssign').append(
                        `<tr>
                         <td>${data.data.project_start}</td>
                         <td>${data.data.project_finish}</td>
                         <td>${$('#inputSelectUser :selected').text()}</td>
                         <td class="date-join">${$('#inputDateJoin').val()}</td>
                         <td class="date-leave">${$('#inputDateLeave').val()}</td>
                         <td>
                             <button class="btn btn-outline-danger delete-assign"  title="Delete"> <i class="fa fa-fw fa-trash"></i></button>
                         </td>
                      </tr>`);
                } else {
                    alert('error');
                    $('#errorAssign').addClass('text-danger').html(`<strong>Invalid date: ${data.data.error} --- assigned before</strong>`);
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    let errors = data.responseJSON.errors;
                    let keys_errors = Object.keys(errors);
                    for (let i = 0; i < keys_errors.length; i++) {
                        let element = $('[name="' + keys_errors[i] + '"]');
                        element.addClass('is-invalid');
                        element.after(`<span class="invalid-feedback"><strong>${errors[keys_errors[i]][0]}</strong></span>`);
                    }
                }
            }
        });
    });

    $('#tableAssign tbody').on('click', '.delete-assign', function () {
        let projectId = $('#inputProjectAssign').val();
        let userId = $("#inputSelectUser :selected").val();
        let dateJoin = $(this).closest('tr').find('.date-join').text();
        let dateLeave = $(this).closest('tr').find('.date-leave').text();
        let url = $('#urlDeleteAssignment').val().replace('projectId', projectId).replace('userId', userId).replace('dateJoin', dateJoin).replace('dateLeave', dateLeave);
        let node = this;
        if(confirm(`Delete this assign ???`)){
            $.ajax({
                type: "DELETE",
                url: url,
                success: function (data) {
                    console.log(data);
                    node.closest('tr').remove();
                },
                error: function (data) {
                }
            });

        }
    });
});
