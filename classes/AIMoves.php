<?php

class AIMoves
{
    function AIPlay(){
        /**
         * using kevinAlbs's Connect4 AI
         * https://github.com/kevinAlbs/Connect4
         */
        $data = self::boardToData($GLOBALS['board']);
        $response = self::get_web_page("http://kevinalbs.com/connect4/back-end/index.php/getMoves?board_data=$data&player=2");
        //$resArr = array();
        $resArr = json_decode($response, true);
        //echo self::best_move($resArr);
        return self::best_move($resArr);
    }

    function best_move($list){
        $moveKey = '0';
        $moveValue = $list[$moveKey];
        foreach ($list as $key => $value){
            if ($value >= $moveValue){
                $moveKey = $key;
                $moveValue = $value;
            }
        }
        return $moveKey;
    }

    function get_web_page($url) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content  = curl_exec($ch);

        curl_close($ch);

        return $content;
    }

    function boardToData(){
        $data = "";
        for ($j=$GLOBALS['HAUT']-1; $j>=0; $j--) {
            for ($i=0; $i<$GLOBALS['HAUT']; $i++) {
                $data = $data.$GLOBALS['board'][$i][$j];
            }
        }
        return $data;
    }
}