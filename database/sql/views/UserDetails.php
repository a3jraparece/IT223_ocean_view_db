<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP VIEW IF EXISTS user_full_detail;
        
    CREATE VIEW user_full_detail AS
    SELECT
        users.id,
        users.username,
        users.email,
        users.email_verified_at,
        users.password,
        users.profile_photo,
        users.status as user_status,
        users.remember_token,
        guest_details.first_name,
        guest_details.middle_name,
        guest_details.sur_name,
        guest_details.suffix,
        guest_details.region,
        guest_details.province,
        guest_details.city,
        guest_details.phone_number,
        guest_details.status as detail_status,
        users.created_at,
        users.updated_at
    FROM
    users
    JOIN guest_details ON users.id = guest_details.user_id
    ');
};
