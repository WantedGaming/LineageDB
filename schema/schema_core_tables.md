# LineageDB Core Tables Reference

This document provides detailed information about the most critical tables in the database schema.

## accounts

Central user account storage.

| Column | Type | Description |
|--------|------|-------------|
| account_id | INT | Primary key |
| username | VARCHAR(45) | Account login name |
| password | VARCHAR(75) | Encrypted password |
| email | VARCHAR(100) | User email address |
| access_level | TINYINT | Permission level (0=player, >0=staff) |
| last_login | DATETIME | Most recent login timestamp |
| created_at | DATETIME | Account creation date |
| status | TINYINT | Account status (0=active, 1=banned, etc.) |

**Notes:**
- Username is unique and case-insensitive
- Multiple characters can be associated with one account
- Access levels determine administrative capabilities

## characters

Player character information.

| Column | Type | Description |
|--------|------|-------------|
| char_id | INT | Primary key |
| account_id | INT | Associated account |
| char_name | VARCHAR(35) | Character name |
| race | TINYINT | Character race ID |
| class_id | TINYINT | Character class ID |
| sex | TINYINT | Gender (0=male, 1=female) |
| level | INT | Character level |
| exp | BIGINT | Experience points |
| hp | INT | Current hit points |
| max_hp | INT | Maximum hit points |
| mp | INT | Current mana points |
| max_mp | INT | Maximum mana points |
| sp | INT | Spell points |
| karma | INT | Alignment value |
| face | TINYINT | Facial appearance ID |
| hair_style | TINYINT | Hair style ID |
| hair_color | TINYINT | Hair color ID |
| x | INT | X coordinate in world |
| y | INT | Y coordinate in world |
| z | INT | Z coordinate in world |
| heading | INT | Direction facing |
| delete_time | DATETIME | Scheduled deletion date (NULL if active) |
| created_at | DATETIME | Character creation date |

**Notes:**
- char_name is unique across all characters
- Foreign key to accounts table via account_id
- Location coordinates (x,y,z) represent last saved position

## items

Master item definitions.

| Column | Type | Description |
|--------|------|-------------|
| item_id | INT | Primary key |
| name | VARCHAR(100) | Item name |
| type | TINYINT | Item category (weapon, armor, etc.) |
| weight | INT | Item weight affecting inventory capacity |
| grade | TINYINT | Item quality/tier |
| is_tradable | TINYINT(1) | Whether item can be traded (0=no, 1=yes) |
| is_dropable | TINYINT(1) | Whether item can be dropped (0=no, 1=yes) |
| is_destroyable | TINYINT(1) | Whether item can be destroyed (0=no, 1=yes) |
| is_stackable | TINYINT(1) | Whether item can be stacked (0=no, 1=yes) |
| icon | VARCHAR(100) | UI icon path |
| description | TEXT | Item description |

**Notes:**
- Reference table for all game items
- Extended by type-specific tables (weapons, armor, etc.)
- Used in inventory, shop, and drop tables

## inventory

Character inventory contents.

| Column | Type | Description |
|--------|------|-------------|
| inventory_id | INT | Primary key |
| char_id | INT | Character owning the item |
| item_id | INT | Reference to items table |
| count | INT | Quantity of stackable items |
| loc | TINYINT | Equipment slot or inventory position |
| object_id | INT | Unique instance ID for this specific item |
| enchant_level | TINYINT | Enhancement level |
| custom_type1 | INT | Custom attribute 1 |
| custom_type2 | INT | Custom attribute 2 |

**Notes:**
- Foreign keys to characters and items tables
- loc determines if item is equipped or in inventory
- object_id is unique for each item instance

## skills

Available skills in the game.

| Column | Type | Description |
|--------|------|-------------|
| skill_id | INT | Primary key |
| name | VARCHAR(40) | Skill name |
| level | TINYINT | Skill level |
| sp_cost | INT | Mana/spell points cost |
| hp_cost | INT | Hit points cost |
| mp_cost | INT | Mana points cost |
| cast_range | INT | Maximum distance for targeting |
| hit_time | INT | Casting time in milliseconds |
| reuse_delay | INT | Cooldown time in milliseconds |
| buff_duration | INT | Effect duration for buffs |
| description | TEXT | Skill description |

**Notes:**
- Core reference table for all skills
- Linked to characters via character_skills table
- Multiple levels of the same skill use same base skill_id

## character_skills

Skills known by characters.

| Column | Type | Description |
|--------|------|-------------|
| char_id | INT | Character ID |
| skill_id | INT | Skill ID |
| skill_level | TINYINT | Current skill level |
| is_passive | TINYINT(1) | Whether skill is passive |
| reuse_time_remaining | INT | Remaining cooldown time |

**Notes:**
- Composite primary key on char_id and skill_id
- Foreign keys to characters and skills tables
- Tracks individual character progression in skills