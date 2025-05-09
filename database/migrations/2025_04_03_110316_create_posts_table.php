<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('cascade');
            $table->string('post_title');
            $table->string('post_subtitle')->nullable();
            $table->string('post_slug')->unique();
            $table->text('content');
            // $table->text('post_excerpt')->nullable();
            $table->string('post_photo');
            $table->string('photo_caption')->nullable();
            $table->integer('visitors')->default(0);
            $table->foreignId('author_id')->nullable();
            $table->foreignId('admin_id')->nullable();
            $table->foreignId('editor_id')->nullable();

            // SEO Fields
            $table->string('meta_description', 160)->nullable();
            // $table->string('focus_keywords')->nullable();
            $table->string('schema_type')->default('NewsArticle');

            // Post Options
            $table->boolean('is_share')->default(false);
            $table->boolean('is_comment')->default(false);
            $table->boolean('is_featured')->default(false);

            // Language and Status
            $table->foreignId('language_id');
            $table->enum('status', ['published', 'draft', 'pending'])->default('pending');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
