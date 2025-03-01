# LineageDB Database Schema Documentation
Generated: 2025-03-01 13:45:52

## Table: `0_translations`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| text_korean | text | NO | MUL |  |  |
| text_english | text | NO |  |  |  |
| source | varchar(200) | YES | MUL |  |  |
| line_number | int(11) | YES |  |  |  |
| validated | tinyint(1) | NO |  | 0 |  |


## Table: `accounts`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| login | varchar(50) | NO | PRI |  |  |
| password | varchar(50) | NO |  |  |  |
| lastactive | datetime | YES |  |  |  |
| lastQuit | datetime | YES |  |  |  |
| access_level | int(11) | NO |  | 0 |  |
| ip | varchar(20) | NO |  |  |  |
| host | varchar(20) | NO |  |  |  |
| banned | int(11) unsigned | NO |  | 0 |  |
| charslot | int(11) | NO |  | 6 |  |
| warehouse_password | int(11) | NO |  | 0 |  |
| notice | varchar(20) | YES |  | 0 |  |
| quiz | varchar(20) | YES |  |  |  |
| phone | varchar(20) | YES |  |  |  |
| hddId | varchar(255) | YES |  |  |  |
| boardId | varchar(255) | YES |  |  |  |
| Tam_Point | int(11) | NO |  | 0 |  |
| Buff_DMG_Time | datetime | YES |  |  |  |
| Buff_Reduc_Time | datetime | YES |  |  |  |
| Buff_Magic_Time | datetime | YES |  |  |  |
| Buff_Stun_Time | datetime | YES |  |  |  |
| Buff_Hold_Time | datetime | YES |  |  |  |
| BUFF_PCROOM_Time | datetime | YES |  |  |  |
| Buff_FireDefence_Time | datetime | YES |  |  |  |
| Buff_EarthDefence_Time | datetime | YES |  |  |  |
| Buff_WaterDefence_Time | datetime | YES |  |  |  |
| Buff_WindDefence_Time | datetime | YES |  |  |  |
| Buff_SoulDefence_Time | datetime | YES |  |  |  |
| Buff_Str_Time | datetime | YES |  |  |  |
| Buff_Dex_Time | datetime | YES |  |  |  |
| Buff_Wis_Time | datetime | YES |  |  |  |
| Buff_Int_Time | datetime | YES |  |  |  |
| Buff_FireAttack_Time | datetime | YES |  |  |  |
| Buff_EarthAttack_Time | datetime | YES |  |  |  |
| Buff_WaterAttack_Time | datetime | YES |  |  |  |
| Buff_WindAttack_Time | datetime | YES |  |  |  |
| Buff_Hero_Time | datetime | YES |  |  |  |
| Buff_Life_Time | datetime | YES |  |  |  |
| second_password | varchar(11) | YES |  |  |  |
| Ncoin | int(11) | NO |  | 0 |  |
| Npoint | int(11) | NO |  | 0 |  |
| Shop_open_count | int(6) | NO |  | 0 |  |
| DragonRaid_Buff | datetime | YES |  |  |  |
| Einhasad | int(11) | NO |  | 0 |  |
| EinDayBonus | int(2) | NO |  | 0 |  |
| IndunCheckTime | datetime | YES |  |  |  |
| IndunCount | int(2) | NO |  | 0 |  |
| app_char | int(10) | NO |  | 0 |  |
| app_terms_agree | enum('false','true') | NO |  | false |  |
| PSSTime | int(11) | NO |  | 1800 |  |


## Table: `accounts_free_buff_shield`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| account_name | varchar(50) | NO | PRI |  |  |
| favor_locked_time | int(4) | NO |  | 0 |  |
| pccafe_favor_remain_count | int(1) | NO |  | 0 |  |
| free_favor_remain_count | int(1) | NO |  | 0 |  |
| event_favor_remain_count | int(1) | NO |  | 0 |  |
| pccafe_reward_item_count | int(3) | NO |  | 0 |  |
| reset_time | datetime | YES |  |  |  |


## Table: `accounts_pcmaster_golden`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| account_name | varchar(50) | NO | PRI |  |  |
| index_id | int(1) | NO | PRI | 0 |  |
| type | int(1) | NO |  | 1 |  |
| grade | blob | YES |  |  |  |
| remain_time | int(6) | NO |  | 0 |  |


## Table: `accounts_shop_limit`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| accountName | varchar(50) | NO | PRI |  |  |
| buyShopId | int(9) | NO | PRI | 0 |  |
| buyItemId | int(9) | NO | PRI | 0 |  |
| buyCount | int(9) | NO |  | 0 |  |
| buyTime | timestamp | NO |  | 0000-00-00 00:00:00 | on update current_timestamp() |
| limitTerm | enum('WEEK','DAY','NONE') | NO |  | DAY |  |


## Table: `adshop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| account | varchar(13) | NO |  |  |  |
| name | varchar(13) | NO |  |  |  |
| sex | int(15) | NO |  |  |  |
| type | int(15) | NO |  |  |  |
| x | int(15) | NO |  |  |  |
| y | int(15) | NO |  |  |  |
| heading | int(15) | NO |  |  |  |
| map_id | int(15) | NO |  |  |  |


## Table: `ai_user`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| name | varchar(50) | NO | PRI |  |  |
| ai_type | enum('AI_BATTLE','COLOSEUM','HUNT','FISHING','TOWN_MOVE','SCARECROW_ATTACK') | NO | PRI | AI_BATTLE |  |
| level | int(3) | NO |  | 0 |  |
| class | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') | YES |  | crown |  |
| gender | enum('MALE(0)','FEMALE(1)') | NO |  | MALE(0) |  |
| str | int(3) | NO |  | 0 |  |
| con | int(3) | NO |  | 0 |  |
| dex | int(3) | NO |  | 0 |  |
| inti | int(3) | NO |  | 0 |  |
| wis | int(3) | NO |  | 0 |  |
| cha | int(3) | NO |  | 0 |  |
| alignment | int(6) | NO |  | 0 |  |
| hit | int(3) | NO |  | 0 |  |
| bow_hit | int(3) | NO |  | 0 |  |
| dmg | int(3) | NO |  | 0 |  |
| bow_dmg | int(3) | NO |  | 0 |  |
| reduction | int(3) | NO |  | 0 |  |
| skill_hit | int(3) | NO |  | 0 |  |
| spirit_hit | int(3) | NO |  | 0 |  |
| dragon_hit | int(3) | NO |  | 0 |  |
| magic_hit | int(3) | NO |  | 0 |  |
| fear_hit | int(3) | NO |  | 0 |  |
| skill_regist | int(3) | NO |  | 0 |  |
| spirit_regist | int(3) | NO |  | 0 |  |
| dragon_regist | int(3) | NO |  | 0 |  |
| fear_regist | int(3) | NO |  | 0 |  |
| dg | int(3) | NO |  | 0 |  |
| er | int(3) | NO |  | 0 |  |
| me | int(3) | NO |  | 0 |  |
| mr | int(3) | NO |  | 0 |  |
| hp | int(4) | NO |  | 0 |  |
| mp | int(4) | NO |  | 0 |  |
| hpr | int(3) | NO |  | 0 |  |
| mpr | int(3) | NO |  | 0 |  |
| title | varchar(50) | YES |  |  |  |
| clanId | int(2) | NO |  | 0 |  |
| clanname | varchar(50) | YES |  |  |  |
| elfAttr | int(2) | NO |  | 0 |  |


## Table: `ai_user_buff`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| class | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') | NO | PRI | crown |  |
| elfAttr | int(2) | NO | PRI | 0 |  |
| buff | text | YES |  |  |  |


## Table: `ai_user_drop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| class | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','all') | NO | PRI | all |  |
| itemId | int(10) | NO | PRI | 0 |  |
| name | varchar(100) | YES |  |  |  |
| count | int(10) | NO |  | 1 |  |
| chance | int(3) | NO |  | 100 |  |


## Table: `ai_user_fish`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| loc_x | int(5) | NO | PRI | 0 |  |
| loc_y | int(5) | NO | PRI | 0 |  |
| heading | int(1) | NO |  | 0 |  |
| fish_x | int(5) | NO |  | 0 |  |
| fish_y | int(5) | NO |  | 0 |  |


## Table: `ai_user_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| class | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','all') | NO | PRI | all |  |
| itemId | int(10) | NO | PRI | 0 |  |
| name | varchar(100) | YES |  |  |  |
| count | int(10) | NO |  | 1 |  |
| enchantLevel | int(2) | NO |  | 0 |  |
| attrLevel | int(2) | NO |  | 0 |  |
| equip | enum('false','true') | NO |  | false |  |


## Table: `ai_user_ment`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) | NO | PRI |  |  |
| ment | varchar(100) | YES |  |  |  |
| type | enum('login','logout','kill','death') | YES |  | login |  |


## Table: `ai_user_skill`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| class | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') | NO | PRI | crown |  |
| active | text | YES |  |  |  |
| passive | text | YES |  |  |  |


## Table: `app_alim_log`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| account_name | varchar(50) | YES | MUL |  |  |
| logContent | varchar(255) | YES |  |  |  |
| type | int(2) | NO |  | 0 |  |
| insertTime | datetime | YES |  |  |  |
| status | enum('false','true') | NO |  | false |  |


## Table: `app_auth_extension`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| extension | varchar(5) | NO | PRI |  |  |


## Table: `app_board_content`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  | NULL |  |
| date | datetime | YES |  |  |  |
| title | varchar(200) | YES |  |  |  |
| content | mediumtext | YES |  |  |  |
| readcount | int(10) | YES |  | 0 |  |
| chatype | int(2) | YES |  | 0 |  |
| chasex | int(1) | YES |  | 0 |  |
| likenames | text | YES |  |  |  |
| mainImg | varchar(100) | YES |  |  |  |
| top | enum('true','false') | NO |  | false |  |


## Table: `app_board_content_comment`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| boardId | int(10) | NO |  | 0 |  |
| name | varchar(16) | NO |  |  |  |
| chaType | int(2) | NO |  | 0 |  |
| chaSex | int(1) | NO |  | 0 |  |
| date | datetime | NO |  |  |  |
| content | varchar(1000) | NO |  |  |  |
| likenames | text | YES |  |  |  |


## Table: `app_board_free`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  | NULL |  |
| date | datetime | YES |  |  |  |
| title | varchar(200) | YES |  |  |  |
| content | mediumtext | YES |  |  |  |
| readcount | int(10) | YES |  | 0 |  |
| chatype | int(2) | YES |  | 0 |  |
| chasex | int(1) | YES |  | 0 |  |
| likenames | text | YES |  |  |  |
| mainImg | varchar(100) | YES |  |  |  |


## Table: `app_board_free_comment`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| boardId | int(10) | NO |  | 0 |  |
| name | varchar(16) | NO |  |  |  |
| chaType | int(2) | NO |  | 0 |  |
| chaSex | int(1) | NO |  | 0 |  |
| date | datetime | NO |  |  |  |
| content | varchar(1000) | NO |  |  |  |
| likenames | text | YES |  |  |  |


## Table: `app_board_notice`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  | NULL |  |
| date | datetime | YES |  |  |  |
| title | varchar(200) | YES |  | NULL |  |
| content | mediumtext | YES |  |  |  |
| readcount | int(10) | YES |  | 0 |  |
| type | int(1) | YES |  | 0 |  |
| top | enum('false','true') | NO |  | false |  |
| mainImg | varchar(100) | YES |  |  |  |


## Table: `app_board_pitch`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  | NULL |  |
| date | datetime | YES |  |  |  |
| title | varchar(200) | YES |  |  |  |
| content | mediumtext | YES |  |  |  |
| readcount | int(10) | YES |  | 0 |  |
| chatype | int(2) | YES |  | 0 |  |
| chasex | int(1) | YES |  | 0 |  |
| likenames | text | YES |  |  |  |
| mainImg | varchar(100) | YES |  |  |  |
| top | enum('true','false') | NO |  | false |  |


## Table: `app_board_pitch_comment`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| boardId | int(10) | NO |  | 0 |  |
| name | varchar(16) | NO |  |  |  |
| chaType | int(2) | NO |  | 0 |  |
| chaSex | int(1) | NO |  | 0 |  |
| date | datetime | NO |  |  |  |
| content | varchar(1000) | NO |  |  |  |
| likenames | text | YES |  |  |  |


## Table: `app_coupon`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| number | varchar(50) | NO | PRI |  |  |
| type | enum('VOUCHER','NCOIN','NPOINT') | NO |  | NCOIN |  |
| price | int(11) | NO |  | 0 |  |
| status | enum('false','true') | NO |  | false |  |
| useAccount | varchar(45) | YES |  |  |  |
| createTime | datetime | NO |  |  |  |
| useTime | datetime | YES |  |  |  |


## Table: `app_customer`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| login | varchar(45) | NO |  |  |  |
| type | int(1) | NO |  | 1 |  |
| title | varchar(150) | NO |  |  |  |
| content | text | NO |  |  |  |
| status | enum('Submitted','Answered') | NO |  | Submitted |  |
| date | datetime | NO |  |  |  |
| comment | text | YES |  |  |  |
| commentDate | datetime | YES |  |  |  |


## Table: `app_customer_normal`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| title | varchar(150) | NO |  |  |  |
| content | text | NO |  |  |  |


## Table: `app_dictionary_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| schar | varchar(50) | NO | PRI |  |  |


## Table: `app_engine_log`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| account | varchar(50) | NO |  |  |  |
| engine | varchar(100) | NO |  |  |  |
| time | datetime | NO |  |  |  |


## Table: `app_extra_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| extra_info_id | int(11) | NO | PRI |  | auto_increment |
| extra_info_type | enum('ITEM','NPC','SKILL','MAP') | NO |  |  |  |
| name | varchar(100) | NO | UNI |  |  |
| extra_info | text | NO |  |  |  |
| active | tinyint(1) | NO |  | 1 |  |


## Table: `app_guide`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(2) | NO | PRI | 0 |  |
| title | varchar(100) | NO |  |  |  |
| content | mediumtext | YES |  |  |  |


## Table: `app_guide_boss`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(2) | NO | PRI | 0 |  |
| loc | int(2) | NO |  | 0 |  |
| locName | varchar(50) | NO |  |  |  |
| number | int(2) | NO |  | 0 |  |
| bossName | varchar(50) | NO |  |  |  |
| bossImg | varchar(100) | NO |  |  |  |
| spawnLoc | varchar(500) | NO |  |  |  |
| spawnTime | varchar(500) | NO |  |  |  |
| dropName | varchar(500) | YES |  |  |  |


## Table: `app_guide_recommend`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(1) | NO | PRI | 0 |  |
| title | varchar(100) | NO |  |  |  |
| content | varchar(100) | NO |  |  |  |
| url | varchar(100) | NO |  |  |  |
| img | varchar(100) | NO |  |  |  |


## Table: `app_item_search`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| seq | int(11) | NO | PRI |  | auto_increment |
| item_name | varchar(250) | NO | PRI |  |  |
| item_keyword | varchar(250) | NO |  |  |  |


## Table: `app_nshop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| itemid | int(10) | NO |  | 0 |  |
| itemname | varchar(50) | NO |  |  |  |
| price | int(10) | NO |  | 0 |  |
| price_type | enum('NCOIN','NPOINT') | NO |  | NCOIN |  |
| saved_point | int(10) | NO |  | 0 |  |
| pack | int(10) | NO |  | 0 |  |
| enchant | int(10) | NO |  | 0 |  |
| limitCount | int(10) | NO |  | 50 |  |
| flag | enum('NONE','DISCOUNT','ESSENTIAL','HOT','LIMIT','LIMIT_MONTH','LIMIT_WEEK','NEW','REDKNIGHT') | NO |  | NONE |  |
| iteminfo | varchar(700) | NO |  |  |  |


## Table: `app_page_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| uri | varchar(100) | NO | PRI |  |  |
| path | varchar(100) | YES |  |  |  |
| className | varchar(100) | NO |  |  |  |
| cnbType | int(2) | NO |  | 0 |  |
| cnbSubType | int(2) | NO |  | 0 |  |
| needIngame | enum('true','false') | NO |  | false |  |
| needLauncher | enum('true','false') | NO |  | false |  |
| needLogin | enum('true','false') | NO |  | false |  |
| needGm | enum('true','false') | NO |  | false |  |
| Json | enum('true','false') | NO |  | false |  |
| fileUpload | enum('true','false') | NO |  | false |  |


## Table: `app_powerbook`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| title | varchar(200) | NO |  | NULL |  |
| content | mediumtext | YES |  |  |  |
| mainImg | varchar(100) | YES |  |  |  |
| main | enum('true','false') | NO |  | false |  |
| guideMain | enum('true','false') | NO |  | false |  |


## Table: `app_powerbook_guide`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| group_type | enum('1. Beginner''s Guide','2. Classes','3. Items','4. Magic','5. Magic Dolls','6. Monsters & Dungeons','7. Party Content','8. World Content','9. Combat System','10. Community','11. Main Systems','12. Service') | NO | PRI | 1. Beginner's Guide |  |
| id | int(2) | NO | PRI | 0 |  |
| title | varchar(100) | NO |  |  |  |
| uri | varchar(100) | NO |  |  |  |
| is_new | enum('true','false') | NO |  | false |  |


## Table: `app_promotion`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(2) | NO | PRI | 0 |  |
| title | varchar(100) | NO |  |  |  |
| subText | varchar(100) | NO |  |  |  |
| promotionDate | varchar(100) | YES |  |  |  |
| targetLink | varchar(100) | NO |  |  |  |
| promotionImg | varchar(100) | NO |  |  |  |
| listallImg | varchar(100) | NO |  |  |  |


## Table: `app_report`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| name | varchar(45) | NO |  |  |  |
| targetName | varchar(45) | NO |  |  |  |
| type | enum('Sexual','Abuse','Advertisement','Illegal Program','Content','Privacy','Lies','Other') | NO |  | Sexual |  |
| log | text | YES |  |  |  |
| date | datetime | NO |  |  |  |


## Table: `app_shop_rank`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| group_type | enum('1.All','2.Weapon','3.Armor','4.Accessory','5.Other') | NO | PRI | 1.All |  |
| shop_type | enum('1.Sell','2.Buy') | NO | PRI | 1.Sell |  |
| id | int(1) | NO | PRI | 0 |  |
| item_id | int(10) | NO |  | 0 |  |
| enchant | int(3) | NO |  | 0 |  |
| search_rank | int(2) | NO |  | 0 |  |


## Table: `app_support`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| account_name | varchar(50) | NO |  |  |  |
| character_name | varchar(50) | NO |  |  |  |
| pay_amount | int(10) | NO |  | 0 |  |
| write_date | datetime | YES |  |  |  |
| status | enum('STANBY','FINISH') | NO |  | STANBY |  |


## Table: `app_support_message`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| type | enum('AGREE','PROGRESS','REWARD') | NO | PRI | AGREE |  |
| index_id | int(2) | NO | PRI | 1 |  |
| content | varchar(200) | NO |  |  |  |


## Table: `app_support_request`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| account_name | varchar(50) | NO |  |  |  |
| character_name | varchar(50) | NO |  |  |  |
| request_date | datetime | NO |  |  |  |
| response | text | YES |  |  |  |
| response_date | datetime | YES |  |  |  |


## Table: `app_trade`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI | 0 |  |
| title | varchar(100) | NO |  |  |  |
| content | varchar(1000) | NO |  |  |  |
| bank | varchar(100) | NO |  |  |  |
| bankNumber | varchar(50) | NO |  |  |  |
| status | enum('SELL','IN_PROGRESS','COMPLETED','CANCELLED') | NO |  | SELL |  |
| sellerName | varchar(45) | NO |  |  |  |
| sellerCharacter | varchar(45) | NO |  |  |  |
| sellerPhone | varchar(20) | NO |  |  |  |
| buyerName | varchar(45) | YES |  |  |  |
| buyerCharacter | varchar(45) | YES |  |  |  |
| buyerPhone | varchar(20) | YES |  |  |  |
| writeTime | datetime | NO |  |  |  |
| send | enum('false','true') | NO |  | false |  |
| receive | enum('false','true') | NO |  | false |  |
| completeTime | datetime | YES |  |  |  |
| sellerCancle | enum('false','true') | NO |  | false |  |
| buyerCancle | enum('false','true') | NO |  | false |  |
| top | enum('true','false') | NO |  | false |  |


## Table: `app_uri_block`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| uri | varchar(100) | NO | PRI |  |  |


## Table: `app_uri_pass`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| uri | varchar(100) | NO | PRI |  |  |


## Table: `area`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| areaid | int(5) | NO | PRI | 0 |  |
| mapid | int(5) | NO |  | 0 |  |
| areaname | varchar(50) | YES |  |  |  |
| x1 | int(6) | NO |  | 0 |  |
| y1 | int(6) | NO |  | 0 |  |
| x2 | int(6) | NO |  | 0 |  |
| y2 | int(6) | NO |  | 0 |  |
| flag | int(1) | NO |  | 0 |  |
| restart | int(4) | NO |  | 0 |  |


## Table: `armor`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(5) | NO | PRI | 0 |  |
| item_name_id | int(10) | NO |  | 0 |  |
| desc_kr | varchar(70) | YES |  | NULL |  |
| desc_en | varchar(100) | NO |  |  |  |
| desc_powerbook | varchar(100) | NO |  |  |  |
| note | text | NO |  |  |  |
| desc_id | varchar(45) | NO |  |  |  |
| itemGrade | enum('ONLY','MYTH','LEGEND','HERO','RARE','ADVANC','NORMAL') | NO |  | NORMAL |  |
| type | enum('NONE','HELMET','ARMOR','T_SHIRT','CLOAK','GLOVE','BOOTS','SHIELD','AMULET','RING','BELT','RING_2','EARRING','GARDER','RON','PAIR','SENTENCE','SHOULDER','BADGE','PENDANT') | NO |  | NONE |  |
| grade | int(2) | NO |  | 0 |  |
| material | enum('NONE(-)','LIQUID(액체)','WAX(밀랍)','VEGGY(식물성)','FLESH(동물성)','PAPER(종이)','CLOTH(천)','LEATHER(가죽)','WOOD(나무)','BONE(뼈)','DRAGON_HIDE(용비늘)','IRON(철)','METAL(금속)','COPPER(구리)','SILVER(은)','GOLD(금)','PLATINUM(백금)','MITHRIL(미스릴)','PLASTIC(블랙미스릴)','GLASS(유리)','GEMSTONE(보석)','MINERAL(광석)','ORIHARUKON(오리하루콘)','DRANIUM(드라니움)') | NO |  | NONE(-) |  |
| weight | int(7) unsigned | NO |  | 0 |  |
| iconId | int(5) unsigned | NO |  | 0 |  |
| spriteId | int(5) unsigned | NO |  | 0 |  |
| ac | int(3) | NO |  | 0 |  |
| ac_sub | int(3) | NO |  | 0 |  |
| safenchant | int(2) | NO |  | 0 |  |
| use_royal | int(2) unsigned | NO |  | 0 |  |
| use_knight | int(2) unsigned | NO |  | 0 |  |
| use_mage | int(2) unsigned | NO |  | 0 |  |
| use_elf | int(2) unsigned | NO |  | 0 |  |
| use_darkelf | int(2) unsigned | NO |  | 0 |  |
| use_dragonknight | int(2) unsigned | NO |  | 0 |  |
| use_illusionist | int(2) unsigned | NO |  | 0 |  |
| use_warrior | int(2) unsigned | NO |  | 0 |  |
| use_fencer | int(2) unsigned | NO |  | 0 |  |
| use_lancer | int(2) unsigned | NO |  | 0 |  |
| add_str | int(2) | NO |  | 0 |  |
| add_con | int(2) | NO |  | 0 |  |
| add_dex | int(2) | NO |  | 0 |  |
| add_int | int(2) | NO |  | 0 |  |
| add_wis | int(2) | NO |  | 0 |  |
| add_cha | int(2) | NO |  | 0 |  |
| add_hp | int(6) | NO |  | 0 |  |
| add_mp | int(6) | NO |  | 0 |  |
| add_hpr | int(6) | NO |  | 0 |  |
| add_mpr | int(6) | NO |  | 0 |  |
| add_sp | int(3) | NO |  | 0 |  |
| min_lvl | int(3) unsigned | NO |  | 0 |  |
| max_lvl | int(3) unsigned | NO |  | 0 |  |
| m_def | int(2) | NO |  | 0 |  |
| haste_item | int(2) unsigned | NO |  | 0 |  |
| carryBonus | int(4) unsigned | NO |  | 0 |  |
| hit_rate | int(2) | NO |  | 0 |  |
| dmg_rate | int(2) | NO |  | 0 |  |
| bow_hit_rate | int(2) | NO |  | 0 |  |
| bow_dmg_rate | int(2) | NO |  | 0 |  |
| bless | int(2) unsigned | NO |  | 1 |  |
| trade | int(2) unsigned | NO |  | 0 |  |
| retrieve | int(2) unsigned | NO |  | 0 |  |
| specialretrieve | int(2) unsigned | NO |  | 0 |  |
| retrieveEnchant | int(2) | NO |  | 0 |  |
| cant_delete | int(2) unsigned | NO |  | 0 |  |
| cant_sell | int(2) unsigned | NO |  | 0 |  |
| max_use_time | int(10) | NO |  | 0 |  |
| defense_water | int(2) | NO |  | 0 |  |
| defense_wind | int(2) | NO |  | 0 |  |
| defense_fire | int(2) | NO |  | 0 |  |
| defense_earth | int(2) | NO |  | 0 |  |
| attr_all | int(2) | NO |  | 0 |  |
| regist_stone | int(2) | NO |  | 0 |  |
| regist_sleep | int(2) | NO |  | 0 |  |
| regist_freeze | int(2) | NO |  | 0 |  |
| regist_blind | int(2) | NO |  | 0 |  |
| regist_skill | int(2) | NO |  | 0 |  |
| regist_spirit | int(2) | NO |  | 0 |  |
| regist_dragon | int(2) | NO |  | 0 |  |
| regist_fear | int(2) | NO |  | 0 |  |
| regist_all | int(2) | NO |  | 0 |  |
| hitup_skill | int(2) | NO |  | 0 |  |
| hitup_spirit | int(2) | NO |  | 0 |  |
| hitup_dragon | int(2) | NO |  | 0 |  |
| hitup_fear | int(2) | NO |  | 0 |  |
| hitup_all | int(2) | NO |  | 0 |  |
| hitup_magic | int(2) | NO |  | 0 |  |
| damage_reduction | int(2) | NO |  | 0 |  |
| MagicDamageReduction | int(2) | NO |  | 0 |  |
| reductionEgnor | int(2) | NO |  | 0 |  |
| reductionPercent | int(2) | NO |  | 0 |  |
| PVPDamage | int(2) | NO |  | 0 |  |
| PVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamageReductionPercent | int(2) | NO |  | 0 |  |
| PVPMagicDamageReduction | int(2) | NO |  | 0 |  |
| PVPReductionEgnor | int(2) | NO |  | 0 |  |
| PVPMagicDamageReductionEgnor | int(2) | NO |  | 0 |  |
| abnormalStatusDamageReduction | int(2) | NO |  | 0 |  |
| abnormalStatusPVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamagePercent | int(2) | NO |  | 0 |  |
| expBonus | int(3) | NO |  | 0 |  |
| rest_exp_reduce_efficiency | int(3) | NO |  | 0 |  |
| shortCritical | int(2) | NO |  | 0 |  |
| longCritical | int(2) | NO |  | 0 |  |
| magicCritical | int(2) | NO |  | 0 |  |
| addDg | int(2) | NO |  | 0 |  |
| addEr | int(2) | NO |  | 0 |  |
| addMe | int(2) | NO |  | 0 |  |
| poisonRegist | enum('false','true') | NO |  | false |  |
| imunEgnor | int(3) | NO |  | 0 |  |
| stunDuration | int(2) | NO |  | 0 |  |
| tripleArrowStun | int(2) | NO |  | 0 |  |
| strangeTimeIncrease | int(4) | NO |  | 0 |  |
| strangeTimeDecrease | int(4) | NO |  | 0 |  |
| potionRegist | int(2) | NO |  | 0 |  |
| potionPercent | int(2) | NO |  | 0 |  |
| potionValue | int(2) | NO |  | 0 |  |
| hprAbsol32Second | int(2) | NO |  | 0 |  |
| mprAbsol64Second | int(2) | NO |  | 0 |  |
| mprAbsol16Second | int(2) | NO |  | 0 |  |
| hpPotionDelayDecrease | int(4) | NO |  | 0 |  |
| hpPotionCriticalProb | int(4) | NO |  | 0 |  |
| increaseArmorSkillProb | int(4) | NO |  | 0 |  |
| attackSpeedDelayRate | int(3) | NO |  | 0 |  |
| moveSpeedDelayRate | int(3) | NO |  | 0 |  |
| MainId | int(10) | NO |  | 0 |  |
| MainId2 | int(10) | NO |  | 0 |  |
| MainId3 | int(10) | NO |  | 0 |  |
| Set_Id | int(10) | NO |  | 0 |  |
| polyDescId | int(6) | NO |  | 0 |  |
| Magic_name | varchar(20) | YES |  |  |  |


## Table: `armor_set`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| note | varchar(45) | YES |  |  |  |
| sets | varchar(1000) | NO |  |  |  |
| polyid | int(6) | NO |  | 0 |  |
| min_enchant | int(2) | NO |  | 0 |  |
| ac | int(2) | NO |  | 0 |  |
| hp | int(5) | NO |  | 0 |  |
| mp | int(5) | NO |  | 0 |  |
| hpr | int(5) | NO |  | 0 |  |
| mpr | int(5) | NO |  | 0 |  |
| mr | int(5) | NO |  | 0 |  |
| str | int(2) | NO |  | 0 |  |
| dex | int(2) | NO |  | 0 |  |
| con | int(2) | NO |  | 0 |  |
| wis | int(2) | NO |  | 0 |  |
| cha | int(2) | NO |  | 0 |  |
| intl | int(2) | NO |  | 0 |  |
| shorthitup | int(2) | NO |  | 0 |  |
| shortdmgup | int(2) | NO |  | 0 |  |
| shortCritical | int(2) | NO |  | 0 |  |
| longhitup | int(2) | NO |  | 0 |  |
| longdmgup | int(2) | NO |  | 0 |  |
| longCritical | int(2) | NO |  | 0 |  |
| sp | int(2) | NO |  | 0 |  |
| magichitup | int(2) | NO |  | 0 |  |
| magicCritical | int(2) | NO |  | 0 |  |
| earth | int(10) | NO |  | 0 |  |
| fire | int(10) | NO |  | 0 |  |
| wind | int(10) | NO |  | 0 |  |
| water | int(10) | NO |  | 0 |  |
| reduction | int(2) | NO |  | 0 |  |
| reductionEgnor | int(2) | NO |  | 0 |  |
| magicReduction | int(2) | NO |  | 0 |  |
| PVPDamage | int(2) | NO |  | 0 |  |
| PVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPMagicDamageReduction | int(2) | NO |  | 0 |  |
| PVPReductionEgnor | int(2) | NO |  | 0 |  |
| PVPMagicDamageReductionEgnor | int(2) | NO |  | 0 |  |
| abnormalStatusDamageReduction | int(2) | NO |  | 0 |  |
| abnormalStatusPVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamagePercent | int(2) | NO |  | 0 |  |
| expBonus | int(2) | NO |  | 0 |  |
| rest_exp_reduce_efficiency | int(2) | NO |  | 0 |  |
| dg | int(2) | NO |  | 0 |  |
| er | int(2) | NO |  | 0 |  |
| me | int(2) | NO |  | 0 |  |
| toleranceSkill | int(2) | NO |  | 0 |  |
| toleranceSpirit | int(2) | NO |  | 0 |  |
| toleranceDragon | int(2) | NO |  | 0 |  |
| toleranceFear | int(2) | NO |  | 0 |  |
| toleranceAll | int(2) | NO |  | 0 |  |
| hitupSkill | int(2) | NO |  | 0 |  |
| hitupSpirit | int(2) | NO |  | 0 |  |
| hitupDragon | int(2) | NO |  | 0 |  |
| hitupFear | int(2) | NO |  | 0 |  |
| hitupAll | int(2) | NO |  | 0 |  |
| strangeTimeIncrease | int(4) | NO |  | 0 |  |
| underWater | enum('true','false') | NO |  | false |  |


## Table: `attendance_accounts`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| account | varchar(50) | NO | PRI |  |  |
| dailyCount | int(4) | NO |  | 0 |  |
| isCompleted | enum('true','false') | NO |  | false |  |
| resetDate | datetime | YES |  |  |  |
| groupData | blob | YES |  |  |  |
| groupOpen | blob | YES |  |  |  |
| randomItems | text | YES |  |  |  |
| rewardHistory | text | YES |  |  |  |


## Table: `attendance_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| groupType | int(3) | NO | PRI | 0 |  |
| index | int(3) | NO | PRI | 0 |  |
| item_id | int(10) | NO |  | 0 |  |
| item_name | varchar(45) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| enchant | int(3) | YES |  | 0 |  |
| count | int(10) | YES |  | 1 |  |
| broadcast | enum('true','false') | NO |  | false |  |
| bonus_type | enum('RandomDiceItem(3)','GiveItem(2)','UseItem(1)') | NO |  | GiveItem(2) |  |


## Table: `attendance_item_random`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| groupType | int(1) | NO | PRI | 0 |  |
| index | int(3) | NO | PRI | 0 |  |
| itemId | int(10) | NO |  | 0 |  |
| itemName | varchar(45) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| count | int(10) | NO |  | 1 |  |
| broadcast | enum('false','true') | NO |  | false |  |
| level | enum('1','2','3','4','5') | NO |  | 1 |  |


## Table: `auth_ip`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| ip | varchar(15) | NO | PRI |  |  |


## Table: `autoloot`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(11) | NO | PRI | 0 |  |
| note | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |


## Table: `balance`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| attackerType | enum('npc','lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') | NO | PRI | crown |  |
| targetType | enum('npc','lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') | NO | PRI | crown |  |
| physicalDmg | int(3) | NO |  | 0 |  |
| physicalHit | int(3) | NO |  | 0 |  |
| physicalReduction | int(3) | NO |  | 0 |  |
| magicDmg | int(3) | NO |  | 0 |  |
| magicHit | int(3) | NO |  | 0 |  |
| magicReduction | int(3) | NO |  | 0 |  |


## Table: `ban_account`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| account | varchar(100) | NO | PRI |  |  |
| reason | enum('BUG_ABOUS','CHAT_ABOUS','CHEAT','ETC') | NO | PRI | ETC |  |
| counter | int(3) | NO |  | 1 |  |
| limitTime | datetime | NO |  |  |  |


## Table: `ban_board`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| number | varchar(100) | NO | PRI |  |  |
| account | varchar(50) | NO |  |  |  |
| registTime | datetime | NO |  |  |  |


## Table: `ban_hdd`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| number | varchar(100) | NO | PRI |  |  |
| account | varchar(50) | NO |  |  |  |
| registTime | datetime | NO |  |  |  |


## Table: `ban_ip`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| address | varchar(255) | NO | PRI |  |  |
| reason | enum('CONNECTION_OVER','PACKET_ATTACK','BAD_USER','UNSUAL_REQUEST','WEB_URI_LENGTH_OVER','WEB_REQUEST_OVER','SERVER_SLANDER','WELLKNOWN_PORT','BUG_ABOUS','CHEAT','ETC','WEB_ATTACK_REQUEST','WEB_NOT_AUTH_IP') | NO |  | ETC |  |
| registTime | datetime | NO |  |  |  |


## Table: `beginner`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| item_id | int(6) | NO |  | 0 |  |
| count | int(10) | NO |  | 0 |  |
| charge_count | int(10) | NO |  | 0 |  |
| enchantlvl | int(6) | NO |  | 0 |  |
| item_name | varchar(50) | NO |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| activate | enum('A','P','K','E','W','D','T','B','J','F','L') | NO |  | A |  |


## Table: `beginner_addteleport`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  |  |
| num_id | int(10) unsigned | NO |  | 0 |  |
| speed_id | int(10) | NO |  | -1 |  |
| char_id | int(10) unsigned | NO | MUL | 0 |  |
| name | varchar(45) | NO |  |  |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |
| randomX | int(10) unsigned | NO |  | 0 |  |
| randomY | int(10) unsigned | NO |  | 0 |  |
| item_obj_id | int(10) unsigned | NO |  | 0 |  |


## Table: `beginner_box`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemid | int(20) | NO |  |  |  |
| count | int(20) | NO |  | 0 |  |
| enchantlvl | int(6) | NO |  | 0 |  |
| item_name | varchar(50) | NO |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| bless | int(10) | NO |  | 1 |  |
| activate | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','all') | NO |  | all |  |


## Table: `beginner_quest`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| quest_id | int(10) | NO | PRI |  |  |
| note | varchar(45) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| use | enum('true','false') | NO |  | true |  |
| auto_complete | enum('false','true') | NO |  | false |  |
| fastLevel | int(3) | NO |  | 0 |  |


## Table: `beginner_quest_drop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| classId | int(10) | NO | PRI | 0 |  |
| desc | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| mainQuestId | int(3) | NO |  | 0 |  |
| mainItemNameId | int(10) | NO |  | 0 |  |
| subQuestId | int(3) | NO |  | 0 |  |
| subItemNameId | int(10) | NO |  | 0 |  |


## Table: `beginner_teleport`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| name | varchar(45) | NO |  |  |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |


## Table: `bin_armor_element_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| type | int(2) | NO | PRI | 0 |  |
| enchant | int(2) | NO | PRI | 0 |  |
| fr | int(2) | NO |  | 0 |  |
| wr | int(2) | NO |  | 0 |  |
| ar | int(2) | NO |  | 0 |  |
| er | int(2) | NO |  | 0 |  |


## Table: `bin_catalyst_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| nameId | int(6) | NO | PRI | 0 |  |
| nameId_kr | varchar(100) | YES |  |  |  |
| input | int(6) | NO | PRI | 0 |  |
| input_kr | varchar(100) | YES |  |  |  |
| output | int(6) | NO | PRI | 0 |  |
| output_kr | varchar(100) | YES |  |  |  |
| successProb | int(3) | NO |  | 0 |  |
| rewardCount | int(6) | NO |  | 0 |  |
| preserveProb | int(3) | NO |  | 0 |  |
| failOutput | int(6) | NO | PRI | 0 |  |
| failOutput_kr | varchar(100) | YES |  |  |  |


## Table: `bin_charged_time_map_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(1) | NO | PRI | 0 |  |
| groups | text | YES |  |  |  |
| multi_group_list | text | YES |  |  |  |


## Table: `bin_companion_class_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| classId | int(6) | NO | PRI | 0 |  |
| class | varchar(100) | YES |  |  |  |
| category | enum('DOG_FIGHT(5)','WILD(4)','PET(3)','DEVINE_BEAST(2)','FIERCE_ANIMAL(1)') | NO |  | FIERCE_ANIMAL(1) |  |
| element | enum('LIGHT(5)','EARTH(4)','AIR(3)','WATER(2)','FIRE(1)','NONE(0)') | NO |  | NONE(0) |  |
| skill | text | YES |  |  |  |


## Table: `bin_companion_enchant_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| tier | int(3) | NO | PRI |  |  |
| enchantCost | text | YES |  |  |  |
| openCost | text | YES |  |  |  |


## Table: `bin_companion_skill_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) | NO | PRI | 0 |  |
| descNum | int(6) | NO |  | 0 |  |
| descKr | varchar(100) | YES |  |  |  |
| enchantBonus | text | YES |  |  |  |


## Table: `bin_companion_stat_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) | NO | PRI | 0 |  |
| statType | enum('INT(2)','CON(1)','STR(0)') | NO |  | STR(0) |  |
| value | int(3) | NO |  | 0 |  |
| meleeDmg | int(3) | NO |  | 0 |  |
| meleeHit | int(3) | NO |  | 0 |  |
| regenHP | int(3) | NO |  | 0 |  |
| ac | int(3) | NO |  | 0 |  |
| spellDmg | int(3) | NO |  | 0 |  |
| spellHit | int(3) | NO |  | 0 |  |


## Table: `bin_craft_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| craft_id | int(6) | NO | PRI | 0 |  |
| desc_id | int(6) | NO |  | 0 |  |
| desc_kr | varchar(100) | YES |  |  |  |
| min_level | int(3) | NO |  | 0 |  |
| max_level | int(3) | NO |  | 0 |  |
| required_gender | int(2) | NO |  | 0 |  |
| min_align | int(6) | NO |  | 0 |  |
| max_align | int(6) | NO |  | 0 |  |
| min_karma | int(10) | NO |  | 0 |  |
| max_karma | int(10) | NO |  | 0 |  |
| max_count | int(6) | NO |  | 0 |  |
| is_show | enum('true','false') | NO |  | false |  |
| PCCafeOnly | enum('true','false') | NO |  | false |  |
| bmProbOpen | enum('true','false') | NO |  | false |  |
| required_classes | int(6) | NO |  | 0 |  |
| required_quests | text | YES |  |  |  |
| required_sprites | text | YES |  |  |  |
| required_items | text | YES |  |  |  |
| inputs_arr_input_item | text | YES |  |  |  |
| inputs_arr_option_item | text | YES |  |  |  |
| outputs_success | text | YES |  |  |  |
| outputs_failure | text | YES |  |  |  |
| outputs_success_prob_by_million | int(10) | NO |  | 0 |  |
| batch_delay_sec | int(10) | NO |  | 0 |  |
| period_list | text | YES |  |  |  |
| cur_successcount | int(10) | NO |  | 0 |  |
| max_successcount | int(10) | NO |  | 0 |  |
| except_npc | enum('true','false') | NO |  | false |  |
| SuccessCountType | enum('World(0)','Account(1)','Character(2)','AllServers(3)') | NO |  | World(0) |  |


## Table: `bin_einpoint_cost_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| value | int(3) | NO | PRI | 0 |  |
| point | int(10) | NO |  | 0 |  |


## Table: `bin_einpoint_faith_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| GroupId | int(3) | NO | PRI | 0 |  |
| spellId | int(10) | NO |  | 0 |  |
| Index_indexId | int(3) | NO | PRI | 0 |  |
| Index_spellId | int(10) | NO |  | 0 |  |
| Index_cost | int(10) | NO |  | 0 |  |
| Index_duration | int(10) | NO |  | 0 |  |
| Index_additional_desc | int(6) | NO |  | 0 |  |
| Index_additional_desc_kr | varchar(100) | YES |  |  |  |
| additional_desc | int(6) | NO |  | 0 |  |
| additional_desc_kr | varchar(100) | YES |  |  |  |
| BuffInfo_tooltipStrId | int(6) | NO |  | 0 |  |
| BuffInfo_tooltipStrId_kr | varchar(100) | YES |  |  |  |


## Table: `bin_einpoint_meta_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| index_id | int(3) | NO | PRI | 0 |  |
| stat_type | enum('BLESS(0)','LUCKY(1)','VITAL(2)','ITEM_SPELL_PROB(3)','ABSOLUTE_REGEN(4)','POTION(5)','ATTACK_SPELL(6)','PVP_REDUCTION(7)','PVE_REDUCTION(8)','_MAX_(9)') | NO |  | _MAX_(9) |  |
| AbilityMetaData1_token | varchar(100) | YES |  |  |  |
| AbilityMetaData1_x100 | enum('true','false') | NO |  | false |  |
| AbilityMetaData1_unit | enum('None(1)','Percent(2)') | NO |  | None(1) |  |
| AbilityMetaData2_token | varchar(100) | YES |  |  |  |
| AbilityMetaData2_x100 | enum('true','false') | NO |  | false |  |
| AbilityMetaData2_unit | enum('None(1)','Percent(2)') | NO |  | None(1) |  |


## Table: `bin_einpoint_normal_prob_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| Normal_level | int(3) | NO | PRI | 0 |  |
| prob | int(10) | NO |  | 0 |  |


## Table: `bin_einpoint_overstat_prob_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| over_level | int(3) | NO | PRI | 0 |  |
| prob | int(10) | NO |  | 0 |  |


## Table: `bin_einpoint_prob_table_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| isLastChance | enum('true','false') | NO | PRI | false |  |
| bonusPoint | int(3) | NO | PRI | 0 |  |
| prob | int(10) | NO |  | 0 |  |


## Table: `bin_einpoint_stat_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| index_id | int(3) | NO | PRI | 0 |  |
| stat_type | enum('BLESS(0)','LUCKY(1)','VITAL(2)','ITEM_SPELL_PROB(3)','ABSOLUTE_REGEN(4)','POTION(5)','ATTACK_SPELL(6)','PVP_REDUCTION(7)','PVE_REDUCTION(8)','_MAX_(9)') | NO |  | _MAX_(9) |  |
| value | int(3) | NO | PRI | 0 |  |
| Ability1_minIncValue | int(3) | NO |  | 0 |  |
| Ability1_maxIncValue | int(3) | NO |  | 0 |  |
| Ability2_minIncValue | int(3) | NO |  | 0 |  |
| Ability2_maxIncValue | int(3) | NO |  | 0 |  |
| StatMaxInfo_level | int(3) | NO |  | 0 |  |
| StatMaxInfo_statMax | int(3) | NO |  | 0 |  |
| eachStatMax | int(3) | NO |  | 0 |  |
| totalStatMax | int(3) | NO |  | 0 |  |


## Table: `bin_element_enchant_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| prob_index | int(3) | NO | PRI | 0 |  |
| type_index | int(3) | NO | PRI | 0 |  |
| level | int(3) | NO | PRI | 0 |  |
| increaseProb | int(3) | NO |  | 0 |  |
| decreaseProb | int(3) | NO |  | 0 |  |


## Table: `bin_enchant_scroll_table_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| enchantType | int(3) | NO | PRI | 0 |  |
| nameid | int(6) | NO | PRI | 0 |  |
| desc_kr | varchar(100) | YES |  |  |  |
| targetEnchant | int(3) | NO |  | 0 |  |
| noTargetMaterialList | text | YES |  |  |  |
| target_category | enum('NONE(0)','WEAPON(1)','ARMOR(2)','ACCESSORY(3)','ELEMENT(4)') | NO |  | NONE(0) |  |
| isBmEnchantScroll | enum('false','true') | NO |  | false |  |
| elementalType | int(2) | NO |  | 0 |  |
| useBlesscodeScroll | int(2) | NO |  | 0 |  |


## Table: `bin_enchant_table_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_index | int(10) | NO | PRI | 0 |  |
| bonusLevel_index | int(10) | NO | PRI | 0 |  |
| enchantSuccessProb | int(10) | NO |  | 0 |  |
| enchantTotalProb | int(10) | NO |  | 0 |  |
| bmEnchantSuccessProb | int(10) | NO |  | 0 |  |
| bmEnchantRemainProb | int(10) | NO |  | 0 |  |
| bmEnchantFailDownProb | int(10) | NO |  | 0 |  |
| bmEnchantTotalProb | int(10) | NO |  | 0 |  |


## Table: `bin_entermaps_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(6) | NO | PRI | 0 |  |
| action_name | varchar(50) | NO | PRI |  |  |
| number_id | int(6) | NO |  | 0 |  |
| loc_x | int(6) | NO |  | 0 |  |
| loc_y | int(6) | NO |  | 0 |  |
| loc_range | int(3) | NO |  | 0 |  |
| priority_id | int(2) | NO |  | 0 |  |
| maxUser | int(3) | NO |  | 0 |  |
| conditions | text | YES |  |  |  |
| destinations | text | YES |  |  |  |


## Table: `bin_favorbook_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| category_id | int(2) | NO | PRI | 0 |  |
| desc_id | varchar(50) | YES |  |  |  |
| desc_kr | varchar(100) | YES |  |  |  |
| start_date | datetime | YES |  |  |  |
| end_date | datetime | YES |  |  |  |
| sort | int(2) | NO |  | 0 |  |
| slot_id | int(2) | NO | PRI | 0 |  |
| state_infos | text | YES |  |  |  |
| red_dot_notice | int(2) | NO |  | 0 |  |
| default_display_item_id | int(5) | NO |  | 0 |  |


## Table: `bin_general_goods_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| NameId | int(6) | NO | PRI | 0 |  |
| NameId_kr | varchar(100) | YES |  |  |  |


## Table: `bin_huntingquest_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| maxQuestCount | int(3) | NO |  | 0 |  |
| goalKillCount | int(3) | NO |  | 0 |  |
| reset_HourOfDay | int(2) | NO |  | -1 |  |
| reward_normal_ConditionalRewards | text | YES |  |  |  |
| reward_normal_UsedItemID | int(6) | NO |  |  |  |
| reward_normal_UsedAmount | int(6) | NO |  | 0 |  |
| reward_dragon_ConditionalRewards | text | YES |  |  |  |
| reward_dragon_UsedItemID | int(6) | NO |  | 0 |  |
| reward_dragon_UsedAmount | int(6) | NO |  | 0 |  |
| reward_hightdragon_ConditionalRewards | text | YES |  |  |  |
| reward_hightdragon_UsedItemID | int(6) | NO |  | 0 |  |
| reward_hightdragon_UsedAmount | int(6) | NO |  | 0 |  |
| requiredCondition_MinLevel | int(3) | NO |  | 0 |  |
| requiredCondition_MaxLevel | int(3) | NO |  | 0 |  |
| requiredCondition_Map | int(6) | NO | PRI | 0 |  |
| requiredCondition_LocationDesc | int(6) | NO | PRI | 0 |  |
| enterMapID | int(6) | NO |  | 0 |  |


## Table: `bin_indun_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mapKind | int(3) | NO | PRI | 0 |  |
| keyItemId | int(5) | NO |  | 0 |  |
| minPlayer | int(2) | NO |  | 0 |  |
| maxPlayer | int(2) | NO |  | 0 |  |
| minAdena | int(6) | NO |  | 0 |  |
| maxAdena | int(6) | NO |  | 0 |  |
| minLevel | varchar(100) | YES |  |  |  |
| bmkeyItemId | int(5) | NO |  | 0 |  |
| eventKeyItemId | int(5) | NO |  | 0 |  |
| dungeon_type | enum('UNDEFINED(0)','DEFENCE_TYPE(1)','DUNGEON_TYPE(2)') | NO |  | UNDEFINED(0) |  |
| enable_boost_mode | enum('false','true') | NO |  | false |  |


## Table: `bin_item_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| name_id | int(6) | NO | PRI | 0 |  |
| icon_id | int(6) | NO |  | 0 |  |
| sprite_id | int(6) | NO |  | 0 |  |
| desc_id | varchar(100) | YES |  |  |  |
| real_desc | varchar(100) | YES |  |  |  |
| desc_kr | varchar(100) | YES |  |  |  |
| material | enum('DRANIUM(23)','ORIHARUKON(22)','MINERAL(21)','GEMSTONE(20)','GLASS(19)','PLASTIC(18)','MITHRIL(17)','PLATINUM(16)','GOLD(15)','SILVER(14)','COPPER(13)','METAL(12)','IRON(11)','DRAGON_HIDE(10)','BONE(9)','WOOD(8)','LEATHER(7)','CLOTH(6)','PAPER(5)','FLESH(4)','VEGGY(3)','WAX(2)','LIQUID(1)','NONE(0)') | NO |  | NONE(0) |  |
| weight_1000ea | int(10) | NO |  | 0 |  |
| level_limit_min | int(3) | NO |  | 0 |  |
| level_limit_max | int(3) | NO |  | 0 |  |
| prince_permit | enum('true','false') | NO |  | false |  |
| knight_permit | enum('true','false') | NO |  | false |  |
| elf_permit | enum('true','false') | NO |  | false |  |
| magician_permit | enum('true','false') | NO |  | false |  |
| darkelf_permit | enum('true','false') | NO |  | false |  |
| dragonknight_permit | enum('true','false') | NO |  | false |  |
| illusionist_permit | enum('true','false') | NO |  | false |  |
| warrior_permit | enum('true','false') | NO |  | false |  |
| fencer_permit | enum('true','false') | NO |  | false |  |
| lancer_permit | enum('true','false') | NO |  | false |  |
| equip_bonus_list | text | YES |  |  |  |
| interaction_type | int(3) | NO |  | 0 |  |
| real_weight | int(10) | NO |  | 0 |  |
| spell_range | int(2) | NO |  | 0 |  |
| item_category | enum('WAND(1013)','AUTO_USED_BY_BUFF_ITEM(1012)','SPELL_EXTRACTOR(1011)','ARROW(1010)','POTION_MANA(1009)','LUCKY_BAG(1008)','WAND_CALL_LIGHTNING(1007)','ARMOR_SERIES_MAIN(1006)','ARMOR_SERIES(1005)','SCROLL(1004)','SCROLL_TELEPORT_HOME(1003)','SCROLL_TELEPORT_TOWN(1002)','POTION_HEAL(1001)','POTION(1000)','ITEM(23)','LIGHT(22)','FOOD(21)','ARMOR(19)','WEAPON(1)','NONE(0)') | NO |  | NONE(0) |  |
| body_part | enum('BODYPART_ALL(-1)','BP_PENDANT(33554432)','BP_INSIGNIA(16777216)','BP_PAULDRON(8388608)','BP_HERALDRY(4194304)','EXT_SLOTS(2097152)','RUNE(1048576)','L_WRIST(524288)','R_WRIST(262144)','BACK(131072)','L_SHOULDER(65536)','R_SHOULDER(32768)','EAR(16384)','WAIST(8192)','NECK(4096)','R_FINGER(2048)','L_FINGER(1024)','R_HOLD(512)','L_HOLD(256)','R_HAND(128)','L_HAND(64)','FOOT(32)','LEG(16)','CLOAK(8)','SHIRT(4)','TORSO(2)','HEAD(1)','NONE(0)') | NO |  | NONE(0) |  |
| ac | int(6) | NO |  | 0 |  |
| extended_weapon_type | enum('WEAPON_EX_NOT_EQUIPPED(13)','WEAPON_EX_KIRINGKU(12)','WEAPON_EX_DOUBLE_AXE(11)','WEAPON_EX_CHAIN_SWORD(10)','WEAPON_EX_GAUNTLET(9)','WEAPON_EX_CRAW(8)','WEAPON_EX_DOUBLE_SWORD(7)','WEAPON_EX_LARGE_SWORD(6)','WEAPON_EX_DAGGER(5)','WEAPON_EX_STAFF(4)','WEAPON_EX_SPEAR(3)','WEAPON_EX_BOW(2)','WEAPON_EX_AXE(1)','WEAPON_EX_ONEHAND_SWORD(0)','NONE(-1)') | NO |  | NONE(-1) |  |
| large_damage | int(3) | NO |  | 0 |  |
| small_damage | int(3) | NO |  | 0 |  |
| hit_bonus | int(3) | NO |  | 0 |  |
| damage_bonus | int(3) | NO |  | 0 |  |
| armor_series_info | text | YES |  |  |  |
| cost | int(10) | NO |  | 0 |  |
| can_set_mage_enchant | enum('true','false') | NO |  | false |  |
| merge | enum('true','false') | NO |  | false |  |
| pss_event_item | enum('true','false') | NO |  | false |  |
| market_searching_item | enum('true','false') | NO |  | false |  |
| lucky_bag_reward_list | text | YES |  |  |  |
| element_enchant_table | int(3) | NO |  | 0 |  |
| accessory_enchant_table | int(3) | NO |  | 0 |  |
| bm_prob_open | int(3) | NO |  | 0 |  |
| enchant_type | int(3) | NO |  | 0 |  |
| is_elven | enum('true','false') | NO |  | false |  |
| forced_elemental_enchant | int(3) | NO |  | 0 |  |
| max_enchant | int(3) | NO |  | 0 |  |
| energy_lost | enum('true','false') | NO |  | false |  |
| prob | int(6) | NO |  | 0 |  |
| pss_heal_item | enum('false','true') | NO |  | false |  |
| useInterval | bigint(10) | NO |  | 0 |  |


## Table: `bin_ndl_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| map_number | int(6) | NO | PRI | 0 |  |
| npc_classId | int(6) | NO | PRI | 0 |  |
| npc_desc_kr | varchar(100) | YES |  |  |  |
| territory_startXY | int(10) | NO | PRI | 0 |  |
| territory_endXY | int(10) | NO | PRI | 0 |  |
| territory_location_desc | int(6) | NO |  | 0 |  |
| territory_average_npc_value | int(10) | NO |  | 0 |  |
| territory_average_ac | int(10) | NO |  | 0 |  |
| territory_average_level | int(10) | NO |  | 0 |  |
| territory_average_wis | int(10) | NO |  | 0 |  |
| territory_average_mr | int(10) | NO |  | 0 |  |
| territory_average_magic_barrier | int(10) | NO |  | 0 |  |


## Table: `bin_npc_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| class_id | int(6) | NO | PRI | 0 |  |
| npc_id | int(11) | NO |  |  |  |
| with_bin_spawn | tinyint(1) | NO |  |  |  |
| sprite_id | int(6) | NO |  | 0 |  |
| desc_id | varchar(100) | YES |  |  |  |
| desc_kr | varchar(100) | YES |  |  |  |
| level | int(3) | NO |  | 0 |  |
| hp | int(9) | NO |  | 0 |  |
| mp | int(9) | NO |  | 0 |  |
| ac | int(3) | NO |  | 0 |  |
| str | int(3) | NO |  | 0 |  |
| con | int(3) | NO |  | 0 |  |
| dex | int(3) | NO |  | 0 |  |
| wis | int(3) | NO |  | 0 |  |
| inti | int(3) | NO |  | 0 |  |
| cha | int(3) | NO |  | 0 |  |
| mr | int(3) | NO |  | 0 |  |
| magic_level | int(3) | NO |  | 0 |  |
| magic_bonus | int(3) | NO |  | 0 |  |
| magic_evasion | int(3) | NO |  | 0 |  |
| resistance_fire | int(3) | NO |  | 0 |  |
| resistance_water | int(3) | NO |  | 0 |  |
| resistance_air | int(3) | NO |  | 0 |  |
| resistance_earth | int(3) | NO |  | 0 |  |
| alignment | int(6) | NO |  | 0 |  |
| big | enum('true','false') | NO |  | false |  |
| drop_items | text | YES |  |  |  |
| tendency | enum('AGGRESSIVE(2)','PASSIVE(1)','NEUTRAL(0)') | NO |  | NEUTRAL(0) |  |
| category | int(10) | NO |  | 0 |  |
| is_bossmonster | enum('true','false') | NO |  | false |  |
| can_turnundead | enum('true','false') | NO |  | false |  |


## Table: `bin_passivespell_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| passive_id | int(10) | NO | PRI | 0 |  |
| duration | int(10) | NO |  | 0 |  |
| spell_bonus_list | text | YES |  |  |  |
| delay_group_id | int(2) | NO |  | 0 |  |
| extract_item_name_id | int(6) | NO |  | 0 |  |
| extract_item_count | int(6) | NO |  | 0 |  |


## Table: `bin_pc_master_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| utilities | text | YES |  |  |  |
| pc_bonus_map_infos | text | YES |  |  |  |
| notification | text | YES |  |  |  |
| buff_group | text | YES |  |  |  |
| buff_bonus | text | YES |  |  |  |


## Table: `bin_portrait_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| asset_id | int(5) | NO | PRI | 0 |  |
| desc_id | varchar(100) | YES |  |  |  |
| desc_kr | varchar(100) | YES |  |  |  |


## Table: `bin_potential_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(4) | NO | PRI | 0 |  |
| grade | int(2) | NO |  | 0 |  |
| desc_id | int(6) | NO |  | 0 |  |
| desc_kr | varchar(100) | YES |  |  |  |
| material_list | text | YES |  |  |  |
| event_config | text | YES |  |  |  |


## Table: `bin_ship_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(2) | NO | PRI | 0 |  |
| dockWorld | int(6) | NO |  | 0 |  |
| shipWorld | int(6) | NO |  | 0 |  |
| ticket | int(6) | NO |  | 0 |  |
| levelLimit | int(3) | NO |  | 0 |  |
| dock_startX | int(5) | NO |  | 0 |  |
| dock_startY | int(5) | NO |  | 0 |  |
| dock_endX | int(5) | NO |  | 0 |  |
| dock_endY | int(5) | NO |  | 0 |  |
| shipLoc_x | int(5) | NO |  | 0 |  |
| shipLoc_y | int(5) | NO |  | 0 |  |
| destWorld | int(6) | NO |  | 0 |  |
| destLoc_x | int(5) | NO |  | 0 |  |
| destLoc_y | int(5) | NO |  | 0 |  |
| destLoc_range | int(3) | NO |  | 0 |  |
| schedule_day | varchar(100) | YES |  |  |  |
| schedule_time | blob | YES |  |  |  |
| schedule_duration | int(2) | NO |  | 0 |  |
| schedule_ship_operating_duration | int(2) | NO |  | 0 |  |
| returnWorld | int(6) | NO |  | 0 |  |
| returnLoc_x | int(5) | NO |  | 0 |  |
| returnLoc_y | int(5) | NO |  | 0 |  |


## Table: `bin_spell_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| spell_id | int(10) | NO | PRI | 0 |  |
| spell_category | enum('COMPANION_SPELL_BUFF(2)','SPELL_BUFF(1)','SPELL(0)') | NO |  | SPELL(0) |  |
| on_icon_id | int(6) | NO |  | 0 |  |
| off_icon_id | int(6) | NO |  | 0 |  |
| duration | int(10) | NO |  | 0 |  |
| tooltip_str_id | int(6) | NO |  | 0 |  |
| tooltip_str_kr | varchar(200) | YES |  |  |  |
| spell_bonus_list | text | YES |  |  |  |
| companion_on_icon_id | int(6) | NO |  | 0 |  |
| companion_off_icon_id | int(6) | NO |  | 0 |  |
| companion_icon_priority | int(3) | NO |  | 0 |  |
| companion_tooltip_str_id | int(6) | NO |  | 0 |  |
| companion_new_str_id | int(6) | NO |  | 0 |  |
| companion_end_str_id | int(6) | NO |  | 0 |  |
| companion_is_good | int(3) | NO |  | 0 |  |
| companion_duration_show_type | int(3) | NO |  | 0 |  |
| delay_group_id | int(2) | NO |  | 0 |  |
| extract_item_name_id | int(6) | NO |  | 0 |  |
| extract_item_count | int(6) | NO |  | 0 |  |


## Table: `bin_timecollection_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| buffSelect | text | YES |  |  |  |
| rewardList | text | YES |  |  |  |
| enchantSection | text | YES |  |  |  |
| group_id | int(3) | NO | PRI | 0 |  |
| group_desc | int(6) | NO |  | 0 |  |
| group_desc_kr | varchar(100) | YES |  |  |  |
| group_level_min | int(3) | NO |  | 0 |  |
| group_level_max | int(3) | NO |  | 0 |  |
| group_period_StartDate | varchar(100) | YES |  |  |  |
| group_period_EndDate | varchar(100) | YES |  |  |  |
| group_set_id | int(3) | NO | PRI | 0 |  |
| group_set_desc | int(6) | NO |  | 0 |  |
| group_set_desc_kr | varchar(100) | YES |  |  |  |
| group_set_defaultTime | varchar(100) | YES |  |  |  |
| group_set_recycle | int(3) | NO |  | 0 |  |
| group_set_itemSlot | text | YES |  |  |  |
| group_set_BuffType | text | YES |  |  |  |
| group_set_endBonus | enum('true','false') | NO |  | false |  |
| group_set_ExtraTimeId | int(10) | NO |  | 0 |  |
| group_set_SetType | enum('NONE(-1)','TC_INFINITY(0)','TC_LIMITED(1)','TC_BONUS_INFINITY(2)','TC_BONUS_LIMITED(3)','TC_ADENA_REFILL(4)','TC_ADENA_REFILL_ERROR(5)','TC_BONUS_ADENA_REFILL(6)','TC_BONUS_ADENA_REFILL_ERROR(7)') | NO |  | NONE(-1) |  |
| ExtraTimeSection | text | YES |  |  |  |
| NPCDialogInfo | text | YES |  |  |  |
| AlarmSetting | text | YES |  |  |  |


## Table: `bin_treasurebox_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(2) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| excavateTime | int(2) | NO |  | 0 |  |
| desc_id | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | YES |  |  |  |
| grade | enum('Common(0)','Good(1)','Prime(2)','Legendary(3)') | NO |  | Common(0) |  |


## Table: `bin_treasureboxreward_common`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| nameid | int(6) | NO | PRI | 0 |  |
| desc_kr | varchar(50) | YES |  |  |  |
| grade | enum('Common(0)','Good(1)','Prime(2)','Legendary(3)') | NO |  | Common(0) |  |


## Table: `board_app_lfc`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  | NULL |  |
| date | varchar(16) | YES |  | NULL |  |
| title | varchar(16) | YES |  | NULL |  |
| content | varchar(100) | YES |  | NULL |  |


## Table: `board_auction`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| house_id | int(10) unsigned | NO | PRI | 0 |  |
| house_name | varchar(45) | NO |  |  |  |
| house_area | int(10) unsigned | NO |  | 0 |  |
| deadline | datetime | YES |  |  |  |
| price | int(10) unsigned | NO |  | 0 |  |
| location | varchar(45) | NO |  |  |  |
| old_owner | varchar(45) | NO |  |  |  |
| old_owner_id | int(10) unsigned | NO |  | 0 |  |
| bidder | varchar(45) | NO |  |  |  |
| bidder_id | int(10) unsigned | NO |  | 0 |  |


## Table: `board_free`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_notice`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_notice1`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_notice2`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_notice3`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(50) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_posts_fix`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_posts_key`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_user`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `board_user1`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO |  |  |  |
| name | varchar(16) | YES |  |  |  |
| date | varchar(16) | YES |  |  |  |
| title | varchar(16) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `bots`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| name | varchar(255) | NO |  |  |  |
| x | int(2) | NO |  | 0 |  |
| y | int(2) | NO |  | 0 |  |
| heading | int(2) | NO |  | 0 |  |
| mapId | int(10) | NO |  |  |  |
| type | int(11) | NO |  |  |  |


## Table: `castle`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| castle_id | int(11) | NO | PRI | 0 |  |
| name | varchar(45) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| war_time | datetime | YES |  |  |  |
| tax_rate | int(11) | NO |  | 0 |  |
| public_money | int(11) | NO |  | 0 |  |


## Table: `castle_present`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemid | int(20) | NO | PRI |  |  |
| count | int(20) | NO |  | 0 |  |
| memo | varchar(20) | NO |  |  |  |


## Table: `castle_soldier`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| castle_id | int(2) | NO | PRI |  | auto_increment |
| soldier1 | int(2) | NO |  | 0 |  |
| soldier1_npcid | int(6) | NO |  | 0 |  |
| soldier1_name | varchar(10) | NO |  |  |  |
| soldier2 | int(2) | NO |  | 0 |  |
| soldier2_npcid | int(6) | NO |  | 0 |  |
| soldier2_name | varchar(10) | NO |  |  |  |
| soldier3 | int(2) | NO |  | 0 |  |
| soldier3_npcid | int(6) | NO |  | 0 |  |
| soldier3_name | varchar(10) | NO |  |  |  |
| soldier4 | int(2) | NO |  | 0 |  |
| soldier4_npcid | int(6) | NO |  | 0 |  |
| soldier4_name | varchar(10) | NO |  | 0 |  |


## Table: `catalyst`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| nameId | int(6) | NO | PRI | 0 |  |
| nameId_kr | varchar(100) | YES |  |  |  |
| nameId_en | varchar(100) | NO |  |  |  |
| input | int(6) | NO | PRI | 0 |  |
| input_kr | varchar(100) | YES |  |  |  |
| input_en | varchar(100) | NO |  |  |  |
| successProb | int(3) | NO |  | 0 |  |
| broad | enum('true','false') | NO |  | false |  |


## Table: `catalyst_custom`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI | 0 |  |
| desc_kr | varchar(100) | YES |  |  |  |
| desc_en | varchar(100) | NO |  |  |  |
| input_itemId | int(10) | NO | PRI | 0 |  |
| input_enchant | int(3) | NO | PRI | 0 |  |
| input_desc_kr | varchar(100) | YES |  |  |  |
| input_desc | varchar(100) | NO |  |  |  |
| output_itemId | int(10) | NO |  | 0 |  |
| output_desc_kr | varchar(100) | YES |  |  |  |
| output_desc | varchar(100) | NO |  |  |  |
| successProb | int(3) | NO |  | 100 |  |
| rewardCount | int(10) | NO |  | 1 |  |
| rewardEnchant | int(3) | NO |  | 0 |  |
| broad | enum('true','false') | NO |  | false |  |


## Table: `character_arca`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(1) | NO | PRI | 0 |  |
| charId | int(10) | NO | PRI | 0 |  |
| day | int(3) | NO |  | 0 |  |
| useItemId | int(10) | NO |  | 0 |  |


## Table: `character_beginner_quest`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| charId | int(10) | NO | PRI | 0 |  |
| info | text | NO |  |  |  |


## Table: `character_buddys`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | MUL |  | auto_increment |
| char_id | int(10) | NO | PRI | 0 |  |
| buddy_name | varchar(45) | NO | PRI |  |  |
| buddy_memo | varchar(45) | NO |  |  |  |


## Table: `character_buff`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_obj_id | int(10) | NO | PRI | 0 |  |
| skill_id | int(10) | NO | PRI | -1 |  |
| remaining_time | int(10) | NO |  | 0 |  |
| poly_id | int(10) | YES |  | 0 |  |


## Table: `character_companion`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_objId | int(10) unsigned | NO | PRI |  |  |
| objid | int(10) unsigned | NO |  | 0 |  |
| name | varchar(50) | NO |  |  |  |
| npcId | int(10) unsigned | NO |  |  |  |
| level | int(10) unsigned | NO |  | 1 |  |
| exp | int(10) unsigned | NO |  | 0 |  |
| maxHp | int(5) unsigned | NO |  | 160 |  |
| currentHp | int(5) unsigned | NO |  | 160 |  |
| friend_ship_marble | int(3) unsigned | NO |  | 0 |  |
| friend_ship_guage | int(10) unsigned | NO |  | 0 |  |
| add_str | int(3) | NO |  | 0 |  |
| add_con | int(3) | NO |  | 0 |  |
| add_int | int(3) | NO |  | 0 |  |
| remain_stats | int(3) unsigned | NO |  | 0 |  |
| elixir_use_count | int(2) unsigned | NO |  | 0 |  |
| dead | tinyint(1) unsigned | NO |  | 0 |  |
| oblivion | tinyint(1) unsigned | NO |  | 0 |  |
| tier | int(1) | NO |  | 1 |  |
| wild | blob | NO |  |  |  |
| lessExp | int(10) | NO |  | 0 |  |
| traningTime | datetime | YES |  |  |  |


## Table: `character_companion_buff`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| objid | int(10) unsigned | NO | PRI | 0 |  |
| buff_id | int(10) unsigned | NO | PRI | 0 |  |
| duration | int(10) | NO |  |  |  |


## Table: `character_config`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| object_id | int(10) | NO | PRI | 0 |  |
| length | int(10) unsigned | NO |  | 0 |  |
| data | blob | YES |  |  |  |


## Table: `character_death_exp`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_id | int(10) | NO | PRI | 0 |  |
| delete_time | datetime | NO | PRI |  |  |
| death_level | int(3) | NO |  | 0 |  |
| exp_value | int(11) | NO |  | 0 |  |
| recovery_cost | int(7) | NO |  | 0 |  |


## Table: `character_death_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_id | int(10) | NO |  | 0 |  |
| delete_time | datetime | NO |  |  |  |
| db_id | int(10) | NO | PRI | 0 |  |
| itemId | int(11) | NO |  |  |  |
| count | int(11) | NO |  | 0 |  |
| enchant | int(6) | NO |  | 0 |  |
| identi | enum('false','true') | NO |  | false |  |
| chargeCount | int(11) | NO |  | 0 |  |
| bless | int(3) | NO |  | 1 |  |
| attrEnchant | int(2) | NO |  | 0 |  |
| specialEnchant | int(2) | NO |  | 0 |  |
| potential_id | int(3) | NO |  | 0 |  |
| slot_first | int(5) | NO |  | 0 |  |
| slot_second | int(5) | NO |  | 0 |  |
| recovery_cost | int(8) | NO |  | 0 |  |


## Table: `character_einhasadfaith`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| objId | int(11) | NO | PRI | 0 |  |
| groupId | int(3) | NO |  | 0 |  |
| indexId | int(3) | NO | PRI | 0 |  |
| spellId | int(6) | NO |  | -1 |  |
| expiredTime | datetime | YES |  |  |  |


## Table: `character_einhasadstat`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| objid | int(11) | NO | PRI | 0 |  |
| bless | int(3) | NO |  | 0 |  |
| lucky | int(3) | NO |  | 0 |  |
| vital | int(3) | NO |  | 0 |  |
| itemSpellProb | int(3) | NO |  | 0 |  |
| absoluteRegen | int(3) | NO |  | 0 |  |
| potion | int(3) | NO |  | 0 |  |
| bless_efficiency | int(3) | NO |  | 0 |  |
| bless_exp | int(3) | NO |  | 0 |  |
| lucky_item | int(3) | NO |  | 0 |  |
| lucky_adena | int(3) | NO |  | 0 |  |
| vital_potion | int(3) | NO |  | 0 |  |
| vital_heal | int(3) | NO |  | 0 |  |
| itemSpellProb_armor | int(3) | NO |  | 0 |  |
| itemSpellProb_weapon | int(3) | NO |  | 0 |  |
| absoluteRegen_hp | int(3) | NO |  | 0 |  |
| absoluteRegen_mp | int(3) | NO |  | 0 |  |
| potion_critical | int(3) | NO |  | 0 |  |
| potion_delay | int(3) | NO |  | 0 |  |


## Table: `character_elf_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| account_name | varchar(50) | YES | MUL |  |  |
| item_id | int(11) | YES |  |  |  |
| item_name | varchar(255) | YES |  |  |  |
| count | int(11) | YES |  |  |  |
| is_equipped | int(11) | YES |  |  |  |
| enchantlvl | int(11) | YES |  |  |  |
| is_id | int(11) | YES |  |  |  |
| durability | int(11) | YES |  |  |  |
| charge_count | int(11) | YES |  |  |  |
| remaining_time | int(11) | YES |  |  |  |
| last_used | datetime | YES |  |  |  |
| attr_enchantlvl | int(11) | YES |  |  |  |
| special_enchant | int(11) | YES |  |  |  |
| doll_ablity | int(4) | YES |  |  |  |
| bless | int(11) | YES |  | 0 |  |


## Table: `character_equipset`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| charId | int(10) | NO | PRI | 0 |  |
| current_set | int(1) | NO |  | 0 |  |
| slot1_item | text | YES |  |  |  |
| slot2_item | text | YES |  |  |  |
| slot3_item | text | YES |  |  |  |
| slot4_item | text | YES |  |  |  |
| slot1_name | varchar(100) | NO |  |  |  |
| slot2_name | varchar(100) | NO |  |  |  |
| slot3_name | varchar(100) | NO |  |  |  |
| slot4_name | varchar(100) | NO |  |  |  |
| slot1_color | int(2) | NO |  | 0 |  |
| slot2_color | int(2) | NO |  | 0 |  |
| slot3_color | int(2) | NO |  | 0 |  |
| slot4_color | int(2) | NO |  | 0 |  |


## Table: `character_eventpush`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| push_id | int(10) | NO | PRI | 0 |  |
| objId | int(10) | NO |  | 0 |  |
| subject | varchar(90) | YES |  |  |  |
| content | varchar(300) | YES |  |  |  |
| web_url | varchar(200) | YES |  |  |  |
| itemId | int(11) | NO |  | 0 |  |
| item_amount | int(11) | NO |  | 0 |  |
| item_enchant | int(6) | YES |  | 0 |  |
| doll_ablity | int(4) | YES |  |  |  |
| used_immediately | enum('false','true') | NO |  | false |  |
| status | int(2) | NO |  | 0 |  |
| enable_date | datetime | NO |  |  |  |
| image_id | int(6) | NO |  | 0 |  |


## Table: `character_exclude`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | MUL |  | auto_increment |
| char_id | int(10) | NO | PRI | 0 |  |
| type | int(2) | NO | PRI | 0 |  |
| exclude_id | int(10) unsigned | NO | PRI | 0 |  |
| exclude_name | varchar(45) | NO |  |  |  |


## Table: `character_fairly_config`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| object_id | int(10) | NO | PRI |  |  |
| data | blob | YES |  |  |  |


## Table: `character_favorbook`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| charObjId | int(10) | NO | PRI | 0 |  |
| category | int(3) | NO | PRI | 0 |  |
| slotId | int(1) | NO | PRI | 0 |  |
| itemObjId | int(10) | NO |  | 0 |  |
| itemId | int(10) | NO |  | 0 |  |
| itemName | varchar(255) | YES |  |  |  |
| count | int(10) | NO |  | 1 |  |
| enchantLevel | int(10) | NO |  | 0 |  |
| attrLevel | int(10) | NO |  | 0 |  |
| bless | int(3) | NO |  | 1 |  |
| endTime | datetime | YES |  |  |  |
| craftId | int(6) | NO |  | 0 |  |
| awakening | int(1) | NO |  | 0 |  |


## Table: `character_hunting_quest`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI | 0 |  |
| objID | int(10) | NO |  | 0 |  |
| map_number | int(6) | YES |  | 0 |  |
| location_desc | int(3) | YES |  | 0 |  |
| quest_id | int(3) | YES |  |  |  |
| kill_count | int(3) | YES |  |  |  |
| complete | enum('true','false') | YES |  | false |  |


## Table: `character_items`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI | 0 |  |
| item_id | int(11) | NO |  |  |  |
| char_id | int(11) | NO | MUL |  |  |
| item_name | varchar(255) | YES |  |  |  |
| count | int(11) | NO |  | 0 |  |
| is_equipped | tinyint(1) unsigned | NO |  | 0 |  |
| enchantlvl | int(11) | NO |  | 0 |  |
| is_id | tinyint(1) unsigned | NO |  | 0 |  |
| durability | int(2) | NO |  | 0 |  |
| charge_count | int(11) | NO |  | 0 |  |
| remaining_time | int(11) | NO |  | 0 |  |
| last_used | datetime | YES |  |  |  |
| bless | int(3) | NO |  | 1 |  |
| attr_enchantlvl | int(3) | NO |  | 0 |  |
| special_enchant | int(3) | NO |  | 0 |  |
| doll_ablity | int(4) | NO |  | 0 |  |
| end_time | datetime | YES |  |  |  |
| KeyVal | int(6) | NO |  | 0 |  |
| package | tinyint(1) | NO |  | 0 |  |
| engrave | tinyint(1) unsigned | NO |  | 0 |  |
| scheduled | tinyint(1) | NO |  | 0 |  |
| slot_0 | int(5) | NO |  | 0 |  |
| slot_1 | int(5) | NO |  | 0 |  |


## Table: `character_monsterbooklist`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| monsterlist | text | NO |  |  |  |
| monquest | text | NO |  |  |  |


## Table: `character_package_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| account_name | varchar(50) | YES | MUL |  |  |
| item_id | int(11) | YES |  |  |  |
| item_name | varchar(255) | YES |  |  |  |
| count | int(11) | YES |  |  |  |
| is_equipped | int(11) | YES |  |  |  |
| enchantlvl | int(11) | YES |  |  |  |
| is_id | int(11) | YES |  |  |  |
| durability | int(11) | YES |  |  |  |
| charge_count | int(11) | YES |  |  |  |
| remaining_time | int(11) | YES |  |  |  |
| last_used | datetime | YES |  |  |  |
| attr_enchantlvl | int(11) | YES |  |  |  |
| bless | int(11) | YES |  | 0 |  |
| special_enchant | int(11) | YES |  |  |  |
| doll_ablity | int(4) | YES |  |  |  |


## Table: `character_present_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| account_name | varchar(50) | YES | MUL |  |  |
| item_id | int(11) | YES |  |  |  |
| item_name | varchar(255) | YES |  |  |  |
| count | int(11) | YES |  |  |  |
| is_equipped | int(11) | YES |  |  |  |
| enchantlvl | int(11) | YES |  |  |  |
| is_id | int(11) | YES |  |  |  |
| durability | int(11) | YES |  |  |  |
| charge_count | int(11) | YES |  |  |  |
| remaining_time | int(11) | YES |  |  |  |
| last_used | datetime | YES |  |  |  |
| attr_enchantlvl | int(11) | YES |  |  |  |
| special_enchant | int(11) | YES |  |  |  |
| doll_ablity | int(4) | YES |  |  |  |
| bless | int(11) | YES |  | 0 |  |


## Table: `character_quests`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_id | int(10) unsigned | NO | PRI |  |  |
| quest_id | int(3) unsigned | NO | PRI | 0 |  |
| quest_step | int(3) unsigned | NO |  | 0 |  |


## Table: `character_revenge`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| number | int(10) unsigned | NO | PRI | 0 |  |
| char_id | int(10) unsigned | NO |  | 0 |  |
| result | int(2) unsigned | NO |  | 0 |  |
| starttime | datetime | YES |  |  |  |
| endtime | datetime | YES |  |  |  |
| chasestarttime | datetime | YES |  |  |  |
| chaseendtime | datetime | YES |  |  |  |
| usecount | int(2) unsigned | NO |  | 0 |  |
| amount | int(10) unsigned | NO |  | 0 |  |
| targetobjid | int(10) | NO |  | 0 |  |
| targetclass | int(2) unsigned | NO |  | 0 |  |
| targetname | varchar(45) | NO |  |  |  |
| targetclanid | int(10) unsigned | NO |  | 0 |  |
| targetclanname | varchar(45) | NO |  |  |  |


## Table: `character_shop_limit`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| characterId | int(10) | NO | PRI | 0 |  |
| buyShopId | int(9) | NO | PRI | 0 |  |
| buyItemId | int(9) | NO | PRI | 0 |  |
| buyCount | int(9) | NO |  | 0 |  |
| buyTime | timestamp | NO |  | 0000-00-00 00:00:00 | on update current_timestamp() |
| limitTerm | enum('WEEK','DAY','NONE') | NO |  | DAY |  |


## Table: `character_skills_active`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_obj_id | int(10) | NO | PRI | 0 |  |
| skill_id | int(10) | NO | PRI | -1 |  |
| skill_name | varchar(100) | NO |  |  |  |


## Table: `character_skills_passive`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_obj_id | int(10) | NO | PRI | 0 |  |
| passive_id | int(10) | NO | PRI | 0 |  |
| passive_name | varchar(100) | NO |  |  |  |


## Table: `character_soldier`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_id | int(12) | NO | PRI |  |  |
| npc_id | int(12) | NO |  | 0 |  |
| count | int(4) | NO |  | 0 |  |
| castle_id | int(4) | NO |  | 0 |  |
| time | int(18) | NO | PRI |  |  |


## Table: `character_special_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| account_name | varchar(50) | YES | MUL |  |  |
| item_id | int(11) | YES |  |  |  |
| item_name | varchar(255) | YES |  |  |  |
| count | int(11) | YES |  |  |  |
| is_equipped | int(11) | YES |  |  |  |
| enchantlvl | int(11) | YES |  |  |  |
| is_id | int(11) | YES |  |  |  |
| durability | int(11) | YES |  |  |  |
| charge_count | int(11) | YES |  |  |  |
| remaining_time | int(11) | YES |  |  |  |
| last_used | datetime | YES |  |  |  |
| attr_enchantlvl | int(11) | YES |  |  |  |
| doll_ablity | int(4) | YES |  |  |  |
| bless | int(11) | YES |  | 0 |  |
| second_id | int(11) | YES |  |  |  |
| round_id | int(11) | YES |  |  |  |
| ticket_id | int(11) | YES |  |  |  |
| maan_time | datetime | YES |  |  |  |
| regist_level | int(11) | YES |  |  |  |


## Table: `character_teleport`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| num_id | int(10) unsigned | NO |  | 0 |  |
| speed_id | int(10) | NO |  | -1 |  |
| char_id | int(10) unsigned | NO | MUL | 0 |  |
| name | varchar(45) | NO |  |  |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |
| randomX | int(10) unsigned | NO |  | 0 |  |
| randomY | int(10) unsigned | NO |  | 0 |  |
| item_obj_id | int(10) unsigned | NO |  | 0 |  |


## Table: `character_timecollection`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| charObjId | int(10) | NO | PRI | 0 |  |
| groupId | int(1) | NO | PRI | 0 |  |
| setId | int(1) | NO | PRI | 0 |  |
| slots | text | YES |  |  |  |
| registComplet | enum('false','true') | NO |  | false |  |
| buffType | enum('SHORT','LONG','MAGIC') | NO |  | MAGIC |  |
| buffTime | datetime | YES |  |  |  |
| refillCount | int(3) | NO |  | 0 |  |


## Table: `character_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| account_name | varchar(50) | YES | MUL |  |  |
| item_id | int(11) | YES |  |  |  |
| item_name | varchar(255) | YES |  |  |  |
| count | int(11) | YES |  |  |  |
| is_equipped | int(11) | YES |  |  |  |
| enchantlvl | int(11) | YES |  |  |  |
| is_id | int(11) | YES |  |  |  |
| durability | int(11) | YES |  |  |  |
| charge_count | int(11) | YES |  |  |  |
| remaining_time | int(11) | YES |  |  |  |
| last_used | datetime | YES |  |  |  |
| attr_enchantlvl | int(11) | YES |  |  |  |
| bless | int(11) | YES |  | 0 |  |
| special_enchant | int(11) | YES |  |  |  |
| doll_ablity | int(4) | YES |  |  |  |
| package | tinyint(3) | YES |  | 0 |  |
| buy_time | datetime | YES |  |  |  |


## Table: `characters`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| account_name | varchar(50) | YES | MUL |  |  |
| objid | int(11) unsigned | NO | PRI | 0 |  |
| char_name | varchar(45) | NO |  |  |  |
| level | int(3) unsigned | NO |  | 0 |  |
| HighLevel | int(3) unsigned | NO |  | 0 |  |
| Exp | bigint(11) unsigned | NO |  | 0 |  |
| MaxHp | int(5) | NO |  | 0 |  |
| CurHp | int(5) | NO |  | 0 |  |
| MaxMp | int(5) | NO |  | 0 |  |
| CurMp | int(5) | NO |  | 0 |  |
| Ac | int(3) | NO |  | 0 |  |
| Str | int(3) | NO |  | 0 |  |
| BaseStr | int(3) | NO |  | 0 |  |
| Con | int(3) | NO |  | 0 |  |
| BaseCon | int(3) | NO |  | 0 |  |
| Dex | int(3) | NO |  | 0 |  |
| BaseDex | int(3) | NO |  | 0 |  |
| Cha | int(3) | NO |  | 0 |  |
| BaseCha | int(3) | NO |  | 0 |  |
| Intel | int(3) | NO |  | 0 |  |
| BaseIntel | int(3) | NO |  | 0 |  |
| Wis | int(3) | NO |  | 0 |  |
| BaseWis | int(3) | NO |  | 0 |  |
| Status | int(3) unsigned | NO |  | 0 |  |
| Class | int(2) unsigned | NO |  | 0 |  |
| gender | int(1) unsigned | NO |  | 0 |  |
| Type | int(2) unsigned | NO |  | 0 |  |
| Heading | int(2) unsigned | NO |  | 0 |  |
| LocX | int(6) unsigned | NO |  | 0 |  |
| LocY | int(6) unsigned | NO |  | 0 |  |
| MapID | int(6) unsigned | NO |  | 0 |  |
| Food | int(10) unsigned | NO |  | 0 |  |
| Alignment | int(6) | NO |  | 0 |  |
| Title | varchar(35) | NO |  |  |  |
| ClanID | int(10) unsigned | NO |  | 0 |  |
| Clanname | varchar(45) | NO |  |  |  |
| ClanRank | int(3) | NO |  | 0 |  |
| ClanContribution | int(8) | NO |  | 0 |  |
| ClanWeekContribution | int(8) | NO |  | 0 |  |
| pledgeJoinDate | int(10) | NO |  | 0 |  |
| pledgeRankDate | int(10) | NO |  | 0 |  |
| notes | varchar(60) | NO |  |  |  |
| BonusStatus | int(4) | NO |  | 0 |  |
| ElixirStatus | int(2) | NO |  | 0 |  |
| ElfAttr | int(2) | NO |  | 0 |  |
| PKcount | int(6) | NO |  | 0 |  |
| ExpRes | int(10) | NO |  | 0 |  |
| PartnerID | int(10) | NO |  | 0 |  |
| AccessLevel | int(6) unsigned | NO |  | 0 |  |
| OnlineStatus | int(2) unsigned | NO |  | 0 |  |
| HomeTownID | int(2) | NO |  | 0 |  |
| Contribution | int(10) | NO |  | 0 |  |
| HellTime | int(10) unsigned | NO |  | 0 |  |
| Banned | tinyint(1) unsigned | NO |  | 0 |  |
| Karma | int(10) | NO |  | 0 |  |
| LastPk | datetime | YES |  |  |  |
| DeleteTime | datetime | YES |  |  |  |
| ReturnStat | bigint(10) | NO |  |  |  |
| lastLoginTime | datetime | YES |  |  |  |
| lastLogoutTime | datetime | YES |  |  |  |
| BirthDay | int(11) | YES |  |  |  |
| PC_Kill | int(6) | YES |  |  |  |
| PC_Death | int(6) | YES |  |  |  |
| Mark_Count | int(10) | NO |  | 60 |  |
| TamEndTime | datetime | YES |  |  |  |
| SpecialSize | int(3) | NO |  | 0 |  |
| HuntPrice | int(10) | YES |  |  |  |
| HuntText | varchar(30) | YES |  |  |  |
| HuntCount | int(10) | YES |  |  |  |
| RingAddSlot | int(3) | YES |  | 0 |  |
| EarringAddSlot | int(3) | YES |  | 0 |  |
| BadgeAddSlot | int(3) | YES |  | 0 |  |
| ShoulderAddSlot | int(3) | YES |  | 0 |  |
| fatigue_point | int(3) | NO |  | 0 |  |
| fatigue_rest_time | datetime | YES |  |  |  |
| EMETime | datetime | YES |  |  |  |
| EMETime2 | datetime | YES |  |  |  |
| PUPLETime | datetime | YES |  |  |  |
| TOPAZTime | datetime | YES |  |  |  |
| EinhasadGraceTime | datetime | YES |  |  |  |
| EinPoint | int(11) | YES |  | 0 |  |
| EinCardLess | int(2) | NO |  | 0 |  |
| EinCardState | int(3) | NO |  | 0 |  |
| EinCardBonusValue | int(1) | NO |  | 0 |  |
| ThirdSkillTime | datetime | YES |  |  |  |
| FiveSkillTime | datetime | YES |  |  |  |
| SurvivalTime | datetime | YES |  |  |  |
| potentialTargetId | int(10) | NO |  | 0 |  |
| potentialBonusGrade | int(1) | NO |  | 0 |  |
| potentialBonusId | int(3) | NO |  | 0 |  |


## Table: `clan_bless_buff`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| number | int(10) unsigned | NO | PRI |  | auto_increment |
| buff_id | int(10) | NO | PRI | -1 |  |
| map_name | varchar(45) | NO |  |  |  |
| teleport_map_id | int(6) unsigned | YES |  | 0 |  |
| teleport_x | int(6) unsigned | YES |  | 0 |  |
| teleport_y | int(6) unsigned | YES |  | 0 |  |
| buff_map_list | varchar(255) | YES |  |  |  |


## Table: `clan_contribution_buff`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| clan_id | int(10) unsigned | NO | PRI |  | auto_increment |
| clan_name | varchar(45) | NO |  |  |  |
| exp_buff_type | int(1) unsigned | YES |  | 0 |  |
| exp_buff_time | datetime | YES |  |  |  |
| battle_buff_type | int(1) unsigned | YES |  | 0 |  |
| battle_buff_time | datetime | YES |  |  |  |
| defens_buff_type | int(1) unsigned | YES |  | 0 |  |
| defens_buff_time | datetime | YES |  |  |  |


## Table: `clan_data`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| clan_id | int(10) unsigned | NO | PRI |  | auto_increment |
| clan_name | varchar(45) | NO |  |  |  |
| leader_id | int(10) unsigned | NO |  | 0 |  |
| leader_name | varchar(45) | NO |  |  |  |
| hascastle | int(10) unsigned | NO |  | 0 |  |
| hashouse | int(10) unsigned | NO |  | 0 |  |
| alliance | varchar(100) | YES |  |  |  |
| clan_birthday | datetime | NO |  |  |  |
| bot | enum('true','false') | NO |  | false |  |
| bot_style | tinyint(3) | NO |  | 0 |  |
| bot_level | tinyint(3) | NO |  | 0 |  |
| max_online_user | int(10) | NO |  | 0 |  |
| announcement | varchar(160) | NO |  |  |  |
| introductionMessage | varchar(160) | NO |  |  |  |
| enter_notice | varchar(160) | NO |  |  |  |
| emblem_id | int(10) | NO |  | 0 |  |
| emblem_status | tinyint(1) | NO |  | 0 |  |
| contribution | int(10) | NO |  | 0 |  |
| bless | int(45) | NO |  | 0 |  |
| bless_count | int(45) | NO |  | 0 |  |
| attack | int(45) | NO |  | 0 |  |
| defence | int(45) | NO |  | 0 |  |
| pvpattack | int(45) | NO |  | 0 |  |
| pvpdefence | int(45) | NO |  | 0 |  |
| under_dungeon | tinyint(3) | NO |  | 0 |  |
| ranktime | int(10) | NO |  | 0 |  |
| rankdate | datetime | YES |  |  |  |
| War_point | int(10) | NO |  | 0 |  |
| enable_join | enum('true','false') | NO |  | true |  |
| join_type | int(1) | NO |  | 1 |  |
| total_m | int(10) | NO |  | 0 |  |
| current_m | int(10) | NO |  | 0 |  |
| join_password | varchar(45) | YES |  |  |  |
| EinhasadBlessBuff | int(10) | YES |  |  |  |
| Buff_List1 | int(10) | YES |  |  |  |
| Buff_List2 | int(10) | YES |  |  |  |
| Buff_List3 | int(10) | YES |  |  |  |
| dayDungeonTime | datetime | YES |  |  |  |
| weekDungeonTime | datetime | YES |  |  |  |
| vowTime | datetime | YES |  |  |  |
| vowCount | int(1) | NO |  | 0 |  |
| clanNameChange | enum('true','false') | NO |  | false |  |
| storeAllows | text | YES |  |  |  |
| limit_level | int(3) | NO |  | 30 |  |
| limit_user_names | text | YES |  |  |  |


## Table: `clan_emblem_attention`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| clanname | varchar(45) | NO | PRI |  |  |
| attentionClanname | varchar(45) | NO | PRI |  |  |


## Table: `clan_history`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| num | int(11) | NO | PRI |  | auto_increment |
| clan_id | int(11) | NO |  | 0 |  |
| ckck | int(2) | NO |  | 0 |  |
| char_name | varchar(50) | NO |  |  |  |
| item_name | varchar(50) | NO |  |  |  |
| item_count | int(11) | NO |  | 0 |  |
| time | datetime | YES |  |  |  |


## Table: `clan_joinning`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| pledge_uid | int(10) | NO | PRI | 0 |  |
| pledge_name | varchar(50) | YES |  |  |  |
| user_uid | int(10) | NO | PRI | 0 |  |
| user_name | varchar(50) | NO |  |  |  |
| join_message | varchar(100) | YES |  |  |  |
| class_type | int(2) | NO |  | 0 |  |
| join_date | int(10) | NO |  | 0 |  |


## Table: `clan_matching_apclist`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| pc_name | varchar(45) | NO |  |  |  |
| pc_objid | int(10) | YES |  |  |  |
| clan_name | varchar(45) | NO |  |  |  |


## Table: `clan_matching_list`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| clanname | varchar(45) | NO | PRI |  |  |
| text | varchar(500) | YES |  |  |  |
| type | int(10) | YES |  |  |  |


## Table: `clan_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| clan_name | varchar(45) | YES | MUL |  |  |
| item_id | int(11) | YES |  |  |  |
| item_name | varchar(255) | YES |  |  |  |
| count | int(11) | YES |  |  |  |
| is_equipped | int(11) | YES |  |  |  |
| enchantlvl | int(11) | YES |  |  |  |
| is_id | int(11) | YES |  |  |  |
| durability | int(11) | YES |  |  |  |
| charge_count | int(11) | YES |  |  |  |
| remaining_time | int(11) | YES |  |  |  |
| last_used | datetime | YES |  |  |  |
| attr_enchantlvl | int(11) | YES |  |  |  |
| special_enchant | int(11) | YES |  |  |  |
| doll_ablity | int(4) | YES |  | 0 |  |
| package | tinyint(3) | YES |  | 0 |  |


## Table: `clan_warehouse_list`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| clanid | int(11) | YES |  | 0 |  |
| list | varchar(200) | YES |  |  |  |
| date | varchar(20) | YES |  |  |  |


## Table: `clan_warehouse_log`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(1) unsigned | NO | PRI |  | auto_increment |
| name | varchar(30) | NO |  |  |  |
| clan_name | varchar(30) | NO |  |  |  |
| item_name | varchar(30) | NO |  |  |  |
| item_count | int(1) unsigned | NO |  |  |  |
| type | bit(1) | NO |  |  |  |
| time | datetime | NO |  |  |  |


## Table: `commands`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| name | varchar(255) | NO | PRI |  |  |
| access_level | int(10) | NO |  | 9999 |  |
| class_name | varchar(255) | NO |  |  |  |
| description | varchar(300) | NO |  |  |  |


## Table: `connect_reward`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) | NO | PRI | 0 |  |
| description | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| reward_type | enum('NORMAL','STANBY_SERVER') | NO |  | NORMAL |  |
| reward_item_id | int(10) | NO |  | 0 |  |
| reward_item_count | int(10) | NO |  | 0 |  |
| reward_interval_minute | int(6) | NO |  | 0 |  |
| reward_start_date | datetime | YES |  |  |  |
| reward_finish_date | datetime | YES |  |  |  |
| is_use | enum('true','false') | NO |  | true |  |


## Table: `craft_block`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| craft_id | int(5) | NO | PRI | 0 |  |
| craft_name | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |


## Table: `craft_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| craft_id | int(10) unsigned | NO | PRI |  | auto_increment |
| name | varchar(45) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| output_name_id | int(10) | NO |  | 0 |  |
| probability_million | int(10) | NO |  | 0 |  |
| preserve_name_ids | text | YES |  |  |  |
| success_preserve_count | text | YES |  |  |  |
| failure_preserve_count | text | YES |  |  |  |
| is_success_count_type | enum('false','true') | NO |  | false |  |


## Table: `craft_npcs`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npc_id | int(10) unsigned | NO | PRI |  | auto_increment |
| npc_name | varchar(45) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| craft_id_list | text | YES |  |  |  |


## Table: `craft_success_count_user`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| accountName | varchar(50) | NO | PRI |  |  |
| charId | int(10) | NO | PRI | 0 |  |
| craftId | int(6) | NO | PRI | 0 |  |
| success_count_type | enum('World','Account','Character','AllServers') | NO |  | World |  |
| currentCount | int(3) | NO |  | 0 |  |


## Table: `dogfight_tickets`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) | NO | PRI | 0 |  |
| name | varchar(45) | NO |  |  |  |
| price | int(10) | NO |  |  |  |


## Table: `droplist`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mobId | int(6) | NO | PRI | 0 |  |
| mobname_kr | varchar(100) | NO |  |  |  |
| mobname_en | varchar(100) | NO |  |  |  |
| moblevel | int(10) | NO |  | 0 |  |
| itemId | int(6) | NO | PRI | 0 |  |
| itemname_kr | varchar(50) | NO |  |  |  |
| itemname_en | varchar(100) | NO |  |  |  |
| min | int(4) | NO |  | 0 |  |
| max | int(4) | NO |  | 0 |  |
| chance | int(8) | NO |  | 0 |  |
| Enchant | int(10) | NO |  | 0 |  |


## Table: `droptype_npc`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mobId | int(11) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| type | enum('map','share') | NO |  | map |  |


## Table: `dungeon`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| src_x | int(10) | NO | PRI | 0 |  |
| src_y | int(10) | NO | PRI | 0 |  |
| src_mapid | int(10) | NO | PRI | 0 |  |
| new_x | int(10) | NO |  | 0 |  |
| new_y | int(10) | NO |  | 0 |  |
| new_mapid | int(10) | NO |  | 0 |  |
| new_heading | int(10) | NO |  | 1 |  |
| min_level | int(3) | NO |  | 0 |  |
| max_level | int(3) | NO |  | 0 |  |
| note | varchar(75) | NO |  |  |  |


## Table: `dungeon_random`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| src_x | int(10) | NO | PRI | 0 |  |
| src_y | int(10) | NO | PRI | 0 |  |
| src_mapid | int(10) | NO | PRI | 0 |  |
| new_x1 | int(10) | NO |  | 0 |  |
| new_y1 | int(10) | NO |  | 0 |  |
| new_mapid1 | int(10) | NO |  | 0 |  |
| new_x2 | int(10) | NO |  | 0 |  |
| new_y2 | int(10) | NO |  | 0 |  |
| new_mapid2 | int(10) | NO |  | 0 |  |
| new_x3 | int(10) | NO |  | 0 |  |
| new_y3 | int(10) | NO |  | 0 |  |
| new_mapid3 | int(10) | NO |  | 0 |  |
| new_x4 | int(10) | NO |  | 0 |  |
| new_y4 | int(10) | NO |  | 0 |  |
| new_mapid4 | int(10) | NO |  | 0 |  |
| new_x5 | int(10) | NO |  | 0 |  |
| new_y5 | int(10) | NO |  | 0 |  |
| new_mapid5 | int(10) | NO |  | 0 |  |
| new_heading | int(10) | NO |  | 1 |  |
| note | varchar(50) | NO |  |  |  |


## Table: `dungeon_timer`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| timerId | int(3) | NO | PRI | 0 |  |
| desc | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| descId | varchar(50) | YES |  |  |  |
| useType | enum('ACCOUNT','CHARACTER') | NO |  | ACCOUNT |  |
| mapIds | text | YES |  |  |  |
| timerValue | int(9) | NO |  | 0 |  |
| bonusLevel | int(3) | NO |  | 0 |  |
| bonusValue | int(9) | NO |  | 0 |  |
| pccafeBonusValue | int(9) | NO |  | 0 |  |
| resetType | enum('DAY','WEEK','NONE') | NO |  | DAY |  |
| minLimitLevel | int(3) | NO |  | 0 |  |
| maxLimitLevel | int(3) | NO |  | 0 |  |
| serialId | int(6) | NO |  | 0 |  |
| serialDescId | varchar(50) | YES |  |  |  |
| maxChargeCount | int(3) | NO |  | 0 |  |
| group | enum('NONE','HIDDEN_FIELD','SILVER_KNIGHT_DUNGEON','HIDDEN_FIELD_BOOST') | NO |  | NONE |  |


## Table: `dungeon_timer_account`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| account | varchar(50) | NO | PRI |  |  |
| timerId | int(10) | NO | PRI | 0 |  |
| remainSecond | int(10) | NO |  | 0 |  |
| chargeCount | int(2) | NO |  | 0 |  |
| resetTime | datetime | YES |  |  |  |


## Table: `dungeon_timer_character`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| charId | int(10) | NO | PRI | 0 |  |
| timerId | int(10) | NO | PRI | 0 |  |
| remainSecond | int(10) | NO |  | 0 |  |
| chargeCount | int(2) | NO |  | 0 |  |
| resetTime | datetime | YES |  |  |  |


## Table: `dungeon_timer_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI | 0 |  |
| desc | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| timerId | int(3) | NO |  | 0 |  |
| groupId | int(1) | NO |  | 0 |  |


## Table: `enchant_result`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| color_item | enum('false','true') | NO |  | false |  |
| bm_scroll | enum('false','true') | NO |  | false |  |


## Table: `etcitem`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) unsigned | NO | PRI |  | auto_increment |
| item_name_id | int(10) unsigned | NO |  | 0 |  |
| desc_kr | varchar(45) | NO |  |  |  |
| desc_en | varchar(100) | NO |  |  |  |
| desc_powerbook | varchar(100) | NO |  |  |  |
| note | text | NO |  |  |  |
| desc_id | varchar(45) | NO |  |  |  |
| itemGrade | enum('ONLY','MYTH','LEGEND','HERO','RARE','ADVANC','NORMAL') | NO |  | NORMAL |  |
| item_type | enum('ARROW','WAND','LIGHT','GEM','TOTEM','FIRE_CRACKER','POTION','FOOD','SCROLL','QUEST_ITEM','SPELL_BOOK','PET_ITEM','OTHER','MATERIAL','EVENT','STING','TREASURE_BOX') | NO |  | OTHER |  |
| use_type | enum('NONE','NORMAL','WAND1','WAND','SPELL_LONG','NTELE','IDENTIFY','RES','TELEPORT','INVISABLE','LETTER','LETTER_W','CHOICE','INSTRUMENT','SOSC','SPELL_SHORT','T_SHIRT','CLOAK','GLOVE','BOOTS','HELMET','RING','AMULET','SHIELD','GARDER','DAI','ZEL','BLANK','BTELE','SPELL_BUFF','CCARD','CCARD_W','VCARD','VCARD_W','WCARD','WCARD_W','BELT','SPELL_LONG2','EARRING','FISHING_ROD','RON','RON_2','ACCZEL','PAIR','HEALING','SHOULDER','BADGE','POTENTIAL_SCROLL','SPELLMELT','ELIXER_RON','INVENTORY_BONUS','TAM_FRUIT','RACE_TICKET','PAIR_2','MAGICDOLL','SENTENCE','SHOULDER_2','BADGE_2','PET_POTION','GARDER_2','DOMINATION_POLY','PENDANT','SHOVEL','LEV_100_POLY','SMELTING','PURIFY','CHARGED_MAP_TIME') | NO |  | NONE |  |
| material | enum('NONE(-)','LIQUID(액체)','WAX(밀랍)','VEGGY(식물성)','FLESH(동물성)','PAPER(종이)','CLOTH(천)','LEATHER(가죽)','WOOD(나무)','BONE(뼈)','DRAGON_HIDE(용비늘)','IRON(철)','METAL(금속)','COPPER(구리)','SILVER(은)','GOLD(금)','PLATINUM(백금)','MITHRIL(미스릴)','PLASTIC(블랙미스릴)','GLASS(유리)','GEMSTONE(보석)','MINERAL(광석)','ORIHARUKON(오리하루콘)','DRANIUM(드라니움)') | NO |  | NONE(-) |  |
| weight | int(10) unsigned | NO |  | 0 |  |
| iconId | int(10) unsigned | NO |  | 0 |  |
| spriteId | int(10) unsigned | NO |  | 0 |  |
| merge | enum('true','false') | NO |  | false |  |
| max_charge_count | int(6) unsigned | NO |  | 0 |  |
| dmg_small | int(6) unsigned | NO |  | 0 |  |
| dmg_large | int(6) unsigned | NO |  | 0 |  |
| ac_bonus | int(3) | NO |  | 0 |  |
| shortHit | int(10) unsigned | NO |  | 0 |  |
| shortDmg | int(10) unsigned | NO |  | 0 |  |
| longHit | int(10) unsigned | NO |  | 0 |  |
| longDmg | int(10) unsigned | NO |  | 0 |  |
| add_str | int(2) | NO |  | 0 |  |
| add_con | int(2) | NO |  | 0 |  |
| add_dex | int(2) | NO |  | 0 |  |
| add_int | int(2) | NO |  | 0 |  |
| add_wis | int(2) | NO |  | 0 |  |
| add_cha | int(2) | NO |  | 0 |  |
| add_hp | int(6) | NO |  | 0 |  |
| add_mp | int(6) | NO |  | 0 |  |
| add_hpr | int(6) | NO |  | 0 |  |
| add_mpr | int(6) | NO |  | 0 |  |
| add_sp | int(2) | NO |  | 0 |  |
| min_lvl | int(3) unsigned | NO |  | 0 |  |
| max_lvl | int(3) unsigned | NO |  | 0 |  |
| m_def | int(2) | NO |  | 0 |  |
| carryBonus | int(4) | NO |  | 0 |  |
| defense_water | int(2) | NO |  | 0 |  |
| defense_wind | int(2) | NO |  | 0 |  |
| defense_fire | int(2) | NO |  | 0 |  |
| defense_earth | int(2) | NO |  | 0 |  |
| attr_all | int(2) | NO |  | 0 |  |
| regist_stone | int(2) | NO |  | 0 |  |
| regist_sleep | int(2) | NO |  | 0 |  |
| regist_freeze | int(2) | NO |  | 0 |  |
| regist_blind | int(2) | NO |  | 0 |  |
| regist_skill | int(2) | NO |  | 0 |  |
| regist_spirit | int(2) | NO |  | 0 |  |
| regist_dragon | int(2) | NO |  | 0 |  |
| regist_fear | int(2) | NO |  | 0 |  |
| regist_all | int(2) | NO |  | 0 |  |
| hitup_skill | int(2) | NO |  | 0 |  |
| hitup_spirit | int(2) | NO |  | 0 |  |
| hitup_dragon | int(2) | NO |  | 0 |  |
| hitup_fear | int(2) | NO |  | 0 |  |
| hitup_all | int(2) | NO |  | 0 |  |
| hitup_magic | int(2) | NO |  | 0 |  |
| damage_reduction | int(2) | NO |  | 0 |  |
| MagicDamageReduction | int(2) | NO |  | 0 |  |
| reductionEgnor | int(2) | NO |  | 0 |  |
| reductionPercent | int(2) | NO |  | 0 |  |
| PVPDamage | int(2) | NO |  | 0 |  |
| PVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamageReductionPercent | int(2) | NO |  | 0 |  |
| PVPMagicDamageReduction | int(2) | NO |  | 0 |  |
| PVPReductionEgnor | int(2) | NO |  | 0 |  |
| PVPMagicDamageReductionEgnor | int(2) | NO |  | 0 |  |
| abnormalStatusDamageReduction | int(2) | NO |  | 0 |  |
| abnormalStatusPVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamagePercent | int(2) | NO |  | 0 |  |
| expBonus | int(3) | NO |  | 0 |  |
| rest_exp_reduce_efficiency | int(3) | NO |  | 0 |  |
| shortCritical | int(2) | NO |  | 0 |  |
| longCritical | int(2) | NO |  | 0 |  |
| magicCritical | int(2) | NO |  | 0 |  |
| addDg | int(2) | NO |  | 0 |  |
| addEr | int(2) | NO |  | 0 |  |
| addMe | int(2) | NO |  | 0 |  |
| poisonRegist | enum('false','true') | NO |  | false |  |
| imunEgnor | int(3) | NO |  | 0 |  |
| stunDuration | int(2) | NO |  | 0 |  |
| tripleArrowStun | int(2) | NO |  | 0 |  |
| strangeTimeIncrease | int(4) | NO |  | 0 |  |
| strangeTimeDecrease | int(4) | NO |  | 0 |  |
| potionRegist | int(2) | NO |  | 0 |  |
| potionPercent | int(2) | NO |  | 0 |  |
| potionValue | int(2) | NO |  | 0 |  |
| hprAbsol32Second | int(2) | NO |  | 0 |  |
| mprAbsol64Second | int(2) | NO |  | 0 |  |
| mprAbsol16Second | int(2) | NO |  | 0 |  |
| hpPotionDelayDecrease | int(4) | NO |  | 0 |  |
| hpPotionCriticalProb | int(4) | NO |  | 0 |  |
| increaseArmorSkillProb | int(4) | NO |  | 0 |  |
| attackSpeedDelayRate | int(3) | NO |  | 0 |  |
| moveSpeedDelayRate | int(3) | NO |  | 0 |  |
| buffDurationSecond | int(8) | NO |  | 0 |  |
| locx | int(6) unsigned | NO |  | 0 |  |
| locy | int(6) unsigned | NO |  | 0 |  |
| mapid | int(6) unsigned | NO |  | 0 |  |
| bless | int(2) unsigned | NO |  | 1 |  |
| trade | int(2) unsigned | NO |  | 0 |  |
| retrieve | int(2) unsigned | NO |  | 0 |  |
| specialretrieve | int(2) unsigned | NO |  | 0 |  |
| cant_delete | int(2) unsigned | NO |  | 0 |  |
| cant_sell | int(2) unsigned | NO |  | 0 |  |
| delay_id | int(10) unsigned | NO |  | 0 |  |
| delay_time | int(10) unsigned | NO |  | 0 |  |
| delay_effect | int(10) unsigned | NO |  | 0 |  |
| food_volume | int(10) unsigned | NO |  | 0 |  |
| save_at_once | tinyint(1) unsigned | NO |  | 1 |  |
| Magic_name | varchar(20) | YES |  |  |  |
| level | int(3) unsigned | NO |  | 0 |  |
| attr | enum('EARTH','AIR','WATER','FIRE','NONE') | NO |  | NONE |  |
| alignment | enum('CAOTIC','NEUTRAL','LAWFUL','NONE') | NO |  | NONE |  |
| use_royal | int(2) unsigned | NO |  | 0 |  |
| use_knight | int(2) unsigned | NO |  | 0 |  |
| use_mage | int(2) unsigned | NO |  | 0 |  |
| use_elf | int(2) unsigned | NO |  | 0 |  |
| use_darkelf | int(2) unsigned | NO |  | 0 |  |
| use_dragonknight | int(2) unsigned | NO |  | 0 |  |
| use_illusionist | int(2) unsigned | NO |  | 0 |  |
| use_warrior | int(2) unsigned | NO |  | 0 |  |
| use_fencer | int(2) unsigned | NO |  | 0 |  |
| use_lancer | int(2) unsigned | NO |  | 0 |  |
| skill_type | enum('passive','active','none') | NO |  | none |  |
| etc_value | int(10) | NO |  | 0 |  |
| limit_type | enum('WORLD_WAR','BEGIN_ZONE','NONE') | NO |  | NONE |  |
| prob | int(3) | NO |  | 0 |  |


## Table: `event`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| event_id | int(10) | NO | PRI | 0 |  |
| description | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| desc_en | varchar(50) | NO |  |  |  |
| start_date | datetime | YES |  |  |  |
| finish_date | datetime | YES |  |  |  |
| broadcast | enum('true','false') | NO |  | false |  |
| event_flag | enum('SPAWN_NPC','DROP_ADENA','DROP_ITEM','POLY') | NO |  | SPAWN_NPC |  |
| spawn_data | text | YES |  |  |  |
| drop_rate | float | NO |  | 1 |  |
| finish_delete_item | text | YES |  |  |  |
| finish_map_rollback | text | YES |  |  |  |


## Table: `exp`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| level | int(10) | NO | PRI |  |  |
| exp | int(11) | NO |  | 0 |  |
| panalty | varchar(100) | NO |  | 1 |  |


## Table: `favorbook`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| listId | int(2) | NO |  | 0 |  |
| category | int(3) | NO | PRI | 0 |  |
| slotId | int(1) | NO | PRI |  |  |
| itemIds | text | YES |  |  |  |
| note | varchar(100) | YES |  |  |  |
| desc_kr | varchar(100) | NO |  |  |  |


## Table: `free_pvp_region`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| worldNumber | int(6) | NO | PRI | 0 |  |
| desc | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| isFreePvpZone | enum('true','false') | NO |  | true |  |
| box_index | int(3) | NO | PRI | 0 |  |
| box_sx | int(5) | NO |  | 0 |  |
| box_sy | int(5) | NO |  | 0 |  |
| box_ex | int(5) | NO |  | 0 |  |
| box_ey | int(5) | NO |  | 0 |  |


## Table: `getback`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| area_x1 | int(10) | NO | PRI | 0 |  |
| area_y1 | int(10) | NO | PRI | 0 |  |
| area_x2 | int(10) | NO | PRI | 0 |  |
| area_y2 | int(10) | NO | PRI | 0 |  |
| area_mapid | int(10) | NO | PRI | 0 |  |
| getback_x1 | int(10) | NO |  | 0 |  |
| getback_y1 | int(10) | NO |  | 0 |  |
| getback_x2 | int(10) | NO |  | 0 |  |
| getback_y2 | int(10) | NO |  | 0 |  |
| getback_x3 | int(10) | NO |  | 0 |  |
| getback_y3 | int(10) | NO |  | 0 |  |
| getback_mapid | int(10) | NO |  | 0 |  |
| getback_townid | int(10) unsigned | NO |  | 0 |  |
| getback_townid_elf | int(10) unsigned | NO |  | 0 |  |
| getback_townid_darkelf | int(10) unsigned | NO |  | 0 |  |
| scrollescape | int(10) | NO |  | 1 |  |
| note | varchar(50) | NO |  |  |  |


## Table: `getback_restart`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| area | int(10) | NO | PRI | 0 |  |
| note | varchar(50) | YES |  |  |  |
| locx | int(10) | NO |  | 0 |  |
| locy | int(10) | NO |  | 0 |  |
| mapid | int(10) | NO |  | 0 |  |


## Table: `house`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| house_id | int(10) unsigned | NO | PRI | 0 |  |
| house_name | varchar(45) | NO |  |  |  |
| house_area | int(10) unsigned | NO |  | 0 |  |
| location | varchar(45) | NO |  |  |  |
| keeper_id | int(10) unsigned | NO |  | 0 |  |
| is_on_sale | int(10) unsigned | NO |  | 0 |  |
| is_purchase_basement | int(10) unsigned | NO |  | 0 |  |
| tax_deadline | datetime | YES |  |  |  |


## Table: `hunting_quest`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| area_name | varchar(50) | NO |  |  |  |
| map_number | int(6) | NO |  | 0 |  |
| location_desc | int(6) | YES |  |  |  |
| quest_id | int(6) | NO | PRI | 0 |  |
| is_use | enum('true','false') | NO |  | true |  |


## Table: `hunting_quest_teleport`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| action_string | varchar(50) | NO | PRI |  |  |
| tel_mapid | int(6) | NO |  | 0 |  |
| tel_x | int(4) | YES |  |  |  |
| tel_y | int(4) | YES |  |  |  |
| tel_itemid | int(10) | YES |  |  |  |


## Table: `inter_race_region`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| loc_x | int(10) | YES |  |  |  |
| loc_y | int(10) | YES |  |  |  |
| loc_mapid | int(10) | YES |  |  |  |


## Table: `item_bookmark`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| book_id | int(10) unsigned | NO |  | 0 |  |
| item_id | int(10) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |


## Table: `item_box`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| boxId | int(10) | NO | PRI | 0 |  |
| name | varchar(50) | YES |  |  |  |
| classType | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','all') | NO | PRI | all |  |
| itemId | int(10) | NO | PRI | 0 |  |
| count | int(10) | NO |  | 1 |  |
| enchant | int(2) | NO |  | 0 |  |
| bless | int(3) | NO |  | 1 |  |
| attr | int(2) | NO |  | 0 |  |
| identi | enum('true','false') | NO |  | false |  |
| limitTime | int(10) | NO |  | 0 |  |
| limitMaps | varchar(200) | YES |  |  |  |
| questBox | enum('true','false') | NO |  | false |  |
| effectId | int(6) | NO |  | 0 |  |
| chance | int(3) | NO |  | 100 |  |
| validateItems | text | YES |  |  |  |
| boxDelete | enum('false','true') | NO |  | true |  |


## Table: `item_buff`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) | NO | PRI | 0 |  |
| name | varchar(100) | YES |  |  |  |
| skill_ids | varchar(100) | NO |  |  |  |
| delete | enum('false','true') | NO |  | false |  |


## Table: `item_click_message`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI |  |  |
| type | enum('true','false') | NO |  | false |  |
| msg | varchar(500) | YES |  |  |  |
| delete | enum('true','false') | NO |  | false |  |


## Table: `item_collection`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI | 0 |  |
| name | varchar(70) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| type | int(3) | NO |  | 0 |  |


## Table: `item_enchant_ablity`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(3) | NO | PRI | 0 |  |
| name | varchar(70) | NO |  |  |  |
| desc_kr | varchar(45) | YES |  |  |  |
| enchant | int(2) | NO | PRI | 0 |  |
| ac_bonus | int(2) | NO |  | 0 |  |
| ac_sub | int(3) | NO |  | 0 |  |
| str | int(2) | NO |  | 0 |  |
| con | int(2) | NO |  | 0 |  |
| dex | int(2) | NO |  | 0 |  |
| int | int(2) | NO |  | 0 |  |
| wis | int(2) | NO |  | 0 |  |
| cha | int(2) | NO |  | 0 |  |
| shortDamage | int(2) | NO |  | 0 |  |
| shortHit | int(2) | NO |  | 0 |  |
| shortCritical | int(2) | NO |  | 0 |  |
| longDamage | int(2) | NO |  | 0 |  |
| longHit | int(2) | NO |  | 0 |  |
| longCritical | int(2) | NO |  | 0 |  |
| spellpower | int(2) | NO |  | 0 |  |
| magicHit | int(2) | NO |  | 0 |  |
| magicCritical | int(2) | NO |  | 0 |  |
| magicDamage | int(2) | NO |  | 0 |  |
| maxHp | int(3) | NO |  | 0 |  |
| maxMp | int(3) | NO |  | 0 |  |
| hpRegen | int(2) | NO |  | 0 |  |
| mpRegen | int(2) | NO |  | 0 |  |
| baseHpRate | int(2) | NO |  | 0 |  |
| baseMpRate | int(2) | NO |  | 0 |  |
| attrFire | int(2) | NO |  | 0 |  |
| attrWater | int(2) | NO |  | 0 |  |
| attrWind | int(2) | NO |  | 0 |  |
| attrEarth | int(2) | NO |  | 0 |  |
| attrAll | int(2) | NO |  | 0 |  |
| mr | int(2) | NO |  | 0 |  |
| carryBonus | int(3) | NO |  | 0 |  |
| dg | int(2) | NO |  | 0 |  |
| er | int(2) | NO |  | 0 |  |
| me | int(2) | NO |  | 0 |  |
| reduction | int(2) | NO |  | 0 |  |
| reductionEgnor | int(2) | NO |  | 0 |  |
| reductionMagic | int(2) | NO |  | 0 |  |
| reductionPercent | int(2) | NO |  | 0 |  |
| PVPDamage | int(2) | NO |  | 0 |  |
| PVPReduction | int(2) | NO |  | 0 |  |
| PVPReductionPercent | int(2) | NO |  | 0 |  |
| PVPReductionEgnor | int(2) | NO |  | 0 |  |
| PVPReductionMagic | int(2) | NO |  | 0 |  |
| PVPReductionMagicEgnor | int(2) | NO |  | 0 |  |
| abnormalStatusDamageReduction | int(2) | NO |  | 0 |  |
| abnormalStatusPVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamagePercent | int(2) | NO |  | 0 |  |
| registBlind | int(2) | NO |  | 0 |  |
| registFreeze | int(2) | NO |  | 0 |  |
| registSleep | int(2) | NO |  | 0 |  |
| registStone | int(2) | NO |  | 0 |  |
| toleranceSkill | int(2) | NO |  | 0 |  |
| toleranceSpirit | int(2) | NO |  | 0 |  |
| toleranceDragon | int(2) | NO |  | 0 |  |
| toleranceFear | int(2) | NO |  | 0 |  |
| toleranceAll | int(2) | NO |  | 0 |  |
| hitupSkill | int(2) | NO |  | 0 |  |
| hitupSpirit | int(2) | NO |  | 0 |  |
| hitupDragon | int(2) | NO |  | 0 |  |
| hitupFear | int(2) | NO |  | 0 |  |
| hitupAll | int(2) | NO |  | 0 |  |
| potionPlusDefens | int(2) | NO |  | 0 |  |
| potionPlusPercent | int(2) | NO |  | 0 |  |
| potionPlusValue | int(2) | NO |  | 0 |  |
| hprAbsol32Second | int(2) | NO |  | 0 |  |
| mprAbsol64Second | int(2) | NO |  | 0 |  |
| mprAbsol16Second | int(2) | NO |  | 0 |  |
| imunEgnor | int(2) | NO |  | 0 |  |
| expBonus | int(2) | NO |  | 0 |  |
| einBlessExp | int(2) | NO |  | 0 |  |
| rest_exp_reduce_efficiency | int(2) | NO |  | 0 |  |
| fowSlayerDamage | int(2) | NO |  | 0 |  |
| titanUp | int(2) | NO |  | 0 |  |
| stunDuration | int(2) | NO |  | 0 |  |
| tripleArrowStun | int(2) | NO |  | 0 |  |
| vanguardTime | int(2) | NO |  | 0 |  |
| strangeTimeIncrease | int(4) | NO |  | 0 |  |
| strangeTimeDecrease | int(4) | NO |  | 0 |  |
| hpPotionDelayDecrease | int(4) | NO |  | 0 |  |
| hpPotionCriticalProb | int(4) | NO |  | 0 |  |
| increaseArmorSkillProb | int(4) | NO |  | 0 |  |
| returnLockDuraion | int(2) | NO |  | 0 |  |
| attackSpeedDelayRate | int(3) | NO |  | 0 |  |
| moveSpeedDelayRate | int(3) | NO |  | 0 |  |
| magicName | varchar(50) | YES |  |  |  |


## Table: `item_key_boss`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_obj_id | int(11) | NO | PRI |  |  |
| key_id | int(11) | NO | PRI |  |  |


## Table: `item_ment`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI | 0 |  |
| itemName | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| mentType | enum('treasurebox','craft','drop','pickup') | NO | PRI | pickup |  |


## Table: `item_selector`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(11) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| selectItemId | int(11) | NO | PRI | 0 |  |
| selectName | varchar(45) | YES |  |  |  |
| select_desc_kr | varchar(45) | NO |  |  |  |
| count | int(10) | NO |  | 1 |  |
| enchant | int(4) | NO |  | 0 |  |
| attr | enum('5','4','3','2','1','0') | NO |  | 0 |  |
| bless | int(3) | NO |  | 1 |  |
| limitTime | int(10) | NO |  | 0 |  |
| delete | enum('false','true') | NO |  | true |  |


## Table: `item_selector_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(11) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| selectItemId | int(11) | NO | PRI | 0 |  |
| selectName | varchar(45) | YES |  |  |  |
| select_desc_kr | varchar(45) | NO |  |  |  |
| index | int(3) | NO |  | 0 |  |
| enchantLevel | int(2) | NO |  | 0 |  |
| attrLevel | int(2) | NO |  | 0 |  |


## Table: `item_terms`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(9) | NO | PRI | 0 |  |
| name | varchar(50) | YES |  |  |  |
| desc_kr | varchar(50) | NO |  |  |  |
| termMinut | int(9) | NO |  | 0 |  |


## Table: `letter`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_object_id | int(10) unsigned | NO | PRI | 0 |  |
| code | int(10) unsigned | NO |  | 0 |  |
| sender | varchar(16) | YES |  |  |  |
| receiver | varchar(16) | YES |  |  |  |
| date | datetime | YES |  |  |  |
| template_id | int(5) unsigned | NO |  | 0 |  |
| subject | varchar(20) | YES |  |  |  |
| content | varchar(2000) | YES |  |  |  |
| isCheck | bit(1) | YES |  |  |  |


## Table: `letter_command`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| subject | varchar(100) | YES |  |  |  |
| content | varchar(500) | YES |  |  |  |


## Table: `letter_spam`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| no | int(10) | NO | PRI | 0 |  |
| name | varchar(16) | YES |  |  |  |
| spamname | varchar(16) | YES |  |  |  |


## Table: `levelup_quests_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| level | int(10) | NO | MUL | 0 |  |
| type | int(5) | NO | MUL | 0 |  |
| note | varchar(100) | YES |  |  |  |
| item_name | varchar(50) | NO |  |  |  |
| item_id | int(10) | NO |  | 0 |  |
| count | int(10) | NO |  | 0 |  |
| enchant | int(6) | NO |  | 0 |  |
| attrlevel | int(5) | NO |  | 0 |  |
| bless | int(5) | NO |  | 1 |  |


## Table: `log_adena_monster`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| startTime | datetime | YES |  |  |  |
| endTime | datetime | YES |  |  |  |
| accounts | varchar(20) | YES |  |  |  |
| name | varchar(20) | YES |  |  |  |
| count | int(20) | YES |  |  |  |


## Table: `log_adena_shop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| startTime | datetime | YES |  |  |  |
| endTime | datetime | YES |  |  |  |
| accounts | varchar(20) | YES |  |  |  |
| name | varchar(20) | YES |  |  |  |
| count | int(20) | YES |  |  |  |


## Table: `log_chat`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| account_name | varchar(50) | NO |  |  |  |
| char_id | int(10) | NO |  |  |  |
| name | varchar(50) | NO |  |  |  |
| clan_id | int(10) | NO |  |  |  |
| clan_name | varchar(50) | YES |  |  |  |
| locx | int(10) | NO |  |  |  |
| locy | int(10) | NO |  |  |  |
| mapid | int(10) | NO |  |  |  |
| type | int(10) | NO |  |  |  |
| target_account_name | varchar(50) | YES |  |  |  |
| target_id | int(10) | YES |  | 0 |  |
| target_name | varchar(50) | YES |  |  |  |
| target_clan_id | int(10) | YES |  |  |  |
| target_clan_name | varchar(50) | YES |  |  |  |
| target_locx | int(10) | YES |  |  |  |
| target_locy | int(10) | YES |  |  |  |
| target_mapid | int(10) | YES |  |  |  |
| content | varchar(256) | NO |  |  |  |
| datetime | datetime | NO |  |  |  |


## Table: `log_cwarehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| datetime | timestamp | YES |  |  | on update current_timestamp() |
| type | varchar(45) | NO |  |  |  |
| clan_id | int(10) | YES |  |  |  |
| clan_name | varchar(45) | YES |  |  |  |
| account | varchar(45) | YES |  |  |  |
| char_id | int(10) | YES |  |  |  |
| char_name | varchar(45) | YES |  |  |  |
| item_id | varchar(45) | YES |  |  |  |
| item_name | varchar(45) | YES |  |  |  |
| item_enchantlvl | varchar(45) | YES |  |  |  |
| item_count | int(10) | YES |  |  |  |


## Table: `log_enchant`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| char_id | int(10) | NO | MUL | 0 |  |
| item_id | int(10) unsigned | NO |  | 0 |  |
| old_enchantlvl | int(3) | NO |  | 0 |  |
| new_enchantlvl | int(3) | YES |  | 0 |  |


## Table: `log_private_shop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| time | timestamp | YES |  |  | on update current_timestamp() |
| type | varchar(45) | NO |  |  |  |
| shop_account | varchar(45) | YES |  |  |  |
| shop_id | int(10) | YES |  |  |  |
| shop_name | varchar(45) | YES |  |  |  |
| user_account | varchar(45) | YES |  |  |  |
| user_id | int(10) | YES |  |  |  |
| user_name | varchar(45) | YES |  |  |  |
| item_id | int(10) | YES |  |  |  |
| item_name | varchar(45) | YES |  |  |  |
| item_enchantlvl | int(10) | YES |  |  |  |
| price | int(12) | YES |  |  |  |
| item_count | int(10) | YES |  |  |  |
| total_price | int(12) | YES |  |  |  |


## Table: `log_shop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| time | timestamp | YES |  |  | on update current_timestamp() |
| type | varchar(45) | NO |  |  |  |
| npc_id | varchar(45) | YES |  |  |  |
| user_account | varchar(45) | YES |  |  |  |
| user_id | int(10) | YES |  |  |  |
| user_name | varchar(45) | YES |  |  |  |
| item_id | int(10) | YES |  |  |  |
| item_name | varchar(45) | YES |  |  |  |
| item_enchantlvl | int(10) | YES |  |  |  |
| price | int(12) | YES |  |  |  |
| item_count | int(10) | YES |  |  |  |
| total_price | int(12) | YES |  |  |  |


## Table: `log_warehouse`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| datetime | timestamp | YES |  |  | on update current_timestamp() |
| type | varchar(45) | NO |  |  |  |
| account | varchar(45) | YES |  |  |  |
| char_id | int(10) | YES |  |  |  |
| char_name | varchar(45) | YES |  |  |  |
| item_id | varchar(45) | YES |  |  |  |
| item_name | varchar(45) | YES |  |  |  |
| item_enchantlvl | varchar(45) | YES |  |  |  |
| item_count | int(10) | YES |  |  |  |


## Table: `magicdoll_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(11) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| dollNpcId | int(11) | NO |  | 0 |  |
| blessItemId | int(11) | YES |  | 0 |  |
| grade | int(2) | NO |  | 0 |  |
| bonusItemId | int(11) | NO |  | 0 |  |
| bonusCount | int(11) | NO |  | 0 |  |
| bonusInterval | int(11) | NO |  | 0 |  |
| damageChance | int(3) | NO |  | 0 |  |
| attackSkillEffectId | int(5) | NO |  | 0 |  |
| haste | enum('true','false') | NO |  | false |  |


## Table: `magicdoll_potential`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| bonusId | int(3) | NO | PRI | 0 |  |
| name | varchar(70) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| isUse | enum('false','true') | YES |  | true |  |
| ac_bonus | int(2) | NO |  | 0 |  |
| str | int(2) | NO |  | 0 |  |
| con | int(2) | NO |  | 0 |  |
| dex | int(2) | NO |  | 0 |  |
| int | int(2) | NO |  | 0 |  |
| wis | int(2) | NO |  | 0 |  |
| cha | int(2) | NO |  | 0 |  |
| allStatus | int(2) | NO |  | 0 |  |
| shortDamage | int(2) | NO |  | 0 |  |
| shortHit | int(2) | NO |  | 0 |  |
| shortCritical | int(2) | NO |  | 0 |  |
| longDamage | int(2) | NO |  | 0 |  |
| longHit | int(2) | NO |  | 0 |  |
| longCritical | int(2) | NO |  | 0 |  |
| spellpower | int(2) | NO |  | 0 |  |
| magicHit | int(2) | NO |  | 0 |  |
| magicCritical | int(2) | NO |  | 0 |  |
| hp | int(3) | NO |  | 0 |  |
| mp | int(3) | NO |  | 0 |  |
| hpr | int(2) | NO |  | 0 |  |
| mpr | int(2) | NO |  | 0 |  |
| hpStill | int(2) | NO |  | 0 |  |
| mpStill | int(2) | NO |  | 0 |  |
| stillChance | int(3) | NO |  | 0 |  |
| hprAbsol | int(2) | NO |  | 0 |  |
| mprAbsol | int(2) | NO |  | 0 |  |
| attrFire | int(2) | NO |  | 0 |  |
| attrWater | int(2) | NO |  | 0 |  |
| attrWind | int(2) | NO |  | 0 |  |
| attrEarth | int(2) | NO |  | 0 |  |
| attrAll | int(2) | NO |  | 0 |  |
| mr | int(2) | NO |  | 0 |  |
| expBonus | int(3) | NO |  | 0 |  |
| carryBonus | int(3) | NO |  | 0 |  |
| dg | int(2) | NO |  | 0 |  |
| er | int(2) | NO |  | 0 |  |
| me | int(2) | NO |  | 0 |  |
| reduction | int(2) | NO |  | 0 |  |
| reductionEgnor | int(2) | NO |  | 0 |  |
| reductionMagic | int(2) | NO |  | 0 |  |
| reductionPercent | int(2) | NO |  | 0 |  |
| PVPDamage | int(2) | NO |  | 0 |  |
| PVPReduction | int(2) | NO |  | 0 |  |
| PVPReductionEgnor | int(2) | NO |  | 0 |  |
| PVPReductionMagic | int(2) | NO |  | 0 |  |
| PVPReductionMagicEgnor | int(2) | NO |  | 0 |  |
| toleranceSkill | int(2) | NO |  | 0 |  |
| toleranceSpirit | int(2) | NO |  | 0 |  |
| toleranceDragon | int(2) | NO |  | 0 |  |
| toleranceFear | int(2) | NO |  | 0 |  |
| toleranceAll | int(2) | NO |  | 0 |  |
| hitupSkill | int(2) | NO |  | 0 |  |
| hitupSpirit | int(2) | NO |  | 0 |  |
| hitupDragon | int(2) | NO |  | 0 |  |
| hitupFear | int(2) | NO |  | 0 |  |
| hitupAll | int(2) | NO |  | 0 |  |
| imunEgnor | int(2) | NO |  | 0 |  |
| strangeTimeIncrease | int(4) | NO |  | 0 |  |
| firstSpeed | enum('true','false') | NO |  | false |  |
| secondSpeed | enum('true','false') | NO |  | false |  |
| thirdSpeed | enum('true','false') | NO |  | false |  |
| forthSpeed | enum('true','false') | NO |  | false |  |
| skilId | int(9) | NO |  | -1 |  |
| skillChance | int(3) | NO |  | 0 |  |


## Table: `map_balance`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mapId | mediumint(5) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| damageType | enum('both','attack','magic') | NO |  | both |  |
| damageValue | float | NO |  | 1 |  |
| reductionType | enum('both','attack','magic') | NO |  | both |  |
| reductionValue | float | NO |  | 1 |  |
| expValue | float | NO |  | 1 |  |
| dropValue | float | NO |  | 1 |  |
| adenaValue | float | NO |  | 1 |  |


## Table: `map_fix_key`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| locX | smallint(6) unsigned | NO | PRI |  |  |
| locY | smallint(6) unsigned | NO | PRI |  |  |
| mapId | smallint(6) unsigned | NO | PRI |  |  |


## Table: `map_type`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mapId | int(6) | NO | PRI | 0 |  |
| desc | varchar(50) | YES |  |  |  |
| type | enum('COMBAT','SAFETY','NORMAL') | NO |  | NORMAL |  |


## Table: `mapids`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mapid | int(10) | NO | PRI | 0 |  |
| locationname | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| startX | int(10) unsigned | NO |  | 0 |  |
| endX | int(10) unsigned | NO |  | 0 |  |
| startY | int(10) unsigned | NO |  | 0 |  |
| endY | int(10) unsigned | NO |  | 0 |  |
| monster_amount | float unsigned | NO |  | 0 |  |
| drop_rate | float unsigned | NO |  | 0 |  |
| underwater | tinyint(1) unsigned | NO |  | 0 |  |
| markable | tinyint(1) unsigned | NO |  | 0 |  |
| teleportable | tinyint(1) unsigned | NO |  | 0 |  |
| escapable | tinyint(1) unsigned | NO |  | 0 |  |
| resurrection | tinyint(1) unsigned | NO |  | 0 |  |
| painwand | tinyint(1) unsigned | NO |  | 0 |  |
| penalty | tinyint(1) unsigned | NO |  | 0 |  |
| take_pets | tinyint(1) unsigned | NO |  | 0 |  |
| recall_pets | tinyint(1) unsigned | NO |  | 0 |  |
| usable_item | tinyint(1) unsigned | NO |  | 0 |  |
| usable_skill | tinyint(1) unsigned | NO |  | 0 |  |
| dungeon | tinyint(1) unsigned | NO |  | 0 |  |
| dmgModiPc2Npc | int(3) | NO |  | 0 |  |
| dmgModiNpc2Pc | int(3) | NO |  | 0 |  |
| decreaseHp | tinyint(1) unsigned | NO |  | 0 |  |
| dominationTeleport | tinyint(1) unsigned | NO |  | 0 |  |
| beginZone | tinyint(1) unsigned | NO |  | 0 |  |
| redKnightZone | tinyint(1) unsigned | NO |  | 0 |  |
| ruunCastleZone | tinyint(1) unsigned | NO |  | 0 |  |
| interWarZone | tinyint(1) unsigned | NO |  | 0 |  |
| geradBuffZone | tinyint(1) unsigned | NO |  | 0 |  |
| growBuffZone | tinyint(1) unsigned | NO |  | 0 |  |
| interKind | int(3) | NO |  | 0 |  |
| script | varchar(50) | YES |  |  |  |
| cloneStart | int(6) | NO |  | 0 |  |
| cloneEnd | int(6) | NO |  | 0 |  |
| pngId | int(11) | YES |  | 0 |  |


## Table: `marble`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| marble_id | int(10) | NO | PRI |  |  |
| char_id | int(10) | YES |  |  |  |
| char_name | varchar(20) | YES |  |  |  |


## Table: `mobgroup`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| note | varchar(255) | NO |  |  |  |
| remove_group_if_leader_die | int(10) unsigned | NO |  | 0 |  |
| leader_id | int(10) unsigned | NO |  | 0 |  |
| minion1_id | int(10) unsigned | NO |  | 0 |  |
| minion1_count | int(10) unsigned | NO |  | 0 |  |
| minion2_id | int(10) unsigned | NO |  | 0 |  |
| minion2_count | int(10) unsigned | NO |  | 0 |  |
| minion3_id | int(10) unsigned | NO |  | 0 |  |
| minion3_count | int(10) unsigned | NO |  | 0 |  |
| minion4_id | int(10) unsigned | NO |  | 0 |  |
| minion4_count | int(10) unsigned | NO |  | 0 |  |
| minion5_id | int(10) unsigned | NO |  | 0 |  |
| minion5_count | int(10) unsigned | NO |  | 0 |  |
| minion6_id | int(10) unsigned | NO |  | 0 |  |
| minion6_count | int(10) unsigned | NO |  | 0 |  |
| minion7_id | int(10) unsigned | NO |  | 0 |  |
| minion7_count | int(10) unsigned | NO |  | 0 |  |
| minion8_id | int(10) unsigned | NO |  | 0 |  |
| minion8_count | int(10) unsigned | NO |  | 0 |  |


## Table: `mobskill`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mobid | int(10) unsigned | NO | PRI | 0 |  |
| actNo | int(3) unsigned | NO | PRI | 0 |  |
| mobname | varchar(45) | NO |  |  |  |
| desc_en | varchar(100) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| type | enum('NONE','ATTACK','SPELL','SUMMON','POLY','LINE_ATTACK','KIRTAS_METEOR','KIRTAS_BARRIER','TITANGOLEM_BARRIER','VALLACAS_FLY','VALLACAS_BRESS') | NO |  | NONE |  |
| prob | int(3) unsigned | NO |  | 0 |  |
| enableHp | int(3) unsigned | NO |  | 0 |  |
| enableCompanionHp | int(3) unsigned | NO |  | 0 |  |
| range | int(3) | NO |  | 0 |  |
| limitCount | int(3) | NO |  | 0 |  |
| ChangeTarget | enum('NO','COMPANION','ME','RANDOM') | NO |  | NO |  |
| AreaWidth | int(3) unsigned | NO |  | 0 |  |
| AreaHeight | int(3) unsigned | NO |  | 0 |  |
| Leverage | int(3) unsigned | NO |  | 0 |  |
| SkillId | int(10) | NO |  | -1 |  |
| Gfxid | int(10) unsigned | NO |  | 0 |  |
| ActId | int(3) unsigned | NO |  | 0 |  |
| SummonId | int(10) unsigned | NO |  | 0 |  |
| SummonMin | int(3) | NO |  | 0 |  |
| SummonMax | int(3) | NO |  | 0 |  |
| PolyId | int(10) unsigned | NO |  | 0 |  |
| Msg | varchar(45) | YES |  |  |  |


## Table: `monster_book`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| monsternumber | int(10) unsigned | NO | PRI |  | auto_increment |
| monstername | varchar(255) | NO |  |  |  |
| desc_kr | varchar(256) | NO |  |  |  |
| monster_id | int(10) | YES |  |  |  |
| locx | int(10) unsigned | YES |  | 0 |  |
| locy | int(10) unsigned | YES |  | 0 |  |
| mapid | int(10) unsigned | YES |  | 0 |  |
| type | int(10) | YES |  |  |  |
| marterial | int(10) | YES |  |  |  |
| book_step_first | int(10) | YES |  |  |  |
| book_step_second | int(10) | YES |  |  |  |
| book_step_third | int(10) | YES |  |  |  |
| note | varchar(255) | YES |  |  |  |


## Table: `notice`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(30) | NO | PRI |  |  |
| message | text | NO |  |  |  |


## Table: `notification`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| notification_id | int(6) | NO | PRI | 0 |  |
| notification_type | enum('NORMAL(0)','CHANGE(1)') | NO |  | NORMAL(0) |  |
| is_use | enum('true','false') | NO |  | true |  |
| is_hyperlink | enum('true','false') | NO |  | false |  |
| displaydesc | varchar(50) | YES |  |  |  |
| displaydesc_kr | varchar(50) | YES |  |  |  |
| displaydesc_en | varchar(50) | NO |  |  |  |
| date_type | enum('NONE(0)','CUSTOM(1)','BOSS(2)','DOMINATION_TOWER(3)','COLOSSEUM(4)','TREASURE(5)','FORGOTTEN(6)') | NO |  | NONE(0) |  |
| date_boss_id | int(10) | NO |  | 0 |  |
| date_custom_start | datetime | YES |  |  |  |
| date_custom_end | datetime | YES |  |  |  |
| teleport_loc | text | YES |  |  |  |
| rest_gauge_bonus | int(4) | NO |  | 0 |  |
| is_new | enum('true','false') | NO |  | false |  |
| animation_type | enum('NO_ANIMATION(0)','ANT_QUEEN(1)','OMAN_MORPH(2)','AI_BATTLE(3)') | NO |  | NO_ANIMATION(0) |  |


## Table: `notification_event_npc`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| notification_id | int(6) | NO | PRI | 0 |  |
| is_use | enum('true','false') | NO |  | true |  |
| order_id | int(2) | NO | PRI | 0 |  |
| npc_id | int(10) | NO |  | 0 |  |
| displaydesc | varchar(50) | NO |  |  |  |
| displaydesc_en | varchar(50) | NO |  |  |  |
| displaydesc_kr | varchar(50) | YES |  |  |  |
| rest_gauge_bonus | int(4) | NO |  | 0 |  |


## Table: `npc`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npcid | int(10) unsigned | NO | PRI |  | auto_increment |
| classId | int(6) | NO |  | 0 |  |
| desc_en | varchar(100) | NO |  |  |  |
| desc_powerbook | varchar(100) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| desc_id | varchar(45) | NO |  |  |  |
| note | varchar(45) | NO |  |  |  |
| impl | varchar(45) | NO |  |  |  |
| spriteId | int(10) unsigned | NO |  | 0 |  |
| lvl | int(3) unsigned | NO |  | 0 |  |
| hp | int(6) unsigned | NO |  | 0 |  |
| mp | int(6) unsigned | NO |  | 0 |  |
| ac | int(3) | NO |  | 0 |  |
| str | int(3) | NO |  | 0 |  |
| con | int(3) | NO |  | 0 |  |
| dex | int(3) | NO |  | 0 |  |
| wis | int(3) | NO |  | 0 |  |
| intel | int(3) | NO |  | 0 |  |
| mr | int(3) | NO |  | 0 |  |
| exp | int(10) unsigned | NO |  | 0 |  |
| alignment | int(10) | NO |  | 0 |  |
| big | enum('true','false') | NO |  | false |  |
| weakAttr | enum('NONE','EARTH','FIRE','WATER','WIND') | NO |  | NONE |  |
| ranged | int(3) unsigned | NO |  | 0 |  |
| is_taming | enum('true','false') | NO |  | false |  |
| passispeed | int(6) unsigned | NO |  | 0 |  |
| atkspeed | int(6) unsigned | NO |  | 0 |  |
| atk_magic_speed | int(6) unsigned | NO |  | 0 |  |
| sub_magic_speed | int(6) unsigned | NO |  | 0 |  |
| undead | enum('NONE','UNDEAD','DEMON','UNDEAD_BOSS','DRANIUM') | NO |  | NONE |  |
| poison_atk | enum('NONE','DAMAGE','PARALYSIS','SILENCE') | NO |  | NONE |  |
| is_agro | enum('false','true') | NO |  | false |  |
| is_agro_poly | enum('false','true') | NO |  | false |  |
| is_agro_invis | enum('false','true') | NO |  | false |  |
| family | varchar(20) | NO |  |  |  |
| agrofamily | int(1) unsigned | NO |  | 0 |  |
| agrogfxid1 | int(10) | NO |  | -1 |  |
| agrogfxid2 | int(10) | NO |  | -1 |  |
| is_picupitem | enum('false','true') | NO |  | false |  |
| digestitem | int(1) unsigned | NO |  | 0 |  |
| is_bravespeed | enum('false','true') | NO |  | false |  |
| hprinterval | int(6) unsigned | NO |  | 0 |  |
| hpr | int(5) unsigned | NO |  | 0 |  |
| mprinterval | int(6) unsigned | NO |  | 0 |  |
| mpr | int(5) unsigned | NO |  | 0 |  |
| is_teleport | enum('true','false') | NO |  | false |  |
| randomlevel | int(3) unsigned | NO |  | 0 |  |
| randomhp | int(5) unsigned | NO |  | 0 |  |
| randommp | int(5) unsigned | NO |  | 0 |  |
| randomac | int(3) | NO |  | 0 |  |
| randomexp | int(5) unsigned | NO |  | 0 |  |
| randomAlign | int(5) | NO |  | 0 |  |
| damage_reduction | int(5) unsigned | NO |  | 0 |  |
| is_hard | enum('true','false') | NO |  | false |  |
| is_bossmonster | enum('true','false') | NO |  | false |  |
| can_turnundead | enum('true','false') | NO |  | false |  |
| bowSpritetId | int(5) unsigned | NO |  | 0 |  |
| karma | int(10) | NO |  | 0 |  |
| transform_id | int(10) | NO |  | -1 |  |
| transform_gfxid | int(10) | NO |  | 0 |  |
| light_size | tinyint(3) unsigned | NO |  | 0 |  |
| is_amount_fixed | enum('false','true') | NO |  | false |  |
| is_change_head | enum('false','true') | NO |  | false |  |
| spawnlist_door | int(10) | NO |  | 0 |  |
| count_map | int(10) | NO |  | 0 |  |
| cant_resurrect | enum('false','true') | NO |  | false |  |
| isHide | enum('true','false') | NO |  | false |  |


## Table: `npc2`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npcid | int(10) unsigned | NO |  |  |  |
| classId | int(6) | NO |  | 0 |  |
| desc_en | varchar(100) | NO |  |  |  |
| desc_powerbook | varchar(100) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| desc_id | varchar(45) | NO |  |  |  |
| note | varchar(45) | NO |  |  |  |
| impl | varchar(45) | NO |  |  |  |
| spriteId | int(10) unsigned | NO |  | 0 |  |
| lvl | int(3) unsigned | NO |  | 0 |  |
| hp | int(6) unsigned | NO |  | 0 |  |
| mp | int(6) unsigned | NO |  | 0 |  |
| ac | int(3) | NO |  | 0 |  |
| str | int(3) | NO |  | 0 |  |
| con | int(3) | NO |  | 0 |  |
| dex | int(3) | NO |  | 0 |  |
| wis | int(3) | NO |  | 0 |  |
| intel | int(3) | NO |  | 0 |  |
| mr | int(3) | NO |  | 0 |  |
| exp | int(10) unsigned | NO |  | 0 |  |
| alignment | int(10) | NO |  | 0 |  |
| big | enum('true','false') | NO |  | false |  |
| weakAttr | enum('NONE','EARTH','FIRE','WATER','WIND') | NO |  | NONE |  |
| ranged | int(3) unsigned | NO |  | 0 |  |
| is_taming | enum('true','false') | NO |  | false |  |
| passispeed | int(6) unsigned | NO |  | 0 |  |
| atkspeed | int(6) unsigned | NO |  | 0 |  |
| atk_magic_speed | int(6) unsigned | NO |  | 0 |  |
| sub_magic_speed | int(6) unsigned | NO |  | 0 |  |
| undead | enum('NONE','UNDEAD','DEMON','UNDEAD_BOSS','DRANIUM') | NO |  | NONE |  |
| poison_atk | enum('NONE','DAMAGE','PARALYSIS','SILENCE') | NO |  | NONE |  |
| is_agro | enum('false','true') | NO |  | false |  |
| is_agro_poly | enum('false','true') | NO |  | false |  |
| is_agro_invis | enum('false','true') | NO |  | false |  |
| family | varchar(20) | NO |  |  |  |
| agrofamily | int(1) unsigned | NO |  | 0 |  |
| agrogfxid1 | int(10) | NO |  | -1 |  |
| agrogfxid2 | int(10) | NO |  | -1 |  |
| is_picupitem | enum('false','true') | NO |  | false |  |
| digestitem | int(1) unsigned | NO |  | 0 |  |
| is_bravespeed | enum('false','true') | NO |  | false |  |
| hprinterval | int(6) unsigned | NO |  | 0 |  |
| hpr | int(5) unsigned | NO |  | 0 |  |
| mprinterval | int(6) unsigned | NO |  | 0 |  |
| mpr | int(5) unsigned | NO |  | 0 |  |
| is_teleport | enum('true','false') | NO |  | false |  |
| randomlevel | int(3) unsigned | NO |  | 0 |  |
| randomhp | int(5) unsigned | NO |  | 0 |  |
| randommp | int(5) unsigned | NO |  | 0 |  |
| randomac | int(3) | NO |  | 0 |  |
| randomexp | int(5) unsigned | NO |  | 0 |  |
| randomAlign | int(5) | NO |  | 0 |  |
| damage_reduction | int(5) unsigned | NO |  | 0 |  |
| is_hard | enum('true','false') | NO |  | false |  |
| is_bossmonster | enum('true','false') | NO |  | false |  |
| can_turnundead | enum('true','false') | NO |  | false |  |
| bowSpritetId | int(5) unsigned | NO |  | 0 |  |
| karma | int(10) | NO |  | 0 |  |
| transform_id | int(10) | NO |  | -1 |  |
| transform_gfxid | int(10) | NO |  | 0 |  |
| light_size | tinyint(3) unsigned | NO |  | 0 |  |
| is_amount_fixed | enum('false','true') | NO |  | false |  |
| is_change_head | enum('false','true') | NO |  | false |  |
| spawnlist_door | int(10) | NO |  | 0 |  |
| count_map | int(10) | NO |  | 0 |  |
| cant_resurrect | enum('false','true') | NO |  | false |  |
| isHide | enum('true','false') | NO |  | false |  |


## Table: `npc_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npcId | int(10) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| recall | enum('false','true') | NO |  | false |  |
| spawnActionId | int(2) | NO |  | 0 |  |
| reward | enum('false','true') | NO |  | false |  |
| rewardRange | enum('screen','map','self') | NO |  | screen |  |
| rewardItemId | int(10) | NO |  | 0 |  |
| rewardItemCount | int(10) | NO |  | 0 |  |
| rewardEinhasad | int(4) | NO |  | 0 |  |
| rewardNcoin | int(10) | NO |  | 0 |  |
| rewardGfx | int(5) | NO |  | 0 |  |
| msgRange | enum('screen','map','self') | NO |  | screen |  |
| spawnMsg | text | YES |  |  |  |
| dieMsg | text | YES |  |  |  |
| dieMsgPcList | enum('false','true') | NO |  | false |  |
| autoLoot | enum('false','true') | NO |  | false |  |
| transformChance | int(3) | NO |  | 0 |  |
| transformId | int(9) | NO |  | 0 |  |
| transformGfxId | int(6) | NO |  | 0 |  |
| scriptType | enum('text','number','none') | NO |  | none |  |
| scriptContent | text | YES |  |  |  |


## Table: `npc_night`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npcId | int(9) | NO | PRI | 0 |  |
| name | varchar(50) | YES |  |  |  |
| targetMapId | int(5) | NO | PRI | 0 |  |
| targetId | int(9) | NO |  | 0 |  |


## Table: `npcaction`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npcid | int(10) unsigned | NO | PRI | 0 |  |
| normal_action | varchar(45) | NO |  |  |  |
| caotic_action | varchar(45) | NO |  |  |  |
| teleport_url | varchar(45) | NO |  |  |  |
| teleport_urla | varchar(45) | NO |  |  |  |


## Table: `npcaction_teleport`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npcId | int(10) | NO | PRI | 0 |  |
| note | varchar(50) | YES |  |  |  |
| actionName | varchar(50) | NO | PRI |  |  |
| needLevel | int(3) | NO |  | 0 |  |
| limitLevel | int(3) | NO |  | 0 |  |
| needTimerId | int(3) | NO |  | 0 |  |
| needItem | text | YES |  |  |  |
| needBuff | text | YES |  |  |  |
| needPcroomBuff | enum('true','false') | NO |  | false |  |
| telX | int(5) | NO |  | 0 |  |
| telY | int(5) | NO |  | 0 |  |
| telMapId | int(5) | NO |  | 0 |  |
| telRange | int(3) | NO |  | 0 |  |
| telType | enum('random','inter','normal') | NO |  | normal |  |
| randomMap | text | YES |  |  |  |
| telTownId | int(11) | NO |  | 0 |  |
| failAlignment | enum('caotic','neutral','lawful','none') | NO |  | none |  |
| successActionName | varchar(50) | YES |  |  |  |
| failLevelActionName | varchar(50) | YES |  |  |  |
| failItemActionName | varchar(50) | YES |  |  |  |
| failBuffActionName | varchar(50) | YES |  |  |  |


## Table: `npcchat`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npc_id | int(10) unsigned | NO | PRI | 0 |  |
| chat_timing | tinyint(1) unsigned | NO | PRI | 0 |  |
| note | varchar(45) | NO |  |  |  |
| start_delay_time | int(10) | NO |  | 0 |  |
| chat_id1 | varchar(45) | NO |  |  |  |
| chat_id2 | varchar(45) | NO |  |  |  |
| chat_id3 | varchar(45) | NO |  |  |  |
| chat_id4 | varchar(45) | NO |  |  |  |
| chat_id5 | varchar(45) | NO |  |  |  |
| chat_interval | int(10) unsigned | NO |  | 0 |  |
| is_shout | tinyint(1) unsigned | NO |  | 0 |  |
| is_world_chat | tinyint(1) | NO |  | 0 |  |
| is_repeat | tinyint(1) unsigned | NO |  | 0 |  |
| repeat_interval | int(10) unsigned | NO |  | 0 |  |
| game_time | int(10) | NO |  | 0 |  |
| percent | int(10) unsigned | YES |  | 0 |  |


## Table: `penalty_pass_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI | 0 |  |
| desc | varchar(100) | YES |  |  |  |


## Table: `penalty_protect_item`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| type | enum('have','equip') | YES |  | have |  |
| itemPanalty | enum('false','true') | YES |  | false |  |
| expPanalty | enum('false','true') | YES |  | false |  |
| dropItemId | int(10) | YES |  | 0 |  |
| msgId | int(5) | YES |  |  |  |
| mapIds | text | YES |  |  |  |
| remove | enum('false','true') | YES |  | false |  |


## Table: `playsupport`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| mapid | int(6) | NO | PRI |  |  |
| mapname | varchar(50) | YES |  |  |  |
| whole | tinyint(1) unsigned | NO |  | 0 |  |
| surround | tinyint(1) unsigned | NO |  | 0 |  |
| sub | tinyint(1) unsigned | NO |  | 0 |  |


## Table: `polyitems`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(10) | NO | PRI | 0 |  |
| name | varchar(50) | YES |  |  |  |
| polyId | int(6) | NO |  | 0 |  |
| duration | int(6) | NO |  | 1800 |  |
| type | enum('domination','normal') | NO |  | normal |  |
| delete | enum('false','true') | NO |  | true |  |


## Table: `polymorphs`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI |  | auto_increment |
| name | varchar(255) | YES |  |  |  |
| polyid | int(11) | NO |  |  |  |
| minlevel | int(11) | NO |  |  |  |
| weaponequip | int(11) | YES |  |  |  |
| armorequip | int(11) | YES |  |  |  |
| isSkillUse | int(11) | NO |  |  |  |
| cause | int(11) | YES |  |  |  |
| bonusPVP | enum('true','false') | NO |  | false |  |
| formLongEnable | enum('true','false') | NO |  | false |  |


## Table: `polyweapon`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| polyId | int(5) | NO | PRI | 0 |  |
| weapon | enum('bow','spear','both') | NO |  | both |  |


## Table: `probability_by_spell`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| skill_id | int(10) | NO | PRI |  |  |
| description | varchar(64) | YES |  |  |  |
| desc_kr | varchar(64) | YES |  |  |  |
| skill_type | enum('MAGICHIT','ABILITY','SPIRIT','DRAGONSPELL','FEAR') | NO | PRI | MAGICHIT |  |
| pierce_lv_weight | varchar(16) | YES |  | 0.0 |  |
| resis_lv_weight | varchar(16) | YES |  | 0.0 |  |
| int_weight | varchar(16) | YES |  | 0.0 |  |
| mr_weight | varchar(16) | YES |  | 0.0 |  |
| pierce_weight | varchar(16) | YES |  | 0.0 |  |
| resis_weight | varchar(16) | YES |  | 0.0 |  |
| default_probability | int(10) | YES |  | 5 |  |
| min_probability | int(10) | YES |  | 5 |  |
| max_probability | int(10) | YES |  | 80 |  |
| is_loggin | enum('false','true') | YES |  | false |  |


## Table: `proto_packet`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| code | varchar(6) | NO | PRI |  |  |
| code_val | int(6) | NO |  | 0 |  |
| className | varchar(50) | NO |  |  |  |


## Table: `race_div_record`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(30) | NO | PRI | 0 |  |
| bug_number | int(10) | NO | PRI | 0 |  |
| dividend | int(10) | NO |  | 0 |  |


## Table: `race_record`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| number | int(5) unsigned | NO | PRI | 0 |  |
| win | int(10) unsigned | NO |  | 0 |  |
| lose | int(10) unsigned | NO |  | 0 |  |


## Table: `race_tickets`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) | NO | PRI | 0 |  |
| name | varchar(45) | NO |  |  |  |
| price | int(10) | NO |  |  |  |


## Table: `repair_item_cost`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| itemId | int(11) | NO | PRI | 0 |  |
| name | varchar(45) | YES |  |  |  |
| cost | int(11) | YES |  |  |  |


## Table: `report`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| target | varchar(100) | NO | PRI |  |  |
| reporter | varchar(100) | NO | PRI |  |  |
| count | int(11) | NO |  | 1 |  |
| date | timestamp | NO |  | current_timestamp() | on update current_timestamp() |


## Table: `resolvent`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) | NO | PRI | 0 |  |
| note | varchar(45) | NO |  |  |  |
| crystal_count | int(10) | NO |  | 0 |  |


## Table: `robot_fishing`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| x | int(8) | YES |  |  |  |
| y | int(8) | YES |  |  |  |
| mapid | int(5) | YES |  |  |  |
| heading | int(5) | YES |  |  |  |
| fishingX | int(8) | YES |  |  |  |
| fishingY | int(8) | YES |  |  |  |


## Table: `robot_location`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| uid | int(10) unsigned | NO | PRI |  | auto_increment |
| istown | enum('true','false') | NO |  | false |  |
| x | int(10) | NO |  |  |  |
| y | int(10) | NO |  |  |  |
| map | int(10) | NO |  |  |  |
| etc | text | NO |  |  |  |
| count | int(10) | NO |  | 1 |  |


## Table: `robot_message`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| uid | int(10) unsigned | NO | PRI |  | auto_increment |
| type | enum('pvp','die') | NO |  |  |  |
| ment | text | NO |  |  |  |


## Table: `robot_name`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| uid | int(10) unsigned | NO | PRI |  | auto_increment |
| name | varchar(255) | NO |  |  |  |


## Table: `robot_teleport_list`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| x | int(10) | YES |  |  |  |
| y | int(10) | YES |  |  |  |
| mapid | int(10) | YES |  |  |  |
| heading | int(1) | YES |  |  |  |
| note | varchar(50) | YES |  |  |  |
| isuse | int(1) | YES |  |  |  |


## Table: `server_explain`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| num | int(10) | NO | PRI |  | auto_increment |
| subject | varchar(45) | YES |  |  |  |
| content | varchar(1000) | YES |  |  |  |


## Table: `serverinfo`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | varchar(255) | NO | PRI |  |  |
| adenmake | bigint(30) | YES |  | 0 |  |
| adenconsume | bigint(30) | YES |  | 0 |  |
| adentax | int(10) | YES |  | 0 |  |
| bugdividend | float(10,0) | YES |  | 0 |  |
| accountcount | int(10) | YES |  | 0 |  |
| charcount | int(10) | YES |  | 0 |  |
| pvpcount | int(10) | YES |  | 0 |  |
| penaltycount | int(10) | YES |  | 0 |  |
| clanmaker | int(10) | YES |  | 0 |  |
| maxuser | int(10) | YES |  | 0 |  |


## Table: `shop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npc_id | int(10) unsigned | NO | PRI | 0 |  |
| item_id | int(10) unsigned | NO | PRI | 0 |  |
| order_id | int(10) unsigned | NO | PRI | 0 |  |
| selling_price | int(10) | NO |  | -1 |  |
| pack_count | int(10) unsigned | NO |  | 0 |  |
| purchasing_price | int(10) | NO |  | -1 |  |
| enchant | int(10) | NO |  | 0 |  |
| pledge_rank | enum('NONE(None)','RANK_NORMAL_KING(Monarch)','RANK_NORMAL_PRINCE(Vice-Monarch)','RANK_NORMAL_KNIGHT(Guardian)','RANK_NORMAL_ELITE_KNIGHT(Elite)','RANK_NORMAL_JUNIOR_KNIGHT(Common)','RANK_NORMAL_REGULAR(Training)') | NO |  | NONE(None) |  |
| note | varbinary(50) | YES |  |  |  |


## Table: `shop_aden`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| itemid | int(10) | YES |  |  |  |
| itemname | varchar(22) | YES |  |  |  |
| price | int(10) | YES |  |  |  |
| type | int(10) | YES |  | 0 |  |
| status | int(10) | YES |  | 0 |  |
| html | varchar(22) | YES |  |  |  |
| pack | int(10) | YES |  | 0 |  |
| enchant | int(10) | YES |  | 0 |  |


## Table: `shop_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npcId | int(9) | NO | PRI | 0 |  |
| name | varchar(50) | YES |  |  |  |
| type | enum('clan','ein','ncoin','tam','berry','item') | NO |  | item |  |
| currencyId | int(9) | NO |  | 0 |  |
| currencyDescId | int(6) | NO |  | 0 |  |


## Table: `shop_limit`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| shopId | int(9) | NO | PRI | 0 |  |
| itemId | int(9) | NO | PRI | 0 |  |
| itemName | varchar(50) | YES |  |  |  |
| limitTerm | enum('WEEK','DAY','NONE') | NO |  | DAY |  |
| limitCount | int(9) | NO |  | 0 |  |
| limitType | enum('ACCOUNT','CHARACTER') | NO |  | ACCOUNT |  |


## Table: `shop_npc`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npc_id | int(10) | NO | PRI |  |  |
| id | int(10) | NO | PRI | 1 |  |
| item_id | int(10) | NO |  | 0 |  |
| memo | text | YES |  |  |  |
| count | int(10) | NO |  | 1 |  |
| enchant | int(10) | NO |  | 0 |  |
| selling_price | int(10) | NO |  | -1 |  |
| purchasing_price | int(10) | NO |  | -1 |  |


## Table: `skills`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| skill_id | int(10) | NO | PRI | -1 |  |
| name | varchar(45) | NO |  |  |  |
| desc_kr | varchar(45) | NO |  |  |  |
| desc_en | varchar(100) | NO |  |  |  |
| skill_level | int(10) | NO |  | 0 |  |
| mpConsume | int(10) unsigned | NO |  | 0 |  |
| hpConsume | int(10) unsigned | NO |  | 0 |  |
| itemConsumeId | int(10) unsigned | NO |  | 0 |  |
| itemConsumeCount | int(10) unsigned | NO |  | 0 |  |
| reuseDelay | int(6) unsigned | NO |  | 0 |  |
| delayGroupId | int(2) | NO |  | 0 |  |
| fixDelay | enum('true','false') | NO |  | false |  |
| buffDuration | int(6) unsigned | NO |  | 0 |  |
| buffDuration_txt | varchar(30) | NO |  |  |  |
| target | enum('NONE','ATTACK','BUFF') | NO |  | NONE |  |
| target_to | enum('ME','PC','NPC','ALL','PLEDGE','PARTY','COMPANIION','PLACE') | NO |  | ALL |  |
| target_to_txt | varchar(75) | NO |  |  |  |
| effect_txt | varchar(260) | NO |  |  |  |
| damage_value | int(6) unsigned | NO |  | 0 |  |
| damage_dice | int(6) unsigned | NO |  | 0 |  |
| damage_dice_count | int(6) unsigned | NO |  | 0 |  |
| probability_value | int(6) unsigned | NO |  | 0 |  |
| probability_dice | int(6) unsigned | NO |  | 0 |  |
| attr | enum('NONE','EARTH','FIRE','WATER','WIND','RAY') | NO |  | NONE |  |
| type | enum('NONE','PROB','CHANGE','CURSE','DEATH','HEAL','RESTORE','ATTACK','OTHER') | NO |  | NONE |  |
| alignment | int(10) | NO |  | 0 |  |
| ranged | int(3) | NO |  | 0 |  |
| area | int(3) | NO |  | 0 |  |
| is_through | enum('true','false') | NO |  | false |  |
| action_id | int(3) unsigned | NO |  | 0 |  |
| action_id2 | int(3) unsigned | NO |  | 0 |  |
| action_id3 | int(3) unsigned | NO |  | 0 |  |
| castgfx | int(10) unsigned | NO |  | 0 |  |
| castgfx2 | int(10) unsigned | NO |  | 0 |  |
| castgfx3 | int(10) unsigned | NO |  | 0 |  |
| sysmsgID_happen | int(10) unsigned | NO |  | 0 |  |
| sysmsgID_stop | int(10) unsigned | NO |  | 0 |  |
| sysmsgID_fail | int(10) unsigned | NO |  | 0 |  |
| classType | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','normal','none') | NO |  | none |  |
| grade | enum('ONLY','MYTH','LEGEND','RARE','NORMAL') | NO |  | NORMAL |  |


## Table: `skills_handler`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| skillId | int(9) | NO | PRI | -1 |  |
| name | varchar(100) | YES |  |  |  |
| className | varchar(100) | NO |  |  |  |


## Table: `skills_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| skillId | int(10) | NO | PRI | -1 |  |
| skillname | varchar(20) | NO |  |  |  |
| desc_en | varchar(100) | NO |  |  |  |
| desc_kr | varchar(100) | NO |  |  |  |
| useSkillId | int(10) | NO |  | 0 |  |
| durationShowType | enum('NONE(0)','PERCENT(1)','MINUTE(2)','PERCENT_ORC_SERVER(3)','EINHASAD_COOLTIME_MINUTE(4)','LEGACY_TIME(5)','VARIABLE_VALUE(6)','DAY_HOUR_MIN(7)','AUTO_DAY_HOUR_MIN_SEC(8)','NSERVICE_TOPPING(9)','UNLIMIT(10)','CUSTOM(11)','COUNT(12)','RATE(13)','EINHASAD_FAVOR(14)','HIDDEN(15)') | NO |  | AUTO_DAY_HOUR_MIN_SEC(8) |  |
| icon | int(5) | NO |  | 0 |  |
| onIconId | int(5) | NO |  | 0 |  |
| offIconId | int(5) | NO |  | 0 |  |
| simplePck | enum('false','true') | NO |  | false |  |
| iconPriority | int(3) | NO |  | 3 |  |
| tooltipStrId | int(5) | NO |  | 0 |  |
| newStrId | int(5) | NO |  | 0 |  |
| endStrId | int(5) | NO |  | 0 |  |
| isGood | enum('true','false') | NO |  | true |  |
| overlapBuffIcon | int(3) | NO |  | 0 |  |
| mainTooltipStrId | int(3) | NO |  | 0 |  |
| buffIconPriority | int(3) | NO |  | 0 |  |
| buffGroupId | int(3) | NO |  | 0 |  |
| buffGroupPriority | int(3) | NO |  | 0 |  |
| expireDuration | int(6) | NO |  | 0 |  |
| boostType | enum('BOOST_NONE(0)','HP_UI_CHANGE(1)') | NO |  | BOOST_NONE(0) |  |
| isPassiveSpell | enum('true','false') | NO |  | false |  |


## Table: `skills_passive`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| passive_id | int(3) | NO | PRI | -1 |  |
| name | varchar(100) | YES |  |  |  |
| desc_kr | varchar(100) | NO |  |  |  |
| desc_en | varchar(100) | NO |  |  |  |
| duration | int(6) | NO |  | 0 |  |
| on_icon_id | int(6) | NO |  | 0 |  |
| tooltip_str_id | int(6) | NO |  | 0 |  |
| is_good | enum('false','true') | NO |  | true |  |
| class_type | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','normal','none') | NO |  | none |  |
| back_active_skill_id | int(10) | NO |  | -1 |  |
| back_passive_id | int(3) | NO |  | -1 |  |
| grade | enum('ONLY','MYTH','LEGEND','RARE','NORMAL') | NO |  | NORMAL |  |


## Table: `spawnlist`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| name | varchar(45) | NO |  |  |  |
| count | int(10) unsigned | NO |  | 0 |  |
| npc_templateid | int(10) unsigned | NO |  | 0 |  |
| group_id | int(6) unsigned | NO |  | 0 |  |
| locx | int(6) unsigned | NO |  | 0 |  |
| locy | int(6) unsigned | NO |  | 0 |  |
| randomx | int(3) unsigned | NO |  | 0 |  |
| randomy | int(3) unsigned | NO |  | 0 |  |
| locx1 | int(6) unsigned | NO |  | 0 |  |
| locy1 | int(6) unsigned | NO |  | 0 |  |
| locx2 | int(6) unsigned | NO |  | 0 |  |
| locy2 | int(6) unsigned | NO |  | 0 |  |
| heading | int(2) unsigned | NO |  | 0 |  |
| min_respawn_delay | int(10) unsigned | NO |  | 0 |  |
| max_respawn_delay | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |
| respawn_screen | tinyint(1) unsigned | NO |  | 0 |  |
| movement_distance | int(3) unsigned | NO |  | 0 |  |
| rest | tinyint(1) unsigned | NO |  | 0 |  |
| near_spawn | tinyint(1) unsigned | NO |  | 0 |  |


## Table: `spawnlist_arrow`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npc_id | int(10) unsigned | NO | PRI |  | auto_increment |
| locx | int(10) unsigned | NO | PRI | 0 |  |
| locy | int(10) | NO | PRI | 0 |  |
| tarx | int(10) unsigned | NO |  | 0 |  |
| tary | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO | PRI | 0 |  |
| start_delay | int(10) | NO |  | 0 |  |


## Table: `spawnlist_boss`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| spawn_group_id | int(11) | NO |  | 0 |  |
| name | varchar(45) | YES |  |  |  |
| desc_kr | varchar(45) | YES |  |  |  |
| npcid | int(10) | NO |  | 0 |  |
| spawnDay | varchar(100) | YES |  |  |  |
| spawnTime | text | YES |  |  |  |
| spawnX | int(5) | NO |  | 0 |  |
| spawnY | int(5) | NO |  | 0 |  |
| spawnMapId | int(5) | NO |  | 0 |  |
| rndMinut | int(6) | NO |  | 0 |  |
| rndRange | int(10) | NO |  | 0 |  |
| heading | int(10) unsigned | NO |  | 0 |  |
| groupid | int(10) | NO |  | 0 |  |
| movementDistance | int(3) | NO |  | 0 |  |
| isYN | enum('true','false') | NO |  | false |  |
| mentType | enum('NONE','WORLD','MAP','SCREEN') | NO |  |  |  |
| ment | varchar(100) | YES |  |  |  |
| percent | int(10) unsigned | NO |  | 0 |  |
| aliveSecond | int(10) | NO |  | 0 |  |
| spawnType | enum('NORMAL','DOMINATION_TOWER','DRAGON_RAID','POISON_FEILD') | NO |  | NORMAL |  |


## Table: `spawnlist_boss_sign`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  | auto_increment |
| name | varchar(100) | YES |  |  |  |
| desc_kr | varchar(100) | NO |  |  |  |
| bossId | int(10) | NO |  | 0 |  |
| npcId | int(10) | NO |  | 0 |  |
| locX | int(6) | NO |  | 0 |  |
| locY | int(6) | NO |  | 0 |  |
| locMapId | int(6) | NO |  | 0 |  |
| rndRange | int(3) | NO |  | 0 |  |
| aliveSecond | int(6) | NO |  | 0 |  |


## Table: `spawnlist_clandungeon`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(2) unsigned | NO | PRI |  | auto_increment |
| type | int(1) unsigned | NO |  | 0 |  |
| stage | int(2) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| npc_templateid | int(10) unsigned | NO |  | 0 |  |
| count | int(2) unsigned | NO |  | 0 |  |
| boss | enum('true','false') | YES |  | false |  |


## Table: `spawnlist_door`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(11) | NO | PRI | 0 |  |
| name | varchar(60) | NO |  |  |  |
| gfxid | int(11) | NO |  | 0 |  |
| locx | int(11) | NO |  | 0 |  |
| locy | int(11) | NO |  | 0 |  |
| mapid | int(11) | NO |  | 0 |  |
| direction | int(11) | NO |  | 0 |  |
| left_edge_location | int(11) | NO |  | 0 |  |
| right_edge_location | int(11) | NO |  | 0 |  |
| hp | int(11) | NO |  | 0 |  |
| keeper | int(11) | NO |  | 0 |  |


## Table: `spawnlist_furniture`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_obj_id | int(10) unsigned | NO | PRI | 0 |  |
| npcid | int(10) unsigned | NO |  | 0 |  |
| locx | int(10) | NO |  | 0 |  |
| locy | int(10) | NO |  | 0 |  |
| mapid | int(10) | NO |  | 0 |  |


## Table: `spawnlist_indun`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) unsigned | NO | PRI |  | auto_increment |
| type | int(3) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| npc_id | int(10) unsigned | NO |  | 0 |  |
| locx | int(6) unsigned | NO |  | 0 |  |
| locy | int(6) unsigned | NO |  | 0 |  |
| heading | int(2) | NO |  | 0 |  |
| randomRange | int(11) | NO |  | 5 |  |
| mapId | int(11) | NO |  |  |  |
| location | varchar(150) | NO |  |  |  |


## Table: `spawnlist_light`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| npcid | int(10) unsigned | NO |  | 0 |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |


## Table: `spawnlist_npc`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| name | varchar(50) | NO |  |  |  |
| count | int(10) unsigned | NO |  | 0 |  |
| npc_templateid | int(10) unsigned | NO |  | 0 |  |
| locx | int(6) unsigned | NO |  | 0 |  |
| locy | int(6) unsigned | NO |  | 0 |  |
| randomx | int(3) unsigned | NO |  | 0 |  |
| randomy | int(3) unsigned | NO |  | 0 |  |
| heading | int(2) unsigned | NO |  | 0 |  |
| respawn_delay | int(10) unsigned | NO |  | 0 |  |
| mapid | int(6) unsigned | NO |  | 0 |  |
| movement_distance | int(3) unsigned | NO |  | 0 |  |


## Table: `spawnlist_npc_cash_shop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| npc_id | int(10) unsigned | NO |  | 0 |  |
| name | varchar(40) | NO |  |  |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |
| heading | int(10) | NO |  | 0 |  |
| title | varchar(35) | NO |  |  |  |
| shop_chat | text | NO |  |  |  |


## Table: `spawnlist_npc_shop`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| npc_id | int(10) unsigned | NO |  | 0 |  |
| name | varchar(40) | NO |  |  |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| mapid | int(10) unsigned | NO |  | 0 |  |
| heading | int(10) | NO |  | 0 |  |
| title | varchar(35) | NO |  |  |  |
| shop_chat | text | NO |  |  |  |


## Table: `spawnlist_other`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(5) unsigned | NO | PRI |  | auto_increment |
| type | int(5) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| npc_id | int(10) unsigned | NO |  | 0 |  |
| locx | int(6) unsigned | NO |  | 0 |  |
| locy | int(6) unsigned | NO |  | 0 |  |
| heading | int(2) | NO |  | 0 |  |
| randomRange | int(3) | NO |  | 0 |  |
| timeMillisToDelete | int(6) | NO |  | 0 |  |
| gfxId | int(6) | NO |  | 0 |  |
| actionStatus | int(3) | NO |  | 4 |  |
| leftEdge | int(6) | NO |  | 0 |  |
| rightEdge | int(6) | NO |  | 0 |  |
| direction | int(3) | NO |  | 0 |  |
| targetPlayer | tinyint(1) | NO |  | 0 |  |
| paralysisTime | int(3) | NO |  | 0 |  |
| count | int(3) | NO |  | 1 |  |
| mapId | int(10) | NO |  |  |  |
| location | varchar(150) | NO |  |  |  |


## Table: `spawnlist_ruun`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) unsigned | NO | PRI |  | auto_increment |
| stage | int(3) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| npcId | int(10) unsigned | NO |  | 0 |  |
| locX | int(6) unsigned | NO |  | 0 |  |
| locY | int(6) unsigned | NO |  | 0 |  |
| mapId | int(6) unsigned | NO |  | 0 |  |
| range | int(3) unsigned | NO |  | 0 |  |
| count | int(3) unsigned | NO |  | 0 |  |


## Table: `spawnlist_trap`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(8) | NO | PRI |  |  |
| name | varchar(64) | YES |  |  |  |
| trapId | int(8) | NO |  |  |  |
| mapId | int(4) | NO |  |  |  |
| locX | int(4) | NO |  |  |  |
| locY | int(4) | NO |  |  |  |
| locRndX | int(4) | NO |  | 0 |  |
| locRndY | int(4) | NO |  | 0 |  |
| count | int(4) | NO |  | 1 |  |
| span | int(4) | NO |  |  |  |


## Table: `spawnlist_ub`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| ub_id | int(10) unsigned | NO |  | 0 |  |
| pattern | int(10) unsigned | NO |  | 0 |  |
| group_id | int(10) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| npc_templateid | int(10) unsigned | NO |  | 0 |  |
| count | int(10) unsigned | NO |  | 0 |  |
| spawn_delay | int(10) unsigned | NO |  | 0 |  |
| seal_count | int(10) unsigned | NO |  | 0 |  |
| isBoss | enum('false','true') | NO |  | false |  |
| isGateKeeper | enum('false','true') | NO |  | false |  |


## Table: `spawnlist_unicorntemple`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) unsigned | NO | PRI |  | auto_increment |
| type | int(10) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| npc_id | int(10) unsigned | NO |  | 0 |  |
| locx | int(10) unsigned | NO |  | 0 |  |
| locy | int(10) unsigned | NO |  | 0 |  |
| heading | int(2) | NO |  | 0 |  |
| count | int(2) | NO |  | 1 |  |
| mapId | int(11) | NO |  |  |  |
| locationname | varchar(100) | NO |  |  |  |


## Table: `spawnlist_worldwar`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) unsigned | NO | PRI |  | auto_increment |
| type | int(3) unsigned | NO |  | 0 |  |
| name | varchar(45) | NO |  |  |  |
| npc_id | int(10) unsigned | NO |  | 0 |  |
| locx | int(6) unsigned | NO |  | 0 |  |
| locy | int(6) unsigned | NO |  | 0 |  |
| mapid | int(6) unsigned | NO |  | 0 |  |
| heading | int(2) unsigned | NO |  | 0 |  |


## Table: `spell_melt`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| skillId | int(5) | NO | PRI | -1 |  |
| skillName | varchar(50) | YES |  |  |  |
| passiveId | int(3) | NO | PRI | 0 |  |
| classType | enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') | NO |  | crown |  |
| skillItemId | int(9) | NO |  | 0 |  |
| meltItemId | int(9) | NO |  | 0 |  |


## Table: `spr_action`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| spr_id | int(10) | NO | PRI |  |  |
| act_id | int(10) | NO | PRI |  |  |
| act_name | varchar(128) | YES |  |  |  |
| framecount | int(10) | YES |  |  |  |
| framerate | int(10) | YES |  |  |  |
| numOfFrame | int(10) | YES |  |  |  |


## Table: `spr_info`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| spr_id | int(10) | NO | PRI |  |  |
| spr_name | varchar(200) | YES |  |  |  |
| description | varchar(200) | YES |  |  |  |
| shadow | int(6) | NO |  | 0 |  |
| type | int(6) | NO |  | 0 |  |
| attr | int(3) | NO |  | 0 |  |
| width | int(6) | NO |  | 0 |  |
| height | int(6) | NO |  | 0 |  |
| flying_type | int(3) | NO |  | 0 |  |
| action_count | int(10) | NO |  | 0 |  |


## Table: `tb_bookquest_compensate`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| difficulty | int(3) | YES |  | 1 |  |
| type | varchar(20) | NO |  |  |  |
| num1 | int(10) | YES |  |  |  |
| num2 | int(10) | YES |  |  |  |
| id1 | int(10) | YES |  |  |  |
| id2 | int(10) | YES |  |  |  |


## Table: `tb_lfccompensate`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| ID | int(10) | NO | PRI |  | auto_increment |
| LFCID | int(2) | YES |  | 0 |  |
| PARTITION | int(10) | YES |  | 0 |  |
| TYPE | varchar(20) | YES |  |  |  |
| IDENTITY | int(10) | YES |  | 0 |  |
| QUANTITY | int(50) | YES |  | 0 |  |
| LEVEL | int(10) | YES |  | 0 |  |


## Table: `tb_lfctypes`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| ID | int(2) | NO | PRI |  | auto_increment |
| TYPE | int(2) | YES |  | 0 |  |
| NAME | varchar(50) | YES |  |  |  |
| DESC_KR | varchar(50) | NO |  |  |  |
| USE | int(2) | YES |  | 0 |  |
| BUFF_SPAWN_TIME | int(10) | YES |  | 0 |  |
| POSSIBLE_LEVEL | int(10) | YES |  | 0 |  |
| MIN_PARTY | int(10) | YES |  | 0 |  |
| MAX_PARTY | int(10) | YES |  | 0 |  |
| NEED_ITEMID | int(10) | YES |  | 0 |  |
| NEED_ITEMCOUNT | int(10) | YES |  | 0 |  |
| PLAY_INST | varchar(50) | YES |  |  |  |
| MAPRT_LEFT | int(10) | YES |  | 0 |  |
| MAPRT_TOP | int(10) | YES |  | 0 |  |
| MAPRT_RIGHT | int(10) | YES |  | 0 |  |
| MAPRT_BOTTOM | int(10) | YES |  | 0 |  |
| MAPID | int(10) | YES |  | 0 |  |
| STARTPOS_REDX | int(10) | YES |  | 0 |  |
| STARTPOS_REDY | int(10) | YES |  | 0 |  |
| STARTPOS_BLUEX | int(10) | YES |  | 0 |  |
| STARTPOS_BLUEY | int(10) | YES |  | 0 |  |
| PLAYTIME | int(10) | YES |  | 0 |  |
| READYTIME | int(10) | YES |  | 0 |  |
| RAND_WINNER_RATIO | int(10) | YES |  |  |  |


## Table: `tb_monster_book`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npc_id | int(10) | YES |  |  |  |
| npc_name | varchar(50) | YES |  |  |  |
| book_id | int(10) | NO | PRI | 0 |  |
| book_step_first | int(10) | YES |  |  |  |
| book_step_second | int(10) | YES |  |  |  |
| book_step_third | int(10) | YES |  |  |  |
| book_clear_num | int(3) | YES |  |  |  |
| week_difficulty | int(3) | YES |  |  |  |
| week_success_count | int(10) | YES |  |  |  |
| tel_x | int(3) | YES |  |  |  |
| tel_y | int(3) | YES |  |  |  |
| tel_mapId | int(3) | YES |  |  |  |


## Table: `tb_monster_book_clearinfo`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| book_id | int(10) | NO | PRI |  |  |
| book_clear_num2 | int(10) | NO |  |  |  |


## Table: `tb_user_monster_book`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_id | int(10) | NO | PRI |  |  |
| book_id | int(10) | NO | PRI |  |  |
| difficulty | int(3) | YES |  | 1 |  |
| step | int(10) | YES |  | 0 |  |
| completed | int(3) | YES |  | 0 |  |


## Table: `tb_user_week_quest`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| char_id | int(10) | NO | PRI |  |  |
| bookId | int(10) | YES |  |  |  |
| difficulty | int(3) | NO | PRI |  |  |
| section | int(3) | NO | PRI | 0 |  |
| step | int(10) | YES |  | 0 |  |
| stamp | datetime | YES |  |  |  |
| completed | tinyint(1) | YES |  |  |  |


## Table: `tb_weekquest_compensate`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| button_no | int(3) | NO | PRI |  |  |
| ingredient_itemId | int(10) | YES |  | 0 |  |
| compen_exp | int(10) | YES |  | 0 |  |
| compen_exp_level | int(10) | YES |  | 0 |  |
| compen_itemId | int(10) | YES |  | 0 |  |
| compen_itemCount | int(10) | YES |  | 0 |  |
| compen_itemLevel | int(3) | YES |  |  |  |


## Table: `tb_weekquest_matrix`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| difficulty | int(10) | NO | PRI |  |  |
| col1 | int(10) | YES |  |  |  |
| col2 | int(10) | YES |  |  |  |
| col3 | int(10) | YES |  |  |  |
| stamp | datetime | YES |  |  |  |


## Table: `tb_weekquest_updateinfo`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(3) | NO | PRI |  |  |
| lastTime | datetime | YES |  |  |  |


## Table: `tj_coupon`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| objId | int(10) | NO | PRI | 0 |  |
| charId | int(10) | NO |  | 0 |  |
| itemId | int(10) | NO |  | 0 |  |
| count | int(10) | NO |  | 0 |  |
| enchantLevel | int(9) | NO |  | 0 |  |
| attrLevel | int(3) | NO |  | 0 |  |
| bless | int(3) | NO |  | 1 |  |
| lostTime | datetime | NO |  |  |  |


## Table: `town`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| town_id | int(10) unsigned | NO | PRI | 0 |  |
| name | varchar(45) | NO |  |  |  |
| leader_id | int(10) unsigned | NO |  | 0 |  |
| leader_name | varchar(45) | YES |  |  |  |
| tax_rate | int(10) unsigned | NO |  | 0 |  |
| tax_rate_reserved | int(10) unsigned | NO |  | 0 |  |
| sales_money | int(10) unsigned | NO |  | 0 |  |
| sales_money_yesterday | int(10) unsigned | NO |  | 0 |  |
| town_tax | int(10) unsigned | NO |  | 0 |  |
| town_fix_tax | int(10) unsigned | NO |  | 0 |  |


## Table: `town_npc`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| npc_id | int(11) | NO | PRI | 0 |  |
| description | varchar(100) | YES |  |  |  |
| town | enum('TALK_ISLAND','SILVER_KNIGHT','GLUDIO','ORCISH_FOREST','WINDAWOOD','KENT','GIRAN','HEINE','WERLDAN','OREN','ELVEN_FOREST','ADEN','SILENT_CAVERN','BEHEMOTH','SILVERIA','OUM_DUNGEON','RESISTANCE','PIRATE_ISLAND','RECLUSE_VILLAGE','HIDDEN_VALLEY','CLAUDIA','REDSOLDER','SKYGARDEN','RUUN') | NO |  | TALK_ISLAND |  |


## Table: `trap`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(8) | NO | PRI |  |  |
| note | varchar(64) | YES |  |  |  |
| type | varchar(64) | NO |  |  |  |
| gfxId | int(4) | NO |  |  |  |
| isDetectionable | tinyint(1) | NO |  |  |  |
| base | int(4) | NO |  |  |  |
| dice | int(4) | NO |  |  |  |
| diceCount | int(4) | NO |  |  |  |
| poisonType | char(1) | NO |  | n |  |
| poisonDelay | int(4) | NO |  | 0 |  |
| poisonTime | int(4) | NO |  | 0 |  |
| poisonDamage | int(4) | NO |  | 0 |  |
| monsterNpcId | int(4) | NO |  | 0 |  |
| monsterCount | int(4) | NO |  | 0 |  |
| teleportX | int(4) | NO |  | 0 |  |
| teleportY | int(4) | NO |  | 0 |  |
| teleportMapId | int(4) | NO |  | 0 |  |
| skillId | int(4) | NO |  | -1 |  |
| skillTimeSeconds | int(4) | NO |  | 0 |  |


## Table: `ub_managers`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| ub_id | int(10) unsigned | NO |  | 0 |  |
| ub_manager_npc_id | int(10) unsigned | NO |  | 0 |  |


## Table: `ub_rank`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| ub_id | int(10) | NO | PRI | 0 |  |
| char_name | varchar(45) | NO | PRI |  |  |
| score | int(11) | NO |  |  |  |


## Table: `ub_settings`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| ub_id | int(10) unsigned | NO | PRI | 0 |  |
| ub_name | varchar(45) | NO |  |  |  |
| ub_mapid | int(10) unsigned | NO |  | 0 |  |
| ub_area_x1 | int(10) unsigned | NO |  | 0 |  |
| ub_area_y1 | int(10) unsigned | NO |  | 0 |  |
| ub_area_x2 | int(10) unsigned | NO |  | 0 |  |
| ub_area_y2 | int(10) unsigned | NO |  | 0 |  |
| min_lvl | int(10) unsigned | NO |  | 0 |  |
| max_lvl | int(10) unsigned | NO |  | 0 |  |
| max_player | int(10) unsigned | NO |  | 0 |  |
| enter_royal | tinyint(3) unsigned | NO |  | 0 |  |
| enter_knight | tinyint(3) unsigned | NO |  | 0 |  |
| enter_mage | tinyint(3) unsigned | NO |  | 0 |  |
| enter_elf | tinyint(3) unsigned | NO |  | 0 |  |
| enter_darkelf | tinyint(3) unsigned | NO |  | 0 |  |
| enter_dragonknight | tinyint(3) unsigned | NO |  | 0 |  |
| enter_illusionist | tinyint(3) unsigned | NO |  | 0 |  |
| enter_Warrior | tinyint(3) unsigned | NO |  | 0 |  |
| enter_Fencer | tinyint(3) unsigned | NO |  | 0 |  |
| enter_Lancer | tinyint(3) unsigned | NO |  | 0 |  |
| enter_male | tinyint(3) unsigned | NO |  | 0 |  |
| enter_female | tinyint(3) unsigned | NO |  | 0 |  |
| use_pot | tinyint(3) unsigned | NO |  | 0 |  |
| hpr_bonus | int(10) | NO |  | 0 |  |
| mpr_bonus | int(10) | NO |  | 0 |  |


## Table: `ub_times`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| ub_id | int(10) unsigned | NO |  | 0 |  |
| ub_time | int(10) unsigned | NO |  | 0 |  |


## Table: `uml_conversion`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| oldname | varchar(45) | NO | PRI |  |  |
| newname | varchar(45) | NO |  |  |  |


## Table: `util_fighter`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| Num | int(10) unsigned | NO | PRI |  | auto_increment |
| WinCount | int(10) unsigned | NO |  | 0 |  |
| LoseCount | int(10) unsigned | NO |  | 0 |  |


## Table: `util_racer`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| Num | int(10) unsigned | NO | PRI |  | auto_increment |
| WinCount | int(10) | NO |  | 0 |  |
| LoseCount | int(10) | NO |  | 0 |  |


## Table: `war_time`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| castleId | int(2) | NO | PRI |  |  |
| castleName | varchar(255) | YES |  |  |  |
| day | enum('SUN','MON','TUE','WED','THU','FRI','SAT') | NO | PRI | SUN |  |
| hour | enum('23','22','21','20','19','18','17','16','15','14','13','12','11','10','9','8','7','6','5','4','3','2','1','0') | NO |  | 0 |  |
| minute | enum('50','40','30','20','10','0') | NO |  | 0 |  |


## Table: `weapon`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) unsigned | NO | PRI |  | auto_increment |
| item_name_id | int(10) unsigned | NO |  | 0 |  |
| desc_kr | varchar(45) | NO |  |  |  |
| desc_en | varchar(100) | NO |  |  |  |
| desc_powerbook | varchar(100) | NO |  |  |  |
| note | text | NO |  |  |  |
| desc_id | varchar(45) | NO |  |  |  |
| itemGrade | enum('ONLY','MYTH','LEGEND','HERO','RARE','ADVANC','NORMAL') | NO |  | NORMAL |  |
| type | enum('SWORD','DAGGER','TOHAND_SWORD','BOW','SPEAR','BLUNT','STAFF','STING','ARROW','GAUNTLET','CLAW','EDORYU','SINGLE_BOW','SINGLE_SPEAR','TOHAND_BLUNT','TOHAND_STAFF','KEYRINGK','CHAINSWORD') | NO |  | SWORD |  |
| material | enum('NONE(-)','LIQUID(액체)','WAX(밀랍)','VEGGY(식물성)','FLESH(동물성)','PAPER(종이)','CLOTH(천)','LEATHER(가죽)','WOOD(나무)','BONE(뼈)','DRAGON_HIDE(용비늘)','IRON(철)','METAL(금속)','COPPER(구리)','SILVER(은)','GOLD(금)','PLATINUM(백금)','MITHRIL(미스릴)','PLASTIC(블랙미스릴)','GLASS(유리)','GEMSTONE(보석)','MINERAL(광석)','ORIHARUKON(오리하루콘)','DRANIUM(드라니움)') | NO |  | NONE(-) |  |
| weight | int(10) unsigned | NO |  | 0 |  |
| iconId | int(10) unsigned | NO |  | 0 |  |
| spriteId | int(10) unsigned | NO |  | 0 |  |
| dmg_small | int(6) unsigned | NO |  | 0 |  |
| dmg_large | int(6) unsigned | NO |  | 0 |  |
| safenchant | int(3) | NO |  | 0 |  |
| use_royal | int(2) unsigned | NO |  | 0 |  |
| use_knight | int(2) unsigned | NO |  | 0 |  |
| use_mage | int(2) unsigned | NO |  | 0 |  |
| use_elf | int(2) unsigned | NO |  | 0 |  |
| use_darkelf | int(2) unsigned | NO |  | 0 |  |
| use_dragonknight | int(2) unsigned | NO |  | 0 |  |
| use_illusionist | int(2) unsigned | NO |  | 0 |  |
| use_warrior | int(2) unsigned | NO |  | 0 |  |
| use_fencer | int(2) unsigned | NO |  | 0 |  |
| use_lancer | int(2) unsigned | NO |  | 0 |  |
| hitmodifier | int(6) | NO |  | 0 |  |
| dmgmodifier | int(6) | NO |  | 0 |  |
| add_str | int(3) | NO |  | 0 |  |
| add_con | int(3) | NO |  | 0 |  |
| add_dex | int(3) | NO |  | 0 |  |
| add_int | int(3) | NO |  | 0 |  |
| add_wis | int(3) | NO |  | 0 |  |
| add_cha | int(3) | NO |  | 0 |  |
| add_hp | int(3) | NO |  | 0 |  |
| add_mp | int(3) | NO |  | 0 |  |
| add_hpr | int(3) | NO |  | 0 |  |
| add_mpr | int(3) | NO |  | 0 |  |
| add_sp | int(3) | NO |  | 0 |  |
| m_def | int(3) | NO |  | 0 |  |
| haste_item | int(2) unsigned | NO |  | 0 |  |
| double_dmg_chance | int(3) unsigned | NO |  | 0 |  |
| magicdmgmodifier | int(3) | NO |  | 0 |  |
| canbedmg | int(10) unsigned | NO |  | 0 |  |
| min_lvl | int(3) unsigned | NO |  | 0 |  |
| max_lvl | int(3) unsigned | NO |  | 0 |  |
| bless | int(2) unsigned | NO |  | 1 |  |
| trade | int(2) unsigned | NO |  | 0 |  |
| retrieve | int(2) unsigned | NO |  | 0 |  |
| specialretrieve | int(2) unsigned | NO |  | 0 |  |
| cant_delete | int(2) unsigned | NO |  | 0 |  |
| cant_sell | int(2) unsigned | NO |  | 0 |  |
| max_use_time | int(10) unsigned | NO |  | 0 |  |
| regist_skill | int(2) | NO |  | 0 |  |
| regist_spirit | int(2) | NO |  | 0 |  |
| regist_dragon | int(2) | NO |  | 0 |  |
| regist_fear | int(2) | NO |  | 0 |  |
| regist_all | int(2) | NO |  | 0 |  |
| hitup_skill | int(2) | NO |  | 0 |  |
| hitup_spirit | int(2) | NO |  | 0 |  |
| hitup_dragon | int(2) | NO |  | 0 |  |
| hitup_fear | int(2) | NO |  | 0 |  |
| hitup_all | int(2) | NO |  | 0 |  |
| hitup_magic | int(2) | NO |  | 0 |  |
| damage_reduction | int(2) | NO |  | 0 |  |
| MagicDamageReduction | int(2) | NO |  | 0 |  |
| reductionEgnor | int(2) | NO |  | 0 |  |
| reductionPercent | int(2) | NO |  | 0 |  |
| PVPDamage | int(2) | NO |  | 0 |  |
| PVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamageReductionPercent | int(2) | NO |  | 0 |  |
| PVPMagicDamageReduction | int(2) | NO |  | 0 |  |
| PVPReductionEgnor | int(2) | NO |  | 0 |  |
| PVPMagicDamageReductionEgnor | int(2) | NO |  | 0 |  |
| abnormalStatusDamageReduction | int(2) | NO |  | 0 |  |
| abnormalStatusPVPDamageReduction | int(2) | NO |  | 0 |  |
| PVPDamagePercent | int(2) | NO |  | 0 |  |
| expBonus | int(3) | NO |  | 0 |  |
| rest_exp_reduce_efficiency | int(3) | NO |  | 0 |  |
| shortCritical | int(2) | NO |  | 0 |  |
| longCritical | int(2) | NO |  | 0 |  |
| magicCritical | int(2) | NO |  | 0 |  |
| addDg | int(2) | NO |  | 0 |  |
| addEr | int(2) | NO |  | 0 |  |
| addMe | int(2) | NO |  | 0 |  |
| poisonRegist | enum('false','true') | NO |  | false |  |
| imunEgnor | int(3) | NO |  | 0 |  |
| stunDuration | int(2) | NO |  | 0 |  |
| tripleArrowStun | int(2) | NO |  | 0 |  |
| strangeTimeIncrease | int(4) | NO |  | 0 |  |
| strangeTimeDecrease | int(4) | NO |  | 0 |  |
| potionRegist | int(2) | NO |  | 0 |  |
| potionPercent | int(2) | NO |  | 0 |  |
| potionValue | int(2) | NO |  | 0 |  |
| hprAbsol32Second | int(2) | NO |  | 0 |  |
| mprAbsol64Second | int(2) | NO |  | 0 |  |
| mprAbsol16Second | int(2) | NO |  | 0 |  |
| hpPotionDelayDecrease | int(4) | NO |  | 0 |  |
| hpPotionCriticalProb | int(4) | NO |  | 0 |  |
| increaseArmorSkillProb | int(4) | NO |  | 0 |  |
| attackSpeedDelayRate | int(3) | NO |  | 0 |  |
| moveSpeedDelayRate | int(3) | NO |  | 0 |  |
| Magic_name | varchar(20) | YES |  |  |  |


## Table: `weapon_damege`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) | NO | PRI |  |  |
| name | varchar(40) | NO | PRI |  |  |
| addDamege | int(3) | NO |  | 0 |  |


## Table: `weapon_skill`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| weapon_id | int(11) unsigned | NO | PRI |  | auto_increment |
| note | varchar(255) | YES |  |  |  |
| attackType | enum('PVE','PVP','ALL') | NO | PRI | ALL |  |
| probability | int(3) unsigned | NO |  | 0 |  |
| fix_damage | int(6) unsigned | NO |  | 0 |  |
| random_damage | int(6) unsigned | NO |  | 0 |  |
| area | int(3) | NO |  | 0 |  |
| skill_id | int(11) | NO |  | -1 |  |
| skill_time | int(11) unsigned | NO |  | 0 |  |
| effect_id | int(11) unsigned | NO |  | 0 |  |
| effect_target | int(11) unsigned | NO |  | 0 |  |
| arrow_type | int(3) unsigned | NO |  | 0 |  |
| attr | enum('NONE','EARTH','FIRE','WATER','WIND','RAY') | NO |  | NONE |  |
| enchant_probability | int(3) | NO |  | 0 |  |
| enchant_damage | int(3) | NO |  | 0 |  |
| int_damage | int(3) | NO |  | 0 |  |
| spell_damage | int(3) | NO |  | 0 |  |
| enchant_limit | int(3) | NO |  | 0 |  |
| hpStill | enum('true','false') | NO |  | false |  |
| hpStill_probabliity | int(3) | NO |  | 0 |  |
| hpStillValue | int(3) | NO |  | 0 |  |
| mpStill | enum('true','false') | NO |  | false |  |
| mpStill_probabliity | int(11) | NO |  | 0 |  |
| mpStillValue | int(3) | NO |  | 0 |  |
| stillEffectId | int(11) | NO |  | 0 |  |


## Table: `weapon_skill_model`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| item_id | int(10) | NO | PRI |  |  |
| desc_en | varchar(100) | YES |  |  |  |
| desc_kr | varchar(100) | YES |  |  |  |
| procType | enum('NORMAL(MELEE)','NORMAL(RANGED)','WIDE(FRONT)','WIDE(TARGET)','CHAIN-SPOT','CHAOTIC(NO-EFFECT)','CHAOTIC(EFFECT)','POISON-DAMAGE','DICE-DAGGER','DISEASE','HOLD','HP-DRAIN','HP-DRAIN(MORE-DAMAGE)','MP-DRAIN','MP-DRAIN(MORE-DAMAGE)','MP-DRAIN(DISEASE)','PUMPKIN-CURSE','SILENCE','TURN-UNDEAD','CRITICAL-ATTACK','CRITICAL-ATTACK(DEMON)','LEGENDARY-WEAPON','ARMOR(HP-REGEN)','ARMOR(MP-REGEN)','ARMOR(HP-MP-REGEN)','ARMOR(PROB-REDUCTION)') | YES |  |  |  |
| condition | enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') | YES |  | 0 |  |
| default_prob | int(5) | YES |  | 0 |  |
| enchant_prob | int(5) | YES |  | 0 |  |
| stat_prob | enum('NONE','STR','DEX','CON','WIS','INT','CHA') | YES |  | NONE |  |
| stat_weight | int(5) | YES |  | 0 |  |
| limit_low_val | int(10) | YES |  | 0 |  |
| limit_high_val | int(10) | YES |  | 0 |  |
| min_val | int(10) | YES |  | 0 |  |
| max_val | int(10) | YES |  | 0 |  |
| stat_val | enum('NONE','STR','DEX','CON','WIS','INT','CHA') | YES |  | NONE |  |
| stat_val_weight | int(5) | YES |  | 0 |  |
| enchant_val | enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') | YES |  | 0 |  |
| enchant_val_weight | int(5) | YES |  | 0 |  |
| effect | int(10) | YES |  | 0 |  |
| PVE_Effect | int(10) | YES |  | 0 |  |
| Location | int(10) | YES |  | 0 |  |
| attr_type | enum('NONE','EARTH','FIRE','WATER','WIND') | YES |  | NONE |  |
| is_magic | enum('true','false') | YES |  | true |  |
| is_sp_val | enum('false','true') | YES |  | false |  |
| sp_val_weight | int(10) | YES |  | 0 |  |


## Table: `weapon_skill_spell_def`

### Columns

| Column | Type | Null | Key | Default | Extra |
|--------|------|------|-----|---------|-------|
| id | int(10) | NO | PRI |  |  |
| def_dmg | int(5) | YES |  |  |  |
| def_ratio | int(5) | YES |  |  |  |


