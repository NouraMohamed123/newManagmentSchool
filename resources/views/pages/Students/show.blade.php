@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ trans('Students_trans.Student_details') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Students_trans.Student_details') }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="card-body">
                    <div class="tab nav-border">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-02-tab" data-toggle="tab" href="#home-02"
                                    role="tab" aria-controls="home-02"
                                    aria-selected="true">{{ trans('Students_trans.Student_details') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-02-tab" data-toggle="tab" href="#profile-02"
                                    role="tab" aria-controls="profile-02"
                                    aria-selected="false">{{ trans('Students_trans.Attachments') }}</a>
                            </li>





                            <li class="nav-item">
                                <a class="nav-link" id="profile-03-tab" data-toggle="tab" href="#profile-03"
                                    role="tab" aria-controls="profile-03" aria-selected="false">مرفقات الباركود</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="profile-04-tab" data-toggle="tab" href="#profile-04"
                                    role="tab" aria-controls="profile-04" aria-selected="false"> تقرير الحضور و
                                    الغياب </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="profile-05-tab" data-toggle="tab" href="#profile-05"
                                    role="tab" aria-controls="profile-05" aria-selected="false"> تقارير الفواتير
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" id="profile-06-tab" data-toggle="tab" href="#profile-06"
                                    role="tab" aria-controls="profile-06" aria-selected="false"> تقارير الدرجات
                                </a>
                            </li>


                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                aria-labelledby="home-02-tab">
                                <table class="table table-striped table-hover" style="text-align:center">
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ trans('Students_trans.name') }}</th>


                                            <th scope="row">{{ trans('Students_trans.Grade') }}</th>

                                            <th scope="row">{{ trans('Students_trans.classrooms') }}</th>

                                            <th scope="row">{{ trans('Students_trans.section') }}</th>

                                            <th scope="row">{{ trans('Students_trans.Date_of_Birth') }}</th>


                                            <th scope="row">{{ trans('Students_trans.parent') }}</th>

                                            <th scope="row">{{ trans('Students_trans.academic_year') }}</th>


                                        </tr>
                                    <tbody>
                                        <tr>
                                            <td>{{ $Student->name }}</td>
                                            <td>{{ $Student->grade->Name }}</td>
                                            <td>{{ $Student->classroom->Name_Class }}</td>
                                            <td>{{ $Student->section->Name_Section }}</td>
                                            <td>{{ $Student->Date_Birth }}</td>
                                            <td>{{ $Student->myparent->Name_Father }}</td>
                                            <td>{{ $Student->academic_year }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="profile-02" role="tabpanel" aria-labelledby="profile-02-tab">
                                <div class="card card-statistics">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('Upload_attachment') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label
                                                        for="academic_year">{{ trans('Students_trans.Attachments') }}
                                                        : <span class="text-danger">*</span></label>
                                                    <input type="file" accept="image/*" name="photos[]" multiple
                                                        required>
                                                    <input type="hidden" name="student_name"
                                                        value="{{ $Student->name }}">
                                                    <input type="hidden" name="student_id"
                                                        value="{{ $Student->id }}">
                                                </div>
                                            </div>
                                            <br><br>
                                            <button type="submit" class="button button-border x-small">
                                                {{ trans('Students_trans.submit') }}
                                            </button>
                                        </form>
                                    </div>
                                    <br>
                                    <table class="table center-aligned-table mb-0 table table-hover"
                                        style="text-align:center">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th scope="col">#</th>
                                                <th scope="col">{{ trans('Students_trans.filename') }}</th>
                                                <th scope="col">{{ trans('Students_trans.created_at') }}</th>
                                                <th scope="col">{{ trans('Students_trans.Processes') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Student->images as $attachment)
                                                <tr style='text-align:center;vertical-align:middle'>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $attachment->filename }}</td>
                                                    <td>{{ $attachment->created_at->diffForHumans() }}</td>
                                                    <td colspan="2">
                                                        <a class="btn btn-outline-info btn-sm"
                                                            href="{{ url('Download_attachment') }}/{{ $attachment->imageable->name }}/{{ $attachment->filename }}"
                                                            role="button"><i class="fas fa-download"></i>&nbsp;
                                                            {{ trans('Students_trans.Download') }}</a>

                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#Delete_img{{ $attachment->id }}"
                                                            title="{{ trans('Grades_trans.Delete') }}">{{ trans('Students_trans.delete') }}
                                                        </button>

                                                    </td>
                                                </tr>
                                                @include('pages.Students.Delete_img')
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-03" role="tabpanel"
                                aria-labelledby="profile-02-tab">
                                <div class="card card-statistics">

                                    <table class="table center-aligned-table mb-0 table table-hover"
                                        style="text-align:center">
                                        <thead>
                                            <tr class="table-secondary">

                                                <th scope="col">اسم الطالب</th>
                                                <th scope="col">{{ trans('Students_trans.filename') }}</th>
                                                <th scope="col">{{ trans('Students_trans.Processes') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr style='text-align:center;vertical-align:middle'>
                                                <td>{{ $Student->name }}</td>
                                                <td><img src="{{ asset('qrcode/' . $Student->qr_code->qr . '.svg') }}"
                                                        alt=""></td>
                                                <td colspan="2">
                                                    <a class="btn btn-outline-info btn-sm"
                                                        href="{{ url('Download_attachment_parcode') }}/{{ $Student->qr_code->qr . '.svg' }}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp;
                                                        {{ trans('Students_trans.Download') }}</a>



                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="profile-04" role="tabpanel"
                                aria-labelledby="profile-02-tab">
                                <div class="card card-statistics">

                                    <table class="table center-aligned-table mb-0 table table-hover"
                                        style="text-align:center">
                                        <thead>
                                            <tr class="table-secondary">

                                                <th scope="col">اسم الطالب</th>

                                                <th scope="col">تاريخ الحضور</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($Student->attendance as $attence)
                                                <tr style='text-align:center;vertical-align:middle'>
                                                    <td>{{ $Student->name }}</td>
                                                    <td> {{ $attence->attendence_date }} </td>

                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <div class="tab-pane fade" id="profile-05" role="tabpanel"
                                aria-labelledby="profile-02-tab">
                                <div class="card card-statistics">

                                    <table class="table center-aligned-table mb-0 table table-hover"
                                        style="text-align:center">
                                        <thead>
                                            <tr class="table-secondary">

                                                <th scope="col">اسم الطالب</th>

                                                <th scope="col">نوع الرسوم</th>
                                                <th scope="col">تاريخ الدفع</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($Student->fee_invoice as $fee_invoice)
                                                <tr style='text-align:center;vertical-align:middle'>
                                                    <td>{{ $Student->name }}</td>
                                                    <td>{{ $fee_invoice->fees->title }}</td>
                                                    <td> {{ $fee_invoice->Date }} </td>

                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <div class="tab-pane fade" id="profile-06" role="tabpanel"
                                aria-labelledby="profile-02-tab">
                                <div class="card card-statistics">

                                    <table class="table center-aligned-table mb-0 table table-hover"
                                        style="text-align:center">
                                        <thead>
                                            <tr class="table-secondary">

                                                <th scope="col">اسم الطالب</th>

                                                <th scope="col">اسم المادة </th>
                                                <th scope="col"> تاريخ الدرجة </th>
                                                <th scope="col"> درجة الطالب</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($Student->degree as $degree)
                                                <tr style='text-align:center;vertical-align:middle'>
                                                    <td>{{ $Student->name }}</td>
                                                    <td>{{ $degree->specialized->Name }}</td>
                                                    <td>{{ $degree->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ $degree->degree }}</td>


                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>








                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- row closed -->
    @endsection
    @section('js')
        @toastr_js
        @toastr_render
    @endsection
