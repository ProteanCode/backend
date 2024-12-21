```shell
echo nft.dev 127.0.0.1 >> /etc/hosts
cd ./.docker
./up.sh
docker exec nft-php-1 cp .env.example .env
docker exec nft-php-1 composer install
docker exec nft-php-1 php artisan key:generate
docker exec nft-php-1 php artisan migrate
docker exec nft-php-1 php artisan db:seed
docker exec nft-php-1 php artisan test
```
