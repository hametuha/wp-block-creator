#!/usr/bin/env bash

set -e

# Remove unwanted files.
rm -rf .git
rm -rf .gitignore
rm -rf .travis.yml
rm -rf bin
rm -rf vendor
rm -rf tests
rm -rf composer.lock
rm -rf phpunit.xml.dist
