<?php

use Illuminate\Support\Facades\DB;

return function () {


    DB::unprepared('
    DROP PROCEDURE IF EXISTS update_guest_details;

    CREATE PROCEDURE update_guest_details (
        IN p_user_id INT,
        IN p_first_name VARCHAR(100),
        IN p_middle_name VARCHAR(100),
        IN p_sur_name VARCHAR(100),
        IN p_suffix VARCHAR(10),
        IN p_region VARCHAR(100),
        IN p_province VARCHAR(100),
        IN p_city VARCHAR(100),
        IN p_phone_number VARCHAR(20),
        IN p_status TINYINT
    )
    BEGIN
        DECLARE existing INT;

        SELECT COUNT(*) INTO existing
        FROM guest_details
        WHERE user_id = p_user_id;

        IF existing > 0 THEN
            UPDATE guest_details
            SET
                first_name = p_first_name,
                middle_name = p_middle_name,
                sur_name = p_sur_name,
                suffix = p_suffix,
                region = p_region,
                province = p_province,
                city = p_city,
                phone_number = p_phone_number,
                status = p_status,
                updated_at = NOW()
            WHERE user_id = p_user_id;
        ELSE
            INSERT INTO guest_details (
                user_id, first_name, middle_name, sur_name, suffix,
                region, province, city, phone_number, status,
                created_at, updated_at
            )
            VALUES (
                p_user_id, p_first_name, p_middle_name, p_sur_name, p_suffix,
                p_region, p_province, p_city, p_phone_number, p_status,
                NOW(), NOW()
            );
        END IF;
    END
    ');

    DB::unprepared('
    DROP PROCEDURE IF EXISTS CreateUserWithRole;

    CREATE PROCEDURE CreateUserWithRole(
        IN p_username VARCHAR(255),
        IN p_email VARCHAR(255),
        IN p_password VARCHAR(255)
    )
    BEGIN
        DECLARE user_id INT;
        DECLARE currentTimestamp DATETIME;

        SET currentTimestamp = NOW();

        START TRANSACTION;

        INSERT INTO users (username, email, password, created_at, updated_at) 
        VALUES (p_username, p_email, p_password, currentTimestamp, currentTimestamp);

        SET user_id = LAST_INSERT_ID();

        INSERT INTO user_roles (user_id, role_id, resort_id, created_at, updated_at) 
        VALUES (user_id, 4, NULL, currentTimestamp, currentTimestamp);

        INSERT INTO guest_details (user_id, created_at, updated_at)
        VALUES (user_id, currentTimestamp, currentTimestamp);

        COMMIT;

        SELECT user_id AS user_id;
    END
    ');
    
};
