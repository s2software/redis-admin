#!/usr/bin/env bash

# Exec with:
# chmod +x build-push.sh && ./build-push.sh

# Build production images from Dockerfile
docker build -t s2software/redis-admin:latest .

# Push to Remote Registry (requires "docker login")
docker push s2software/redis-admin:latest
