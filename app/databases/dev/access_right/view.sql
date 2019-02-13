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