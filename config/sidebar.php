<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'menu' => [[
      'text' => 'Navigation',
      'is_header' => true
    ],[
      'url' => '/dashboard',
      'icon' => 'fa fa-home',
      'text' => 'Home'
    ],
    [
      'icon' => 'fa fa-user-circle',
      'text' => 'Add Patient',
      'children' => [[
        'url' => '/create-patient-from-emr',
        'text' => 'Add Patient From EMR'
      ],
      [
        'url' => '/create-patient',
        'text' => 'New Patient Registration'
      ]
      ]
      ],
      [
        'url' => '/beds',
        'icon' => 'fa fa-bed',
        'text' => 'Bed Information'
      ],
      [
        'url' => '/patients-list',
        'icon' => 'fa fa-users',
        'text' => 'Patient List'
    ],
    [
      'icon' => 'fa fa-cogs',
      'text' => 'Settings',
      'children' => [[
        'url' => '/admin/permissions',
        'text' => 'Permissions'
      ],
      [
        'url' => '/admin/assign-role',
        'text' => 'Roles'
      ]
      ]
      ],

]];
