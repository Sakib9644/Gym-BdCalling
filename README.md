
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
To set up the Gym Scheduling System, first ensure that you have cloned the repository and installed all necessary dependencies. After configuring the environment file and setting up your database, you will need to migrate the database and seed it with initial data. When the migration and seeding process is complete, the necessary tables will be created, and data will be automatically seeded into them. This includes creating the default admin user. The admin will have the email admin@example.com and the password password. This user will be automatically assigned the role of admin, giving them full control over the system. Once the admin account is created, the system will be ready for use.
