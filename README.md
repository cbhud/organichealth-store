[Live Demo](https://organichealth.zya.me/index.php)
# Organic Health Store

University final exam project built using PHP  

This PHP-based e-commerce platform for products incorporates a range of modern web development features, including:

- **User Registration & Login:**  
  - Secure password handling using industry-standard hashing.
  - Security measures such as input validation and session management with roles.

- **Product & Category Management:**  
  - Admins can add, edit, and delete products and categories through dedicated interfaces.
  - Product and category data is stored and managed in a relational database (see included DB diagram).
  - Product listing and detail pages dynamically fetch product data from the database.

- **Admin Panel:**  
  - Centralized dashboard for administrators to manage the store, including products, categories, and orders.
  - Backend logic separates admin functionality from regular user experience.

- **Shopping Cart & Checkout:**  
  - Users can add products to a cart, update quantities, and remove items, with actions handled via AJAX for responsiveness.
  - Checkout process captures order and shipping details, and processes the order into the database.

- **Order Processing & Reports:**  
  - System tracks orders per user, with order history accessible in user accounts and the admin panel.
  - Admins can generate reports (e.g., sales, inventory, user activity) for the store's performance and management.

- **Security & Best Practices:**  
  - User inputs are sanitized to prevent SQL injections.
  - Role-based access control ensures only admins can access sensitive features.

- **Database Design & Implementation:**  
  - Well-structured relational database, as visualized in the provided ERD.
  - Database includes tables for users, products, categories, orders, order items, and possibly more (addresses, reports, etc.).
  - Database dump files (`webshop_dump/`) assist with development, backup, and deployment.

- **Frontend & User Experience:**  
  - Responsive design using custom CSS/JS for interactivity.
  - AJAX enables smooth, real-time updates (e.g., cart changes, order updates, etc.).

- **Utility Scripts:**  
  - Handles AJAX requests for adding products to the user's cart and updating cart contents.
  - Implements server-side filtering logic for product searches and category browsing.
  - Provides live interactive search box suggestions on the products listing page.
  - Enables secure deletion of products by authorized admins.
  - Allows admins to update order status or details.
  - Generates downloadable CSV reports (sales, inventory, etc.) for admin review.
  - Centralizes secure database connections and session management.

---


Organic Health Store demonstrates a comprehensive approach to building a modern, secure, and user-friendly e-commerce application with PHP. 
By combining robust backend architecture, responsive frontend design, and carefully structured utility scripts, 
the project delivers a complete online store experience suitable for real-world deployment or further development. 
The modular codebase and best practices in security and maintainability ensure the platform is both scalable and adaptable for future needs.


