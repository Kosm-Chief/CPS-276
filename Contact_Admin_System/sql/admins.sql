CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status ENUM('staff', 'admin') NOT NULL
);

-- Insert test admin accounts with password 'password123'
INSERT INTO admins (name, email, password, status) VALUES 
('Admin User', 'mblaser@admin.com', '$2y$10$YourNewHashHere1234567890abcdefghijklmnopqrstuvwxyz', 'admin'),
('Staff User', 'mblaser@staff.com', '$2y$10$Hw2PfUDw5w9O1orPfHHfIedHmM1sFAXPnY4yChiIBHd944xiu2C/W', 'staff'); 