-- 1) query to show customer's order (define by ShopDB.Orders.person_id)
SELECT dest, order_date FROM ShopDB.Orders WHERE person_id = 1;

-- 2) query to show all the goods of order (define by order_id)
SELECT item_id, quantity, item_name, price FROM 
  ShopDB.CustomersCart INNER JOIN ShopDB.Goods 
  ON Goods.id = CustomersCart.item_id
  WHERE CustomersCart.order_id = 1
  ORDER BY Goods.id;

-- 3) query to show items inf. by an image
-- (define by an image - the second arg. of CONCAT fn.)
SELECT * FROM ShopDB.Goods WHERE item_image = CONCAT("styles/images/", "goods.jpg");

-- 4) insert queries

-- insert values for `Customers` table
INSERT INTO CustomersDB.Customers (initials, email, phone_number) VALUES
  ("Микола Тищенко", "tyshchenko-m@rada.gov.ua", "0442553476"),
  ("Піт Буттіджич", "info@peteforamerica.com", "5555262626"),
  ("Дімаш Кудайбергенов", "kudaibergenov.dimash@gmail.com", "72777797924");

-- insert values for `Goods` table
INSERT INTO ShopDB.Goods (item_name, prise, categories, item_image) VALUES
  ("Диво-капці", 88, "взуття, домашнє, одяг", "styles/images/goods.jpg"),
  ("Костюм телепузика", 226, "одяг, костюм, розваги, для дітей", "styles/images/goods2.jpg"),
  ("диск \"Зелений слоник", 1275, "фільми, драма, мистецтво", "styles/images/goods3.jpg"),
  ("футболка \"Титанік", 79, "фільми, одяг, ганчірка для швабри", "styles/images/goods4.jpg");

-- insert values for `Orders` table
INSERT INTO ShopDB.Orders (dest, person_id) VALUES
  ("Україна, Київ", 1),
  ("Україна, Бровари", 1),
  ("США, Індіана, Саут-Бенд", 2),
  ("Казахстан, Нур-Султан", 3);

-- insert values for `CustomersCart` table
INSERT INTO ShopDB.CustomersCart (order_id, item_id, quantity) VALUES
	(1, 4, 12), (1, 1, 3),
  (2, 3, 200),
  (3, 2, 4), (3, 4, 1), (3, 3, 22);