#!/bin/bash

echo "status all" | bconsole | awk '$2 ~ /Full/ || $2 ~ /Incr/' | awk '$6 ~ /Error/ || $5 ~ /Error/'
