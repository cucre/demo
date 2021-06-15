@extends('layouts.master')

@push('customcss')
    <style type="text/css">
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
    </style>
@endpush

@section('page-header')
    @php($carbon = new \Carbon\Carbon())
    @php($date = $carbon->now()->formatLocalized('%A %d %B %Y'))
    <small>{{ $date ?? "" }}</small>
@endsection

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-body">
            <img src="/imgs/logo_principal.jpg" class="center">
        </div>
    </div>
@endsection