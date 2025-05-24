<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP VIEW IF EXISTS booking_full_summarry;

    CREATE VIEW booking_full_summarry AS
    SELECT
        b.id AS booking_id,
        u.username AS user_name,
        r.id AS room_id,
        b.check_in,
        b.check_out,
        b.`sub-total` AS booking_subtotal,
        b.total_amount,
        b.status,
        bd.price_per_night,
        bd.nights,
        bd.room_subtotal,
        bd.discount,
        bd.tax,
        bd.final_price,
        r.resort_id,
        b.created_at
    FROM
    bookings b
    JOIN users u ON b.user_id = u.id
    JOIN rooms r ON b.room_id = r.id
    JOIN booking_details bd ON b.id = bd.booking_id;
    ');

    // bld.id AS building_id,
    // rs.id AS resort_id,


    // JOIN buildings bld ON r.building_id = bld.id
    // JOIN resorts rs ON rs.id = bld.resort_id
};
