<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP PROCEDURE IF EXISTS InsertUser;

    CREATE PROCEDURE InsertUser(
        IN p_username VARCHAR(255),
        IN p_email VARCHAR(255),
        IN p_password VARCHAR(255),
        IN p_profile_photo VARCHAR(255),
        IN p_status ENUM("active", "inactive")
    )
    BEGIN
        INSERT INTO users (username, email, password, profile_photo, status, created_at, updated_at)
        VALUES (p_username, p_email, p_password, p_profile_photo, p_status, NOW(), NOW());
    END
    ');

    // Deri ipang butang other procedures pud sa baba

};
