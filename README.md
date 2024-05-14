*Cafeteria Project Specification*


*Project Overview*

PHP application project focusing on revolutionizing cafeteria operations. It is designed with two main parts: Admin View and User View, each tailored to enhance user experience and streamline administrative tasks.

Screen 1: Login

•	Users and admins can securely log in using their email and password.
•	Forgot password functionality redirects users and admins to a page to reset their password.

*User View*


Screen 1: Home

1.	Home page allows users to select their orders.
2.	Products are represented with clickable images.
3.	Users can add or remove products, specify quantities, and add comments.
4.	Rooms are displayed in a combo box.
5.	Total order cost is displayed dynamically.
6.	Confirmation sends the order, with the latest order displayed on top.
7.	prices are specified.
   
Screen 2: My Orders

Users can view their orders with total prices within specified date ranges.
Orders have statuses: Processing, Out for Delivery, and Done.
Only orders in Processing status can be canceled.
Clicking on an order displays its content (order items).

Admin View


Screen 1: Home 

Admins can add orders maual for users choose specific user and make order to him.

Screen 2: Manula Orders

Admins can check current orders and their statuses and add new order manual for users.

Screen 3: Product Management

Admins can view all products, add new ones, edit and remove existing ones.

Screen 4: User Management

Admins can view, edit, and delete users, with an option to add new users.

Screen 5: Add User Form

Provides a form for adding new users to the system.

Screen 6: Category Management

Admins can manage product categories and add new ones.

Screen 7: Rooms Management

Admins can manage rooms, Extensions and add new ones.

Screen 8: Check Management

Admins can view all checks according to specified dates and for specific users.
If no specific user is selected, all users' checks are displayed.
Clicking on a username displays their order info during the specified time period.



*Databse Overview*
Our MySQL dump file (cafeteria_project.sql) contains the database structure.

*Tables*

1- categories: Stores information about product categories.

2- order_items: Tracks items ordered by users.

3- orders: Manages orders placed by users, including order status and total price.

4- products: Contains details about cafeteria products, including their prices and categories.

5- rooms: Stores information about cafeteria rooms.

6- users: Manages user accounts, including their roles and associated rooms.


*Relationships*

•  orders and order_items: Linked via the order_id field, representing a one-to-many relationship between orders and items within those orders.

•  products and categories: Linked via the category_id field, representing a one-to-many relationship between categories and products.

•  orders and users: Linked via the user_id field, representing a one-to-many relationship between users and orders.

•  users and rooms: Linked via the room_id field, representing a one-to-many relationship between users and their assigned rooms.

*DB Usage*

•  To utilize this database structure, import the MySQL dump file into your MySQL database.

•  You can then interact with the tables and data to manage cafeteria operations effectively.
