<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER id_packages BEFORE INSERT ON list_packages FOR EACH ROW
            BEGIN
                INSERT INTO sequence_packages VALUES (NULL);
                SET NEW.package_number = CONCAT("PK_", LPAD(LAST_INSERT_ID(), 6, "0"));
            END
        ');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER "id_packages"');
    }
};