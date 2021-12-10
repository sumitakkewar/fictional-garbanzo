<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('service_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_user_id')->onDelete('cascade');
            $table->foreignId('user_id')->onDelete('cascade');
            $table->timestamp('scheduled_time');
            $table->longText('desc');
            $table->string('latitude');
            $table->string('longitude');
            $table->longText('address');
            $table->enum('job_status', ["active", "inprogress", "completed", "cancelled", "rejected"])->default("active");
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
