<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared("
   DROP PROCEDURE IF EXISTS create_payment;

CREATE PROCEDURE create_payment(
    IN p_booking_id       INT,
    IN p_screenshot_path  VARCHAR(255),
    IN p_amount_paid      DECIMAL(10,2),
    IN p_reference_number VARCHAR(255),
    IN p_status           VARCHAR(50),
    IN p_reviewed_by      INT,
    IN p_reviewed_at      DATETIME,
    IN p_created_at       DATETIME,
    IN p_updated_at       DATETIME
)
BEGIN
    IF p_booking_id IS NULL OR p_amount_paid IS NULL OR p_reference_number IS NULL OR p_status IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Missing required payment parameters.';
    END IF;

    START TRANSACTION;

    INSERT INTO payment_submissions (
        booking_id, screenshot_path, amount_paid,
        reference_number, status, reviewed_by, reviewed_at,
        created_at, updated_at
    ) VALUES (
        p_booking_id, p_screenshot_path, p_amount_paid,
        p_reference_number, p_status, p_reviewed_by, p_reviewed_at,
        p_created_at, p_updated_at
    );

    COMMIT;
END;

");
};
