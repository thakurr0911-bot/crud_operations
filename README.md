# crud_operations

Project: PHP CRUD Operations with AJAX, Filters, Pagination & Loader

Description:
A complete CRUD (Create, Read, Update, Delete) application built with PHP, MySQL, AJAX, and jQuery. Features real-time data operations without page refresh, advanced filtering, server-side pagination, and loading animations for smooth user experience.

Features:
- Full CRUD operations (Create, Read, Update, Delete) via AJAX
- Real-time search/filter by multiple fields (name, email, status, date)
- Server-side pagination with customizable page size
- Inline editing and bulk delete functionality
- Loading spinner/overlay during AJAX requests
- Responsive Bootstrap design
- Data validation and error handling
- Confirmation dialogs for delete operations

How it Works:
1. Main page displays records table with filters and pagination
2. AJAX handles all data operations without page reloads
3. PHP backend processes requests and returns JSON responses
4. jQuery manages frontend interactions and DOM updates
5. Loading overlay shows during server communication

Usage:
1. Configure database connection in config.php
2. Run the application in web browser
3. Use search boxes to filter records instantly
4. Click Edit/Delete buttons for CRUD operations
5. Pagination controls navigate through results

Files Structure:
- index.php - Main interface with table and filters
- config.php - Database configuration
- ajax_handler.php - Processes all AJAX requests (CRUD, filter, pagination)
- style.css - Custom styling and loader animations
- script.js - jQuery AJAX logic and frontend interactions

Setup Instructions:
1. Create MySQL database and table (sample SQL provided)
2. Update database credentials in config.php
3. Upload all files to web server
4. Access index.php to start using

Key Features Implemented:
- Search filter across multiple columns simultaneously
- Pagination with 10/25/50 records per page
- Real-time loader animation during AJAX calls
- Success/error toast notifications
- Responsive table with mobile optimization
- Bulk select and delete functionality

AJAX Endpoints:
- fetch_data.php - Load filtered/paginated records
- add_user.php - Create new record
- edit_user.php - Update existing record
- delete_user.php - Delete single/bulk records

Technologies Used:
- Backend: PHP 7+, MySQL
- Frontend: HTML5, Bootstrap 5, jQuery 3.x
- Features: AJAX, JSON, Server-side pagination

Notes:
- Secure against SQL injection using prepared statements
- XSS protection with htmlspecialchars()
- Session-based CSRF protection recommended for production
- Easy to extend with more fields and filters
- have to create upload file in the folder directory.

Future Enhancements:
- Export to CSV/Excel
- Image upload support
- Advanced date range filter
- Print functionality

Contact:
For support, customization, or issues, contact thakurr0911@gmail.com.
