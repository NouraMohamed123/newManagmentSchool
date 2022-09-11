@extends('layouts.master')
@section('css')

@section('title')
    تقرير الفواتير
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    تقارير الفواتير
@stop
<!-- breadcb -->

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

                    <form method="post" action="{{ route('Fees1.search') }}" autocomplete="off">
                        @csrf
                        <h6 style="font-family: 'Cairo', sans-serif;color: blue">معلومات البحث</h6><br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="student">الطلاب</label>
                                    <select class="custom-select mr-sm-2" name="student_id">
                                        <option value="0">الكل</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
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
                    @isset($feeInvoices)
                        <div class="table-responsive">
                            <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                                style="text-align: center">
                                <thead>
                                    <tr>
                                        <th class="alert-success">#</th>
                                        <th class="alert-success">اسم الطالب</th>
                                        <th class="alert-success">الرسوم دراسيه</th>
                                        <th class="alert-success"> التاريخ</th>
                                        <th class="alert-success">المبلغ</th>
                                        <th class="alert-success">الاجمالي</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    {{ $sum = 0 }}
                                    @foreach ($feeInvoices as $feeInvoice)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $feeInvoice->student->name }}</td>
                                            <td>{{ $feeInvoice->fees->title }}</td>
                                            <td> {{ $feeInvoice->created_at->format('d-m-Y') }} </td>
                                            <td>{{ $feeInvoice->amount }}</td>

                                            <td> {{ $sum += $feeInvoice->amount }} </td>

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

@endsection
