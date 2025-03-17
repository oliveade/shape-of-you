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
    ->set('remote_user', 'master_mmcdasburj')
    ->set('deploy_path', '~/applications/zdjmyznepe/public_html');

// Hooks

after('deploy:failed', 'deploy:unlock');
