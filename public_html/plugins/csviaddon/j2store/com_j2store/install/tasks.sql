DELETE FROM `#__csvi_availabletables` WHERE `component` = 'com_j2store';
INSERT IGNORE INTO `#__csvi_availabletables` (`task_name`, `template_table`, `component`, `action`, `enabled`) VALUES
('product', 'product', 'com_j2store', 'import', '0'),
('product', 'j2store_products', 'com_j2store', 'import', '1'),
('product', 'j2store_productfiles', 'com_j2store', 'import', '1'),
('product', 'j2store_productimages', 'com_j2store', 'import', '1'),
('product', 'j2store_variants', 'com_j2store', 'import', '1'),
('product', 'product', 'com_j2store', 'export', '0'),
('product', 'j2store_products', 'com_j2store', 'export', '1'),
('product', 'j2store_productfiles', 'com_j2store', 'export', '1'),
('product', 'j2store_productimages', 'com_j2store', 'export', '1'),
('product', 'j2store_variants', 'com_j2store', 'export', '1'),
('price', 'price', 'com_j2store', 'import', '0'),
('price', 'j2store_product_prices', 'com_j2store', 'import', '1'),
('price', 'price', 'com_j2store', 'export', '0'),
('price', 'j2store_product_prices', 'com_j2store', 'export', '1'),
('productfile', 'productfile', 'com_j2store', 'export', '0'),
('productfile', 'j2store_productfiles', 'com_j2store', 'export', '1'),
('productfile', 'productfile', 'com_j2store', 'import', '0'),
('productfile', 'j2store_productfiles', 'com_j2store', 'import', '1'),
('order', 'order', 'com_j2store', 'import', '0'),
('order', 'j2store_orders', 'com_j2store', 'import', '1'),
('order', 'j2store_orderinfos', 'com_j2store', 'import', '1'),
('order', 'order', 'com_j2store', 'export', '0'),
('order', 'j2store_orders', 'com_j2store', 'export', '1'),
('order', 'j2store_orderhistories', 'com_j2store', 'export', '1'),
('order', 'j2store_orderinfos', 'com_j2store', 'export', '1'),
('productimage', 'productimage', 'com_j2store', 'export', '0'),
('productimage', 'j2store_productimages', 'com_j2store', 'export', '1'),
('productimage', 'productimage', 'com_j2store', 'import', '0'),
('productimage', 'j2store_productimages', 'com_j2store', 'import', '1'),
('order', 'j2store_orderinfos', 'com_j2store', 'export', '1'),
('productfile', 'j2store_productfiles', 'com_j2store', 'import', '1'),
('orderitem', 'orderitem', 'com_j2store', 'export', '0'),
('orderitem', 'j2store_orderitems', 'com_j2store', 'export', '1'),
('orderitem', 'j2store_orderitemattributes', 'com_j2store', 'export', '1'),
('orderitem', 'orderitem', 'com_j2store', 'import', '0'),
('orderitem', 'j2store_orderitems', 'com_j2store', 'import', '1'),
('orderitem', 'j2store_orderitemattributes', 'com_j2store', 'import', '1'),
('productfilter', 'productfilter', 'com_j2store', 'export', '0'),
('productfilter', 'j2store_product_filters', 'com_j2store', 'export', '1'),
('productfilter', 'productfilter', 'com_j2store', 'import', '0'),
('productfilter', 'j2store_product_filters', 'com_j2store', 'import', '1'),
('orderitem', 'j2store_orderitemattributes', 'com_j2store', 'import', '1'),
('geozonerule', 'j2store_geozonerules', 'com_j2store', 'export', '1'),
('geozonerule', 'j2store_geozones', 'com_j2store', 'export', '1'),
('geozonerule', 'j2store_countries', 'com_j2store', 'export', '1'),
('geozonerule', 'j2store_zones', 'com_j2store', 'export', '1'),
('geozonerule', 'j2store_geozonerules', 'com_j2store', 'import', '1'),
('geozonerule', 'j2store_geozones', 'com_j2store', 'import', '1'),
('geozonerule', 'j2store_countries', 'com_j2store', 'import', '1'),
('geozonerule', 'j2store_zones', 'com_j2store', 'import', '1');


DELETE FROM `#__csvi_tasks` WHERE `component` = 'com_j2store';
INSERT IGNORE INTO `#__csvi_tasks` (`task_name`, `action`, `component`, `url`, `options`) VALUES
('product', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,product,layout,fields,limit.advancedUser'),
('product', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,product,image,fields,limit.advancedUser'),
('price', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,price,layout,fields,limit.advancedUser'),
('price', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,fields,limit.advancedUser'),
('productfile', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,layout,fields,limit.advancedUser'),
('productfile', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,productfile,fields,limit.advancedUser'),
('order', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,layout,custom_order,fields,limit.advancedUser'),
('order', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,order,fields,limit.advancedUser'),
('productfile', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,productfile,fields,limit.advancedUser'),
('orderitem', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,order_item,layout,fields,limit.advancedUser'),
('orderitem', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,fields,limit.advancedUser'),
('order', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,order,fields,limit.advancedUser'),
('productimage', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,layout,fields,limit.advancedUser'),
('productimage', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,productimage,image,fields,limit.advancedUser'),
('productfilter', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,layout,fields,limit.advancedUser'),
('productfilter', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,productfilter,fields,limit.advancedUser'),
('productimage', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,productimage,image,fields,limit.advancedUser'),
('geozonerule', 'export', 'com_j2store', 'index.php?option=com_j2store', 'source,file,layout,fields,limit.advancedUser'),
('geozonerule', 'import', 'com_j2store', 'index.php?option=com_j2store', 'source,file,fields,limit.advancedUser');