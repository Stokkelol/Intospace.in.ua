## Official Documentation

Intospace.in.ua source code. Powered by Laravel 5.2.

sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
sudo systemctl status supervisor shows supervisor's status itself
sudo supervisorctl status shows running workers
To restart queue (need to run if jobs code was changed): php artisan queue:restart

Commands for Telegram bot:
help - help page
stop - stop broadcasting messages
start - start broadcasting messages
youtube - youtube search. example - /youtube slayer 
latest - latest 5 posts
blackmetal - random black metal post
deathmetal - random death metal post
sludge - random sludge post
technicaldeathmetal - random tech death metal post
sludgedoom - random sludgedoom post
experimental - random experimental post
psychedelic - random psychedelic post
doommetal - random doom metal post
src/Illuminate/Bus/Dispatcher.php(94): Illuminate\Container\Container->call(Array)