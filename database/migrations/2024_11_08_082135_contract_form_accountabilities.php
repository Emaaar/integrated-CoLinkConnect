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
        //MARK: a
        //slide 5 part 1
        Schema::create('need_assessment_and_analysis', function (Blueprint $table) {
            // Foreign keys
            $table->unsignedBigInteger('contract_num')->nullable();
            $table->integer('need_assessment_costing')->nullable();
            $table->string('need_assessment_partner')->nullable();
            $table->string('need_assessment_colinkIC')->nullable();
            $table->date('need_assessment_timeline')->nullable();

            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: b
        //slide 5 part 1
        Schema::create('trainig_design_and_implementation', function (Blueprint $table) {
            // Foreign keys
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('trainig_design_and_implementation_costing')->nullable();
            $table->string('trainig_design_and_implementation_partner')->nullable();
            $table->string('trainig_design_and_implementation_colinkIC')->nullable();
            $table->date('trainig_design_and_implementation_timeline')->nullable();

            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: c
        //slide 5 part 1
        Schema::create('number_of_facilitators', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('number_of_facilitators_costing')->nullable();
            $table->string('number_of_facilitators_partner')->nullable();
            $table->string('number_of_facilitators_colinkIC')->nullable();
            $table->date('number_of_facilitators_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: d
        //slide 5 part 1
        Schema::create('conduct_of_orientation', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('conduct_of_orientation_costing')->nullable();
            $table->string('conduct_of_orientation_partner')->nullable();
            $table->string('conduct_of_orientation_colinkIC')->nullable();
            $table->date('conduct_of_orientation_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: e
        //slide 5 part 1
        Schema::create('coordination_of_materials', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('coordination_of_materials_costing')->nullable();
            $table->string('coordination_of_materials_partner')->nullable();
            $table->string('coordination_of_materials_colinkIC')->nullable();
            $table->date('coordination_of_materials_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: f
        //slide 5 part 2
        Schema::create('secretariat', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('secretariat_costing')->nullable();
            $table->string('secretariat_partner')->nullable();
            $table->string('secretariat_colinkIC')->nullable();
            $table->date('secretariat_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: g
        //slide 5 part 2
        Schema::create('id', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('id_costing')->nullable();
            $table->string('id_partner')->nullable();
            $table->string('id_colinkIC')->nullable();
            $table->date('id_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: h
        //slide 5 part 2
        Schema::create('parents_consent', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('parents_consent_costing')->nullable();
            $table->string('parents_consent_partner')->nullable();
            $table->string('parents_consent_colinkIC')->nullable();
            $table->date('parents_consent_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: i
        //slide 5 part 2
        Schema::create('designing_of_poster', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('designing_of_poster_costing')->nullable();
            $table->string('designing_of_poster_partner')->nullable();
            $table->string('designing_of_poster_colinkIC')->nullable();
            $table->date('designing_of_poster_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: j
        //slide 5 part 2
        Schema::create('tshirt_printing', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('tshirt_printing_costing')->nullable();
            $table->string('tshirt_printing_partner')->nullable();
            $table->string('tshirt_printing_colinkIC')->nullable();
            $table->date('tshirt_printing_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: k
        //slide 5 part 3
        Schema::create('banner_printing', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('banner_printing_costing')->nullable();
            $table->string('banner_printing_partner')->nullable();
            $table->string('banner_printing_colinkIC')->nullable();
            $table->date('banner_printing_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: l
        //slide 5 part 3
        Schema::create('coordination_for_venue', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('coordination_for_venue_costing')->nullable();
            $table->string('coordination_for_venue_partner')->nullable();
            $table->string('coordination_for_venue_colinkIC')->nullable();
            $table->date('coordination_for_venue_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: m
        //slide 5 part 3
        Schema::create('coordination_with_participants', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('coordination_with_participants_costing')->nullable();
            $table->string('coordination_with_participants_partner')->nullable();
            $table->string('coordination_with_participants_colinkIC')->nullable();
            $table->date('coordination_with_participants_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: n
        //slide 5 part 3
        Schema::create('coordination_with_food', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('coordination_with_food_costing')->nullable();
            $table->string('coordination_with_food_partner')->nullable();
            $table->string('coordination_with_food_colinkIC')->nullable();
            $table->date('coordination_with_food_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: o
        //slide 5 part 3
        Schema::create('coordination_with_speakers', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('coordination_with_speakers_costing')->nullable();
            $table->string('coordination_with_speakers_partner')->nullable();
            $table->string('coordination_with_speakers_colinkIC')->nullable();
            $table->date('coordination_with_speakers_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: p
        //slide 5 part 4
        Schema::create('supporting_docs_coordination', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('supporting_docs_coordination_costing')->nullable();
            $table->string('supporting_docs_coordination_partner')->nullable();
            $table->string('supporting_docs_coordination_colinkIC')->nullable();
            $table->date('supporting_docs_coordination_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: q
        //slide 5 part 4
        Schema::create('insurance', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('insurance_costing')->nullable();
            $table->string('insurance_partner')->nullable();
            $table->string('insurance_colinkIC')->nullable();
            $table->date('insurance_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: r
        //slide 5 part 4
        Schema::create('venue_recce', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('venue_recce_costing')->nullable();
            $table->string('venue_recce_partner')->nullable();
            $table->string('venue_recce_colinkIC')->nullable();
            $table->date('venue_recce_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: s
        //slide 5 part 4
        Schema::create('documentation', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('documentation_costing')->nullable();
            $table->string('documentation_partner')->nullable();
            $table->string('documentation_colinkIC')->nullable();
            $table->date('documentation_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });

        //MARK: t
        //slide 5 part 4
        Schema::create('video_teaser', function (Blueprint $table) {
            // Foreign key
            $table->unsignedBigInteger('contract_num')->nullable(); // Foreign key (from partners_information table)

            $table->integer('video_teaser_costing')->nullable();
            $table->string('video_teaser_partner')->nullable();
            $table->string('video_teaser_colinkIC')->nullable();
            $table->date('video_teaser_timeline')->nullable();


            // Add the foreign key constraints
            $table->foreign('contract_num')->references('contract_num')->on('partners_information')->onDelete('set null');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_teaser', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('documentation', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('venue_recce', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('insurance', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('supporting_docs_coordination', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('coordination_with_speakers', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('coordination_with_food', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('coordination_with_participants', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('coordination_for_venue', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('banner_printing', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('tshirt_printing', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('designing_of_poster', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('parents_consent', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('id', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('secretariat', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('coordination_of_materials', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('conduct_of_orientation', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('number_of_facilitators', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('trainig_design_and_implementation', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });
        Schema::table('need_assessment_and_analysis', function (Blueprint $table) {
            $table->dropForeign(['contract_num']);
        });

        Schema::dropIfExists('video_teaser');
        Schema::dropIfExists('documentation');
        Schema::dropIfExists('venue_recce');
        Schema::dropIfExists('insurance');
        Schema::dropIfExists('supporting_docs_coordination');
        Schema::dropIfExists('coordination_with_speakers');
        Schema::dropIfExists('coordination_with_food');
        Schema::dropIfExists('coordination_with_participants');
        Schema::dropIfExists('coordination_for_venue');
        Schema::dropIfExists('banner_printing');
        Schema::dropIfExists('tshirt_printing');
        Schema::dropIfExists('designing_of_poster');
        Schema::dropIfExists('parents_consent');
        Schema::dropIfExists('id');
        Schema::dropIfExists('secretariat');
        Schema::dropIfExists('coordination_of_materials');
        Schema::dropIfExists('conduct_of_orientation');
        Schema::dropIfExists('number_of_facilitators');
        Schema::dropIfExists('trainig_design_and_implementation');
        Schema::dropIfExists('need_assessment_and_analysis');
    }
};
