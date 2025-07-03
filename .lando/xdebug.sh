#!/bin/bash

if [ "$#" -ne 1 ]; then
  echo "Xdebug has been turned off, please use the following syntax: 'lando xdebug <mode>'."
  echo "Valid modes: https://xdebug.org/docs/all_settings#mode."
  echo xdebug.mode = off > /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  pkill -o -USR2 php-fpm
else
  mode="$1"
  echo xdebug.mode = "$mode" > /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  echo zend_extension=xdebug >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  echo xdebug.start_with_request = yes >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  echo xdebug.client_port = 9003 >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  echo memory_limit = 4000M  >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  echo upload_max_filesize = 4000M  >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  echo post_max_size = 4000M  >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  echo max_file_uploads = 100 >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  pkill -o -USR2 php-fpm
  echo "Xdebug is loaded in "$mode" mode."
fi
