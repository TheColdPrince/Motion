<?php
declare(strict_types=1);

const MAX_UPLOAD = 536870912; // 512 MB

function json_error(string $message, int $status = 400): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => $message]);
    exit;
}
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_error('POST required.', 405);
if ((int)($_SERVER['CONTENT_LENGTH'] ?? 0) > MAX_UPLOAD) json_error('Recording is larger than 512 MB.', 413);
if (!isset($_FILES['video']) || !is_uploaded_file($_FILES['video']['tmp_name'])) json_error('No video recording received.');
if ((int)$_FILES['video']['size'] <= 0 || (int)$_FILES['video']['size'] > MAX_UPLOAD) json_error('Invalid recording size.');

$ffmpeg = find_ffmpeg();
if ($ffmpeg === null) json_error('FFmpeg is not installed, or PHP shell_exec is disabled.', 501);

$token = bin2hex(random_bytes(12));
$input = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "motion_studio_{$token}.input";
$output = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "motion_studio_{$token}.mp4";
if (!move_uploaded_file($_FILES['video']['tmp_name'], $input)) json_error('Could not store the temporary recording.', 500);

$command = escapeshellarg($ffmpeg)
    . ' -hide_banner -loglevel error -y -i ' . escapeshellarg($input)
    . ' -an -c:v libx264 -preset medium -crf 18 -pix_fmt yuv420p -movflags +faststart '
    . escapeshellarg($output) . ' 2>&1';
$log = (string)@shell_exec($command);
@unlink($input);

if (!is_file($output) || filesize($output) < 1024) {
    @unlink($output);
    json_error('FFmpeg could not create the MP4. ' . mb_substr(trim($log), 0, 500), 500);
}

header('Content-Type: video/mp4');
header('Content-Disposition: attachment; filename="motion-studio-export.mp4"');
header('Content-Length: ' . filesize($output));
header('Cache-Control: no-store');
readfile($output);
@unlink($output);
