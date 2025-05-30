<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::statement("DROP VIEW IF EXISTS user_booking_details_view");

    DB::statement("
    CREATE VIEW user_booking_details_view AS
    SELECT
        bd.id AS booking_detail_id,
        bd.booking_id,
        bd.price_per_night,
        bd.nights,
        bd.room_subtotal,
        bd.discount,
        bd.tax,
        bd.final_price,
        bd.created_at AS booking_detail_created_at,
        bd.updated_at AS booking_detail_updated_at,
        b.user_id,
        b.check_in,
        b.check_out,
        b.status,
        b.created_at AS booking_created_at,
        b.updated_at AS booking_updated_at,
        r.room_name,
        rt.name
    FROM booking_details bd
    JOIN bookings b ON bd.booking_id = b.id
    JOIN rooms r ON b.room_id = r.id
    JOIN room_types rt ON r.room_type_id = rt.id
    ORDER BY b.created_at DESC
");
};
