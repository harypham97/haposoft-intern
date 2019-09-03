$(document).ready(function () {
    $('#inputDepartment').on('change', function () {
        let departmentId = $('#inputDepartment').val();
        let url = $('#urlGetUserByDepartment').val().replace('departmentId', departmentId);
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                let arrUser;
                let listUser = document.getElementById('loopCheckBox');
                let html = '';

                if (departmentId === '-1') {
                    arrUser = Object.values(data.data.users);
                }
                else {
                    arrUser = data.data.department.users;
                }

                $('#loopCheckBox').addClass('form-control col-12 d-flex flex-wrap h-auto mb-3');
                if (arrUser.length === 0) {
                    html += `<div class="col-12"> <span>---No data to display---</span></div> `;
                }

                for (let i = 0; i < arrUser.length; i++) {
                    html += `<div class="col-3"> <input type="checkbox" value="${arrUser[i].id}" id="checkBoxUserId" name="checkBoxUserId[]">${arrUser[i].name}</div>`;
                }

                listUser.innerHTML = html;
            },
            error: function (e) {
            }
        });
    });

    $('#tableProjectUser tbody').on('click', '.delete-user-in-project', function () {
        let userId = $(this).attr('value');
        let url = $(this).closest('td').find("input").val().replace('userId', userId);
        let textBtn = $(this).text().trim();
        let node = this;
        if(confirm(`Delete ${textBtn} ???`)){
            $.ajax({
                type: "DELETE",
                url: url,
                success: function (data) {
                    node.remove();
                },
                error: function (data) {
                }
            });
        }
    });
});
