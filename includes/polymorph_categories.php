<?php
/**
 * Polymorph category definitions
 * Used for filtering and organizing polymorphs
 */

// Major categories for polymorphs
$polymorph_categories = [
    'character' => [
        'name' => 'Character Class',
        'description' => 'Polymorphs based on character classes',
        'subcategories' => [
            'prince' => 'Prince/Princess',
            'knight' => 'Knight',
            'elf' => 'Elf',
            'wizard' => 'Wizard',
            'darkelf' => 'Dark Elf',
            'dragonknight' => 'Dragon Knight',
            'illusionist' => 'Illusionist',
            'warrior' => 'Warrior',
            'fencer' => 'Fencer',
            'lancer' => 'Lancer'
        ]
    ],
    'monster' => [
        'name' => 'Monster',
        'description' => 'Transform into various monsters',
        'subcategories' => [
            'humanoid' => 'Humanoid',
            'undead' => 'Undead',
            'demon' => 'Demon',
            'beast' => 'Beast',
            'dragon' => 'Dragon',
            'elemental' => 'Elemental',
            'other' => 'Other'
        ]
    ],
    'tier' => [
        'name' => 'Progression Tier',
        'description' => 'Polymorphs by power tier',
        'subcategories' => [
            'basic' => 'Basic (Level 1-45)',
            'dark' => 'Dark (Level 50-55)',
            'silver' => 'Silver (Level 60-65)',
            'gold' => 'Gold (Level 70-75)',
            'platinum' => 'Platinum/Jin (Level 80-85)',
            'arch' => 'Arch/Special (Level 90+)'
        ]
    ],
    'special' => [
        'name' => 'Special',
        'description' => 'Event and special polymorphs',
        'subcategories' => [
            'event' => 'Event',
            'seasonal' => 'Seasonal',
            'pvp' => 'PVP Enhanced',
            'npc' => 'NPC Characters',
            'other' => 'Other Special'
        ]
    ]
];

/**
 * Function to determine the likely category of a polymorph
 * @param array $polymorph The polymorph data record
 * @return array The category and subcategory
 */
function getCategoryForPolymorph($polymorph) {
    // Default categories if we can't determine more specific ones
    return ['monster', 'other'];
}