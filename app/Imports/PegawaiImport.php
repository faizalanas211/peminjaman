<?php

namespace App\Imports;

use App\Models\Pegawai;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);

        // Konversi tanggal lahir
        $tanggalLahir = null;

        if (!empty($row['tgl_lahir'])) {
            // Jika berupa angka serial Excel (contoh: 30234)
            if (is_numeric($row['tgl_lahir'])) {
                $tanggalLahir = Date::excelToDateTimeObject($row['tgl_lahir'])->format('Y-m-d');
            } else {
                // Jika formatnya sudah string tanggal
                $tanggalLahir = date('Y-m-d', strtotime($row['tgl_lahir']));
            }
        }

        return new Pegawai([
            'nama'             => $row['nama_pegawai'],
            'nip'              => $row['nip'],
            'jenis_kelamin'    => $row['jenis_kelamin'],
            'tempat_lahir'     => $row['tempat_lahir'],
            'tanggal_lahir'    => $tanggalLahir,
            'jabatan'          => $row['jabatan'],
            'pangkat_golongan' => $row['pangkat_golongan'],
        ]);
    }
}