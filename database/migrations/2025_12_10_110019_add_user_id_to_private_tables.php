<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('cultivos')) {
            Schema::table('cultivos', function (Blueprint $table) {
                if (!Schema::hasColumn('cultivos', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');
                }
            });
        }

        // variables_ambientales
        if (Schema::hasTable('variables_ambientales')) {
            Schema::table('variables_ambientales', function (Blueprint $table) {
                if (!Schema::hasColumn('variables_ambientales', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('siembra_id');
                }
            });
        }

        // bitacoras
        if (Schema::hasTable('bitacoras')) {
            Schema::table('bitacoras', function (Blueprint $table) {
                if (!Schema::hasColumn('bitacoras', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('siembra_id');
                }
            });
        }

        // alertas
        if (Schema::hasTable('alertas')) {
            Schema::table('alertas', function (Blueprint $table) {
                if (!Schema::hasColumn('alertas', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('siembra_id');
                }
            });
        }
        if (Schema::hasTable('Cosechas')) {
            Schema::table('Cosechas', function (Blueprint $table) {
                if (!Schema::hasColumn('Cosechas', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cultivos')) {
            Schema::table('cultivos', function (Blueprint $table) {
                if (Schema::hasColumn('cultivos', 'user_id')) {
                    $table->dropConstrainedForeignId('user_id');
                }
            });
        }

        if (Schema::hasTable('variables_ambientales')) {
            Schema::table('variables_ambientales', function (Blueprint $table) {
                if (Schema::hasColumn('variables_ambientales', 'user_id')) {
                    $table->dropConstrainedForeignId('user_id');
                }
            });
        }

        if (Schema::hasTable('bitacoras')) {
            Schema::table('bitacoras', function (Blueprint $table) {
                if (Schema::hasColumn('bitacoras', 'user_id')) {
                    $table->dropConstrainedForeignId('user_id');
                }
            });
        }

        if (Schema::hasTable('alertas')) {
            Schema::table('alertas', function (Blueprint $table) {
                if (Schema::hasColumn('alertas', 'user_id')) {
                    $table->dropConstrainedForeignId('user_id');
                }
            });
        }
        if (Schema::hasTable('Cosechas')) {
            Schema::table('Cosechas', function (Blueprint $table) {
                if (Schema::hasColumn('Cosechas', 'user_id')) {
                    $table->dropConstrainedForeignId('user_id');
                }
            });
        }
    }
};
