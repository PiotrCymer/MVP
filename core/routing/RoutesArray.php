<?php
  return [
    'main-site' => [
      'url' => '/',
      'routerObject' => [
        'class' => 'appEngine\App\Controllers\IndexController',
        'method' => 'index',
        'model' => 'appEngine\App\Models\IndexModel',
        'type' => 'normal'
      ]
    ],
    'single-category' => [
      'url' => '/kategorie/%^\d+$%/%\w+%',
      'routerObject' => [
        'class' => 'appEngine\App\Controllers\SingleCategoryController',
        'method' => 'index',
        'model' => 'appEngine\App\Models\SingleCategoryModel',
        'type' => 'subpage'
      ]
    ],
    'single-plant' => [
      'url' => '/%^\d+$%/%\w+%',
      'routerObject' => [
        'class' => 'appEngine\App\Controllers\SinglePlantController',
        'method' => 'index',
        'model' => 'appEngine\App\Models\SinglePlantModel',
        'type' => 'subpage'
      ]
    ],
    'send-email' => [
      'url' => '/send-email',
      'routerObject' => [
        'class' => 'appEngine\App\Controllers\IndexController',
        'method' => 'send',
        'model' => 'appEngine\App\Models\IndexModel',
        'type' => 'normal'
      ]
    ],
      'api-test' => [
          'url' => '/api/test',
          'routerObject' => [
              'class' => 'appEngine\App\Controllers\ApiController',
              'method' => 'test',
              'model' => 'appEngine\App\Models\ApiModel',
              'type' => 'api'
          ]
      ],
      'api-login' => [
          'url' => '/api/login',
          'routerObject' => [
              'class' => 'appEngine\App\Controllers\ApiController',
              'method' => 'login',
              'model' => 'appEngine\App\Models\ApiModel',
              'type' => 'api'
          ]
      ]
  ];
