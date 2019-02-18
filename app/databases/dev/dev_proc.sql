# Procedure, Function, and Trigger Access Right #

# End Procedure, Function, and Trigger Access Right #

# Procedure, Function, and Trigger Increment #

-- Function get increment
    DROP FUNCTION IF EXISTS f_get_increment;
    delimiter //
    CREATE FUNCTION f_get_increment(table_name_param varchar(255)) RETURNS int 
    DETERMINISTIC
    BEGIN
        DECLARE table_id_param int;
        DECLARE last_increment_param int;

        SELECT id INTO table_id_param FROM menu WHERE table_name = table_name_param;
        SELECT last_increment INTO last_increment_param FROM increment WHERE menu_id = table_id_param;

        UPDATE increment SET last_increment = last_increment_param + 1;

        RETURN last_increment_param + 1;
    END //
    delimiter ;
-- End Function get increment

# End Procedure, Function, and Trigger Increment #

# Procedure, Function, and Trigger items #

-- Procedure Add Items
DROP PROCEDURE IF EXISTS p_add_item;
delimiter //

CREATE PROCEDURE p_add_item (
    name_param varchar(255),
    price_param double(12,2),
    description_param text,
    image_param text,
    status_param int,
    created_by_param varchar(50)
)
BEGIN

    INSERT INTO items
        (name, price, description, image, status, created_by, modified_by) 
    VALUES 
        (name_param, price_param, description_param, image_param, 
        status_param, created_by_param, created_by_param);

END //

delimiter ;
-- End Procedure Add Items

-- Procedure Edit Items
DROP PROCEDURE IF EXISTS p_edit_item;
delimiter //

CREATE PROCEDURE p_edit_item (
    id_param int,
    name_param varchar(255),
    price_param double(12,2),
    description_param text,
    status_param int,
    modified_by_param varchar(50)
)
BEGIN

    UPDATE items SET
        name = name_param,
        price = price_param,
        description = description_param,
        status = status_param,
        modified_by = modified_by_param
    WHERE id = id_param;

END //

delimiter ;
-- End Procedure Edit Items

-- Procedure Delete Items
DROP PROCEDURE IF EXISTS p_delete_item;
delimiter //

CREATE PROCEDURE p_delete_item (
    id_param int
)
BEGIN

    DELETE FROM order_detail WHERE item = id_param;
    DELETE FROM items WHERE id = id_param;

END //

delimiter ;
-- End Procedure Delete Items

# End Procedure, Function, and Trigger items #

# Procedure, Function, and Trigger orders #

-- Procedure add order
DROP PROCEDURE IF EXISTS p_add_order;
delimiter //

CREATE PROCEDURE p_add_order (
	in id_param varchar(50),
	in date_param date,
	in money_param double(12,2),
	in total_param double(12,2),
	in change_money_param double(12,2),
	in notes_param text,
	in status_param int,
	in user_param varchar(50)
)
BEGIN

	INSERT INTO orders 
		(id, date, money, total, change_money, notes, status, user, created_by, modified_by) 
	VALUES 
		(id_param, date_param, money_param, total_param, 
		change_money_param, notes_param, status_param, user_param, user_param, user_param);

END //

delimiter ;
-- End Procedure add order

-- Procedure edit order
DROP PROCEDURE IF EXISTS p_edit_order;
delimiter //

CREATE PROCEDURE p_edit_order (
	in id_param varchar(50),
	in date_param date,
	in money_param double(12,2),
	in total_param double(12,2),
	in change_money_param double(12,2),
	in notes_param text,
	in status_param int,
	in modified_by_param varchar(50)
)
BEGIN

	UPDATE orders SET
		date = date_param,
		money = money_param,
		total = total_param,
		change_money = change_money_param,
		notes = notes_param,
		status = status_param,
		modified_by = modified_by_param
	WHERE id = id_param;

END //

delimiter ;
-- End Procedure edit order

-- Procedure edit status order
DROP PROCEDURE IF EXISTS p_edit_status_order;
delimiter //

CREATE PROCEDURE p_edit_status_order (
	in id_param varchar(50),
	in status_param int,
	in modified_by_param varchar(50)
)
BEGIN

	UPDATE orders SET
		status = status_param,
		modified_by = modified_by_param
	WHERE id = id_param;

END //

delimiter ;
-- End Procedure edit status order

-- Procedure delete order
DROP PROCEDURE IF EXISTS p_delete_order;
delimiter //

CREATE PROCEDURE p_delete_order (
	in id_param int
)
BEGIN

	DELETE FROM order_detail WHERE order_id = id_param;
	DELETE FROM orders WHERE id = id_param;

END //

delimiter ;
-- End Procedure delete order

-- Procedure add order detail
DROP PROCEDURE IF EXISTS p_add_order_detail;
delimiter //

CREATE PROCEDURE p_add_order_detail (
	in order_id_param varchar(50),
	in item_param int,
	in order_item_param varchar(255),
	in price_item_param double(12,2),
	in qty_param int,
	in subtotal_param double(12,2),
	in created_by_param varchar(50) 
)
BEGIN

	-- insert order detail
	INSERT INTO order_detail 
		(order_id, item, order_item, price_item, qty, subtotal, created_by, modified_by) 
	VALUES 
		(order_id_param, item_param, order_item_param, price_item_param, 
		qty_param, subtotal_param, created_by_param, created_by_param);

END //

delimiter ;
-- End Procedure add order detail

-- Procedure edit order detail
DROP PROCEDURE IF EXISTS p_edit_order_detail;
delimiter //

CREATE PROCEDURE p_edit_order_detail (
	in id_param int,
	in order_id_param varchar(50),
	in item_param int,
	in order_item_param varchar(255),
	in price_item_param double(12,2),
	in qty_param int,
	in subtotal_param double(12,2),
	in modified_by_param varchar(50)
)
BEGIN

	UPDATE order_detail SET
		item = item_param,
		order_item = order_item_param,
		price_item = price_item_param,
		qty = qty_param,
		subtotal = subtotal_param,
		modified_by = modified_by_param
	WHERE id = id_param;

END //

delimiter ;
-- End Procedure edit order detail

-- Procedure delete order detail
DROP PROCEDURE IF EXISTS p_delete_order_detail;
delimiter //

CREATE PROCEDURE p_delete_order_detail (
	in id_param int
)
BEGIN

	DELETE FROM order_detail WHERE id = id_param;

END //

delimiter ;
-- End Procedure delete order detail

# End Procedure, Function, and Trigger orders #

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