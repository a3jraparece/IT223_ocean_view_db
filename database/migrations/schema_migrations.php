<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('resorts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('location');
            $table->text('location_coordinates');
            $table->decimal('tax_rate', 5, 2);
            $table->enum('status', ['active', 'deactivated'])->default('active');
            $table->text('contact_details')->unique()->nullable();
            $table->text('main_image')->nullable();
            $table->text('image1')->nullable();
            $table->text('image1_2')->nullable();
            $table->text('image1_3')->nullable();
            $table->text('image2')->nullable();
            $table->text('image3')->nullable();
            $table->text('resort_description')->nullable();
            $table->text('room_image_1')->nullable();
            $table->text('room_image_2')->nullable();
            $table->text('room_image_3')->nullable();
            $table->text('room_description')->nullable();
            $table->timestamps();
        });

        Schema::create('resort_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resort_id')->constrained('resorts')->onDelete('cascade');
            $table->text('name');
            $table->string('image')->nullable();
            $table->decimal('discount_rate', 3, 2);
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resort_id')->constrained('resorts')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->integer('floor_count');
            $table->integer('room_per_floor');
            $table->timestamps();
        });

        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('capacity');
            $table->decimal('base_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained('buildings')->onDelete('cascade');
            $table->foreignId('resort_id')->constrained('resorts')->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained('room_types');
            $table->string('room_name')->nullable();
            $table->string('room_image')->nullable();
            $table->string('description')->nullable();
            $table->string('inclusions', 2000)->nullable();
            $table->string('amenities', 2000)->nullable();
            $table->decimal('price_per_night', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table
                ->enum("role", [
                    "super_admin",
                    "resort_super_admin",
                    "resort_admin",
                    "guest",
                ])
                ->default("guest")
                ->unique();
            $table->text("description")->nullable();
            $table->timestamps();
        });

        // Schema::create('permissions', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->unique();
        //     $table->string('description')->unique();
        //     $table->timestamps();
        // });

        // Schema::create('role_permission', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
        //     $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
        //     $table->timestamps();
        // });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("password");
            $table->string("profile_photo")->nullable();
            $table
                ->enum("status", ["active", "deactivated"])
                ->default("active");
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId("resort_id")->nullable()->constrained("resorts")->onDelete("cascade");
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->decimal('sub-total', 8, 2)->nullable();
            $table->decimal('total_amount', 8, 2);
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled', 'Completed',])->default('Pending');
            $table->timestamps();
        });

        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->decimal('price_per_night', 10, 2);
            $table->integer('nights');
            $table->decimal('room_subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('final_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('payment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->string("screenshot_path", 255);
            $table->decimal("amount_paid", 5, 2);
            $table->string('reference_number');
            $table->enum("status", ["pending", "approved", "rejected"])->default("pending");
            $table->foreignId("reviewed_by")->nullable()
                ->constrained("users")
                ->onDelete("cascade");
            $table->timestamp("reviewed_at")->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->enum('payment_method', ["Cash", "ECash", "GCash"])->default('Cash');
            $table->decimal('amount_paid', 10, 2);
            $table->foreignId("received_by")->nullable()->constrained("users");
            $table->foreignId("payment_submission_id")
                ->nullable()
                ->constrained("payment_submissions")
                ->onDelete("cascade"); //if gcash gikan null lang if actual paymenyt
            $table->timestamps();
        });

        Schema::create("notifications", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->text("message");
            $table->enum("status", ["unread", "read"])->default("unread");
            $table->timestamps();
        });

        Schema::create("amenities_category", callback: function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->string("description");
            $table->timestamps();
        });

        Schema::create("resort_amenities", function (Blueprint $table) {
            $table->id();
            $table->foreignId("resort_id")->constrained('resorts')->onDelete("cascade");
            $table->foreignId("amenity_category_id")->constrained('amenities_category')->onDelete("cascade");
            $table->text('amenity');
            $table->timestamps();
        });

        Schema::create("bookmarks", function (Blueprint $table) {
            $table->id();
            $table->foreignId("resort_id")->constrained('resorts')->onDelete("cascade");
            $table->foreignId("user_id")->constrained('users')->onDelete("cascade");
            $table->timestamps();
        });

        Schema::create("reviews", function (Blueprint $table) {
            $table->id();
            $table->foreignId("resort_id")->constrained('resorts')->onDelete("cascade");
            $table->foreignId("user_id")->constrained('users')->onDelete("cascade");
            $table->enum('ratings', [1, 2, 3, 4, 5]);
            $table->string('comments', 500);
            $table->timestamps();
        });

        Schema::create("trigger_logs", function (Blueprint $table) {
            $table->id();
            $table->text('table');
            $table->unsignedBigInteger('affected_id')->nullable();
            $table->text('action');
            $table->text('message');
            $table->foreignId('triggered_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create("guest_details", function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            $table->string('first_name', 50)->nullable();
            $table->string('middle_name', 50)->nullable();
            $table->string('sur_name', 50)->nullable();
            $table->string('suffix', 10)->nullable();

            $table->string('region', 50)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('city', 100)->nullable();

            $table->string('phone_number', 15)->nullable();
            $table->boolean('status')->default(false);

            $table->timestamps();
        });

        Schema::create('logged_in_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('logged_in_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
