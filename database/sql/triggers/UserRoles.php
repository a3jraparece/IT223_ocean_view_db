<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_user_role;

    CREATE TRIGGER after_insert_user_role
    AFTER INSERT ON user_roles
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "user_roles",
            NEW.id,
            "INSERT",
            CONCAT("User Role added for user_id ", NEW.user_id, ", role_id ", NEW.role_id, IFNULL(CONCAT(", resort_id ", NEW.resort_id), "")),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_user_role;

    CREATE TRIGGER after_update_user_role
    AFTER UPDATE ON user_roles
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.user_id <=> NEW.user_id THEN
            SET msg = CONCAT(msg, "user_id changed from \'", OLD.user_id, "\' to \'", NEW.user_id, "\'; ");
        END IF;
        IF NOT OLD.role_id <=> NEW.role_id THEN
            SET msg = CONCAT(msg, "role_id changed from \'", OLD.role_id, "\' to \'", NEW.role_id, "\'; ");
        END IF;
        IF NOT OLD.resort_id <=> NEW.resort_id THEN
            SET msg = CONCAT(msg, "resort_id changed from \'", OLD.resort_id, "\' to \'", NEW.resort_id, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "user_roles",
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
    DROP TRIGGER IF EXISTS after_delete_user_role;

    CREATE TRIGGER after_delete_user_role
    AFTER DELETE ON user_roles
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "user_roles",
            OLD.id,
            "DELETE",
            CONCAT("User Role with ID ", OLD.id, " for user_id ", OLD.user_id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};
