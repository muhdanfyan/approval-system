<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        Status::updateOrCreate(['name' => 'Menunggu Persetujuan'], ['id' => 1]);
        Status::updateOrCreate(['name' => 'Disetujui'], ['id' => 2]);
        Status::updateOrCreate(['name' => 'Ditolak'], ['id' => 3]);
    }
}
