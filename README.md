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

To test the UI

Copy the auth token
```shell
docker exec nft-php-1 php artisan issue-token
```

And paste it to .env file

The test images that are going to be seeded comes from picsum.photos service therefore I have no clue what will you see on your screen
