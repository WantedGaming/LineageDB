# LineageDB Naming Conventions

This document outlines the naming patterns and conventions used throughout the LineageDB schema.

## Table Naming

- **Singular nouns** for entity tables (e.g., `character`, not `characters`)
- **Plural nouns** for lookup/reference tables (e.g., `items`, `skills`)
- **Underscore_separated** words for multi-word table names
- **Junction tables** named by combining related tables with underscore (e.g., `character_skills`)

## Column Naming

- **Primary keys**: Generally named as `id` or `table_name_id`
- **Foreign keys**: Named as `referenced_table_singular_id` (e.g., `character_id`)
- **Boolean fields**: Prefixed with `is_`, `has_`, or `can_` (e.g., `is_active`, `has_subscription`)
- **Date/time fields**: Suffixed with `_at` for points in time (e.g., `created_at`) or `_date` for calendar dates
- **Enumerated types**: Suffixed with `_type` or `_status` (e.g., `account_status`)

## Data Types and Sizes

- **TINYINT(1)** used for boolean values (0=false, 1=true)
- **VARCHAR** lengths standardized:
  - Usernames: 45 characters
  - Passwords: 75 characters (for hashed values)
  - Names: 35 characters
  - Email addresses: 100 characters
- **INT** used for IDs and numeric values with standard ranges
- **BIGINT** for experience points and other potentially large numeric values
- **DECIMAL(M,N)** for currency and precise numeric values

## Indexes

- **Primary keys**: Named as `pk_table_name`
- **Foreign keys**: Named as `fk_table_name_referenced_table`
- **Unique constraints**: Named as `uk_table_name_column_name`
- **Normal indexes**: Named as `idx_table_name_column_name`

## Common Prefixes/Suffixes

- **tmp_**: Temporary tables
- **log_**: Logging tables
- **_history**: Tables tracking historical changes
- **_archive**: Tables containing archived/old data
- **_config**: Configuration tables

## Game-Specific Conventions

- **Character locations**: Use x, y, z coordinates consistently
- **Status effects**: Use begin_time and end_time for duration
- **Stackable items**: Use count field for quantity
- **Equipment**: Use standardized slot IDs in loc field

## Notes

- These conventions should be followed for all new tables and columns
- Legacy naming patterns may exist in some tables
- When extending the schema, match the existing pattern of related tables