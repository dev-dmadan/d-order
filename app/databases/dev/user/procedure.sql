# Procedure, Function, and Trigger user #

-- Procedure add user
DROP PROCEDURE IF EXISTS p_add_user;
delimiter //

CREATE PROCEDURE p_add_user (
    in username_param varchar(50),
    in password_param text,
    in name_param varchar(255),
    in level_param int,
    in status_param int,
    in image_param text,
    in created_by_param varchar(50)
)
BEGIN

    INSERT INTO user 
        (username, password, name, level, status, image, created_by, modified_by)
    VALUES 
        (username_param, password_param, name_param, level_param, 
        status_param, image_param, created_by_param, created_by_param);

END //

delimiter ;
-- End Procedure add user

-- Procedure edit user
DROP PROCEDURE IF EXISTS p_edit_user;
delimiter //

CREATE PROCEDURE p_edit_user (
    in username_param varchar(50),
    in name_param varchar(255),
    in level_param int,
    in status_param int,
    in modified_by_param varchar(50)
)
BEGIN

    UPDATE user SET
        name = name_param,
        level = level_param,
        status = status_param,
        modified_by = modified_by_param
    WHERE username = username_param;

END //

delimiter ;
-- End Procedure edit user

-- -- Procedure edit status user
-- DROP PROCEDURE IF EXISTS p_edit_status_user;
-- delimiter //

-- CREATE PROCEDURE p_edit_status_user (
--     in username_param varchar(50),
--     in status_param int,
--     in modified_by_param varchar(50)
-- )
-- BEGIN

--     UPDATE user SET
--         status = status_param,
--         modified_by = modified_by_param
--     WHERE username = username_param;

-- END //

-- delimiter ;
-- -- End Procedure edit status user

-- Procedure edit foto user
DROP PROCEDURE IF EXISTS p_edit_foto_user;
delimiter //

CREATE PROCEDURE p_edit_foto_user (
    in username_param varchar(50),
    in image_param text,
    in modified_by_param varchar(50)
)
BEGIN

    UPDATE user SET
        image = image_param,
        modified_by = modified_by_param
    WHERE username = username_param;

END //

delimiter ;
-- End Procedure edit foto user

-- Procedure edit password user
DROP PROCEDURE IF EXISTS p_edit_password_user;
delimiter //

CREATE PROCEDURE p_edit_password_user (
    in username_param varchar(50),
    in password_param text,
    in modified_by_param varchar(50)
)
BEGIN

    UPDATE user SET
        password = password_param,
        modified_by = modified_by_param
    WHERE username = username_param;

END //

delimiter ;
-- End Procedure edit password user

-- Procedure delete user
DROP PROCEDURE IF EXISTS p_delete_user;
delimiter //

CREATE PROCEDURE p_delete_user (
    in username_param varchar(50)
)
BEGIN

    DELETE FROM user WHERE username = username_param;

END //

delimiter ;
-- End Procedure delete user

# End Procedure, Function, and Trigger user #