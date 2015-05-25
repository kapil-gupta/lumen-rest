<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'users', function ($table) {
			$table->increments ( 'id' );
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique();
			$table->string('password');
			$table->date('birthdate');
			$table->string('contact',20);
			$table->text('biography');
			$table->string('address1');
			$table->string('address2');
			$table->timestamps();
			$table->rememberToken();
			$table->softDeletes();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users');
	}
}
