<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared("
       DROP PROCEDURE IF EXISTS create_booking;

CREATE PROCEDURE create_booking(
    IN p_user_id         INT,
    IN p_room_id         INT,
    IN p_check_in        DATE,
    IN p_check_out       DATE,
    IN p_price_per_night DECIMAL(10,2),
    IN p_nights          INT,
    IN p_discount        DECIMAL(10,2),
    IN p_tax             DECIMAL(10,2),
    IN p_sub_total       DECIMAL(10,2),
    IN p_total_amount    DECIMAL(10,2),
    IN p_status          VARCHAR(255),
    IN p_created_at      DATETIME,
    IN p_updated_at      DATETIME
)
BEGIN
    DECLARE v_booking_id INT;

    IF p_check_in IS NULL OR p_check_out IS NULL OR p_check_in >= p_check_out THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid check-in or check-out dates.';
    END IF;

    START TRANSACTION;

    INSERT INTO bookings (
        user_id, room_id, check_in, check_out, `sub-total`,
        total_amount, status, created_at, updated_at
    ) VALUES (
        p_user_id, p_room_id, p_check_in, p_check_out, p_sub_total,
        p_total_amount, p_status, p_created_at, p_updated_at
    );

    SET v_booking_id = LAST_INSERT_ID();

    INSERT INTO booking_details (
        booking_id, price_per_night, nights, room_subtotal,
        discount, tax, final_price, created_at, updated_at
    ) VALUES (
        v_booking_id, p_price_per_night, p_nights, p_sub_total,
        p_discount, p_tax, p_total_amount, p_created_at, p_updated_at
    );

    COMMIT;
END;

    ");
};
