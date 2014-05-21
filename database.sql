--
-- Table structure for table `pastes`
--

CREATE TABLE IF NOT EXISTS `pastes` (
`id` int(11) NOT NULL,
  `hash` varchar(40) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `visibility` tinyint(4) NOT NULL,
  `syntax` varchar(128) NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Indexes for table `pastes`
--
ALTER TABLE `pastes`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `hash` (`hash`);

ALTER TABLE `pastes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
