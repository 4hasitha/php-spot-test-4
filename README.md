# PHP Spot Test 4

## .env

Use `.env.example` to create .env file 

## Database
Create a database as `php_spot_test_4` and run following query 
```sh
php artisan migrate:refresh --seed
```

## Run servers
After properly install vendor files and npm dependencies,
run following command to execute the servers
```sh
php artisan serve
```

```sh
npm run dev
```

## Postman Collection
Setup postman collection from `PHP Spot Test 4.postman_collection` file which is under parent folder
1. Use `api/sanctum/token` post request to get the token
2. Use that token as OAuth 2.0 token of `api/order/new` post request 

## Stage 02 Number 3 Question
1. ProcessBeeceptorApiRequest is to manage a queue to call Beeceptor's post request
2. Use following code to maintain the configured number of parallel requests
```sh
php artisan queue:work --queue=beeceptor --tries=3 --max-jobs=5
```
3. `beeceptor_responses` table is to save the API response of beeceptor 3rd party API

## Stage 02 Number 4 Question
1. Use `http://localhost:8000/login` url to login into the system. Use email as 
`4hasitha@gmail.com` and password as `12345678`.
2. Use `http://localhost:8000/home` url to view, submit form and view table data from `Indexed DB`.