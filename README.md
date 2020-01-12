# brick_photo
A photography library for communities
***
# Docker
```
>>> clone laradock
git clone https://github.com/laradock/laradock.git
cp env-example .env

>>> config php-worker in docker-compose.yml
    php-worker:
      image: zimoxiao/php-worker:latest
      restart: always
      volumes:
        - ${APP_CODE_PATH_HOST}:${APP_CODE_PATH_CONTAINER}${APP_CODE_CONTAINER_FLAG}
        - ./php-worker/supervisord.d:/etc/supervisord.d
      depends_on:
        - workspace
      extra_hosts:
        - "dockerhost:${DOCKER_HOST_IP}"
      networks:
        - backend
      ports:
      - 5200:5200
>>> 

docker-compose exec workspace bash
crontab -e
>>>
0 18 * * * cd ~/laradock && docker-compose exec workspace php /var/www/brick_photo/artisan send:download
0 18 * * * cd ~/laradock && docker-compose exec workspace php /var/www/brick_photo/artisan send:delete
>>>
```