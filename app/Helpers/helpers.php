<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

if (!function_exists('getCartId')) {
    function getCartId()
    {
        if (is_null(Cookie::get('cart'))) {
            Cookie::queue(
                Cookie::make('cart', session()->getId(), 260640)
            );
            return session()->getId();
        }
        return Cookie::get('cart');
    }
}

if (!function_exists('array_key_exists_recursive')) {
    function array_key_exists_recursive($key, $array)
    {
        if (array_key_exists($key, $array)) {
            return true;
        }
        foreach ($array as $k => $value) {
            if (is_array($value) && array_key_exists_recursive($key, $value)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('phone_format')) {
    /**
     * @return string Formatted phone number
     */
    function phone_format($phone)
    {
        $phone = only_integers($phone);

        $res = preg_replace(
            [
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            ],
            [
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4',
                '+7 ($2) $3-$4',
            ],
            $phone
        );

        return $res;
    }
}

if (!function_exists('date_to_cyr')) {
    function date_to_cyr($date, $format = 'd.m.Y H:i:s')
    {
        return Carbon::parse($date)->locale('ru', 'eu')->translatedFormat($format);
    }
}

if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {
            return app('setting')->set($key);
        }

        try {
            return app('setting')->get($key, $default);
        } catch (PDOException $e) {
            return $default;
        }
    }
}

if (!function_exists('current_route_name')) {
    function current_route_name()
    {
        return Route::currentRouteName();
    }
}

if (!function_exists('mb_ucfirst')) {
    /**
     * @charset UTF-8
     * Преобразует первый символ строки в верхний регистр.
     * @param string $str
     */
    function mb_ucfirst($str)
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc . mb_substr($str, 1);
    }
}

if (!function_exists('only_integers')) {
    function only_integers($numbers)
    {
        $symbs = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

        $callback = function ($a, $b) use ($symbs) {
            if (in_array($b, $symbs))
                $a .= $b;
            return $a;
        };

        $result = array_reduce(str_split($numbers), $callback, "");
        return $result;
    }
}

if (!function_exists('locale')) {
    /**
     * Get current locale.
     *
     * @return string
     */
    function locale()
    {
        return app()->getLocale();
    }
}

if (!function_exists('price')) {
    function price($money, $num = 0)
    {
        return number_format($money, $num, ',', ' ');
    }
}

if (!function_exists('sum')) {
    function sum($array, $key)
    {
        return array_sum(array_column($array, $key));
    }
}

if (!function_exists('array_add')) {
    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param  array  $array
     * @param  string  $key
     * @param  mixed  $value
     * @return array
     */
    function array_add($array, $key, $value)
    {
        return Arr::add($array, $key, $value);
    }
}

if (!function_exists('city')) {
    /**
     * Collapse an array of arrays into a single array.
     *
     * @param  array  $array
     * @return array
     */
    function city(string $word)
    {
        //Согласные
        $consonants = ["б", "в", "г", "д", "ж", "з", "й", "к", "л", "м", "н", "п", "р", "с", "т", "ф", "х", "ц", "ч", "ш", "щ", "ь"];
        //Гласные
        $vocal = ["а", "у", "о", "ы", "и", "э", "я", "ю", "ё", "е"];
        //Глухие согласные
        $deafConsonants = ["п", "ф", "к", "т", "ш", "с", "х", "ц", "ч", "щ"];
        //Звонкие согласные
        $voicedConsonants = ["б", "в", "г", "д", "ж", "з", "л", "м", "н", "р"];
        //Общие окончания
        $endings = [
            "ий", "ай", "ая", "ты", "ей", "ри", "ды", "ое", "ец", "ый", "ны", "ие", "ые", "бо", "но", "во", "ть", "ро", "ор", "ма", "ау", "ко", "кт", "ну", "ян", "ар", "нь", "ый", "лы", "ль",
            "чи", "ки", "ой", "ок", "аы", "ни"
        ];
        //Окончание при глухой согласной
        $deafEndings = ["ий" => "ом", "ой" => "ом"];
        //Окончание при звонкой согласной
        $voicedEndings = ["ий" => "ем", "ой" => "ое", "ец" => "це"];
        //Простые окончания
        $regularEndings = [
            "ай" => "ае", "ая" => "ой", "ты" => "тах", "ей" => "ее", "ри" => "рях", "ды" => "дах", "лы" => "лах", "ое" => "ом", "ор" => "ору", "ец" => "це", "ый" => "ом",
            "ны" => "нах", "ие" => "их", "ые" => "ых", "ий" => "ом", "ль" => "ле", "нь" => "не", "чи" => "чах", "ки" => "ках", "ок" => "ке", "аы" => "ау", "ни" => "нях"
        ];
        //Окончание при третьем гласном знаке
        $vocalEndings = ["ень" => "не", "оби" => "би", "лец" => "льце", "очи" => "очи"];
        //Несклоняемые окончания
        $noDeclension = ["ну", "бо", "но", "во", "ть", "ро", "ма", "ау", "ко", "кт", "ян", "ар", "ак", "ев", "ас", "ид", "он", "ыл", "сь"];
        //Проверяем сложное название или простое по наличию дефиса или пробела
        preg_match("~(-на-|-|\s)~", $word, $delimiter) ? $word = explode($delimiter[0], $word) : null;
        //Если сложно выполняем склонение для каждой части отдельно
        if (is_array($word)) {
            foreach ($word as $key => $value) {
                //Получаем последний знак
                $singleChar = mb_substr($value, -1);
                //Определяем гласная или согласная
                if (in_array($singleChar, $vocal)) { //Если гласная
                    //Получаем окончание из 2 знаков
                    $twoChars = mb_strtolower(mb_substr($value, -2));
                    if (!in_array($twoChars, $noDeclension)) {
                        if (in_array($twoChars, $endings)) {
                            //Если окончание присутствует в массиве получаем третий знак
                            $thirdChar = mb_strtolower(mb_substr($value, -3, 1));
                            //Если глухой
                            if (in_array($thirdChar, $deafConsonants)) {
                                if (array_key_exists($twoChars, $deafEndings)) {
                                    $word[$key] = mb_substr($value, 0, -2) . $deafEndings[$twoChars];
                                } else {
                                    $word[$key] = mb_substr($value, 0, -2) . $regularEndings[$twoChars];
                                }
                                //Если звонкий
                            } elseif (in_array($thirdChar, $voicedConsonants)) {
                                if (array_key_exists($twoChars, $voicedEndings)) {
                                    $word[$key] = mb_substr($value, 0, -2) . $voicedEndings[$twoChars];
                                } else {
                                    $word[$key] = mb_substr($value, 0, -2) . $regularEndings[$twoChars];
                                }
                                //Если третий символ гласный
                            } elseif (in_array($thirdChar, $vocal)) {
                                //Получаем окончание из 3 знаков
                                $threeChars = mb_substr($value, -3);
                                if (array_key_exists($threeChars, $vocalEndings)) {
                                    $word[$key] = mb_substr($value, 0, -3) . $vocalEndings[$threeChars];
                                } else {
                                    $word[$key] = mb_substr($value, 0, -2) . $regularEndings[$twoChars];
                                }
                                //Или берем стандартное окнчание
                            } else {
                                $word[$key] = mb_substr($value, 0, -2) . $regularEndings[$twoChars];
                            }
                        } else {
                            $word[$key] = mb_substr($value, 0, -1) . "е";
                        }
                    }
                }
                if (in_array($singleChar, $consonants)) { //Если согласная
                    //Получаем окончание из 2 знаков
                    $twoChars = mb_strtolower(mb_substr($value, -2));
                    if (!in_array($twoChars, $noDeclension)) {
                        if (in_array($twoChars, $endings)) {
                            //Если окончание присутствует в массиве получаем третий знак
                            $thirdChar = mb_strtolower(mb_substr($value, -3, 1));
                            if (in_array($thirdChar, $deafConsonants)) {
                                if (array_key_exists($twoChars, $deafEndings)) {
                                    $word[$key] = mb_substr($value, 0, -2) . $deafEndings[$twoChars];
                                } else {
                                    $word[$key] = mb_substr($value, 0, -2) . $regularEndings[$twoChars];
                                }
                                //Если звонкий
                            } elseif (in_array($thirdChar, $voicedConsonants)) {
                                if (array_key_exists($twoChars, $voicedEndings)) {
                                    $word[$key] = mb_substr($value, 0, -2) . $voicedEndings[$twoChars];
                                } else {
                                    $word[$key] = mb_substr($value, 0, -2) . $regularEndings[$twoChars];
                                }
                            } elseif (in_array($thirdChar, $vocal)) {
                                //Получаем окончание из 3 знаков
                                $threeChars = mb_substr($value, -3);
                                if (array_key_exists($threeChars, $vocalEndings)) {
                                    $word[$key] = mb_substr($value, 0, -3) . $vocalEndings[$threeChars];
                                } else {
                                    $word[$key] = mb_substr($value, 0, -2) . $regularEndings[$twoChars];
                                }
                            }
                        } else $word[$key] = "{$value}е";
                    }
                }
            }
            //Склеиваем обратно и возвращаем
            return implode($delimiter[0], $word);
        }
        //Если навзание простое выполняем склонение в штатном режиме
        $singleChar = mb_strtolower(mb_substr($word, -1));
        //Если гласная
        if (in_array($singleChar, $vocal)) {
            $twoChars = mb_strtolower(mb_substr($word, -2));
            if (!in_array($twoChars, $noDeclension)) {
                if (in_array($twoChars, $endings)) {
                    //Если окончание присутствует в массиве получаем третий знак
                    $threeChars = mb_substr($word, -3);
                    if (in_array($threeChars, $vocalEndings)) {
                        return mb_substr($word, 0, -3) . $vocalEndings[$threeChars];
                    }
                    return mb_substr($word, 0, -2) . $regularEndings[$twoChars];
                }
                return mb_substr($word, 0, -1) . "е";
            }
            return $word;
        }
        //Если согласная
        if (in_array($singleChar, $consonants)) {
            $twoChars = mb_strtolower(mb_substr($word, -2));
            if (!in_array($twoChars, $noDeclension)) {
                if (in_array($twoChars, $endings)) {
                    //Если окончание присутствует в массиве получаем третий знак
                    $thirdChar = mb_strtolower(mb_substr($word, -3, 1));
                    if (in_array($thirdChar, $deafConsonants)) {
                        if (array_key_exists($twoChars, $deafEndings)) {
                            return mb_substr($word, 0, -2) . $deafEndings[$twoChars];
                        } else {
                            return mb_substr($word, 0, -2) . $regularEndings[$twoChars];
                        }
                        //Если звонкий
                    } elseif (in_array($thirdChar, $voicedConsonants)) {
                        if (array_key_exists($twoChars, $voicedEndings)) {
                            return mb_substr($word, 0, -2) . $voicedEndings[$twoChars];
                        } else {
                            return mb_substr($word, 0, -2) . $regularEndings[$twoChars];
                        }
                    }
                    return mb_substr($word, 0, -2) . $regularEndings[$twoChars];
                }
            }
            return "{$word}е";
        }
    }
}

if (!function_exists('array_collapse')) {
    /**
     * Collapse an array of arrays into a single array.
     *
     * @param  array  $array
     * @return array
     */
    function array_collapse($array)
    {
        return Arr::collapse($array);
    }
}

if (!function_exists('array_divide')) {
    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param  array  $array
     * @return array
     */
    function array_divide($array)
    {
        return Arr::divide($array);
    }
}

if (!function_exists('array_dot')) {
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array  $array
     * @param  string  $prepend
     * @return array
     */
    function array_dot($array, $prepend = '')
    {
        return Arr::dot($array, $prepend);
    }
}

if (!function_exists('array_except')) {
    /**
     * Get all of the given array except for a specified array of keys.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function array_except($array, $keys)
    {
        return Arr::except($array, $keys);
    }
}

if (!function_exists('array_first')) {
    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param  array  $array
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    function array_first($array, callable $callback = null, $default = null)
    {
        return Arr::first($array, $callback, $default);
    }
}

if (!function_exists('array_flatten')) {
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array  $array
     * @param  int  $depth
     * @return array
     */
    function array_flatten($array, $depth = INF)
    {
        return Arr::flatten($array, $depth);
    }
}

if (!function_exists('array_forget')) {
    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return void
     */
    function array_forget(&$array, $keys)
    {
        Arr::forget($array, $keys);
    }
}

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int  $key
     * @param  mixed  $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::get($array, $key, $default);
    }
}

if (!function_exists('array_has')) {
    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|array  $keys
     * @return bool
     */
    function array_has($array, $keys)
    {
        return Arr::has($array, $keys);
    }
}

if (!function_exists('array_last')) {
    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param  array  $array
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    function array_last($array, callable $callback = null, $default = null)
    {
        return Arr::last($array, $callback, $default);
    }
}

if (!function_exists('array_only')) {
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function array_only($array, $keys)
    {
        return Arr::only($array, $keys);
    }
}

if (!function_exists('array_pluck')) {
    /**
     * Pluck an array of values from an array.
     *
     * @param  array  $array
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    function array_pluck($array, $value, $key = null)
    {
        return Arr::pluck($array, $value, $key);
    }
}

if (!function_exists('array_prepend')) {
    /**
     * Push an item onto the beginning of an array.
     *
     * @param  array  $array
     * @param  mixed  $value
     * @param  mixed  $key
     * @return array
     */
    function array_prepend($array, $value, $key = null)
    {
        return Arr::prepend($array, $value, $key);
    }
}

if (!function_exists('array_pull')) {
    /**
     * Get a value from the array, and remove it.
     *
     * @param  array  $array
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function array_pull(&$array, $key, $default = null)
    {
        return Arr::pull($array, $key, $default);
    }
}

if (!function_exists('array_random')) {
    /**
     * Get a random value from an array.
     *
     * @param  array  $array
     * @param  int|null  $num
     * @return mixed
     */
    function array_random($array, $num = null)
    {
        return Arr::random($array, $num);
    }
}

if (!function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array  $array
     * @param  string  $key
     * @param  mixed  $value
     * @return array
     */
    function array_set(&$array, $key, $value)
    {
        return Arr::set($array, $key, $value);
    }
}

if (!function_exists('array_sort')) {
    /**
     * Sort the array by the given callback or attribute name.
     *
     * @param  array  $array
     * @param  callable|string|null  $callback
     * @return array
     */
    function array_sort($array, $callback = null)
    {
        return Arr::sort($array, $callback);
    }
}

if (!function_exists('array_sort_recursive')) {
    /**
     * Recursively sort an array by keys and values.
     *
     * @param  array  $array
     * @return array
     */
    function array_sort_recursive($array)
    {
        return Arr::sortRecursive($array);
    }
}

if (!function_exists('array_where')) {
    /**
     * Filter the array using the given callback.
     *
     * @param  array  $array
     * @param  callable  $callback
     * @return array
     */
    function array_where($array, callable $callback)
    {
        return Arr::where($array, $callback);
    }
}

if (!function_exists('array_wrap')) {
    /**
     * If the given value is not an array, wrap it in one.
     *
     * @param  mixed  $value
     * @return array
     */
    function array_wrap($value)
    {
        return Arr::wrap($value);
    }
}

if (!function_exists('camel_case')) {
    /**
     * Convert a value to camel case.
     *
     * @param  string  $value
     * @return string
     */
    function camel_case($value)
    {
        return Str::camel($value);
    }
}

if (!function_exists('ends_with')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function ends_with($haystack, $needles)
    {
        return Str::endsWith($haystack, $needles);
    }
}

if (!function_exists('kebab_case')) {
    /**
     * Convert a string to kebab case.
     *
     * @param  string  $value
     * @return string
     */
    function kebab_case($value)
    {
        return Str::kebab($value);
    }
}

if (!function_exists('snake_case')) {
    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
     */
    function snake_case($value, $delimiter = '_')
    {
        return Str::snake($value, $delimiter);
    }
}

if (!function_exists('starts_with')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function starts_with($haystack, $needles)
    {
        return Str::startsWith($haystack, $needles);
    }
}

if (!function_exists('str_after')) {
    /**
     * Return the remainder of a string after a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    function str_after($subject, $search)
    {
        return Str::after($subject, $search);
    }
}

if (!function_exists('str_before')) {
    /**
     * Get the portion of a string before a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    function str_before($subject, $search)
    {
        return Str::before($subject, $search);
    }
}

if (!function_exists('str_contains')) {
    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function str_contains($haystack, $needles)
    {
        return Str::contains($haystack, $needles);
    }
}

if (!function_exists('str_finish')) {
    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $cap
     * @return string
     */
    function str_finish($value, $cap)
    {
        return Str::finish($value, $cap);
    }
}

if (!function_exists('str_is')) {
    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string|array  $pattern
     * @param  string  $value
     * @return bool
     */
    function str_is($pattern, $value)
    {
        return Str::is($pattern, $value);
    }
}

if (!function_exists('str_limit')) {
    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int  $limit
     * @param  string  $end
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...')
    {
        return Str::limit($value, $limit, $end);
    }
}

if (!function_exists('str_plural')) {
    /**
     * Get the plural form of an English word.
     *
     * @param  string  $value
     * @param  int  $count
     * @return string
     */
    function str_plural($value, $count = 2)
    {
        return Str::plural($value, $count);
    }
}

if (!function_exists('str_random')) {
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \RuntimeException
     */
    function str_random($length = 16)
    {
        return Str::random($length);
    }
}

if (!function_exists('str_replace_array')) {
    /**
     * Replace a given value in the string sequentially with an array.
     *
     * @param  string  $search
     * @param  array  $replace
     * @param  string  $subject
     * @return string
     */
    function str_replace_array($search, array $replace, $subject)
    {
        return Str::replaceArray($search, $replace, $subject);
    }
}

if (!function_exists('str_replace_first')) {
    /**
     * Replace the first occurrence of a given value in the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    function str_replace_first($search, $replace, $subject)
    {
        return Str::replaceFirst($search, $replace, $subject);
    }
}

if (!function_exists('str_replace_last')) {
    /**
     * Replace the last occurrence of a given value in the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    function str_replace_last($search, $replace, $subject)
    {
        return Str::replaceLast($search, $replace, $subject);
    }
}

if (!function_exists('str_singular')) {
    /**
     * Get the singular form of an English word.
     *
     * @param  string  $value
     * @return string
     */
    function str_singular($value)
    {
        return Str::singular($value);
    }
}

if (!function_exists('str_slug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string  $language
     * @return string
     */
    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }
}

if (!function_exists('str_start')) {
    /**
     * Begin a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $prefix
     * @return string
     */
    function str_start($value, $prefix)
    {
        return Str::start($value, $prefix);
    }
}

if (!function_exists('studly_case')) {
    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     * @return string
     */
    function studly_case($value)
    {
        return Str::studly($value);
    }
}

if (!function_exists('title_case')) {
    /**
     * Convert a value to title case.
     *
     * @param  string  $value
     * @return string
     */
    function title_case($value)
    {
        return Str::title($value);
    }
}
