$(document).ready(function () {
    $.ajaxSetup({
        headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    });

    $('#inputProjectReport').on('change', function () {
        let projectId = $('#inputProjectReport').val();
        let url = $('#getTasksByProject').val().replace('projectId', projectId);
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                let htmlCheckBox = '';
                if (data.success === true) {
                    $.each(data.data.tasks, function (i, task) {
                        htmlCheckBox += `<div class="col-3"> <input type="checkbox" value="${task.id}"  name="check_box_task_id[]">${task.name}</div>`;
                    });
                } else {
                    htmlCheckBox += `<div class="col-12"> <span>---No data to display---</span></div>`;
                }
                $('#loopCheckBoxTask').html(htmlCheckBox);
            },
            error: function (data) {
            }
        });
    });

    $('#btnCreateReport').on('click', function (e) {
        e.preventDefault();
        let formData = new FormData($('form#formCreateReport')[0]);
        let url = $('#formCreateReport').attr('action');
        let project_name = $('#inputProjectReport :selected').text();
        let report_name = formData.get('name');
        let date = formData.get('date');
        let time = `${formData.get('time_start')} ~ ${formData.get('time_end')}`;
        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                let urlEdit = $('#urlTableEditReport').val();
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                alert('report saved!!!');
                $('#tableCreateReport').append(
                    `<tr>
                         <td>${report_name}</td>
                         <td>${project_name}</td>
                         <td>${date}</td>
                         <td>${time}</td>
                         <td>${getCurrentTime()}</td>
                         <td>
                             <button class="btn btn-outline-danger deleteReport" value="${data.data.report_id}" title="Delete"> <i class="fa fa-fw fa-trash"></i></button>
                            <a class="btn btn-outline-warning ml-3 mr-3" title="Edit"
                               href="${urlEdit.replace('id', data.data.report_id)}">
                            <i class="fa fa-fw fa-edit"></i>
                            </a>
                         </td>
                      </tr>`);
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

    function getCurrentTime() {
        let date = new Date();
        let curr_date = (date.getDate() < 10 ? '0' : '') + date.getDate();
        let curr_month = ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1);
        return `${date.getFullYear()}-${curr_month}-${curr_date} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
    }

    $('#tableCreateReport tbody').on('click', '.deleteReport', function () {
        if (confirm("Delete this report?")) {
            let reportId = $(this).attr('value');
            let node = this;
            let url = $('#getUrlDelete').val().replace('id', reportId);
            $.ajax({
                type: 'DELETE',
                url: url,
                success: function (data) {
                    if (data.success === true) {
                        $(node).closest("tr").remove();
                        $('#formCreateReport').trigger("reset");
                    }
                    else {
                        alert('something wrong, try again later!')
                    }
                },
                error: function (data) {
                }
            });
        }
    });

    $('#btnSearchReport').on('click', function (e) {
        e.preventDefault();
        $('#tableReportSearch tbody').empty();
        let fromDate = $('#from_date').val();
        let toDate = $('#to_date').val();
        let actionForm = $('#formSearchReport').attr('action');
        let url = `${actionForm}/${fromDate}/${toDate}`;

        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                let html = '';
                let urlEdit = $('#getUrlEdit').val();
                if (data.data.reports.length > 0) {
                    $.each(data.data.reports, function (i, report) {
                        html += `<tr>
                                <td>${i + 1}</td>
                                <td>${report.name}</td>
                                <td>${report.created_at}</td>
                                <td>
                                    <a class="btn btn-outline-info" href="${urlEdit.replace('id', report.id)}" title="Info">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </td>
                              </tr>`;
                    });
                } else {
                    html += `<tr><td colspan="4" class="text-center">---No data to display---</td></tr>`;
                }
                $('#tableReportSearch').append(html);
            },
            error: function (data) {
            }
        });
    });

    // project-join's staff
    $('#projectJoined').on('click', function (e) {
        e.preventDefault();
        location.reload();
    });

    $('#taskAssigned').on('click', function (e) {
        e.preventDefault();
        $('#projectJoined').removeClass('active');
        $('#taskAssigned').addClass('active');
        $('#tableProjectJoin').remove();
        $('#tableTaskAssigned').removeClass('d-none');
        let url = $('#urlGetTasksAssignedByStaff').val();
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                if (data.success === true) {
                    let htmlTable = ``;
                    let tasks = data.data.tasks;
                    console.log(data);
                    $.each(tasks, function (i, task) {
                        htmlTable +=
                            `<tr>
                                <td>${i + 1 }</td>
                                <td>${task.project.name}</td>
                                <td>${task.name}</td>
                                <td class="date-join">${task.hour}</td>
                             </tr>`;
                    });
                    $('#tableTaskAssigned').append(htmlTable);
                }
                else {
                    alert('something wrong, try again later!')
                }
            },
            error: function (data) {
            }
        });
    });
});
