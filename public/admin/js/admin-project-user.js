$(document).ready(function () {

    var baseUrl = window.location.origin;

    $('#inputDepartment').on('change', function () {
        var departmentId = $('#inputDepartment').val();
        $.ajax({
            type: "GET",
            url: baseUrl + '/hapo-intern/admin/ajax/get-user-by-department/' + departmentId,
            success: function (data) {
                console.log(data);
                var arrUser;
                var listUser = document.getElementById('loopCheckBox');
                var html = '';

                if (departmentId === 'all') {
                    arrUser = Object.values(data.users);
                }
                else {
                    arrUser = data.department.users;
                }

                $('#loopCheckBox').addClass('form-control col-12 d-flex flex-wrap h-auto mb-3');
                if (arrUser.length === 0) {
                    html += `<div class="col-12"> <span>---No data to display---</span></div> `;
                }

                for (var i = 0; i < arrUser.length; i++) {
                    html += `<div class="col-3"> <input type="checkbox" value="${arrUser[i].id}" id="checkBoxUserId" name="checkBoxUserId[]">${arrUser[i].name}</div>`;
                }

                listUser.innerHTML = html;
            },
            error: function (e) {
                console.log('error:' + e);
            }
        });
    });

    $('#inputProjectAssign').on('change', function () {
        $('#tableAssign tbody').empty();
        $('#inputSelectUser').empty();
        var projectId = $('#inputProjectAssign').val();
        $.ajax({
            type: "GET",
            url: baseUrl + '/hapo-intern/admin/ajax/get-project-by-id/' + projectId,
            success: function (data) {
                console.log(data);
                var htmlTable = '';
                var htmlSelect = '';
                var arrUsers = data.project.users;

                $.each(arrUsers, function (i, user) {
                    htmlTable +=
                        `<tr>
                            <td>${data.project.date_start}</td>
                            <td>${data.project.date_finish}</td>
                            <td>${user.name}</td>
                            <td>${user.pivot.date_start}</td>
                            <td>${user.pivot.date_finish}</td>
                            <td><button class="btn btn-outline-danger" value="${user.id}"> <i class="fa fa-fw fa-trash"></i></button></td>
                         </tr>`;
                    htmlSelect += `<option value="${user.id}">${user.name}</option>`;
                });

                $('#tableAssign').append(htmlTable);
                $('#inputSelectUser').append(htmlSelect);
            },
            error: function (e) {
                console.log('error:' + e);
            }
        });
    });

    $('#btnAssign').on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('form#formAssign')[0]);
        var url = $('#formAssign').attr('action');

        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                console.log(data);
            },
            error: function (e) {
                console.log('error:' + e);
            }
        });
    });
});
