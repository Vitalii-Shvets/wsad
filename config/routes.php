<?php
return array(
    'request/name-([a-zA-Z]+)/order-([a-zA-Z]+)' => 'request/index/$1/$2',
    'request/([0-9]+)' => 'request/delete/$1',
    'request/create' => 'request/create',
    'requests' => 'request/index',
);