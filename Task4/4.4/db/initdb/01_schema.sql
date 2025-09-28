-- Create table for storing student details
CREATE TABLE IF NOT EXISTS students (
    student_id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    address TEXT,
    dob DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
