<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'git@github.com:/oliveade/shape-of-you.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('161.35.162.159')
    ->setLabels(['stage' => 'prod'])
    ->set('remote_user', 'master_mmcdasburj')
    ->set('deploy_path', '~/applications/zdjmyznepe/public_html');

// Tasks

//task('deploy:secrets', function () {
//    upload(getenv('DOTENV'), '{{deploy_path}}/shared/.env');
//});

//task('build', function () {
//    cd('{{release_path}}');
//    run('npm install');
//    run('npm run prod');
//});

// Hooks

// after('deploy:update_code', 'deploy:secrets');

//after('deploy:update_code', 'build');

after('deploy:failed', 'deploy:unlock');
