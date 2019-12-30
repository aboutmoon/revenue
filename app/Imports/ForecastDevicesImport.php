<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\Location;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\ForecastDevice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ForecastDevicesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        // maybe there are some missing
        $odm = Account::firstOrCreate(['name' => 'ODM', 'level_type' => 'Category', 'parent_id' => 1]);
        $oem = Account::firstOrCreate(['name' => 'OEM', 'level_type' => 'Category', 'parent_id' => 1]);
        $carrier = Account::firstOrCreate(['name' => 'Carrier', 'level_type' => 'Category', 'parent_id' => 1]);

        $oems = Account::where('parent_id', $oem->id)->get()->keyBy('name');
        $odms = Account::where('parent_id', $odm->id)->get()->keyBy('name');
        $carriers = Account::where('parent_id', $carrier->id)->get()->keyBy('name');

        $insertData = [];
        foreach ($collection as $index => $row) {

            $product = [];

            if ($row['oem']) {

                if ($oems[$row['oem']]) {
                    $product['oem_id'] = $oems[$row['oem']]->id;
                } else {
                    Log::info('['. $index .']' . 'oem not exist' . $row['oem']);
                    continue;
                }
            } else {
                $product['oem_id'] = 0;
            }

            if ($row['odm']) {
                if ($odms[$row['odm']]) {
                    $product['odm_id'] = $odms[$row['odm']]->id;
                } else {
                    Log::info('['. $index .']' . 'odm not exist' . $row['odm']);
                    continue;
                }
            } else {
                $product['odm_id'] = 0;
            }

            if ($row['carrier']) {
                if ($carriers[$row['carrier']]) {
                    $product['carrier_id'] = $carriers[$row['carrier']]->id;
                } else {
                    Log::info('['. $index .']' . 'carrier_id not exist' . $row['carrier']);
                    continue;
                }
            } else {
                $product['carrier_id'] = 0;
            }



            $product['type'] = $row['type']? $row['type']: '';
            $product['brand'] = $row['brand']? $row['brand']: '';
            $product['confidence'] = $row['confidence']? $row['confidence']: '';
//            $product['licensee'] = $row['licensee']? $row['licensee']: '';
//            $product['connectivity'] = $row['connectivity']? $row['connectivity']: '';

            $project = Project::firstOrCreate($product);

            if ($project->wasRecentlyCreated) {
                Log::info('['. $index .']' . 'project not exist, created' . $row['country']);
            }


            $market = Location::where('name', $row['market'])->where('level_type', 'Market')->first();
            $location = Location::where('name', $row['country'])->where('level_type', 'country')->where('parent_id', $market->id)->where('region', $row['region'])->first();
            if (!$location){
                Log::info('['. $index .']' . 'Location not exist, created' . $row['country']);
                continue;
            }

            ForecastDevice::create([
                'location_id' => $location->id,
                'market_id' => $location->parent->id,
                'project_id' => $project->id,
                'date' => $row['month'],
                'quantity' => $row['shipment'],
                'confidence' => $row['confidence']
            ]);
        }
    }
//    public function collection(Collection $collection)
//    {
//
//        // maybe there are some missing
//        $odm = Account::firstOrCreate(['name' => 'ODM', 'level_type' => 'Category', 'parent_id' => 1]);
//        $oem = Account::firstOrCreate(['name' => 'OEM', 'level_type' => 'Category', 'parent_id' => 1]);
//        $carrier = Account::firstOrCreate(['name' => 'Carrier', 'level_type' => 'Category', 'parent_id' => 1]);
//
//        $oems = Account::where('parent_id', $oem->id)->get()->keyBy('name');
//        $odms = Account::where('parent_id', $odm->id)->get()->keyBy('name');
//        $carriers = Account::where('parent_id', $carrier->id)->get()->keyBy('name');
//
//        foreach ($collection as $index => $row) {
//
//            $product = [];
//
//            if ($row['oem']) {
//
//                if ($oems[$row['oem']]) {
//                    $product['oem_id'] = $oems[$row['oem']]->id;
//                } else {
//                    Log::info('['. $index .']' . 'oem not exist' . $row['oem']);
//                    continue;
//                }
//            } else {
//                $product['oem_id'] = 0;
//            }
//
//            if ($row['odm']) {
//                if ($odms[$row['odm']]) {
//                    $product['odm_id'] = $odms[$row['odm']]->id;
//                } else {
//                    Log::info('['. $index .']' . 'odm not exist' . $row['odm']);
//                    continue;
//                }
//            } else {
//                $product['odm_id'] = 0;
//            }
//
//            if ($row['carrier']) {
//                if ($carriers[$row['carrier']]) {
//                    $product['carrier_id'] = $carriers[$row['carrier']]->id;
//                } else {
//                    Log::info('['. $index .']' . 'carrier_id not exist' . $row['carrier']);
//                    continue;
//                }
//            } else {
//                $product['carrier_id'] = 0;
//            }
//
//
//
//            $product['type'] = $row['type']? $row['type']: '';
//            $product['brand'] = $row['brand']? $row['brand']: '';
////            $product['licensee'] = $row['licensee']? $row['licensee']: '';
////            $product['connectivity'] = $row['connectivity']? $row['connectivity']: '';
//
//            $project = Project::firstOrCreate($product);
//
//            if ($project->wasRecentlyCreated) {
//                Log::info('['. $index .']' . 'project not exist, created' . $row['country']);
//            }
//
//            $location = Location::where('level_type', 'Country')->where('name', $row['country'])->first();
//            if (!$location){
//                Log::info('['. $index .']' . 'Location not exist, created' . $row['country']);
//                continue;
//            }
//
//            $keys = array_keys($row->all());
//
//            $dates = array_filter($keys, function ($value){
//                    if (preg_match('/^\d{4}_(q1|q2|q3|q4){1}/', $value)) {
//                        return true;
//                    } else {
//                        return false;
//                    }
//                }
//            );
//
//
//            foreach ($dates as $date) {
//                [$y, $q] = preg_split('/_/', $date);
//                $d = [];
//                switch ($q){
//                    case 'q1':
//                        $df = $y . '-' . 1 . '-1';
//                        $dt = $y . '-' . 3 . '-1';
//                        break;
//                    case 'q2':
//                        $df = $y . '-' . 4 . '-1';
//                        $dt = $y . '-' . 6 . '-1';
//                        break;
//                    case 'q3':
//                        $df = $y . '-' . 7 . '-1';
//                        $dt = $y . '-' . 9 . '-1';
//                        break;
//                    case 'q4':
//                        $df = $y . '-' . 10 . '-1';
//                        $dt = $y . '-' . 12 . '-1';
//                        break;
//                }
//
//                $date_from = Carbon::parse($df);
//                $date_to = Carbon::parse($dt);
//                $count = ($date_to->year - $date_from->year) * 12 + $date_to->month - $date_from->month + 1;
//
//                $d['confidence'] = $row['confidence']? $row['confidence']: 0;
//                $d['quantity'] = trim($row[$date])?$row[$date] / $count : 0;
//
//                while ($date_from->lte($date_to)) {
//                    $d['date'] = $date_from->$forecastDevice = [
//                        'model_id' => 1,
//                        'model_vid' => 1,
//                        'project_id' => $project->id,
//                        'location_id' => $location->id,
//                        'market_id' => $location->parent->id,
//                    ];toDateString();
//
//                    $result = ForecastDevice::firstOrCreate(array_merge($forecastDevice, $d));
//                    if ($result->wasRecentlyCreated) {
////                    Log::info(print_r(array_merge($forecastDevice, $d), true));
////                    Log::info('['. $index .'] create success.');
//                    } else {
//                        Log::info(print_r(array_merge($forecastDevice, $d), true));
//                        Log::info('['. $index .'] duplicate.');
//                    }
//
//                    $date_from->addMonth();
//                }
//
//
//            }
//
//        }
//    }

}
