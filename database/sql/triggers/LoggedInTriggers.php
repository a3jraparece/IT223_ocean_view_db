<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS user_login_trigger;

    CREATE TRIGGER user_login_trigger
    AFTER INSERT ON logged_in_users
    FOR EACH ROW
    BEGIN
        DECLARE current_user_id INT;
    
        SET current_user_id = NEW.user_id;

        IF current_user_id IS NOT NULL THEN
            INSERT INTO trigger_logs (`table`, `affected_id`,`action`, `message`,`triggered_by` ,`created_at`)
            VALUES ("logged_in_users", current_user_id,"LOGIN", CONCAT("User ", current_user_id, " logged in"), current_user_id ,NOW());
        END IF;
    END
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS user_logout_trigger;

    CREATE TRIGGER user_logout_trigger
    AFTER DELETE ON logged_in_users
    FOR EACH ROW
    BEGIN
        DECLARE current_user_id INT;

        SET current_user_id = OLD.user_id;

        IF current_user_id IS NOT NULL THEN
            INSERT INTO trigger_logs (`table`, `affected_id`,`action`, `message`, `triggered_by`, `created_at`)
            VALUES ("logged_in_users", current_user_id, "LOGOUT", CONCAT("User ", current_user_id, " logged out"), current_user_id , NOW());
        END IF;
    END
    ');

};
