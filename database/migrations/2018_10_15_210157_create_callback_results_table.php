<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCallbackResultsTable
 */
class CreateCallbackResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callback_results', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedInteger('outbound_message_text_id')->nullable()->default(null);
            $table->json('data')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('outbound_message_text_id')
                ->references('id')
                ->on('outbound_message_texts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callback_results');
    }
}
