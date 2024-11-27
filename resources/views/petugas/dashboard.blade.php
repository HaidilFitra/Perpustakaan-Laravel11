@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Dashboard Petugas</h6>
                </div>
                <div class="card-body">
                    <p>Selamat datang, {{ Auth::user()->nama_lengkap }}</p>
                    <p>Anda login sebagai Petugas</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
