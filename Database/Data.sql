
use projects;

CREATE TABLE `task1` (
    `task_id` int(11) NOT NULL AUTO_INCREMENT,
    `task` varchar(150) NOT NULL,
    `status` varchar(150) NOT NULL,
    PRIMARY KEY(`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

