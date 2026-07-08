tar -xf wp-content.tar
sudo docker compose up -d
sleep 45
sudo docker compose exec -T db mysql -u root -psomewordpress wordpress < backup_correct.sql
sudo docker compose exec -T db mysql -u root -psomewordpress wordpress -e "UPDATE wp_options SET option_value = 'http://34.67.160.184' WHERE option_name IN ('siteurl', 'home');"
