$(document).ready(function () {
    var baseUrl = window.location.origin;

    $('#inputProject').on('change', function () {
        var projectId = $('#inputProject').val();
        renderTable(projectId);

    });

    $('#createTask').on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('form#formCreateTask')[0]);
        var url = $('#formCreateTask').attr('action');
        var projectId = formData.get('project_id');

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
        renderTable(projectId);

    });


    $('#tableTaskAssign tbody').on('click', '.deleteTask', function () {

        // if (confirm("Delete this task?")) {
        //     var taskId = $(this).attr('value');
        //     var node = this;
        //     $.ajax({
        //         type: 'DELETE',
        //         url: baseUrl + '/hapo-intern/admin/tasks/' + taskId,
        //         success: function (data) {
        //             $(node).closest("tr").remove();
        //         },
        //         error: function (e) {
        //             console.log(e);
        //         }
        //     });
        // }
        alert(this.parentNode.parentNode.cells[0].textContent);
    });

    function renderTable(projectId) {
        $('#tableTaskAssign tbody').empty();
        $('#inputSelectUser').empty();
        $.ajax({
            type: "GET",
            url: baseUrl + '/hapo-intern/admin/ajax/get-task-by-project-id/' + projectId,
            success: function (data) {
                console.log(data);
                var htmlTable = '';
                var htmlSelect = '';

                $.each(data.tasks, function (i, task) {
                    htmlTable +=
                        `<tr>
                             <td id="taskName">${task.name}</td>
                             <td>${task.user_id}</td>
                             <td>${task.hour}</td>
                             <td>${task.created_at}</td>
                             <td><button class="btn btn-outline-danger deleteTask" value="${task.id}" id="task${task.id}"><i class="fa fa-fw fa-trash"></i></button></td>
                         </tr>`;
                });
                $.each(data.users, function (i, user) {
                    htmlSelect += `<option value="${user.id}">${user.name}</option>`;
                });

                $('#tableTaskAssign').append(htmlTable);
                $('#inputSelectUser').append(htmlSelect);
            },
            error: function (e) {
            }
        });
    }
});
