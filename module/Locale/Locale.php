<?php

namespace Locale\Model;

class Locale
{
    const SESSION_KEY_LOCALE = 'locale';
    const LOCALES = ['en', 'ru', 'ua', 'pl'];
    const TRANSLATOR_NAMES = [
        'en' => 'en_US',
        'ru' => 'ru_RU',
        'ua' => 'ua_UA',
        'pl' => 'pl_PL'
    ];

    public function setLocale($short_locale)
    {
        $client_lang = 'en';
            if (in_array($short_locale, self::LOCALES)) {
                $client_lang = $short_locale;
            }
        $this->setToSession($client_lang);
    }

    public function get()
    {
        if (!isset($_SESSION[self::SESSION_KEY_LOCALE])) {
            $this->getBrowserLang();
        }
    }

    public function getBrowserLang()
    {
        $re = '/[-=;, ]/m';
        $browser_langs = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $matches = preg_split($re, $browser_langs);
        $client_lang = 'en';

        foreach ($matches as $elem) {
            if (in_array($elem, self::LOCALES)) {
                $client_lang = $elem;
                break;
            }
        }
        $this->setToSession($client_lang);
    }

    private function setToSession($client_lang){
        $_SESSION[self::SESSION_KEY_LOCALE] = self::TRANSLATOR_NAMES[$client_lang];
    }

}

return new Locale();