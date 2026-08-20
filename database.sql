CREATE DATABASE IF NOT EXISTS request_system;
USE request_system;
-- Requests table
CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    priority ENUM('low', 'normal', 'high') NOT NULL DEFAULT 'normal',
    status ENUM('new', 'in_progress', 'closed') NOT NULL DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_email (email),
    INDEX idx_name (fullname)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- Insert sample data
INSERT INTO requests (
        fullname,
        email,
        subject,
        description,
        priority,
        status,
        created_at
    )
VALUES (
        'John Doe',
        'john.doe@example.com',
        'Cannot access my account',
        'I have been trying to log in for the past hour but keep getting "invalid credentials" error even after resetting my password.',
        'high',
        'new',
        DATE_SUB(NOW(), INTERVAL 2 HOUR)
    ),
    (
        'Jane Smith',
        'jane.smith@company.com',
        'Feature request: Export reports',
        'We need the ability to export monthly reports in CSV format for our accounting department. This would save us hours of manual work.',
        'normal',
        'in_progress',
        DATE_SUB(NOW(), INTERVAL 5 HOUR)
    ),
    (
        'Bob Johnson',
        'bob.j@startup.io',
        'Billing discrepancy',
        'Our invoice #INV-2026-001 shows an overcharge of $250. We were quoted $500 but billed $750. Please investigate.',
        'high',
        'new',
        DATE_SUB(NOW(), INTERVAL 1 DAY)
    ),
    (
        'Alice Williams',
        'alice.w@techcorp.com',
        'API documentation outdated',
        'The API documentation for version 2.0 still references the old endpoint structure. This is causing confusion for our integration team.',
        'normal',
        'new',
        DATE_SUB(NOW(), INTERVAL 2 DAY)
    ),
    (
        'Charlie Brown',
        'charlie.b@enterprise.com',
        'Password reset not working',
        'The password reset email never arrives to our corporate email addresses. We''ve checked spam folders and whitelisted your domain.',
        'high',
        'in_progress',
        DATE_SUB(NOW(), INTERVAL 3 DAY)
    ),
    (
        'Diana Prince',
        'diana.p@justice.org',
        'Slow performance on dashboard',
        'The dashboard takes over 10 seconds to load when viewing the last 30 days of data. This happens consistently during business hours.',
        'normal',
        'new',
        DATE_SUB(NOW(), INTERVAL 4 DAY)
    ),
    (
        'Eve Adams',
        'eve.a@researchlab.net',
        'Question about data retention',
        'We need clarification on your data retention policy. How long do you keep customer data after account termination?',
        'low',
        'closed',
        DATE_SUB(NOW(), INTERVAL 7 DAY)
    ),
    (
        'Frank Castle',
        'frank.c@securityfirm.com',
        'Security vulnerability report',
        'We discovered that the session token is being transmitted over HTTP instead of HTTPS in some scenarios.',
        'high',
        'new',
        DATE_SUB(NOW(), INTERVAL 12 HOUR)
    ),
    (
        'Grace Hopper',
        'grace.h@navy.mil',
        'Need bulk import feature',
        'We have 500+ records to import and the current system only allows one-at-a-time creation. A bulk CSV import would be greatly appreciated.',
        'normal',
        'new',
        DATE_SUB(NOW(), INTERVAL 1 DAY)
    ),
    (
        'Henry Ford',
        'henry.f@automotive.com',
        'Integration with our CRM',
        'We need to integrate your system with our Salesforce CRM. Do you have any existing connectors or APIs we can use?',
        'normal',
        'in_progress',
        DATE_SUB(NOW(), INTERVAL 2 DAY)
    );