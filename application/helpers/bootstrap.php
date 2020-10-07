<?php

if ($_ENV['DEBUG']) {
	$ttl = 1;
} else {
	$ttl = mt_rand(55, 65);
}

define('TTL', $ttl);
