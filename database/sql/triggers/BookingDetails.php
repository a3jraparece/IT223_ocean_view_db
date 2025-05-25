<?php

use Illuminate\Support\Facades\DB;

return function () {
    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_booking_detail;
    DROP TRIGGER IF EXISTS after_update_booking_detail;
    DROP TRIGGER IF EXISTS after_delete_booking_detail;

    CREATE TRIGGER after_insert_booking_detail
    AFTER INSERT ON booking_details
    FOR EACH ROW
    BEGIN
    IF @user_id IS NULL THEN
    SET @user_id = 1;  -- Default user ID (you can choose a default user ID here)
    END IF;
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "booking_details",
            NEW.id,
            "INSERT",
            CONCAT(
                "Booking detail created for booking_id ", NEW.booking_id,
                ", price_per_night: ", NEW.price_per_night,
                ", nights: ", NEW.nights,
                ", final_price: ", NEW.final_price
            ),
            @user_id,
            NOW(),
            NOW()
        );
    END;

    CREATE TRIGGER after_update_booking_detail
    AFTER UPDATE ON booking_details
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.booking_id <=> NEW.booking_id THEN
            SET msg = CONCAT(msg, "booking_id changed from \'", OLD.booking_id, "\' to \'", NEW.booking_id, "\'; ");
        END IF;
        IF NOT OLD.price_per_night <=> NEW.price_per_night THEN
            SET msg = CONCAT(msg, "price_per_night changed from \'", OLD.price_per_night, "\' to \'", NEW.price_per_night, "\'; ");
        END IF;
        IF NOT OLD.nights <=> NEW.nights THEN
            SET msg = CONCAT(msg, "nights changed from \'", OLD.nights, "\' to \'", NEW.nights, "\'; ");
        END IF;
        IF NOT OLD.room_subtotal <=> NEW.room_subtotal THEN
            SET msg = CONCAT(msg, "room_subtotal changed from \'", OLD.room_subtotal, "\' to \'", NEW.room_subtotal, "\'; ");
        END IF;
        IF NOT OLD.discount <=> NEW.discount THEN
            SET msg = CONCAT(msg, "discount changed from \'", OLD.discount, "\' to \'", NEW.discount, "\'; ");
        END IF;
        IF NOT OLD.tax <=> NEW.tax THEN
            SET msg = CONCAT(msg, "tax changed from \'", OLD.tax, "\' to \'", NEW.tax, "\'; ");
        END IF;
        IF NOT OLD.final_price <=> NEW.final_price THEN
            SET msg = CONCAT(msg, "final_price changed from \'", OLD.final_price, "\' to \'", NEW.final_price, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "booking_details",
                NEW.id,
                "UPDATE",
                msg,
                @user_id,
                NOW(),
                NOW()
            );
        END IF;
    END;

    CREATE TRIGGER after_delete_booking_detail
    AFTER DELETE ON booking_details
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "booking_details",
            OLD.id,
            "DELETE",
            CONCAT(
                "Booking detail with ID ", OLD.id,
                " for booking_id ", OLD.booking_id,
                " was deleted."
            ),
            @user_id,
            NOW(),
            NOW()
        );
    END;
    ');
};
