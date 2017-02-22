<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaratrustUpgradeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('{{ $laratrust['role_user_table'] }}', function (Blueprint $table) {
           // Drop user foreign key and primary with role_id
            $table->dropForeign('{{ $laratrust['role_user_table'] }}_{{ $laratrust['user_foreign_key'] }}_foreign');
            $table->dropPrimary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['role_foreign_key'] }}']);

            $table->string('user_type');
            $table->primary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['role_foreign_key'] }}', 'user_type']);
        });

        Schema::table('{{ $laratrust['permission_user_table'] }}', function (Blueprint $table) {
           // Drop user foreign key and primary with permission_id
            $table->dropForeign('{{ $laratrust['permission_user_table'] }}_{{ $laratrust['user_foreign_key'] }}_foreign');
            $table->dropPrimary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['permission_foreign_key'] }}']);

            $table->string('user_type');
            $table->primary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['permission_foreign_key'] }}', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('{{ $laratrust['role_user_table'] }}', function (Blueprint $table) {
            $table->dropPrimary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['role_foreign_key'] }}', 'user_type']);
            $table->dropColumn('user_type');

            $table->foreign('{{ $laratrust['user_foreign_key'] }}')->references('{{ $user->getKeyName() }}')->on('{{ $user->getTable() }}')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['role_foreign_key'] }}']);
        });

        Schema::table('{{ $laratrust['permission_user_table'] }}', function (Blueprint $table) {
            $table->dropPrimary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['permission_foreign_key'] }}', 'user_type']);
            $table->dropColumn('user_type');

            $table->foreign('{{ $laratrust['user_foreign_key'] }}')->references('{{ $user->getKeyName() }}')->on('{{ $user->getTable() }}')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['{{ $laratrust['user_foreign_key'] }}', '{{ $laratrust['permission_foreign_key'] }}']);
        });
    }
}
