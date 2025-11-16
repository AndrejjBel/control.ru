<?php
// Файл app/Translations.php
declare(strict_types=1);

namespace App;

use Hleb\Static\Settings;
use InvalidArgumentException;

class Translations
{
    public const RU = 'ru';

    public const EN = 'en';

   private static array $sources = [];

    /**
     * Локализация по ключу $key.
     * Поддерживает подмену подстрок по принципу {%name%} из именованного массива $params.
     */
   public static function t(string $key, array $params = [], ?string $lang = null): string
   {
       // Попытка определить язык из первой части url, get-параметра (lang) или сессии (LANG), иначе дефолтный из конфига.
       $lang = $lang ?? Settings::getAutodetectLang();
       $languages = config('main', 'allowed.languages');
       if (!in_array($lang, $languages)) {
           throw new InvalidArgumentException("Language `{$lang}` is not supported or not defined.");
       }
       if (empty(self::$sources[$lang])) {
           self::$sources[$lang] = require_once hl_path("@/config/i18n/$lang.php");
       }
       $result =  self::$sources[$lang][$key] ?? $key;

       if ($params) {
           $replacements = [];
           foreach ($params as $name => $value) {
               $replacements['{%'.$name.'%}'] = (string)$value;
           }
           $result = strtr($result, $replacements);
       }

       return $result;
   }
}
