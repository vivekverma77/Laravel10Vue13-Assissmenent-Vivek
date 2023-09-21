<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedUserIdToTasks extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add the new column
            $table->unsignedBigInteger('assigned_user_id')->nullable();

            // Set up the foreign key relationship
            $table->foreign('assigned_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null'); // or 'cascade' or 'restrict', depending on your needs
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['assigned_user_id']);
            
            // Drop the column
            $table->dropColumn('assigned_user_id');
        });
    }
}
