<?php

use App\Models\AgriTourism;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceToAgriTourismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agri_tourisms', function (Blueprint $table) {
            if (!Schema::hasColumn('agri_tourisms', 'reference')) {
                $table->string('reference')->nullable()->after('id');
            }
        });

        AgriTourism::whereNull('reference')->orWhere('reference', '')->chunk(100, function ($registrations) {
            foreach ($registrations as $registration) {
                $registration->reference = reference_no(AgriTourism::class);
                $registration->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agri_tourisms', function (Blueprint $table) {
            if (Schema::hasColumn('agri_tourisms', 'reference')) {
                $table->dropColumn('reference');
            }
        });
    }
}
