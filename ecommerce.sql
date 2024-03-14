-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 06:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', 'admin', 'jhag2491@gmail.com'),
(2, 'sam', 'sam123', 'jhagovind278@gamil.com');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `product_id`, `quantity`, `price`) VALUES
(117, 2, 40, 2, 379),
(118, 2, 40, 1, 379),
(131, 29, 33, 1, 149);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(9, 'Home Appliances', 'Shop for Home Appliances Online at Best Price. Choose from AC, Refrigerator, air cooler & more. Get Flexible EMI options & free home delivery from PROTO.'),
(20, 'Headphones', 'Headphones- Upto 80% Off on Headphones Online. Choose from a wide range of Headphones on proto.com. Free Shipping, Cash on Delivery, EMI Offers.'),
(21, 'chargers', 'Mobile Chargers & Cables: Buy Latest Mobile Chargers at Amazon.in. Choose from a wide range of Mobile Chargers from major brands '),
(18, 'Laptops', 'Get Best Laptop Prices Online in India. Choose from Ultra-thin Laptop, Gaming Laptop from brands like HP, Dell, Lenovo, Acer, and avail great offers.\r\n₹29,999.00 to ₹1,39,999.00 · '),
(22, 'Mobile Accessories  ', 'Some of the best accessories for a phone include a mobile projector, a portable phone charger, a phone case that\'s made from natural materials'),
(6, 'Mobile phones', 'Shop for Android, iOS, Dual-SIM mobiles & More. Brand Warranty. Pay COD. No Cost EMI Available. Top Brands. Best Deals. Huge Selection. Great Offers. Easy & Fast Delivery. Low Prices.'),
(23, 'Laptop Accessories', 'Browse through other laptop accessories like screen guards, batteries, number pads, and many more to find the right accessory'),
(24, 'Computer', 'Core i5 Desktop Complete Computer System Full Setup for Home & Business'),
(26, 'Wearables', 'Shop for Wearable Devices online at proto. Checkout wide range selection of Wearable Devices such as activity trackers, action cameras, smartwatches');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon` varchar(255) NOT NULL,
  `discount` int(50) NOT NULL,
  `customers` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon`, `discount`, `customers`) VALUES
(1, 'shrusti30', 30, NULL),
(2, 'DIWALI20', 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` int(50) DEFAULT 0,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `image`, `gender`, `email`, `password`, `address`, `pincode`, `phone_number`) VALUES
(30, 'prach', '1708585769OIP (3).jpeg', 'Female', 'prachiblohar@gmail.com', 'prachi', 'kuch bhiiiii ', 0, '1234565434'),
(29, 'Jaadu', '1708316746OIP (3).jpeg', 'Female', 'chaudharyshrusti@gmail.com', 'jaadu', 'kachigam, nani daman', 396210, '08849845813');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `pincode` int(50) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`address_id`, `customer_id`, `name`, `email`, `address`, `pincode`) VALUES
(1, 15, 'Harshal Patil', 'harshal@gmail.com', 'D-103 Chandramani residency Chankheda Ahemdabad - 382424', 0),
(2, 2, 'Govind Jha', 'jhag2491@gmail.com', 'D-103 Chandramani Residency Chankheda Ahemdabad - 382424', 0),
(3, 3, 'Shrusti Jha', 'chaudharyshrusti@gmail.com', '505 shriram Bhavan Residency  nehru street Vapi Town Vapi - 396191', 0),
(4, 13, 'Jaynesh Mehta', 'jaynesh@gmail.com', 'D-103 Chandramani Chankheda Ahmedabad -382423', 0),
(5, 16, 'Rahulraj Singh', 'rahulraj@gmail.com', 'D-103 Chandramani residensy chankheda Ahmedabad Gujarat - 382424', 0),
(6, 17, 'Vaibhav Gupta', 'vaibhav@gmail.com', 'D-103 Chandramani Residency Chankheda Ahemdabad - 382424', 0),
(7, 18, 'Vignesh ', 'vigneshvenkatesan44535@gmail.com', 'Radixweb', 0),
(8, 19, 'Dhruvi Patel', 'dhruvi22may2000@gmail.com', 'Ahmedabad', 0),
(9, 20, 'Khushboo Jha', 'khushboo@gmail.com', '406,Shri Ram Bhavan Society Near Nehru Street Vapi Town Gujarat - 396191', 0),
(10, 21, 'Shivani Jha', 'shivani@gmail.com', '406,Shri Ram Bhavan Society Near Nehru Street Vapi Town Gujarat - 396191', 0),
(11, 22, 'temp', 'temp@gmail.com', '505 shriram appartnment\r\nNahru street', 0),
(12, 23, 'temp2', 'temp2@gmail.com', '505 shriram appartnment\r\nNahru street', 0),
(13, 24, 'GOVIND U. JHA', 'jhag2491@gmail.com', '505 shriram appartnment\r\nNahru street', 0),
(14, 25, 'UGANT JHA', 'jhag2491@gmail.com', '505 shriram appartnment\r\nNahru street', 0),
(15, 26, 'GOVIND UGANT JHA', 'jhag2491@gmail.com', '505 shriram appartnment\r\nNahru street', 0),
(16, 27, 'GOVIND UGANT JHA', 'jhag2491@gmail.com', '505 shriram appartnment\r\nNahru street', 0),
(17, 28, 'chandra chod ', 'chaudharyshrusti1122@gmail.com', '505 shriram appartnment\r\nNahru street', 0),
(18, 29, 'Jaadu', 'chaudharyshrusti@gmail.com', 'kachigam, nani daman', 0),
(19, 30, 'prach', 'prachiblohar@gmail.com', 'kuch bhiiiii ', 0),
(20, 29, 'Jaadu', 'chaudharyshrusti@gmail.com', 'kuch bhiiiii', 326210);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_status` enum('0','1') DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `product_id`, `quantity`, `order_date`, `total_amount`, `order_status`, `address_id`) VALUES
(14, 2, 30, 1, '2023-05-23', 3999.00, '1', 0),
(13, 2, 26, 2, '2023-05-23', 225980.00, '1', 0),
(24, 2, 20, 4, '2023-05-25', 267960.00, '1', 0),
(23, 2, 26, 1, '2023-05-24', 112990.00, '1', 0),
(22, 2, 20, 2, '2023-05-24', 133980.00, '1', 0),
(21, 3, 14, 2, '2023-05-23', 103998.00, '1', 0),
(20, 2, 14, 2, '2023-05-23', 103998.00, '1', 0),
(19, 3, 23, 2, '2023-05-23', 21998.00, '1', 0),
(18, 2, 14, 2, '2023-05-23', 103998.00, '1', 0),
(16, 2, 14, 10, '2023-05-23', 519990.00, '1', 0),
(15, 2, 24, 2, '2023-05-23', 9998.00, '1', 0),
(25, 2, 20, 3, '2023-05-25', 200970.00, '1', 0),
(26, 2, 22, 2, '2023-05-26', 70380.00, '1', 0),
(65, 2, 17, 1, '2023-06-16', 10999.00, '1', 0),
(64, 2, 14, 1, '2023-06-16', 51999.00, '1', 0),
(63, 2, 14, 1, '2023-06-16', 51999.00, '1', 0),
(32, 3, 14, 2, '2023-05-29', 103998.00, '1', 0),
(62, 2, 14, 2, '2023-06-16', 103998.00, '1', 0),
(61, 2, 14, 1, '2023-06-16', 51999.00, '1', 0),
(60, 2, 15, 2, '2023-06-16', 181998.00, '1', 0),
(59, 2, 15, 2, '2023-06-16', 181998.00, '1', 0),
(58, 2, 14, 1, '2023-06-14', 51999.00, '1', 0),
(57, 2, 15, 1, '2023-06-14', 90999.00, '1', 0),
(56, 2, 28, 2, '2023-06-09', 81998.00, '1', 0),
(55, 2, 39, 6, '2023-06-09', 534.00, '1', 0),
(41, 2, 40, 3, '2023-06-01', 1137.00, '1', 0),
(42, 2, 42, 2, '2023-06-01', 1198.00, '1', 0),
(43, 2, 37, 6, '2023-06-01', 7794.00, '1', 0),
(44, 2, 42, 5, '2023-06-01', 2995.00, '1', 0),
(45, 2, 21, 3, '2023-06-01', 164970.00, '1', 0),
(46, 2, 19, 5, '2023-06-01', 94995.00, '1', 0),
(47, 2, 44, 2, '2023-06-01', 93980.00, '1', 0),
(48, 2, 44, 1, '2023-06-01', 46990.00, '1', 0),
(49, 18, 36, 2, '2023-06-02', 5598.00, '1', 0),
(50, 2, 20, 6, '2023-06-05', 401940.00, '1', 0),
(54, 2, 39, 2, '2023-06-08', 178.00, '1', 0),
(66, 2, 22, 1, '2023-06-16', 35190.00, '1', 0),
(67, 2, 26, 1, '2023-06-16', 112990.00, '1', 0),
(68, 2, 26, 1, '2023-06-16', 112990.00, '1', 0),
(69, 2, 26, 1, '2023-06-16', 112990.00, '1', 0),
(70, 2, 17, 1, '2023-06-16', 10999.00, '1', 0),
(71, 2, 43, 1, '2023-06-16', 20000.00, '1', 0),
(72, 2, 29, 1, '2023-06-16', 1499.00, '1', 0),
(73, 2, 33, 1, '2023-06-16', 149.00, '1', 0),
(74, 2, 39, 2, '2023-06-16', 178.00, '1', 0),
(75, 2, 43, 2, '2023-06-16', 40000.00, '1', 0),
(76, 2, 43, 2, '2023-06-16', 40000.00, '1', 0),
(77, 2, 26, 2, '2023-06-16', 225980.00, '1', 0),
(78, 2, 29, 1, '2023-06-16', 1499.00, '1', 0),
(79, 20, 25, 1, '2023-06-16', 25999.00, '1', 0),
(80, 20, 32, 2, '2023-06-16', 498.00, '1', 0),
(81, 2, 29, 1, '2023-09-12', 1499.00, '1', 0),
(82, 2, 29, 1, '2023-09-12', 1499.00, '1', 0),
(83, 2, 40, 1, '2024-02-18', 379.00, '1', 0),
(84, 29, 25, 1, '2024-02-19', 25999.00, '1', 0),
(85, 29, 30, 2, '2024-02-22', 7998.00, '1', 0),
(86, 29, 17, 1, '2024-02-22', 10999.00, '1', 0),
(87, 29, 16, 1, '2024-02-22', 109999.00, '1', 0),
(88, 29, 45, 1, '2024-02-22', 1399.00, '1', 0),
(89, 29, 45, 1, '2024-03-05', 1399.00, '0', NULL),
(90, 29, 45, 1, '2024-03-05', 1399.00, '0', NULL),
(91, 29, 32, 1, '2024-03-05', 249.00, '0', NULL),
(92, 29, 25, 1, '2024-03-06', 25999.00, '0', NULL),
(93, 29, 17, 1, '2024-03-06', 10999.00, '0', NULL),
(94, 29, 30, 1, '2024-03-11', 3999.00, '0', NULL),
(95, 29, 17, 1, '2024-03-11', 10999.00, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_date` datetime NOT NULL,
  `amount` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `summary` tinytext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `summary`, `description`, `price`, `quantity`, `category_id`, `image`) VALUES
(19, 'Oppo A78 5G', 'Oppo A78 5G (Glowing Black, 8GB RAM, 128 Storage) | 5000 mAh Battery with 33W SUPERVOOC Charger| 50MP AI Camera | 90Hz Refresh Rate', 'Big 5000 mAh Battery with 33W SUPERVOOC Charging\r\nSuper smooth experience with ColorOS 13 and 8GB RAM (+ RAM expansion up to 8GB) | 128GB ROM | Expandable Upto 1TB\r\nCrystal clear details with AI Camera setup 50MP + 2MP Rear Camera | 8MP Front Camera\r\nOPPO Glow Design with 6.56\" inch (16.66cm) 90Hz Color-Rich Display and Large Screen to Body ratio of 89.8%\r\nDual Ultra Linear Stereo Speakers with ROST and flagship hardware which produce an immersive sound effect', 18999.00, 0, 6, '1684825231Oppo A78 5G.webp'),
(20, 'AmazonBasics 564 L', 'AmazonBasics 564 L Frost Free Side-by-Side Refrigerator with Water Dispenser (Silver Steel Finish)', 'The star rating changes are as per BEE guidelines on or before 1st Jan 2023;Side-by-side refrigerator with Water Dispenser and Auto Defrost technology that prevents excess ice build up automatically\r\n564 L capacity: Suitable for the daily requirements of a family with 5 or more members; Please note that Left side of the refrigerator is Freezer & right side is regular Fridge;Warranty: 1 year on product & 5 years on compressor for malfunction arising from manufacturing defects. For claiming warranty, A) Go to \'Your orders\' section, B) select the product, C) Click on Get product support and D) schedule an appointment. No need to call anyone and wait in a queue. Hassle free process. Paperless Experience with complete visibility to every step of your warranty claim.\r\nMulti airflow system ensures smooth airflow into the storage compartments for uniform cooling; Comes with in-built LED Display Panel that allows instant control and access to the temperature settings, making it convenient and easy to use\r\nOne gas refill/top-up will be provided free of cost during the first year of warranty post which they will be chargeable\r\nModel Name: 564 L Ab2019rf005; Warranty Description: Free Warranty - 1 Year On Product & 5 Years On Compressor For Malfunction Arising From Manufacturing Defects. For Claiming Warranty, A) Go To \'Your Orders\' Section, B) Select The Product, C) Click On Get Product Support And D) Schedule An Appointment. No Need To Call Anyone And Wait In A Queue. Hassle Free Process. Paperless Experience With Complete Visibility To Every Step Of Your Warranty Claim; Shelf Type: Toughened Glass; Specification Met: Energy Star', 66990.00, 0, 9, '1684825335AmazonBasics 564 L Frost Free Side-by-Side Refrigerator.jpg'),
(14, 'Apple iPhone 13 ', 'iPhone 13 family with its powerful new A14 Bionic processor, a Super Retina XDR display, a more durable Ceramic Shield front cover, and a MagSafe feature for more reliable wireless charging, and support for attachable accessories.', '15 cm (6.1-inch) Super Retina XDR display\r\nCinematic mode adds shallow depth of field and shifts focus automatically in your videos\r\nAdvanced dual-camera system with 12MP Wide and Ultra Wide cameras; Photographic Styles, Smart HDR 4, Night mode, 4K Dolby Vision HDR recording\r\n12MP TrueDepth front camera with Night mode, 4K Dolby Vision HDR recording\r\nA15 Bionic chip for lightning-fast performance', 51999.00, 0, 6, '1684824610Apple iPhone 13 (128GB) - (Product) RED.jpg'),
(15, 'Iphone 14 pro', 'iPhone 14 family with its powerful new A14 Bionic processor, a Super Retina XDR display, a more durable Ceramic Shield front cover, and a MagSafe feature for more reliable wireless charging, and support for attachable accessories.', '15.54 cm (6.1-inch) Super Retina XDR display featuring Always-On and ProMotion\r\nDynamic Island, a magical new way to interact with iPhone\r\n48MP Main camera for up to 4x greater resolution\r\nCinematic mode now in 4K Dolby Vision up to 30 fps\r\nAction mode for smooth, steady, handheld videos\r\nAll-day battery life and up to 23 hours of video playback', 90999.00, 0, 6, '1684824705Apple iPhone 14 Pro (128 GB) - Deep Purple.jpg'),
(16, 'Iphone 14 pro max', 'iPhone 14 family with its powerful new A14 Bionic processor, a Super Retina XDR display, a more durable Ceramic Shield front cover, and a MagSafe feature for more reliable wireless charging, and support for attachable accessories.', '17.00 cm (6.7-inch) Super Retina XDR display featuring Always-On and ProMotion\r\nDynamic Island, a magical new way to interact with iPhone\r\n48MP Main camera for up to 4x greater resolution\r\nCinematic mode now in 4K Dolby Vision up to 30 fps\r\nAction mode for smooth, steady, handheld videos\r\nAll-day battery life and up to 29 hours of video playback\r\nVital safety technology — Crash Detection can detect a severe car crash and call for help', 109999.00, 2, 6, '1684824792Apple iPhone 14 Pro Max (256 GB) - Deep Purple.jpg'),
(17, 'Realme Narzo N55', 'MediaTek Helio G88 Chipset. Processor ; 64MP AI Camera | 8MP Selfie Camera. Camera ; 33W SUPERVOOC Charge | 5000mAh Massive Battery.', '* With fast 33W SUPERVOOC charging, the realme narzo N55 charges up the massive 5000mAh battery from 0-50% in just 29 minutes, making your life super convenient and stress free.\r\n* Super High-res 64MP primary AI camera allows you to shoot crisp and clear shots in any scenario with incredible detail. The flagship grade ProLight Imaging technology brings segment leading low light performance to the N55.\r\n* Large 6.72” Full screen display on the narzo N55 provides a segment leading display with a centre punch hole display, 90Hz ultra smooth refresh rate, 680nits of peak brightness, and 91.4% screen-to-Body ratio.\r\n* Flagship grade premium two tone design makes the N55 stand out from the crowd. The 7.89mm thin beauty feels easy to hold and light weight to carry around easily.', 10999.00, 0, 6, '1684824885realme narzo N55.jpg'),
(21, 'Godrej 564 L ', 'Godrej 564 L Multi Air Flow System, With Advanced Controls Frost Free Side-By-Side Refrigerator(RS EONVELVET 579 RFD PL ST, Platinum Steel)', 'Multi airflow system: An intelligent and evenly distributed air system is inbuilt in both the fridge and the freezer section, maintaining a constant, optimal temperature throughout and keeping your food consistently chilled to perfection;Super Freeze Function can quickly lower frozen temperature and freeze your food much faster than usual\r\nRemovable Twist Ice Maker: A removable ice maker with a twistable knob which gives you perfectly formed ice cubes every time;XXL Door Balcony: Taller items like 2-litre soda bottles can be easily accommodated in the large door pockets\r\nBigger Drawers: The bigger drawers provide extra storage space, allowing you to accommodate a greater number of food items easily in the refrigerator;Bright LED Lighting: LED lighting design is deeper and wider, providing clear illumination\r\nShelf Type: Glass; Fresh Food Capacity: 348.0; Pattern Name: Solid; Freezer Capacity: 216.0; Finish Type: Glossy', 54990.00, 0, 9, '1684825424Godrej 564 L Multi Air Flow System.jpg'),
(22, 'Whirlpool 330 L', 'Whirlpool 330 L Frost-Free Multi-Door Refrigerator (FP 343D PROTTON ROY, Steel Onyx, 2022 Model)', 'Frost Free Refrigerator : Auto defrost function to prevent ice-build up\r\nCapacity 330 litres: Suitable for families with 3 to 4 members\r\nEnergy Rating : Uses Less Energy Than a CFL\r\nManufacturer warranty: 1 year on product, 10 years on compressor\r\nInverter Compressor – Energy efficient, silent operation & more durable\r\nShelf type: Toughened glass shelves', 35190.00, 7, 9, '1684825509Whirlpool 330 L Frost-Free Multi-Door Refrigerator.jpg'),
(23, 'wallmart Rice Cooker', 'A basic electric rice cooker often comes with a one-touch operation.', 'Rice Cooker 1.8 Litre Comes with Strong and Sturdy Body\r\nRice Cooker 1.8 Liter is sutiable for 4 to 5 persons\r\nStainless Steel Lid with Cool Touch handle\r\n700 Watt Rice cooker Preserves nutrients with Slow Cooking\r\nMicro Switch Control to Keep your food warm uo to 5 Hours', 10999.00, 4, 9, '1684825738pngwing.com (38).png'),
(24, 'Bajaj Mixter', 'Bajaj Mixer Grinders feature powerful motors from 500 W to 750 W with a 30-minute power rating to ensure consistent performance. Its multiple jars', 'No of Jars: 3; Jar Size: 1.20 Litre liquidizing jar, 0.8 Litre multi purpose jar, 0.3 Litre chutney jar; Jar Material: Stainless Steel; Body Material: ABS; Cord Material: PVC; Blade Material: Stainless Steel; Speed Control: 3 speed control with incher for momentary operation\r\nMotor Warranty: 1; Product Warranty: 1\r\nDo not worry if you experience some burning smell when you run your mixer grinder for the 1st time.This is due to the motor varnish getting heated for the 1st timeThe problem should not recur in subsequent uses. If it does, please contact Brand Service Centre; Since your mixer grinder runs on a powerful motor, there will be some noise. If the noise level seems abnormal, please contact Brand Service Centre', 4999.00, 6997, 9, '1684825878pngwing.com (30).png'),
(25, 'Harir AC', 'iscover Inverter AC by Haier with supersonic cooling in 10 sec & Energy saving upto 65% Buy Haier Inverter AC with 5 yrs comprehensive warranty & lifetime compressor Warranty', 'Brand Haier\r\nCapacity 1.5 Tons\r\nCooling Power 1.52 Kilowatts\r\nSpecial Feature Anti bacterial Filter\r\nProduct Dimensions 200D x 86.5W x 29H Centimeters\r\nEnergy Star 3 Star\r\nStart year 2023\r\nSeasonal Energy Efficiency Ratio (SEER) 3.85\r\nColour White\r\nVoltage 50 Volts', 25999.00, 2, 9, '1684826066pngwing.com (37).png'),
(26, 'Galaxy Book3', 'Samsung Galaxy Book3 Pro Intel 13th Gen i5 EvoTM 35.56cm(14\") Dynamic Amoled 2X, 3K Display, 120Hz, Ultra Thin & Light Laptop(16 GB/512 GB SSD/Windows 11/MS Office/Graphite/1.17Kg), NP940XFG-KC1IN', 'Processor: 13th Generation Intel Core i5-1340P processor (1.9 GHz up to 4.6 GHz 12 MB L3 Cache) | Memory: 16 GB LPDDR5 Memory | Storage: 512 GB NVMe SSD | Intel Iris Xe Graphics\r\nOperating System: Windows 11 Home | Pre-Installed Software: MS Office Home & Student 2021, Galaxy Ecosystem Apps\r\nDisplay: 14\" (35.56 cm), Dynamic AMOLED 2X, 3K WQXGA+ (2880 x 1800) resolution | 16:10 Aspect Ratio | 120Hz | 500nits HDR |Design: Aluminum body with 11.3mm thinness and 1.17kg', 112990.00, 1, 18, '1684826251pngwing.com (16).png'),
(27, 'Xiaomi Notebook Pro Max', 'Xiaomi Notebook Pro Max 11th Gen Intel Core i5-11320H Thin & Light (16GB/512GB SSD/Iris Xe Graphics/14″ QHD+ Display/2.5K Resolution/Win 11/Thunderbolt 4/MS Office \'21/Fingerprint Sensor/1.4 Kg)', 'Processor: 11th Gen Intel Tiger Lake Core i5-11320H processor| Speed: 3.1 GHz(base) - 4.4 GHz(max) | 4 cores | 8 Threads | 8 MB Cache\r\nDisplay: 35.56 centimeters IPS QHD+ resolution (2560x1600)| 300 nits brightness |16:10 aspect ratio, 100% sRGB,215 PPI, 1000:1 contrast ratio | Anti Glare | TUV low Blue light\r\nMemory & Storage: 16GB DDR4 3200 MHz | 512GB PCIe NVMe M.2 SSD', 53999.00, 3, 18, '1684826552pngwing.com (23).png'),
(28, 'HP 15s', 'HP 15s,11th Gen Intel Core i3-1115G4 8GB RAM/512GB SSD 15.6-inch(39.6 cm) Micro-Edge Anti-Glare FHD Laptop/Alexa Built-in/Win 11/Intel UHD Graphics/Dual Speakers/MS Office 2021/1.69 Kg, 15s-fq2673TU', 'Processor: Intel Core i3-1115G4 (up to 4.1 GHz with Intel Turbo Boost Technology(2g),6 MB L3 cache, 2 cores)|Memory: 8 GB DDR4-3200 SDRAM (1 x 8 GB)| Storage: 512 GB PCIe NVMe M.2 SSD\r\nDisplay & Graphics : 39.6 cm (15.6\") diagonal, FHD, micro-edge,anti-glare, 250 nits, 141 ppi, 45%NTSC |Graphics: Intel UHD Graphics\r\nOperating System & Preinstalled Software: Windows 11 Home 64 Plus Single Language | Microsoft Office Home & Student 2021| McAfee LiveSafe (30 days free trial as default) |Pre-installed Alexa built-in- Your life simplified with Alexa. Just ask Alexa to check your calendar, create to-do lists, shopping lists, play music, set reminders, get latest news and control smart home.', 40999.00, 3, 18, '1684826669pngwing.com (25).png'),
(29, ' JBL Endurance Run 2 ', 'JBL Endurance Run 2 with Fliphook & TwistLock Technolog... Black, In the Ear. 4.1. (278) ; JBL Wave 300 TWS, 26Hr Playtime, Open-Ear Design', 'dfsgd', 1499.00, 0, 20, '1684826823pngwing.com (22).png'),
(30, 'of Beats Solo Pro', 'Choose the fully immersive sound of Beats Solo Pro Wireless Noise Cancelling Headphones in six luxury matte finishe', 'Beats Headphones at India\'s Best Online Shopping Store. Choose from a huge range of beats earphones & headphones. ✓Best Deals ✓Fast Shipping', 3999.00, 3, 20, '1684826918pngwing.com (20).png'),
(31, 'boAt WCDV', 'boAt WCDV 22.5W Dual Port Wall Charger with 18W Quick Charge 3.0 & 22.5W Power Delivery Support, Smart IC Protection, Auto Detection, Corrosion Resistant Pins & PD Cable(White)', 'The boAt WCDV 22.5W QCPD Dual Port Wall Charger supports 18W Quick Charge 3.0 & 22.5W Power Delivery and is compatible with all Micro USB, Type C and Power Delivery cables for all your charging needs.;Take charge of time with 18W Quick Charge 3.0 technology & 22.5W Power Delivery support.\r\nThe smart IC protection will keep your devices safe with built-in surge protection, short circuit protection, over current protection & overheat protection.\r\nThe Auto Detect Charging (Max 22.5W) adapts to your device’s charging needs to offer maximum efficiency.\r\nThe enduring capacitors having up to 10000 cycles is aptly complimented by its corrosion resistant pins for a long lifecycle of the device.; It comes with a free Power Delivery Cable to give you full charging support.\r\nPower Source Type: Corded Electric', 579.00, 8, 21, '1684827015boAt WCDV 22.5W Dual Port Wall Charger.jpg'),
(32, 'Oraimo Charger', 'Oraimo USB Charger, Oraimo Elite Dual Port 5V/2.4A Wall Charger, USB Wall Charger Adapter for iPhone 11/Xs/XS Max/XR/X/8/7/6/Plus, iPad Pro/Air 2/Mini 3/Mini 4, Samsung S4/S5, and More (Black)', 'Dual Port USB Wall Charger Adapter】Oraimo USB Charger with dual ports allow you to charge 2 devices at the same time with the total output of 2.4A current. Single port allows Max 2.4A current when connecting only one device. Much more convenient and save your time effectively.\r\n【Safe Charging】With the intelligent chip inside, dual USB wall charger matches the current as your device\'s need automatically. Over-current, over-voltage and short-circuit protection also effectively protect your smartphones from damage\r\n【Multi-Protection】 Internal protection mechanisms offers multiple Protection against short-circuit, over-temperature, over-current, over-voltage and more\r\n【Wide Compatibility】Wall charger works for all phones with USB-A Cables - iPhone 12/12 Mini/12 Pro/12 Pro Max/11/ 11 Pro/XR/X/Xs/8/8 Plus/7Plus/7/6/6S/5, iPad Air, iPad mini, iPad Pro, Samsung Galaxy M30s/A30s/A50s/A10s/A10e/M40/A20e/A10/S10+/S10/S10e/S9/S9+/S8/S8+/Note 9/8, Google Pixel, HTC, BLU, Xiaomi, LG Q70/K30/K20/K40S/K50S/G7/G6/G5, Blackberry, Nokia, Motorola, Sony, Huawei, and any other USB outlet devices; 【Durable Design】 Robust textured casing and premium internal components ensure perfect performance regardless of scrapes, bumps, or drops.\r\nPower Source Type: Corded Electric', 249.00, 2, 21, '1684827096Oraimo USB Charger, Oraimo Elite Dual Port 5V2.4A Wall Charger.jpg'),
(33, 'pTron Volta Fast Charger', 'pTron Volta 12W Single Port USB Fast Charger, BIS Certified, Made in India Wall Charger Adapter, Universal Compatibility (1 m Micro USB Cable Included, Black)', 'Made in India Fast Charging Charger with 1 meter 2.4A Micro USB cable | This USB travel wall charger port charges at a consistent 12 Watt Current.\r\nCompact & Lightweight - pTron Volta USB charger adapter allows charging at home or in the office via a USB cable connection. Use a compatible USB charging cable to experience fast charging.\r\nSingle USB port that lets you charge all your USB devices with a single adaptor, to avoid the hassle of carrying multiple chargers.\r\nSafe Charging: Volta features over-voltage protection, over-current protection, over-heat protection, short circuit protection, anti-static protection, fire-resistant material, and BIS certification.\r\nWide Compatibility - Designed for Indian wall sockets. You can easily charge your smartphone, power bank & wireless headphones, etc. 6 months of manufacturer warranty from the date of purchase.', 149.00, 4, 21, '1684827170pTron Volta 12W Single Port USB Fast Charger.jpg'),
(36, 'boAt Xtend', 'boAt Xtend Smartwatch with Alexa Built-in, 1.69” HD Display, Multiple Watch Faces, Stress Monitor, Heart & SpO2 Monitoring, 14 Sports Modes, Sleep Monitor, 5 ATM & 7 Days Battery(Charcoal Black)', 'Alexa- Alexa built-in Voice Assistant that sets reminders, alarms and answers questions from weather forecasts to live cricket scores at your command! Volume Control for Music: Yes\r\nScreen Size- ;1.69\" big square colour LCD display with a round dial features complete capacitive touch experience to let you take control, effortlessly. Always on display:No, Peak Brightness 500 Nits\r\nWatch Faces- Multiple watch faces with customizable options to match your OOTD, every day!', 2799.00, 11, 26, '1684911935pngwing.com (13).png'),
(37, 'Noise ColorFit', 'Noise ColorFit Pulse Grand Smart Watch with 1.69', '1.69\" grand display: Get the rich immersive viewing experience on the 1.69\" LCD display.;60 sports modes: Take your pick from a wide range of 60 sports modes. Charging Time 2.5 hours\r\nInstant charge: Now enjoy more than a day’s worth/25 hours of battery in just 15 minutes of charge. Battery Capacity: 260 mAh;150+ cloud-based & customisable watch faces: Choose from 150+ cloud-based and customisable watch faces and change your look to suit your outfit.', 1299.00, 10, 26, '1684912000pngwing.com (14).png'),
(38, 'boAt data cable', 'boAt Micro USB 55 Tangle-free, Sturdy Micro USB Cable with 3A Fast Charging & 480mbps Data Transmission (Black)', 'It Ensures High Speed Transmission And Charging By Offering 3A Fast Charging And Data Transmissions With Rapid Sync At 480 Mbps\r\nThe Braided Skin Makes It Durable And Invincible Against External Damage So You Can Have An Absolute Hassle-Free & Tangle Free Experience\r\nIts Durable Pvc Housing And The Flexible Design Makes It Last 6 Times Longer Than Other Cables', 99.00, 10, 22, '1684912137pngwing.com (11).png'),
(39, 'PTron Baseus all in one cable', 'Tron USB-A to Micro USB 2.4A Fast Charging Cable Compatible with Android Phones/Tablets, 480mbps Data Transfer Speed, Made in India, Solero M241 Tangle-Free USB Cable (Round, 1M, Black)', 'Solero M241 data and charging cable is equipped with a Micro USB port, the cable supports up to 2.4Amps of power output for powering and fast charging your smart device.\r\nCharge & sync, this USB cable can charge and data sync simultaneously at 480Mbps speed, compatible with all devices with a Micro USB port. Core : Tinned Copper', 89.00, 8, 22, '1684912256pngwing.com (12).png'),
(40, 'SanDisk Cruzer Usb Pendrive', 'SanDisk Cruzer Blade 64GB USB 2.0 Flash Drive', 'Compact Design for Maximum Portability.\r\nStore more with capacities up to 16gb 5-year limited warranty , High-Capacity Drive Accommodates Your Favorite Media Files. Write Speed : 20 MB/s (USB 2.0)\r\nOperating temperature: 0ºC to 45ºC , Storage temperature: -10ºC to 70ºC\r\nSanDisk SecureAccess Software Protects Drive from Unauthorized Access\r\nThe models are different because production is from different countries. Otherwise both are sandisk cruzer blade models.', 379.00, 26, 23, '1684912344pngwing.com (15).png'),
(41, 'Dell MS116', 'Dell MS116 1000Dpi USB Wired Optical Mouse, Led Tracking, Scrolling Wheel, Plug and Play.', 'Movement Detection: Optical, Resolution : 1000dpi;Cable Length : 1.8 meter, Interface Type : USB\r\nColour : Black, Weight : 413 Grams\r\nGreat Aesthetics, Usage ideal for office, education sectors, designing, basic gaming etc\r\nComfortable for use in longer periods with performance; Warranty : 3 Year', 699.00, 0, 23, '1684912521pngwing.com (9).png'),
(42, 'HP X1000', 'HP X1000 Wired USB Mouse with 3 Handy Buttons, Fast-Moving Scroll Wheel and Optical Sensor works on most Surfaces, 3 years warranty', '3 buttons improve productivity;Optical sensor works on most surfaces\r\nThe sleek and modern HP Mouse X1000 adds an instant touch of trend-setting style to any work space .\r\nGlossy black and metallic gray shine with sophistication\r\n3 years manufacturer warranty on the device from the date of purchase\r\nOperating System: Windows Xp;Style Name: 1600 Dpi', 599.00, 0, 23, '1684912571pngwing.com (10).png'),
(43, 'CHIST Core i5', 'CHIST Core i5 Desktop Complete Computer System Full Setup for Home & Business(core I5 3470 Processor/19 Monitor/Keyboard Mouse/Windows 11/ WiFi) (16GB RAM/512GB SSD)', 'Core i5 3470 Upto 3.6 GHzOME PROCESSOR Processor 4 Core 4Threats 6MB Caches\r\nH61 Motherboard VGA& HDMI, 6x 2.0 USB Ports\r\nRam and HDD as per varient/19\" Monitor wired keyboard mouse\r\nwindows 11 (trail) all essential software installed', 20000.00, 7, 24, '1684912670pngwing.com (18).png'),
(44, 'HP AMD', 'HP AMD Windows 10 All-in-One PC 23.8-inches 60.5 cm FHD Desktop PC Ryzen 3-3250U -8GB/256GB SSD + 1TB HDD/IR Camera/Win 11/MS Office/Snow White, 24-cb0789in', 'Processor :- AMD Ryzen 3 3250U (2.6 GHz base clock, up to 3.5 GHz max boost clock, 4 MB L3 cache, 2 cores, 4 threads)Memory & Storage :- 8 GB DDR4-2400 MHz RAM (1 x 8 GB)| Storage :- 256 GB PCIe NVMe M.2 SSD + 1 TB 5400 rpm SATA HDD\r\nDisplay & Graphics : 60.5 cm (23.8\") diagonal, FHD (1920 x 1080), VA, three-sided micro-edge, anti-glare, 250 nits, 72% NTSC |Graphics:AMD Radeon Graphics\r\nOperating System :- Windows 11 Home| Microsoft Office Home and Student Edition 2019', 46990.00, 0, 24, '1684912741pngwing.com (21).png'),
(45, 'boAt Immortal 171', 'boAt Immortal 171 with Beast Mode(Low Latency), 40 HRS Playback & Blazing RGB LEDs Bluetooth Gaming Headset  (Black Sabre, True Wireless)', 'Make your gaming skills legendary with the boAt Immortal 171 TWS Gaming Earbuds. 40 ms low-latency BEASTTM mode offers synchronized visuals and powerful sound with no lag. First-person shooter games feel more realistic whether you are playing alone or with your buddies.', 1399.00, 27, 22, '1708443645buds mera wala.webp'),
(46, 'Smart watches', 'Fire-Boltt Phoenix Ultra Luxury Stainless Steel, Bluetooth Calling Smartwatch, AI Voice Assistant, Metal Body with 120+ Sports Modes, SpO2, Heart Rate Monitoring (Gold)', '【Bigger Round Display】- Comes with a TFT Color Full Touch Screen and a 240*240 Pixel High Resolution this watch is covered to flaunt the sleek and stylish look always. Enjoy a 320 NITS Peak Brightness\r\nThe watch will work on a single charge for about 7 days (without Bluetooth calling) and about 4 Days with Bluetooth calling. 【Stainless Steel Luxury Straps】- Fire-Boltt Phoenix Ultra has stainless steel magnetic closure straps for ultimate luxury look and sleek finish.', 1999.00, 67, 26, '1708577768smartwatcj.png'),
(47, 'Smart watches', 'Fire-Boltt Phoenix Ultra Luxury Stainless Steel, Bluetooth Calling Smartwatch, AI Voice Assistant, Metal Body with 120+ Sports Modes, SpO2, Heart Rate Monitoring (Gold)', '【1.83\" HD Display Smart Watch】- The 46.48mm (1.83-inch) HD display makes the display clear and true-to-life, with vivid colours ensuring smooth readability and keeping the watch as exquisite to look at as when you first lay your eyes on it. The watch has a 280 NITS Peak Brightness\r\nThis fashion smart watch will work on a single charge for about 8 days (without Bluetooth calling) and about 5 Days with Bluetooth calling.', 1999.00, 67, 26, '17085778641.png'),
(48, 'Smart watches', 'Sounce 3 Pack 20mm Watch Strap Bands Compatible for Amazfit Bip, Amazfit GTS, Galaxy Watch Active 2, Gear S2 Classic, Samsung Gear Trendy Watch Straps (Pack of 3)', 'Compatible Models: Fits for Removable Straps ONLY for Amazfit Bip, Amazfit GTS, Galaxy Watch Active 2, Gear S2 Classic, Samsung Gear, Boat, Firebolt, Noise. Water-proof, sweat-proof, replacement wrist strap only, no watch included.\r\n【Material】 Made of flexible and durable elastomer silicone material, softness is moderate, comfortable to wear. Best for high intensity workouts and sleep tracking, never fade or dim.\r\n【Breathable】 The holes on the band makes it more comfortable to wear and makes your skin breath freely . Ventilation Holes Design makes it wear cool and dry after you sweat during the sports.', 1999.00, 60, 26, '17085780702.png'),
(49, 'Fire-Boltt Phoenix Smart Watch', 'Fire-Boltt Phoenix Smart Watch with Bluetooth Calling 1.3\",120+ Sports Modes, 240 * 240 PX High Res with SpO2, Heart Rate Monitoring & IP67 Rating (Silver Grey)', '【High Resolution Display】- Comes with a 1.3\" TFT Color Full Touch Screen and a 240*240 Pixel High Resolution this fashion smartwatch is covered to flaunt the sleek and stylish look always with 260 NITS Peak Brightness\r\nThe watch will work on a single charge for about 7 days (without Bluetooth calling) and about 4 Days with Bluetooth calling.\r\nCharging Specs - The watch needs to be charged for 3 hours to reach 100%. The charger should be a 3.7V to 5V adapter or any laptop output. For a bare minimum of 20% charge the watch needs to be charged for about 30-40 mins', 1499.00, 60, 26, '17085783033.png');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `img1` varchar(250) DEFAULT NULL,
  `img2` varchar(250) DEFAULT NULL,
  `img3` varchar(250) DEFAULT NULL,
  `img4` varchar(250) DEFAULT NULL,
  `img5` varchar(250) DEFAULT NULL,
  `img6` varchar(250) DEFAULT NULL,
  `color1` varchar(250) DEFAULT NULL,
  `color2` varchar(250) DEFAULT NULL,
  `color3` varchar(250) DEFAULT NULL,
  `color4` varchar(250) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `title`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`, `color1`, `color2`, `color3`, `color4`, `about`, `status`) VALUES
(10, 'new theme', '4slider.webp', '1slider.png', 'SliderFinal-4.jpeg', 'Screenshot 2024-02-18 233931.png', 'Screenshot 2024-02-18 234502.png', 'Screenshot 2024-02-18 234431.png', '#b493e6', '#ffffff', '#563d7c', '#b49bd9', 'new theme', '0'),
(11, 'charismas', 'Screenshot 2024-02-18 234502.png', 'Screenshot 2024-02-18 234431.png', 'Screenshot 2024-02-18 233931.png', '4slider.webp', '1slider.png', 'seller-verification.jpg', '#ff000d', '#faf8fc', '#f0f0f0', '#ff0a23', 'dfghjkl;lkjhgfdsfghjkl;', '0'),
(12, '26 jan', 'seller-verification.jpg', '4slider.webp', '1slider.png', 'BTS-Lenovo-1365x260.avif', 'SliderFinal1.jpeg', 'download (5).jpeg', '#0fb812', '#f9f5ff', '#faf9fa', '#236308', 'fghjukjhgfdfghjklkijuhygtfrd', '0'),
(13, 'diwali', 'design_preview (10)_page-0001.jpg', 'Screenshot 2024-02-18 234431.png', 'Screenshot 2024-02-18 234502.png', NULL, NULL, NULL, '#b99cde', '#000000', '#8651c8', '#ffffff', ' HAPPY DIWALI !!!!!!!!We have came with new and exited offer kn dewali get upto <strong> 20% </strong> off on each product use <strong> DEWALI20 <strong>', '1'),
(14, 'watch white', 'Screenshot 2024-02-22 105530.png', 'Screenshot 2024-02-22 105634.png', 'Screenshot 2024-02-22 105220.png', 'Screenshot 2024-02-22 105157.png', 'Screenshot 2024-02-22 105612.png', 'Screenshot 2024-02-22 105554.png', '#65e6aa', '#000000', '#46a466', '#ffffff', 'swdfghjukilokihgfvcdfgthyjukilo;plokijuhygtfd', '0'),
(15, 'whatch black', 'Screenshot 2024-02-22 104954.png', 'Screenshot 2024-02-22 104912.png', 'Screenshot 2024-02-22 104912.png', 'Screenshot 2024-02-22 105101.png', 'Screenshot 2024-02-22 105035.png', 'Screenshot 2024-02-22 105135.png', '#040209', '#f9f7fd', '#2b272f', '#bfa8e1', 'dfghjkl;lkjhgfcdfghjkilo;p\';lkjhgfvcdxcfvhjkl;lkjhgfdcfghyjuki;p\'\r\n', '0');

-- --------------------------------------------------------

--
-- Table structure for table `validate`
--

CREATE TABLE `validate` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `valid` enum('0','1') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `validate`
--

INSERT INTO `validate` (`id`, `email`, `valid`) VALUES
(1, 'jhag2491@gmail.com', '1'),
(2, 'shrusti@gamil.com', '1'),
(3, 'harshal@gmail.com', '1'),
(4, 'jaynesh@gmail.com', '1'),
(5, 'rahulraj@gmail.com', '0'),
(6, 'vaibhav@gmail.com', '0'),
(7, 'vigneshvenkatesa44535@gmail.com', '0'),
(8, 'dhruvi22may2000@gmail.com', '1'),
(9, 'khushboo@gmail.com', '1'),
(10, 'shivani@gmail.com', '1'),
(11, 'temp@gmail.com', '0'),
(12, 'temp2@gmail.com', '0'),
(13, 'jhag2491@gmail.com', '0'),
(14, 'jhag2491@gmail.com', '0'),
(15, 'jhag2491@gmail.com', '0'),
(16, 'jhag2491@gmail.com', '0'),
(17, 'chaudharyshrusti1122@gmail.com', '0'),
(18, 'chaudharyshrusti@gmail.com', '1'),
(19, 'prachiblohar@gmail.com', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `validate`
--
ALTER TABLE `validate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `validate`
--
ALTER TABLE `validate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
