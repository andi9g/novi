<?php

namespace App\Http\Controllers;

use App\Models\kriteriaM;
use Illuminate\Http\Request;

class kriteriaC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $data = kriteriaM::where("namakriteria", "like", "%$keyword%")
        ->get();

        return view("pages.kriteria", [
            'data' => $data,
            'keyword' => $keyword,
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
        try {
            $data = $request->all();
            $tambah = new kriteriaM($data);
            $tambah->save();
            
            return redirect()->back()->with("success", "data".$tambah->namakriteria." berhasil ditambahkan")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kriteriaM  $kriteriaM
     * @return \Illuminate\Http\Response
     */
    public function show(kriteriaM $kriteriaM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kriteriaM  $kriteriaM
     * @return \Illuminate\Http\Response
     */
    public function edit(kriteriaM $kriteriaM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\kriteriaM  $kriteriaM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kriteriaM $kriteriaM,$idkriteria)
    {
        try {
            $data = $request->all();
            $bobot = $request->bobot;
            $kriteria = kriteriaM::sum("bobot");
            

            $update = kriteriaM::where("idkriteria", $idkriteria)->first();

            $hitung = ($kriteria - $update->bobot) + $bobot;

            if($hitung > 100) {
                return redirect()->back()->with("error", "Bobot Melebihi 100%")->withInput();
            }

            $update->update($data);
            
            return redirect()->back()->with("success", "data".$update->namakriteria." berhasil diupdate")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kriteriaM  $kriteriaM
     * @return \Illuminate\Http\Response
     */
    public function destroy(kriteriaM $kriteriaM, $idkriteria)
    {
        try {
            kriteriaM::destroy($idkriteria);
            
            return redirect()->back()->with("success", "data berhasil dihapus")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "terjadi kesalahan")->withInput();
        }
    }
}
