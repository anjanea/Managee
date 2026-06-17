<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    Illuminate\Http\Request::capture()
);

echo "Total Properties: " . \App\Models\Property::count() . "\n";
foreach (\App\Models\Property::all() as $p) {
    echo "ID: {$p->id} | Title: {$p->title}\n";
}
