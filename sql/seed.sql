USE cafe_elfirdaous;
-- Default password is password. Change it immediately after first login.
INSERT INTO users(username,password,full_name,role) VALUES ('admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','مدير النظام','admin');
INSERT INTO settings(setting_key,setting_value) VALUES ('cafe_name','مقهى الفردوس'),('currency','د.م'),('tax_enabled','0');
INSERT INTO categories(name) VALUES ('قهوة'),('عصائر'),('مشروبات'),('مأكولات');
INSERT INTO products(category_id,name,cost,price) VALUES (1,'قهوة نص نص',3.00,10.00),(1,'إسبريسو',2.50,8.00),(2,'عصير برتقال',5.00,15.00),(3,'ماء معدني',1.50,5.00);
INSERT INTO customer_tiers(name,discount_percent,first_order_points,order_threshold,threshold_points,point_value) VALUES ('عادي',0,1,5,3,0.10),('فضي',5,2,5,5,0.15),('ذهبي',10,3,5,8,0.20);
INSERT INTO expense_categories(name) VALUES ('الكراء'),('الكهرباء والماء'),('المشتريات'),('أخرى');
