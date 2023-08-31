@extends('layouts.master')

@section("title", "Data Sekolah")


@section("title", "Data Sekolah")
@section("warnasekolah", "active")


@section('content')
    <div id="tambahsekolah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambahsekolah" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahsekolah">Tambah Sekolah</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sekolah.store', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namasekolah">Nama Sekolah</label>
                            <input id="namasekolah" class="form-control" type="text" name="namasekolah">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" class="form-control" type="text" name="alamat">
                        </div>
    
                        @foreach ($kriteria as $item)
                            @php
                                $name = str_replace(" ", "", $item->namakriteria);
                            @endphp
                            @if ($item->typedata == "dinamis")
                                <div class="form-group">
                                    <label for="{{ $name }}">{{ $item->namakriteria }}</label>
                                    <input id="{{ $name }}" required class="form-control" type="number" name="{{ $name }}">
                                </div> 
    
                            @elseif($item->typedata == "statis")
                                <div class="form-group">
                                    <label for="{{ $name }}">{{ $item->namakriteria }}</label>
                                    <select id="{{ $name }}" required class="form-control" name="{{ $name }}">
                                        @php
                                            $subkriteria = DB::table("subkriteria")->where("idkriteria", $item->idkriteria)->get();
    
                                        @endphp
                                        @foreach ($subkriteria as $sk)
                                            <option value="{{ $sk->idsubkriteria }}">{{ $sk->namasubkriteria }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
    
                            @endif
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary">
                            Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            Tambah Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-7">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahsekolah">Tambah Sekolah</button>
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
                        <table class="table table-hover table-striped table-sm table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Sekolah</th>
                                <th>Alamat</th>
                                <th>Detail Sekolah</th>
                                <th>Aksi</th>
                            </thead>

                            <tbody>
                                @foreach ($sekolah as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $sekolah->firstItem() - 1 }}</td>
                                        <td>{{ $item->namasekolah }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>
                                            <button class="badge border-0 py-1 badge-primary" type="button" data-toggle="modal" data-target="#ubahdetailsekolah{{ $item->idsekolah }}"><i class="fa fa-eye"></i>Detail</button>
                                        </td>
                                        <td>
                                            <form action="{{ route('sekolah.destroy', [$item->idsekolah]) }}" method="post" class="d-inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="badge badge-danger border-0 py-1" onclick="return confirm('Lanjutkan proses hapus?')">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>

                                            <button class="badge border-0 py-1 badge-info" type="button" data-toggle="modal" data-target="#update{{ $item->idsekolah }}"><i class="fa fa-edit"></i>Update</button>
                                        </td>
                                    </tr>

                                    <div id="update{{ $item->idsekolah }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">Update Data</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('sekolah.update', [$item->idsekolah]) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="namasekolah">Nama Sekolah</label>
                                                            <input id="namasekolah" class="form-control" value="{{ $item->namasekolah }}" type="text" name="namasekolah">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="alamat">Alamat</label>
                                                            <input id="alamat" class="form-control" type="text" value="{{ $item->alamat }}" name="alamat">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">
                                                            Update Data
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="ubahdetailsekolah{{ $item->idsekolah }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">Detail Sekolah</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('ubah.detail', [$item->idsekolah]) }}" method="post">
                                                    @method("PUT")
                                                    @csrf
                                                    <div class="modal-body">
                                                        @foreach ($kriteria as $kt)
                                                        @php
                                                            $name = str_replace(" ", "", $kt->namakriteria);
                                                            $value = DB::table("sekolahkriteria")->where("idsekolah", $item->idsekolah)->where("idkriteria", $kt->idkriteria)->first();
                                                        @endphp
                                                        @if ($kt->typedata == "dinamis")
                                                            <div class="form-group">
                                                                <label for="{{ $name }}">{{ $kt->namakriteria }}</label>
                                                                <input id="{{ $name }}" required class="form-control" value="{{ $value->nilai }}" type="number" name="{{ $name }}">
                                                            </div> 
                                
                                                        @elseif($kt->typedata == "statis")
                                                            <div class="form-group">
                                                                <label for="{{ $name }}">{{ $kt->namakriteria }}</label>
                                                                <select id="{{ $name }}" required class="form-control" name="{{ $name }}">
                                                                    @php
                                                                        $subkriteria = DB::table("subkriteria")->where("idkriteria", $kt->idkriteria)->get();
                                
                                                                    @endphp
                                                                    @foreach ($subkriteria as $sk)
                                                                        <option value="{{ $sk->idsubkriteria }}" @if ($sk->idsubkriteria == $value->nilai)
                                                                            selected
                                                                        @endif>{{ $sk->namasubkriteria }}</option>
                                                                    @endforeach
                                                                    
                                                                </select>
                                                            </div>
                                
                                                        @endif
                                                    @endforeach
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Update Detail</button>
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
        </div>
    </div>
@endsection
