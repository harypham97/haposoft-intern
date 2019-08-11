$(document).ready(function () {

    $(".modal").on("hidden.bs.modal", function(){
        $("#tableEdit tbody").empty();
    });

    $("a#showListCheckBox").click(function (e) {
        e.preventDefault();
        var flag = $('input#flag').val();
        if (flag === 'true') {
            $("#loopCheckBox").removeClass("d-none").addClass("d-flex");
            $('input#flag').val('false');
        }
        else {
            $("#loopCheckBox").removeClass("d-flex").addClass("d-none");
            $('input#flag').val('true');
        }
    });

//     $.ajax({
//         headers:
//             {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//         type: "GET",
//         url: "/hapo-intern/ajax/getAllProjectUser/",
//         success: function (data) {
//             console.log(data);
//             //function(key,value)
//             var trHTML = '';
//             $.each(data, function (i, project) {
//                 if (project.users.length > 0) {
//
//                     $.each(project.users, function (i, user) {
//                         trHTML += '<tr>' +
//                             '<td>' + project.name + '</td>' +
//                             '<td>' + project.date_start + '</td>' +
//                             '<td>' + project.date_finish + '</td>' +
//                             '<td>' + user.name + '</td>' +
//                             '<td>' + user.pivot.date_start + '</td>' +
//                             '<td>' + user.pivot.date_finish + '</td>' +
//                             '</tr>';
//                     });
//                 } else {
//                     trHTML += '<tr>' +
//                         '<td>' + project.name + '</td>' +
//                         '<td>' + project.date_start + '</td>' +
//                         '<td>' + project.date_finish + '</td>' +
//                         '<td></td>' +
//                         '<td></td>' +
//                         '<td></td>' +
//                         '</tr>';
//
//
//                 }
//
//
//             });
//
//             $('#tableProjectUser').append(trHTML);
//         }
//     });
//
//
    $('#btnAddNew').on('click', function (e) {
        e.preventDefault(); // this prevents the form from submitting
        var formData = new FormData($('form#formAddUserProject')[0]);
        var listIdUser = [];
        var url = $('#formAddUserProject').attr('action')

        $.each($("input[name='checkBoxUserID']:checked"), function () {
            listIdUser.push($(this).val());
        });

        formData.append('listIdUser', JSON.stringify(listIdUser));

        $.ajax({
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            processData: false,
            contentType: false,
            type: 'POST',
            url: url,
            data: formData,
            success: function (data) {
                alert('Done!!!');
                window.location.reload();
                console.log(data);
            },
            error: function (e) {
                console.log(e);
            }
        });

    });

    $('.btnEdit').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr("value");
        $.ajax({
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "GET",
            url: 'http://localhost:8080/hapo-intern/admin/project-user/'+id+'/edit',
            success: function (data) {
                $('#editModalTitle').text(data.project.name);

                var trHTML = '';


                    $.each(data.project.users, function (i, user) {
                        trHTML += '<tr>' +
                            '<td>' + data.project.name + '</td>' +
                            '<td>' + user.name + '</td>' +
                            '<td> <button class="btn btn-danger ml-2 deleteUser" value=""> Delete</button></td>' +

                            '</tr>';
                                                  });

            $('#tableEdit').append(trHTML);

            }
        });

        $('#editProjectModal').modal('show');


    });
});
