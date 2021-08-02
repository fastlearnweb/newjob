CREATE TABLE `directory` (
  `id` int(11) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `middlename` varchar(128) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


INSERT INTO `directory` (`id`, `lastname`, `firstname`, `middlename`, `date`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', '2021-08-01 23:09:29'),
(2, 'Сидоров', 'Артем', 'Петрович', '2021-08-02 10:03:30'),
(3, 'Арутюнов', 'Вазген', 'Вахирович', '2021-08-02 10:03:43');


CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


INSERT INTO `phones` (`id`, `user_id`, `phone`) VALUES
(1, 1, '88005551122'),
(2, 2, '89182223322'),
(3, 1, '89189956123'),
(4, 2, '89182254322');

ALTER TABLE `directory`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `directory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;