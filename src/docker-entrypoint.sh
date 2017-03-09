#!/usr/bin/env bash

cd /var/www/html/
git pull

/usr/sbin/sshd
tail -f /etc/hosts

