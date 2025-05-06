<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP PROCEDURE IF EXISTS CreateUserWithRole;

    CREATE PROCEDURE CreateUserWithRole (
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

        COMMIT;

        SELECT user_id AS user_id;
    END;
    ');

    // Deri ipang butang other procedures pud sa baba

};
