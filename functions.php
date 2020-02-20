<?php
//ALIBABA API
//JSON_ENCODE GETS  AN ARRAY AND ENCODES IT INTO JSON FORMAT AND JSON_DECODES DOES THE  OPPOSITE
//$phonebook = json_decode(file_get_contents("phonebook.json"));
//file_get_contents gets values as string from file
//json_decode converts to array
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
function feedback($success = false, $message = [], $result = [])
{
    $response = [
        "statuscode" => $success,
        "data" => $message,
        "message" => $result,
    ];

    echo json_encode($response);
}

function generateUrl()
{
    //API CALL TO ALIBABA

// Download：https://github.com/aliyun/openapi-sdk-php
// Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md

AlibabaCloud::accessKeyClient('LTAI4FthQdW99VGCefrVdHgW', '6dp7tHtTxWDQAi6N3nY8NBbexiyqpC')
                        ->regionId('cn-hangzhou')
                        ->asDefaultClient();

try {
    $result = AlibabaCloud::rpc()
                          ->product('live')
                          // ->scheme('https') // https | http
                          ->version('2016-11-01')
                          ->action('ResumeLiveStream')
                          ->method('POST')
                          ->host('live.aliyuncs.com')
                          ->options([
                                        'query' => [
                                          'RegionId' => "cn-hangzhou",
                                          'LiveStreamType' => "publisher",
                                          'AppName' => "kols",
                                          'StreamName' => "kolid111",
                                          'DomainName' => "ingest.producekolinjeststream.com",
                                        ],
                                    ])
                          ->request();
    print_r($result->toArray());
} catch (ClientException $e) {
    echo $e->getErrorMessage() . PHP_EOL;
} catch (ServerException $e) {
    echo $e->getErrorMessage() . PHP_EOL;
}
    //Save response

    //API CALL TO kols node instance
    echo feedback(true,[],$result);
}
