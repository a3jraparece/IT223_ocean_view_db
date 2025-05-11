<?php

use Illuminate\Support\Facades\DB;

return function () {

    // DB::unprepared('
    // DROP TRIGGER IF EXISTS after_insert_amenities_category;

    // CREATE TRIGGER after_insert_amenities_category
    // AFTER INSERT ON amenities_category
    // FOR EACH ROW
    // BEGIN
    //     INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
    //     VALUES (
    //         "amenities_category",
    //         NEW.id,
    //         "INSERT",
    //         CONCAT("Amenity category ", NEW.name, " was added with ID ", NEW.id),
    //         @user_id,
    //         NOW(),
    //         NOW()
    //     );
    // END
    // ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_amenities_category;

    CREATE TRIGGER after_update_amenities_category
    AFTER UPDATE ON amenities_category
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.name <=> NEW.name THEN
            SET msg = CONCAT(msg, "name changed from \'", OLD.name, "\' to \'", NEW.name, "\'; ");
        END IF;
        IF NOT OLD.description <=> NEW.description THEN
            SET msg = CONCAT(msg, "description changed; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "amenities_category",
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
    DROP TRIGGER IF EXISTS after_delete_amenities_category;

    CREATE TRIGGER after_delete_amenities_category
    AFTER DELETE ON amenities_category
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "amenities_category",
            OLD.id,
            "DELETE",
            CONCAT("Amenity category ", OLD.name, " with ID ", OLD.id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

};
