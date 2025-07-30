How to Update the Site:

Most updates for the site can be done through the admin panel, such as adding and removing menu items, and deals, viewing and removing users, viewing and responding to support requests, and switching themes.
When adding menu items and deals you will need to add your image to the images folder of the code. To do this, simply drag and drop the image from your computer to the file. For example, drag and drop, or copy and paste the image from your downloads to the images folder.
If you can't find the images folder, it should be located in the JadePizza folder called images.

No other updates should be needed for the site!





MySQL Database:

The MySQL database for the site should be up to date and set up, unless you are using it on a new device.
There should be no need to adjust the database, as using the admin panel's options does it automatically. The databases also auto-update when new users register.

In case something happens to the database, or you are using it on a new device, please recreate the main folder (jade_pizza) and re-add the table structures listed below:
Note: If these tables are recreated, they will be empty and no longer hold any current information.

CREATE TABLE `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `deals` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `menu_item_id` INT(11) NOT NULL,
  `flat_price` DECIMAL(6,2) NOT NULL,
  `description` TEXT COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `fk_deals_menu_item` (`menu_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `deal_requirements` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `deal_id` INT(11) NOT NULL,
  `required_category` VARCHAR(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` INT(11) DEFAULT NULL,
  `required_size` VARCHAR(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `required_name` VARCHAR(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deal_id` (`deal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `menu_items` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` TEXT COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` VARCHAR(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_special` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `menu_item_sizes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `menu_item_id` INT(11) NOT NULL,
  `size` VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
  `price` DECIMAL(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_item_id` (`menu_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `subtotal` DECIMAL(10,2) DEFAULT NULL,
  `deal_discount` DECIMAL(10,2) DEFAULT NULL,
  `tax` DECIMAL(10,2) DEFAULT NULL,
  `total` DECIMAL(10,2) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `order_items` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `name` VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
  `size` VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` INT(11) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `site_themes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `theme` VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `support_requests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `subject` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` TEXT COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `response` TEXT COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` VARCHAR(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

If you wish to re-implement the existing data, please follow these steps for each table on your device: 

First move the existing code and databases to the folder you intend to use.
If you are going to use XAMPP for example, then your code will most likely go here: C:\xampp\htdocs, and your MySQL should go here: C:\xampp\mysql\data.
This is assuming you downloaded XAMPP to its default location.

Next, load up XAMPP or whichever platform you are using and create a new database called jade_pizza.

After that, make a backup copy of the MySQL data somewhere on your device, and create one table at a time using the structures above:

  CREATE TABLE `admins` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    `password` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

Creating the table will re-write the data files for that table saved in C:\xampp\mysql\data.
If the table already exists, please follow these steps:

  DROP TABLE IF EXISTS admins;

  CREATE TABLE `admins` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    `password` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

Once you have recreated the table you will need to discard the tablespace:

  ALTER TABLE admins DISCARD TABLESPACE;

Once you have done this, drag and drop the original files from your backup (.frm and .ibd) back into your file in XAMPP: C:\xampp\mysql\data\jade_pizza

After you have done this, import the tablespace:

  ALTER TABLE admins IMPORT TABLESPACE;

If all steps were followed correctly, then the data from the original files should show.

id    username    password
2     admin       $2y$10$GN10Ub2OTrxHiGO32rAJWOlZEDpQotOtdyanZJZwdJAh7GuifIdli