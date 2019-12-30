<?php

use Illuminate\Database\Seeder;
use App\Models\ForecastItem;
use App\Models\ForecastItemItem;
use App\Models\ForecastItemAccount;
use App\Models\ForecastItemLocation;
use App\Models\ForecastCriteria;
use App\Models\ForecastCriteriaLocation;
use App\Models\ForecastCriteriaParameter;
//$table->bigIncrements('id');
//$table->bigInteger('model_id');
//$table->bigInteger('model_vid');
//$table->dateTime('date_from');
//$t17-01-01dateTime('date_to');
//$table->decimal('coverage', 24, 8);
//$table->timestamps();
class ForecastItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $markets = \App\Models\Location::where('level_type', 'Market')->get()->keyBy('name');
        $global = $markets['Global']->id;
        $emerging = $markets['Emerging Markets']->id;
        $europe = $markets['Europe/Russia']->id;
        $america = $markets['North America']->id;
        $india = $markets['India']->id;

        //shipment
        $this->shipment($global, $emerging, $europe, $america, $india);

        //install base
        $this->install_base($global, $emerging, $europe, $america, $india);

        //active_device
        $this->active_device($global, $emerging, $europe, $america, $india);

        //mau
        $this->mau($global, $emerging, $europe, $america, $india);

        //ads mau
        $this->ads_mau($global, $emerging, $europe, $america, $india);

        //fota fee
        $this->fota_fee($global, $emerging, $europe, $america, $india);

        //search_revenue_sharing
        $this->search_revenue_sharing($global, $emerging, $europe, $america, $india);

        //ads revenue sharing
        $this->ads_revenue_sharing($global, $emerging, $europe, $america, $india);
    }

    public function fota_fee($global, $emerging, $europe, $america, $india) {
        $id = 8;

        $fota_fee = 8;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $fota_fee, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function ads_revenue_sharing($global, $emerging, $europe, $america, $india) {
        $id = 11;

        $monthly_page_view = 11;
        $ecpm = 12;
        $ads_revenue_per_1k_ads_dau = 13;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 2.64, 'monthly_growth' => 0.17,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 4.70, 'monthly_growth' => 0.18,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.1, 'monthly_growth' => 0.9,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.15, 'monthly_growth' => 0.05,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 5.80, 'monthly_growth' => 0.18,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);


    }

    public function search_revenue_sharing($global, $emerging, $europe, $america, $india) {
        $id = 10;

        $onekPerMAU = 10;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 2.64, 'monthly_growth' => 0.17,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 4.70, 'monthly_growth' => 0.18,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 6.11, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function ads_mau($global, $emerging, $europe, $america, $india) {
        $id = 6;

        $mauToAdsDauRatio = 7;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.0193646, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.0193646, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.46, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.0193646, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.025, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

    }

    public function mau($global, $emerging, $europe, $america, $india) {
        $id = 5;

        $initialMAURatio = 5;
        $mauGrowthFactor = 6;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.465907381962302, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.46, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.405, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.40, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 1, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 1, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.465907381962302, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.67, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.408, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.41, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function active_device($global, $emerging, $europe, $america, $india) {
        $id = 4;

        $activationRation = 4;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.561709826880253, 'monthly_growth' => 0.01,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.38796594886216, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.85, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.561709826880253, 'monthly_growth' => 0.01,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.23, 'monthly_growth' => 0.012,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function install_base($global, $emerging, $europe, $america, $india) {
        $installBaseItem = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);
        ForecastItemItem::create(['id' => $installBaseItem->id, 'item_id' => 3]);
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $india]); // India

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.024, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 30, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.03, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 24, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.02, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 36, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.03, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 24, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.03, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 24, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

    }

    public function shipment($global, $emerging, $europe, $america, $india) {
        $shipmentItem = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','oem_id' => null, 'odm_id' => null, 'carrier_id' => null , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $shipmentItem->id, 'item_id' => 2]);

        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $india]); // India

        $shipmentCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 2,'oem_id' => null, 'odm_id' => null, 'carrier_id' => null]);
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $global]); // Global
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $europe]); // Europe/Russia
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $america]); // North America
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $india]); // India

        ForecastCriteriaParameter::create(['forecast_criteria_id' => $shipmentCriteria->id, 'criteria_id' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01', 'value' => 1, 'monthly_growth' => 0]);

    }
}
