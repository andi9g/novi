<?php

namespace App\Http\Controllers;

use App\Models\sekolahM;
use App\Models\kriteriaM;
use App\Models\sekolahkriteriaM;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class sekolahC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $sekolah = sekolahM::where("namasekolah", "like", "$keyword%")
        ->paginate(15);
        $sekolah->appends($request->only(["limit", "keyword"]));

        $kriteria = kriteriaM::orderBy("idkriteria", "asc")->get();
        return view("pages.sekolah", [
            'sekolah' => $sekolah,
            'keyword' => $keyword,
            'kriteria' => $kriteria,
        ]);
        
    }

    public function home(Request $request)
    {
        $kriteria = kriteriaM::count();
        $sekolah = sekolahM::count();
        return view('pages.home', [
            "kriteria" => $kriteria,
            "sekolah" => $sekolah,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "namasekolah" => "required",
            "alamat" => "required",
        ]);

        try {
            $namasekolah = $request->namasekolah;
            $alamat = $request->alamat;

            $tambah = new sekolahM;
            $tambah->namasekolah = $namasekolah;
            $tambah->alamat = $alamat;
            $tambah->save();

            $id = $tambah->idsekolah;

            $kriteria = kriteriaM::orderBy("idkriteria", "asc")->get();
            foreach ($kriteria as $item) {
                $name = str_replace(" ", "", $item->namakriteria);
                $detail = new sekolahkriteriaM;
                $detail->idsekolah = $id;
                $detail->idkriteria = $item->idkriteria;
                $detail->nilai = $request->$name;
                $detail->save();
            }


            return redirect()->back()->with("success", "Data berhasil ditambahkan")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }


    }

    public function detailupdate(Request $request, $idsekolah) 
    {
        try {
            $id = $idsekolah;
            $kriteria = kriteriaM::orderBy("idkriteria", "asc")->get();
            foreach ($kriteria as $item) {
                $name = str_replace(" ", "", $item->namakriteria);

                sekolahkriteriaM::where("idsekolah", $id)->where("idkriteria", $item->idkriteria)->update([
                    "nilai" => $request->$name
                ]);
            }
            return redirect()->back()->with("success", "Detail Berhasil Diubah")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
        
    }

    
    public function hitung(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');

        
        $client = new Client();
        $response = $client->get("https://maps.googleapis.com/maps/api/distancematrix/json", [
            'query' => [
                'units' => 'metric',
                'origins' => $origin,
                'destinations' => $destination,
                'key' => config('app.google_maps_api_key'),
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        dd($data);

        $distance = $data['rows'][0]['elements'][0]['distance']['text'];
        $duration = $data['rows'][0]['elements'][0]['duration']['text'];

        return view('calculate_distance', compact('origin', 'destination', 'distance', 'duration'));
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
    public function update(Request $request, sekolahM $sekolahM, $idsekolah)
    {
        try {
            $data = $request->all();
            $update = sekolahM::where("idsekolah", $idsekolah)->first();
            $update->update($data);

            return redirect()->back()->with("success", "Detail Berhasil Diubah")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sekolahM  $sekolahM
     * @return \Illuminate\Http\Response
     */
    public function destroy(sekolahM $sekolahM, $idsekolah)
    {
        sekolahM::destroy($idsekolah);
        return redirect()->back()->with("success", "data berhasil dihapus")->withInput();
    }
}
