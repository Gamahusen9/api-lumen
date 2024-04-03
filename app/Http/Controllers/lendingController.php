<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\lending;
use App\models\Stuff;
use App\models\user;
use Illuminate\Support\Facades\Validator;

class lendingController extends Controller
{
    public function index(){
        $lending = lending::all();

        return response()->json([
            'success' => true,
            'message' => 'Lihat semua barang',
            'data' => $lending
        ],200);
    }

    public function store(Request $request){
        $validator = Validator::make
        ($request->all(), [
            'stuff_id' => 'required',
            'date_time' => 'required',
            'name' => 'required',
            'user_id' => 'required',
            'notes' => 'required',
            'total_stuff' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
             'success' => false,
             'message' => 'Semua kolom wajib disi!',
             'data' => $validator->errors()
            ],400);
    } else {
        $lending = lending::create([
            'stuff_id' => $request->input('stuff_id'),
            'date_time' => $request->input('date_time'),
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id'),
            'notes' => $request->input('notes'),
            'total_stuff' => $request->input('total_stuff'),
        ]);
    }


    if ($lending) {
        return response()->json([
          'success' => true,
          'message' => 'Barang berhasil ditambahkan',
            'data' => $lending
        ],200);
    } else{
        return response()->json([
          'success' => false,
          'message' => 'Barang gagal ditambahkan',
        ],400);
    }
    }
    public function show($id){
        try{
            $lending = lending::findOrFail($id);
            return response()->json([
             'success' => true,
             'message' => 'Lihat Barang dengan id $id',
                'data' => $lending
            ],200);

    } catch(Exception $th) {
        return response()->json([
       'success' => false,
       'message' => 'Data dengan id $id tidak ditemukan',
        ],400);
    }
}

public function update(Request $request, $id){
    try{
        $lending = lending::findOrFail($id);
        $stuff_id = ($request->stuff_id) ? $request->stuff_id : $lending->stuff_id;
        $date_time = ($request->date_time)? $request->date_time : $lending->date_time;
        $name = ($request->name)? $request->name : $lending->name;
        $user_id = ($request->user_id)? $request->user_id : $lending->user_id;
        $notes = ($request->notes)? $request->notes : $lending->notes;
        $total_stuff = ($request->total_stuff)? $request->total_stuff : $lending->total_stuff;

        if ($lending) {
            $lending->update([
                'stuff_id' => $stuff_id,
                'date_time' => $date_time,
                'name' => $name,
                'user_id' => $user_id,
                'notes' => $notes,
                'total_stuff' => $total_stuff,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Barang Ubah Data dengan id '.$id,
                    'data' => $lending
                ],200);
        } else{
            return response()->json([
              'success' => false,
              'message' => 'Proses gagal',
            ],400);
        }


    } catch(\Throwable $th){
        return response()->json([
          'success' => false,
          'message' => 'Proses gagal! data dengan id '.$id.' tidak ditemukan',
        ],400);
    }

}

public function destroy($id){
    try{
        $lending = lending::findOrFail($id);

        $lending->delete();

        return response()->json([
         'success' => true,
         'message' => 'Barang Hapus Data dengan id $id',
            'data' => $lending
        ],200);
    } catch(\Throwable $th){
        return response()->json([
        'success' => false,
        'message' => 'Proses gagal! data dengan id $id tidak ditemukan',
        ],400);
    }
}
}
