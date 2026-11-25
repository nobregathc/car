<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $res = Illuminate\Support\Facades\DB::table('sessions')->where('id', 'uO27OdXa2ZafMURLnjzTbrVGi2Uoil5LZDRC6IE7')->first();
    echo "SUCCESS SESSIONS QUERY\n";
    var_dump($res);
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
