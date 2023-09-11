@extends('layouts.master')

@section("title", "Data kriteria")


@section("title", "Data kriteria")
@section("warnakriteria", "active")


@section('content')






<div class="container">
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <div class="row">
                <div class="col-md-7">
                    {{-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahkriteria">Tambah Sekolah</button> --}}
                </div>
                
                <div class="col-md-5">
                    <form action="{{ url()->current() }}" method="get">
                        <div class="input-group ">
                            <input type="text" class="form-control" value="{{ $keyword }}" placeholder="berdasarkan nama sekolah" aria-describedby="button-addon2">
                            <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="card-body">
            <table class="table table-hover table-sm table-striped table-bordered">
                <thead>
                    <th>No</th>
                    <th>Kriteria</th>
                    <th>Bobot</th>
                    <th>Aksi</th>
                </thead>

                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->namakriteria }}</td>
                        <td>{{ $item->bobot }}</td>
                        <td>
                            {{-- <form action="{{ route('kriteria.destroy', [$item->idkriteria]) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin dihapus?')" class="badge badge-danger py-1 border-0">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form> --}}

                            <button class="badge py-1 border-0 badge-primary" type="button" data-toggle="modal" data-target="#ubahkriteria{{ $item->idkriteria }}">
                                <i class="fa fa-edit"></i> Ubah
                            </button>
                        </td>
                    </tr>

                    <div id="ubahkriteria{{ $item->idkriteria }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ubahkriteria" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ubahkriteria">Ubah Kriteria</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('kriteria.update', [$item->idkriteria]) }}" method="post">
                                    @csrf
                                    @method("PUT")
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="namakriteria">Nama Kriteria</label>
                                            <input id="namakriteria" class="form-control" type="text" name="namakriteria" value="{{ $item->namakriteria }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="bobot">Bobot</label>
                                            <input id="bobot" class="form-control" type="number" name="bobot" value="{{ $item->bobot }}">
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
@endsection
