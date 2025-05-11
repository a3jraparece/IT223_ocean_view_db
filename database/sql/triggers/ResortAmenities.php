<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_resort_amenities;

    CREATE TRIGGER after_insert_resort_amenities
    AFTER INSERT ON resort_amenities
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "resort_amenities",
            NEW.id,
            "INSERT",
            CONCAT("Amenity ", NEW.amenity, " was added to resort with ID ", NEW.resort_id),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_resort_amenities;

    CREATE TRIGGER after_update_resort_amenities
    AFTER UPDATE ON resort_amenities
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.amenity <=> NEW.amenity THEN
            SET msg = CONCAT(msg, "amenity changed from \'", OLD.amenity, "\' to \'", NEW.amenity, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "resort_amenities",
                NEW.id,
                "UPDATE",
                msg,
                @user_id,
                NOW(),
                NOW()
            );
        END IF;
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_delete_resort_amenities;

    CREATE TRIGGER after_delete_resort_amenities
    AFTER DELETE ON resort_amenities
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "resort_amenities",
            OLD.id,
            "DELETE",
            CONCAT("Amenity ", OLD.amenity, " in resort with ID ", OLD.resort_id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

};
