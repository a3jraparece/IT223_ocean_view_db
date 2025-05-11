<?php

use Illuminate\Support\Facades\DB;

return function () {

    // DB::unprepared('
    // DROP TRIGGER IF EXISTS after_insert_review;

    // CREATE TRIGGER after_insert_review
    // AFTER INSERT ON reviews
    // FOR EACH ROW
    // BEGIN
    //     INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
    //     VALUES (
    //         "reviews",
    //         NEW.id,
    //         "INSERT",
    //         CONCAT("Review for resort ID ", NEW.resort_id, " by user with ID ", NEW.user_id, " was added with rating ", NEW.ratings),
    //         @user_id,
    //         NOW(),
    //         NOW()
    //     );
    // END
    // ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_review;

    CREATE TRIGGER after_update_review
    AFTER UPDATE ON reviews
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.ratings <=> NEW.ratings THEN
            SET msg = CONCAT(msg, "rating changed from \'", OLD.ratings, "\' to \'", NEW.ratings, "\'; ");
        END IF;

        IF NOT OLD.comments <=> NEW.comments THEN
            SET msg = CONCAT(msg, "comments changed; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "reviews",
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
    DROP TRIGGER IF EXISTS after_delete_review;

    CREATE TRIGGER after_delete_review
    AFTER DELETE ON reviews
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "reviews",
            OLD.id,
            "DELETE",
            CONCAT("Review for resort ID ", OLD.resort_id, " by user with ID ", OLD.user_id, " was deleted"),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

};
