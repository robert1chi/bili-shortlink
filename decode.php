<?php
$Slink = $_POST['before'];
$Slink = htmlspecialchars($Slink, ENT_QUOTES);
if(!empty($Slink) == 1){
    if (strpos($Slink, 'https://b23.tv/') !== false || strpos($Slink, 'http://b23.tv/') !== false)  {
        $Slink=str_replace('http://',"https://",$Slink);
        $left = strpos($Slink, 'https://b23.tv/');
        $left = strpos($Slink, 'https://b23.tv/');
        $b_alink = substr($Slink, $left + strlen('https://b23.tv/'));
        $alink= 'https://b23.tv/'.$b_alink;
        $origin = "https://b23.tv"; //目标网址
        $header = [
            'Accept: application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: zh-CN,zh;q=0.9',
            'Connection: keep-alive',
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            //           'Host: localhost_mlf.com',
            'Origin: ' . $origin,
            'Referer:' . $alink,
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36',
            'X-Requested-With: XMLHttpRequest',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $alink);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        if ($error) {
            echo 'Error: ' . $error;
        }
        curl_close($ch);
        if (is_json($response) == true){
            $arr1 = json_decode($response,true);
            if (strpos($response,'https://www.bilibili.com/video') !== false){
            $part1 = (strpos($response, '/video'));
            $part2 = (strpos($response, '?'));
            $final = 'https://www.bilibili.com/video'.substr($response,$part1 + strlen('/video'), $part2-$part1-strlen('/video'));
            echo $final;
            }
            elseif ($arr1['code'] = -404 ){
                echo '啥也没有，是不是输错了呢';
            }
            else {echo '未知错误';}
        }
        else {
            echo "未知错误";
        }
    }
    elseif((strpos($Slink, 'https://b23.tv/') === false) && (substr($Slink,0,2) == 'BV')&& (ctype_alnum($Slink) === true)){
        $final = 'https://www.bilibili.com/video/'.$Slink;
        echo $final;
    }
    else{
        echo "不是b站短链接哦";
    }
    }

else{echo "没有输入内容捏";}
function is_json($string): bool
{
    return is_null(json_decode($string));
}
?>