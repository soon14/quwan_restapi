<?php

namespace App\Repository;


class LbsRepository extends BaseRepository
{

    public function range($u_lat, $u_lon, $list)
    {
        /*
        *u_lat 用户纬度
        *u_lon 用户经度
        *list sql语句
        */
        if (!empty($u_lat) && !empty($u_lon))
        {
            foreach ($list as $row)
            {
                $row['distance'] = $this->nearbyDistance($u_lat, $u_lon, $row['lat'], $row['lon']);
                $row['distance'] = round($row['distance']);
                $res[]     = $row;
            }

            if (!empty($res))
            {
                foreach ($res as $user)
                {
                    $ages[] = $user['distance'];
                }
                array_multisort($ages, SORT_ASC, $res);

                return $res;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    //计算经纬度两点之间的距离
    public function nearbyDistance($lat1, $lon1, $lat2, $lon2)
    {
        // $EARTH_RADIUS = 6378.137;
        // $radLat1      = $this->rad($lat1);
        // $radLat2      = $this->rad($lat2);
        // $a            = $radLat1 - $radLat2;
        // $b            = $this->rad($lon1) - $this->rad($lon2);
        // $s            = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        // $s1           = $s * $EARTH_RADIUS;
        // $s2           = round($s1 * 10000) / 10000;
        //
        // return $s2;

        $dx = $lon1 - $lon2;
        $dy = $lat1 - $lat2;
        $b = ($lat1 + $lat2) / 2;
        $lx = 6367000.0 * deg2rad($dx) * cos(deg2rad($b));
        $ly = 6367000.0 * deg2rad($dy);
        return sqrt($lx * $lx + $ly * $ly);


        //print_r($s2);
    }

    private function rad($d)
    {
        return $d * 3.1415926535898 / 180.0;
    }

}
