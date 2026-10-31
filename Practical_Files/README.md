# StudentHub — Web Development Frameworks (AIUE203)

This is the original StudentHub Bootstrap website, with PHP/MySQL features added for Practicals 5–15. Original `.html` pages and theme files are retained. Use XAMPP, not VS Code Live Server, for PHP/database functions.

## Installation on XAMPP (Windows)

1. Extract the **Pract** folder into `C:\xampp\htdocs\` so the path is `C:\xampp\htdocs\Pract`.
2. Open XAMPP Control Panel; start **Apache** and **MySQL**.
3. Open `http://localhost/phpmyadmin/`, choose **Import**, select `C:\xampp\htdocs\Pract\database\studenthub.sql`, then click **Import/Go**. The SQL creates database `studenthub`, its tables, 20 sample students and sample events.
4. If MySQL root has a password, edit `backend/db.php` and set `$pass` accordingly.
5. Open `http://localhost/Pract/setup_admin.php`. Enter your own admin name, admin login ID, email and a password of 10+ characters. **Delete `setup_admin.php` immediately afterward**.
6. Open `http://localhost/Pract/home.php
`. Register a student using `register.html`; log in using the enrollment number and password at `login.html`. Admin uses the admin login ID/password you set.
7. Student records: admin login → `admin.php` → **Student Records** (`students.php`). You can add, edit, search, and delete records. Check phpMyAdmin → studenthub → students to see the data. AJAX CRUD is `students_ajax.php`.
8. Admin events: `events_manage.php` (add/edit/delete events and poster images). The public events page uses the database API.
9. Contact form stores messages in `database/contact_messages.csv` (Practical 7). Keep `database/` inaccessible to web visitors; `.htaccess` blocks it on Apache.

## Practical coverage

- P4: Existing DOM interactions and theme preserved.
- P5: Browser-side validation added to existing registration form, plus server-side checks.
- P6: Existing events search/filter/sort/pagination, now backed by database JSON API; existing FAQ content remains.
- P7: Contact POST with server-side validation and CSV storage.
- P8: SQL schema, relations, MySQLi connection and prepared statements.
- P9: Student registration with unique enrollment/email and `password_hash()`.
- P10: PHP login/logout, role-based access, session timeout (30 min); remember-me checkbox remains visual only (not implemented).
- P11: Admin student CRUD/search using MySQLi prepared statements, 20 seed records.
- P12: Admin event CRUD, validated image upload (2MB JPG/PNG/WebP).
- P13: JSON API + Fetch CRUD on `students_ajax.php` without page reload.
- P14: Protected admin dashboard with live counts, role-aware links, audit log.
- P15: Integrated local XAMPP project, README and basic syntax tests.

## Important

- Original `.html` dashboard/profile/admin pages are kept as visual references, but working protected pages use `.php`.
- Do not share real student data in a public GitHub repository. Sample seed data is fictional.
- Admin creation file must be deleted after first use.
- Use a local XAMPP environment; this is a college demonstration, not a production deployment.
- Optional remember-me login and full end-to-end browser/database tests are **not** claimed complete.
