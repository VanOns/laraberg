#!/usr/bin/env bash
path="../public/js/laraberg.js"
cmd="php -d memory_limit=2048M artisan vendor:publish --provider='VanOns\Laraberg\LarabergServiceProvider' --tag='public' --force"

eval $cmd
echo "Watching $path for changes..."

fswatch -0 $path | while read -d "" event;
do
  echo "File update detected!"
  eval $cmd
done
