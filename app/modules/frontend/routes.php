<?php
/**
 * Shorthand controller instantiation format:
 * module:controller:action
 * i.e. frontend:index:index -> \Modules\Frontend\Controllers\IndexController::indexAction
 */

return function(\Slim\App $app) {

    $app->get('/', 'frontend:index:index')->setName('home');
    $app->get('/account', 'frontend:account:index')->setName('account:index');
    $app->map(['GET', 'POST'], '/login', 'frontend:account:login')->setName('account:login');
    $app->get('/logout', 'frontend:account:logout')->setName('account:logout');
    $app->get('/endsession', 'frontend:account:endmasquerade')->setName('account:endmasquerade');
    $app->get('/profile', 'frontend:profile:index')->setName('profile:index');
    $app->map(['GET', 'POST'], '/profile/edit', 'frontend:profile:edit')->setName('profile:edit');
    $app->map(['GET', 'POST'], '/profile/timezone', 'frontend:profile:timezone')->setName('profile:timezone');
    $app->get('/test', 'frontend:util:test')->setName('util:test');

    $app->group('/setup', function () {

        $this->map(['GET', 'POST'], '', 'frontend:setup:index')->setName('setup:index');
        $this->map(['GET', 'POST'], '/complete', 'frontend:setup:complete')->setName('setup:complete');
        $this->map(['GET', 'POST'], '/register', 'frontend:setup:register')->setName('setup:register');
        $this->map(['GET', 'POST'], '/station', 'frontend:setup:station')->setName('setup:station');
        $this->map(['GET', 'POST'], '/settings', 'frontend:setup:settings')->setName('setup:settings');

    });

    $app->group('/public/{station}', function () {

        $this->get('', 'frontend:public:index')->setName('public:index');
        $this->get('/embed', 'frontend:public:embed')->setName('public:embed');
        $this->get('/embed-requests', 'frontend:public:embedrequests')->setName('public:embedrequests');
        $this->get('/playlist[/{format}]', 'frontend:public:playlist')->setName('public:playlist');

    });

};