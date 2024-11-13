<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResepController extends Controller
{
    public function index()
    {
        $resep = Resep::all();

        if ($resep->isNotEmpty()) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $resep
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 204); // 204 No Content
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_resep' => 'required',
            'bahan_resep' => 'required',
            'gambar_resep' => 'nullable',
            'keterangan_resep' => 'required'
        ]);


        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }

        $resep = Resep::create($storeData);
        return response([
            'message' => 'Add resep Success',
            'data' => $resep
        ], 201); // 201 Created
    }

    public function show(string $id)
    {
        $resep = Resep::find($id);

        if ($resep) {
            return response([
                'message' => 'resep Found',
                'data' => $resep
            ], 200);
        }

        return response([
            'message' => 'resep Not Found',
            'data' => null
        ], 404); // 404 Not Found
    }

    public function update(Request $request, string $id)
    {
        $resep = Resep::find($id);
        if (is_null($resep)) {
            return response([
                'message' => 'resep Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_resep' => 'required',
            'bahan_resep' => 'required',
            'gambar_resep' => 'nullable',
            'keterangan_resep' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }

        $resep->update($updateData);

        return response([
            'message' => 'Update resep Success',
            'data' => $resep
        ], 200);
    }

    public function destroy(string $id)
    {
        $resep = Resep::find($id);
        if (is_null($resep)) {
            return response([
                'message' => 'resep Not Found',
                'data' => null
            ], 404);
        }

        $resep->delete();
        return response([
            'message' => 'Delete resep Success',
            'data' => $resep
        ], 200);
    }

    public function searchByName($name)
    {
        $resep = Resep::where('nama_resep', 'LIKE', '%' . $name . '%')->get();

        if ($resep->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "Resep dengan nama tersebut tidak ditemukan",
                "data" => []
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => 'Berhasil ambil data resep',
            "data" => $resep
        ], 200);
    }
}
