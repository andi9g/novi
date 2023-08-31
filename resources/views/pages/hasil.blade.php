<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Hasil Ranking</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        h5 {
            font-weight: bold;
        }
        th {
            text-align: center;
        }
        td {
            text-align: center;
        }
    </style>

  </head>
  <body>
   <br>
   <br>
   <br>

   <div id="perhitungan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Hasil Perhitungan</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Tabel Alternative</h5>
                        <table border="1">
                            <tr>
                                <th>Alternative</th>
                                <th>Nama Sekolah</th>
                            </tr>
                            @foreach ($sekolah as $s)
                                <tr>
                                    <td>{{ "A".$loop->iteration }}</td>
                                    <td>{{ $s->namasekolah }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Bobot Kriteria</h5>
                        <table border="1">
                            <tr>
                                <th>Kriteria</th>
                                <th>Keterangan</th>
                                <th>Bobot</th>
                            </tr>
                            @foreach ($kriteria as $k)
                                <tr>
                                    <td>{{ "C".$loop->iteration }}</td>
                                    <td>{{ $k->namakriteria }}</td>
                                    <td>{{ $k->bobot / 100 }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>


                <h5>Table Normalisasi</h5>
                <table border="1">
                    <tr>
                        <th class="text-center" rowspan="2" width="20%">Alternative</th>
                        <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>
                    </tr>
                    <tr>
                        @foreach ($kriteria as $k)
                            <th class="text-center">{{ "C".$loop->iteration }}</th>
                        @endforeach
                    </tr>

                    @foreach ($sekolah as $s)
                        <tr>
                            <td class="text-center">{{ "A".$loop->iteration }}</td>
                            @for ($i=1 ; $i <= count($kriteria); $i++)
                                <td class="text-center">
                                    {{ $data[($loop->iteration-1)]["normal"]["C".$i] }}
                                </td>
                            @endfor
                                
                        </tr>
                    @endforeach
                </table>

                <br>
                <h5>Nilai Min</h5>
                <table border="1">
                    <tr>
                        <th colspan="{{ count($kriteria) }}">Kriteria</th>
                    </tr>
                    <tr>
                        @foreach ($kriteria as $k)
                            <td>{{ "C".$loop->iteration }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        @foreach ($data[0]["min"] as $item)
                        <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                        
                    
                </table>

                <br>
                <h5>Nilai Max</h5>
                <table border="1">
                    <tr>
                        <th colspan="{{ count($kriteria) }}">Kriteria</th>
                    </tr>
                    <tr>
                        @foreach ($kriteria as $k)
                            <td>{{ "C".$loop->iteration }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        @foreach ($data[0]["max"] as $item)
                        <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                        
                    
                </table>

                <p>Menghitung nilai utility :</p>
                <table style="width: fit-content">
                    <tr>
                        <td rowspan="2">Ui(ai) = </td>
                        <td style="border-bottom: 1px solid black">Cmax - Cout</td>
                    </tr>
                    <tr>
                        <td>Cmax - Cmin</td>
                    </tr>
                </table>


                <br>
                <h5>Matriks Hasil Nilai Utility</h5>
                <table border="1">
                    <tr>
                        <th class="text-center" rowspan="2" width="20%">Alternative</th>
                        <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>
                    </tr>
                    <tr>
                        @foreach ($kriteria as $k)
                            <th class="text-center">{{ "C".$loop->iteration }}</th>
                        @endforeach
                    </tr>

                    @foreach ($sekolah as $s)
                        <tr>
                            <td class="text-center">{{ "A".$loop->iteration }}</td>
                            @for ($i=1 ; $i <= count($kriteria); $i++)
                                <td class="text-center">
                                    {{ $data[($loop->iteration-1)]["normalisasi"]["C".$i] }}
                                </td>
                            @endfor
                                
                        </tr>
                    @endforeach
                </table>

                <p>Menghitung Nilai Akhir:</p>
                <p>Matriks hasil utility * dengan bobot kriteria</p>

                <br>
                <h5>Hasil Akhir belum di Urutkan</h5>
                <table border="1">
                    <tr>
                        <th class="text-center" rowspan="2" width="20%">Alternative</th>
                        <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>
                        <th class="text-center" rowspan="2" width="20%">Ranking</th>
                    </tr>
                    <tr>
                        @foreach ($kriteria as $k)
                            <th class="text-center">{{ "C".$loop->iteration }}</th>
                        @endforeach
                    </tr>

                    @foreach ($sekolah as $s)
                        <tr>
                            <td class="text-center">{{ "A".$loop->iteration }}</td>
                            @for ($i=1 ; $i <= count($kriteria); $i++)
                                <td class="text-center">
                                    {{ $data[($loop->iteration-1)]["hasilakhir"]["C".$i] }}
                                </td>
                            @endfor
                            <td>{{ $data[($loop->iteration-1)]["ranking"] }}</td>
                                
                        </tr>
                    @endforeach
                </table>



                <br>
                <h5>Hasil Akhir telah di Urutkan</h5>
                <table border="1">
                    <tr>
                        <th class="text-center" rowspan="2" width="20%">Nama Sekolah</th>
                        <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>
                        <th class="text-center" rowspan="2" width="20%">Ranking</th>
                        <th class="text-center" rowspan="2" width="20%">Pringkat</th>
                    </tr>
                    <tr>
                        @foreach ($kriteria as $k)
                            <th class="text-center">{{ "C".$loop->iteration }}</th>
                        @endforeach
                    </tr>

                    @foreach ($hasilakhir as $item)
                        <tr>
                            <td>{{ $item["namasekolah"] }}</td>
                            @foreach ($item["hasilakhir"] as $ha)
                                <td>{{ $ha }}</td>
                            @endforeach
                            <td>{{ $item["ranking"] }}</td>
                            <td>{{ $loop->iteration }}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
   </div>
    <div class="container">
        <h1 class="text-center">
            HASIL ANALISA
        </h1>
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/', []) }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#perhitungan">Lihat Perhitungan</button>
            </div>

            <div class="card-body">
                <table class="table-sm table table-hover table-striped table-bordered">
                    <thead>

                        <tr>
                            <th class="text-center" rowspan="2" width="20%">Nama Sekolah</th>
                            <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>
                            <th class="text-center" rowspan="2" width="20%">Ranking</th>
                            <th class="text-center" rowspan="2" width="20%">Pringkat</th>
                        </tr>
                        <tr>
                            @foreach ($kriteria as $k)
                                <th class="text-center">{{ "C".$loop->iteration }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    @foreach ($hasilakhir as $item)
                        <tr>
                            <td>{{ $item["namasekolah"] }}</td>
                            @foreach ($item["hasilakhir"] as $ha)
                                <td>{{ $ha }}</td>
                            @endforeach
                            <td>{{ $item["ranking"] }}</td>
                            <td>{{ $loop->iteration }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
   </div>

    

      

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>