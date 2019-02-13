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