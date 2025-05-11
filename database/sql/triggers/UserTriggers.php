<?php

// use Illuminate\Support\Facades\DB;

// return function () {

//     DB::unprepared('
//     DROP TRIGGER IF EXISTS after_user_insert;

//             CREATE TRIGGER after_user_insert
//             AFTER INSERT ON users
//             FOR EACH ROW
//             BEGIN
//                 INSERT INTO trigger_logs (`table`,`affected_id` ,`action`, `message`, `created_at`, `updated_at`)
//                 VALUES (
//                     "users",
//                     NEW.id,
//                     "INSERT",
//                     CONCAT("A new user has been inserted with ID = ", NEW.id),
//                     NOW(),
//                     NOW()
//                 );
//             END
//     ');

    



//     // Deri ipang butang other triggers pud sa baba
// };

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_user;

    CREATE TRIGGER after_insert_user
    AFTER INSERT ON users
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "users",
            NEW.id,
            "INSERT",
            CONCAT("User ", NEW.username, " was added with ID ", NEW.id),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_user;

    CREATE TRIGGER after_update_user
    AFTER UPDATE ON users
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.username <=> NEW.username THEN
            SET msg = CONCAT(msg, "username changed from \'", OLD.username, "\' to \'", NEW.username, "\'; ");
        END IF;
        IF NOT OLD.email <=> NEW.email THEN
            SET msg = CONCAT(msg, "email changed from \'", OLD.email, "\' to \'", NEW.email, "\'; ");
        END IF;
        IF NOT OLD.email_verified_at <=> NEW.email_verified_at THEN
            SET msg = CONCAT(msg, "email_verified_at changed; ");
        END IF;
        IF NOT OLD.password <=> NEW.password THEN
            SET msg = CONCAT(msg, "password was updated; ");
        END IF;
        IF NOT OLD.profile_photo <=> NEW.profile_photo THEN
            SET msg = CONCAT(msg, "profile_photo changed; ");
        END IF;
        IF NOT OLD.status <=> NEW.status THEN
            SET msg = CONCAT(msg, "status changed from \'", OLD.status, "\' to \'", NEW.status, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "users",
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
    DROP TRIGGER IF EXISTS after_delete_user;

    CREATE TRIGGER after_delete_user
    AFTER DELETE ON users
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "users",
            OLD.id,
            "DELETE",
            CONCAT("User ", OLD.username, " with ID ", OLD.id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};

