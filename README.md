
# Gym Scheduling System
Overview
The Gym Scheduling System is designed to efficiently manage gym class scheduling for three user roles: Admin, Trainer, and Trainee.

## User Roles:
### Admin:

Creates and manages trainer profiles.
Assigns trainers up to 5 classes per day, each lasting 2 hours.
Manages class capacities, trainee assignments, and monitors system activities.

### Trainer:

Can view assigned class schedules, including date, time, class capacity, and trainee list.
Cannot modify class schedules or availability.

### Trainee:

Can browse and book available classes based on trainer schedules.
Must avoid booking classes with time conflicts.
Can manage their profile and bookings (view, cancel, reschedule) through a dashboard.
Key Features:
Admin-controlled scheduling and class capacity management.
Trainers have read-only access to their schedules.
Trainees can book classes and manage their bookings without conflicts.

# Project Setup
To set up the Gym Scheduling System, first ensure that you have cloned the repository and installed all necessary dependencies. After configuring the environment file and setting up your database, you will need to migrate the database and seed it with initial data. When the migration and seeding process is complete, the necessary tables will be created, and data will be automatically seeded into them. This includes creating the default admin user. The admin will have the email admin@example.com and the password is password. This user will be automatically assigned the role of admin, giving them full control over the system. Once the admin account is created, the system will be ready for use.

## Login
For login, use this endpoint: https://gym.com.samadhan24.com/api/login. After providing the correct credentials, it will return a JWT token. This token must be passed in the Authorization header for all subsequent API requests.

## Create Trainer
Use the following endpoint to create a trainer: https://gym.com.samadhan24.com/api/admin/trainers. The JSON data for submitting will be structured as follows:

{ "name": "John Doe", "email": "john.doe@example.com", "password": "password123", "expertise": "Yoga", "user_id": 2, "availability": [ "2024-12-15", "2024-12-16", "2024-12-17" ] }

GET /admin/trainers: Retrieves a list of all trainers in the system. This endpoint allows admins to view the complete list of trainers.
URL: https://gym.com.samadhan24.com/api/admin/trainers

GET /admin/trainers/{trainer}: Retrieves the details of a specific trainer identified by their unique ID. This endpoint allows admins to view information about a particular trainer.
URL: https://gym.com.samadhan24.com/api/admin/trainers/{trainer}

PUT /admin/trainers/{trainer}: Updates the details of an existing trainer. Admins can modify the trainer's information by sending the updated data.
URL: https://gym.com.samadhan24.com/api/admin/trainers/{trainer}

DELETE /admin/trainers/{trainer}: Deletes a specific trainer from the system. Admins can remove trainers by providing their unique ID.
URL: https://gym.com.samadhan24.com/api/admin/trainers/{trainer}

## Class Schedule API Routes

GET /admin/classes/get: Retrieves a list of all scheduled classes in the system. This endpoint allows admins to view the complete list of classes.
URL: https://gym.com.samadhan24.com/api/admin/classes/get

POST /admin/classes/store: Creates a new class schedule. Admins can submit the necessary JSON data to add a new class to the system.
URL: https://gym.com.samadhan24.com/api/admin/classes/store
{
  "trainer_id": 3,
  "class_time": "2024-12-16 16:10",
  "class_name": "yoga",
  "capacity": 20
}

GET /admin/classes/{class}: Retrieves the details of a specific class identified by its unique ID. This endpoint allows admins to view information about a particular class.
URL: https://gym.com.samadhan24.com/api/admin/classes/{class}

PUT /admin/classes/{class}: Updates the details of an existing class. Admins can modify the class schedule by sending the updated data.
URL: https://gym.com.samadhan24.com/api/admin/classes/{class}
{
  "trainer_id": 3,
  "class_time": "2024-12-16 16:10",
  "class_name": "yoga",
  "capacity": 20
}

DELETE /admin/classes/{class}: Deletes a specific class from the system. Admins can remove classes by providing their unique ID.
URL: https://gym.com.samadhan24.com/api/admin/classes/{class}

## Trainer Class
To retrieve scheduled classes, trainers must log in using their credentials. The GET /trainer/classes endpoint is accessible only to users with the trainer role, ensuring that trainers can securely view their schedules. Upon successful login, trainers will receive their class schedule along with essential information, including their expertise, total class capacity, and the trainees assigned to each class.

This endpoint is available at:
URL: https://gym.com.samadhan24.com/api/trainer/classes

## Trainee Section
