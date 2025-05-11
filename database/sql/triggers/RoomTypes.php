<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_room_type;

    CREATE TRIGGER after_insert_room_type
    AFTER INSERT ON room_types
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "room_types",
            NEW.id,
            "INSERT",
            CONCAT("Room type ", NEW.name, " was added with ID ", NEW.id),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_room_type;

    CREATE TRIGGER after_update_room_type
    AFTER UPDATE ON room_types
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.name <=> NEW.name THEN
            SET msg = CONCAT(msg, "name changed from \'", OLD.name, "\' to \'", NEW.name, "\'; ");
        END IF;
        IF NOT OLD.description <=> NEW.description THEN
            SET msg = CONCAT(msg, "description changed; ");
        END IF;
        IF NOT OLD.capacity <=> NEW.capacity THEN
            SET msg = CONCAT(msg, "capacity changed from \'", OLD.capacity, "\' to \'", NEW.capacity, "\'; ");
        END IF;
        IF NOT OLD.base_price <=> NEW.base_price THEN
            SET msg = CONCAT(msg, "base_price changed from \'", OLD.base_price, "\' to \'", NEW.base_price, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "room_types",
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
    DROP TRIGGER IF EXISTS after_delete_room_type;

    CREATE TRIGGER after_delete_room_type
    AFTER DELETE ON room_types
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "room_types",
            OLD.id,
            "DELETE",
            CONCAT("Room type ", OLD.name, " with ID ", OLD.id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};
