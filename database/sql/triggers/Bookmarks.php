<?php

use Illuminate\Support\Facades\DB;

return function () {

    // DB::unprepared('
    // DROP TRIGGER IF EXISTS after_insert_bookmark;

    // CREATE TRIGGER after_insert_bookmark
    // AFTER INSERT ON bookmarks
    // FOR EACH ROW
    // BEGIN
    //     INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
    //     VALUES (
    //         "bookmarks",
    //         NEW.id,
    //         "INSERT",
    //         CONCAT("Bookmark for resort ID ", NEW.resort_id, " was added by user with ID ", NEW.user_id),
    //         @user_id,
    //         NOW(),
    //         NOW()
    //     );
    // END
    // ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_bookmark;

    CREATE TRIGGER after_update_bookmark
    AFTER UPDATE ON bookmarks
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.resort_id <=> NEW.resort_id THEN
            SET msg = CONCAT(msg, "resort_id changed from \'", OLD.resort_id, "\' to \'", NEW.resort_id, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "bookmarks",
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
    DROP TRIGGER IF EXISTS after_delete_bookmark;

    CREATE TRIGGER after_delete_bookmark
    AFTER DELETE ON bookmarks
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "bookmarks",
            OLD.id,
            "DELETE",
            CONCAT("Bookmark for resort ID ", OLD.resort_id, " was deleted by user with ID ", OLD.user_id),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

};
