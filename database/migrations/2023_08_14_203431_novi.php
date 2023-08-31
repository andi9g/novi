<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Novi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->bigIncrements('idsekolah');
            $table->string("namasekolah");
            $table->string("alamat");
            $table->timestamps();
        });

        Schema::create('sekolahkriteria', function (Blueprint $table) {
            $table->bigIncrements('idsekolahkriteria');
            $table->integer("idsekolah");
            $table->integer("idkriteria");
            $table->string("nilai");
            $table->timestamps();
        });


        Schema::create('kriteria', function (Blueprint $table) {
            $table->bigIncrements('idkriteria');
            $table->string("namakriteria")->unique();
            $table->double("bobot");
            $table->enum("typedata", ["dinamis", "statis"]);
            $table->timestamps();
        });

        Schema::create('subkriteria', function (Blueprint $table) {
            $table->bigIncrements('idsubkriteria');
            $table->integer("idkriteria");
            $table->string("namasubkriteria")->default("0");
            $table->integer("nilai")->default(0);
            $table->timestamps();
        });

        $namakriteria = [
            "Biaya Masuk-35-dinamis",
            "Biaya SPP-20-dinamis",
            "Lokasi-25-statis",
            "Sarana dan Prasarana-20-statis",
        ];

        $biayamasuk = [
            "700000-2",
            "50000-3",
            "0-4",
        ];
        $spp = [
            "150000-2",
            "100000-3",
            "40000-4",
        ];
        $jarak = [
            "Jauh dari jalan raya-3",
            "Dekat dengan jalan raya-1",
            "Sepi Penduduk-2",
            "Ramai Penduduk-4",
        ];
        $sarana = [
            "Cukup Baik-2",
            "Baik-3",
            "Sangat Baik-4",
        ];
        foreach ($sarana as $item) {
            $ex = explode("-", $item);
            DB::table("subkriteria")->insert([
                "idkriteria" => 4,
                "namasubkriteria" => $ex[0],
                "nilai" => $ex[1],
            ]);
        }
        foreach ($jarak as $item) {
            $ex = explode("-", $item);
            DB::table("subkriteria")->insert([
                "idkriteria" => 3,
                "namasubkriteria" => $ex[0],
                "nilai" => $ex[1],
            ]);
        }
        foreach ($spp as $item) {
            $ex = explode("-", $item);
            DB::table("subkriteria")->insert([
                "idkriteria" => 2,
                "namasubkriteria" => $ex[0],
                "nilai" => $ex[1],
            ]);
        }

        foreach ($biayamasuk as $item) {
            $ex = explode("-", $item);
            DB::table("subkriteria")->insert([
                "idkriteria" => 1,
                "namasubkriteria" => $ex[0],
                "nilai" => $ex[1],
            ]);
        }
        

        foreach ($namakriteria as $item) {
            


            $ex = explode("-", $item);
            DB::table("kriteria")->insert([
                "namakriteria" => $ex[0],
                "bobot" => $ex[1],
                "typedata" => $ex[2],
            ]);

            



        }

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
