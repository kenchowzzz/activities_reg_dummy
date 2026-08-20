#!/bin/sh
# Container startup:
#   1. generate a self-signed cert on first run (HTTPS is mandatory here)
#   2. best-effort make log/upload dirs writable
#   3. hand off to apache2-foreground
set -e

SSL_DIR=/etc/apache2/ssl
if [ ! -f "$SSL_DIR/server.crt" ]; then
    echo "[entrypoint] generating self-signed certificate for localhost ..."
    openssl req -x509 -nodes -newkey rsa:2048 -days 825 \
        -keyout "$SSL_DIR/server.key" \
        -out "$SSL_DIR/server.crt" \
        -subj "/CN=localhost" >/dev/null 2>&1
fi

# Writable dirs. Bind mounts from Windows may ignore chown; that's fine
# (Docker Desktop mounts are world-writable), hence the || true.
for d in \
    /var/www/html/application/logs \
    /var/www/upload; do
    [ -d "$d" ] && chown -R www-data:www-data "$d" 2>/dev/null || true
done

exec "$@"
