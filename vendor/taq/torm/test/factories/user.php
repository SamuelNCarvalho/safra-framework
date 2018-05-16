<?php
TORM\Factory::define("user",array(
                     "id"           => time(),
                     "name"         => "Mary Doe",
                     "email"        => "mary@doe.com",
                     "user_level"   => 1,
                     "code"         => "12345",
                     "created_at"   => null,
                     "updated_at"   => null));

TORM\Factory::define("admin",array(
                     "id"           => time(),
                     "name"         => "Mary Doe",
                     "email"        => "mary@doe.com",
                     "user_level"   => 1,
                     "code"         => "12345",
                     "created_at"   => null,
                     "updated_at"   => null),
                     array("class_name"=>"User"));

TORM\Factory::define("unnamed_user",array(
                     "id"           => time(),
                     "name"         => null,
                     "email"        => "mary@doe.com",
                     "user_level"   => 1,
                     "code"         => "12345",
                     "created_at"   => null,
                     "updated_at"   => null),
                     array("class_name"=>"User"));

TORM\Factory::define("crazy_user",array(
                     "id"           => time(),
                     "name"         => "Mary Doe",
                     "email"        => "mary@doe.com",
                     "user_level"   => 1,
                     "code"         => "12345",
                     "invalid_attr" => "invalid",
                     "created_at"   => null,
                     "updated_at"   => null),
                     array("class_name"=>"User"));
?>
