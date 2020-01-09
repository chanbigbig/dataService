<?php

/**
 * json解释
 * @param $string
 * @return array|mixed|stdClass
 */
function decodeIfJson($string)
{
    json_decode($string);
    return json_last_error() == JSON_ERROR_NONE ? json_decode($string, true) : $string;
}



/**
 * 获取好友搜索内容的类型
 * @param $search
 * @return int
 */
function getSearchScene($search)
{
    if (is_numeric($search)) {
        $length = mb_strlen($search);
        if ($length > 11 || $length < 5) {
            return 0;
        } else if ($length == 11) {
            return 15;
        } else {
            return 1;
        }
    } else if (isWxid($search)) {
        return 3;
    }
    return 0;
}



/**
 * 获取服务器真实IP
 * @return string
 */
function getHostIp()
{
    preg_match('/inet(.*)netmask/', shell_exec('ifconfig'), $match);
    return (trim($match[1]));
}

/**
 * 获取路径下的所有类
 * @param $path
 * @return array
 */
function getClasses($path)
{
    $myClasses = [];
    $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
    $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
    foreach ($phpFiles as $phpFile) {
        $content = file_get_contents($phpFile->getRealPath());
        $tokens = token_get_all($content);
        $namespace = '';
        for ($index = 0; isset($tokens[$index]); $index++) {
            if (!isset($tokens[$index][0])) {
                continue;
            }
            if (T_NAMESPACE === $tokens[$index][0]) {
                $index += 2; // Skip namespace keyword and whitespace
                while (isset($tokens[$index]) && is_array($tokens[$index])) {
                    $namespace .= $tokens[$index++][1];
                }
            }
            if (T_CLASS === $tokens[$index][0]) {
                $index += 2; // Skip class keyword and whitespace
                $myClasses[] = $namespace . '\\' . $tokens[$index][1];
            }
        }
    }
    return $myClasses;
}

/**
 * 异步执行闭包，支持参数，支持延时, 闭包里不要包含$this，参数请用$params
 * @param Closure $closure
 * @param array $params
 * @param int $delayedSeconds
 * @param string $queue
 * @param string $connection
 * @return mixed
 */
function execAsyncAction(Closure $closure, array $params = [], int $delayedSeconds = 0, $queue = '', $connection = '')
{
    $connection = $connection ?: config('queue.default');
    $queue = $queue ?: 'default';

    $params['trace'] = end(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2));

    if ($delayedSeconds) {
        return \Queue::connection($connection)->later($delayedSeconds, (new \App\Jobs\AsyncAction($closure, $params)), '', $queue);
    }
    return \Queue::connection($connection)->push(new \App\Jobs\AsyncAction($closure, $params), '', $queue);
}


/**
 * 文件上传七牛
 * @param $path
 * @param string $dsn
 * @param null $key
 * @return bool|string
 */
function qiniuUpload($path, $dsn = '', $key = null)
{
    $dsn || $dsn = 'default';
    $config = config('qiniu.dsn.' . $dsn);
    list($ret, $error) = (new Qiniu\Storage\UploadManager())
        ->putFile(qiniuToken($key, $dsn), $key ?: $dsn . '-' . md5($path) . time(), $path); //
    if ($error) {
        return false;
    }
    return $config['domain'] . '/' . $ret['key'];
}

/**
 * 获取七牛token
 * @param $dsn
 * @param null $key
 * @return string
 */
function qiniuToken($key = null, $dsn = '')
{
    $dsn || $dsn = 'default';
    $config = config('qiniu.dsn.' . $dsn);
    $auth = new Qiniu\Auth(config('qiniu.accessKey'), config('qiniu.secretKey'));
    return $auth->uploadToken($config['bucket'], $key);
}

/**
 * 访问私有七牛资源
 * @param $url
 * @return string url
 */
function qiniuPrivateAccess($url)
{
    $auth = new Qiniu\Auth(config('qiniu.accessKey'), config('qiniu.secretKey'));

    return $auth->privateDownloadUrl($url);
}

/**
 * 根据文件地址删除七牛文件, 只支持通过qiniuUpload方法上传的文件
 * @param $path
 * @return bool true删除成功
 */
function qiniuDelete($path)
{
    $key = basename($path);
    $dsn = explode('-', $key);
    array_pop($dsn);
    $dsn = implode('-', $dsn);
    if ($dsn && $config = config('qiniu.dsn.' . $dsn)) {
        $handle = new Qiniu\Storage\BucketManager(new Qiniu\Auth(config('qiniu.accessKey'), config('qiniu.secretKey')));
        if ($handle->delete($config['bucket'], $key)) {
            return false;
        }
        return true;
    }
    return false;
}

/**
 * 粗略判断是否是微信号或者wxid
 * @param $str
 * @return int
 */
function isWxid($str)
{
    return preg_match('/^[@\-_a-zA-Z0-9]{5,20}$/', $str);
}

/**
 * 使一个多维数组扁平成一维
 * @param $array
 * @param string $prefix
 * @return array
 */
function flattenArray($array, $prefix = '')
{
    $result = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = $result + flattenArray($value, $prefix . $key . '.');
        } else {
            $result[$prefix . $key] = $value;
        }
    }
    return $result;
}

/**
 * 根据两个账号id获取唯一id
 * @param $accountId
 * @param $targetAccountId
 * @param string $seperater
 * @return string
 */
function getUniqueUserId($accountId, $targetAccountId, $seperater = '-')
{
    $account = \App\Models\Account::getAccount($accountId);
    $targetAccount = \App\Models\Account::getAccount($targetAccountId);
    if ($account->type == 1) {
        $userId = $accountId;
    } else if ($targetAccount->type == 1) {
        $userId = $targetAccountId;
    } else {
        $seperater || $seperater = '_';
        $userId = $accountId < $targetAccountId ? $accountId . $seperater . $targetAccountId : $targetAccountId . $seperater . $accountId;
    }
    return strval($userId);
}

/**
 * 获取唯一设备id
 * @param string $type
 * @param int $tries
 * @return mixed
 * @throws Exception
 */
function getUniqueDeviceId($type = '', $tries = 10)
{
    $i = 0;
    do {
        $type || $type = date('Ymd');
        $deviceId = uniqid($type . $i);
        $i++;
        if ($i > $tries) {
            throw new Exception('获取唯一设备ID重试次数过多');
        }
    } while (\App\Models\Device::where('device_id', $deviceId)->first(['id']));

    return $deviceId;

}

/**
 * 从2的指数值中，获取不在当前数组中，最小的指数值
 * @param array $values
 * @param int $index
 * @return int
 */
function getIndexFromPow2(array $values, $index = 1)
{
    if (in_array($index, $values)) {
        return getIndexFromPow2($values, $index << 1);
    } else {
        return $index;
    }
}

/**
 * 分解标签
 * @param $id
 * @param $tags
 * @return array
 */
function parseTagFromTags($id, $tags)
{
    $result = [];
    foreach ($tags as $tagName => $tagId) {
        if (intval($tagId) & intval($id)) {
            $result[] = ['id' => intval($tagId), 'name' => strval($tagName)];
        }
    }
    return $result;
}

/**
 * 将字符串转为十六进制的字符串
 * @param $str
 * @return string
 */
function strToHex($str)
{
    return strtoupper(implode(unpack("H*", $str)));
}

/**
 * 数组内容加密
 * @param $array
 * @return string
 */
function encryptArray($array)
{
    $data = base64_encode(json_encode($array));
    //前面加10位随机字符
    $data = substr(str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm'), 26, 10) . $data;
    return $data;
}

/**
 * 字符串去除emoji
 * @param $text
 * @return string
 */

function emoji_reject($text)
{
    $len = mb_strlen($text);
    $newText = '';
    for ($i = 0; $i < $len; $i++) {
        $word = mb_substr($text, $i, 1);
        if (strlen($word) <= 3) {
            $newText .= $word;
        }
    }
    return $newText;
}


/**
 * 是否手机号
 * @param $value
 * @return bool
 */
function isMobile($value)
{
    return preg_match("/^((86)[\+-]?)?^1\d{10}$/i", $value) == 1;
}

/**
 * 将json转换成数组
 * @param string 待转换json字符串
 * @return bool|array 成功返回转换后的数组，否则返回 false
 */
function jsonToArray($data = '')
{
    $data = json_decode($data, true);
    // json字符串转换成数组成功直接返回
    if (is_array($data)) {
        return $data;
    }
    // 转换失败
    return false;
}


/**
 * 后台列表数据汇总
 * @param array $cellIndexs
 * @return string
 */
function summaryGridScript($cellIndexs = [])
{
    $cellIndexs = json_encode($cellIndexs);
    return <<<EOF
            if($('.summary').text()=='汇总'){
                return;
            }
            var td = $('tbody>tr>td');
            var cellIndex = {$cellIndexs};
            var val = [];
            for(var i=0;i<cellIndex.length;i++){
                for(var j=0;j<td.length;j++){
                    if(td[j].cellIndex==cellIndex[i]){
                        if(isNaN(val[cellIndex[i]])){
                            val[cellIndex[i]]=0;
                        }
                        val[cellIndex[i]] += Number($(td[j]).text());
                    }
                }

            }
            var tr = $('tbody>tr')[0];
            var text='<tr style="background-color:rgba(28,255,123,0.07);">';
            var v='';
            for(var k=0;k<tr.childElementCount;k++){
                if(k==0){
                    v='<strong class="summary">汇总</strong>';
                }else if(cellIndex.indexOf(k) > -1){
                    v=val[k];
                }else{
                    v='-';
                }
                text+='<td><strong>'+v+'</strong></td>';
            }
            text +='</tr>';
            $('tbody').append(text);   
EOF;
}

/**
 * 返回区间内的值
 * @param $current
 * @param $min
 * @param $max
 * @return mixed
 */
function clamp($current, $min, $max)
{
    return number_format(max($min, min($max, $current)), '2');
}

/**
 * 解码utf-16
 * @param $str
 * @param null $be
 * @return string
 */
function utf16_decode($str, &$be = null)
{
    if (strlen($str) < 2) {
        return $str;
    }
    $c0 = ord($str{0});
    $c1 = ord($str{1});
    $start = 0;
    if ($c0 == 0xFE && $c1 == 0xFF) {
        $be = true;
        $start = 2;
    } else if ($c0 == 0xFF && $c1 == 0xFE) {
        $start = 2;
        $be = false;
    }
    if ($be === null) {
        $be = true;
    }
    $len = strlen($str);
    $newstr = '';
    for ($i = $start; $i < $len; $i += 2) {
        if ($be) {
            $val = ord($str{$i}) << 4;
            $val += ord($str{$i + 1});
        } else {
            $val = ord($str{$i + 1}) << 4;
            $val += ord($str{$i});
        }
        $newstr .= ($val == 0x228) ? "\n" : chr($val);
    }
    return $newstr;
}

/**
 * @param $url 请求网址
 * @param bool $params 请求参数
 * @param int $ispost 请求方式
 * @param int $https https协议
 * @return bool|mixed
 */
function curl($url, $params = false, $ispost = 0, $https = 0)
{
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, 'https://ydy.yidejia.com');
    if ($https) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    }
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            if (is_array($params)) {
                $params = http_build_query($params);
            }
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }

    $response = curl_exec($ch);

    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
    curl_close($ch);
    return $response;
}

/**
 * 获取需要更新的字段，如果传入的值为空，则保留原始的值
 * @param array $fillableKeys
 * @return array
 */
function updateTryingColumns(array $fillableKeys)
{
    $result = [];
    foreach ($fillableKeys as $key) {
        $result[$key] = sprintf("if (VALUES(`%s`)>'' ,VALUES(`%s`), `%s`)", $key, $key, $key);
    }
    return $result;
}

/**
 * 闭包代码
 * @param Closure $c
 * @return string
 */
function closure_dump(Closure $c) {
    $str = 'function (';
    $r = new ReflectionFunction($c);
    $params = array();
    foreach($r->getParameters() as $p) {
        $s = '';
        if($p->isArray()) {
            $s .= 'array ';
        } else if($p->getClass()) {
            $s .= $p->getClass()->name . ' ';
        }
        if($p->isPassedByReference()){
            $s .= '&';
        }
        $s .= '$' . $p->name;
        if($p->isOptional()) {
            $s .= ' = ' . var_export($p->getDefaultValue(), TRUE);
        }
        $params []= $s;
    }
    $str .= implode(', ', $params);
    $str .= '){' . PHP_EOL;
    $lines = file($r->getFileName());
    for($l = $r->getStartLine(); $l < $r->getEndLine(); $l++) {
        $str .= $lines[$l];
    }
    return $str;
}