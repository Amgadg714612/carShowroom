# carShowroom
 backend and frontend project 
Car Rental Management System
The Car Rental Management System is a web-based application designed to streamline the process of renting cars for both customers and administrators. This project provides an efficient way to manage car bookings, track rented vehicles, and handle user information. It is built using PHP for the backend, MySQL for the database, and JavaScript for dynamic frontend interactions.


Features
User Management:
Register and manage users (customers and renters).
Store user details such as name, national ID, phone number, email, and role (renter or customer).


Car Management:
Add, update, and delete car details (brand, model, price, image, colors, type, and status).
Track car availability (available or rented).



Booking System:
Customers can book cars by specifying pickup and return dates.
Calculate the total price based on rental duration.
Store booking details (car ID, user ID, pickup date, return date, and total price).


Rental Information:
View details of rented cars, including renter information, rental duration, and price.
Fetch and display rental history for specific users or cars.

Dynamic Frontend:
Use of JavaScript (Fetch API) to dynamically load and display data without refreshing the page.
Responsive and user-friendly interface.


Technologies Used
Backend: PHP
Frontend: HTML, CSS, JavaScript
Database: MySQL
APIs: Custom RESTful API endpoints for data retrieval and management.

How It Works
User Registration and Login:
Users can register and log in to the system based on their role (renter or customer).
Car Booking:
Customers can browse available cars, select a car, and book it by specifying pickup and return dates.
Rental Management:
Renters can view their rented cars and manage bookings.
Admins can track all bookings and car statuses.


Dynamic Data Fetching:
The frontend uses JavaScript's Fetch API to retrieve data from the backend and display it dynamically.
API Endpoints
Get Rented Cars: GET /index.php?endpoint=rented_cars
Get Renter Information: GET /index.php?endpoint=renter_info&national_id=12345
Get Car Bookings: GET /index.php?endpoint=car_bookings&car_id=1


Installation
Clone the repository:
git clone https://github.com/your-username/car-rental-system.git
Set up the database:


Import the provided SQL file to create the necessary tables.
Configure the backend:
Update the database connection details in the PHP files.
Run the application:
Deploy the project on a local server (e.g., XAMPP, WAMP) or a live server.
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.
Screenshots
![image](https://github.com/user-attachments/assets/fb551f89-65a4-4975-8bbc-b0934d5b0867)

![image](https://github.com/user-attachments/assets/3baf3e5c-869d-419f-a841-a16da360ccd2)

![image](https://github.com/user-attachments/assets/335be781-349b-45f0-8a13-402918c27999)

![image](https://github.com/user-attachments/assets/daa27013-93e0-4a27-b157-ec7c03e9d892)

![image](https://github.com/user-attachments/assets/e2410147-4207-47e4-b0a5-a77fd0011f2f)
![image](https://github.com/user-attachments/assets/384cbeae-fdab-4886-ae0e-da2daa0b3d3c)
...
...
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Car Rental System
Example of the car rental interface.
Future Enhancements
Add payment gateway integration for online payments.
Implement user authentication using JWT or OAuth.
Develop a mobile-friendly version of the application.

