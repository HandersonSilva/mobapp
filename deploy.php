<?php
/** create a file the deploy */
namespace Deployer;

require 'recipe/common.php';

$imageName = 'mobapp';
$version = '1.0.1';
$port = '8000';
$replicas = 2;

inventory('deployment/hosts.yml');

set('application', 'MOBAPP');

set('default_stage', 'production');

set('repository', 'git@bitbucket.org:teamsisp/mobapp.git');
set('keep_releases', 2);

task('copy-config', function () {
    run('cp -f /home/ubuntu/environment/env.mobapp {{release_path}}/src/.env');
})->desc('Copy config files');

task('docker-build', function () use ($imageName, $version) {
  run('cd {{release_path}} && docker build -t handersonsilva/switch-'.$imageName.':'.$version.' .');
})->desc('Build image');

task('docker-push', function () use ($imageName, $version) {
  run('docker push handersonsilva/switch-'.$imageName.':'.$version);
})->desc('Push image');

task('docker-clear-image', function () {
  run('docker image prune -a -f');
})->desc('Push image');

task('remove-service', function () use ($imageName) {
  try{
      run("docker service rm {$imageName}");
  }catch(\Exception $e){
      write($e->getMessage());
  }
  return true;
})->desc('Remove service');

task('create-service', function () use ($imageName, $version, $port, $replicas) {
  run("docker service create --name {$imageName} --replicas {$replicas} -dt -p {$port}:80 handersonsilva/switch-{$imageName}:{$version}");
})->desc('Create service');

task('update-permissions', function () {
     run('sudo chown -R ubuntu:ubuntu {{release_path}}/src');
     run('sudo chmod -R 777 {{release_path}}/src/storage');
})->desc('Update permissions');

task('deploy',[
  'deploy:info',
  'deploy:prepare',
  'deploy:release',
  'deploy:update_code',
  'copy-config',
  'update-permissions',
  'docker-build',
  'docker-push',
  'docker-clear-image',
  'remove-service',
  'create-service',
  'deploy:shared',
  'deploy:writable',
  'deploy:symlink',
  'cleanup'    
])->desc('Deploy project');

after('deploy:failed', 'deploy:unlock');