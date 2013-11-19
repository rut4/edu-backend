-- at the class

ALTER TABLE products
ADD UNIQUE INDEX SKU_INDEX (sku);

ALTER TABLE orders
ADD FOREIGN KEY (customer_id)
REFERENCES customers (customer_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

-- at the home

ALTER TABLE order_products
ADD FOREIGN KEY (product_id)
REFERENCES products (product_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE order_products
ADD FOREIGN KEY (order_id)
REFERENCES orders (order_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE orders
ADD FOREIGN KEY (seller_id)
REFERENCES sellers (seller_id)
ON DELETE CASCADE
ON UPDATE CASCADE;
