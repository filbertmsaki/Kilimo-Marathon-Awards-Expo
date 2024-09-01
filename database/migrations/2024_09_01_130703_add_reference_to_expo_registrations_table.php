<?php

use App\Models\ExpoRegistration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceToExpoRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expo_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('expo_registrations', 'reference')) {
                $table->string('reference')->nullable()->after('id');
            }
        });

        ExpoRegistration::whereNull('reference')->orWhere('reference', '')->chunk(100, function ($registrations) {
            foreach ($registrations as $registration) {
                $registration->reference = reference_no(ExpoRegistration::class);
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
        Schema::table('expo_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('expo_registrations', 'reference')) {
                $table->dropColumn('reference');
            }
        });
    }
}
