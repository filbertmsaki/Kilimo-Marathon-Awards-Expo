<?php

use App\Models\MarathonRegistration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceToMarathonRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marathon_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('marathon_registrations', 'reference')) {
                $table->string('reference')->nullable()->after('id');
            }
        });

        MarathonRegistration::whereNull('reference')->orWhere('reference', '')->chunk(100, function ($registrations) {
            foreach ($registrations as $registration) {
                $registration->reference = reference_no(MarathonRegistration::class);
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
        Schema::table('marathon_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('marathon_registrations', 'reference')) {
                $table->dropColumn('reference');
            }
        });
    }
}
