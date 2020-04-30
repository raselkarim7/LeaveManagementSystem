# Leave Management System


**Clone this project, go to root directory. 
Follow the Steps**

### Step 1: Database configuraton:
* Create **.env file** and copy everything from **.env.example**, and paste in **.env**
* Here I used mysql database, Create a database in mysql & configure these in **.env** file
```
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=leave_management_system
	DB_USERNAME=root
	DB_PASSWORD=

```
### Step 2: Run following commands
```
composer install

npm install 

php artisan key:generate

php artisan passport:keys

php artisan migrate:fresh --seed
```
* Then run below command and Then you have to press enter again to execute.
```
php artisan passport:client --personal
```

* Then run following commands
```
npm run dev 

php artisan cache:clear

php artisan config:clear

```

* Final command 

```
php artisan serve
```
This command will generate and url and go to that. 

**Login With**
```
email: hr@hr.com
password: 123456
```
**Finally:**
While creating and employee from this application, the password autometically was set to **123456**, 
And also we have change password option in this project.  
```
Client components and Routes accesses have been given by roles.
The Role with "HR Manager" is able to perform everything.
Other employee only can apply for leave and see their leave applications.
```