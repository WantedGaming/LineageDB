# LineageDB Schema Documentation

This directory contains the database schema documentation for the LineageDB project, based on the Lineage MMORPG database structure.

## Available Documentation

- [Database Diagram (JPEG)](./lineage_schema.jpg)
- [Database Diagram (SVG)](./lineage_schema.svg) - Vector format for better zooming
- [Table Groups](./table_groups.md) - Tables categorized by game subsystem
- [Core Tables Reference](./core_tables.md) - Detailed information on primary tables
- [Naming Conventions](./naming_conventions.md) - Database naming patterns and standards
- [Schema Updates](./schema_updates.md) - Log of schema changes (to be maintained)

## About This Schema

The LineageDB database supports the data persistence needs for the Lineage MMORPG. This complex schema encompasses player accounts, characters, items, skills, quests, NPCs, and numerous game mechanics.

## Using This Documentation

- Refer to the visual diagrams for understanding table relationships
- Check the table groups documentation to locate functionality by game system
- Review core tables documentation for details on critical data structures
- Follow the naming conventions when extending the schema

## Contributing to Documentation

When making schema changes, please:
1. Update the relevant diagrams
2. Document new tables in the appropriate group file
3. Log the change in schema_updates.md
4. Review naming conventions for consistency

Last updated: 2025-03-01