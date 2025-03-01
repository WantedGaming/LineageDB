CREATE TABLE `characters` (
  `char_id` INT NOT NULL AUTO_INCREMENT,
  `account_name` VARCHAR(45) NOT NULL,
  `char_name` VARCHAR(45) NOT NULL,
  `level` INT NOT NULL DEFAULT 1,
  `exp` BIGINT NOT NULL DEFAULT 0,
  `hp` INT NOT NULL DEFAULT 1,
  `mp` INT NOT NULL DEFAULT 1,
  `ac` INT NOT NULL DEFAULT 10,     -- Armor class (defense)
  `str` INT NOT NULL DEFAULT 10,    -- Strength
  `con` INT NOT NULL DEFAULT 10,    -- Constitution 
  `dex` INT NOT NULL DEFAULT 10,    -- Dexterity
  `wis` INT NOT NULL DEFAULT 10,    -- Wisdom
  `int` INT NOT NULL DEFAULT 10,    -- Intelligence
  `cha` INT NOT NULL DEFAULT 10,    -- Charisma
  `alignment` INT NOT NULL DEFAULT 0, -- Good/evil alignment
  `gender` INT NOT NULL DEFAULT 0,
  `race` INT NOT NULL DEFAULT 0,    -- Elf, human, etc.
  `class` INT NOT NULL DEFAULT 0,   -- Knight, wizard, etc.
  `current_hp` INT NOT NULL DEFAULT 1,
  `current_mp` INT NOT NULL DEFAULT 1,
  `loc_x` INT NOT NULL DEFAULT 0,
  `loc_y` INT NOT NULL DEFAULT 0,
  `loc_map` INT NOT NULL DEFAULT 0,
  `pledge_id` INT DEFAULT NULL,     -- Clan ID
  `pledge_rank` INT DEFAULT NULL,   -- Position in clan
  `pk_count` INT NOT NULL DEFAULT 0,
  `online` TINYINT NOT NULL DEFAULT 0,
  `last_login` DATETIME DEFAULT NULL,
  PRIMARY KEY (`char_id`),
  UNIQUE KEY `char_name_unique` (`char_name`)
);