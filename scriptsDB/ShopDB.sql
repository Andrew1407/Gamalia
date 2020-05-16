CREATE DATABASE ShopDB DEFAULT CHARSET cp1251;

CREATE TABLE Goods (
  id INT AUTO_INCREMENT,
  item_name VARCHAR(40) NOT NULL,
  categories VARCHAR(40) NOT NULL,
  price DECIMAL(13, 2) NOT NULL,
  item_image VARCHAR(80) NOT NULL,
  discount DECIMAL(4, 2) DEFAULT 0,
  owner_id INT NOT NULL,
  FOREIGN KEY(owner_id)
    REFERENCES CustomersDB.Customers(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  PRIMARY KEY(id)
);

CREATE TABLE Orders (
  id INT AUTO_INCREMENT,
  dest VARCHAR(80) NOT NULL,
  order_date DATETIME DEFAULT now(),
  person_id INT NOT NULL,
  FOREIGN KEY(person_id)
    REFERENCES CustomersDB.Customers(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  PRIMARY KEY(id)
);

CREATE TABLE CustomersCart (
  quantity INT DEFAULT 1,
  item_id INT NOT NULL,
  order_id INT NOT NULL,
  FOREIGN KEY(item_id)
    REFERENCES Goods(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY(order_id)
    REFERENCES Orders(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- table for temporary items in cart
CREATE TABLE CartTemp (
  id INT AUTO_INCREMENT,
  person_id INT NOT NULL,
  item_id INT NOT NULL,
  dest VARCHAR(80) NOT NULL,
  quantity INT DEFAULT 1,
  FOREIGN KEY(person_id)
    REFERENCES CustomersDB.Customers(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY(item_id)
    REFERENCES Goods(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  PRIMARY KEY(id)
);
