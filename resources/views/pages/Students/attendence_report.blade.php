@extends('layouts.master')
@section('css')

@section('title')
    تقرير الحضور والغياب
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    تقارير الحضور والغياب
@stop
<!-- breadcrumb -->

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('search1') }}" autocomplete="off">
                        @csrf
                        <h6 style="font-family: 'Cairo', sans-serif;color: blue">معلومات البحث</h6><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Grade_id">{{ trans('Students_trans.Grade') }} : <span
                                            class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-2" name="Grade_id">
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                        @foreach ($my_classes as $c)
                                            <option value="{{ $c->id }}">{{ $c->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Classroom_id">{{ trans('Students_trans.classrooms') }} : <span
                                            class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-2" name="Classroom_id">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="section_id">{{ trans('Students_trans.section') }} : </label>
                                    <select class="custom-select mr-sm-2" name="section_id">
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="student">الطلاب</label>
                                    <select class="custom-select mr-sm-2" name="student_id">

                                    </select>
                                </div>
                            </div>

                            <div class="card-body datepicker-form">
                                <div class="input-group" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control range-from date-picker-default"
                                        placeholder="تاريخ البداية" required name="from">
                                    <span class="input-group-addon">الي تاريخ</span>
                                    <input class="form-control range-to date-picker-default" placeholder="تاريخ النهاية"
                                        type="text" required name="to">
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-success btn-sm nextBtn btn-lg pull-right"
                            type="submit">{{ trans('Students_trans.submit') }}</button>
                    </form>
                    @isset($Students)
                        <div class="table-responsive">
                            <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                                style="text-align: center">
                                <thead>
                                    <tr>
                                        <th class="alert-success">#</th>
                                        <th class="alert-success">{{ trans('Students_trans.name') }}</th>
                                        <th class="alert-success">{{ trans('Students_trans.Grade') }}</th>
                                        <th class="alert-success">{{ trans('Students_trans.section') }}</th>
                                        <th class="alert-success">التاريخ</th>
                                        <th class="alert-warning">الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Students as $student)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $student->students->name }}</td>
                                            <td>{{ $student->grade->Name }}</td>
                                            <td>{{ $student->section->Name_Section }}</td>
                                            <td>{{ $student->attendence_date }}</td>
                                            <td>

                                                @if ($student->attendence_status == 0)
                                                    <span class="btn-danger">غياب</span>
                                                @else
                                                    <span class="btn-success">حضور</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @include('pages.Students.Delete')
                                    @endforeach
                            </table>
                        </div>
                    @endisset

                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')

    <script>
        $(document).ready(function() {
            $('select[name="section_id"]').on('change', function() {
                var section_id = $(this).val();


                if (section_id) {
                    $.ajax({
                        url: "{{ URL::to('student_section_id') }}/" + section_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="student_id"]').empty();
                            $('select[name="student_id"]').append('<option selected  value="0" >الكل...</option>');
                            $.each(data, function(key, value) {
                                $('select[name="student_id"]').append(

                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });


                        },
                    });
                }
                /*else {
                                   console.log('AJAX load did not work');
                               }*/
            });
        });
    </script>

@endsection
