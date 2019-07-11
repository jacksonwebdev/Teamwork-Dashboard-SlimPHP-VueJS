<?php

namespace App\Controller\Teamwork;

use Slim\Http\Request;
use Slim\Http\Response;

use \App\Controller\TeamworkController;
use \App\Controller\Utility\VarDumpController as VarDump;
use \App\Controller\Utility\TimeController as Time;

use TeamWorkPm;

/**
 * @property \Awurth\SlimValidation\Validator validator
 * @property \Cartalyst\Sentinel\Sentinel     auth
 */
class TeamworkBillableHoursController extends TeamworkController
{
    /**
     * Constructor - inherits Teamwork Controller
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Get Billable Hours
     *
     * @param Request $request
     * @param Response $response
     * @param String $type
     * @param [string] $user_id
     * @return void
     */
    public static function get(Request $request, Response $response, String $type, String $user_id = null )
    {
        $instance = new self();
        if ( is_null( $instance::$twauth ) ) {
            $instance::$twauth = $instance::authenticate();
        }
        
        if ( $instance::$twauth ) {
            $type = $type ?: null;
            try {
                $response = $instance::getTotalBillableHoursByCategory( $type );
                $instance::respond( $response );

            } catch (Exception $e) {
                print_r($e);
            }
        }

    }

    /**
     * Get total billable hours by Project Category
     *
     * @param String $catSlug
     * @param Date $fromDate
     * @param Date $toDate
     * @return void
     */
    public static function getTotalBillableHoursByCategory( String $catSlug, Date $fromDate = null, Date $toDate = null )
    {

        $fromDate = ( !is_null( $fromDate ) ) ? $fromDate : date("Ym01");
        $toDate = ( !is_null( $toDate ) ) ? $toDate : date("Ymt");

        $types = array(
            'woo' => 18735,
            'magento' => 18736,
            'web_app' => 18737
        );

        $id = null;
        if ( isset( $types[ $catSlug ] ) ) {
            $id = $types[ $catSlug ];
        }
        
        if ( !is_null( $id ) ) {

            $project_params = [
                "catId" => $id
            ];

            $projects = TeamWorkPm\Factory::build('project')->getAll($project_params);

            $time_entries = [];

            foreach ($projects as $project) {

                $time_entry = self::getTotalBillableDecimalHours($fromDate,$toDate,$userId = null,$projectId = $project['id']);
                $time_entries[] = $time_entry;
                $company_info["company_info"][$project["company"]["id"]] = [
                    "billable_hours" => $time_entry,
                    "company_name" => $project["company"]["name"],
                    "company_logo" => $project["logo"],
                    "company_id" => $project["company"]["id"]
                ];
            }

            $company_info["total_billable_time"] = array_sum($time_entries);

        }
        else {
            $company_info = array();
        }

        return $company_info;
    }


    /**
     * Get Total Billable Decimal Hours
     *
     * @param Date $from
     * @param Date $toDate
     * @param String $userId
     * @param String $projectId
     * @return void
     */
    public static function getTotalBillableDecimalHours( Date $fromDate, Date $toDate, String $userId = null, String $projectId = NULL)
    {
        $time_entry_params = [
            "fromDate" => $fromDate,
            "fromTime" => "00:00",
            "toDate" => $toDate,
            "toTime" => "24:00",
            "userId" => $userId,
            "page" => 1,
            "pageSize" => 500,
            "projectId" => $projectId,
            "billableType" => "billable",
            "status" => "active"

        ];

        $total_decimal_time = 0;
        $time_entries_count = 0;
        $i = 1;

        do {
            $time_entry_params['page'] = $i;
            $time_entries = TeamWorkPm\Factory::build('time')->getAll($time_entry_params);
            $time_entries_count = count($time_entries);

            foreach ($time_entries as $time_entry) {
                $total_decimal_time += Time::decimalHours($time_entry->hours.':'.$time_entry->minutes);
            }

            $total_decimal_time = number_format((float)$total_decimal_time, 2, '.', '');

            $i++;
        } while ($time_entries_count > 499);

        return $total_decimal_time;

    }

}
