
@servers(['web-1' => 'root@192.168.1.1', 'web-2' => 'root@192.168.1.2'])

@task('deploy', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    cd /var/www/
    git pull origin master
    composer install --no-dev
    php artisan migrate
@endtask


@task('deploy-ecommerce', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    cd /var/www/ecommerce
    git pull origin master
    composer install
    php artisan migrate
@endtask

@task('init-ecommerce', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    cd /var/www/ecommerce
    git pull origin master
    composer install
    php artisan migrate
@endtask