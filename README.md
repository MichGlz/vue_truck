Truck Management Application
This application allows users to manage their trucks, including adding, viewing, and updating truck details. Below are the instructions for running the application and an overview of its features:


Run the Application: Start the Laravel development server.

php artisan serve
The application will be accessible at http://localhost:8000.

Features
View Trucks: Users can view a list of their trucks with details such as brand, model, colors, sizes, and base price.
Add Truck: Users can add new trucks to their collection by specifying the brand, model, colors, sizes, and base price.
Update Truck: Users can update the details of their existing trucks, including colors, sizes, and base price.

Data Structure
The vehicles table in the database stores information about trucks. Each truck record includes fields for brand, model, colors, sizes, and base price. The colors and sizes columns store JSON arrays containing the available colors and sizes of the truck, along with their respective price factors.

Here's an example of how the colors and sizes columns are structured:

{
    "colors": ["red", "blue", "white", "black"],
    "sizes": [
        {"cubic_m": "10", "price_factor": 1},
        {"cubic_m": "12", "price_factor": 1.1},
        {"cubic_m": "14", "price_factor": 1.15}
    ]
}

PHP 8.2.4
Laravel Framework 10.48.4

Time:
Backend: 3hr
Frontend: 4.5hr
Extras: 2hr
