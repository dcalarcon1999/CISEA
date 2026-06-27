<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER logs_actividad_no_update
            BEFORE UPDATE ON logs_actividad
            FOR EACH ROW
            SIGNAL SQLSTATE "45000"
            SET MESSAGE_TEXT = "SICEA: los registros de logs_actividad son inmutables y no pueden modificarse.";
        ');

        DB::unprepared('
            CREATE TRIGGER logs_actividad_no_delete
            BEFORE DELETE ON logs_actividad
            FOR EACH ROW
            SIGNAL SQLSTATE "45000"
            SET MESSAGE_TEXT = "SICEA: los registros de logs_actividad son inmutables y no pueden eliminarse.";
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS logs_actividad_no_update');
        DB::unprepared('DROP TRIGGER IF EXISTS logs_actividad_no_delete');
    }
};
