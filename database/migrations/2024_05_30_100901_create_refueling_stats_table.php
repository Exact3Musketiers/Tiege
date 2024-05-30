<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('refueling_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained();
            $table->integer('odo_reading');
            $table->integer('liters_tanked');
            $table->integer('price_per_liter');
            $table->integer('usage')->nullable();
            $table->date('record_date');
            $table->timestamps();
        });
        DB::select(
            DB::raw('alter table `refueling_stats` add index `refueling_stats_car_id_record_date_index`(`car_id`, `record_date` desc)')
                ->getValue(DB::connection()->getQueryGrammar())
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('refueling_stats');
    }
};
