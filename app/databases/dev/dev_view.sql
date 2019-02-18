# View Access Right #

-- View Menu Permission
    CREATE OR REPLACE VIEW v_menu_permission AS
    SELECT
        m.id menu_id, m.name menu_name,
        md.id permission_id, 
        (CASE
            WHEN md.permission = '1' THEN 'READ'
            WHEN md.permission = '2' THEN 'ADD'
            WHEN md.permission = '3' THEN 'UPDATE'
            WHEN md.permission = '4' THEN 'DELETE'
            WHEN md.permission = '5' THEN 'UPDATE STATUS' 
            ELSE 'EXPORT' 
        END) permission_name, md.permission 
    FROM menu m
    JOIN menu_detail md ON md.menu_id = m.id;
-- End View Menu Permission

-- View Role Permission
    CREATE OR REPLACE VIEW v_role_permission AS
    SELECT
        rm.id, rm.user username, u.name user_name,
        md.menu_id, m.name menu_name,
        rm.permission_id,
        (CASE
            WHEN md.permission = '1' THEN 'READ'
            WHEN md.permission = '2' THEN 'ADD'
            WHEN md.permission = '3' THEN 'UPDATE'
            WHEN md.permission = '4' THEN 'DELETE'
            WHEN md.permission = '5' THEN 'UPDATE STATUS' 
            ELSE 'EXPORT' 
        END) permission_name, md.permission
    FROM role_permission rm
    JOIN user u ON u.username = rm.user
    JOIN menu_detail md ON md.id = rm.permission_id
    JOIN menu m ON m.id = md.menu_id;
-- End View Role Permission

-- View Access Menu
    CREATE OR REPLACE VIEW v_access_menu AS
    SELECT
        am.id,
        am.level_id, ll.name level_name,
        am.menu_id, m.name menu_name, m.url, m.class, m.icon, m.position
    FROM access_menu am
    JOIN level_lookup ll ON ll.id = am.level_id
    JOIN menu m ON m.id = am.menu_id;
-- End View Access Menu

# End View Access Right #

# View Increment #

-- View Increment
    CREATE OR REPLACE VIEW v_increment AS
    SELECT
        i.id, i.menu_id, m.name menu_name, m.table_name,
        i.mask, i.last_increment, i.description
    FROM increment i
    JOIN menu m ON m.id = i.menu_id;
-- End View Increment

# End View Increment #

# View items #

-- View Items
CREATE OR REPLACE VIEW v_items AS
SELECT
    i.id, i.name, i.price, i.description, i.image,
    i.status status_id, asl.name status_name,
    i.created_on, i.created_by, ucb.name created_by_name,
    i.modified_on, i.modified_by, umb.name modified_by_name
FROM items i
LEFT JOIN active_status_lookup asl ON asl.id = i.status
LEFT JOIN user ucb ON ucb.username = i.created_by
LEFT JOIN user umb ON umb.username = i.modified_by;
-- End View Items

# End View items #

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

# View user #

-- View User
CREATE OR REPLACE VIEW v_user AS
SELECT
    u.username, u.password, u.name, u.image,
    u.level level_id, ll.name level_name,
    u.status status_id, asl.name status_name,
    u.created_on, u.created_by, ucb.name created_by_name,
    u.modified_on, u.modified_by, umb.name modified_by_name
FROM user u
LEFT JOIN level_lookup ll ON ll.id = u.level
LEFT JOIN active_status_lookup asl ON asl.id = u.status
LEFT JOIN user ucb ON ucb.username = u.created_by
LEFT JOIN user umb ON umb.username = u.modified_by;
-- End View User

# View user #