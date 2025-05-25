CREATE TABLE `request`
(
    `id`         int                                        NOT NULL,
    `user_id`    int                                        NOT NULL,
    `feedback`   text,
    `created_at` datetime                                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status`     enum ('new','confirm','cancel','progress') NOT NULL DEFAULT 'new',
    `datetime`   datetime                                   NOT NULL,
    `type`       enum ('Мусор','Мебель','Другое','')        NOT NULL
);

CREATE TABLE `user`
(
    `id`       int(11)      NOT NULL,
    `login`    varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `name`     varchar(255) NOT NULL,
    `email`    varchar(255) NOT NULL,
    `phone`    varchar(255) NOT NULL,
    `is_admin` int(11)      NOT NULL DEFAULT 0
);