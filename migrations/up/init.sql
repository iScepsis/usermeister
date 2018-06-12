CREATE TABLE users (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Id пользователя',
  `name` VARCHAR(30) NOT NULL COMMENT 'Имя',
  `age` INT(3) NOT NULL COMMENT 'Возраст',
  `city_id` INT(6) NULL COMMENT 'Ссылка на город',
  PRIMARY KEY (`id`));
ALTER TABLE users COMMENT = 'Пользователи';

CREATE TABLE cities
(
  id int(6) PRIMARY KEY NOT NULL COMMENT 'id города' AUTO_INCREMENT,
  city varchar(30) NOT NULL
);
CREATE UNIQUE INDEX cities_city_uindex ON cities (city);
ALTER TABLE cities COMMENT = 'Города';

ALTER TABLE users
ADD CONSTRAINT users_city_id_fk
FOREIGN KEY (city_id) REFERENCES cities (id);