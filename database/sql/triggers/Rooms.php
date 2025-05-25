<?php

use Illuminate\Support\Facades\DB;

// return function () {

//     // DB::unprepared('
//     // DROP TRIGGER IF EXISTS after_insert_room;

//     // CREATE TRIGGER after_insert_room
//     // AFTER INSERT ON rooms
//     // FOR EACH ROW
//     // BEGIN
//     //     INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
//     //     VALUES (
//     //         "rooms",
//     //         NEW.id,
//     //         "INSERT",
//     //         CONCAT("Room ", NEW.room_name, " was added with ID ", NEW.id),
//     //         @user_id,
//     //         NOW(),
//     //         NOW()
//     //     );
//     // END
//     // ');

//     // DB::unprepared('
//     // DROP TRIGGER IF EXISTS after_update_room;

//     // CREATE TRIGGER after_update_room
//     // AFTER UPDATE ON rooms
//     // FOR EACH ROW
//     // BEGIN
//     //     DECLARE msg TEXT DEFAULT "";

//     //     IF NOT OLD.building_id <=> NEW.building_id THEN
//     //         SET msg = CONCAT(msg, "building_id changed from \'", OLD.building_id, "\' to \'", NEW.building_id, "\'; ");
//     //     END IF;
//     //     IF NOT OLD.room_type_id <=> NEW.room_type_id THEN
//     //         SET msg = CONCAT(msg, "room_type_id changed from \'", OLD.room_type_id, "\' to \'", NEW.room_type_id, "\'; ");
//     //     END IF;
//     //     IF NOT OLD.room_name <=> NEW.room_name THEN
//     //         SET msg = CONCAT(msg, "room_name changed from \'", OLD.room_name, "\' to \'", NEW.room_name, "\'; ");
//     //     END IF;
//     //     IF NOT OLD.room_image <=> NEW.room_image THEN
//     //         SET msg = CONCAT(msg, "room_image changed; ");
//     //     END IF;
//     //     IF NOT OLD.description <=> NEW.description THEN
//     //         SET msg = CONCAT(msg, "description changed; ");
//     //     END IF;
//     //     IF NOT OLD.inclusions <=> NEW.inclusions THEN
//     //         SET msg = CONCAT(msg, "inclusions changed; ");
//     //     END IF;
//     //     IF NOT OLD.amenities <=> NEW.amenities THEN
//     //         SET msg = CONCAT(msg, "amenities changed; ");
//     //     END IF;
//     //     IF NOT OLD.price_per_night <=> NEW.price_per_night THEN
//     //         SET msg = CONCAT(msg, "price_per_night changed from \'", OLD.price_per_night, "\' to \'", NEW.price_per_night, "\'; ");
//     //     END IF;
//     //     IF NOT OLD.is_available <=> NEW.is_available THEN
//     //         SET msg = CONCAT(msg, "is_available changed from \'", OLD.is_available, "\' to \'", NEW.is_available, "\'; ");
//     //     END IF;

//     //     IF msg != "" THEN
//     //         INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
//     //         VALUES (
//     //             "rooms",
//     //             NEW.id,
//     //             "UPDATE",
//     //             msg,
//     //             @user_id,
//     //             NOW(),
//     //             NOW()
//     //         );
//     //     END IF;
//     // END
//     // ');

//     // DB::unprepared('
//     // DROP TRIGGER IF EXISTS after_delete_room;

//     // CREATE TRIGGER after_delete_room
//     // AFTER DELETE ON rooms
//     // FOR EACH ROW
//     // BEGIN
//     //     INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `created_at`, `updated_at`)
//     //     VALUES (
//     //         "rooms",
//     //         OLD.id,
//     //         "DELETE",
//     //         CONCAT("Room ", OLD.room_name, " with ID ", OLD.id, " was deleted."),
//     //         @user_id,
//     //         NOW(),
//     //         NOW()
//     //     );
//     // END
//     // ');
    
    
// };

return function () {
    // Drop existing triggers if any
    DB::unprepared('DROP TRIGGER IF EXISTS after_update_room;');
    DB::unprepared('DROP TRIGGER IF EXISTS after_delete_room;');

    // Create after_update_room trigger
    DB::unprepared('
    CREATE TRIGGER after_update_room
    AFTER UPDATE ON rooms
    FOR EACH ROW
    BEGIN
        DECLARE msg TEXT DEFAULT "";
        DECLARE res_id INT DEFAULT NULL;

        SET res_id = NEW.resort_id;

        IF NOT OLD.building_id <=> NEW.building_id THEN
            SET msg = CONCAT(msg, "building_id changed from \'", OLD.building_id, "\' to \'", NEW.building_id, "\'; ");
        END IF;
        IF NOT OLD.room_type_id <=> NEW.room_type_id THEN
            SET msg = CONCAT(msg, "room_type_id changed from \'", OLD.room_type_id, "\' to \'", NEW.room_type_id, "\'; ");
        END IF;
        IF NOT OLD.room_name <=> NEW.room_name THEN
            SET msg = CONCAT(msg, "room_name changed from \'", OLD.room_name, "\' to \'", NEW.room_name, "\'; ");
        END IF;
        IF NOT OLD.room_image <=> NEW.room_image THEN
            SET msg = CONCAT(msg, "room_image changed; ");
        END IF;
        IF NOT OLD.description <=> NEW.description THEN
            SET msg = CONCAT(msg, "description changed; ");
        END IF;
        IF NOT OLD.inclusions <=> NEW.inclusions THEN
            SET msg = CONCAT(msg, "inclusions changed; ");
        END IF;
        IF NOT OLD.amenities <=> NEW.amenities THEN
            SET msg = CONCAT(msg, "amenities changed; ");
        END IF;
        IF NOT OLD.price_per_night <=> NEW.price_per_night THEN
            SET msg = CONCAT(msg, "price_per_night changed from \'", OLD.price_per_night, "\' to \'", NEW.price_per_night, "\'; ");
        END IF;
        IF NOT OLD.is_available <=> NEW.is_available THEN
            SET msg = CONCAT(msg, "is_available changed from \'", OLD.is_available, "\' to \'", NEW.is_available, "\'; ");
        END IF;

        IF msg != "" THEN
            INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `resort_id`, `created_at`, `updated_at`)
            VALUES (
                "rooms",
                NEW.id,
                "UPDATE",
                msg,
                @user_id,
                res_id,
                NOW(),
                NOW()
            );
        END IF;
    END;
    ');

    // Create after_delete_room trigger
    DB::unprepared('
    CREATE TRIGGER after_delete_room
    AFTER DELETE ON rooms
    FOR EACH ROW
    BEGIN
        INSERT INTO trigger_logs (`table`, `affected_id`, `action`, `message`, `triggered_by`, `resort_id`, `created_at`, `updated_at`)
        VALUES (
            "rooms",
            OLD.id,
            "DELETE",
            CONCAT("Room ", OLD.room_name, " with ID ", OLD.id, " was deleted."),
            @user_id,
            OLD.resort_id,
            NOW(),
            NOW()
        );
    END;
    ');
};
