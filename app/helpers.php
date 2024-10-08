<?php

use App\Models\AwardCategory;
use App\Models\AwardMarathonSetting;
use App\Models\AwardNominee;
use App\Models\ExpoRegistration;
use App\Models\MarathonRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


if (!function_exists('random_color')) {
    function random_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}

if (!function_exists('remove_space')) {
    function remove_space($string)
    {
        return str_replace(' ', '-', $string);
    }
}
if (!function_exists('remove_special_characters')) {
    function remove_special_characters($string)
    {
        $characters = str_replace(array(
            '\'',
            '"',
            '(',
            ')',
            '[',
            ']',
            '/',
            '+',
            '=',
            '$',
            '@',
            ',',
            ';',
            '<',
            '>',
            ':',
            '!',
            '#',
            '%',
            '^',
            '*',
            '~',
            '|',
            '{',
            '}',
            '.',
        ), '', $string);
        $word = str_replace('_', ' ', $characters);
        $result = preg_replace('/-+/', '-', remove_space(str_replace('&', 'and', $word)));
        return $result;
    }
}
if (!function_exists('slug_format')) {
    function slug_format($string)
    {
        $result = strtolower(remove_special_characters($string));
        return $result;
    }
}

if (!function_exists('unique_token')) {
    function unique_token()
    {
        $string = Str::random(10);
        return md5($string . time());
    }
}
if (!function_exists('phone_number_format')) {
    function phone_number_format($code, $digits)
    {

        $characters = str_replace(array(
            '\'',
            '"',
            '(',
            ')',
            '[',
            ']',
            '/',
            '+',
            '=',
            '$',
            '@',
            ',',
            ';',
            '<',
            '>',
            ':',
            '!',
            '#',
            '%',
            '^',
            '*',
            '~',
            '|',
            '{',
            '}',
            '.',
            ' ',
            '-',
            '_'
        ), '', $digits);
        $trimedmobile = substr($characters, -9);
        $phonenumber = $code . $trimedmobile;
        return $phonenumber;
    }
}

if (!function_exists('marathon_years')) {
    function marathon_years()
    {
        $runners = MarathonRegistration::select(DB::raw('YEAR(created_at) year'))
            ->latest()->groupBy('year')->get();
        return  $runners;
    }
}

if (!function_exists('award_years')) {
    function award_years()
    {
        $runners = AwardNominee::select(DB::raw('YEAR(created_at) year'))
            ->latest()->groupBy('year')->get();
        return  $runners;
    }
}
if (!function_exists('expo_years')) {
    function expo_years()
    {
        $year = ExpoRegistration::select(DB::raw('YEAR(created_at) year'))
            ->latest()->groupBy('year')->get();
        return  $year;
    }
}

if (!function_exists('awardCategories')) {
    function awardCategories()
    {
        return  AwardCategory::orderBy('name', 'ASC')->get();
    }
}

if (!function_exists('isMarathonActive')) {
    function isMarathonActive()
    {
        $award_settings = AwardMarathonSetting::get()->first();
        $marathon_registration_date = $award_settings->marathon_registration_time_remain;
        $marathon_registration_status =  $award_settings->marathon_registration;
        $curDateTime = date("Y-m-d H:i:s");
        $D_Date = date("Y-m-d H:i:s", strtotime($marathon_registration_date));
        if ($D_Date < $curDateTime ||  $marathon_registration_status == '0') {
            return false;
        } else {
            return true;
        }
    }
}
if (!function_exists('isAwardActive')) {
    function isAwardActive()
    {
        $award_settings = AwardMarathonSetting::get()->first();
        $award_date = $award_settings->awards_registration_time_remain;
        $award_status =  $award_settings->awards_registration;
        $curDateTime = date("Y-m-d H:i:s");
        $D_Date = date("Y-m-d H:i:s", strtotime($award_date));
        if ($D_Date < $curDateTime ||  $award_status == '0') {
            return false;
        } else {
            return true;
        }
    }
}
if (!function_exists('isExpoActive')) {
    function isExpoActive()
    {
        return true;
    }
}
if (!function_exists('isVoteActive')) {
    function isVoteActive()
    {
        $award_settings = AwardMarathonSetting::get()->first();
        $voting_date = $award_settings->vote_time_remain;
        $vote_status =  $award_settings->vote;
        $curDateTime = date("Y-m-d H:i:s");
        $D_Date = date("Y-m-d H:i:s", strtotime($voting_date));
        if ($D_Date < $curDateTime ||  $vote_status == '0') {
            return false;
        } else {
            return true;
        }
    }
}


if (!function_exists('reference_no')) {
    function reference_no($modelName)
    {
        $lastOrder = $modelName::orderBy('created_at', 'DESC')->first();
        $alphabetPart = 'AA';
        if ($lastOrder && $lastOrder->reference != null) {
            $lastReference = $lastOrder->reference;
            $alphabetPart = substr($lastReference, 0, 2);
            $alphabetPart = increment_alphabet($alphabetPart);
        }

        $randomPart = generate_random_string(8);
        $newOrderNo = $alphabetPart . $randomPart;
        // Ensure the reference is unique
        while ($modelName::where('reference', $newOrderNo)->exists()) {
            $alphabetPart = increment_alphabet($alphabetPart);
            $newOrderNo = $alphabetPart . generate_random_string(8);
        }

        return strtoupper($newOrderNo);
    }

    function generate_random_string($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle(str_repeat($characters, ceil($length / strlen($characters)))), 0, $length);
    }

    function increment_alphabet($alpha)
    {
        // Ensure the input is exactly two characters long
        if (strlen($alpha) != 2) {
            throw new InvalidArgumentException('Input must be a two-character string.');
        }

        $firstChar = $alpha[0];
        $secondChar = $alpha[1];

        if ($secondChar === 'Z') {
            if ($firstChar === 'Z') {
                // Reset to 'AA' if both are 'Z'
                return 'AA';
            }
            // Increment the first character and reset the second character to 'A'
            return chr(ord($firstChar) + 1) . 'A';
        } else {
            // Increment the second character
            return $firstChar . chr(ord($secondChar) + 1);
        }
    }
}
