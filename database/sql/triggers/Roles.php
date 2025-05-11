<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_role;

    CREATE TRIGGER after_insert_role
    AFTER INSERT ON roles
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "roles",
            NEW.id,
            "INSERT",
            CONCAT("Role ", NEW.role, " was added with ID ", NEW.id),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_role;

    CREATE TRIGGER after_update_role
    AFTER UPDATE ON roles
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.role <=> NEW.role THEN
            SET msg = CONCAT(msg, "role changed from \'", OLD.role, "\' to \'", NEW.role, "\'; ");
        END IF;
        IF NOT OLD.description <=> NEW.description THEN
            SET msg = CONCAT(msg, "description changed; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "roles",
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
    DROP TRIGGER IF EXISTS after_delete_role;

    CREATE TRIGGER after_delete_role
    AFTER DELETE ON roles
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "roles",
            OLD.id,
            "DELETE",
            CONCAT("Role ", OLD.role, " with ID ", OLD.id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};
