CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `qty_stock` int(11) NOT NULL,
  `dt_sales` timestamp DEFAULT CURRENT_TIMESTAMP,
  `amount_sales` decimal(10,0),
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;


INSERT INTO `products` (`product_id`, `name`, `amount`, `qty_stock`, `dt_sales`, `amount_sales`) VALUES
(1, 'Dell Inspirion', '4000.0', 3, null, '336'),
(2, 'MacBook Air', '7000.0', 0, '2020-08-03 01:12:26', '336')