<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            // Add user_id for per-user data isolation
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->index('user_id', 'contents_user_id_index');
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropIndex('contents_user_id_index');
            $table->dropColumn('user_id');
        });
    }
};
