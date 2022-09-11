@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة الدرجات
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    قائمة الدرجات
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


    @if ($errors->any())
        <div class="error">{{ $errors->first('Name') }}</div>
    @endif



    <div class="col-xl-12 mb-30">
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

                <a type="button" class="button x-small" href="{{ route('Degree1.create') }}">
                    اضافة درجات الطالب
                </a>
                <br><br>

                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('اسم طالب') }}</th>
                                <th>{{ trans('اسم الماده') }}</th>
                                <th>{{ trans('درجة الماده') }}</th>
                                <th>تاريخ الدرجة</th>
                                <th> العمليات </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($degrees as $degree)
                                <tr>
                                    <?php $i++; ?>
                                    <td>{{ $i }}</td>
                                    <td>{{ $degree->student->name }}</td>
                                    <td>{{ $degree->specialized->Name }}</td>
                                    <td>{{ $degree->degree }}</td>
                                    <td> {{ $degree->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $degree->id }}"
                                            title="{{ trans('Grades_trans.Edit') }}"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $degree->id }}"
                                            title="{{ trans('Grades_trans.Delete') }}"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- edit_modal_Grade -->
                                <div class="modal fade" id="edit{{ $degree->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    تعديل الدرجة
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- add_form -->
                                                <form action="{{ route('Degree1.update', 'test') }}" method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="exampleFormControlTextarea1"> تعديل اسم الطالب
                                                                :</label>
                                                            <select class="custom-select my-1 mr-sm-2"
                                                                name="student_id">
                                                                <option selected value="{{ $degree->student_id }}">
                                                                    {{ $degree->student->name }} </option>
                                                                @foreach ($students as $student)
                                                                    <option value="{{ $student->id }}">
                                                                        {{ $student->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input id="id" type="hidden" name="id"
                                                                class="form-control" value="{{ $degree->id }}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="Name_en" class="mr-sm-2"> تعديل درجة الطالب
                                                                :</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $degree->degree }}" name="degree_value"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1"> تعديل  اسم المادة
                                                            :</label>
                                                        <select class="custom-select my-1 mr-sm-2"
                                                            name="specialized_id">
                                                            <option value="{{ $degree->specializations_id }}">
                                                                {{ $degree->specialized->Name }} </option>
                                                            @foreach ($specializations as $specialization)
                                                                <option value="{{ $specialization->id }}">
                                                                    {{ $specialization->Name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <br><br>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- delete_modal_Grade -->
                                <div class="modal fade" id="delete{{ $degree->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    حذف الدرجة
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('Degree1.destroy', 'test') }}" method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    {{ trans('Grades_trans.Warning_Grade') }}
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $degree->id }}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ trans('Grades_trans.submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </table>
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
