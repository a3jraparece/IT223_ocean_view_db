<?php

use Illuminate\Support\Facades\DB;

return function () {


    DB::statement("DROP VIEW IF EXISTS booking_stats_view");

    DB::statement("
    CREATE VIEW booking_stats_view AS

    SELECT 
        'Pending' AS status,
        SUM(CASE WHEN status = 'Pending' AND DATE(check_in) = CURDATE() THEN 1 ELSE 0 END) AS today,
        SUM(CASE WHEN status = 'Pending' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() THEN 1 ELSE 0 END) AS this_week,
        SUM(CASE WHEN status = 'Pending' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() THEN 1 ELSE 0 END) AS this_month,
        SUM(CASE WHEN status = 'Pending' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 364 DAY AND CURDATE() THEN 1 ELSE 0 END) AS this_year
    FROM bookings

    UNION ALL

    SELECT 
        'Confirmed',
        SUM(CASE WHEN status = 'Confirmed' AND DATE(check_in) = CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Confirmed' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Confirmed' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Confirmed' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 364 DAY AND CURDATE() THEN 1 ELSE 0 END)
    FROM bookings

    UNION ALL

    SELECT 
        'Cancelled',
        SUM(CASE WHEN status = 'Cancelled' AND DATE(check_in) = CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Cancelled' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Cancelled' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Cancelled' AND DATE(check_in) BETWEEN CURDATE() - INTERVAL 364 DAY AND CURDATE() THEN 1 ELSE 0 END)
    FROM bookings

    UNION ALL

    SELECT 
        'Completed',
        SUM(CASE WHEN status = 'Completed' AND DATE(check_out) = CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Completed' AND DATE(check_out) BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Completed' AND DATE(check_out) BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() THEN 1 ELSE 0 END),
        SUM(CASE WHEN status = 'Completed' AND DATE(check_out) BETWEEN CURDATE() - INTERVAL 364 DAY AND CURDATE() THEN 1 ELSE 0 END)
    FROM bookings
    ");
};
