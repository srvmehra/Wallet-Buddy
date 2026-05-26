# Wallet-Buddy
The system simulates a simple financial flow where users maintain a wallet balance, place orders using that balance, and request withdrawals. Withdrawals are not processed immediately and must be handled by a background process.


# How to run
composer install
php artisan migrate --seed
php artisan serve
php artisan queue:work