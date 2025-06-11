

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
    `cart_id` int(100) NOT NULL,
    `user_id` int(100) NOT NULL,
    `p_id` int(100) NOT NULL,
    `p_name` varchar(255) NOT NULL,
    `p_img` varchar(255) NOT NULL,
    `qty` int(100) NOT NULL,
    `p_price` int(100) NOT NULL,
    `p_desc` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `category` (
    `c_id` int(100) NOT NULL,
    `c_name` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `orders` (
    `order_id` int(100) NOT NULL,
    `user_id` int(100) NOT NULL,
    `total` int(100) NOT NULL,
    `pre_name` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `mno` varchar(255) NOT NULL,
    `address1` varchar(255) NOT NULL,
    `address2` varchar(255) NOT NULL,
    `city` varchar(255) NOT NULL,
    `state` varchar(255) NOT NULL,
    `zip` int(100) NOT NULL,
    `country` varchar(255) NOT NULL,
    `payment` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `products` (
    `p_id` int(30) NOT NULL,
    `p_name` varchar(255) NOT NULL,
    `p_img` varchar(255) NOT NULL,
    `p_mrp` int(100) NOT NULL,
    `p_price` int(100) NOT NULL,
    `p_desc` varchar(255) NOT NULL,
    `c_id` int(100) NOT NULL,
    `qty` int(100) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `testimonial` (
    `testimonial_id` int(50) NOT NULL,
    `name` varchar(255) NOT NULL,
    `testimonial_data` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
    `user_id` int(100) NOT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Table structure for table `admins`

CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
    `wish_id` int(100) NOT NULL,
    `user_id` int(100) NOT NULL,
    `p_id` int(100) NOT NULL,
    `p_name` varchar(255) NOT NULL,
    `p_img` varchar(255) NOT NULL,
    `qty` int(100) NOT NULL,
    `p_price` int(100) NOT NULL,
    `p_desc` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    user_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
);


--
-- Indexes for table `cart`
--
ALTER TABLE `cart` ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category` ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders` ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products` ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial` ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form` ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist` ADD PRIMARY KEY (`wish_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 57;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `c_id` int(100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `p_id` int(30) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 26;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
MODIFY `testimonial_id` int(50) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
MODIFY `wish_id` int(100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 29;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;