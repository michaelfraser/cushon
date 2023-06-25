#!/bin/bash

set -e

cd "${PROJECT_ROOT}"

mkdir -p var/{cache,log,sessions}
chmod -R 777 var/{cache,log,sessions}

sed -i 's/^    AllowOverride None/    AllowOverride All/' /etc/httpd/conf/httpd.conf
sed -i 's/^    AllowOverride none/    AllowOverride All/' /etc/httpd/conf/httpd.conf

exec "$@"
