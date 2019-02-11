# View user #

-- View User
CREATE OR REPLACE VIEW v_user AS
SELECT
    u.username, u.password, u.image,
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