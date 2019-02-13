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
        status_param, created_by_param, modified_by_param);

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
    image_param text,
    modified_by_param varchar(50)
)
BEGIN

    UPDATE items SET
        name = name_param,
        price = price_param,
        description = description_param,
        image = image_param,
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