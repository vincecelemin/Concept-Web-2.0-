## About
This project is for the fulfillment of the final requirement for the subject Web Framework

Inside the web application, customers may register and do their shopping from a wide selection of concept stores that are provided by the registered shop owners.

## Included Modules (for web app)
- Shop Registration
- Products Management (CRUD functionalities)
- Orders Management (CRUD functionalities)
- Sales Viewing

## Installation
- Download the Project
- Move the Project to the Server's Folder
- Make a database named ```concept_db```
- In the terminal (CMD):
    - Run ```composer install```
    - Run ```php artisan key:generate```
    - Run ```php artisan migrate```
    - Run ```php artisan db:seed```
- In the ```.env``` set the value of the ```DB_DATABASE``` field to ```concept_db```
- Insert the proper database credentials
- In the terminal: Run ```php artisan serve```
- Open the URL provided