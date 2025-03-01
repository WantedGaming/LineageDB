# LineageDB Naming Conventions

This document outlines the naming patterns used throughout the Lineage database schema.

## Table Naming Conventions

- **Singular form** for main entity tables (e.g., `character`, `item`)
- **Plural form** for list tables (e.g., `items` for character-owned items)
- **Underscore separator** for multi-word table names (e.g., `castle_manor_procure`)
- **Junction tables** use main tables with underscore (e.g., `character_skills`)
- **System tables** often prefixed with system name (e.g., `olympiad_nobles`)

## Column Naming Conventions

- **camelCase** for most column names (e.g., `charId`, `maxHp`)
- **Primary keys** typically named with entity + 'Id' (e.g., `charId`, `clanId`)
- **Foreign keys** match the primary key name in source table (e.g., `charId` in related tables)
- **Boolean columns** often stored as TINYINT (e.g., `online`, `nobless`)
- **Status columns** typically use numerical codes rather than text

## Lineage-Specific Naming Patterns

- **Character stats**: Uses standard D&D abbreviations (STR, CON, DEX, INT, WIT, MEN)
- **Resources**: `curHp`/`maxHp`, `curMp`/`maxMp`, `curCp`/`maxCp`
- **Coordinates**: Always `x`, `y`, `z` for world positioning
- **Online status**: `online` (0=offline, 1=online)
- **Special statuses**: `nobless`, `hero` as TINYINT flags
- **Location codes**: 
  - `PAPERDOLL` - Equipped items
  - `INVENTORY` - Regular inventory
  - `WAREHOUSE` - Personal storage
  - `CLANWH` - Clan warehouse
  - `PET` - Pet inventory

## Data Type Conventions

- **Character names**: VARCHAR(35)
- **Account names**: VARCHAR(45)
- **Level values**: INT (despite small range, for consistency)
- **Status flags**: TINYINT (0=off, 1=on)
- **Timestamps**: INT (Unix timestamp format)
- **Currency/large numbers**: BIGINT

## Index Naming

Indexes typically follow these patterns:
- Primary keys: `PRIMARY`
- Unique indexes: `key_<column_name>` or `<table>_<column>_unique`
- Foreign keys: Often not explicitly named in schema

## Legacy Patterns

The Lineage database has evolved over many versions. You may encounter:
- Inconsistent capitalization between tables
- Mixed naming conventions from different development periods
- Some redundant or deprecated tables kept for compatibility

## Extending the Schema

When adding new tables or columns:
- Follow the convention of related/similar tables
- Use camelCase for new columns for consistency
- Add appropriate indexes for frequently queried fields
- Document new tables in the appropriate table groups file