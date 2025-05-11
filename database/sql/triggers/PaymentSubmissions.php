<?php

use Illuminate\Support\Facades\DB;

return function () {
    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_payment_submission;
    DROP TRIGGER IF EXISTS after_update_payment_submission;
    DROP TRIGGER IF EXISTS after_delete_payment_submission;

    CREATE TRIGGER after_insert_payment_submission
    AFTER INSERT ON payment_submissions
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "payment_submissions",
            NEW.id,
            "INSERT",
            CONCAT(
                "Payment submission received for booking_id ", NEW.booking_id,
                ", amount_paid: ", NEW.amount_paid,
                ", status: ", NEW.status
            ),
            @user_id,
            NOW(),
            NOW()
        );
    END;

    CREATE TRIGGER after_update_payment_submission
    AFTER UPDATE ON payment_submissions
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";

        IF NOT OLD.booking_id <=> NEW.booking_id THEN
            SET msg = CONCAT(msg, "booking_id changed from \'", OLD.booking_id, "\' to \'", NEW.booking_id, "\'; ");
        END IF;
        IF NOT OLD.screenshot_path <=> NEW.screenshot_path THEN
            SET msg = CONCAT(msg, "screenshot_path changed; ");
        END IF;
        IF NOT OLD.amount_paid <=> NEW.amount_paid THEN
            SET msg = CONCAT(msg, "amount_paid changed from \'", OLD.amount_paid, "\' to \'", NEW.amount_paid, "\'; ");
        END IF;
        IF NOT OLD.reference_number <=> NEW.reference_number THEN
            SET msg = CONCAT(msg, "reference_number changed; ");
        END IF;
        IF NOT OLD.status <=> NEW.status THEN
            SET msg = CONCAT(msg, "status changed from \'", OLD.status, "\' to \'", NEW.status, "\'; ");
        END IF;
        IF NOT OLD.reviewed_by <=> NEW.reviewed_by THEN
            SET msg = CONCAT(msg, "reviewed_by changed from \'", OLD.reviewed_by, "\' to \'", NEW.reviewed_by, "\'; ");
        END IF;
        IF NOT OLD.reviewed_at <=> NEW.reviewed_at THEN
            SET msg = CONCAT(msg, "reviewed_at changed; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
            VALUES (
                "payment_submissions",
                NEW.id,
                "UPDATE",
                msg,
                @user_id,
                NOW(),
                NOW()
            );
        END IF;
    END;

    CREATE TRIGGER after_delete_payment_submission
    AFTER DELETE ON payment_submissions
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "payment_submissions",
            OLD.id,
            "DELETE",
            CONCAT(
                "Payment submission with ID ", OLD.id,
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
