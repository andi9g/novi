<?php

namespace App\Http\Controllers;

use App\Models\subkriteriaM;
use App\Models\kriteriaM;
use Illuminate\Http\Request;

class subkriteriaC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = kriteriaM::get();

        return view("pages.subkriteria", [
            'data' => $data,
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
            $tambah = new subkriteriaM($data);
            $tambah->save();
            
            return redirect()->back()->with("success", "data".$tambah->namasubkriteria." berhasil ditambahkan")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subkriteriaM  $subkriteriaM
     * @return \Illuminate\Http\Response
     */
    public function show(subkriteriaM $subkriteriaM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subkriteriaM  $subkriteriaM
     * @return \Illuminate\Http\Response
     */
    public function edit(subkriteriaM $subkriteriaM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subkriteriaM  $subkriteriaM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subkriteriaM $subkriteriaM, $idsubkriteria)
    {
        try {
            $data = $request->all();
            $update = subkriteriaM::where("idsubkriteria", $idsubkriteria)->first();
            $update->update($data);
            
            return redirect()->back()->with("success", "data".$update->namasubkriteria." berhasil ditambahkan")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subkriteriaM  $subkriteriaM
     * @return \Illuminate\Http\Response
     */
    public function destroy(subkriteriaM $subkriteriaM, $idsubkriteria)
    {
        subkriteriaM::destroy($idsubkriteria);
        return redirect()->back()->with("success", "data berhasil dihapus")->withInput();
    }
}
