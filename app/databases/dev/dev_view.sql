-- View User
CREATE OR REPLACE VIEW v_user AS
    SELECT u.username, u.password, u.name name, u.images, l.name level, a.name status
    FROM user u
    LEFT JOIN level_lookup l ON l.id = u.level
    LEFT JOIN active_status_lookup a ON a.id = u.status;

