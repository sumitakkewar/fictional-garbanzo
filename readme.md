# Service Portal

## Tech Specification
- Docker
- Laravel
- VueJs
- MySQL
- VS-Code Rest Client ( Extension Id: humao.rest-client )

## Setup guide

### 1. Requirement
- Docker ( Docker version 20.10.8 Dev Machine Version)
### 2. ENV Setup
- frontend 
    - Copy env.example as .env
- backend
    - Copy env.example as .env
    - Keep MAIL_FROM_ADDRESS empty if you are not configuring email client, i have used Sendgrid

### 3. Run Application
- Run Command ``` docker-compose up -d ```
This Command will start application on local server
    Ports are mapped as follows:
    - Database(MySQL): 3001
    - PHP: 3002
    - Nginx: 3003
    - Frontend: 3004
    
    *Note:* Make sure these ports are open, or change same in *docker-compose.yml*
- http://localhost:3003/ points to Backend
- http://localhost:3004/ points to Frontend

#### *Important Note:* Front-End wont work here due to not pointing API_URL to correct container. follow below steps to connect Front-End
1. ```bashdocker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' service_portal_nginx```
(take the output of this command and replace in .env with <docker-container-ip>)
2. ```bash docker-compose stop```
3. ```bash docker-compose start```

Above steps will be perfomed when there is change in ENV file.

### 4. Migration and Seeding
- ```bashphp artisan db:wipe``` (just in case)
- ```bashphp artisan migrate``` 
- ```bashphp artisan db:seed``` This will populated Users and Services Tables with Data
- ```bashphp artisan cache:clear``` (just in case)

*Note:* To run these command please open docker cotainer => ```bash docker exec -it service_portal_php bash```, Run this command in terminal, after all docker container started.

### 5. Testing
- Test User 1:
    Username: *provider@test.com*
- Test User 2:
    Username: *subscriber@test.com*

all passwords are *password*

### 4. REST API Documentation
You will find all api endpoints in app/rest folder
- auth.rest - it has login, register api documentation
- jobs.rest - it has apis like jobs, orders, profile, job
- provider.rest - it has apis like register, deregister for provider 
- subscriber.rest - it has apis like register, deregister for subscriber
- service.rest - it has apis like services list, service item, book service appointment

*Note:* VS-Code Rest Client ( Extension Id: humao.rest-client ), You can use this extension to see test all apis
### 5.Testing
NA(Won't be able to complete it due timeline)


# Thank You!
## Sumit Akkewar
### sumitakkewar@gmail.com | contact@sumitakkewar.com



