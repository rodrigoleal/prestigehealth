#!/bin/bash
curl -s -o /tmp/logo.png "https://prestigehealth.pt/wp-content/uploads/2022/12/prestige-solucoes-saude-Prestige-Health-Solucoes-de-Saude-150x81.png"
id=$(wp media import /tmp/logo.png --porcelain)
wp theme mod set custom_logo $id
