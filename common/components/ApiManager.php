<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Notification;
use backend\helpers\FirebaseNotifications;
use common\components\NotificationManager;

class ApiManager extends \yii\base\Component {

    public function GetAsset($datas) {
        $result = [];
        $error_list = [];
        if ($datas != NULL) {

            foreach ($datas as $data) {
                $plate_no = $data['plateNo'];
                $vehicle_exist = \common\models\LbClientVehicles::find()->where(['vehicle_number' => $plate_no])->one();

                if ($vehicle_exist != NULL) {
                    $model = new \common\models\LbClientVehicles();
                    $model->rfid = $data['rfid'];
                    if ($model->save(FALSE)) {

                    }
                }
            }
        }
        $result['errors'] = $error_list;
        return $result;
    }

    public function GetDevices($datas) {
        $result = [];
        $error_list = [];
        if ($datas != NULL) {

            foreach ($datas as $data) {
                $device_id = $data['id'];
                $device_ref_id = $data['name'];
                $device_type = $data['description'];
                $exp_items = explode('-', $device_ref_id);
                $station = 0;
                $dispenser = 0;
                $nozzle = 0;
                $dispenser_exist = [];
                if ($exp_items != NULL) {
                    if (isset($exp_items[0])) {
                        $station = $exp_items[0];
                    }
                    if (isset($exp_items[1])) {

                        $dispenser = $exp_items[1];
                    }
                    if (isset($exp_items[2])) {

                        $nozzle = $exp_items[2];
                    }
                }
                if ($device_type == "Lootah-S") {
                    if ($dispenser != 0) {
                        $dispenser_id = str_replace($dispenser, "", "D");
                        $dispenser_exist = \common\models\Dispenser::find()->where(['id' => $dispenser_id])->one();
                    }
                    $station_exist = \common\models\LbStation::find()->where(['station_name' => $station])->one();
                    $check_nozzle_exist = \common\models\Nozzle::find()->where(['device_ref_no' => $device_ref_id])->one();

//                if ($station_exist != NULL && $dispenser_exist != NULL && $station != 0 && $dispenser != 0 && $nozzle != 0) {

                    if ($check_nozzle_exist != NULL) {

                        $result_selected[] = $data;
                        $check_device_exist = \common\models\Device::find()->where(['device_id' => $device_id])->one();
                        if ($check_device_exist != NULL) {
                            $check_device_exist->name = $data['name'];
                            $check_device_exist->uid = $data['uid'];
                            $check_device_exist->description = $data['description'];
                            $check_device_exist->device_type = $data['description'];
                            $check_device_exist->status = $data['status'];
                            $check_device_exist->updated = $data['updated'];
                            $check_device_exist->mobile = $data['mobile'];
                            $check_device_exist->timestamp = $data['timestamp'];
                            $check_device_exist->softwareId = $data['softwareId'];
                            $check_device_exist->save();
                        } else {
                            $model = new \common\models\Device();
                            $model->name = $data['name'];
                            $model->device_id = $data['id'];
                            $model->uid = $data['uid'];
                            $model->description = $data['description'];
                            $model->device_type = $data['description'];
                            $model->device_ref_id = $data['name'];
                            $model->status = $data['status'];
                            $model->updated = $data['updated'];
                            $model->mobile = $data['mobile'];
                            $model->dispenser_id = $check_nozzle_exist->dispenser_id;
                            $model->station_id = $check_nozzle_exist->station_id;
                            $model->nozle_id = $check_nozzle_exist->id;
                            $model->softwareId = $data["softwareId"];
                            $model->timestamp = $data['timestamp'];
                            if ($model->save(FALSE)) {

                            } else {
                                $error_list[] = $model->errors;
                            }
                        }
                    } else {
                        $result_all[] = $data;
                    }
                } else if ($device_type == "Lootah-T") {
                    if ($station_exist != NULL) {
                        $model = new \common\models\Device();
                        $model->name = $data['name'];
                        $model->device_id = $data['id'];
                        $model->uid = $data['uid'];
                        $model->description = $data['description'];
                        $model->device_type = $data['device_type'];
                        $model->device_ref_id = $data['name'];
                        $model->status = $data['status'];
                        $model->updated = $data['updated'];
                        $model->mobile = $data['mobile'];
                        $model->station_id = $check_nozzle_exist->station_id;
                        $model->softwareId = $data["softwareId"];
                        $model->timestamp = $data['timestamp'];
                        if ($model->save(FALSE)) {

                        }
                    }
                }
            }
        }
        $result['errors'] = $error_list;
        $result['result_all'] = $result_all;
        $result['result_selected'] = $result_selected;
//        echo "<pre/>";
//        print_r($result);
//        exit;
        return $result;
    }

    public function GetTransactions($datas) {
        $result = [];
        $error_list = [];
        if ($datas != NULL) {

            foreach ($datas as $data) {

                $device_ref_id = $data['Meter'];
                $exp_items = explode('-', $device_ref_id);
                $station = 0;
                $dispenser = 0;
                $nozzle = 0;
                $dispenser_exist = [];
                if ($exp_items != NULL) {
                    if (isset($exp_items[0])) {
                        $station = $exp_items[0];
                    }
                    if (isset($exp_items[1])) {

                        $dispenser = $exp_items[1];
                    }
                    if (isset($exp_items[2])) {

                        $nozzle = $exp_items[2];
                    }
                }

                if ($dispenser != 0) {
                    $dispenser_id = str_replace($dispenser, "", "D");
                    $dispenser_exist = \common\models\Dispenser::find()->where(['id' => $dispenser_id])->one();
                }
                $station_exist = \common\models\LbStation::find()->where(['station_name' => $station])->one();
                $check_nozzle_exist = \common\models\Nozzle::find()->where(['device_ref_no' => $device_ref_id])->one();

//                if ($station_exist != NULL && $dispenser_exist != NULL && $station != 0 && $dispenser != 0 && $nozzle != 0) {

                if ($check_nozzle_exist != NULL) {

                    $result_selected[] = $data;
                    $check_device_exist = \common\models\Device::find()->where(['device_id' => $data['DeviceId']])->one();
                    $check_transaction_exist = \common\models\Transaction::find()->where(['transaction_no' => $data->Id])->one();
                    if ($check_device_exist == NULL) {
                        if ($check_transaction_exist == NULL) {

                            $model = new \common\models\Transaction();
                            $model->dispenser_id = $check_nozzle_exist->dispenser_id;
                            $model->station_id = $check_nozzle_exist->station_id;
                            $model->nozle_id = $check_nozzle_exist->id;
                            $model->UUID = uniqid('LOOTAH');
                            $model->DeviceId = $data['DeviceId'];
                            $model->DeviceId = $check_device_exist->device_type;

                            $model->transaction_no = $data['Id'];
                            $model->ReferenceId = $data['ReferenceId'];
                            $model->SequenceId = $data['SequenceId'];

                            $model->Meter = $data['Meter'];
                            $model->SecondaryTag = $data['SecondaryTag'];
                            $model->Category = $data['Category'];
                            $model->Operator = $data['Operator'];
                            $model->Asset = $data['Asset'];
                            $model->AccumulatorType = $data['AccumulatorType'];
                            $model->Sitecode = $data['Sitecode'];
                            $model->Project = $data['Project'];
                            $model->PlateNo = $data['PlateNo'];
                            $model->Master = $data['Master'];
                            $model->Accumulator = $data['Accumulator'];
                            $model->Volume = $data['Volume'];
                            $model->Allowance = $data['Allowance'];
                            $model->Type = $data['Type'];
                            $model->StartTime = $data['StartTime'];
                            $model->EndTime = $data['EndTime'];
                            $model->Status = $data['Status'];
                            $model->ServerTimestamp = $data['ServerTimestamp'];
                            $model->UpdateTimestamp = $data['UpdateTimestamp'];


                            if ($model->save(FALSE)) {

                            } else {
                                $error_list[] = $model->errors;
                            }
                        }
                    }
                } else {
                    $result_all[] = $data;
                }
            }
        }
        $result['errors'] = $error_list;
        $result['result_all'] = $result_all;
        $result['result_selected'] = $result_selected;
//        echo "<pre/>";
//        print_r($result);
//        exit;
        return $result;
    }

    public function vehiclemanagement($params, $method) {
        $name = "Manage veichle details-" . $method;

        if ($method == "POST" || $method == "PUT") {
            $url = "FCS/SecondaryTag";
            $make_call = $this->callAPI($method, $url, json_encode($params));

            if ($make_call == 1) {

                return $make_call;
            } else {

                $array = $this->errorCode(1000, $name, 1, $make_call);
                return 0;
            }
        } else {
            $url = "FCS/SecondaryTag/key";
            $response = $this->callAPI($method, $url, json_encode($params));
            //$response = json_decode($make_call, true);
            $array = $this->errorCode(1000, $name, 1, $make_call);

            return $response;
        }
    }

    public function updateagent($params, $master) {
        $name = "Update agent details-" . $master;
        $url = "/rest/modules/v1.0/Agent/" . $master;
        $make_call = $this->callAPI('POST', $url, json_encode($params));

        $lang = 1;
        $response = json_decode($make_call, true);
        if ($response['errors'] == null) {
            $array = $this->errorCode(2000, $name, $lang, $params);
            return $response['id'];
        } else {

            $array = $this->errorCode(1000, $name, $lang, $make_call);
            return 0;
        }
    }

    public function createagent($params, $master) {
        $name = "Create agent details - " . $master;
        $url = "/rest/modules/v1.0/Agent";
        $make_call = $this->callAPI('POST', $url, json_encode($params));

        $lang = 1;
        $response = json_decode($make_call, true);
        if ($response['errors'] == null) {
            $array = $this->errorCode(2000, $name, $lang, $params);
            return $response['id'];
        } else {

            $array = $this->errorCode(1000, $name, $lang, $make_call);
            return 0;
        }
    }

    public function getMaterValue($param) {
        $get_value = \common\models\CrmMaster::find()->where(['can_name' => $param, 'status' => 1])->one();
        if ($get_value != NULL) {
            return $get_value->val;
        } else {
            return "";
        }
    }

    public function updateuser($params, $master) {
        $name = "Update agent details-" . $master;
        $url = "/rest/modules/v1.0/account/" . $master;
        $make_call = $this->callAPI('POST', $url, json_encode($params));

        $lang = 1;
        $response = json_decode($make_call, true);
        if ($response['errors'] == null) {
            $array = $this->errorCode(2000, $name, $lang, $params);
            return TRUE;
        } else {

            $array = $this->errorCode(1000, $name, $lang, $make_call);
            return TRUE;
        }
    }

    public function getEquipmentList($unit_no) {
        $name = "Get Equipment List-" . $unit_no;
//        $url = "AssetDetails/" . $unit_no . "/RpBnrQ676207cWAClnI6TfNxw0UaIDUp3ZN_AYTnMZR7h";
//        $make_call = $this->callAPIEquipment('GET', $url);

        $lang = 1;
        $log['name'] = $name;
        $log['input'] = $unit_no;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://192.169.158.192:89/Service1.svc/AssetDetails/" . $unit_no . "/RpBnrQ676207cWAClnI6TfNxw0UaIDUp3ZN_AYTnMZR7h",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $log['ouput'] = $response;

        curl_close($curl);
        $array = $this->errorCode(2000, $name, $lang, $log);
        return $response;
    }

    public function createusers($user_id) {
        $user = \common\models\Users::find()->where(['id' => $user_id])->one();
        if ($user != NULL) {

            if ($user->master_id != '') {
                $name = "Update User details-" . $user->master_id;
                $url = "/rest/modules/v1.0/Account/" . $user->master_id;
            } else {
                $name = "Create User details";
                $url = "/rest/modules/v1.0/Account";
            }
//                                    $user = $this->createUser($email, $first_name, $last_name, $mobile_number, $nationality);
            $params['Email'] = $user->email;
            $nme = $user->name . ' ' . $user->last_name;
            $params['Name'] = $user->name . ' ' . $user->last_name;
            $params['Code'] = substr($nme, 0, 3) . "-" . $user->id;
            $params['AccountType'] = 'Customer';
            $params['Phone'] = $user->phone;
            $params['Mobile'] = $user->phone;
            $get_country = \common\models\Country::find()->where(['iso' => $user->country_name])->one();
            if ($get_country != NULL) {
                $params['ShippingCountry__code'] = $get_country->iso3;
                $params['BillingCountry__code'] = $get_country->iso3;
                $params['ShippingCountry__code'] = 'QAT';
                $params['BillingCountry__code'] = 'QAT';
            }
            $make_call = $this->callAPI('POST', $url, json_encode($params));
//            $make_call = [];
            $lang = 1;
            $response = json_decode($make_call, true);
            if ($response['errors'] == null) {
                $array = $this->errorCode(2000, $name, $lang, $params);
                return $response['id'];
            } else {

                $array = $this->errorCode(1000, $name, $lang, $make_call);
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function createuserst($user_id) {
        $user = \common\models\Users::find()->where(['id' => $user_id])->one();
        if ($user != NULL) {

            if ($user->master_id != 0) {
                $name = "Update Tenant details-" . $user->master_id;
                $url = "/rest/modules/v1.0/Tenant/" . $user->master_id;
            } else {
                $name = "Create User details";
                $url = "/rest/modules/v1.0/Tenant";
            }
//                                    $user = $this->createUser($email, $first_name, $last_name, $mobile_number, $nationality);
            $params['Email'] = $user->email;
            $params['Name'] = $user->name . ' ' . $user->last_name;
            $params['Code'] = "$user->id";
//            $params['AccountType'] = 'Prospect';
            $params['Phone'] = $user->phone;
            $get_country = \common\models\Country::find()->where(['iso' => $user->country_name])->one();
            if ($get_country != NULL) {
//                $params['ShippingCountry__code'] = $get_country->iso3;
//                $params['BillingCountry__code'] = $get_country->iso3;
//                $params['ShippingCountry__code'] = 'QAT';
//                $params['BillingCountry__code'] = 'QAT';
            }
            $make_call = $this->callAPI('POST', $url, json_encode($params));
//            $make_call = [];
            $lang = 1;
            $response = json_decode($make_call, true);
            if ($response['errors'] == null) {
                $array = $this->errorCode(2000, $name, $lang, $params);
                return $response['id'];
            } else {

                $array = $this->errorCode(1000, $name, $lang, $make_call);
                return $response;
            }
        } else {
            return 0;
        }
    }

    public function GetUnits($datas) {

        $result = [];
        $error_list = [];
        if ($datas != NULL) {

            foreach ($datas as $data) {
                $unit_type_code = $data['UnitType__code'];
                $check_unit_code_exist = \common\models\Property::find()->where(['property_id' => $unit_type_code])->one();
                $furnished = $this->getFurnished($data["NatureofFurnishings"]);
//                $flist = [];
                $type_lis[] = $unit_type_code;
                $flist[$unit_type_code][] = $furnished;

                if ($check_unit_code_exist != NULL) {
                    $property_id = $check_unit_code_exist->id;
//                    $frn = $this->getfur($check_unit_code_exist, $furnished);
//                    $check_unit_code_exist->furnished_status = $frn;
//                    $check_unit_code_exist->save(FALSE);
                } else {
                    $new_property = new \common\models\Property();
                    $new_property->property_id = $unit_type_code;
                    $new_property->view_type = $this->getViewType($data["UnitView__name"]);
                    $new_property->type_id = $this->getPropertyType($data["PropertyType__name"]);
                    $new_property->furnished_status = 4;
                    $new_property->status = 1;

                    $new_property->save(FALSE);

                    $property_id = $new_property->id;
                }

                $check_unit_exist = \common\models\PropertyUnits::find()->where(['unit_code' => $data["Code"]])->one();

                if ($check_unit_exist != NULL) {
                    $check_unit_exist->property_id = $property_id;
                    $check_unit_exist->tower_no = $data["PropertyId__code"];

                    if ($data['UnitStatus__name'] == "Booked") {
                        $check_unit_exist->booking_status = 1;
                    } else if ($data["UnitStatus__name"] == "Reserved") {
                        $check_unit_exist->booking_status = 2;
                    } else if ($data["UnitStatus__name"] == "Occupied") {
                        $check_unit_exist->booking_status = 1;
                    } else {
                        $check_unit_exist->booking_status = 0;
                    }

                    $check_unit_exist->parking_no = $data["ParkingNo"];
                    $check_unit_exist->no_of_parking = $data["NoofParking"];
                    $check_unit_exist->water_charge = $data["Water"];
                    $check_unit_exist->electricity_charge = $data["Electricity"];
                    $check_unit_exist->cool_meter = $data["QatarCool"];
                    $check_unit_exist->price = $data["Price"];
//                            $check_unit_exist->furnished_status = $data["Furnished_status_code"];
                    $check_unit_exist->master_id = $data["MasterId"];
                    $check_unit_exist->unit_code = $data["Code"];
                    $check_unit_exist->unit_no = $data["Name"];
                    $check_unit_exist->floor_no = $data["FloorId__code"];
                    $check_unit_exist->status = 1;

                    $view_type = $this->getViewType($data["UnitView__name"]);
                    $check_unit_exist->furnished_status = $furnished;

                    $check_unit_exist->view_type = $view_type;
                    $check_unit_exist->area = $data["Area"];
                    if ($check_unit_exist->save(FALSE)) {

                    } else {
                        $err['master_id'] = $data["MasterId"];
                        $err['tower'] = $datas["PropertyId__code"];
                        $err['error_details'] = $check_unit_exist->errors;
                        $error_list[] = $err;
                    }
                } else {
                    $model = new \common\models\PropertyUnits();
                    $model->property_id = $property_id;
                    $model->tower_no = $data["PropertyId__code"];
                    $model->no_of_parking = $data["NoofParking"];
                    $model->water_charge = $data["Water"];
                    $model->electricity_charge = $data["Electricity"];
                    $model->cool_meter = $data["QatarCool"];
                    $model->unit_no = $data["Name"];
                    $model->floor_no = $data["FloorId__code"];

                    if ($data['UnitStatus__name'] == "Booked") {
                        $model->booking_status = 1;
                    } else if ($data["UnitStatus__name"] == "Reserved") {
                        $model->booking_status = 2;
                    } else if ($data["UnitStatus__name"] == "Occupied") {
                        $model->booking_status = 1;
                    } else {
                        $model->booking_status = 0;
                    }
                    $model->parking_no = $data["ParkingNo"];
                    $model->price = $data["Price"];
//                            $model->furnished_status = $data["Furnished_status_code"];
                    $furnished = $this->getFurnished($data["NatureofFurnishings"]);
                    $model->furnished_status = $furnished;
                    $model->master_id = $data["MasterId"];
                    $model->unit_code = $data["Code"];
                    $model->status = 1;
                    $view_type = $this->getViewType($data["UnitView__name"]);
                    if ($view_type != '') {
                        $model->view_type = $view_type;
                    }
                    $model->area = $data["Area"];

                    if ($model->save()) {

                    } else {
                        $err['master_id'] = $data["MasterId"];
                        $err['error_details'] = $model->errors;
                        $error_list[] = $err;
                    }
                }
            }
            if ($flist != NULL) {
//                echo '<pre/>';
//                print_r($flist);
                foreach ($flist as $key => $value) {
                    $csf = 0;
                    $cff = 0;
                    $cuf = 0;
                    $selected_status = 4;
                    $property_id = $key;
                    if (is_array($value)) {


                        $fitems = array_unique($value);
                        if ($fitems != NULL) {
                            $total_count = count($fitems);
                            $counts = array_count_values($fitems);
                            if (in_array(0, $fitems)) {
                                $csf = $counts[0];
                            }
                            if (in_array(1, $fitems)) {
                                $cff = $counts[1];
                            }
                            if (in_array(3, $fitems)) {
                                $cuf = $counts[3];
                            }
                            if (($cff + $csf) == $total_count) {
                                $selected_status = 2;
                            }
                            if (($cff + $csf) < $total_count) {
                                $selected_status = 4;
                            }
                            if ($csf == $total_count) {
                                $selected_status = 0;
                            }
                            if ($cff == $total_count) {
                                $selected_status = 1;
                            }
                            if ($cuf == $total_count) {
                                $selected_status = 3;
                            }
                            $check_unit_code_exist = \common\models\Property::find()->where(['property_id' => $property_id])->one();


                            if ($check_unit_code_exist != NULL) {
                                $check_unit_code_exist->furnished_status = $selected_status;
                                $check_unit_code_exist->save(FALSE);
                            }
                        }
                    }
                }
            }
        }
        $result['errors'] = $error_list;
        return $result;
    }

    public function GetTower($datas) {

        $result = [];
        $error_list = [];
        if ($datas != NULL) {

            foreach ($datas as $data) {
                $tower_code = $data['Code'];
                $check_tower_exist = \common\models\Tower::find()->where(['code' => $tower_code])->one();
                if ($check_tower_exist != NULL) {
                    $check_tower_exist->name = $data['Name'];
                    $check_tower_exist->status = 1;
                    $check_tower_exist->master_id = $data['MasterId'];
                    $check_tower_exist->deposit_bank_name = $data['DepositedBank__name'];
                    $check_tower_exist->deposit_bank_code = $data['DepositedBank__code'];
                    $check_tower_exist->deposit_bank_id = $data['DepositedBank__id'];
                    $check_tower_exist->security_bank_name = $data['SecurityDepositBank__name'];
                    $check_tower_exist->security_bank_code = $data['SecurityDepositBank__code'];
                    $check_tower_exist->security_bank_id = $data['SecurityDepositBank__id'];
                    $check_tower_exist->company_address_en = $data['Address'];
                    $check_tower_exist->company_address_ar = $data['Address'];
                    if ($check_tower_exist->save()) {

                    } else {
                        $err['master_id'] = $data["MasterId"];
                        $err['error_details'] = $check_tower_exist->errors;
                        $error_list[] = $err;
                    }
                } else {
                    $new_tower = new \common\models\Tower();
                    $new_tower->name = $data['Name'];
                    $new_tower->code = $data['Code'];
                    $new_tower->master_id = $data['MasterId'];
                    $new_tower->status = 1;
                    $new_tower->deposit_bank_name = $data['DepositedBank__name'];
                    $new_tower->deposit_bank_code = $data['DepositedBank__code'];
                    $new_tower->deposit_bank_id = $data['DepositedBank__id'];

                    $new_tower->security_bank_name = $data['SecurityDepositBank__name'];
                    $new_tower->security_bank_code = $data['SecurityDepositBank__code'];
                    $new_tower->security_bank_id = $data['SecurityDepositBank__id'];

                    $check_tower_exist->company_address_en = $data['Address'];
                    $check_tower_exist->company_address_ar = $data['Address'];
                    if ($new_tower->save()) {

                    } else {
                        $err['master_id'] = $data["MasterId"];
                        $err['tower'] = $data["Code"];
                        $err['error_details'] = $new_tower->errors;
                        $error_list[] = $err;
                    }
                }
            }
        }
        $result['errors'] = $error_list;
        return $result;
    }

    public function GetAgents($datas) {

        $result = [];
        $error_list = [];
        if ($datas != NULL) {

            foreach ($datas as $data) {
                $master_id = $data["MasterId"];
                $check_agent_exist = \common\models\Users::find()->where(['account_type_id' => 3, 'master_id' => $master_id])->one();
                if ($check_agent_exist != NULL) {
                    $check_agent_exist->name = $data["Name"];
                    $check_agent_exist->address1 = $data["Address"];
                    $check_agent_exist->password = Yii::$app->security->generatePasswordHash($data["Password"]);
                    $check_agent_exist->email = $data["Email"];
                    $check_agent_exist->country_name = "QA";
                    $check_agent_exist->phone = $data["Mobile"];
                    $check_agent_exist->login_status = 0;
                    $check_agent_exist->account_type_id = 3;
                    $check_agent_exist->notification_activated_status = 1;
                    $check_agent_exist->app_lang_id = 1;
                    $check_agent_exist->user_group = 4;
                    $check_agent_exist->status = 10;
                    $check_agent_exist->master_id = $master_id;
                    if ($check_agent_exist->save()) {

                    } else {
                        $err['master_id'] = $data["MasterId"];
                        $err['error_details'] = $check_agent_exist->errors;
                        $error_list[] = $err;
                    }
                } else {
                    $model = new \common\models\Users();
                    $model->name = $data["Name"];
                    $model->address1 = $data["Address"];
                    $model->password = Yii::$app->security->generatePasswordHash($data["Password"]);
                    $model->email = $data["Email"];
                    $model->country_name = "QA";
                    $model->phone = $data["Mobile"];
                    $model->login_status = 0;
                    $model->account_type_id = 3;
                    $model->notification_activated_status = 1;
                    $model->app_lang_id = 1;
                    $model->user_group = 4;
                    $model->availability_status = 1;
                    $model->status = 10;

                    $model->master_id = $master_id;

                    if ($model->save()) {

                    } else {
                        $err['master_id'] = $data["MasterId"];
                        $err['error_details'] = $model->errors;
                        $error_list[] = $err;
                    }
                }
            }
        }
        $result['errors'] = $error_list;
        return $result;
    }

    public function updateProperty($params, $master) {
        $name = "Update Property Unit-" . $master;
        $url = "/rest/modules/v1.0/PMSUnits/" . $master;
        $make_call = $this->callAPI('POST', $url, json_encode($params));
//        $make_call = [];
        $lang = 1;
        $response = json_decode($make_call, true);
        if ($response['errors'] == null) {
            $array = $this->errorCode(2000, $name, $lang, $make_call);
            return TRUE;
        } else {

            $array = $this->errorCode(1000, $name, $lang, $make_call);
            return TRUE;
        }
    }

    public function getModule($params) {
        $name = "Get CEM Master-" . $params;
        $url = "/rest/modules/v1.0/" . $params;
        $make_call = $this->callAPI('GET', $url, '');

        $lang = 1;
        $response = json_decode($make_call, true);
        if ($response['errors'] == null) {
            $array = $this->errorCode(2000, $name, $lang, $params);
            return $response['records'];
        } else {

            $array = $this->errorCode(1000, $name, $lang, $make_call);
            return $response['records'];
        }
    }

    public function createContract($params, $master) {
        $send['records'] = json_encode($params);
        $name = "Create Contract-" . json_encode($params);
        if ($master == 0) {
            $name = "Create new Contract request " . json_encode($params);

            $url = "/rest/modules/v1.0/PMSContract";
        } else {
            $name = "Create new Contract request" . $master . " - " . json_encode($params);


            $url = "/rest/modules/v1.0/PMSContract/" . $master;
        }
        $make_call = $this->callAPI('POST', $url, json_encode($params));
//        $make_call = [];
        $lang = 1;
        $array = $this->errorCode(2000, $name, $lang, $make_call);

        $response = json_decode($make_call, true);
//        return $response;
        if ($response['errors'] == null) {
            $array = $this->errorCode(2000, $name, $lang, $params);
            return $response['TransId'];
        } else {

            $array = $this->errorCode(1000, $name, $lang, $params);
            return 0;
        }
    }

    public function createMaintenance($params, $master) {

        if ($master == 0) {
            $name = "Create new maintenance request... " . json_encode($params);

            $url = "/rest/modules/v1.0/Calls";
        } else {
            $name = "Create new maintenance request" . $master;

            $url = "/rest/modules/v1.0/Calls/" . $master;
        }
        $make_call = $this->callAPI('POST', $url, json_encode($params));
//        $make_call = [];
        $lang = 1;
        $response = json_decode($make_call, true);
        if ($response['errors'] == null) {
            $array = $this->errorCode(2000, $name, $lang, $params);
            return $response;
        } else {

            $array = $this->errorCode(1000, $name, $lang, $make_call);
            return $response;
        }
    }

    function callAPI($method, $url, $data) {
        ini_set('memory_limit', '-1');


        $access_token = $this->GetAccessToken();

        if ($access_token != '') {
            $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
            $post_url = $site_url . $url . '?key=' . $access_token;
            $curl = curl_init();

            switch ($method) {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                default:
                    $post_url = sprintf("%s&%s", $post_url, http_build_query(json_decode($data)));


//                        $url = sprintf("%s?%s", $post_url, http_build_query($data));
                // $url = $post_url;
            }

            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $post_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            // EXECUTE:
            $response = curl_exec($curl);
            $result = json_decode($response, true);
            $input['url'] = $post_url;
            $input['access_token'] = $access_token;
            $input['data'] = $data;
            $input['response'] = $result;

            if (!$response) {
                echo "<pre/>";
                print_r($input);
                die("Connection Failure");
            }
            $final['url'] = $url;
            $final['result'] = $result;

//            if ($method == "GET") {
//
//                echo "<pre/>";
//                print_r($input);
//                die("date get");
//            }
            return $result;
        } else {
            return 'Access token not getting';
        }
    }

    function getcallAPI($method, $url, $data) {
        ini_set('memory_limit', '-1');


        $access_token = $this->GetAccessToken();

        if ($access_token != '') {
            $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
            $post_url = $site_url . $url . '?key=' . $access_token;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.smetron.com/casper/api/FCS/SecondaryTag/key?key=SID-VHRF39ZXZAP3EL5U2QNU6CJ7GVSONHT17012021075821176U24&label=499',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $result = json_decode($response, true);

            return $result;
        } else {
            return 'Access token not getting';
        }
    }

    function callAPIEquipment($method, $url) {

        $access_token = $this->GetAccessToken();

        if ($access_token != '') {
            $site_url = "http://192.169.158.192:89/Service1.svc/";

            $post_url = $site_url . $url;
            $curl = curl_init();

            if ($method == "GET") {
                $url = $post_url;
            } else {
                return 0;
            }

            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $post_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            // EXECUTE:
            $result = curl_exec($curl);
            if (!$result) {
                die("Connection Failure");
            }
            curl_close($curl);
            return $result;
        } else {
            return 'Access token not getting';
        }
    }

    public function GetAccessToken() {
        date_default_timezone_set('Asia/Qatar');
        $get_token = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        if ($get_token->dms_access_token == '' || $get_token->dms_token_last_updated_on == '0000-00-00 00:00:00') {

            $token_result = $this->generateToken();
            if ($token_result != NULL) {
                if (isset($token_result['sessionId']) && $token_result['sessionId'] != "") {
                    $get_token->dms_access_token = $token_result["sessionId"];
                    $get_token->dms_token_last_updated_on = $token_result["expire"];
                    $get_token->save(FALSE);
                    $token = $token_result['sessionId'];
                }
            }
        } else {

            $last_updated = $get_token->dms_token_last_updated_on;
            $last_timestamp = strtotime($last_updated);
            $current_time = strtotime(date('Y-m-d H:i:s'));
            $new_time = strtotime('+24 hours', $last_timestamp);
            if ($current_time >= $new_time) {

                $token_result = $this->generateToken();

                if ($token_result != NULL) {
                    if (isset($token_result['sessionId']) && $token_result['sessionId'] != "") {
                        $get_token->dms_access_token = $token_result["sessionId"];
                        $get_token->dms_token_last_updated_on = $token_result["expire"];
                        $get_token->save(FALSE);

                        $token = $token_result['sessionId'];
                    }
                }
            } else {

                $token = $get_token->dms_access_token;
            }
        }

        return $token;
    }

    public function generateToken() {
        $curl = curl_init();
        $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
        $user_name = Yii::$app->CommonRequest->getconfig()->dms_user_name;
        $password = Yii::$app->CommonRequest->getconfig()->dms_password;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $site_url . "Auth?username=" . $user_name . "&password=" . $password,
//            CURLOPT_URL => 'https://www.smetron.com/casper/api/Auth?username=tutorial&password=1215',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response, true);

        return $result;
    }

    function getViewType($type) {
        $check_view_type = \common\models\ViewType::find()->where(['label' => $type])->one();
        if ($check_view_type != NULL) {
            return $check_view_type->id;
        } else {
            $model = new \common\models\ViewType();
            $model->label = $type;
            $model->name_en = $type;
            $model->status = 1;
            $model->name_ar = $type;

            $name = $type;
            $name = str_replace(' ', '_', $name);
            $name = rtrim($name, '_');
            $model->can_name = strtoupper($name);
            $model->save(FALSE);
            return $model->id;
        }
    }

    function getFurnished($type) {
        $check_fur = \common\models\FurnishedStatus::find()->where(['title' => $type])->one();
        if ($check_fur != NULL) {
            return $check_fur->key;
        } else {
            $model = new \common\models\FurnishedStatus();
            $model->title = $type;
            $model->label_en = $type;
            $model->label_ar = $type;
            $model->status = 1;

            $model->save(FALSE);
            return $model->key;
        }
    }

    function getPropertyType($type) {
        $check_view_type = \common\models\PropertyType::find()->where(['name_en' => $type])->one();
        if ($check_view_type != NULL) {
            return $check_view_type->id;
        } else {
            $model = new \common\models\PropertyType();
            $model->name_en = $type;
            $model->name_ar = $type;

            $name = $type;
            $name = str_replace(' ', '_', $name);
            $name = rtrim($name, '_');
            $model->can_name = strtoupper($name);
            $model->status = 1;
            $model->save(FALSE);
            return $model->id;
        }
    }

    function getFur($exist_status, $post_status) {
        if ($exist_status == $post_status) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 1) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 3) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 4) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 5) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 1) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 3) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 4) {
            $st = $post_status;
        } else if ($exist_status = 0 && $post_status == 5) {
            $st = $post_status;
        }

//        $date['Semi Furnished'] = 0;
//        $date['Fully furnished'] = 1;
//        $date['Both FF/SF'] = 2;
//        $date['Villa Fitout Furniture '] = 3;
//        $date['Villa-Furniture'] = 4;
//        $date['Villa- unfurnished'] = 5;
//        $date['Multiple'] = 6;
//
//        $get_fr = \common\models\FurnishedStatus::find()->where(['status' => 1, 'title' => $title])
        $counts = array_count_values($type);

        $sf_count = 0;
        $ff_count = 0;
        $fif_count = 0;
        $uf_count = 0;

        if (in_array("Semi Furnished", $type)) {
            $sf_count = $counts['Semi Furnished'];
        }
        if (in_array("Fully Furnished", $type)) {
            $ff_count = $counts['Fully Furnished'];
        }
        if (in_array("Un Furnished", $type)) {
            $uf_count = $counts['Un Furnished'];
        }
        if (in_array("Fitout Furnished", $type)) {
            $fif_count = $counts['Fitout Furnished'];
        }
        $status = 6;
        if ($sf_count > 0 && $ff_count > 0 && ($uf_count > 0 || $fif_count > 0)) {
            $status = 6;
        } else if ($sf_count > 0 && $ff_count > 0 && ($uf_count > 0 || $fif_count > 0)) {
            $status = 6;
        }
        $check_view_type = \common\models\PropertyType::find()->where(['name_en' => $type])->one();
        if ($check_view_type != NULL) {
            return $check_view_type->id;
        } else {
            $model = new \common\models\PropertyType();
            $model->name_en = $type;
            $model->name_ar = $type;
            $name = $type;
            $name = str_replace(' ', '_', $name);
            $name = rtrim($name, '_');
            $model->can_name = strtoupper($name);
            $model->status = 1;
            $model->save(FALSE);
            return $model->id;
        }
    }

    function errorCode($code, $name, $lang = 1, $value = "") {

        $retun = [];

        $file_size = filesize(Yii::$app->basePath . "/../uploads/logs/crm_app_log.txt");
        $size = $file_size / 1000;
        if ($size >= 1000) {
            $old_name = Yii::$app->basePath . "/../uploads/logs/crm_app_log.txt";
            $new_name = Yii::$app->basePath . "/../uploads/logs/crm_app_log" . date('Y-m-d') . ".txt";
            rename($old_name, $new_name);
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/crm_app_log.txt', "a") or die("Unable to open file!");
        } else {
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/crm_app_log.txt', "a") or die("Unable to open file!");
        }

        if ($code != 2000) {
            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Error code : ' . $code;
        } else {

            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Success : ' . $code;
        }
        $imp = '';
//        if ($value != '') {
//            $imp = serialize($value);
//        }
        if ($value != '') {
            if (is_array($value)) {
                $imp = json_encode($value);
            } else {
                $imp = $value;
            }
        }
//        if ($value != '') {
//            if (is_array($value)) {
//                $imp .= "BODY DATA => [" . "\r\n";
//                foreach ($value as $key => $val) {
//                    $imp.= $key . ' : ' . $val . "\r\n";
//                }
//                $imp .= " ]" . "\r\n";
//            }
//        }
        fwrite($fp, "\r\n" . $write_data);
        fwrite($fp, "\r\n" . $imp);
        fclose($fp);





        return $retun;
    }

}
