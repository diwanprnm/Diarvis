@extends('admin.layout.index')

@section('title') Tambah Data Gedung dan Bangunan (KIB C)@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">

<style>
    table.table-bordered tbody td {
        word-break: break-word;
        vertical-align: top;
    }
</style>
@endsection

@section('page-header')

<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4> Tambah Data Gedung dan Bangunan (KIB C)</h4>
                <span></span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-1.htm"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Data Barang</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Intra</a>
                </li>
                <li class="breadvcrumb-item"><a href="#">Gedung dan Bangunan</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')

@endsection


