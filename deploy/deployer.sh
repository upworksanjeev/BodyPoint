# GIT MERGE OPTIONS DEPENDING HOSTING OR DEPLOYMENT PROVIDERS
# git checkout -- .
# git checkout .
# git merge
# php artisan down || true

# Put the application into maintenance / demo mode
php artisan down

# GIT Clear current generated files so can pull new ones
#git reset --hard
#git clean -df

# Pull the branch
# replace {branch} with your branch name like master or main


git pull origin main

# Optimizes PSR0 and PSR4 packages to be loaded with classmaps too, good for production.
composer dump-autoload -o

# Composer install for production without dev dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Migration Forced
php artisan migrate --force

# Flush expired password reset tokens
php artisan auth:clear-resets

# Remove the compiled class file
php artisan clear-compiled

# Remove the cached bootstrap files
php artisan optimize:clear

# Clear all compiled view files
php artisan view:clear

# Flush the application cache
php artisan cache:clear

# Remove the route cache file
# NOTE: Sometimes gives error for API route
php artisan route:clear

# Remove the configuration cache file
php artisan config:clear

# Create a cache file for faster configuration loading
# Done first for faster future oprations
php artisan config:cache

# Create a route cache file for faster route registration
# NOTE: Sometimes gives error for API route
php artisan route:cache

# Compile all of the application's Blade templates
php artisan view:cache

# NPM OR YARN (Whichever you use)

#NPM install and run for production
# npm install --only=prod
#npm ci
#npm run production

# YARN Install and Run for the production
# yarn --production=true
# yarn run production

# NOTE: Sometimes gives error for API route
php artisan optimize

# Restart queue worker daemons after their current job
php artisan queue:restart

# Optimizes PSR0 and PSR4 packages to be loaded with classmaps too, good for production.
composer dump-autoload -o

#sudo chmod -R 777 storage

#sudo chmod -R 777 bootstrap

# Bring the application out of maintenance mode
php artisan up
