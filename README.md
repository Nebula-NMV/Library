PHP Library Management System (Basic CRUD)
A simple role-based library system without API integration

🔧 Setup Instructions
Database Configuration

Edit private/check_db.php and private/connect.php with your database credentials

Import provided SQL file to your database

File Permissions

Grant write permissions to the book/ directory for file uploads

Initial Access

Admin account is configured through database (set role = 'admin')

Passwords cannot be changed via direct database edits

👨💻 Role Permissions
Administrator

📚 Book Management: Add/Edit/Delete books

👥 User Management: Edit roles (moderator/user), update profiles, delete users
(Cannot modify other admin accounts)

📖 Borrowing System: Process loans/returns, view borrowing history

⚙️ Personal Profile: Update own information

Moderator

📚 Book Management: Add/Edit/Delete books

📖 Borrowing System: Process loans/returns, view borrowing history
(No user management access)

⚙️ Personal Profile: Update own information

Regular User

🔍 Browse & Borrow: Request books, view loan status

⚙️ Personal Profile: Update own information

⚠️ Important Notes
Data Integrity

Deleting books/users will erase associated borrowing history

Admin accounts can only be modified through direct database edits

Security

Password changes must use system interface (not via database)

Implement additional server-side validation as needed

Error Handling

Check PHP error logs for debugging

Verify database connection settings if issues occur
