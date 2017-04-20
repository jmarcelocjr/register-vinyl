<?php
return [
	"base" => [
		"url" => 'http://localhost:1010',
		"path" => "/var/www/html/register-vinyl"
	],
    "view" => [
        "template_path" => __DIR__ . "/../view/templates/"
    ],
    "db" => [
    	"host" => "mysql",
    	"database" => "register_vinyl",
    	"user" => "root",
    	"password" => "docker"
    ]
];