<?php

namespace App\Http\Controllers;

use App\Models\sekolahM;
use App\Models\sekolahkriteriaM;
use App\Models\kriteriaM;
use App\Models\User;
use App\Models\subkriteriaM;
use Illuminate\Http\Request;
use Hash;

class indexC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kriteria = kriteriaM::get();
        $sekolah = sekolahM::get();
        return view("pages.index", [
            'sekolah' => $sekolah,
            'kriteria' => $kriteria
        ]);
    }

    public function login(Request $request)
    {
        
        return view("pages.login");
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('login');
    }

    public function proses(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required",
        ]);
        
        try {
            $username = $request->username;
            $password = $request->password;


            $cek = User::where("username", $username);
            if($cek->count() == 1) {
                $data = $cek->first();
                if(Hash::check($password, $data->password)) {
                    $request->session()->put('login', true);
                    $request->session()->put('email', $data->email);
                    $request->session()->put('username', $data->username);
                    $request->session()->put('posisi', $data->posisi);

                    // dd($data->posisi);
                    return redirect('home');
                }
            }

            return redirect()->back()->with("error", "username dan password salah")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "username dan password salah")->withInput();
        }
    }


    
    public function hitung(Request $request)
    {
        $kriteria = kriteriaM::get();
        $sekolah = sekolahM::get();
        
        foreach ($sekolah as $s) {
            $i=1;
            $namasekolah[] = $s->namasekolah; 
            $idsekolah[] = $s->idsekolah; 

            foreach ($kriteria as $k) {

                $namakriteria = str_replace(" ","",$k->namakriteria);
    
                if($k->typedata == "dinamis") {
                    
                    
                    $subkriteria = subkriteriaM::where("idkriteria", $k->idkriteria)->orderBy("namasubkriteria", "desc")->get();
                    $nilai = [];
                    foreach ($subkriteria as $sk) {
                        $nilai[] = [
                            "jumlah" => (int)$sk->namasubkriteria,
                            "nilai" => $sk->nilai,
                        ];
                    }
                    rsort($nilai);
                    
                    $sekolahkriteria = sekolahkriteriaM::where('idsekolah', $s->idsekolah)
                        ->where('idkriteria', $k->idkriteria)->first();
                    
                    $maxVal=1000000;

                    $kecil = min($nilai);

                    foreach ($nilai as $n) {
                        $nilaicari = (int)$request->$namakriteria;
                        $nilaisekolah = (int)$sekolahkriteria->nilai;
                        $nilaisub = $n["jumlah"];
                        
                        $ttd = 0;
                        // dd($nilaicari." ".$nilaisekolah." ".$nilaisub);
                       if($kecil["jumlah"] == $nilaisub) {
                        if($nilaicari >= $nilaisub && $ttd==0) {
                            if($nilaisekolah >= $nilaisub && $nilaisekolah < $maxVal) {
                                $data["C".$i][] = $n["nilai"];
                                $ttd = 1;
                            }
                            
                        }
                       }else {
                        if($nilaicari > $nilaisub && $ttd==0) {
                            if($nilaisekolah > $nilaisub && $nilaisekolah <= $maxVal) {
                                $data["C".$i][] = $n["nilai"];
                                $ttd = 1;
                            }
                            
                        }
                       }
                        

                        $maxVal = $nilaisub;
                    }

                    if($ttd == 0) {
                        $data["C".$i][] = 0;
                    }
                    
                }



                if($k->typedata == "statis"){
                    
                    $nilaisekolah = sekolahkriteriaM::where('idsekolah', $s->idsekolah)
                    ->where('idkriteria', $k->idkriteria)->first()->nilai;

                    $subkriteria = subkriteriaM::where("idkriteria", $k->idkriteria)
                    ->where("idsubkriteria", $nilaisekolah);

                    if($subkriteria->count() > 0) {
                        $nilaisub = (int) $subkriteria->first()->nilai;
                        $data["C".$i][] = $nilaisub;
                    }
                    
                }

                
                $i++;
            }
            
        }

        for ($i=1; $i <= count($kriteria); $i++) { 
            $min["minC".$i] = min($data["C".$i]);
            $max["maxC".$i] = max($data["C".$i]);
        }

        $i =1;
        foreach ($kriteria as $k) {
            $bobot["C".$i] = (double) $k->bobot / 100;
            $i++;
        }

        

        $normaldata = [
            "idsekolah" => $idsekolah,
            "namasekolah" => $namasekolah,
            "bobot" => $bobot,
            "data" => $data,
            "min" => $min,
            "max" => $max,
        ];

        $data = collect($normaldata);
        // dd($data);
        for ($i=1; $i <= count($data["data"]); $i++) { 
            foreach ($data["data"]["C".$i] as $d) {
                $Cmin = $data["min"]["minC".$i];
                $Cmax = $data["max"]["maxC".$i];
                $Cout = $d;
                
                // dd($Cmin." ".$Cmax." ".$Cout);
                $atas = $Cmax - $Cout; 
                $bawah = $Cmax - $Cmin; 
                if($atas == 0 && $bawah==0) {
                    $hasil = 0;
                }else {
                    $hasil = $atas / $bawah;
                }
                
                $dataNormal["C".$i][] = $hasil;
            }
        }

        $normaldata["normalisasi"] = $dataNormal;
        $data = collect($normaldata);

        for ($i=1; $i <= count($data["data"]); $i++) { 
            foreach ($data["normalisasi"]["C".$i] as $d) {
                $bobot = $data["bobot"]["C".$i];
                $hitung = $d * $bobot;
                
                $normalrumus["C".$i][] = $hitung; 
            }


        }

        $normaldata["hasilakhir"] = $normalrumus;
        $data = collect($normaldata);
        // dd($data);
        for ($i=0; $i < count($data["namasekolah"]); $i++) { 
            $nilai = 0;
            for ($ii=1; $ii <= count($data["hasilakhir"]); $ii++) { 
                $nilai = $nilai + $data["hasilakhir"]["C".$ii][$i];

                //tampil
                // $tampilranking[] =  $data["ranking"]["C".$ii][$i];
                
                $normal["C".$ii] =  $data["data"]["C".$ii][$i];
                $normalisasi["C".$ii] =  $data["normalisasi"]["C".$ii][$i];
                $hasilakhir["C".$ii] =  $data["hasilakhir"]["C".$ii][$i];
            }

            $ranking[] = $nilai;

            $total[] = [
                "ranking" => $nilai,
                "namasekolah" => $data["namasekolah"][$i],
                "bobot" => $data["bobot"],
                "min" => $data["min"],
                "max" => $data["max"],
                "normal" => $normal,
                "normalisasi" => $normalisasi,
                "hasilakhir" => $hasilakhir,
            ];

        }

        $data2 = collect($total);
        $hasilAkhir = $data2->sortDesc();

        $normaldata["ranking"] = $ranking;
        $data = collect($normaldata);

        // dd($hasilAkhir);
        // dd($hasilAkhir[0]["normal"]["C1"]);

        return view("pages.hasil", [
            "data" => $data2,
            "hasilakhir" => $hasilAkhir,
            "sekolah" => $sekolah,
            "kriteria" => $kriteria,
        ]);

        


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sekolahM  $sekolahM
     * @return \Illuminate\Http\Response
     */
    public function show(sekolahM $sekolahM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sekolahM  $sekolahM
     * @return \Illuminate\Http\Response
     */
    public function edit(sekolahM $sekolahM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sekolahM  $sekolahM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sekolahM $sekolahM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sekolahM  $sekolahM
     * @return \Illuminate\Http\Response
     */
    public function destroy(sekolahM $sekolahM)
    {
        //
    }
}
