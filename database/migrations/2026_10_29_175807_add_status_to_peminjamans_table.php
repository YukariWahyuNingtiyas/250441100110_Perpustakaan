
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->enum('status', [
                'diajukan',
                'dipinjam',
                'dikembalikan',
                'ditolak'
            ])->default('diajukan')->after('tanggal_kembali');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
