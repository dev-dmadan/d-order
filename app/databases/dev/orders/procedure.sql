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