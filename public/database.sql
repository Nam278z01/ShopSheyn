-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.28 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for shop
CREATE DATABASE IF NOT EXISTS `shop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `shop`;

-- Dumping structure for table shop.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã admin',
  `admin_username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên tài khoản',
  `admin_password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mật khẩu',
  `admin_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tên admin',
  `admin_role` tinyint DEFAULT '1' COMMENT 'Vai trò',
  `admin_state` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `admin_name`, `admin_role`, `admin_state`) VALUES
	(1, 'nam278z01@gmail.com', '1234567890', 'Nguyễn Nam', 1, 1);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table shop.category
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã danh mục',
  `category_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tên danh mục',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.category: ~11 rows (approximately)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`category_id`, `category_name`) VALUES
	(1, 'Áo'),
	(2, 'Quần'),
	(3, 'Quần đùi'),
	(8, 'Đồ liền thân'),
	(9, 'Áo khoác'),
	(11, 'Hoodie & Áo nỉ'),
	(12, 'Bộ'),
	(14, 'Đồ ngủ'),
	(16, 'Đồ truyền thống'),
	(20, 'Vớ/Tất'),
	(21, 'Đầm/Váy');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Dumping structure for table shop.color
CREATE TABLE IF NOT EXISTS `color` (
  `color_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã màu sản phẩm',
  `color_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tên màu sản phẩm',
  `product_price` double NOT NULL COMMENT 'Giá sản phẩm',
  `product_image1` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Ảnh 1',
  `product_image2` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Ảnh 2',
  `product_image3` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Ảnh 3',
  `product_image4` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Ảnh 4',
  `product_image5` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Ảnh 5',
  `product_id` int NOT NULL COMMENT 'Mã sản phẩm',
  PRIMARY KEY (`color_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `color_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.color: ~6 rows (approximately)
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
INSERT INTO `color` (`color_id`, `color_name`, `product_price`, `product_image1`, `product_image2`, `product_image3`, `product_image4`, `product_image5`, `product_id`) VALUES
	(1, 'Đen', 142000, '1610954054037523ce2e1b5541c69040ccb4102400_thumbnail_900x.webp', '1610954057e9d333c568dd4f28a5fd56343acb912e_thumbnail_900x.webp', '16109540614aabaa892deb01c5d59b17e73326a2a8_thumbnail_900x.webp', '1610954064b4d703949275742134916533ca2c4253_thumbnail_900x.webp', '16109540670d4cab359190a6ff9e445efeb15b2a6b_thumbnail_900x.webp', 1),
	(2, 'Xanh trời', 279000, '16454131255afcc643a69b66c26689dda9181d1c54_thumbnail_900x.webp', '1645413133d534d4842ab0c89cbb2edd272669590e_thumbnail_900x.webp', '1645413131f0602c3612f8dabe2c0356f3e366ffcb_thumbnail_900x.webp', NULL, NULL, 2),
	(3, 'Xanh lá', 179000, '160920611249ad39d73eeee11fbaac26e377576d23_thumbnail_900x.webp', '1609206120a804b3017788c7d41c18305cd9e71fce_thumbnail_900x.webp', '1609206123447c39a80f62252d15ac6cc6f798f091_thumbnail_900x.webp', NULL, NULL, 3),
	(4, 'Màu xanh nhạt', 189000, '1618211892e75457451d549d7d4db079b5e090e11a_thumbnail_900x.webp', '16182118953f87e2f1faaf757c2337ab4ff3964c03_thumbnail_900x.webp', '16182119007c0cb3990a3621e2af7968d5249a6f28_thumbnail_900x.webp', '16182119051c4f9b7b948d195033dd19eb8e742ac2_thumbnail_900x.webp', NULL, 3),
	(5, 'Bụi hồng', 212000, '1649313585f9122376541fc5bebb42d02f751dfcb2_thumbnail_900x.webp', '1649313587e2857ae575b1bbbaa708304a33f82d86_thumbnail_900x.webp', '1649313589aecf462147b15f1c06fa8b14dcb99996_thumbnail_900x.webp', '1649313591cd494a031e025b164c489798fb1bffc7_thumbnail_900x.webp', '16493135971e3fa57e0f6f53e27fb17ff21b759d12_thumbnail_900x.webp', 4),
	(6, 'Trắng', 216000, '1648450658b948882cf65aa3f0086e7989fbc9e7fd_thumbnail_900x.webp', '1648450661235cabc1104f54b32afedf8094bbe7d7_thumbnail_900x.webp', '164845066326a16b50f07a9159996868ebb72c22ca_thumbnail_900x.webp', '164845066520964b5f0abce253b6d569119824f335_thumbnail_900x.webp', '16484506694e16bc04657ef28707d8b29de8dcc49e_thumbnail_900x.webp', 4),
	(7, 'Xanh lá', 211000, '16493136081a5ef0c748eb63af52cc624fc388c6a7_thumbnail_900x.webp', '16493136413af016974d7011e50566ac38492de680_thumbnail_900x.webp', '164931368054500f5c377f92b902da5348e1f68a0a_thumbnail_900x.webp', '164931371618a2dbbd32883ec90db99e72f30d58e8_thumbnail_900x.webp', '164931376462b7c2bad488c03533d9540a63bb9aa9_thumbnail_900x.webp', 4),
	(8, 'Xám', 334000, '1635996842069a094265a3ffff0450594b2430ffaa_thumbnail_900x.webp', '16359968461b4c6bd60781a9a7b4cdaf2f21061fd2_thumbnail_900x.webp', '1635996850b5de0fabc8b9fe6110e0d62b2b039474_thumbnail_900x.webp', '1635996856d99ebf3909c44e3b2ea2f00370b63692_thumbnail_900x.webp', NULL, 5),
	(9, 'Trắng', 371000, '16464650625b0643019be992b87ea960019513c4eb_thumbnail_900x.webp', '1646465064465e152e1327d339c980a1410752448b_thumbnail_900x.webp', '1646465065a5f896b17836aacfe042103462d74910_thumbnail_900x.webp', NULL, NULL, 6),
	(10, 'Cam nhạt', 252000, '1648815101a614d76d128ceff55e355e80a56771a8_thumbnail_900x.webp', '1648815103910afbfb8917a0e0cc785f5fb82a23d4_thumbnail_900x.webp', '1648815104739f6a49e3619371541776bedb195b52_thumbnail_900x.webp', '1648815105e3f6826346f61b8d087bf8abb1788ce0_thumbnail_900x.webp', NULL, 8),
	(11, 'Đen', 223000, '16500932437393e3a83194a3792af9be96b430348a_thumbnail_900x.webp', '1650093245ae4ad8d68ae23d2295ce22fea24a5540_thumbnail_900x.webp', '1650093247fd6ea84b12d1b73cd2c913560d37726d_thumbnail_900x.webp', '1650093249335ee2f2971667060dda3bc4e2edafaa_thumbnail_900x.webp', '1650093251f7db9a8184d555cba5780e5412ac19bf_thumbnail_900x.webp', 9),
	(12, 'Nhiều màu', 267000, '16496403077a3348181cf19bbe1e054dce096f8a43_thumbnail_900x.webp', '16496402986dbe4cb949a07ce6589de2fc228d16a9_thumbnail_900x.webp', '16496403015da9bd409826aa79e4d2ad4b9991412e_thumbnail_900x.webp', '1649640296df98a631044054a97d151b21e7dea9b1_thumbnail_900x.webp', NULL, 10),
	(13, 'Be nhạt', 245000, '1649646534d7d57013c5076c63026d4b9bc6b2f651_thumbnail_900x.webp', '16496465273a164b7236e77c3baff87b1b1c42d352_thumbnail_900x.webp', '16496465290438e84c01c16c8352267e186ae9f742_thumbnail_900x.webp', '16496465321fe9fbeb95b0bbfaad2d16d85228047e_thumbnail_900x.webp', NULL, 11),
	(14, 'Trắng', 535000, '16492486009eee7455353bf0df410f550abbeb4a53_thumbnail_900x.webp', '1649248603401e9f8a1a260d7d3de658f928b0ff36_thumbnail_900x.webp', '1649248606170c5dcb1ec2940799a594c741d734c5_thumbnail_900x.webp', '1649248608bb23126e53ffb1f791296ec2e2259d3c_thumbnail_900x.webp', '16492486110a19d46494f5a39dc1ecce8ec9f16c13_thumbnail_900x.webp', 12),
	(15, 'Trắng', 369000, '16390275394e38a65b4455af93447350e0a9713e58_thumbnail_900x.webp', '16390275418b77d6e3e73883c418583b279933c1c9_thumbnail_900x.webp', '1639027544df6037381b14b01901e791077d9c1c09_thumbnail_900x.webp', '1639027546a8eb9640b025b4563f6c9212a789218e_thumbnail_900x.webp', '16390275490a026c3d68aee034d71f558345e971c3_thumbnail_900x.webp', 13),
	(16, 'Xanh lá', 382000, '164869274676638ebca8162a9e172750cfb3c0246a_thumbnail_900x.webp', '1648692732991f5bd22aeaee7c7004dccd69730255_thumbnail_900x.webp', '16486927359964303898b7029454b6137a65a62894_thumbnail_900x.webp', '1648692730522a19d24a4e7efb27d54eac6bd17a54_thumbnail_900x.webp', '16486927421992dc51b229dc6710b1ce2395792e68_thumbnail_900x.webp', 14),
	(17, 'Đen', 229000, '164630314053419fc2963f7c59a2146a3879cad57a_thumbnail_900x.webp', '16463031417e1c6f83315bd2e4199a6c328d7a3287_thumbnail_900x.webp', '16463031447ccba117c3bc271f4042d4c4f57608d5_thumbnail_900x.webp', '1646303146be18a16c8126c4043ea8f93b5aa5ee99_thumbnail_900x.webp', NULL, 15),
	(18, 'Hồng', 229000, '1646963292390bff454c2baee8e5d869400a82b4ae_thumbnail_900x.webp', '1646963294ddfb2be01b3223c255a6f9a8ba495502_thumbnail_900x.webp', '1646963296779136d1e61521592306b84299bf5276_thumbnail_900x.webp', '164696329800b6a4ef76757aa9d7779e3a9ae2a4aa_thumbnail_900x.webp', '1646963300064ddcea7464b67b9bf33387a66dd5d7_thumbnail_900x.webp', 15),
	(19, 'Xanh lá', 215000, '16496458305436ee08212ab85e4df0cab7a984372a_thumbnail_900x.webp', '1649645826a1705ba4f374a4e41a631465f82057d6_thumbnail_900x.webp', '1649645824f48742b1d76e5585f3e0da26016ab4fe_thumbnail_900x.webp', '1649645828a628b849b7acde2ee7b0173e3f1682f6_thumbnail_900x.webp', '1649645831edf7e45f961574b16de7bf4839ffce57_thumbnail_900x.webp', 17),
	(20, 'Xanh da trời', 303000, '164918366219ceaff449594c88a4722385e1ad7ad2_thumbnail_900x.webp', '1649183663e5cf2e620ba9ba6404d3a30feeab2121_thumbnail_900x.webp', '16491836654c4b4f86da269044d751252327ee7a7a_thumbnail_900x.webp', NULL, NULL, 18),
	(21, 'Đen', 271000, '1648447618f1c25b25980280dec695cc63f52a0bff_thumbnail_900x.webp', '16484476211eac631f80602840670a75234b8c275d_thumbnail_900x.webp', '16484476241b8ecb28a95e6f33eac5009f7e2a3f00_thumbnail_900x.webp', '1648447630a03d62015143fa6956fb0b06bd37ccbe_thumbnail_900x.webp', NULL, 19),
	(22, 'Đen', 255000, '16424063497f48ca6d8d50f73da6e7df403f63059b_thumbnail_900x.webp', '16424063526d855cef800a70fb877ec08025a51b49_thumbnail_900x.webp', '1642406362086abe3e213199dad482cd82b07260dc_thumbnail_900x.webp', '1642406372e5ec27e00c5ce949cc7009d5acee4704_thumbnail_900x.webp', '1642406374382e94fb535cd6bbb028f17674c08712_thumbnail_900x.webp', 20),
	(23, 'Nâu', 391000, '16430760433cda686bd577ab8f2c9f5fc46c967659_thumbnail_900x.webp', '16430760450b293e0955cb9d2466e6dbd218b4d516_thumbnail_900x.webp', '1643076047533f5c3278b3f98dcb05cb13957ebe34_thumbnail_900x.webp', '16430760499c9f171a8d6e0ebeb30cab2f50867f7a_thumbnail_900x.webp', '1643076050c1af21e45cd3138f7390f0ef49bef7f4_thumbnail_900x.webp', 21),
	(24, 'Tím', 213000, '164879459846b4eb5be1c91e20fc611e7322fa349c_thumbnail_900x.webp', '1648794600205e434ae360d8cf7ffcd079e8be66ca_thumbnail_900x.webp', '1648794604ff32ec69155d2ef06f0d061622b64e7e_thumbnail_900x.webp', '1648794603cc32bfaf5e81722d51ee84cfd49b6f8f_thumbnail_900x.webp', '1648794601094ec756a2b98de7cc6ab91ff657677e_thumbnail_900x.webp', 22);
/*!40000 ALTER TABLE `color` ENABLE KEYS */;

-- Dumping structure for table shop.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã admin',
  `customer_username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên tài khoản',
  `customer_password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mật khẩu',
  `customer_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Vai trò',
  `customer_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Email',
  `customer_phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Số điện thoại',
  `customer_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Địa chỉ',
  `gender` tinyint(1) DEFAULT NULL COMMENT 'Giới tinh',
  `birthdate` datetime DEFAULT NULL COMMENT 'Ngày sinh',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.customer: ~0 rows (approximately)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for procedure shop.getProductsSearch
DELIMITER //
CREATE PROCEDURE `getProductsSearch`(IN `page_index` INT, IN `page_size` INT, IN `category_id` INT, IN `list_subcategory_id` VARCHAR(4000) CHARACTER SET UTF8MB4, IN `text_search` VARCHAR(200) CHARACTER SET UTF8MB4, IN `min_price1` INT, IN `max_price1` INT, IN `sort` INT, OUT `OUT_TOTAL_ROW` INT)
BEGIN
    CREATE TEMPORARY TABLE Result1
    AS (
        SELECT p.product_id,
            p.product_name,
            p.product_description,
            p.product_discount,
            p.created_time,
            MIN(cl.product_price - cl.product_price * p.product_discount / 100) as min_price,
            MAX(cl.product_price - cl.product_price * p.product_discount / 100) as max_price,
            SUM(IFNULL(od.product_quantity, 0)) as quantity_sold
        FROM product AS p
            INNER JOIN subcategory AS sc ON p.subcategory_id = sc.subcategory_id
            INNER JOIN category AS c ON sc.category_id = c.category_id
            INNER JOIN color AS cl ON cl.product_id = p.product_id
            INNER JOIN size s ON s.color_id = cl.color_id
            LEFT JOIN orderdetails od ON od.size_id = s.size_id
        WHERE (category_id IS NULL OR c.category_id = category_id)
            AND (text_search IS NULL OR p.product_name LIKE CONCAT('%', text_search, '%'))
            AND (list_subcategory_id IS NULL OR sc.subcategory_id IN (SELECT *
                                                                    FROM JSON_TABLE(
                                                                            list_subcategory_id,
                                                                            "$[*]" COLUMNS(
                                                                            subcategory_id INT PATH "$")) as data))
        GROUP BY p.product_id, p.product_name, p.product_description, p.product_discount
        HAVING (min_price1 IS NULL OR min_price >= min_price1)
                AND (max_price1 IS NULL OR min_price <= max_price1)
    );
    SELECT COUNT(*)
    INTO OUT_TOTAL_ROW
    FROM Result1;

    SET @page1 = (page_index - 1) * page_size;
    SET @page_size1 = (page_index * page_size);
    IF(sort = '1') THEN
        SET @sort_query = 'ORDER BY r.created_time DESC ';
    ELSEIF(sort = '2') THEN
        SET @sort_query = 'ORDER BY r.quantity_sold DESC ';
    ELSEIF(sort = '3') THEN
        SET @sort_query = 'ORDER BY r.product_discount DESC';
    ELSEIF(sort = '4') THEN
        SET @sort_query = 'ORDER BY r.min_price ASC ';
    ELSE
        SET @sort_query = 'ORDER BY r.min_price DESC ';
    END IF;
    SET @queryString = (
            CONCAT('
                CREATE TEMPORARY TABLE Result2
                    AS (
                        SELECT r.product_id,
                                r.product_name,
                                r.product_description,
                                r.product_discount,
                                r.min_price,
                                r.max_price,
                                r.quantity_sold
                        FROM Result1 AS r ',
                        @sort_query,'
                        LIMIT ?, ?
                    )
            ')
        );

    PREPARE myquery FROM @queryString;
    EXECUTE myquery USING @page1, @page_size1;
    DROP TEMPORARY TABLE Result1;

    SELECT JSON_ARRAYAGG(
        JSON_OBJECT(
        'product_id', p.product_id,
        'product_name', p.product_name,
        'product_description', p.product_description,
        'product_discount', p.product_discount,
        'min_price', p.min_price,
        'max_price', p.max_price,
        'quantity_sold', p.quantity_sold,
        'colors', (SELECT JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'color_id', c.color_id,
                                'color_name', c.color_name,
                                'product_price', c.product_price,
                                'product_image1', c.product_image1,
                                'product_image2', c.product_image2,
                                'product_image3', c.product_image3,
                                'product_image4', c.product_image4,
                                'product_image5', c.product_image5,
                                'sizes', (SELECT JSON_ARRAYAGG(
                                                    JSON_OBJECT(
                                                    'size_id', s.size_id,
                                                    'size_name', s.size_name,
                                                    'quantity', s.quantity
                                                ))
                                        FROM size s
                                        WHERE s.color_id = c.color_id)
                            ))
                    FROM color c
                    WHERE c.product_id = p.product_id)
    )) AS data
    FROM Result2 AS p;
    DROP TEMPORARY TABLE Result2;
END//
DELIMITER ;

-- Dumping structure for table shop.orderdetails
CREATE TABLE IF NOT EXISTS `orderdetails` (
  `orderdetails_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã chi tiết đơn hàng',
  `product_discount` tinyint NOT NULL DEFAULT '0' COMMENT 'Giảm giá (%)',
  `product_quantity` int NOT NULL COMMENT 'Số lượng sản phẩm',
  `price` double NOT NULL COMMENT 'Giá (x1)',
  `size_id` int NOT NULL COMMENT 'Mã size',
  `order_id` int NOT NULL COMMENT 'Mã đơn hàng',
  PRIMARY KEY (`orderdetails_id`),
  KEY `order_id` (`order_id`),
  KEY `size_id` (`size_id`),
  CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.orderdetails: ~0 rows (approximately)
/*!40000 ALTER TABLE `orderdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderdetails` ENABLE KEYS */;

-- Dumping structure for table shop.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã đơn hàng',
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày đặt hàng',
  `customer_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tên khách hàng',
  `customer_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Địa chỉ',
  `customer_phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Số điện thoại',
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Ghi chú',
  `delivery_cost` double NOT NULL DEFAULT '0' COMMENT 'Phí vận chuyển',
  `total` double NOT NULL COMMENT 'Thành tiền',
  `customer_id` int NOT NULL COMMENT 'Mã khách hàng',
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.orders: ~0 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table shop.orderstate
CREATE TABLE IF NOT EXISTS `orderstate` (
  `orderstate_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã trạng thái đơn hàng',
  `orderstate_name` tinyint NOT NULL DEFAULT '0' COMMENT 'Tên trạng thái (0:Đơn hàng đã đặt; 1:Đã xác nhận thông tin thanh toán; 2: Đã giao cho ĐVVC; 3: Đơn hàng đã nhận; 4: Đơn hàng đã giao; 5: Đơn hàng đổi/trả)',
  `orderstate_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian',
  `order_id` int NOT NULL COMMENT 'Mã đơn hàng',
  PRIMARY KEY (`orderstate_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `orderstate_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.orderstate: ~0 rows (approximately)
/*!40000 ALTER TABLE `orderstate` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderstate` ENABLE KEYS */;

-- Dumping structure for table shop.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã sản phẩm',
  `product_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tên sản phẩm',
  `product_description` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Mô tả',
  `product_discount` tinyint NOT NULL DEFAULT '0' COMMENT 'Giảm giá (%)',
  `subcategory_id` int NOT NULL COMMENT 'Mã danh mục con',
  `created_time` datetime NOT NULL COMMENT 'Thời gian tạo',
  `updated_time` datetime DEFAULT NULL COMMENT 'Thời gian cập nhập',
  `admin_updated_id` int DEFAULT NULL COMMENT 'Mã người cập nhập',
  `admin_created_id` int NOT NULL COMMENT 'Mã người tạo',
  PRIMARY KEY (`product_id`),
  KEY `admin_updated_id` (`admin_updated_id`),
  KEY `admin_created_id` (`admin_created_id`),
  KEY `subcategory_id` (`subcategory_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`admin_updated_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`admin_created_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.product: ~3 rows (approximately)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_discount`, `subcategory_id`, `created_time`, `updated_time`, `admin_updated_id`, `admin_created_id`) VALUES
	(1, 'Áo sơ mi Nút màu trơn Thanh lịch', NULL, 40, 7, '2022-04-16 00:00:00', NULL, NULL, 1),
	(2, 'Áo sơ mi nữ Nút phía trước Sọc Giải trí', NULL, 0, 7, '2022-04-17 00:00:00', NULL, NULL, 1),
	(3, 'Áo sơ mi màu trơn Giải trí', NULL, 0, 7, '2022-04-15 00:00:00', NULL, NULL, 1),
	(4, 'Áo sơ mi nữ Thắt lưng Viên lá sen Trọn gói màu trơn Thanh lịch', NULL, 0, 7, '2022-04-22 00:00:00', NULL, NULL, 1),
	(5, 'Áo sơ mi nữ Nút phía trước màu trơn Giải trí', NULL, 0, 7, '2022-04-23 00:00:00', NULL, NULL, 1),
	(6, 'Áo sơ mi nữ Nút màu trơn Giải trí', NULL, 0, 7, '2022-04-21 00:00:00', NULL, NULL, 1),
	(8, 'Áo sơ mi nữ Nút phía trước Rau quả Tất cả trên in Giải trí', NULL, 0, 7, '2022-04-20 00:00:00', NULL, NULL, 1),
	(9, 'Áo sơ mi nữ Nút Ngọc trai màu trơn Thanh lịch', NULL, 20, 7, '2022-04-22 00:00:00', NULL, NULL, 1),
	(10, 'Áo sơ mi nữ viền lá sen Hoa Thanh lịch', NULL, 15, 7, '2022-04-14 00:00:00', NULL, NULL, 1),
	(11, 'Áo sơ mi nữ Thắt nút Nút phía trước màu trơn Thanh lịch', NULL, 0, 7, '2022-04-13 00:00:00', NULL, NULL, 1),
	(12, 'Áo sơ mi nữ Hoa Thanh lịch', NULL, 0, 7, '2022-04-12 00:00:00', NULL, NULL, 1),
	(13, 'Áo sơ mi nữ Nút phía trước Lá thư Giải trí', NULL, 10, 7, '2022-04-11 00:00:00', NULL, NULL, 1),
	(14, 'Áo sơ mi nữ Túi Nút phía trước màu trơn Giải trí', NULL, 0, 7, '2022-04-10 00:00:00', NULL, NULL, 1),
	(15, 'Áo sơ mi nữ Xù màu trơn Giải trí', NULL, 0, 7, '2022-04-10 10:00:00', NULL, NULL, 1),
	(17, 'Áo sơ mi nữ Nút phía trước Tất cả trên in Boho', NULL, 0, 7, '2022-04-16 10:00:00', NULL, NULL, 1),
	(18, 'Áo sơ mi nữ Tương phản ren màu trơn Lãng mạn', NULL, 0, 7, '2022-04-22 10:00:00', NULL, NULL, 1),
	(19, 'Áo sơ mi nữ viền lá sen Nút phía trước Chấm bi Boho', NULL, 0, 7, '2022-04-22 11:00:00', NULL, NULL, 1),
	(20, 'Áo sơ mi nữ viền lá sen Tương phản ràng buộc Nút phía trước màu trơn Giải trí', NULL, 0, 7, '2022-04-22 09:00:00', NULL, NULL, 1),
	(21, 'Áo sơ mi nữ Nút phía trước màu trơn Thanh lịch', NULL, 0, 7, '2022-04-12 10:00:00', NULL, NULL, 1),
	(22, 'Áo sơ mi nữ Nút Cắt ra màu trơn Thanh lịch', NULL, 0, 7, '2022-04-12 09:00:00', NULL, NULL, 1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Dumping structure for table shop.size
CREATE TABLE IF NOT EXISTS `size` (
  `size_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã kích cỡ',
  `size_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tên kích cỡ',
  `quantity` int NOT NULL COMMENT 'Số lượng tồn kho',
  `color_id` int NOT NULL COMMENT 'Mã màu sản phẩm',
  PRIMARY KEY (`size_id`),
  KEY `color_id` (`color_id`),
  CONSTRAINT `size_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.size: ~21 rows (approximately)
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
INSERT INTO `size` (`size_id`, `size_name`, `quantity`, `color_id`) VALUES
	(1, 'XS', 10, 1),
	(2, 'S', 23, 1),
	(3, 'M', 32, 1),
	(4, 'L', 14, 1),
	(5, 'XL', 5, 1),
	(6, 'M', 124, 2),
	(7, 'L', 55, 2),
	(8, 'XL', 33, 2),
	(9, 'M', 112, 3),
	(10, 'L', 43, 3),
	(11, 'XL', 11, 3),
	(12, 'M', 12, 4),
	(13, 'L', 123, 4),
	(14, 'XL', 12, 4),
	(15, 'M', 34, 5),
	(16, 'L', 67, 5),
	(17, 'XL', 22, 5),
	(18, 'M', 56, 6),
	(19, 'L', 23, 6),
	(20, 'XL', 3, 6),
	(21, 'M', 34, 7),
	(22, 'L', 55, 7),
	(23, 'XL', 12, 7),
	(24, 'M', 23, 8),
	(25, 'L', 11, 8),
	(26, 'XL', 76, 8),
	(27, 'M', 11, 9),
	(28, 'L', 23, 9),
	(29, 'XL', 43, 9),
	(30, 'M', 12, 10),
	(31, 'L', 32, 10),
	(32, 'XL', 55, 10),
	(33, 'S', 32, 11),
	(34, 'M', 22, 11),
	(35, 'L', 22, 11),
	(36, 'XS', 43, 12),
	(37, 'X', 234, 12),
	(38, 'M', 34, 12),
	(39, 'L', 54, 12),
	(40, 'XL', 46, 12),
	(41, 'M', 112, 13),
	(42, 'L', 22, 13),
	(43, 'XL', 34, 13),
	(44, 'M', 123, 14),
	(45, 'L', 11, 14),
	(46, 'XL', 23, 14),
	(47, 'M', 23, 15),
	(48, 'L', 43, 15),
	(49, 'XL', 11, 15),
	(50, 'XS', 43, 16),
	(51, 'M', 43, 16),
	(52, 'L', 65, 16),
	(53, 'XL', 23, 16),
	(54, 'M', 213, 17),
	(55, 'L', 243, 17),
	(56, 'XL', 34, 17),
	(57, 'M', 345, 18),
	(58, 'L', 45, 18),
	(59, 'XL', 32, 18),
	(60, 'XS', 33, 19),
	(61, 'M', 43, 19),
	(62, 'L', 434, 19),
	(63, 'XL', 22, 19),
	(64, 'M', 23, 20),
	(65, 'L', 56, 20),
	(66, 'XL', 56, 20),
	(67, 'M', 45, 21),
	(68, 'L', 78, 21),
	(69, 'XL', 89, 21),
	(70, 'M', 56, 22),
	(71, 'L', 67, 22),
	(72, 'XL', 78, 22),
	(73, 'M', 54, 23),
	(74, 'L', 45, 23),
	(75, 'XL', 34, 23),
	(76, 'M', 56, 24),
	(77, 'L', 45, 24),
	(78, 'XL', 34, 24);
/*!40000 ALTER TABLE `size` ENABLE KEYS */;

-- Dumping structure for table shop.subcategory
CREATE TABLE IF NOT EXISTS `subcategory` (
  `subcategory_id` int NOT NULL AUTO_INCREMENT COMMENT 'Mã danh mục con',
  `subcategory_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tên danh mục con',
  `category_id` int NOT NULL COMMENT 'Mã danh mục',
  PRIMARY KEY (`subcategory_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.subcategory: ~48 rows (approximately)
/*!40000 ALTER TABLE `subcategory` DISABLE KEYS */;
INSERT INTO `subcategory` (`subcategory_id`, `subcategory_name`, `category_id`) VALUES
	(1, 'Áo hai dây & ba lỗ', 1),
	(2, 'Áo ống', 1),
	(3, 'Áo thun', 1),
	(7, 'Áo sơ mi', 1),
	(8, 'Áo polo', 1),
	(9, 'Áo len', 1),
	(22, 'Khác', 1),
	(24, 'Áo liền thân', 1),
	(25, 'Quần legging', 2),
	(26, 'Quần dài', 2),
	(27, 'Quần jeans', 2),
	(28, 'Khác', 2),
	(29, 'Quần đùi', 3),
	(30, 'Quần váy', 3),
	(31, 'Khác', 3),
	(32, 'Quần bay (Jumpsuits)', 8),
	(33, 'Quần bay ngắn (Playsuits)', 8),
	(34, 'Quần yếm', 8),
	(35, 'Khác', 8),
	(36, 'Áo khoác mùa đông', 9),
	(37, 'Áo choàng', 9),
	(38, 'Áo blazer', 9),
	(39, 'Áo khoác ngoài', 9),
	(40, 'Áo vest', 9),
	(41, 'Khác', 9),
	(42, 'Áo khoác nỉ', 11),
	(43, 'Áo hoodies', 11),
	(44, 'Khác', 11),
	(45, 'Bộ đồ đôi', 12),
	(46, 'Bộ gia đình', 12),
	(47, 'Bộ lẻ', 12),
	(48, 'Khác', 12),
	(49, 'Pyjama', 14),
	(50, 'Váy ngủ', 14),
	(51, 'Áo choàng ngủ, Áo khoác kimono', 14),
	(52, 'Khác', 14),
	(53, 'Áo', 16),
	(54, 'Quần và chân váy', 16),
	(55, 'Bộ', 16),
	(56, 'Đầm', 16),
	(57, 'Khác', 16),
	(58, 'Tất', 20),
	(59, 'Quần tất', 20),
	(60, 'Khác', 20),
	(61, 'Đầm', 21),
	(62, 'Váy', 21),
	(63, 'Váy cưới', 21),
	(64, 'Khác', 21);
/*!40000 ALTER TABLE `subcategory` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;