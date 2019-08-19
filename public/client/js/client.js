$(document).ready(function () {
    var baseUrl = window.location.origin;
    $.ajaxSetup({
        headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    });

    $('#inputProjectReport').on('change', function () {
        $('#tableReport tbody').empty();
        $('#inputSelectTask').empty();
        var projectId = $('#inputProjectReport').val();
        $('#inputSelectTask').empty();
        $.ajax({
            type: "GET",
            url: baseUrl + '/hapo-intern/client/ajax/get-report-task-by-project/' + projectId,
            success: function (data) {
                var htmlSelect = '';
                var htmlTable = '';
                $.each(data.task_report, function (i, task) {
                    htmlSelect += `<option value="${task.id}">${task.name}</option>`;

                    $.each(task.reports, function (i, report) {
                        htmlTable +=
                            `<tr>
                                <td>${report.name}</td>
                                <td>${task.name}</td>
                                <td>${data.project.name}</td>    
                                <td>${report.created_at}</td>
                                <td>
                                    <button class="btn btn-outline-danger" value="${report.report_id}"> <i class="fa fa-fw fa-trash"></i></button>
                                </td>                       
                             </tr>`;
                    });

                });
                $('#inputSelectTask').append(htmlSelect);
                $('#tableReport').append(htmlTable);
            },
            error: function (e) {
            }
        });

    });

    $('#createReport').on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('form#formCreateReport')[0]);
        var url = $('#formCreateReport').attr('action');

        var project_name = $('#inputProjectReport :selected').text();
        var task_name = $('#inputSelectTask :selected').text();
        var report_name = formData.get('name');
        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                alert('report saved!!!')
                $('#tableReport').append(
                    `<tr>
                         <td>${report_name}</td>
                         <td>${task_name}</td>
                         <td>${project_name}</td>
                         <td></td>
                         <td>
                             <button class="btn btn-outline-danger" value=""> <i class="fa fa-fw fa-trash"></i></button>
                         </td>
                      </tr>`);
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
});