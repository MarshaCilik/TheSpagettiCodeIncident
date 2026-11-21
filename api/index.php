<?php

// Pastikan direktori penyimpanan di /tmp sudah siap sebelum Laravel boot
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/database',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Inisialisasi SQLite database di /tmp jika belum ada
$dbFile = '/tmp/database/database.sqlite';
if (!file_exists($dbFile)) {
    // Copy existing database.sqlite jika ada
    $localDb = __DIR__ . '/../database/database.sqlite';
    if (file_exists($localDb)) {
        @copy($localDb, $dbFile);
    } else {
        @touch($dbFile);
    }
}

// Set environment database ke /tmp/database/database.sqlite
putenv("DB_DATABASE={$dbFile}");
$_ENV['DB_DATABASE'] = $dbFile;
$_SERVER['DB_DATABASE'] = $dbFile;

// Forward ke public/index.php
require __DIR__ . '/../public/index.php';
