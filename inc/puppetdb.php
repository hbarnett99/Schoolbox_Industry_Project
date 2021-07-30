<?php

// PuppetDB functions

/**
 * Execute a query against puppet db api v3
 *
 * @param string $server   Requires scheme + domain + port, eg 'http://puppetdb.service.consul:8080'
 * @param string $endpoint
 * @return array
 * @deprecated Use the v4 API
 * @see        https://puppet.com/docs/puppetdb/6.0/api/index.html
 */
function puppetdb3_query($server, $endpoint)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "{$server}/v3/{$endpoint}");
    $result = curl_exec($curl);
    $result = json_decode($result, true);
    return $result;
}

/**
 * Execute a query against puppet db api v4
 *
 * @param string $server   Requires scheme + domain + port, eg 'http://puppetdb.service.consul:8080'
 * @param string $endpoint
 * @param string $query
 * @return array
 */
function puppetdb4_query($server, $endpoint, $query)
{
    $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, "{$server}/pdb/query/v4/{$endpoint}?query={$query}");
        curl_setopt($curl, CURLOPT_HTTPGET, true);
    $result = curl_exec($curl);
    return json_decode($result,true);
}

/**
 * Returns facts from all registered puppetDb servers
 *
 * @param string $fact
 * @param string $value If set, only return facts where the value matches this
 * @param string $environment If set, only return facts where the environment matches this
 * @return array
 */
function getFacts($fact, $value = '', $environment = '')
{

    $v3Servers = [
//        'http://puppet.alaress-dev.com.au:8080',      // 52.64.67.184 This server is non-responsive since ~2021/01/01 and only contains deprecated instances anyway
    ];
    $v4Servers = [
//        'http://puppetdb.service.consul:8080',        // 172.31.0.5   (this appears to be an alias of 'puppet.alaress.com.au', so not needed)
        'http://puppet.alaress.com.au:8080',          // 13.236.189.186  Production. 16.04 + 18.04 boxes point to this
        'http://puppetstage.alaress.com.au:8080',     // 3.104.38.207
    ];

    $errors   = [];
    $dataSets = [];

    foreach ($v3Servers as $v3Server) {
        $response = puppetdb3_query($v3Server, 'facts/' . $fact);
        if (!is_array($response)) {
            $errors[] = "Invalid query response from V3 server: 'facts/$fact";
        } else {
            $dataSets[] = $response;
        }
    }
    foreach ($v4Servers as $v4Server) {
        $response = puppetdb4_query($v4Server, 'facts', urlencode(sprintf('["=", "name", "%s"]', $fact)));
        if (!is_array($response)) {
            $errors[] = "Invalid query response from V3 server: 'facts/$fact";
        } else {
            $dataSets[] = $response;
        }
    }

    foreach ($errors as $error) {
        trigger_error($error, E_USER_WARNING);
    }

    $data = [];
    foreach ($dataSets as $dataSet) {
        $data = array_merge($data, $dataSet);
    }


    if ($value !== '') {
        foreach ($data as $idx => $array) {
            if(is_array($array['value'])){
                foreach($array['value'] as $idx2 => $value2){
                    if ((string)$value2 !== $value) {
                        unset($data[$idx]['value'][$idx2]);
                    }
                }
                if(!count($data[$idx]['value'])){
                    unset($data[$idx]);
                }
            } elseif ((string)$array['value'] !== $value) {
                unset($data[$idx]);
            }
        }
    }
    if ($environment !== '') {
        foreach ($data as $idx => $array) {
            if ($array['environment'] !== $environment) {
                unset($data[$idx]);
            }
        }
    }
    return $data;
}
