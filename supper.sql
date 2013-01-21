SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db name`
--

-- --------------------------------------------------------

--
-- 表的结构 `supper`
--

CREATE TABLE IF NOT EXISTS `supper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bDate` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `staffId` varchar(10) NOT NULL,
  `place` int(1) NOT NULL,
  `remark` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订餐' AUTO_INCREMENT=83 ;

--
-- 转存表中的数据 `supper`
--

INSERT INTO `supper` (`id`, `bDate`, `name`, `staffId`, `place`, `remark`) VALUES
(1, '2-2', '11', '1', 2, '1');
