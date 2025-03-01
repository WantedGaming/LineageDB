# LineageDB Table Groups

This document categorizes database tables by functional game systems to help developers locate relevant tables quickly.

## Account Management

- **accounts** - User account information
- **account_ban** - Account ban records
- **account_privileges** - Special account permissions
- **login_history** - User login tracking

## Character System

- **characters** - Core character data
- **character_stats** - Character statistics (STR, DEX, etc.)
- **character_appearance** - Visual attributes of characters
- **character_location** - Current world position
- **character_effects** - Active buffs and debuffs
- **character_titles** - Earned character titles

## Inventory System

- **items** - Master item definitions
- **item_templates** - Base item properties
- **inventory** - Character inventory
- **item_attributes** - Special item properties
- **item_enchants** - Item enhancement details
- **item_skins** - Visual appearances for items
- **storage** - Warehouse/storage items

## Combat System

- **skills** - Skill definitions
- **character_skills** - Skills known by characters
- **skill_trees** - Skill progression hierarchies
- **skill_effects** - Effects produced by skills
- **combat_logs** - Records of combat interactions

## Social Systems

- **friends** - Character relationships
- **clans** - Clan/guild data
- **clan_members** - Clan membership
- **clan_privileges** - Clan rank permissions
- **alliances** - Relationships between clans
- **mail** - Mail/message system

## Economy & Trade

- **shops** - NPC shop definitions
- **shop_items** - Items available in shops
- **market_listings** - Player market/auction items
- **trade_logs** - Records of item exchanges
- **price_history** - Historical item values

## World & Environment

- **zones** - World map zones/regions
- **spawn_points** - NPC and monster spawn locations
- **teleport_locations** - Fast travel points
- **world_objects** - Interactive objects in world
- **weather_states** - Environmental conditions

## Quest System

- **quests** - Quest definitions
- **quest_steps** - Sequential quest objectives
- **character_quests** - Character quest progress
- **quest_rewards** - Items/experience gained from quests
- **quest_prerequisites** - Requirements to start quests

## NPC System

- **npcs** - Non-player character definitions
- **npc_drops** - Items dropped by NPCs
- **npc_dialogues** - Conversation trees
- **npc_shops** - Merchants and their inventories
- **npc_spawns** - Spawn locations and timers

## Game Events

- **events** - Special game events
- **event_rewards** - Items/bonuses from events
- **event_participation** - Player participation tracking

## System & Administration

- **server_config** - Global server settings
- **game_logs** - System event logging
- **admin_commands** - Administrative action history
- **maintenance_schedule** - Planned downtimes

## Note
Some tables may belong to multiple functional groups but are listed in their primary category.