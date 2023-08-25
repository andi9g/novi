@extends('layouts.master')

@section("title", "Home")


@section("title", "Home")
@section("warnahome", "active")


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $kriteria }}</h3>
                        <p>Kriteria</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-star"></i>
                    </div>
                    <a href="{{ url('kriteria', []) }}" class="small-box-footer">More info
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $sekolah }}</h3>
                        <p>Sekolah</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-home"></i>
                    </div>
                    <a href="{{ url('sekolah', []) }}" class="small-box-footer">More info
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
