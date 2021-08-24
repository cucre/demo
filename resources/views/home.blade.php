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
    @php
        $carbon_date = new \Carbon\Carbon();
        $carbon_date = $carbon_date->now()->formatLocalized("%A %d %B %Y");
    @endphp   
    <small>{{ $carbon_date ?? "" }}</small>
@endsection

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-body">
            <img src="{{ asset('/imgs/logo_principal.jpg') }}" class="center">
        </div>
    </div>
@endsection