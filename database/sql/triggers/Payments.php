<?php

use Illuminate\Support\Facades\DB;

// return function () {
//     DB::unprepared('
//     DROP TRIGGER IF EXISTS after_insert_payments;
//     DROP TRIGGER IF EXISTS after_update_payments;
//     DROP TRIGGER IF EXISTS after_delete_payments;

//     CREATE TRIGGER after_insert_payments
//     AFTER INSERT ON payments
//     FOR EACH ROW
//     BEGIN
//         INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
//         VALUES (
//             "payments",
//             NEW.id,
//             "INSERT",
//             CONCAT(
//                 "Payment recorded for booking_id ", NEW.booking_id,
//                 ", amount_paid: ", NEW.amount_paid,
//                 ", method: ", NEW.payment_method
//             ),
//             @user_id,
//             NOW(),
//             NOW()
//         );
//     END;

//     CREATE TRIGGER after_update_payments
//     AFTER UPDATE ON payments
//     FOR EACH ROW
//     BEGIN
//         DECLARE msg TEXT DEFAULT "";

//         IF NOT OLD.booking_id <=> NEW.booking_id THEN
//             SET msg = CONCAT(msg, "booking_id changed from \'", OLD.booking_id, "\' to \'", NEW.booking_id, "\'; ");
//         END IF;
//         IF NOT OLD.payment_method <=> NEW.payment_method THEN
//             SET msg = CONCAT(msg, "payment_method changed from \'", OLD.payment_method, "\' to \'", NEW.payment_method, "\'; ");
//         END IF;
//         IF NOT OLD.amount_paid <=> NEW.amount_paid THEN
//             SET msg = CONCAT(msg, "amount_paid changed from \'", OLD.amount_paid, "\' to \'", NEW.amount_paid, "\'; ");
//         END IF;
//         IF NOT OLD.received_by <=> NEW.received_by THEN
//             SET msg = CONCAT(msg, "received_by changed from \'", OLD.received_by, "\' to \'", NEW.received_by, "\'; ");
//         END IF;
//         IF NOT OLD.payment_submission_id <=> NEW.payment_submission_id THEN
//             SET msg = CONCAT(msg, "payment_submission_id changed from \'", OLD.payment_submission_id, "\' to \'", NEW.payment_submission_id, "\'; ");
//         END IF;

//         IF msg != "" THEN
//             INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
//             VALUES (
//                 "payments",
//                 NEW.id,
//                 "UPDATE",
//                 msg,
//                 @user_id,
//                 NOW(),
//                 NOW()
//             );
//         END IF;
//     END;

//     CREATE TRIGGER after_delete_payments
//     AFTER DELETE ON payments
//     FOR EACH ROW
//     BEGIN
//         INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
//         VALUES (
//             "payments",
//             OLD.id,
//             "DELETE",
//             CONCAT(
//                 "Payment with ID ", OLD.id,
//                 " for booking_id ", OLD.booking_id,
//                 " was deleted."
//             ),
//             @user_id,
//             NOW(),
//             NOW()
//         );
//     END;
//     ');
// };

return function () {
    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_payments;
    DROP TRIGGER IF EXISTS after_update_payments;
    DROP TRIGGER IF EXISTS after_delete_payments;

    CREATE TRIGGER after_insert_payments
    AFTER INSERT ON payments
    FOR EACH ROW
    BEGIN
        DECLARE v_resort_id INT DEFAULT NULL;

        -- Get resort_id via booking -> room
        SELECT r.resort_id INTO v_resort_id
        FROM bookings bk
        JOIN rooms r ON bk.room_id = r.id
        WHERE bk.id = NEW.booking_id
        LIMIT 1;

        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `resort_id`, `created_at`, `updated_at`)
        VALUES (
            "payments",
            NEW.id,
            "INSERT",
            CONCAT(
                "Payment recorded for booking_id ", NEW.booking_id,
                ", amount_paid: ", NEW.amount_paid,
                ", method: ", NEW.payment_method
            ),
            @user_id,
            v_resort_id,
            NOW(),
            NOW()
        );
    END;

    CREATE TRIGGER after_update_payments
    AFTER UPDATE ON payments
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";
        DECLARE v_resort_id INT DEFAULT NULL;

        -- Get resort_id via booking -> room
        SELECT r.resort_id INTO v_resort_id
        FROM bookings bk
        JOIN rooms r ON bk.room_id = r.id
        WHERE bk.id = NEW.booking_id
        LIMIT 1;

        IF NOT OLD.booking_id <=> NEW.booking_id THEN
            SET msg = CONCAT(msg, "booking_id changed from \'", OLD.booking_id, "\' to \'", NEW.booking_id, "\'; ");
        END IF;
        IF NOT OLD.payment_method <=> NEW.payment_method THEN
            SET msg = CONCAT(msg, "payment_method changed from \'", OLD.payment_method, "\' to \'", NEW.payment_method, "\'; ");
        END IF;
        IF NOT OLD.amount_paid <=> NEW.amount_paid THEN
            SET msg = CONCAT(msg, "amount_paid changed from \'", OLD.amount_paid, "\' to \'", NEW.amount_paid, "\'; ");
        END IF;
        IF NOT OLD.received_by <=> NEW.received_by THEN
            SET msg = CONCAT(msg, "received_by changed from \'", OLD.received_by, "\' to \'", NEW.received_by, "\'; ");
        END IF;
        IF NOT OLD.payment_submission_id <=> NEW.payment_submission_id THEN
            SET msg = CONCAT(msg, "payment_submission_id changed from \'", OLD.payment_submission_id, "\' to \'", NEW.payment_submission_id, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `resort_id`, `created_at`, `updated_at`)
            VALUES (
                "payments",
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

    CREATE TRIGGER after_delete_payments
    AFTER DELETE ON payments
    FOR EACH ROW
    BEGIN
        DECLARE v_resort_id INT DEFAULT NULL;

        -- Get resort_id via booking -> room (OLD.booking_id)
        SELECT r.resort_id INTO v_resort_id
        FROM bookings bk
        JOIN rooms r ON bk.room_id = r.id
        WHERE bk.id = OLD.booking_id
        LIMIT 1;

        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `resort_id`, `created_at`, `updated_at`)
        VALUES (
            "payments",
            OLD.id,
            "DELETE",
            CONCAT(
                "Payment with ID ", OLD.id,
                " for booking_id ", OLD.booking_id,
                " was deleted."
            ),
            @user_id,
            v_resort_id,
            NOW(),
            NOW()
        );
    END;
    ');
};
