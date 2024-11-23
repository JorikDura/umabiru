<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->index();
            $table->morphs('imageable');
            $table->string('original_path');
            $table->string('preview_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
