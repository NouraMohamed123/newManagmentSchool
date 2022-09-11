<?php

//use SimpleSoftwareIO\QrCode\Facades\QrCode;
?>
@extends('layouts.master')
@section('css')
    @livewireStyles
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
              {{-- {!!QrCode::generate('Make me into a QrCode!')!!} ; --}}
              {{-- {{$qr}} --}}

                  <form action="{{route('qrCode')}}" method="POST">
                    @csrf
                       <input type="text" name="name">
                       <input type="text" name="body">
                       <input type="submit" value=" generate Qr code">
                       {{-- <button type="submit" name="submit"> generate Qr code</button> --}}


                </form>
                <?php
                if (!empty($body)):
                   echo QrCode::generate( $body );
            endif;

                ?>


            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
    @livewireScripts
@endsection
