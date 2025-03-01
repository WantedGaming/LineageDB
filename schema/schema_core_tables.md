# LineageDB Core Tables Reference (Lineage 1)

This document details the most critical tables in the Lineage 1 database schema.

## accounts

User authentication and management.

| Column | Type | Description |
|--------|------|-------------|
| login | VARCHAR(45) | Primary key, account name |
| password | VARCHAR(45) | Encrypted password |
| access_level | INT | Admin rights (0=player, >0=staff) |
| last_active | DATETIME | Last login time |
| ip | VARCHAR(20) | Last login IP |
| banned | TINYINT | Account ban status |

## characters

Player characters.

| Column | Type | Description |
|--------|------|-------------|
| char_id | INT | Primary key |
| account_name | VARCHAR(45) | Associated account |
| char_name | VARCHAR(45) | Character name |
| level | INT | Character level |
| hp | INT | Maximum hit points |
| mp | INT | Maximum mana points |
| ac | INT | Armor class (defense) |
| str | INT | Strength stat |
| con | INT | Constitution stat |
| dex | INT | Dexterity stat |
| wis | INT | Wisdom stat |
| int | INT | Intelligence stat |
| cha | INT | Charisma stat |
| alignment | INT | Good/evil alignment |
| race | INT | Character race |
| class | INT | Character class |
| loc_x | INT | X coordinate |
| loc_y | INT | Y coordinate |
| loc_map | INT | Map ID |
| pledge_id | INT | Clan ID |

## character_items

Character-owned items.

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary key, unique item instance |
| char_id | INT | Character ID of owner |
| item_id | INT | Reference to item_templates |
| count | INT | Stack quantity |
| equipped | TINYINT | Equipment status |
| enchant | INT | Enhancement level |
| identified | TINYINT | Identification status |
| durability | INT | Item condition |

## pledge

Clan/bloodpledge information.

| Column | Type | Description |
|--------|------|-------------|
| pledge_id | INT | Primary key |
| name | VARCHAR(45) | Clan name |
| leader_id | INT | Character ID of clan leader |
| castle_id | INT | Castle owned (0=none or castle ID) |
| alliance_id | INT | Alliance ID |
| creation_date | DATETIME | When clan was created |

## item_templates

Item definitions.

| Column | Type | Description |
|--------|------|-------------|
| item_id | INT | Primary key |
| name | VARCHAR(45) | Item name |
| type | INT | Item category |
| material | INT | Material type |
| weight | INT | Item weight |
| gfx_id | INT | Graphics ID |
| min_dmg | INT | Minimum damage (weapons) |
| max_dmg | INT | Maximum damage (weapons) |
| ac | INT | Armor class (armor) |
| use_type | INT | How item is used |
| use_royal | TINYINT | Usable by royal class |
| use_knight | TINYINT | Usable by knight class |
| use_mage | TINYINT | Usable by mage class |
| use_elf | TINYINT | Usable by elf race |
| trade | TINYINT | Tradable status |
| drop | TINYINT | Droppable status |

**Notes:**
- This is a generic structure - your actual database may vary
- Column names might differ between server implementations