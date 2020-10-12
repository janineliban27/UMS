# UMS
User Management System

<b>Clone the repository</b><br>
  * git clone git@github.com/janineliban27/ums.git
<hr>

<b>Switch to the repo folder</b><br>
  * cd usermanagementsystem
<hr>

<b>Install all the dependencies</b><br>
  * composer install
  * npm install
<hr>

<b>Copy the example env file and make the required configuration changes in the .env file</b><br>
  * cp .env.example .env
<hr>

<b>Generate a new application key</b><br>
  * php artisan key:generate
<hr>

<b>Generate a new Laravel passport authentication secret key</b><br>
  * php artisan passport:install
<hr>

<b>Run the database migrations (Set the database connection in .env before migrating)</b><br>
  * php artisan migrate --seed
<hr>

<b>Register a user with a role of "Administrator" to access the site</b>
  
