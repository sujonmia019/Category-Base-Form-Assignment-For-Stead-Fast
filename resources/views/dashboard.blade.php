@extends('layouts.app')
@section('title',$title)
@push('scripts')
<style>
    .info-box {
        display: block;
        min-height: 90px;
        background: #fff;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        border-radius: 2px;
        margin-bottom: 15px;
    }
    .info-box-icon {
        font-size: 40px !important;
    }
    .info-box i {
        color: #fff;
    }
    .info-box-content {
        height: 90px;
    }
    .info-box-content {
        padding: 5px 10px;
        margin-left: 90px;
    }
    .info-box-text {
        white-space: pre-wrap !important;
        font-weight: 600;
        text-transform: uppercase;
        margin-top: 15px;
        display: block;
        color: #000000;
    }
    .info-box-number {
        margin-top: 5px;
        display: block;
        font-weight: bold;
        font-size: 18px;
        color: #000000;
    }
    .info-box-icon {
        border-top-left-radius: 2px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 2px;
        display: block;
        float: left;
        height: 90px;
        width: 90px;
        text-align: center;
        font-size: 45px;
        line-height: 90px;
        background: rgba(0,0,0,0.2);
    }
    .info-box-icon {
        border-top-left-radius: 2px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 2px;
        display: block;
        float: left;
        height: 90px;
        width: 90px;
        text-align: center;
        font-size: 45px;
        line-height: 90px;
        background: rgba(0,0,0,0.2);
    }
    .bg-aqua {
        background-color: #00c0ef !important;
    }
    .bg-yellow {
        background-color: #f39c12 !important;
    }
</style>
@endpush
@section('content')
<!-- top tiles -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-file-text-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">total users</span>
                <span class="info-box-number">{{ $totalUser }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-file-archive-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">total categories</span>
                <span class="info-box-number">{{ $totalCategory }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-file-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">total forms</span>
                <span class="info-box-number">{{ $totalForm }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">total records</span>
                <span class="info-box-number">{{ $totalRecord }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /top tiles -->
@endsection

@push('scripts')

@endpush
