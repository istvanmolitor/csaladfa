mkdir packages
cd packages
git clone git@github.com:istvanmolitor/admin.git
git clone git@github.com:istvanmolitor/media.git
git clone git@github.com:istvanmolitor/menu.git
git clone git@github.com:istvanmolitor/user.git

cd ../resources/js
mkdir packages
cd packages

git clone git@github.com:istvanmolitor/vue-admin.git
git clone git@github.com:istvanmolitor/vue-media.git
git clone git@github.com:istvanmolitor/ts-menu.git
git clone git@github.com:istvanmolitor/vue-user.git

cd ../../../
if [ ! -f .env ]; then
    cp .env.example .env
fi

composer install

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
