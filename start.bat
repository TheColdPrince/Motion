@echo off
where php >nul 2>nul
if errorlevel 1 (
  echo PHP is required. Install PHP first.
  pause
  exit /b 1
)
echo Motion Studio: http://127.0.0.1:8080/
echo Press Ctrl+C to stop.
php -S 127.0.0.1:8080 -t "%~dp0"
