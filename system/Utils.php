<?php

/**
 * Class Utils
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the ./LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) DreamVids
 * @link          http://dreamvids.fr DreamVids(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace System;

class Utils{

    /**
     * Generate random string
     * @param int $length
     * @return string
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Relative date
     * @param $date
     * @return string
     */
    function time($date)
    {
        $date_a_comparer = new DateTime($date);
        $date_actuelle = new DateTime("now");
        $intervalle = $date_a_comparer->diff($date_actuelle);

        if($date_a_comparer > $date_actuelle){
            $prefixe = 'dans ';
        }else{
            $prefixe = 'il y a ';
        }

        $ans = $intervalle->format('%y');
        $mois = $intervalle->format('%m');
        $jours = $intervalle->format('%d');
        $heures = $intervalle->format('%h');
        $minutes = $intervalle->format('%i');

        if($ans != 0){
            $relative_date = $prefixe . $ans . ' an' . (($ans > 1) ? 's' : '');
            if ($mois >= 6) $relative_date .= ' et demi';
        } elseif ($mois != 0){
            $relative_date = $prefixe . $mois . ' mois';
            if ($jours >= 15) $relative_date .= ' et demi';
        } elseif ($jours != 0){
            $relative_date = $prefixe . $jours . ' jour' . (($jours > 1) ? 's' : '');
        } elseif ($heures != 0){
            $relative_date = $prefixe . $heures . ' heure' . (($heures > 1) ? 's' : '');
        } elseif ($minutes != 0){
            $relative_date = $prefixe . $minutes . ' minute' . (($minutes > 1) ? 's' : '');
        } else {
            $relative_date = $prefixe . ' quelques secondes';
        }

        return $relative_date;
    }

    /**
     * Debug properly
     * @param $var
     */
    public static function dump($var){
        echo "<pre>";
        var_dump($var);
        echo "<pre>";
    }
}