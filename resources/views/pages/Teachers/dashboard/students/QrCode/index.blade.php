@extends('layouts.master')

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
    integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
</script>
<script>
    var socket = io.connect('{{ env('SOCKET_URL') . ':' . env('SOCKET_PORT') }}');
</script>
@section('css')

@section('title')
    empty
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    empty
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="msg" id='msg'></div>
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                    style="text-align: center">
                    <thead>
                        <tr>
                            <th class="alert-success">#</th>
                            <th class="alert-success">{{ trans('Students_trans.name') }}</th>

                            <th class="alert-success">{{ trans('Students_trans.Grade') }}</th>
                            <th class="alert-success">{{ trans('Students_trans.classrooms') }}</th>
                            <th class="alert-success">{{ trans('Students_trans.section') }}</th>

                        </tr>
                    </thead>
                    <tbody id="student_data">




                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script>
    window.onload = function() {
        let QrValue = 0;
        socket.on('qr', (Qr) => {
            QrValue = Qr;


            ////////////////////start Ajax
            $(document).ready(function() {


                if (QrValue) {
                    $.ajax({
                        url: "{{ URL::to('studentDataParcode1') }}/" + QrValue,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {

                            if (data.students) {
                                $("#student_data").append(
                                    `<tr>
                                    <td>
                                        ` + data.students.id + `
                                    </td>
                                    <td>
                                        ` + data.students.name['ar'] + `
                                    </td>
                                    <td>
                                        ` + data.students.grade.Name['ar'] + `
                                    </td>
                                    <td>
                                        ` + data.students.classroom.Name_Class['ar'] + `
                                    </td>
                                    <td>
                                        ` + data.students.section.Name_Section['ar'] + `
                                    </td>

                                </tr>`
                                )
                                console.log(data.students)
                            } else {
                                $("#msg").html(
                                    // console.log(data.msg)
                                    `<div class="alert alert-danger" role="alert">
                                       ${data.msg}
                                        </div>`
                                )
                            }






                            /*     $.each(data, function(key, value) {
                                     $('select[name="section_id"]')
                                         .append('<option value="' +
                                             key + '">' + value +
                                             '</option>');
                                 });
                                 */

                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }

            });
            ////////////end Ajax

        });
    }
</script>
@endsection
