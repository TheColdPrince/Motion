<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function find_ffmpeg(): ?string {
    if (!function_exists('shell_exec')) return null;
    $disabled = array_filter(array_map('trim', explode(',', (string)ini_get('disable_functions'))));
    if (in_array('shell_exec', $disabled, true)) return null;
    $found = trim((string)@shell_exec('command -v ffmpeg 2>/dev/null'));
    if ($found !== '' && is_executable($found)) return $found;
    foreach (['/usr/bin/ffmpeg','/usr/local/bin/ffmpeg'] as $path) {
        if (is_executable($path)) return $path;
    }
    return null;
}

echo json_encode([
    'ok' => true,
    'ffmpeg' => find_ffmpeg() !== null,
    'php' => PHP_VERSION,
]);
