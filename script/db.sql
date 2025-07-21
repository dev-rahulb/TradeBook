
-- 2025-07-01
ALTER TABLE users 
ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user',
ADD COLUMN is_blocked TINYINT(1) DEFAULT 0;
