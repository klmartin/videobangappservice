#!/bin/bash
cd /var/www/AFYACHAPInternalSystem || exit
echo "-------------------------------------";
echo "   AFYA CHAP Seed Service Request ID ";
echo "-------------------------------------";
echo "                 START               ";
echo "-------------------------------------";
php artisan seed:service-request-id 1
php artisan seed:service-request-id 2
php artisan seed:service-request-id 3
echo "-------------------------------------";
echo "                 END               ";
echo "-------------------------------------";