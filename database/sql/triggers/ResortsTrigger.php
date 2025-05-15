<?php

use Illuminate\Support\Facades\DB;

return function () {

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_insert_resort;

        IF @user_id IS NULL THEN
            SET @user_id = 1;  -- Default user ID (you can choose a default user ID here)
        END IF;

    CREATE TRIGGER after_insert_resort
    AFTER INSERT ON resorts
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`,`affected_id` ,`action`, `message`, `triggered_by`)
        VALUES (
            "resorts",
            NEW.id,
            "INSERT",
            CONCAT("Resort ", NEW.name, " was added with ID ", NEW.id),
            @user_id
        );
    END
    ');


    DB::unprepared('
    DROP TRIGGER IF EXISTS after_update_resort;

    CREATE TRIGGER after_update_resort
    AFTER UPDATE ON resorts
    FOR EACH ROW
    BEGIN
    DECLARE msg TEXT DEFAULT "";

    IF NOT OLD.name <=> NEW.name THEN
        SET msg = CONCAT(msg, "name changed from \'", OLD.name, "\' to \'", NEW.name, "\'; ");
    END IF;
    IF NOT OLD.location <=> NEW.location THEN
        SET msg = CONCAT(msg, "location changed from \'", OLD.location, "\' to \'", NEW.location, "\'; ");
    END IF;
    IF NOT OLD.tax_rate <=> NEW.tax_rate THEN
        SET msg = CONCAT(msg, "tax_rate changed from \'", OLD.tax_rate, "\' to \'", NEW.tax_rate, "\'; ");
    END IF;
    IF NOT OLD.status <=> NEW.status THEN
        SET msg = CONCAT(msg, "status changed from \'", OLD.status, "\' to \'", NEW.status, "\'; ");
    END IF;
    IF NOT OLD.contact_details <=> NEW.contact_details THEN
        SET msg = CONCAT(msg, "contact_details changed; ");
    END IF;
    IF NOT OLD.main_image <=> NEW.main_image THEN
        SET msg = CONCAT(msg, "main_image changed; ");
    END IF;
    IF NOT OLD.image1 <=> NEW.image1 THEN
        SET msg = CONCAT(msg, "image1 changed; ");
    END IF;
    IF NOT OLD.image1_2 <=> NEW.image1_2 THEN
        SET msg = CONCAT(msg, "image1_2 changed; ");
    END IF;
    IF NOT OLD.image1_3 <=> NEW.image1_3 THEN
        SET msg = CONCAT(msg, "image1_3 changed; ");
    END IF;
    IF NOT OLD.image2 <=> NEW.image2 THEN
        SET msg = CONCAT(msg, "image2 changed; ");
    END IF;
    IF NOT OLD.image3 <=> NEW.image3 THEN
        SET msg = CONCAT(msg, "image3 changed; ");
    END IF;
    IF NOT OLD.resort_description <=> NEW.resort_description THEN
        SET msg = CONCAT(msg, "resort_description changed; ");
    END IF;
    IF NOT OLD.room_image_1 <=> NEW.room_image_1 THEN
        SET msg = CONCAT(msg, "room_image_1 changed; ");
    END IF;
    IF NOT OLD.room_image_2 <=> NEW.room_image_2 THEN
        SET msg = CONCAT(msg, "room_image_2 changed; ");
    END IF;
    IF NOT OLD.room_image_3 <=> NEW.room_image_3 THEN
        SET msg = CONCAT(msg, "room_image_3 changed; ");
    END IF;
    IF NOT OLD.room_description <=> NEW.room_description THEN
        SET msg = CONCAT(msg, "room_description changed; ");
    END IF;


    IF msg != "" THEN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "resorts",
            NEW.id,
            "UPDATE",
            msg,
            @user_id,
            NOW(),
            NOW()
        );
    END IF;
    END;
    ');

    DB::unprepared('
    DROP TRIGGER IF EXISTS after_delete_resort;

    CREATE TRIGGER after_delete_resort
    AFTER DELETE ON resorts
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
        VALUES (
            "resorts",
            OLD.id,
            "DELETE",
            CONCAT("Resort ", OLD.name, " with ID ", OLD.id, " was deleted."),
            @user_id,
            NOW(),
            NOW()
        );
    END;
    ');



    // Deri ipang butang other triggers pud sa baba
};
