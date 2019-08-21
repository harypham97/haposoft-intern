$(document).ready(function () {
    var baseUrl = window.location.origin;
    $.ajaxSetup({
        headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    });

    $('#inputProjectReport').on('change', function () {
        var projectId = $('#inputProjectReport').val();
        $.ajax({
            type: "GET",
            url: baseUrl + '/hapo-intern/client/ajax/get-tasks-by-project/' + projectId,
            success: function (data) {
                var htmlCheckBox = '';
                if (data.success === true) {
                    $.each(data.tasks, function (i, task) {
                        htmlCheckBox += `<div class="col-3"> <input type="checkbox" value="${task.id}"  name="checkBoxTaskId[]">${task.name}</div>`;
                    });
                } else {
                    htmlCheckBox += `<div class="col-12"> <span>---No data to display---</span></div>`;
                }
                $('#loopCheckBoxTask').html(htmlCheckBox);
            },
            error: function (e) {
            }
        });
    });

    $('#btnCreateReport').on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('form#formCreateReport')[0]);
        var url = $('#formCreateReport').attr('action');
        var project_name = $('#inputProjectReport :selected').text();
        var report_name = formData.get('name');
        var date = formData.get('date');
        var time = `${formData.get('time_start')} ~ ${formData.get('time_end')}`;
        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                alert('report saved!!!');
                $('#tableCreateReport').append(
                    `<tr>
                         <td>${report_name}</td>
                         <td>${project_name}</td>
                         <td>${date}</td>
                         <td>${time}</td>
                         <td>${getCurrentTime()}</td>
                         <td>
                             <button class="btn btn-outline-danger deleteReport" value="${data.report_id}" title="Delete"> <i class="fa fa-fw fa-trash"></i></button>
                         </td>
                      </tr>`);
            },
            error: function (e) {
            }
        });
    });

    function getCurrentTime() {
        var date = new Date();
        var curr_date = (date.getDate() < 10 ? '0' : '') + date.getDate();
        var curr_month = ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1);
        return `${date.getFullYear()}-${curr_month}-${curr_date} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
    }

    $('#tableCreateReport tbody').on('click', '.deleteReport', function () {
        if (confirm("Delete this report?")) {
            var reportId = $(this).attr('value');
            var node = this;
            $.ajax({
                type: 'DELETE',
                url: baseUrl + '/hapo-intern/client/ajax/delete-staff-report/' + reportId,
                success: function (data) {
                    if (data.success === true) {
                        $(node).closest("tr").remove();
                        $('#formCreateReport').trigger("reset");
                    }
                    else {
                        alert('something wrong, try again later!')
                    }
                },
                error: function (e) {
                }
            });
        }
    });

    $('#btnSearchReport').on('click', function (e) {
        e.preventDefault();
        $('#tableReportSearch tbody').empty();
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        $.ajax({
            type: "GET",
            url: `${baseUrl}/hapo-intern/client/ajax/search-report-by-date/${fromDate}/${toDate}`,
            success: function (data) {
                var html = '';
                if (data.reports.length > 0) {
                    $.each(data.reports, function (i, report) {
                        var href = `${baseUrl}/hapo-intern/staffs/reports/${report.id}/edit`;
                        html += `<tr>
                                <td>${i + 1}</td>
                                <td>${report.name}</td>
                                <td>${report.created_at}</td>
                                <td>
                                    <a class="btn btn-outline-info" href="${href}" title="Info">
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
            error: function (e) {
            }
        });
    });
});
