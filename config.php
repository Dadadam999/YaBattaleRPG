<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("DB_SERVER", "localhost");
define("DB_NAME", "ya11432764");
define("DB_USER", "ya114723264");
define("DB_PASSWORD", "12345");
define("DB_PREFIX", "ya_");

define("DB_TABLE_SESSION_NAME", "sessions");
define("DB_TABLE_PERSON_NAME", "persones");

define("PERSON_NAMES", [
      'hero' => 'Игрок',
      'goblin' => 'Гоблин'
]);

define("PERSON_SETTINGS", [
      'hero_attack' => '20',
      'hero_health' => '100',
      'hero_protect' => '5',
      'hero_increase' => '10',
      'goblin_attack' => '10',
      'goblin_health' => '500',
      'goblin_protect' => '10',
      'goblin_increase' => '5',
]);

define("PROTECT_INCREASE", 1);

define("PERSON_ACTIONS", [
      'Атака' => 'attack',
      'Защита' => 'protect',
      'Лечиться' => 'heal',
      'Увеличить атаку' => 'increase_attack'
]);

define("LINES", [
      'battle_start' => '↯↯↯ На вас напал враг. Победите его.%0d',
      'attack' => '⚔️ @person_name провёл атаку и нанёс @value урона.%0d',
      'heal' => '❤ @person_name вылечился на @value здоровья.%0d',
      'protect' => '✪ @person_name повысил свою защиту на @value защиты.%0d',
      'increase_attack' => '✴ @person_name увеличил свою атаку на @value урона.%0d',
      'battle_win' => '✓ Поздравляю, вы победили.%0d',
      'battle_lose' => '✘ Вы проиграли персонажу @person_name, попробуйте ещё раз!.%0d',
      'miss_step'=> '♺ Персонаж @person_name пропустил ход.%0d'
]);

define("YANDEX_FORM_URL", "https://forms.yandex.ru/u/62cd8c33d0517ac5984516b2/");
define("YANDEX_START_URL", "https://forms.yandex.ru/u/630bc73c139b72a9553573fc/");
define("YANDEX_WIN_URL", "https://forms.yandex.ru/u/630bb34ca3ab06c8cc3c5693/");
define("YANDEX_LOSE_URL", "https://forms.yandex.ru/u/630bba1adbc6d1a080bc90a8/");
define("AUTHOR_URL", "https://forms.yandex.ru/u/630bba1adbc6d1a080bc90a8/")
?>
