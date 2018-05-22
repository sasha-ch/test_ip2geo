<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use GeoIp2\Database\Reader;

/**
 * Class GeoIpController
 *
 * @author sasha-ch <o-n-i-x@ya.ru>
 * Date: 22.05.18
 */
class GeoIpController extends Controller
{

    /**
     * Get location info by ip
     *
     * @param string $ip IP address
     *
     * @return array|null Info
     */
    public function actionIndex($ip)
    {

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \yii\base\InvalidArgumentException("ip $ip format invalid");
        }

        $cache = Yii::$app->cache;

        $data = $cache->get($ip);

        if ($data === false) {

            $reader = new Reader(Yii::$app->basePath.Yii::$app->params['geoCityDb']);
            
            try {
                $record = $reader->city($ip);
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 404;

                return null;
            }

            $data = [
                'country' => $record->country->name,
                'city' => $record->city->name,
                'lat' => $record->location->latitude,
                'long' => $record->location->longitude,
            ];

            $cache->set($ip, $data, Yii::$app->params['cacheTTL']);
        }

        return $data;
    }

}
