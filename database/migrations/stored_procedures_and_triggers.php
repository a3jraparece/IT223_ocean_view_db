<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
        $this->runSqlFiles(database_path('sql/procedures'));
        $this->runSqlFiles(database_path('sql/triggers'));
    }

    public function down(): void
    {
        // You can manually or dynamically call DROP PROCEDURE/TRIGGER here
    }

    private function runSqlFiles(string $folderPath): void
    {
        if (!File::exists($folderPath)) {
            return;
        }

        $phpFiles = File::allFiles($folderPath);

        foreach ($phpFiles as $file) {
            $callable = require $file->getPathname();
            if (is_callable($callable)) {
                $callable();
            }
        }
    }
};
