-- seeding table active status lookup
INSERT INTO active_status_lookup 
	(name, description) 
VALUES 
	('ACTIVE', NULL), 
	('NONACTIVE', NULL);

-- seeding table level lookup
INSERT INTO level_lookup
	(name, description)
VALUES
	('MEMBERS', NULL),
	('ADMIN', NULL);
	
-- seeding table order status lookup
INSERT INTO order_status_lookup
	(name, description)
VALUES
	('ACTIVE', NULL),
	('NONACTIVE', NULL);

-- seeding table user
-- password sementara plain text
INSERT INTO user
	(username, password, name)
VALUES
	('hidayat', 'hidayat', 'M. Hidayat'),
	('madan', 'madan', 'Romadan Saputra'),
	('alibaba', 'alibaba', 'M. Ali Imron'),
	('liliput', 'liliput', 'Lili Syaripudin');