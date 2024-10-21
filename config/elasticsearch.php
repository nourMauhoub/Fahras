<?php
return [
    'hosts' => [
        env('ELASTICSEARCH_HOST', 'elasticsearch'),
        env('ELASTICSEARCH_PORT', '9200'),
    ],
];