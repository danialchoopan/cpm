<?php
session_start();
$dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(dirname(__DIR__))));
$dotenv->load();