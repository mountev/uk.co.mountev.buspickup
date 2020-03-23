DROP TABLE IF EXISTS buspickup_locations;
CREATE TABLE IF NOT EXISTS `buspickup_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `location` int(10) unsigned NOT NULL COMMENT 'bus pickup location',
  `k2b_time` varchar(512) COMMENT 'k2b walkers bus pickup time',
  `c2b_time` varchar(512) COMMENT 'c2b walkers bus pickup time',
  `k2b_map` varchar(2048) COMMENT 'k2b location map url or href',
  `c2b_map` varchar(2048) COMMENT 'c2b location map url or href',
  PRIMARY KEY ( `id` )
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
