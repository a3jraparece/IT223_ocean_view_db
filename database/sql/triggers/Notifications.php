<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_notification;

    CREATE TRIGGER after_insert_notification
    AFTER INSERT ON notifications
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "notifications",
            NEW.id,
            "INSERT",
            CONCAT("Notification for user_id ", NEW.user_id, " was added with message: ", NEW.message),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_notification;

    CREATE TRIGGER after_update_notification
    AFTER UPDATE ON notifications
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.status <=> NEW.status THEN
            SET msg = CONCAT(msg, "status changed from \'", OLD.status, "\' to \'", NEW.status, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "notifications",
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
    DROP TRIGGER IF EXISTS after_delete_notification;

    CREATE TRIGGER after_delete_notification
    AFTER DELETE ON notifications
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "notifications",
            OLD.id,
            "DELETE",
            CONCAT("Notification with ID ", OLD.id, " for user_id ", OLD.user_id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};
