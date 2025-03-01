# LineageDB Core Tables Reference

This document details the most critical tables in the Lineage database schema.

## accounts

User authentication and management.

| Column | Type | Description |
|--------|------|-------------|
| login | VARCHAR(45) | Primary key, account name |
| password | VARCHAR(75) | Encrypted password |
| email | VARCHAR(100) | Contact email |
| created_time | INT | Account creation timestamp |
| lastactive | INT | Last login timestamp |
| accessLevel | INT | Admin rights (0=player, >0=staff) |
| lastIP | VARCHAR(20) | Last login IP address |
| lastServer | INT | Last connected game server |
| pcIp | VARCHAR(20) | PC cafe IP address (if applicable) |
| hop1 | VARCHAR(20) | Connection routing data |
| hop2 | VARCHAR(20) | Connection routing data |
| hop3 | VARCHAR(20) | Connection routing data |
| hop4 | VARCHAR(20) | Connection routing data |

**Notes:**
- Primary login credentials for game access
- Access level determines GM/Admin capabilities

## characters

Player characters.

| Column | Type | Description |
|--------|------|-------------|
| charId | INT | Primary key |
| account_name | VARCHAR(45) | Associated account |
| char_name | VARCHAR(35) | Character name |
| level | INT | Character level |
| maxHp | INT | Maximum hit points |
| curHp | INT | Current hit points |
| maxCp | INT | Maximum CP (Combat Points) |
| curCp | INT | Current CP |
| maxMp | INT | Maximum mana points |
| curMp | INT | Current mana points |
| face | INT | Facial appearance |
| hairStyle | INT | Hair style ID |
| hairColor | INT | Hair color ID |
| sex | INT | Gender (0=male, 1=female) |
| heading | INT | Direction facing |
| x | INT | X coordinate |
| y | INT | Y coordinate |
| z | INT | Z coordinate |
| exp | BIGINT | Experience points |
| sp | INT | Skill points |
| karma | INT | Karma/PK counter |
| pvpkills | INT | PvP kill count |
| pkkills | INT | Player kill count |
| clanid | INT | Clan ID |
| race | INT | Character race |
| classid | INT | Character class |
| base_class | INT | Original class before subclass |
| title | VARCHAR(50) | Character title |
| online | TINYINT | Online status |
| onlinetime | INT | Total time played |
| nobless | TINYINT | Noblesse status |
| power_grade | INT | Clan power level |
| subpledge | INT | Clan subgroup |
| last_recom_date | BIGINT | Last recommendation date |
| vitality_points | INT | Vitality system points |

**Notes:**
- Core character data including location and stats
- Links to numerous related tables for skills, items, etc.
- classid refers to specific profession (Knight, Wizard, etc.)

## items

Character-owned items.

| Column | Type | Description |
|--------|------|-------------|
| object_id | INT | Primary key, unique item instance |
| owner_id | INT | Character ID of owner |
| item_id | INT | Reference to item_templates |
| count | BIGINT | Stack quantity |
| enchant_level | INT | Enchantment level |
| loc | VARCHAR(10) | Location code (INVENTORY, PAPERDOLL, WAREHOUSE, etc.) |
| loc_data | INT | Slot position within location |
| time_of_use | INT | Timestamp for timed items |
| custom_type1 | INT | Special flag 1 |
| custom_type2 | INT | Special flag 2 |
| mana_left | INT | Remaining mana in item |
| attr_type | INT | Attribute type |
| attr_value | INT | Attribute value |

**Notes:**
- Represents actual item instances owned by characters
- Different from item_templates which defines base items
- loc determines if equipped, in inventory, or stored

## clan_data

Clan information.

| Column | Type | Description |
|--------|------|-------------|
| clan_id | INT | Primary key |
| clan_name | VARCHAR(45) | Clan name |
| clan_level | INT | Clan level |
| reputation_score | INT | Clan reputation |
| hasCastle | INT | Castle owned (0=none or castle ID) |
| blood_alliance_count | INT | Alliance items count |
| blood_oath_count | INT | Oath items count |
| ally_id | INT | Ally clan ID |
| ally_name | VARCHAR(45) | Ally clan name |
| leader_id | INT | Character ID of clan leader |
| crest_id | INT | Clan crest graphic ID |
| crest_large_id | INT | Large clan crest ID |
| ally_crest_id | INT | Alliance crest ID |
| new_leader_id | INT | Pending leader ID for transfers |

**Notes:**
- Core clan data linking to multiple clan-related tables
- Tracks castles, reputation, and alliances
- Connects to characters via clan_id field

## skill_trees

Class-specific skill progression.

| Column | Type | Description |
|--------|------|-------------|
| class_id | INT | Character class ID |
| skill_id | INT | Skill identifier |
| level | INT | Skill level |
| name | VARCHAR(40) | Skill name |
| sp | INT | Skill points required |
| min_level | INT | Min character level to learn |
| reuse_delay | INT | Cooldown time |
| is_residencial | TINYINT | Castle/residence skill flag |

**Notes:**
- Defines which skills are available to each class
- Used for skill training and progression
- Different from character_skills which tracks learned skills

## npc

NPC templates.

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary key, NPC ID |
| name | VARCHAR(200) | NPC name |
| title | VARCHAR(100) | NPC title |
| class | VARCHAR(200) | NPC classification |
| collision_radius | DECIMAL(6,2) | Collision detection radius |
| collision_height | DECIMAL(6,2) | Collision detection height |
| level | TINYINT | NPC level |
| sex | VARCHAR(6) | Gender |
| type | VARCHAR(22) | NPC type (L2Monster, L2Merchant, etc.) |
| attackrange | INT | Attack distance |
| hp | INT | Hit points |
| mp | INT | Mana points |
| hpreg | DECIMAL(8,2) | HP regeneration rate |
| mpreg | DECIMAL(8,2) | MP regeneration rate |
| str | TINYINT | Strength stat |
| con | TINYINT | Constitution stat |
| dex | TINYINT | Dexterity stat |
| int | TINYINT | Intelligence stat |
| wit | TINYINT | Wit stat |
| men | TINYINT | Mental stat |
| exp | INT | Experience given |
| sp | INT | Skill points given |
| aggro | TINYINT | Aggression range |
| clan | VARCHAR(100) | NPC clan/group |
| absorb_level | TINYINT | Soul crystal absorption ability |

**Notes:**
- Template data for all NPCs, monsters, and bosses
- Actual spawns reference this table
- Base stats scale with level