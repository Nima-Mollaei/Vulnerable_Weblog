# Vulnerable Weblog - Web Security Practice

This is a deliberately vulnerable PHP weblog project designed for **learning and practicing web security concepts**. It includes several classic web vulnerabilities that can be explored safely in a controlled environment.

**⚠️ Warning:** This project is intentionally insecure. **Do not deploy it on a public server**. Use it only locally or in a safe lab environment.

---

## Features / Vulnerabilities Included

- **Authentication Bypass / Logic Flaws** – Login without proper credentials
- **IDOR (Insecure Direct Object References)** – Access other users' posts and data
- **Blind SQL Injection (Boolean-based & Time-based)** – Discover data using SQLi techniques
- **Second-Order SQL Injection** – Payload triggers on later queries
- **Stored XSS** – Persistent JavaScript injection
- **File Upload Vulnerabilities** – Unsafe file uploads for testing
- **API IDOR** – Access API endpoints of other users
- Simple blog functionality: create, edit, delete posts
- and lots of outer bugs ...
---

## Requirements

- PHP >= 8.0
- MySQL or MariaDB
- Web server (Apache, XAMPP, WAMP, or similar)

---

## Setup Instructions

1. Clone this repository:

```bash
git clone https://github.com/your-username/Vulnerable_Weblog.git
cd Vulnerable_Weblog
