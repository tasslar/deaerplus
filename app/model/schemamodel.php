<?php
namespace App\model;
use DB;
use Config;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class schemamodel extends Model
{
    public function __construct()
    {
        Config::set('database.connections.dmsmysql.database', session::get('dealer_schema_name'));
         
    }

    public static function schema_generation($dealerschemaname)
    {

        $password = Hash::make('secret');
        //$username = $register_users[0]->dealer_name;
        $user_password = substr($password, 15, 8);  
        //$db_name = 'dmschema_'.$register_value->dealer_name;
        //$db_name = $register_users[0]->dealer_schema_name;
        $db_name = $dealerschemaname;
        DB::statement('CREATE USER '.$db_name.'@"localhost" IDENTIFIED BY "'.$user_password.'";');
        //DB::statement('CREATE USER "mytest"@"localhost" IDENTIFIED BY "123456";');
        DB::statement('create database '.$db_name.';');

        DB::statement('CREATE TABLE '.$db_name.'.`contact_documents_table` (
                         `auto_id` int(11) NOT NULL AUTO_INCREMENT,
                         `id` int(11) NOT NULL,
                         `file_name` varchar(100) NOT NULL,
                         `file_url` text NOT NULL,
                         PRIMARY KEY (`auto_id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.contact_documents_table TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_agents` (
        `dealer_id` int(11) NOT NULL AUTO_INCREMENT,
        `agent_id` int(11) NOT NULL,
        `agent_name` varchar(50) NOT NULL,
        `agent_phone_number` tinyint(15) NOT NULL,
        `agent_phone_number_1` tinyint(15) NOT NULL,
        `agent_phone_number_2` tinyint(15) NOT NULL,
        `address` text NOT NULL,
        `status` enum("Active","Inactive") NOT NULL,
        PRIMARY KEY (`dealer_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_agents TO '.$db_name.'@"localhost";');

        DB::statement(' CREATE TABLE '.$db_name.'.`dealer_alert_history` (
        `alertid` int(11) NOT NULL AUTO_INCREMENT,
        `alert_type` varchar(100) DEFAULT NULL,
        `alert_listingid` varchar(50) NOT NULL,
        `alert_user_id` int(50) NOT NULL,
        `alert_make` varchar(100) DEFAULT NULL,
        `alert_model` varchar(100) DEFAULT NULL,
        `alert_variant` varchar(100) DEFAULT NULL,
        `alert_year` int(10) DEFAULT NULL,
        `alert_fueltype` varchar(100) DEFAULT NULL,
        `alert_city` varchar(100) DEFAULT NULL,
        `alert_price` decimal(13,2) DEFAULT NULL,
        `alert_status` int(11) NOT NULL DEFAULT "0",
        `alert_usermailid` varchar(150) NOT NULL,
        `alert_mobileno` varchar(50) NOT NULL,
        `alert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `alert_source_dealer_id` int(50) DEFAULT NULL,
        `alert_email_status` int(11) NOT NULL DEFAULT "1",
        `alert_sms_status` int(11) NOT NULL DEFAULT "1",
        PRIMARY KEY (`alertid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_alert_history TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_bidding_details` (
        `thread_id` int(11) NOT NULL AUTO_INCREMENT,
        `ticket_id` varchar(25) NOT NULL,
        `dealer_id` varchar(25) NOT NULL,
        `car_id` varchar(100) NOT NULL,
        `bidded_amount` decimal(13,2) NOT NULL,
        `user_id` varchar(25) NOT NULL,
        `created_date` datetime NOT NULL,
        `delear_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`thread_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_bidding_details TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_cars_pricing` (
        `pricing_id` int(11) NOT NULL AUTO_INCREMENT,
        `listing_id` int(11) NOT NULL,
        `pricing_primary_id` varchar(100) DEFAULT NULL,
        `ownpurchase_date` date DEFAULT NULL,
        `ownpurchased_from` varchar(255) DEFAULT NULL,
        `ownreceived_from_name` varchar(255) DEFAULT NULL,
        `ownpurchased_price` decimal(30,2) DEFAULT NULL,
        `ownkey_received` tinyint(20) DEFAULT NULL,
        `owndocuments_received` tinyint(5) DEFAULT NULL,
        `inventory_type` varchar(255) NOT NULL,
        `test_drive` tinyint(4) DEFAULT NULL,
        `testdrive_dealerpoint` tinyint(4) DEFAULT NULL,
        `testdrive_doorstep` tinyint(4) DEFAULT NULL,
        `markup_condition` varchar(50) NOT NULL,
        `markup_percentage` decimal(30,2) DEFAULT NULL,
        `markup_value` decimal(30,2) DEFAULT NULL,
        `saleprice` decimal(30,2) NOT NULL,
        `user_id` int(50) NOT NULL,
        `purchase_date` date DEFAULT NULL,
        `starting_kms` int(11) DEFAULT NULL,
        `received_from_own` varchar(255) DEFAULT NULL,
        `received_from_name` varchar(255) DEFAULT NULL,
        `fuel_indication` int(11) DEFAULT NULL,
        `fuel_capacity` int(11) DEFAULT NULL,
        `customer_asking_price` int(11) DEFAULT NULL,
        `dealer_markup_price` int(11) DEFAULT NULL,
        `keys_available` int(11) DEFAULT NULL,
        `documents_received` int(11) DEFAULT NULL,
        `lastupdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `createddatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `status` enum("Active","Inactive") NOT NULL DEFAULT "Active",
        PRIMARY KEY (`pricing_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_cars_pricing TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_car_expenses` (
        `expense_id` int(11) NOT NULL AUTO_INCREMENT,
        `car_id` int(11) NOT NULL,
        `car_primary_id` varchar(100) NOT NULL,
        `expense_desc` text,
        `expense_amount` int(255) DEFAULT NULL,
        `status` enum("Active","Inactive") NOT NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`expense_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_car_expenses TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_contact_document_management` (
        `dealer_document_management_id` int(11) NOT NULL AUTO_INCREMENT,
        `contact_management_id` int(11) DEFAULT NULL,
        `document_id_type` varchar(255) DEFAULT NULL,
        `document_id_number` varchar(255) DEFAULT NULL,
        `document_dob` date DEFAULT NULL,
        `doc_link_fullpath` text,
        `dealer_document_status` enum("active","inactive") NOT NULL DEFAULT "active",
        `document_name` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`dealer_document_management_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_contact_document_management TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_contact_management` (
        `contact_management_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) DEFAULT NULL,
        `branch_id` int(11) DEFAULT NULL,
        `contact_type_id` int(11) DEFAULT NULL,
        `contact_owner` varchar(255) DEFAULT NULL,
        `contact_first_name` varchar(255) DEFAULT NULL,
        `contact_last_name` varchar(255) DEFAULT NULL,
        `contact_designation` varchar(255) DEFAULT NULL,
        `contact_gender` enum("male","female") DEFAULT NULL,
        `contact_lead_source` varchar(255) DEFAULT NULL,
        `contact_email_opt_out` tinyint(1) NOT NULL DEFAULT "0",
        `contact_sms_opt_out` tinyint(1) NOT NULL DEFAULT "0",
        `contact_phone_1` varchar(255) DEFAULT NULL,
        `contact_phone_2` varchar(255) DEFAULT NULL,
        `contact_phone_3` varchar(255) DEFAULT NULL,
        `contact_email_1` varchar(255) DEFAULT NULL,
        `contact_email_2` varchar(255) DEFAULT NULL,
        `contact_mailing_address` varchar(255) DEFAULT NULL,
        `contact_mailing_locality` varchar(255) DEFAULT NULL,
        `contact_mailing_city` varchar(255) DEFAULT NULL,
        `contact_mailing_pincode` varchar(255) DEFAULT NULL,
        `contact_other_address` varchar(255) DEFAULT NULL,
        `contact_other_locality` varchar(255) DEFAULT NULL,
        `contact_other_city` varchar(255) DEFAULT NULL,
        `contact_other_pincode` int(11) DEFAULT NULL,
        `user_image` varchar(255) NOT NULL,
        `contact_business_name` varchar(255) NOT NULL,
        `contact_status` enum("active","inactive") DEFAULT "active",
        `pan_number` varchar(50) DEFAULT NULL,
        `employee_information_type` enum("Business","Employee") DEFAULT NULL,
        `business_type` varchar(45) DEFAULT NULL,
        `salary_per_month` decimal(15,2) DEFAULT NULL,
        `employeetype` int(11) DEFAULT NULL,
        PRIMARY KEY (`contact_management_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_contact_management TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_contact_message_transactions` (
        `thread_id` int(11) NOT NULL AUTO_INCREMENT,
        `contact_transactioncode` varchar(255) NOT NULL,
        `from_dealer_id` int(11) NOT NULL,
        `to_dealer_id` int(11) NOT NULL,
        `car_id` varchar(100) NOT NULL,
        `title` varchar(100) NOT NULL,
        `dealer_name` varchar(100) NOT NULL,
        `dealer_email` varchar(255) NOT NULL,
        `mobile` int(50) NOT NULL,
        `message` text NOT NULL,
        `status` int(11) NOT NULL DEFAULT "0",
        `user_id` int(11) NOT NULL,
        `document_link` int(11) NOT NULL,
        `delear_datetime` datetime NOT NULL,
        PRIMARY KEY (`thread_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_contact_message_transactions TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_customerloan_details` (
        `thread_id` int(11) NOT NULL AUTO_INCREMENT,
        `ticket_id` varchar(25) NOT NULL,
        `customername` varchar(255) NOT NULL,
        `customercontactno` varchar(15) DEFAULT NULL,
        `customermobileno` varchar(50) NOT NULL,
        `customerpannumber` varchar(20) DEFAULT NULL,
        `customermailid` varchar(255) NOT NULL,
        `customercity` varchar(255) NOT NULL,
        `customerarea` varchar(255) NOT NULL,
        `requested_amount` decimal(13,2) NOT NULL,
        `status` int(5) DEFAULT "0",
        `user_id` varchar(25) NOT NULL,
        `created_date` date NOT NULL,
        `delear_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`thread_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_customerloan_details TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_documents_table` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `file_name` varchar(100) NOT NULL,
        `file_type` varchar(150) DEFAULT NULL,
        `file_url` text NOT NULL,
        `file_id` int(11) NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_documents_table TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_email_history` (
        `email_history_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `contact_id` int(11) NOT NULL,
        `dealer_email_temp_id` int(11) NOT NULL,
        `sentto_email_id` blob NOT NULL,
        `title` char(30) NOT NULL,
        `message` longtext NOT NULL,
        `transaction_date` datetime DEFAULT NULL,
        `bulk_mailer_count` int(10) NOT NULL DEFAULT "1",
        `sent_status` enum("true","false") DEFAULT NULL,
        `status` enum("Active","Inactive") NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`email_history_id`),
        UNIQUE KEY `transaction_id` (`email_history_id`),
        KEY `transaction_id_2` (`email_history_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_email_history TO '.$db_name.'@"localhost";');

        DB::statement(' CREATE TABLE '.$db_name.'.`dealer_email_template_managment` (
        `email_temp_id` int(11) NOT NULL AUTO_INCREMENT,
        `email_code` varchar(50) NOT NULL,
        `email_subject` text NOT NULL,
        `email_message` text NOT NULL,
        `status` int(11) NOT NULL DEFAULT "0",
        `can_remove` varchar(1) NOT NULL DEFAULT "N",
        `dealer_id` int(11) NOT NULL,
        `branch_id` int(11) NOT NULL,
        PRIMARY KEY (`email_temp_id`),
        UNIQUE KEY `email_code` (`email_code`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_email_template_managment TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_employee_document_management` (
        `dealer_employee_doc_mgmt_id` int(11) NOT NULL AUTO_INCREMENT,
        `employee_management_id` int(11) DEFAULT NULL,
        `employee_document_id_type` varchar(255) DEFAULT NULL,
        `employee_document_id_number` varchar(255) DEFAULT NULL,
        `employee_doc_url` text,
        `employee_document_dob` date DEFAULT NULL,
        `employee_document_status` enum("Active","Inactive") NOT NULL DEFAULT "Active",
        `employee_document_name` varchar(200) DEFAULT NULL,
        PRIMARY KEY (`dealer_employee_doc_mgmt_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_employee_document_management TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_employee_management` (
        `employee_management_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) DEFAULT NULL,
        `branch_id` int(11) DEFAULT NULL,
        `employee_type` int(11) DEFAULT NULL,
        `employee_first_name` varchar(255) DEFAULT NULL,
        `employee_last_name` varchar(255) DEFAULT NULL,
        `employee_designation` varchar(255) DEFAULT NULL,
        `employee_gender` enum("male","female") NOT NULL DEFAULT "male",
        `employee_moblie_no` varchar(255) DEFAULT NULL,
        `employee_landline_no` varchar(255) DEFAULT NULL,
        `employee_email_1` varchar(255) DEFAULT NULL,
        `employee_email_2` varchar(255) DEFAULT NULL,
        `employee_mailing_address` varchar(255) DEFAULT NULL,
        `employee_mailing_locality` varchar(255) DEFAULT NULL,
        `employee_city` varchar(255) DEFAULT NULL,
        `employee_state` varchar(255) DEFAULT NULL,
        `employee_mailing_pincode` varchar(255) DEFAULT NULL,
        `employee_business_name` varchar(255) DEFAULT NULL,
        `employee_user_image` varchar(255) DEFAULT NULL,
        `employee_status` enum("active","deactive") NOT NULL DEFAULT "active",
        PRIMARY KEY (`employee_management_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_employee_management TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_funding_details` (
        `thread_id` int(11) NOT NULL AUTO_INCREMENT,
        `ticket_id` varchar(25) NOT NULL,
        `dealershipname` varchar(255) NOT NULL,
        `dealername` varchar(255) NOT NULL,
        `dealermobileno` int(50) NOT NULL,
        `dealermailid` varchar(255) NOT NULL,
        `dealercity` varchar(255) NOT NULL,
        `dealerarea` varchar(255) NOT NULL,
        `requested_amount` decimal(13,2) NOT NULL,
        `user_id` varchar(25) NOT NULL,
        `created_date` date NOT NULL,
        `status` int(11) NOT NULL DEFAULT "0",
        `delear_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`thread_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_funding_details TO '.$db_name.'@"localhost";');


        DB::statement('CREATE TABLE '.$db_name.'.`dealer_listing_details` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `inventory_id` int(11) NOT NULL,
        `listing_id` varchar(255) NOT NULL,
        `listing_site` varchar(255) NOT NULL,
        `listing_status` varchar(50) NOT NULL,
        `user_id` int(11) NOT NULL,
        `createddate` date NOT NULL,
        `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_listing_details TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_listing_features` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `listing_id` varchar(100) NOT NULL,
        `overviewdescription` varchar(255) NOT NULL,
        `gear_box` varchar(255) NOT NULL,
        `drive_type` varchar(255) NOT NULL,
        `seating_capacity` varchar(255) NOT NULL,
        `steering_type` varchar(255) NOT NULL,
        `turning_radius` varchar(255) NOT NULL,
        `top_speed` varchar(255) NOT NULL,
        `acceleration` int(255) NOT NULL,
        `tyre_type` varchar(255) NOT NULL,
        `no_of_doors` varchar(255) NOT NULL,
        `engine_type` varchar(255) NOT NULL,
        `displacement` varchar(255) NOT NULL,
        `max_power` varchar(255) NOT NULL,
        `max_torque` varchar(255) NOT NULL,
        `no_of_cylinder` varchar(255) NOT NULL,
        `valves_per_cylinder` varchar(255) NOT NULL,
        `valve_configuration` varchar(255) NOT NULL,
        `fuel_supply_system` varchar(255) NOT NULL,
        `turbo_charger` varchar(255) NOT NULL,
        `super_charger` varchar(255) NOT NULL,
        `length` varchar(255) NOT NULL,
        `width` varchar(255) NOT NULL,
        `height` varchar(255) NOT NULL,
        `wheel_base` varchar(255) NOT NULL,
        `gross_weight` varchar(255) NOT NULL,
        `air_conditioner` tinyint(5) NOT NULL,
        `adjustable_steering` tinyint(5) NOT NULL,
        `leather_steering_wheel` tinyint(5) NOT NULL,
        `heater` tinyint(5) NOT NULL,
        `digital_clock` tinyint(5) NOT NULL,
        `power_steering` tinyint(5) NOT NULL,
        `power_windows_front` tinyint(5) NOT NULL,
        `power_windows_rear` tinyint(5) NOT NULL,
        `remote_trunk_opener` tinyint(5) NOT NULL,
        `remote_fuel_lid_opener` tinyint(5) NOT NULL,
        `low_fuel_warning_light` tinyint(5) NOT NULL,
        `rear_reading_lamp` tinyint(5) NOT NULL,
        `rear_seat_headrest` tinyint(5) NOT NULL,
        `rear_seat_centre_arm_rest` tinyint(5) NOT NULL,
        `height_adjustable_front_seat_belts` tinyint(5) NOT NULL,
        `cup_holders_front` tinyint(5) NOT NULL,
        `cup_holders_rear` tinyint(5) NOT NULL,
        `rear_ac_vents` tinyint(5) NOT NULL,
        `parking_sensors` tinyint(5) NOT NULL,
        `anti_lock_braking_system` tinyint(5) NOT NULL,
        `central_locking` tinyint(5) NOT NULL,
        `child_safety_lock` tinyint(5) NOT NULL,
        `driver_airbags` tinyint(5) NOT NULL,
        `passenger_airbag` tinyint(5) NOT NULL,
        `rear_seat_belts` tinyint(5) NOT NULL,
        `seat_belt_warning` tinyint(5) NOT NULL,
        `adjustable_seats` tinyint(5) NOT NULL,
        `crash_sensor` tinyint(5) NOT NULL,
        `anti_theft_device` tinyint(5) NOT NULL,
        `immobilizer` tinyint(5) NOT NULL,
        `adjustable_head_lights` tinyint(5) NOT NULL,
        `power_adjustable_exterior_rear_view_mirror` tinyint(5) NOT NULL,
        `electric_folding_rear_view_mirror` tinyint(5) NOT NULL,
        `rain_sensing_wipers` tinytext NOT NULL,
        `rear_window_wiper` tinyint(5) NOT NULL,
        `alloy_wheels` tinyint(5) NOT NULL,
        `tinted_glass` tinyint(5) NOT NULL,
        `front_fog_lights` tinyint(5) NOT NULL,
        `rear_window_defogger` tinyint(5) NOT NULL,
        `cdplayer` tinyint(5) NOT NULL,
        `radio` tinyint(5) NOT NULL,
        `audio` tinyint(5) NOT NULL,
        `bluetooth` tinyint(5) NOT NULL,
        `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `status` int(11) NOT NULL,
        `created_date` datetime NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_listing_features TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_online_portal` (
        `online_portal_id` int(11) NOT NULL AUTO_INCREMENT,
        `car_id` int(11) NOT NULL,
        `portal_primary_id` varchar(100) NOT NULL,
        `dealer_id` int(255) NOT NULL,
        `dealer_selection` varchar(50) NOT NULL,
        `auction_price` int(255) NOT NULL,
        `auction_startdate` varchar(50) DEFAULT NULL,
        `auction_end_date` varchar(50) DEFAULT NULL,
        `inviation` varchar(255) DEFAULT NULL,
        `listing_dealer` varchar(255) DEFAULT NULL,
        `listing_olx` varchar(50) DEFAULT NULL,
        `listing_carwale` varchar(50) DEFAULT NULL,
        `listing_cardekho` varchar(50) DEFAULT NULL,
        `listing_quickr` varchar(50) DEFAULT NULL,
        `other_auction_type` varchar(50) DEFAULT NULL,
        `other_min_price` int(255) NOT NULL,
        `other_start_date` varchar(50) NOT NULL,
        `other_end_date` varchar(50) NOT NULL,
        `auctioninviation` varchar(255) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`online_portal_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_online_portal TO '.$db_name.'@"localhost";');

        

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_posting_history` (
        `dealer_posting_history_id` int(11) NOT NULL AUTO_INCREMENT,
        `car_id` int(11) DEFAULT NULL,
        `api_sites_id` int(11) DEFAULT NULL,
        `car_status_id` int(11) DEFAULT NULL,
        `dealer_id` int(11) DEFAULT NULL,
        `user_id` int(11) DEFAULT NULL,
        `listing_info` varchar(45) DEFAULT NULL,
        `sale_price` decimal(30,2) DEFAULT NULL,
        `create_at` datetime NOT NULL,
        `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`dealer_posting_history_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_posting_history TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_sales` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `inventory_id` int(11) NOT NULL,
        `vinno` varchar(100) NOT NULL,
        `registrationno` varchar(100) NOT NULL,
        `purchaseprice` decimal(10,0) NOT NULL,
        `saleprice` decimal(10,0) NOT NULL,
        `saledate` date NOT NULL,
        `salesperson` varchar(255) NOT NULL,
        `purchaser` varchar(255) NOT NULL,
        `status` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `createddate` datetime NOT NULL,
        `lastupdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_sales TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_sales_documents` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `inventory_id` int(11) NOT NULL,
        `sales_id` int(11) NOT NULL,
        `document_no` int(11) NOT NULL,
        `document_name` varchar(255) NOT NULL,
        `filename` varchar(255) NOT NULL,
        `file_path` varchar(255) NOT NULL,
        `user_id` int(11) NOT NULL,
        `status` int(11) NOT NULL,
        `createddate` date NOT NULL,
        `lastupdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_sales_documents TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_saved_carlisting` (
        `saved_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `car_id` varchar(100) NOT NULL,
        `saved_status` int(11) NOT NULL,
        `created_date` datetime NOT NULL,
        PRIMARY KEY (`saved_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_saved_carlisting TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_sms_history` (
        `sms_history_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `contact_id` int(11) NOT NULL,
        `dealer_sms_temp_id` int(11) NOT NULL,
        `sentto_sms_id` blob NOT NULL,
        `title` char(30) NOT NULL,
        `message` longtext NOT NULL,
        `transaction_date` datetime DEFAULT NULL,
        `bulk_mailer_count` int(10) NOT NULL DEFAULT "1",
        `sent_status` enum("true","false") DEFAULT NULL,
        `status` enum("Active","Inactive") NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`sms_history_id`),
        UNIQUE KEY `transaction_id` (`sms_history_id`),
        KEY `transaction_id_2` (`sms_history_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_sms_history TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_system_notifications` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `d_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `notification_type_id` int(11) NOT NULL,
        `notification_type` varchar(20) NOT NULL,
        `title` char(30) NOT NULL,
        `message` text NOT NULL,
        `status` enum("0","1") NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT NULL,
        `contact_transactioncode` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_system_notifications TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_testdrive` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `listing_dealer_id` int(11) NOT NULL,
        `car_id` varchar(100) NOT NULL,
        `test_drive` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        `user_id` int(11) NOT NULL,
        `createddatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_testdrive TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_text_template_managment` (
        `text_temp_id` int(11) NOT NULL AUTO_INCREMENT,
        `text_subject` text NOT NULL,
        `text_message` text NOT NULL,
        `dealer_id` int(11) NOT NULL,
        `branch_id` int(11) NOT NULL,
        PRIMARY KEY (`text_temp_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_text_template_managment TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_viewed_cars` (
        `auto_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `car_id` varchar(100) NOT NULL,
        `recorddatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`auto_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_viewed_cars TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_car_listings` (
        `car_id` int(11) NOT NULL AUTO_INCREMENT,
        `addinventor_id` int(50) NOT NULL,
        `duplicate_id` varchar(255) DEFAULT NULL,
        `inventory_type` varchar(50) DEFAULT NULL,
        `chassis_number` varchar(255) DEFAULT NULL,
        `engine_number` varchar(255) DEFAULT NULL,
        `dealer_id` int(11) DEFAULT NULL,
        `branch_id` int(11) DEFAULT NULL,
        `fuel_type` varchar(50) DEFAULT NULL,
        `category_id` int(11) DEFAULT NULL,
        `variant` char(20) DEFAULT NULL,
        `mileage` varchar(255) DEFAULT NULL,
        `transmission` char(20) DEFAULT NULL,
        `price` decimal(15,2) DEFAULT NULL,
        `body_type` char(20) DEFAULT NULL,
        `colors` char(20) DEFAULT NULL,
        `status` char(20) DEFAULT NULL,
        `registration_number` varchar(255) DEFAULT NULL,
        `registration_year` char(20) DEFAULT NULL,
        `owner_type` enum("FIRST","SECOND","THIRD") DEFAULT NULL,
        `make` char(20) DEFAULT NULL,
        `model_id` varchar(20) DEFAULT NULL,
        `place` char(50) DEFAULT NULL,
        `kms_done` int(11) DEFAULT NULL,
        `car_city` char(20) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` varchar(255) DEFAULT NULL,
        `car_master_status` int(11) NOT NULL DEFAULT "0",
        `funding_applied` enum("0","1") DEFAULT "0",
        `loan_applied` enum("0","1") DEFAULT "0",
        `funding_ticket_number` varchar(250) DEFAULT NULL,
        `funding_parent_ticket` varchar(250) DEFAULT NULL,
        `loan_ticket_number` varchar(250) DEFAULT NULL,
        `mongopushdate` date DEFAULT NULL,
        `mongopush_status` enum("success","failure") DEFAULT "failure",
        PRIMARY KEY (`car_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_car_listings TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_car_listings_documents` (
        `document_id` int(11) NOT NULL AUTO_INCREMENT,
        `inventory_primary_id` varchar(255) NOT NULL,
        `car_id` int(11) NOT NULL,
        `document_number` varchar(50) NOT NULL,
        `document_link` text NOT NULL,
        `folder_path` text NOT NULL,
        `full_folder_path` text NOT NULL,
        `s3_bucket_path` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`document_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_car_listings_documents TO '.$db_name.'@"localhost";');

        DB::statement(' CREATE TABLE '.$db_name.'.`dms_car_listings_photos` (
        `photo_id` int(11) NOT NULL AUTO_INCREMENT,
        `car_id` int(11) NOT NULL,
        `inventry_primary_id` varchar(250) NOT NULL,
        `profile_pic_name` varchar(250) DEFAULT NULL,
        `photo_link` text NOT NULL,
        `photo_link_fullpath` text NOT NULL,
        `folder_path` text NOT NULL,
        `s3_bucket_path` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`photo_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_car_listings_photos TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_car_listings_videos` (
        `video_id` int(11) NOT NULL AUTO_INCREMENT,
        `inventory_primary_id` varchar(255) NOT NULL,
        `car_id` int(11) NOT NULL,
        `video_url` text NOT NULL,
        `video_url_fullpath` varchar(255) NOT NULL,
        `folder_path` text NOT NULL,
        `s3_bucket_path` text NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`video_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_car_listings_videos TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_dealerdetails` (
        `dealers_details_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `d_state` int(11) DEFAULT NULL,
        `d_city` int(11) DEFAULT NULL,
        `logo` varchar(100) NOT NULL,
        `phone` varchar(15) NOT NULL,
        `otherinformation` text,
        `Address` text NOT NULL,
        `pincode` int(6) NOT NULL,
        `latitude` text NOT NULL,
        `longitude` text NOT NULL,
        `dealer_name` varchar(51) DEFAULT NULL,
        `landline_no` varchar(51) DEFAULT NULL,
        `fax_no` varchar(51) DEFAULT NULL,
        `line_of_business` varchar(51) DEFAULT NULL,
        `company_status` varchar(51) DEFAULT NULL,
        `dealership_started` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `dealership_website` varchar(255) DEFAULT NULL,
        `pan_no` varchar(51) DEFAULT NULL,
        `business_domain` varchar(51) DEFAULT NULL,
        `preferences` varchar(51) DEFAULT NULL,
        `facebook_link` blob,
        `twitter_link` blob,
        `linkedin_link` blob,
        `about_us` text,
        `company_logo` varchar(255) DEFAULT NULL,
        `company_cover_img` varchar(255) DEFAULT NULL,
        `company_doc` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`dealers_details_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_dealerdetails TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_dealer_billing_details` (
        `bill_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `bill_start_date` datetime NOT NULL,
        `bill_end_date` datetime NOT NULL,
        `bill_status` varchar(30) NOT NULL,
        `billed_date` datetime NOT NULL,
        `plan_amt` decimal(30,2) NOT NULL,
        `coupen_amount` decimal(30,2) NOT NULL,
        `payable_amount` decimal(30,2) NOT NULL,
        PRIMARY KEY (`bill_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_dealer_billing_details TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_dealer_branches` (
        `branch_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `dealer_name` varchar(255) DEFAULT NULL,
        `dealer_contact_no` varchar(255) DEFAULT NULL,
        `branch_address` varchar(100) NOT NULL,
        `dealer_state` varchar(255) DEFAULT NULL,
        `dealer_city` varchar(255) DEFAULT NULL,
        `dealer_pincode` int(11) DEFAULT NULL,
        `dealer_mail` varchar(255) DEFAULT NULL,
        `dealer_service` enum("1","0") NOT NULL DEFAULT "0",
        `headquarter` enum("1","0") NOT NULL DEFAULT "0",
        `latitude` varchar(100) NOT NULL,
        `longitude` varchar(100) NOT NULL,
        `dealer_status` enum("Active","Inactive") NOT NULL DEFAULT "Active",
        PRIMARY KEY (`branch_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_dealer_branches TO '.$db_name.'@"localhost";');

        DB::statement(' CREATE TABLE '.$db_name.'.`dms_dealer_subscription_history` (
        `history_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `subscription_plan_id` int(11) NOT NULL,
        `payment_date` datetime NOT NULL,
        `payment` decimal(30,2) NOT NULL,
        `max_users` int(11) NOT NULL DEFAULT "1",
        `current_subscription` tinyint(4) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`history_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_dealer_subscription_history TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_dealer_system_notifications` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `d_id` int(11) NOT NULL,
        `notification_type_id` int(11) NOT NULL,
        `notification_type` enum("sms","email") NOT NULL,
        `title` varchar(100) NOT NULL,
        `message` text NOT NULL,
        `status` enum("0","1") NOT NULL,
        `notification_message` varchar(255) DEFAULT NULL,
        `notification_status` varchar(10) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_dealer_system_notifications TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dms_listing_certification_warranty_inspection` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `listing_id` varchar(255) DEFAULT NULL,
        `inspectionagency` varchar(255) DEFAULT NULL,
        `inspectiondate` date DEFAULT NULL,
        `certificateid` varchar(255) DEFAULT NULL,
        `certificateurl` varchar(255) DEFAULT NULL,
        `serviceagency` varchar(255) DEFAULT NULL,
        `servicedate` date DEFAULT NULL,
        `serviceid` varchar(255) DEFAULT NULL,
        `serviceurl` varchar(255) DEFAULT NULL,
        `certificatereport` varchar(255) DEFAULT NULL,
        `servicereport` varchar(255) DEFAULT NULL,
        `user_id` int(11) DEFAULT NULL,
        `lastupdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `createddatetime` datetime NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dms_listing_certification_warranty_inspection TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`session_info` (
        `session_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_account_id` int(11) NOT NULL,
        `login_time` datetime NOT NULL,
        `logout_time` datetime NOT NULL,
        `session_key` int(100) NOT NULL,
        `ip` int(100) NOT NULL,
        PRIMARY KEY (`session_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.session_info TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`user_account` (
        `user_id` int(11) NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `dealer_table_id` int(11) DEFAULT NULL,
        `branch_id` int(11) DEFAULT NULL,
        `user_name` char(20) NOT NULL,
        `password_hash` char(30) NOT NULL,
        `user_moblie_no` varchar(255) DEFAULT NULL,
        `user_email` varchar(255) DEFAULT NULL,
        `user_role` varchar(255) DEFAULT NULL,
        `full_name` varchar(20) NOT NULL,
        `creates_date` varchar(20) NOT NULL,
        `modified_date` varchar(20) NOT NULL,
        `expiration_date` varchar(20) NOT NULL,
        `created_by` varchar(255) NOT NULL,
        `status` enum("Active","Inactive") NOT NULL DEFAULT "Active",
        PRIMARY KEY (`user_id`),
        UNIQUE KEY `user_email` (`user_email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.user_account TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`lead_preferences` (
         `lead_preference_id` int(11) NOT NULL AUTO_INCREMENT,
         `lead_id` int(11) DEFAULT NULL,
         `lead_option_id` int(11) DEFAULT NULL,
         `lead_option_value` varchar(225) DEFAULT NULL,
         `lead_option_value_2` varchar(225) DEFAULT NULL,
         PRIMARY KEY (`lead_preference_id`),
         KEY `FK_lead_option_id_parameter_scoring_preferences_idx` (`lead_option_id`),
         KEY `FK_lead_id_dealer_contact_mgmt_preferences_idx` (`lead_id`),
         CONSTRAINT `FK_lead_id_dealer_contact_mgmt_preferences` FOREIGN KEY (`lead_id`) REFERENCES `dealer_contact_management` (`contact_management_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
         CONSTRAINT `FK_lead_option_id_parameter_scoring_preferences` FOREIGN KEY (`lead_option_id`) REFERENCES `dms_dev`.`parameter_option_scoring` (`option_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.lead_preferences TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`lead_product_preference` (
         `product_preference_id` int(11) NOT NULL AUTO_INCREMENT,
         `contact_id` int(11) DEFAULT NULL,
         `car_id` int(11) DEFAULT NULL,
         PRIMARY KEY (`product_preference_id`),
         KEY `FK_contact_id_dealer_contact_mgmt_preference_idx` (`contact_id`),
         KEY `FK_car_id_dms_car_listings_preference_idx` (`car_id`),
         CONSTRAINT `FK_car_id_dms_car_listings_preference` FOREIGN KEY (`car_id`) REFERENCES `dms_car_listings` (`car_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
         CONSTRAINT `FK_contact_id_dealer_contact_mgmt_preference` FOREIGN KEY (`contact_id`) REFERENCES `dealer_contact_management` (`contact_management_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.lead_product_preference TO '.$db_name.'@"localhost";');
        

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_invoices` (
        `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
        `contact_id` int(11) NOT NULL,
        `dealer_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `invoice_status_id` int(10) unsigned NOT NULL DEFAULT "1",
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT NULL,
        `deleted_at` timestamp NULL DEFAULT NULL,
        `invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `discount` double(8,2) NOT NULL DEFAULT "0.00",
        `po_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `invoice_date` date DEFAULT NULL,
        `due_date` date DEFAULT NULL,
        `terms` text COLLATE utf8_unicode_ci NOT NULL,
        `public_notes` text COLLATE utf8_unicode_ci NOT NULL,
        `is_deleted` tinyint(1) NOT NULL DEFAULT "0",
        `is_recurring` tinyint(1) NOT NULL DEFAULT "0",
        `frequency_id` int(10) DEFAULT NULL,
        `start_date` date DEFAULT NULL,
        `end_date` date DEFAULT NULL,
        `last_sent_date` date DEFAULT NULL,
        `recurring_invoice_id` int(11) DEFAULT NULL,
        `tax_name1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `tax_rate1` decimal(13,3) NOT NULL,
        `amount` decimal(13,2) NOT NULL DEFAULT "0.00",
        `balance` decimal(13,2) NOT NULL DEFAULT "0.00",
        `invoice_design_id` int(10) unsigned NOT NULL DEFAULT "1",
        `invoice_type_id` tinyint(1) NOT NULL DEFAULT "0",
        `quote_id` int(10) unsigned DEFAULT NULL,
        `quote_invoice_id` int(10) unsigned DEFAULT NULL,
        `custom_value1` decimal(13,2) NOT NULL DEFAULT "0.00",
        `custom_value2` decimal(13,2) NOT NULL DEFAULT "0.00",
        `custom_taxes1` tinyint(1) NOT NULL DEFAULT "0",
        `custom_taxes2` tinyint(1) NOT NULL DEFAULT "0",
        `is_amount_discount` tinyint(1) DEFAULT NULL,
        `invoice_footer` text COLLATE utf8_unicode_ci,
        `partial` decimal(13,2) DEFAULT NULL,
        `has_tasks` tinyint(1) NOT NULL DEFAULT "0",
        `auto_bill` tinyint(1) NOT NULL DEFAULT "0",
        `custom_text_value1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `custom_text_value2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `has_expenses` tinyint(1) NOT NULL DEFAULT "0",
        `tax_name2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `tax_rate2` decimal(13,3) NOT NULL,
        `client_enable_auto_bill` tinyint(1) NOT NULL DEFAULT "0",
        `is_public` tinyint(1) NOT NULL DEFAULT "0",
        `estimate` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
        `reference` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
        `invoice_discount_type` enum("Amount","%") COLLATE utf8_unicode_ci DEFAULT NULL,
        `grand_total` decimal(15,2) DEFAULT NULL,
        `description` longtext COLLATE utf8_unicode_ci,
        PRIMARY KEY (`invoice_id`),
        UNIQUE KEY `invoices_account_id_invoice_number_unique` (`dealer_id`,`invoice_number`),
        KEY `invoices_dealer_id_foreign` (`dealer_id`),
        KEY `invoices_invoice_status_id_foreign` (`invoice_status_id`),
        KEY `invoices_contact_id_index` (`contact_id`),
        KEY `invoices_recurring_invoice_id_index` (`recurring_invoice_id`),
        KEY `invoices_invoice_design_id_foreign` (`invoice_design_id`),
        KEY `invoices_user_id_idx` (`user_id`),
        CONSTRAINT `invoices_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `dealer_contact_management` (`contact_management_id`) ON DELETE CASCADE,
        CONSTRAINT `invoices_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dms_dev`.`dms_dealers` (`d_id`) ON DELETE CASCADE,
        CONSTRAINT `invoices_invoice_design_id_foreign` FOREIGN KEY (`invoice_design_id`) REFERENCES `dms_dev`.`invoice_designs` (`id`),
        CONSTRAINT `invoices_invoice_status_id_foreign` FOREIGN KEY (`invoice_status_id`) REFERENCES `dms_dev`.`invoice_statuses` (`id`),
        CONSTRAINT `invoices_recurring_invoice_id_foreign` FOREIGN KEY (`recurring_invoice_id`) REFERENCES `dealer_invoices` (`invoice_id`) ON DELETE CASCADE,
        CONSTRAINT `invoices_user_id` FOREIGN KEY (`user_id`) REFERENCES `dms_dev`.`dms_dealers` (`d_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_invoices TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_invoice_items` (
        `invoice_item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `dealer_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `invoice_id` int(11) NOT NULL,
        `product_id` int(11) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        `deleted_at` timestamp NULL DEFAULT NULL,
        `product_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `notes` text COLLATE utf8_unicode_ci NOT NULL,
        `cost` decimal(13,2) NOT NULL,
        `qty` decimal(13,2) DEFAULT NULL,
        `tax_name1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `tax_rate1` decimal(13,3) DEFAULT NULL,
        `public_id` int(10) unsigned NOT NULL,
        `custom_value1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `custom_value2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `tax_name2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `tax_rate2` decimal(13,3) NOT NULL,
        `discount` decimal(15,2) DEFAULT NULL,
        `discount_type` enum("Amount","%") COLLATE utf8_unicode_ci DEFAULT "Amount",
        `sub_total` decimal(15,2) DEFAULT NULL,
        `invoice_status_id` int(10) unsigned NOT NULL DEFAULT "1",
        PRIMARY KEY (`invoice_item_id`),
        KEY `invoice_items_dealer_id_foreign` (`dealer_id`),
        KEY `invoice_items_product_id_foreign` (`product_id`),
        KEY `invoice_items_user_id_foreign` (`user_id`),
        KEY `invoice_items_invoice_id_index` (`invoice_id`),
        CONSTRAINT `invoice_items_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dms_dev`.`dms_dealers` (`d_id`) ON DELETE CASCADE,
        CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `dealer_invoices` (`invoice_id`) ON DELETE CASCADE,
        CONSTRAINT `invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `dms_car_listings` (`car_id`) ON DELETE CASCADE,
        CONSTRAINT `invoice_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_invoice_items TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_payments` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `invoice_id` int(11) NOT NULL,
        `contact_id` int(11) DEFAULT NULL,
        `dealer_id` int(11) DEFAULT NULL,
        `user_id` int(11) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        `deleted_at` timestamp NULL DEFAULT NULL,
        `is_deleted` tinyint(1) NOT NULL DEFAULT "0",
        `amount` decimal(13,2) NOT NULL,
        `payment_date` date DEFAULT NULL,
        `payment_method_id` int(10) unsigned DEFAULT NULL,
        `payment_status_id` int(10) unsigned NOT NULL DEFAULT "4",
        `transaction_reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `payment_type_id` int(10) unsigned DEFAULT NULL,
        `account_gateway_id` int(10) unsigned DEFAULT NULL,
        `payer_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `public_id` int(10) unsigned NOT NULL,
        `refunded` decimal(13,2) NOT NULL,
        `routing_number` int(10) unsigned DEFAULT NULL,
        `last4` smallint(5) unsigned DEFAULT NULL,
        `expiration` date DEFAULT NULL,
        `gateway_error` text COLLATE utf8_unicode_ci,
        `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `credit_ids` text COLLATE utf8_unicode_ci,
        PRIMARY KEY (`id`),
        KEY `payments_contact_id_foreign` (`contact_id`),
        KEY `payments_user_id_foreign` (`user_id`),
        KEY `payments_dealer_id_foreign` (`dealer_id`),
        KEY `payments_payment_type_id_foreign` (`payment_type_id`),
        KEY `payments_invoice_id_index` (`invoice_id`),
        KEY `payments_payment_status_id_foreign` (`payment_status_id`),
        CONSTRAINT `payments_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `dealer_contact_management` (`contact_management_id`) ON DELETE CASCADE,
        CONSTRAINT `payments_dealer_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `dms_dev`.`dms_dealers` (`d_id`),
        CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `dealer_invoices` (`invoice_id`) ON DELETE CASCADE,
        CONSTRAINT `payments_payment_status_id_foreign` FOREIGN KEY (`payment_status_id`) REFERENCES `dms_dev`.`payment_statuses` (`id`),
        CONSTRAINT `payments_payment_type_id_foreign` FOREIGN KEY (`payment_type_id`) REFERENCES `dms_dev`.`payment_types` (`id`),
        CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dms_dev`.`dms_dealers` (`d_id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_payments TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_hypothacation_details` (
         `hypothacation_id` int(11) NOT NULL AUTO_INCREMENT,
         `hypothacation_type` varchar(255) DEFAULT NULL,
         `finacier_name` varchar(255) DEFAULT NULL,
         `fla_finacier_name` varchar(45) DEFAULT NULL,
         `from_date` datetime DEFAULT NULL,
         `listing_id` int(11) DEFAULT NULL,
         `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY (`hypothacation_id`),
         KEY `fk_hypth_listing_id_idx` (`listing_id`),
         CONSTRAINT `fk_hypth_listing_id` FOREIGN KEY (`listing_id`) REFERENCES `dms_car_listings` (`car_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_hypothacation_details TO '.$db_name.'@"localhost";');

        DB::statement('CREATE TABLE '.$db_name.'.`dealer_insurance_details` (
         `insurance_id` int(11) NOT NULL AUTO_INCREMENT,
         `comp_cd_desc` varchar(255) DEFAULT NULL,
         `fla_insurance_name` varchar(255) DEFAULT NULL,
         `insurance_type_desc` varchar(255) DEFAULT NULL,
         `insurance_from` datetime DEFAULT NULL,
         `insurance_upto` varchar(255) DEFAULT NULL,
         `listing_id` int(11) DEFAULT NULL,
         `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY (`insurance_id`),
         KEY `fk_insurance_listing_id_idx` (`listing_id`),
         CONSTRAINT `fk_insurance_listing_id` FOREIGN KEY (`listing_id`) REFERENCES `dms_car_listings` (`car_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_insurance_details TO '.$db_name.'@"localhost";');

        DB::statement('CREATE VIEW '.$db_name.'.`dealer_listing_pricing` AS select `dcl`.`car_id` AS `car_id`,`dcl`.`duplicate_id` AS `duplicate_id`,`mma`.`makename` AS `makename`,`mmd`.`model_name` AS `model_name`,`mv`.`variant_name` AS `variant_name`,`dcp`.`saleprice` AS `saleprice`,`dcl`.`car_master_status` AS `car_master_status` from (((('.$db_name.'.`dealer_cars_pricing` `dcp` join '.$db_name.'.`dms_car_listings` `dcl`) join `dms_dev`.`master_makes` `mma`) join `dms_dev`.`master_models` `mmd`) join `dms_dev`.`master_variants` `mv`) where ((`dcp`.`listing_id` = `dcl`.`car_id`) and (`dcl`.`make` = `mma`.`make_id`) and (`dcl`.`model_id` = `mmd`.`model_id`) and (`dcl`.`variant` = `mv`.`variant_id`) and (`dcl`.`car_master_status` in (1,2)))');

        DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.dealer_listing_pricing TO '.$db_name.'@"localhost";');

        DB::unprepared('CREATE TRIGGER '.$db_name.'.insert_listing_statistics AFTER INSERT
                            ON '.$db_name.'.dms_car_listings FOR EACH ROW
                        BEGIN

                            declare new_status_counter INT;
                         
                            
                           IF(NEW.car_master_status is not null) THEN
                           set new_status_counter = (select count(*) from dms_dev.dealer_listing_statistics where dealer_id=new.dealer_id and dealer_listing_status_id=new.car_master_status);
                            
                            if(new_status_counter >0) then
                                  update dms_dev.dealer_listing_statistics set dealer_listing_count=(select count(car_master_status)
                                  from '.$db_name.'.dms_car_listings where car_master_status=new.car_master_status) where dealer_id=new.dealer_id and
                                  dealer_listing_status_id=new.car_master_status;
                            else
                                  insert into dms_dev.dealer_listing_statistics(dealer_id,dealer_listing_status_id,dealer_listing_count)

                                  values(new.dealer_id,new.car_master_status,(select count(car_master_status) from '.$db_name.'.dms_car_listings where

                                  dealer_id=new.dealer_id and car_master_status=new.car_master_status));
                            end if;
                            end if;
                        END
                        ');

        DB::unprepared('CREATE  TRIGGER '.$db_name.'.update_listing_statistics AFTER UPDATE
                            ON '.$db_name.'.dms_car_listings FOR EACH ROW
                        BEGIN
                            declare new_car_master_status INT;
                            declare old_car_master_status INT;
                            declare old_status_counter INT;
                            declare new_status_counter INT;
                            set new_car_master_status=new.car_master_status;
                            set old_car_master_status=old.car_master_status;
                            
                            IF NOT NEW.car_master_status<=> OLD.car_master_status THEN
                            
                            set old_status_counter = (select count(*) from dms_dev.dealer_listing_statistics where dealer_id=old.dealer_id and dealer_listing_status_id=old.car_master_status);
                            set new_status_counter = (select count(*) from dms_dev.dealer_listing_statistics where dealer_id=old.dealer_id and dealer_listing_status_id=new.car_master_status);
                            if(old_status_counter >0) then
                                  update dms_dev.dealer_listing_statistics set dealer_listing_count=(select count(car_master_status)
                                  from '.$db_name.'.dms_car_listings where car_master_status=old.car_master_status) where dealer_id=old.dealer_id and
                                  dealer_listing_status_id=old.car_master_status;
                            else
                                  insert into dms_dev.dealer_listing_statistics(dealer_id,dealer_listing_status_id,dealer_listing_count)

                                  values(old.dealer_id,old.car_master_status,(select count(car_master_status) from '.$db_name.'.dms_car_listings where

                                  dealer_id=old.dealer_id and car_master_status=old.car_master_status));
                            end if;
                            if(new_status_counter >0) then
                                  update dms_dev.dealer_listing_statistics set dealer_listing_count=(select count(car_master_status)
                                  from '.$db_name.'.dms_car_listings where car_master_status=new.car_master_status) where dealer_id=old.dealer_id and
                                  dealer_listing_status_id=new.car_master_status;
                            else
                                  insert into dms_dev.dealer_listing_statistics(dealer_id,dealer_listing_status_id,dealer_listing_count)

                                  values(old.dealer_id,new.car_master_status,(select count(car_master_status) from '.$db_name.'.dms_car_listings where

                                  dealer_id=old.dealer_id and car_master_status=new.car_master_status));
                            end if;
                            end if;
                        END
                        ');

        DB::unprepared('CREATE TRIGGER '.$db_name.'.delete_listing_statistics AFTER DELETE
                            ON '.$db_name.'.dms_car_listings FOR EACH ROW
                        BEGIN
                            
                        declare old_status_counter INT;
                         
                           IF(old.car_master_status is not null) THEN
                           set old_status_counter = (select count(*) from dms_dev.dealer_listing_statistics where dealer_id=old.dealer_id and dealer_listing_status_id=old.car_master_status);
                            
                            if(old_status_counter >0) then
                                  update dms_dev.dealer_listing_statistics set dealer_listing_count=(select count(car_master_status)
                                  from '.$db_name.'.dms_car_listings where car_master_status=old.car_master_status) where dealer_id=old.dealer_id and
                                  dealer_listing_status_id=old.car_master_status;
                            else
                                  insert into dms_dev.dealer_listing_statistics(dealer_id,dealer_listing_status_id,dealer_listing_count)

                                  values(old.dealer_id,old.car_master_status,(select count(car_master_status) from '.$db_name.'.dms_car_listings where

                                  dealer_id=old.dealer_id and car_master_status=old.car_master_status));
                            end if;
                            end if;
                        END
                        ');

        //DB::table('master_temp_register')->where('id', $register_value->id)->update(['status' => "Completed"]);
        DB::table('master_schema_users')->insert(['username' => $dealerschemaname, 'password' => substr($password, 15, 8),'schema_name' =>$dealerschemaname]);
        $rootpath = public_path().'/uploadimages/'.$dealerschemaname;
        $watermark = 'watermark';
        mkdir(public_path().'/uploadimages/'.$dealerschemaname.'/photos/', 0777, true);
        mkdir(public_path().'/uploadimages/'.$dealerschemaname.'/videos/', 0777, true);
        mkdir(public_path().'/uploadimages/'.$dealerschemaname.'/documents/', 0777, true);
        mkdir(public_path().'/uploadimages/'.$dealerschemaname.'/profileimage/', 0777, true);
        mkdir(public_path().'/uploadimages/'.$dealerschemaname.'/contacts/', 0777, true);
        mkdir(public_path().'/uploadimages/'.$dealerschemaname.'/companylogo/'.$watermark, 0777, true);
    }

    public static function schema_table($table)
    {           
        $schema_table_data = DB::connection('dmsmysql')->table($table)->get();
        return $schema_table_data;
    }

    public static function schema_table_orderby_desc($table)
    {           
        $schema_table_data = DB::connection('dmsmysql')->table($table)->orderBy('addinventor_id', 'desc')->first();
        return $schema_table_data;
    }

    public static function schema_table_whereschemaname($table,$where)
    {           
        $register_users = DB::connection('mastermysql')->table($table)->where('d_id','781')->get();        
        return $register_users;
    }

    public static function schema_table_where_update($table,$param1,$param2,$param3,$param4)
    {           
        $register_users = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->update([$param3=>$param4]);        
        return $register_users;
    }

    public static function schema_mongopush_update($table,$where,$dataupdate)
    {           
        $register_users = DB::connection('dmsmysql')->table($table)->where($where)->update($dataupdate);        
        return $register_users;
    }

    public static function master_table($table)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->get();
        return $master_table_data;
    }

    public static function master_table_color($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function master_table_where($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function master_table_makeid_model_varient($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }
    public static function schema_table_where($table,$wherelist)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($wherelist)->get();
        return $master_table_data;
    }

    public static function schema_table_where_delete($table,$deletecontent)
    {   
        $master_table_get_data = DB::connection('dmsmysql')->table($table)->where($deletecontent)->get();
        $master_table_data = '';
        if(count($master_table_get_data) >= 1){        
            $master_table_data = DB::connection('dmsmysql')->table($table)->where($deletecontent)->delete();
        }
        return $master_table_data;
    }


    public static function schema_table_listing_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_photos_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_videos_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_pricing_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_purchase_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_expense_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_online_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }


    public static function schema_table_listing_documents_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_insert($table,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->insert($array);
        return $update_list;
    }

    public static function schema_insert_get($table,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->where($array)->get();
        return $update_list;
    }


    public static function schema_insertId($table,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->insert($array);
        return $update_list;
    }

    public static function schema_update($table,$whereid,$wherevalue,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->where($whereid,$wherevalue)->update($array);
        return $update_list;
    }

    public static function schema_delete($table,$wherecondition)
    {           
        $DeleteRecord = DB::connection('dmsmysql')->table($table)->where($wherecondition)->delete();
        return $DeleteRecord;
    }

    public static function schema_update_singlewhere($table,$whereid,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->where($whereid)->update($array);
        return $update_list;
    }

    public static function schema_update_twowhere($table,$where1,$where2,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)
                                                 ->where($where1)
                                                 ->where($where2)
                                                 ->update($array);
        return $update_list;
    }

    public static function schema_orderby_desc($table,$orderby,$order,$pricingstatus)
    {           
         $carlist_details = DB::connection('dmsmysql')->table($table)->where($pricingstatus,"1")
                                        ->orderBy($orderby,$order)->get();
         return $carlist_details;
    }
    public static function schema_mypostings($table,$where,$whereconnection)
    {           
         $carlist_details = DB::connection('dmsmysql')
                                            ->table($table)
                                            ->where($where)
                                            ->orwhere($whereconnection)
                                            ->orderBy("car_id","desc")
                                            ->get();
         return $carlist_details;
    }

    public static function mongopush_mypostings($table,$where,$whereconnection)
    {           
         $carlist_details = DB::connection('dmsmysql')
                                            ->table($table)
                                            ->where($where)
                                            ->orwhere($whereconnection)
                                            ->where("car_master_status","<>","4")
                                            ->where("car_master_status","<>","3")
                                            //->where("car_master_status","<>","0")
                                            ->where("car_master_status","<>","5")
                                            ->get();
         return $carlist_details;
    }
    //this function used for get myposting details with schema
    public static function schema_mypostings_list($dealer_schemaname,$table,$where,$fieldstatus)
    {           
         commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                            ->table($table)
                            ->where($where)
                            ->where($fieldstatus,'<>',4)
                            ->orderBy("car_id","desc")
                            ->get();       
        return $fetchrecords; 
    }

    public static function schema_where_notequal($table,$fieldname,$fieldstatus,$fieldvalue)
    {
        $dms_car_listings_details = DB::connection('dmsmysql')->table($table)
                                                                ->where($fieldname,$fieldvalue)
                                                                //->where($fieldstatus,'0')
                                                                //->where($fieldstatus,'<>','4')
                                                                ->get();
        return $dms_car_listings_details;
    }
    
    public static function schema_list_sold($table,$fieldstatus)
    {
        $dms_car_listings_details = DB::connection('dmsmysql')->table($table)
                                                                ->where($fieldstatus,'5')
                                                                ->get();
        return $dms_car_listings_details;
    }


    public static function schema_where($table,$where,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where,$Value)
                                                     ->get();
         return $carlist_details;
    }

    public static function schema_whereid($table,$where)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where)
                                                     ->get();
         return $carlist_details;
    }
    
    public static function schema_where_dealercarview($table,$where,$Value)
    {           
        $carlist_details = DB::connection('mastermysql')->table($table)
                                                     ->where($where,$Value)
                                                     ->get();
         return $carlist_details;
    }
    
    public static function schema_where_two($table,$where,$wherestatus,$valueid,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where,$valueid)
                                                     ->where($wherestatus,$Value)
                                                     ->get();
         return $carlist_details;
    }
    
    public static function schema_draft($table,$where)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where)
                                                     ->get();
         return $carlist_details;
    }
    public static function schema_where_three($table,$where,$wheretype,$wherestatus,$valueid,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where,$valueid)
                                                     ->where($wheretype,$Value)
                                                     ->where($wherestatus,'0')
                                                     ->get();
         return $carlist_details;
    }
        
    public static function schema_where_orderby_limit_one($table,$where,$orderby,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->orderBy($orderby,'asc')
                                                     ->where($where,$Value)
                                                     ->take(1)->get();
         return $carlist_details;
    }
    //Join Table

    public static function schema_join_Threetable($table1,$table2,$table3,$Field1,$Field2,$Field3,$where)
    {           
        $carlist_details    = DB::connection('dmsmysql')
                                            ->table($table1)
                                            ->leftJoin($table2,"$table2.$Field1", '=',"$table1.$Field2")
                                            ->leftJoin($table3,"$table3.$Field3", '=',"$table1.$Field2")
                                            ->where($where)->get();
        return $carlist_details;
    }

    public static function join_query_table_purchase($id){

        $carlist_details    = DB::connection('dmsmysql')
                                            ->table('dealer_cars_pricing')
                                            ->select('dealer_cars_pricing.*','dealer_cars_purchase.*','dealer_car_expenses.*')
                                            ->leftjoin('dealer_cars_purchase', 'dealer_cars_pricing.pricing_primary_id', '=', 'dealer_cars_purchase.dealer_primary_id')
                                            ->leftjoin('dealer_car_expenses', 'dealer_cars_pricing.pricing_primary_id', '=', 'dealer_car_expenses.car_primary_id')
                                            ->where('dealer_cars_pricing.pricing_primary_id', '=', $id)
                                            ->get();
        return $carlist_details;
    }
    //INSERT RECORD FOR CURRENT SCHEMA
    public static function InsertTable($id,$dealer_schemaname,$tablename,$insertrecord){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->insertGetId($insertrecord);      
        return $insertwithid; 
    }
    //GET RECORDS FOR CURRENT SCHEMA
    public static function fetchrecordsTable($dealer_schemaname,$tablename)
    {        
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                            ->table($tablename)
                            ->orderBy('thread_id')
                            ->get();       
        return $fetchrecords; 
    }
    //GET RECORDS FOR CURRENT SCHEMA ORDER BY DESC,ASC
    public static function fetchrecordsTableorderby($dealer_schemaname,$tablename,$where,$field,$desc)
    {        
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                            ->table($tablename)
                            ->where($where)
                            ->orderBy($field,$desc)
                            ->get();       
        return $fetchrecords; 
    }
    
    public static function schema_whereorderbylimitone($dealer_schemaname,$table,$orderby,$where)
    {           
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                                                    ->table($table)
                                                    ->orderBy($orderby,'asc')
                                                    ->where($where)
                                                    ->take(1)->get();
         return $fetchrecords;
    }
    //THIS FUNCTION USED FOR COUNT RECORDS WITH WHERE CONDITION
    public static function schema_countwhere($dealer_schemaname,$table,$where)
    {           
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                                                ->table($table)
                                                ->where($where)
                                                ->get();
         return $fetchrecords;
    }
    //THIS FUNCTION USED FOR COUNT RECORDS WITH WHERE CONDITION
    public static function dogetschemarecords($dealer_schemaname,$table,$where)
    {           
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                                                ->table($table)
                                                ->where($where)
                                                ->first();
         return $fetchrecords;
    }
    public static function dealerUpdateTableDetails($dealer_schemaname,$tablename,$wherecondition,$settabledata){
        commonmodel::doschemachange($dealer_schemaname);
        $updatetables = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->update($settabledata);       
        return $updatetables; 
    }
 }
