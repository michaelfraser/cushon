#!/bin/bash

if env | grep http_proxy= | grep -q 'http://192.168.222.6:3128'; then
    echo "Proxy [http_proxy] is on."
    exit 1
elif env | grep https_proxy= | grep -q "http://192.168.222.6:3128"; then
    echo "Proxy [https_proxy] is on."
    exit 1
fi

echo "Proxy is off."
exit 0