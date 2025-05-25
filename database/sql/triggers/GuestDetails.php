<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_guest_details;
    
        IF @user_id IS NULL THEN
            SET @user_id = 1;  -- Default user ID (you can choose a default user ID here)
        END IF;

    CREATE TRIGGER after_insert_guest_details
    AFTER INSERT ON guest_details
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "guest_details",
            NEW.id,
            "INSERT",
            COALESCE(CONCAT("Guest details for user ID ", NEW.user_id, " were added with first name ", NEW.first_name), "Default message: Guest details added"),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_guest_details;

    CREATE TRIGGER after_update_guest_details
    AFTER UPDATE ON guest_details
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF @user_id IS NULL THEN
    SET @user_id = 1;  -- Default user ID (you can choose a default user ID here)
    END IF;

        IF NOT OLD.first_name <=> NEW.first_name THEN
            SET msg = CONCAT(msg, "first name changed from \'", OLD.first_name, "\' to \'", NEW.first_name, "\'; ");
        END IF;

        IF NOT OLD.middle_name <=> NEW.middle_name THEN
            SET msg = CONCAT(msg, "middle name changed from \'", OLD.middle_name, "\' to \'", NEW.middle_name, "\'; ");
        END IF;

        IF NOT OLD.sur_name <=> NEW.sur_name THEN
            SET msg = CONCAT(msg, "surname changed from \'", OLD.sur_name, "\' to \'", NEW.sur_name, "\'; ");
        END IF;

        IF NOT OLD.suffix <=> NEW.suffix THEN
            SET msg = CONCAT(msg, "suffix changed from \'", OLD.suffix, "\' to \'", NEW.suffix, "\'; ");
        END IF;

        IF NOT OLD.region <=> NEW.region THEN
            SET msg = CONCAT(msg, "region changed from \'", OLD.region, "\' to \'", NEW.region, "\'; ");
        END IF;

        IF NOT OLD.province <=> NEW.province THEN
            SET msg = CONCAT(msg, "province changed from \'", OLD.province, "\' to \'", NEW.province, "\'; ");
        END IF;

        IF NOT OLD.city <=> NEW.city THEN
            SET msg = CONCAT(msg, "city changed from \'", OLD.city, "\' to \'", NEW.city, "\'; ");
        END IF;

        IF NOT OLD.phone_number <=> NEW.phone_number THEN
            SET msg = CONCAT(msg, "phone number changed from \'", OLD.phone_number, "\' to \'", NEW.phone_number, "\'; ");
        END IF;

        IF NOT OLD.status <=> NEW.status THEN
            SET msg = CONCAT(msg, "status changed from \'", OLD.status, "\' to \'", NEW.status, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "guest_details",
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
    DROP TRIGGER IF EXISTS after_delete_guest_details;

    CREATE TRIGGER after_delete_guest_details
    AFTER DELETE ON guest_details
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "guest_details",
            OLD.id,
            "DELETE",
            CONCAT("Guest details for user ID ", OLD.user_id, " were deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END
    ');
};
