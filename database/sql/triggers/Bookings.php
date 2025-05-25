<?php

use Illuminate\Support\Facades\DB;

return function () {
    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_booking;
    DROP TRIGGER IF EXISTS after_update_booking;
    DROP TRIGGER IF EXISTS after_delete_booking;

  CREATE TRIGGER after_insert_booking
AFTER INSERT ON bookings
FOR EACH ROW
BEGIN
    DECLARE v_resort_id INT;

    IF @user_id IS NULL THEN
    SET @user_id = 1;  -- Default user ID (you can choose a default user ID here)
    END IF;

    -- Get resort_id via room -> building -> resort
    SELECT bld.resort_id INTO v_resort_id
    FROM rooms r
    JOIN buildings bld ON r.building_id = bld.id
    WHERE r.id = NEW.room_id
    LIMIT 1;

    -- Insert into trigger_logs with resolved resort_id
    INSERT INTO trigger_logs (
        `table`, `affected_id`, `action`, `message`,
        `triggered_by`, `resort_id`, `created_at`, `updated_at`
    )
    VALUES (
        "bookings",
        NEW.id,
        "INSERT",
        CONCAT(
            "Booking created for user_id ", NEW.user_id,
            ", room_id ", NEW.room_id,
            ", check-in ", NEW.check_in,
            ", check-out ", NEW.check_out
        ),
        @user_id,
        v_resort_id,
        NOW(),
        NOW()
    );
END;

CREATE TRIGGER after_update_booking
        AFTER UPDATE ON bookings
        FOR EACH ROW
        BEGIN
            DECLARE msg TEXT DEFAULT "";
            DECLARE v_resort_id INT;

            IF @user_id IS NULL THEN
    SET @user_id = 1;  -- Default user ID (you can choose a default user ID here)
    END IF;

            -- Get resort_id from room → building
            SELECT bld.resort_id INTO v_resort_id
            FROM rooms r
            JOIN buildings bld ON r.building_id = bld.id
            WHERE r.id = NEW.room_id
            LIMIT 1;

            IF NOT OLD.user_id <=> NEW.user_id THEN
                SET msg = CONCAT(msg, "user_id changed from \'", OLD.user_id, "\' to \'", NEW.user_id, "\'; ");
            END IF;
            IF NOT OLD.room_id <=> NEW.room_id THEN
                SET msg = CONCAT(msg, "room_id changed from \'", OLD.room_id, "\' to \'", NEW.room_id, "\'; ");
            END IF;
            IF NOT OLD.check_in <=> NEW.check_in THEN
                SET msg = CONCAT(msg, "check_in changed from \'", OLD.check_in, "\' to \'", NEW.check_in, "\'; ");
            END IF;
            IF NOT OLD.check_out <=> NEW.check_out THEN
                SET msg = CONCAT(msg, "check_out changed from \'", OLD.check_out, "\' to \'", NEW.check_out, "\'; ");
            END IF;
            IF NOT OLD.`sub-total` <=> NEW.`sub-total` THEN
                SET msg = CONCAT(msg, "sub-total changed from \'", OLD.`sub-total`, "\' to \'", NEW.`sub-total`, "\'; ");
            END IF;
            IF NOT OLD.total_amount <=> NEW.total_amount THEN
                SET msg = CONCAT(msg, "total_amount changed from \'", OLD.total_amount, "\' to \'", NEW.total_amount, "\'; ");
            END IF;
            IF NOT OLD.status <=> NEW.status THEN
                SET msg = CONCAT(msg, "status changed from \'", OLD.status, "\' to \'", NEW.status, "\'; ");
            END IF;

            IF msg != "" THEN
                INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `resort_id`, `created_at`, `updated_at`)
                VALUES (
                    "bookings",
                    NEW.id,
                    "UPDATE",
                    msg,
                    @user_id,
                    v_resort_id,
                    NOW(),
                    NOW()
                );
            END IF;
        END;
        
        CREATE TRIGGER after_delete_booking
        AFTER DELETE ON bookings
        FOR EACH ROW
        BEGIN
            DECLARE v_resort_id INT;

            IF @user_id IS NULL THEN
    SET @user_id = 1;  -- Default user ID (you can choose a default user ID here)
    END IF;

            -- Fetch the resort_id through the deleted room`s building
            SELECT bld.resort_id INTO v_resort_id
            FROM rooms r
            JOIN buildings bld ON r.building_id = bld.id
            WHERE r.id = OLD.room_id
            LIMIT 1;

            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `resort_id`, `created_at`, `updated_at`)
            VALUES (
                "bookings",
                OLD.id,
                "DELETE",
                CONCAT("Booking with ID ", OLD.id, " for user_id ", OLD.user_id, " was deleted."),
                @user_id,
                v_resort_id,
                NOW(),
                NOW()
            );
        END;

    ');
};
