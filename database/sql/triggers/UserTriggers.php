<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_user_insert;

            CREATE TRIGGER after_user_insert
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                INSERT INTO trigger_logs (`table`, `action`, `message`, `created_at`, `updated_at`)
                VALUES (
                    "users",
                    "INSERT",
                    CONCAT("A new user has been inserted with ID = ", NEW.id),
                    NOW(),
                    NOW()
                );
            END
    ');

    



    // Deri ipang butang other triggers pud sa baba
};
