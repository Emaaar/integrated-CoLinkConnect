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
        // MARK: I
        // partners_information
        Schema::create('partners_information', function (Blueprint $table) {
            $table->bigIncrements('contract_num'); // Primary key

            $table->timestamp('date_recorded');

            $table->longText('org_name');
            $table->string('category');

            $table->string('orghd_name');
            $table->string('orghead_designation');
            $table->string('orghead_contact', 20);

            $table->string('coor_name');
            $table->string('coor_desig');
            $table->string('coor_contact', 20);

            // Foreign keys
            $table->unsignedBigInteger('client_id')->nullable(); // Foreign key (from user table)
            $table->unsignedBigInteger('admin_id')->nullable();  // Foreign key (from admin table)

            // Add the foreign key constraints
            $table->foreign('client_id')->references('client_id')->on('users')->onDelete('set null');
            $table->foreign('admin_id')->references('admin_id')->on('admin')->onDelete('set null');
        });

        // MARK: II
        // participants
        Schema::create('participants', function (Blueprint $table) {
            $table->bigIncrements('background_num'); // Primary key
            $table->integer('age');
            $table->string('gender');
            $table->string('education_status');
            $table->string('leadership_exp');
            $table->longText('address');

            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            // Add the foreign key constraint with a custom name
            $table->foreign('contract_num', 'fk_participants_contract_num')
                  ->references('contract_num')
                  ->on('partners_information')
                  ->onDelete('set null');
        });

        // MARK: III
        // intervention_assessment
        Schema::create('intervention_assessment', function (Blueprint $table) {
            $table->bigIncrements('intervention_num'); // Primary key
            $table->longText('pic_success')->nullable();
            $table->longText('kgap')->nullable();
            $table->longText('sgap')->nullable();
            $table->longText('tdgap')->nullable();
            $table->longText('issues_concerns')->nullable();

            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable();  // Foreign key (from partners_information table)

            // Add the foreign key constraint with a custom name
            $table->foreign('contract_num', 'fk_intervention_assessment_contract_num')
                  ->references('contract_num')
                  ->on('partners_information')
                  ->onDelete('set null');
        });

        // MARK: IV
        // proposed_intervention
        Schema::create('proposed_intervention', function (Blueprint $table) {
            $table->bigIncrements('intervention_num'); // Primary key
            $table->string('type_intervention');
            $table->longText('venue')->nullable();
            $table->string('startdate');
            $table->string('enddate');
            $table->integer('days');
            $table->integer('duration');
            $table->longText('objectives');
            $table->longText('output')->nullable();

            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            // Add the foreign key constraint with a custom name
            $table->foreign('contract_num', 'fk_proposed_intervention_contract_num')
                  ->references('contract_num')
                  ->on('partners_information')
                  ->onDelete('set null');
        });

        // MARK: VI
        // people_involve
        Schema::create('people_involve', function (Blueprint $table) {
            $table->bigIncrements('involve_id'); // Primary key
            $table->string('leadfaci');
            $table->string('secondfaci');
            $table->string('thirdfaci');
            $table->string('sponsor')->nullable();
            $table->string('vip')->nullable();
            $table->string('working_com')->nullable();
            $table->string('observers')->nullable();

            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            // Add the foreign key constraint with a custom name
            $table->foreign('contract_num', 'fk_people_involve_contract_num')
                  ->references('contract_num')
                  ->on('partners_information')
                  ->onDelete('set null');
        });

        // MARK: VII
        // services_offered
        Schema::create('services_offered', function (Blueprint $table) {
            $table->bigIncrements('transaction_id'); // Primary key
            $table->string('name_service')->nullable();
            $table->integer('cost');
            $table->string('incharge');
            $table->timestamp('dateordered')->nullable();
            $table->timestamp('datecomplete')->nullable();

            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            // Add the foreign key constraint with a custom name
            $table->foreign('contract_num', 'fk_services_offered_contract_num')
                  ->references('contract_num')
                  ->on('partners_information')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services_offered', function (Blueprint $table) {
            $table->dropForeign('fk_services_offered_contract_num'); // Correct name here
        });

        Schema::table('people_involve', function (Blueprint $table) {
            $table->dropForeign('fk_people_involve_contract_num'); // Correct name here
        });

        Schema::table('proposed_intervention', function (Blueprint $table) {
            $table->dropForeign('fk_proposed_intervention_contract_num'); // Correct name here
        });

        Schema::table('intervention_assessment', function (Blueprint $table) {
            $table->dropForeign('fk_intervention_assessment_contract_num'); // Correct name here
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign('fk_participants_contract_num'); // Correct name here
        });

        Schema::table('partners_information', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['admin_id']);
        });

        Schema::dropIfExists('services_offered');
        Schema::dropIfExists('people_involve');
        Schema::dropIfExists('proposed_intervention');
        Schema::dropIfExists('intervention_assessment');
        Schema::dropIfExists('participants');
        Schema::dropIfExists('partners_information');
    }
};
