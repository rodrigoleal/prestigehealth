#!/bin/bash
echo "Setting up language and widgets..."

# 1. Install and activate Portuguese (Portugal)
wp language core install pt_PT --activate --allow-root
wp language plugin install --all pt_PT --allow-root
wp language theme install --all pt_PT --allow-root
wp site switch-language pt_PT --allow-root

# 2. Clear default sidebar widgets
for WIDGET_ID in $(wp widget list sidebar-1 --format=ids --allow-root); do
    wp widget delete $WIDGET_ID --allow-root
done

# 3. Add WooCommerce widgets to sidebar-1
wp widget add woocommerce_product_categories sidebar-1 1 --title="Categorias" --allow-root
wp widget add woocommerce_price_filter sidebar-1 2 --title="Filtrar por Preço" --allow-root
wp widget add woocommerce_layered_nav_filters sidebar-1 3 --title="Filtros Ativos" --allow-root

echo "Done."
