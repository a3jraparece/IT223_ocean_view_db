<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_resort_event;

    CREATE TRIGGER after_insert_resort_event
    AFTER INSERT ON resort_events
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "resort_events",
            NEW.id,
            "INSERT",
            CONCAT("Resort Event ", NEW.name, " was added with ID ", NEW.id),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_resort_event;

    CREATE TRIGGER after_update_resort_event
    AFTER UPDATE ON resort_events
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.name <=> NEW.name THEN
            SET msg = CONCAT(msg, "name changed from \'", OLD.name, "\' to \'", NEW.name, "\'; ");
        END IF;
        IF NOT OLD.discount_rate <=> NEW.discount_rate THEN
            SET msg = CONCAT(msg, "discount_rate changed from \'", OLD.discount_rate, "\' to \'", NEW.discount_rate, "\'; ");
        END IF;
        IF NOT OLD.description <=> NEW.description THEN
            SET msg = CONCAT(msg, "description changed; ");
        END IF;
        IF NOT OLD.start_date <=> NEW.start_date THEN
            SET msg = CONCAT(msg, "start_date changed from \'", OLD.start_date, "\' to \'", NEW.start_date, "\'; ");
        END IF;
        IF NOT OLD.end_date <=> NEW.end_date THEN
            SET msg = CONCAT(msg, "end_date changed from \'", OLD.end_date, "\' to \'", NEW.end_date, "\'; ");
        END IF;
        IF NOT OLD.image <=> NEW.image THEN
            SET msg = CONCAT(msg, "image changed; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "resort_events",
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
    DROP TRIGGER IF EXISTS after_delete_resort_event;

    CREATE TRIGGER after_delete_resort_event
    AFTER DELETE ON resort_events
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "resort_events",
            OLD.id,
            "DELETE",
            CONCAT("Resort Event ", OLD.name, " with ID ", OLD.id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};
