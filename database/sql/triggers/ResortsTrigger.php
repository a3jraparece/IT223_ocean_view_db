<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_resort;

    CREATE TRIGGER after_insert_resort
    AFTER INSERT ON resorts
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `action`, `message`, `triggered_by`)
        VALUES (
            "resorts",
            "INSERT",
            CONCAT("Resort ", NEW.name, " was added with ID ", NEW.id),
            @user_id
        );
    END
    ');

    // Deri ipang butang other triggers pud sa baba
};
