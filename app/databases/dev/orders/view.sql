# View orders #

-- View orders
CREATE OR REPLACE VIEW v_orders AS
SELECT
    o.id order_number, o.date order_date, o.money, o.total, o.change_money, o.notes,
    o.status status_id, osl.name status_name,
    o.user, u.name user_name,
    o.created_on, o.created_by, ucb.name created_by_name,
    o.modified_on, o.modified_by, umb.name modified_by_name
FROM orders o
LEFT JOIN order_status_lookup osl ON osl.id = o.status
LEFT JOIN user u ON u.username = o.user
LEFT JOIN user ucb ON ucb.username = o.created_by
LEFT JOIN user umb ON umb.username = o.modified_by;
-- End View orders

-- View order detail
CREATE OR REPLACE VIEW v_order_detail AS
SELECT
    od.id, od.order_id order_number,
    od.item item_id, i.name item_name, od.order_item, od.price_item, od.qty, od.subtotal,
    od.created_on, od.created_by, ucb.name created_by_name,
    od.modified_on, od.modified_by, umb.name modified_by_name
FROM order_detail od
LEFT JOIN items i ON i.id = od.item
LEFT JOIN user ucb ON ucb.username = od.created_by
LEFT JOIN user umb ON umb.username = od.modified_by;
-- End View order detail

# End View orders #