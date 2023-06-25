#!/bin/bash
cd `dirname $0`/../..
if [ "$(uname)" == "Darwin" ]; then
  chmod +x local-php-security-checker-darwin
  ./local-php-security-checker-darwin
elif [ "$(expr substr $(uname -s) 1 5)" == "Linux" ]; then
  chmod +x local-php-security-checker-linux
  ./local-php-security-checker-linux
fi
