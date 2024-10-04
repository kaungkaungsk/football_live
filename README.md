# Football Live

> crontab - e

```
*/5 * * * * php /var/www/football_live/artisan kkdev:scrape-now
```
<!-- */5 * * * * php /var/www/football_live/artisan refresh:third-party-live -->
<!-- 0 */1 * * * python3 /var/www/football_live/highlight_crawler -->
> systemctl enable cron
> systemctl start cron
