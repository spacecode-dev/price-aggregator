# Lumen PHP Framework

##Install

Run `cp .env.example .env` in root directory. 

Run `cp .env.example .env` in docker directory. 

Run `docker-compose up --build` for building containers and run docker.

Run `docker exec -it php php artisan migrate` for creation database structure.

Run `docker exec -it php php artisan jwt:secret` for creation a jwt secret key.


## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
