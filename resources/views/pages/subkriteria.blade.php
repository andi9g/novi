@extends('layouts.master')

@section("title", "Data subkriteria")


@section("title", "Data subkriteria")
@section("warnasubkriteria", "active")


@section('content')
<div class="row">
@foreach ($data as $item)

@php
    $typedata = $item->typedata;
@endphp
@if ($typedata=="dinamis")
    @php
        $type = "number";
    @endphp  
@else
    @php
        $type = "text";
    @endphp 
@endif

    <div id="tambahsubkriteria{{ $item->idkriteria }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Tambah Subkriteria {{ $item->namakriteria }}</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('subkriteria.store', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="namasubkriteria" class="form-control" type="text" name="idkriteria" value="{{ $item->idkriteria }}" hidden>
                        </div>
                        <div class="form-group">
                            <label for="namasubkriteria">Nama Subkriteria</label>
                            <input id="namasubkriteria" class="form-control" type="{{ $type }}" name="namasubkriteria">
                        </div>
    
                        <div class="form-group">
                            <label for="nilai">Nilai</label>
                            <input id="nilai" class="form-control" type="number" name="nilai">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah Subkriteria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


        <div class="col-md-6">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahsubkriteria{{ $item->idkriteria }}">Tambah Subkriteria</button>
                        </div>
                        <div class="col-md-8 text-right">
                            <h4>{{ strtoupper($item->namakriteria) }}</h4>
                        </div>
                    </div>
                </div>
        
        
                <div class="card-body">
                    <table class="table table-hover table-sm table-striped table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Subkriteria</th>
                            <th>Nilai</th>
                            <th>aksi</th>
                        </thead>

                        @php
                            $subkriteria = DB::table("subkriteria")->where("idkriteria", $item->idkriteria)->get();
                        @endphp

                        <tbody>
                            @foreach ($subkriteria as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->namasubkriteria }}</td>
                                    <td>{{ $item->nilai }}</td>
                                    <td>
                                        <form action="{{ route('subkriteria.destroy', [$item->idsubkriteria]) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin dihapus?')" class="badge badge-danger py-1 border-0">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
            
                                        <button class="badge py-1 border-0 badge-primary" type="button" data-toggle="modal" data-target="#ubahidsubkriteria{{ $item->idsubkriteria }}">
                                            <i class="fa fa-edit"></i> Ubah
                                        </button>
                                    </td>
                                </tr>


                                <div id="ubahidsubkriteria{{ $item->idsubkriteria }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ubahidsubkriteria" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ubahidsubkriteria">Ubah Kriteria</h5>
                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('subkriteria.update', [$item->idsubkriteria]) }}" method="post">
                                                @csrf
                                                @method("PUT")
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="namasubkriteria">Nama Subkriteria</label>
                                                        <input id="namasubkriteria" class="form-control" type="{{ $type }}" name="namasubkriteria" value="{{ $item->namasubkriteria }}">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="nilai">Nilai</label>
                                                        <input id="nilai" class="form-control" type="number" name="nilai"  value="{{ $item->nilai }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        Ubah Data
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        
            </div>
        </div>
        @endforeach
</div>
   
@endsection
