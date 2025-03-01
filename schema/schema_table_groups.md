# LineageDB Table Groups

This document categorizes database tables by Lineage game systems.

## Account System

- **accounts** - Player account credentials
- **account_data** - Additional account properties
- **account_premium** - Premium/subscription status
- **account_punishment** - Bans and penalties
- **login_history** - Login timestamps and IPs

## Character System

- **characters** - Core character data
- **char_templates** - Base stats by race/class
- **char_stats** - Attributes (STR, DEX, CON, INT, WIT, MEN)
- **character_skills** - Character abilities and magic
- **character_items** - Character equipment and inventory
- **character_subclasses** - Dual class information
- **character_hennas** - Applied henna tattoos
- **character_quests** - Quest progress
- **character_friends** - Friend list
- **character_shortcuts** - UI shortcut configurations
- **character_recipebook** - Known crafting recipes
- **character_macroses** - Custom macro settings
- **character_tpbookmark** - Teleport bookmarks

## Class System

- **class_list** - Character classes (Human Fighter, Elven Mage, etc.)
- **subclass_requirements** - Requirements for subclasses
- **skill_trees** - Class-specific skill progression
- **transform_skill_trees** - Skills for transformation states

## Castle & Territory System

- **castle** - Castle information
- **castle_functions** - Active castle functions
- **castle_doorupgrade** - Door enhancement levels
- **castle_siege_guards** - NPC guard data
- **castle_manor_production** - Seed production in castle territory
- **castle_manor_procure** - Crop procurement data
- **territory_registrations** - Territory ownership
- **territory_ward_locations** - Territory ward spawns

## Clan System

- **clan_data** - Clan basic information
- **clan_subpledges** - Clan squads/divisions
- **clan_privs** - Clan member permissions
- **clan_skills** - Clan abilities
- **clan_wars** - Active clan conflicts
- **clan_notices** - Announcements to members
- **clan_halls** - Clan hall ownership

## Item System

- **item_templates** - Master item definitions
- **armor** - Armor-specific properties
- **weapon** - Weapon-specific properties
- **etcitem** - Miscellaneous item properties
- **items_enchant_stats** - Stats for enchanted items
- **item_attributes** - Element attributes
- **augmentations** - Item augment effects
- **crystalization_recipes** - Item breakdown recipes

## World System

- **zone** - World region definitions
- **spawnlist** - NPC and monster spawn points
- **npc** - Non-player character templates
- **droplist** - Monster drops
- **merchant_buylists** - NPC shop inventories
- **teleport_locations** - Teleport destinations
- **random_spawn** - Random monster spawns
- **seven_signs** - Seven Signs festival data
- **olympiad_data** - PvP tournament system
- **siege_clans** - Clans participating in sieges

## Note
This grouping is specific to Lineage game mechanics. Tables may interact across groups.