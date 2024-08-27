<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{
    public function store(Request $request) {
        $validatedData = $request->validate([
            'norm' => 'required|string',
            'no_pendaftaran' => 'required|string',
            'tgl_kunjungan' => 'required|date',
            'poliklinik_id' => 'required|integer',
            'dokter_id' => 'required|integer',
            'penjamin' => 'required|integer',
            'status' => 'required|string',
        ]);

        $validatedData['penjamin_id'] = $validatedData['penjamin'];

        $pendaftaran = Pendaftaran::create($validatedData);

        // Return response
        $responseData = [
            'status' => 'success',
            'message' => 'Pendaftaran pasien berhasil',
            'data' => [
                'norm' => $pendaftaran->norm,
                'no_pendaftaran' => $pendaftaran->no_pendaftaran,
                'tgl_kunjungan' => $pendaftaran->tgl_kunjungan,
            ],
        ];

        return response()->json($responseData, 201);
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        $pendaftaran = Pendaftaran::find($id);

        if (!$pendaftaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pendaftaran tidak ditemukan',
            ], 404);

        }

        $pendaftaran->status = $validatedData['status'];
        if ($validatedData['status'] === 'selesai') {
            $pendaftaran->tgl_selesai_kunjungan = now();
        }
        $pendaftaran->save();

        
        $responseData = [
            'status' => 'success',
            'message' => 'Pendaftaran pasien dipulangkan!',
            'data' => [
                'norm' => $pendaftaran->norm,
                'no_pendaftaran' => $pendaftaran->no_pendaftaran,
                'tgl_kunjungan' => $pendaftaran->tgl_kunjungan,
                'tgl_selesai_kunjungan' => $pendaftaran->tgl_selesai_kunjungan ? $pendaftaran->tgl_selesai_kunjungan->format('Y-m-d H:i:s') : null, // Format yang benar
            ],
        ];

        return response()->json($responseData, 200);
    }
}
