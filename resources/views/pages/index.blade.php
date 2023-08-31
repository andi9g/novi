<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>SPK SMART</title>
  

  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
        <a class="navbar-brand" href="#">SPK SMART</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{ url('/', []) }}">Form Pencarian</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#sekolah">Data Sekolah</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#analisa">Analisa</a>
              </li>
          </ul>
          <span class="navbar-text">
            <a href="{{ url('login', []) }}" class="">Login</a>
          </span>
        </div>
      </nav>
      

<div class="container-fluid mt-5">
    <div class="jumbotron " style="background: url('gambar/bg.jpeg')">
      <div class="p-3 text-center" style="background: rgba(255, 255, 255, 0.884);">
          <h1 class="display-2 text-bold mb-0"><b>SPK</b></h1>
          <h3 class=" text-bold my-0"><b>Sistem Pendukung Keputusan</b></h3>
          <p class="lead">Menggunakan Metode Simple Multi Attribute Rating Tecհnique (SMART)</p>
          <hr class="my-4">
          <p>Sistem pendukung keputusan dalam menentukan pemilihan TK/PAUD pada kecamatan Gunung Kijang yang sesuai keinginan orangtua untuk anaknya</p>
          <a class="btn btn-primary btn-lg" href="#analisa" role="button">Lakukan Analisa</a>

      </div>
    </div>


    <div class="pt-4">
        <div id="sekolah" class="">
          <div class="container">
              <div class="card text-center">
                  <div class="card-header bg-primary">
                      <h3>Data Sekolah</h3>
                  </div>
                  <div class="card-body text-left">
                      <table class="table table-sm table-striped table-hover">
                          <thead>
                              <th>No</th>
                              <th>Nama Sekolah</th>
                              <th>Alamat</th>
                          </thead>
    
                          <tbody>
                              @foreach ($sekolah as $item)
                                  <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $item->namasekolah }}</td>
                                      <td>{{ $item->alamat }}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                  <div class="card-footer"></div>
              </div>
          </div>
        </div>

    </div>

    <br>
    <br>

    <div id="analisa" class="container mb-6">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h3 class="my-0">ANALISA</h3>
                    </div>
                    <form action="{{ route('hitung', []) }}" method="post">
                        @csrf
                        <div class="card-body">
                            @foreach ($kriteria as $item)
                                @php
                                    $namakriteria = str_replace(" ", "",$item->namakriteria);
                                @endphp
                                @if ($item->typedata == "dinamis")
                                    <div class="form-group">
                                        <label for="{{ $namakriteria }}">{{ $item->namakriteria }}</label>
                                        <input required id="{{  $namakriteria}}" class="form-control" type="number" name="{{ $namakriteria }}" placeholder="masukan angka">
                                    </div>
    
                                @elseif($item->typedata=="statis")
                                @php
                                    $subkriteria = DB::table('subkriteria')->where("idkriteria", $item->idkriteria)->get();
                                @endphp
                                    <div class="form-group">
                                        <label for="{{ $namakriteria }}">{{ $item->namakriteria }}</label>
                                        <select required id="{{ $namakriteria }}" class="form-control" name="">
                                            <option value="">Pilih</option>
                                            @foreach ($subkriteria as $sk)
                                            <option value="{{ $sk->idsubkriteria }}">{{ $sk->namasubkriteria }}</option>
                                                
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                
    
                            @endforeach
                        </div>
    
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                Proses Analisa
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</div>

    

      

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>