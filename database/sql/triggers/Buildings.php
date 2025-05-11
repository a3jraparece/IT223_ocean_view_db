<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_building;

    CREATE TRIGGER after_insert_building
    AFTER INSERT ON buildings
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "buildings",
            NEW.id,
            "INSERT",
            CONCAT("Building ", NEW.name, " was added with ID ", NEW.id),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_building;

    CREATE TRIGGER after_update_building
    AFTER UPDATE ON buildings
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.name <=> NEW.name THEN
            SET msg = CONCAT(msg, "name changed from \'", OLD.name, "\' to \'", NEW.name, "\'; ");
        END IF;
        IF NOT OLD.image <=> NEW.image THEN
            SET msg = CONCAT(msg, "image changed; ");
        END IF;
        IF NOT OLD.floor_count <=> NEW.floor_count THEN
            SET msg = CONCAT(msg, "floor_count changed from \'", OLD.floor_count, "\' to \'", NEW.floor_count, "\'; ");
        END IF;
        IF NOT OLD.room_per_floor <=> NEW.room_per_floor THEN
            SET msg = CONCAT(msg, "room_per_floor changed from \'", OLD.room_per_floor, "\' to \'", NEW.room_per_floor, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "buildings",
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
    DROP TRIGGER IF EXISTS after_delete_building;

    CREATE TRIGGER after_delete_building
    AFTER DELETE ON buildings
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "buildings",
            OLD.id,
            "DELETE",
            CONCAT("Building ", OLD.name, " with ID ", OLD.id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};
