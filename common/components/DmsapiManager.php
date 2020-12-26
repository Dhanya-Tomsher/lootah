<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Notification;
use backend\helpers\FirebaseNotifications;
use common\components\NotificationManager;

class DmsapiManager extends \yii\base\Component {

    public function securityCheck($rid, $type) {

        $name = "DMS Add type $type Cheque Generation";

        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {
            $get_cheque_details = \common\models\Cheque::find()->where(['booking_form_id' => $check_exist_booking->id, 'cheque_type' => $type])->one();
            if ($get_cheque_details != NULL) {

                $url = "/resources/DocumentService/addDocument";
                $check_items[] = ['symName' => 'chequenumber', 'mvalues' => [$get_cheque_details->cheque_number]];
                $check_items[] = ['symName' => 'chequeduedate', 'mvalues' => [date('d/m/Y', strtotime($get_cheque_details->cheque_date))]];
                $check_items[] = ['symName' => 'chequeamount', 'mvalues' => [$get_cheque_details->amount]];
                $check_items[] = ['symName' => 'holdername', 'mvalues' => [$get_cheque_details->user_name]];
                $check_items[] = ['symName' => 'beneficiaryname', 'mvalues' => [$get_cheque_details->beneficiary_name]];
                $check_items[] = ['symName' => 'bankname', 'mvalues' => [$get_cheque_details->bank]];
                $check_items[] = ['symName' => 'contractid', 'mvalues' => [$check_exist_booking->contract_number]];
                $check_items[] = ['symName' => 'userid', 'mvalues' => [$check_exist_booking->user_id]];
                $params['docclass'] = 'chequedocument';
                $get_cheque_details = \common\models\Cheque::find()->where(['booking_form_id' => $check_exist_booking->id, 'cheque_type' => $type])->one();
                if ($get_cheque_details != NULL) {

                    $c_ext = explode('.', $get_cheque_details->cheque_image);
                    $cheque = new \CURLFile(Yii::$app->basePath . "/../uploads/security-cheques/" . $get_cheque_details->booking_form_id . '/' . $get_cheque_details->cheque_image, 'image/' . $c_ext[1], $get_cheque_details->cheque_image);
                }
                $params['props'] = $check_items;
                $postfields = array("DocInfo" => json_encode($params), 'cheque' => $cheque);
                $ctype = "multipart/form-data";
                $make_call = $this->callAPI('POST', $url, $postfields, $ctype);
                $lang = 1;
                $output['input_url'] = $url;
                $output['input_params'] = $params;
                $output['access_token'] = $config->dms_access_token;
                if ($this->isJSON($make_call)) {
                    $response = json_decode($make_call, true);
                    $output['output'] = $response;
                    $array = $this->errorCode(1000, $name, $lang, $output);
                }
                else {
                    $get_cheque_details->dms_cheque_reference = $make_call;
                    $get_cheque_details->save(FALSE);
                    $output['output'] = $make_call;
                    $array = $this->errorCode(2000, $name, $lang, $output);
                }
                return $output;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    public function twelveCheck($rid, $type, $cheque) {

        $name = "DMS Add type $type Cheque Generation";

        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {
            $get_cheque_details = \common\models\Cheque::find()->where(['booking_form_id' => $check_exist_booking->id, 'cheque_type' => $type, 'id' => $cheque->id])->one();
            if ($get_cheque_details != NULL) {

                $url = "/resources/DocumentService/addDocument";
                $check_items[] = ['symName' => 'chequenumber', 'mvalues' => [$get_cheque_details->cheque_number]];
                $check_items[] = ['symName' => 'chequeduedate', 'mvalues' => [date('d/m/Y', strtotime($get_cheque_details->cheque_date))]];
                $check_items[] = ['symName' => 'chequeamount', 'mvalues' => [$get_cheque_details->amount]];
                $check_items[] = ['symName' => 'holdername', 'mvalues' => [$get_cheque_details->user_name]];
                $check_items[] = ['symName' => 'beneficiaryname', 'mvalues' => [$get_cheque_details->beneficiary_name]];
                $check_items[] = ['symName' => 'bankname', 'mvalues' => [$get_cheque_details->bank]];
                $check_items[] = ['symName' => 'contractid', 'mvalues' => [$check_exist_booking->contract_number]];
                $check_items[] = ['symName' => 'userid', 'mvalues' => [$check_exist_booking->user_id]];
                $params['docclass'] = 'chequedocument';
                if ($get_cheque_details->cheque_image != '') {
                    $c_ext = explode('.', $get_cheque_details->cheque_image);
                    $cheque = new \CURLFile(Yii::$app->basePath . "/../uploads/security-cheques/" . $get_cheque_details->booking_form_id . '/' . $get_cheque_details->cheque_image, 'image/' . $c_ext[1], $get_cheque_details->cheque_image);
                }
                $params['props'] = $check_items;
                $postfields = array("DocInfo" => json_encode($params), 'cheque' => $cheque);
                $ctype = "multipart/form-data";
                $make_call = $this->callAPI('POST', $url, $postfields, $ctype);
                $lang = 1;
                $output['input_url'] = $url;
                $output['input_params'] = $params;
                $output['access_token'] = $config->dms_access_token;
                if ($this->isJSON($make_call)) {
                    $response = json_decode($make_call, true);
                    $output['output'] = $response;
                    $array = $this->errorCode(1000, $name, $lang, $output);
                }
                else {

                    if ($make_call != strip_tags($make_call)) {

                        $output['output'] = $make_call;
                        $array = $this->errorCode(2000, $name, $lang, $output);
                    }
                    else {
                        $get_cheque_details->dms_cheque_reference = $make_call;
                        $get_cheque_details->save(FALSE);
                        $output['output'] = $make_call;
                        $array = $this->errorCode(2000, $name, $lang, $output);
                    }
                }
                return $output;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    public function saveChequeActivity($check_items, $get_activity) {

        $name = "DMS Save Security Cheque Details";
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        $url = "/resources/WorkService/saveActivity";
        $params['id'] = $get_activity;
        $params['attachments'] = $check_items;
        $postfields = json_encode($params);
        $ctype = "appalication/json";
//        $make_call = 0;
        $make_call = $this->calljsonAPI('POST', $url, $postfields, $ctype);
        $lang = 1;
        $output['input_url'] = $url;
        $output['input_params'] = $params;
        $output['access_token'] = $config->dms_access_token;
        if ($this->isJSON($make_call)) {
            $response = json_decode($make_call, true);
            $output['output'] = $response;
            $array = $this->errorCode(1000, $name, $lang, $output);
        }
        else {
            $output['output'] = $make_call;
            $array = $this->errorCode(2000, $name, $lang, $output);
        }
        return $output;
    }

    public function checkincheckout($rid, $cheque_id) {
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {
            $get_cheque_details = \common\models\Cheque::find()->where(['booking_form_id' => $check_exist_booking->id, 'dms_cheque_reference' => $cheque_id])->one();
            if ($get_cheque_details != NULL) {
                $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
                $output = [];
                if ($get_cheque_details->cheque_image != '') {

                    $name = "DMS security checque checkout .";
                    $url = "/resources/DocumentService/checkOut?id=" . $get_cheque_details->dms_cheque_reference;
                    $params['id'] = $get_cheque_details->dms_cheque_reference;
                    $postfields = json_encode($params);
                    $ctype = "appalication/json";
                    $make_call = $this->callAPI('GET', $url, $postfields, $ctype);
                    $lang = 1;
                    $output['input_url'] = $url;
                    $output['input_params'] = $params;
                    $output['output'] = $make_call;
                    $output['access_token'] = $config->dms_access_token;
                    if ($make_call == $get_cheque_details->dms_cheque_reference) {
                        $array = $this->errorCode(1099, $name, $lang, $output);
                        $outputin = [];
                        if ($get_cheque_details->cheque_image != '') {
                            $name_in = "DMS security checque check in .";
                            $urlin = "/resources/DocumentService/checkIn";
                            $check_items[] = ['symName' => 'chequenumber', 'mvalues' => [$get_cheque_details->cheque_number]];
                            $check_items[] = ['symName' => 'chequeduedate', 'mvalues' => [date('d/m/Y', strtotime($get_cheque_details->cheque_date))]];
                            $check_items[] = ['symName' => 'chequeamount', 'mvalues' => [$get_cheque_details->amount]];
                            $check_items[] = ['symName' => 'holdername', 'mvalues' => [$get_cheque_details->user_name]];
                            $check_items[] = ['symName' => 'beneficiaryname', 'mvalues' => [$get_cheque_details->beneficiary_name]];
                            $check_items[] = ['symName' => 'bankname', 'mvalues' => [$get_cheque_details->bank]];
                            $check_items[] = ['symName' => 'contractid', 'mvalues' => [$check_exist_booking->contract_number]];
                            $check_items[] = ['symName' => 'userid', 'mvalues' => [$check_exist_booking->user_id]];
                            $params['docclass'] = 'chequedocument';
                            $params['id'] = "$get_cheque_details->dms_cheque_reference";
                            $c_ext = explode('.', $get_cheque_details->cheque_image);
                            $cheque = new \CURLFile(Yii::$app->basePath . "/../uploads/security-cheques/" . $get_cheque_details->booking_form_id . '/' . $get_cheque_details->cheque_image, 'image/' . $c_ext[1], $get_cheque_details->cheque_image);
                            $params['props'] = $check_items;

                            $postfield = array("DocInfo" => json_encode($params), 'file' => $cheque);
                            $ctype = "multipart/form-data";
                            $make_call_in = $this->callAPI('POST', $urlin, $postfield, $ctype);
                            $outputin['input_url'] = $urlin;
                            $outputin['input_params'] = $params;
                            $outputin['access_token'] = $config->dms_access_token;
                            $outputin['output'] = $make_call_in;

                            if ($make_call_in == $get_cheque_details->dms_cheque_reference) {
                                $array = $this->errorCode(1100, $name_in, $lang, $outputin);

                                return $make_call_in;
                            }
                            else {
                                $array = $this->errorCode(1101, $name_in, $lang, $outputin);

                                return 0;
                            }
                        }
                        else {
                            $array = $this->errorCode(1102, $name_in, $lang, $outputin);

                            return 0;
                        }
                    }
                    else {
                        $output['output'] = $make_call;
                        $array = $this->errorCode(1103, $name, $lang, $output);
                        return 0;
                    }
                }
                else {
                    $output['output'] = "Checque Image Not found";
                    $array = $this->errorCode(1104, $name_in, $lang, $output);

                    return 0;
                }
            }
            else {
                $output['output'] = "Checque Details Not found-" . $rid . "--" . $cheque_id;


                $array = $this->errorCode(1105, $name_in, $lang, $output);

                return 0;
            }
        }
        else {
            $output['output'] = "Resrvation Details Not found";


            $array = $this->errorCode(1106, $name_in, $lang, $output);

            return 0;
        }
    }

    public function checkincheckoutqid($rid, $image_name, $dms_ref) {
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {
            if ($dms_ref != '') {
                $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
                $output = [];
                $name = "DMS security checque checkout .";
                $url = "/resources/DocumentService/checkOut?id=" . $dms_ref;
                $params['id'] = $dms_ref;
                $postfields = json_encode($params);
                $ctype = "appalication/json";
                $make_call = $this->callAPI('GET', $url, $postfields, $ctype);
                $lang = 1;
                $output['input_url'] = $url;
                $output['input_params'] = $params;
                $output['output'] = $make_call;
                $output['access_token'] = $config->dms_access_token;
                if ($make_call == $dms_ref) {
                    $array = $this->errorCode(1099, $name, $lang, $output);
                    $outputin = [];
                    if ($image_name != '') {
                        $name_in = "DMS security checque check in .";
                        $urlin = "/resources/DocumentService/checkIn";
                        $check_items = [];

                        $params['docclass'] = 'chequedocument';
                        $params['id'] = "$dms_ref";
                        $c_ext = explode('.', $image_name);
                        $cheque = new \CURLFile(Yii::$app->basePath . "/../uploads/client-booking/" . $check_exist_booking->id . '/' . $image_name, 'image/' . $c_ext[1], $image_name);
                        $params['props'] = $check_items;

                        $postfield = array("DocInfo" => json_encode($params), 'file' => $cheque);
                        $ctype = "multipart/form-data";
                        $make_call_in = $this->callAPI('POST', $urlin, $postfield, $ctype);
                        $outputin['input_url'] = $urlin;
                        $outputin['input_params'] = $params;
                        $outputin['access_token'] = $config->dms_access_token;
                        $outputin['output'] = $make_call_in;

                        if ($make_call_in == $dms_ref) {
                            $array = $this->errorCode(1100, $name_in, $lang, $outputin);

                            return $make_call_in;
                        }
                        else {
                            $array = $this->errorCode(1101, $name_in, $lang, $outputin);

                            return 0;
                        }
                    }
                    else {
                        $array = $this->errorCode(1102, $name_in, $lang, $outputin);

                        return 0;
                    }
                }
                else {
                    $output['output'] = $make_call;
                    $array = $this->errorCode(1103, $name, $lang, $output);
                    return 0;
                }
            }
            else {
                $output['output'] = "Dms Reference Not found-" . $rid . "-" . $image_name . "-" . $dms_ref;
                $array = $this->errorCode(1106, $name_in, $lang, $output);
                return 0;
            }
        }
        else {
            $output['output'] = "Resrvation Details Not found";


            $array = $this->errorCode(1106, $name_in, $lang, $output);

            return 0;
        }
    }

    public function getActivityInfo($rid, $activity_type) {
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {
            $name = "DMS Get Activity Info.";
            $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
            $get_activity = Yii::$app->DmsapiManager->getActivity($check_exist_booking->workflow_id, $activity_type);
            if ($get_activity != 0 && !is_array($get_activity)) {
                $get_activity_id = $get_activity;
                $check_exist_booking->current_activity_id = $get_activity;
                $check_exist_booking->save(FALSE);
            }
            else {
                $get_activity_id = $check_exist_booking->current_activity_id;
            }
            $url = "/resources/WorkService/getActivityInfo?id=" . $get_activity_id;
            $params['id'] = $get_activity_id;
            $postfields = json_encode($params);
            $ctype = "appalication/json";
//        $make_call = 0;
            $make_call = $this->callAPI('GET', $url, $postfields, $ctype);
            $lang = 1;
            $output['input_url'] = $url;
            $output['input_params'] = $params;
            $output['access_token'] = $config->dms_access_token;
            if ($this->isJSON($make_call)) {
                $response = json_decode($make_call, true);
                $output['output'] = $response;
                $array = $this->errorCode(999, $name, $lang, $output);
                return $response;
            }
            else {
                $output['output'] = $make_call;
                $array = $this->errorCode(903, $name, $lang, $output);
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    public function generateContract($rid) {

        $name = "DMS Contract Generation";

        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $website = $config->website;
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {


            $get_property_type = \common\models\PropertyType::find()->where(['id' => $check_exist_booking->property->type_id, 'status' => 1])->one();
            $common_date = $check_exist_booking->commoncement_date;
            $duration = $check_exist_booking->duration;
            $no_month_free = $check_exist_booking->no_month_free;
            $effectiveDate = date('d/m/Y', strtotime("+" . ($duration + $no_month_free) . " months", strtotime($common_date)));
            $grace_period_end = date('d/m/Y', strtotime("+" . $check_exist_booking->no_month_free . " months", strtotime($common_date)));
            $no_year = $duration / 12;
            $url = "/resources/WorkService/initWorkflow";
            $f_ext = explode('.', $check_exist_booking->qid_front);
            $b_ext = explode('.', $check_exist_booking->qid_back);
            $front = new \CURLFile(Yii::$app->basePath . "/../uploads/client-booking/" . $rid . "/" . $check_exist_booking->qid_front, 'image/' . $f_ext[1], $check_exist_booking->qid_front);
            $back = new \CURLFile(Yii::$app->basePath . "/../uploads/client-booking/" . $rid . "/" . $check_exist_booking->qid_back, 'image/' . $b_ext[1], $check_exist_booking->qid_back);
            $params[] = ['key' => '$WorkType', 'value' => 'WT_leaseagreement'];
            $params[] = ['key' => '$ATTACHMENT:4', 'value' => $check_exist_booking->qid_front];
            $params[] = ['key' => '$ATTACHMENT:4', 'value' => $check_exist_booking->qid_back];
            $params[] = ['key' => 'apartmentno', 'value' => $check_exist_booking->unit_number];
            $params[] = ['key' => 'apartmentnoar', 'value' => $check_exist_booking->unit_number];
            if ($check_exist_booking->no_month_free > 0) {
                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A"];

//                if ($check_exist_booking->no_month_free > 1) {
//                    $months = $this->getMessage('months', 1);
//                    $months_ar = $this->getMessage('months', 1);
//                }
//                else {
//                    $months = $this->getMessage('month', 2);
//                    $months_ar = $this->getMessage('month', 2);
//                }
//                $params[] = ['key' => 'template', 'value' => "18B67799-8F9F-4A3D-8BBF-1C32A3A01092"];
//                $params[] = ['key' => 'addendumtenantname', 'value' => $check_exist_booking->first_name];
//                $params[] = ['key' => 'addendumtenantqatarid', 'value' => $check_exist_booking->qatar_id];
//                $params[] = ['key' => 'adapartmentno', 'value' => $check_exist_booking->unit_number];
//                $params[] = ['key' => 'adbuildingno', 'value' => $check_exist_booking->tower_no];
//                $params[] = ['key' => 'adnbmonthfreelettres', 'value' => $check_exist_booking->no_month_free_letter_en];
//                $params[] = ['key' => 'nbmonthfreenumbers', 'value' => $check_exist_booking->no_month_free];
//                $params[] = ['key' => 'monthormonths', 'value' => $months];
//                $params[] = ['key' => 'graceperiodstartdate', 'value' => date('d/m/Y', strtotime($common_date))];
//                $params[] = ['key' => 'graceperiodenddate', 'value' => $grace_period_end];
//                $params[] = ['key' => 'adtenantnametwo', 'value' => $check_exist_booking->last_name];
//                $params[] = ['key' => 'addendumworkaddress', 'value' => $check_exist_booking->work_address_place_en];
//                $params[] = ['key' => 'adtenantnamear', 'value' => $check_exist_booking->first_name_ar];
//                $params[] = ['key' => 'adtenantqataridar', 'value' => $check_exist_booking->qatar_id];
//                $params[] = ['key' => 'adworkaddressar', 'value' => $check_exist_booking->work_address_place_ar];
//                $params[] = ['key' => 'adapartmentnoar', 'value' => $check_exist_booking->unit_number];
//                $params[] = ['key' => 'adnbmonthfreelettersar', 'value' => $check_exist_booking->no_month_free_letter_ar];
//                $params[] = ['key' => 'nbmonthfreenumbersar', 'value' => $check_exist_booking->no_month_free];
//                $params[] = ['key' => 'monthormonthsar', 'value' => $months_ar];
//                $params[] = ['key' => 'graceperiodstartdatear', 'value' => date('d/m/Y', strtotime($common_date))];
//                $params[] = ['key' => 'graceperiodenddatear', 'value' => $grace_period_end];
//                $params[] = ['key' => 'adtenantnameartwo', 'value' => $check_exist_booking->last_name_ar];
            }
            else {
                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A"];
            }
            if ($get_property_type != NULL) {
                $params[] = ['key' => 'apartmenttype', 'value' => $get_property_type->name_en];
                $params[] = ['key' => 'apartmenttypear', 'value' => $get_property_type->name_ar];
            }

            $params[] = ['key' => 'buildingno', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingno1', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingnoar', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingnoar1', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'carparkingno', 'value' => $check_exist_booking->parking_slot_numbers];
            $params[] = ['key' => 'carparkingnoar', 'value' => $check_exist_booking->parking_slot_numbers];
            $params[] = ['key' => 'commregnno', 'value' => $check_exist_booking->tower->cr_no];
            $params[] = ['key' => 'commregnnoar', 'value' => $check_exist_booking->tower->cr_no];
            $params[] = ['key' => 'depositamount', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'depositamountar', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'depositamountwords', 'value' => $check_exist_booking->monthly_number_word];
            $params[] = ['key' => 'depositamountwordsar', 'value' => $check_exist_booking->monthly_number_word_ar];
            $params[] = ['key' => 'elecricitymeterno', 'value' => $check_exist_booking->electricity_charge];
            $params[] = ['key' => 'electricitymeternoar', 'value' => $check_exist_booking->electricity_charge];
            $params[] = ['key' => 'furniturestatus', 'value' => $check_exist_booking->furnished_status_en];
            $params[] = ['key' => 'furniturestatusar', 'value' => $check_exist_booking->furnished_status_ar];
            $params[] = ['key' => 'email', 'value' => $check_exist_booking->email];
            $params[] = ['key' => 'emailar', 'value' => $check_exist_booking->email];
            $params[] = ['key' => 'expirydate', 'value' => $effectiveDate];
            $params[] = ['key' => 'expirydatear', 'value' => $effectiveDate];
            $params[] = ['key' => 'expiryyears', 'value' => $duration + $check_exist_booking->no_month_free];
//            $params[] = ['key' => 'expiryyears', 'value' => $no_year];
            $params[] = ['key' => 'expiryyearsar', 'value' => $duration + $check_exist_booking->no_month_free];
//            $params[] = ['key' => 'expiryyearsar', 'value' => $no_year];
            $params[] = ['key' => 'floorno', 'value' => $check_exist_booking->floor_no];
            $params[] = ['key' => 'floornoar', 'value' => $check_exist_booking->floor_no];
            $params[] = ['key' => 'landlordcompany', 'value' => $check_exist_booking->tower->company_name];
            $params[] = ['key' => 'landlordcompanyar', 'value' => $check_exist_booking->tower->company_name_ar];
            $params[] = ['key' => 'leasenumber', 'value' => $check_exist_booking->contract_number];
            $params[] = ['key' => 'leasenumberar', 'value' => $check_exist_booking->contract_number];
            $params[] = ['key' => 'leasestartdate', 'value' => date('d/m/Y', strtotime($check_exist_booking->commoncement_date))];
            $params[] = ['key' => 'leasestartdatear', 'value' => date('d/m/Y', strtotime($check_exist_booking->commoncement_date))];
            $params[] = ['key' => 'leaseterm', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'leasetermar', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'poboxno', 'value' => $check_exist_booking->po_box];
            $params[] = ['key' => 'poboxnoar', 'value' => $check_exist_booking->po_box];
            $params[] = ['key' => 'premisedescription', 'value' => 'PremiseDescription'];
            $params[] = ['key' => 'premisedescriptionar', 'value' => 'PremiseDescriptionar'];
            $params[] = ['key' => 'qatarcoolno', 'value' => $check_exist_booking->cool_meter];
            $params[] = ['key' => 'qatarcoolnoar', 'value' => $check_exist_booking->cool_meter];
            $params[] = ['key' => 'registeredaddress', 'value' => $check_exist_booking->tower->company_address_en];
            $params[] = ['key' => 'registeredaddressar', 'value' => $check_exist_booking->tower->company_address_ar];
            $params[] = ['key' => 'rentamount', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'rentamountar', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'rentamountwords', 'value' => $check_exist_booking->monthly_number_word];
            $params[] = ['key' => 'rentamountwordsar', 'value' => $check_exist_booking->monthly_number_word_ar];
            $params[] = ['key' => 'telephone', 'value' => $check_exist_booking->mobile_number];
            $params[] = ['key' => 'telephonear', 'value' => $check_exist_booking->mobile_number];
            $params[] = ['key' => 'tenantname', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantname1', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantname2', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantnamear', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnamear1', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnamear2', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnationality', 'value' => $check_exist_booking->country->nicename];
            $params[] = ['key' => 'tenantnationalityar', 'value' => $check_exist_booking->country->name_ar];
            $params[] = ['key' => 'tenantqatarid', 'value' => $check_exist_booking->qatar_id];
            $params[] = ['key' => 'tenantqataridar', 'value' => $check_exist_booking->qatar_id];
            $params[] = ['key' => 'watermeterno', 'value' => $check_exist_booking->water_charge];
            $params[] = ['key' => 'watermeternoar', 'value' => $check_exist_booking->water_charge];
            $params[] = ['key' => 'workaddress', 'value' => $check_exist_booking->work_address_place_en];
            $params[] = ['key' => 'workaddressar', 'value' => $check_exist_booking->work_address_place_ar];
            $total_tenant_text_en = $check_exist_booking->total_tenant_period_en . '(' . $check_exist_booking->no_month_free + $check_exist_booking->duration . ')';
            $total_tenant_text_ar = $check_exist_booking->total_tenant_period_ar . '(' . $check_exist_booking->no_month_free + $check_exist_booking->duration . ')';
            $params[] = ['key' => 'totaltenantperioden', 'value' => $check_exist_booking->total_tenant_period_en . '(' . ($check_exist_booking->no_month_free + $check_exist_booking->duration) . ')'];
            $params[] = ['key' => 'totaltenantperiodar', 'value' => $check_exist_booking->total_tenant_period_ar . '(' . ($check_exist_booking->no_month_free + $check_exist_booking->duration) . ')'];
            $params[] = ['key' => 'freemonthdiscounttexten', 'value' => "$check_exist_booking->free_month_discount_text_en"];
            $params[] = ['key' => 'freemonthdiscounttextar', 'value' => "$check_exist_booking->free_month_discount_text_ar"];
            if ($check_exist_booking->utility_status == 1) {
                $params[] = ['key' => 'utilitiesclausetexten', 'value' => $this->getMessage('utility_include', 1)];
                $params[] = ['key' => 'utilitiesclausetextar', 'value' => $this->getMessage('utility_include', 2)];

                $params[] = ['key' => 'utilityapplicabilityen', 'value' => $this->getMessage('utility_not_available', 1)];
                $params[] = ['key' => 'utilityapplicabilityar', 'value' => $this->getMessage('utility_not_available', 2)];
            }
            else {

                $params[] = ['key' => 'utilityapplicabilityen', 'value' => $this->getMessage('utility_available', 1)];
                $params[] = ['key' => 'utilityapplicabilityar', 'value' => $this->getMessage('utility_available', 2)];
                $params[] = ['key' => 'utilitiesclausetexten', 'value' => $this->getMessage('utility_exclude', 1)];
                $params[] = ['key' => 'utilitiesclausetextar', 'value' => $this->getMessage('utility_exclude', 2)];
            }
            $total_cheque_text_en = $check_exist_booking->total_duration_text_en . '(' . $check_exist_booking->duration . ')';
            $total_cheque_text_ar = $check_exist_booking->total_duration_text_ar . '(' . $check_exist_booking->duration . ')';

            $params[] = ['key' => 'numberchequesen', 'value' => $total_cheque_text_en];

            $params[] = ['key' => 'numberchequesar', 'value' => $total_cheque_text_ar];
            $postfields = array("WorkflowInfo" => json_encode($params), "qid_front" => $front, "qid_back" => $back);
            $ctype = "multipart/form-data";
            $make_call = $this->callAPI('POST', $url, $postfields, $ctype);

            $lang = 1;
            $output['front'] = $front;
            $output['back'] = $back;
            $output['input_url'] = $url;
            $output['input_params'] = $params;
            $output['access_token'] = $config->dms_access_token;
            if ($this->isJSON($make_call)) {
                $response = json_decode($make_call, true);
                $output['output'] = $response;
                $array = $this->errorCode(1000, $name, $lang, $output);
            }
            else {

                $output['output'] = $make_call;
                $array = $this->errorCode(2000, $name, $lang, $output);
            }
            return $output['output'];
        }
        else {
            return 0;
        }
    }

    public function uploadSignature($activity_id, $rid) {

        $name = "DMS Contract Generation";

        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $website = $config->website;
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {
            $get_property_type = \common\models\PropertyType::find()->where(['id' => $check_exist_booking->property->type_id, 'status' => 1])->one();
            $common_date = $check_exist_booking->commoncement_date;
            $duration = $check_exist_booking->duration;
            $no_month_free = $check_exist_booking->no_month_free;
            $effectiveDate = date('d/m/Y', strtotime("+" . ($duration + $no_month_free) . " months", strtotime($common_date)));
            $url = "/resources/WorkService/completeWorkflowActivity";
            $f_ext = explode('.', $check_exist_booking->qid_front);
            $b_ext = explode('.', $check_exist_booking->qid_back);
            $front = new \CURLFile(Yii::$app->basePath . "/../uploads/client-booking/" . $rid . "/" . $check_exist_booking->qid_front, 'image/' . $f_ext[1], $check_exist_booking->qid_front);
            $back = new \CURLFile(Yii::$app->basePath . "/../uploads/client-booking/" . $rid . "/" . $check_exist_booking->qid_back, 'image/' . $b_ext[1], $check_exist_booking->qid_back);
            $s_ext = explode('.', $check_exist_booking->signature);
            $signature = new \CURLFile(Yii::$app->basePath . "/../uploads/signature/" . $rid . "/" . $check_exist_booking->signature, 'image/' . $s_ext[1], $check_exist_booking->signature);
            $params[] = ['key' => '$ActivityId', 'value' => $activity_id];
            $params[] = ['key' => '$ResponseId', 'value' => "1"];
            $params[] = ['key' => '$Comments', 'value' => 'Signature'];
            $params[] = ['key' => '$SIGNATURE', 'value' => $check_exist_booking->signature];
            if ($check_exist_booking->equipment_list != '') {
                $equipment_list = new \CURLFile(Yii::$app->basePath . "/../uploads/contracts/" . $check_exist_booking->id . "/" . $check_exist_booking->equipment_list, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', $check_exist_booking->equipment_list);
                $params[] = ['key' => '$ADDENDUM', 'value' => $check_exist_booking->equipment_list];
            }
            if ($check_exist_booking->no_month_free > 0) {
                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A"];
//                $grace_period_end = date('d/m/Y', strtotime("+" . $check_exist_booking->no_month_free . " months", strtotime($common_date)));
//
//                if ($check_exist_booking->no_month_free > 1) {
//                    $months = $this->getMessage('months', 1);
//                    $months_ar = $this->getMessage('months', 1);
//                }
//                else {
//                    $months = $this->getMessage('month', 2);
//                    $months_ar = $this->getMessage('month', 2);
//                }
//                $params[] = ['key' => 'template', 'value' => "18B67799-8F9F-4A3D-8BBF-1C32A3A01092"];
//                $params[] = ['key' => 'addendumtenantname', 'value' => "$check_exist_booking->first_name"];
//                $params[] = ['key' => 'addendumtenantqatarid', 'value' => "$check_exist_booking->qatar_id"];
//                $params[] = ['key' => 'adapartmentno', 'value' => "$check_exist_booking->unit_number"];
//                $params[] = ['key' => 'adbuildingno', 'value' => "$check_exist_booking->tower_no"];
//                $params[] = ['key' => 'adnbmonthfreelettres', 'value' => "$check_exist_booking->no_month_free_letter_en"];
//                $params[] = ['key' => 'nbmonthfreenumbers', 'value' => "$check_exist_booking->no_month_free"];
//                $params[] = ['key' => 'monthormonths', 'value' => "$months"];
//                $params[] = ['key' => 'graceperiodstartdate', 'value' => date('d/m/Y', strtotime($common_date))];
//                $params[] = ['key' => 'graceperiodenddate', 'value' => "$grace_period_end"];
//                $params[] = ['key' => 'adtenantnametwo', 'value' => "$check_exist_booking->last_name"];
//                $params[] = ['key' => 'addendumworkaddress', 'value' => "$check_exist_booking->work_address_place_en"];
//                $params[] = ['key' => 'adtenantnamear', 'value' => "$check_exist_booking->first_name_ar"];
//                $params[] = ['key' => 'adtenantqataridar', 'value' => "$check_exist_booking->qatar_id"];
//                $params[] = ['key' => 'adworkaddressar', 'value' => "$check_exist_booking->work_address_place_ar"];
//                $params[] = ['key' => 'adapartmentnoar', 'value' => "$check_exist_booking->unit_number"];
//                $params[] = ['key' => 'adnbmonthfreelettersar', 'value' => "$check_exist_booking->no_month_free_letter_ar"];
//                $params[] = ['key' => 'nbmonthfreenumbersar', 'value' => "$check_exist_booking->no_month_free"];
//                $params[] = ['key' => 'monthormonthsar', 'value' => "$months_ar"];
//                $params[] = ['key' => 'graceperiodstartdatear', 'value' => date('d/m/Y', strtotime($common_date))];
//                $params[] = ['key' => 'graceperiodenddatear', 'value' => "$grace_period_end"];
//                $params[] = ['key' => 'adtenantnameartwo', 'value' => "$check_exist_booking->last_name_ar"];
            }
            else {
                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A"];
            }

            $params[] = ['key' => '$ATTACHMENT:4', 'value' => "$check_exist_booking->qid_front"];
            $params[] = ['key' => '$ATTACHMENT:4', 'value' => "$check_exist_booking->qid_back"];
            $params[] = ['key' => 'apartmentno', 'value' => "$check_exist_booking->unit_number"];
            $params[] = ['key' => 'apartmentnoar', 'value' => "$check_exist_booking->unit_number"];
//            if ($check_exist_booking->no_month_free > 0) {
//                $params[] = ['key' => 'template', 'value' => "18B67799-8F9F-4A3D-8BBF-1C32A3A01092""];
//            } else {
//                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A""];
//            }
            if ($get_property_type != NULL) {
                $params[] = ['key' => 'apartmenttype', 'value' => "$get_property_type->name_en"];
                $params[] = ['key' => 'apartmenttypear', 'value' => "$get_property_type->name_ar"];
            }
            $params[] = ['key' => 'buildingno', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingno1', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingnoar', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingnoar1', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'carparkingno', 'value' => $check_exist_booking->parking_slot_numbers];
            $params[] = ['key' => 'carparkingnoar', 'value' => $check_exist_booking->parking_slot_numbers];
            $params[] = ['key' => 'commregnno', 'value' => $check_exist_booking->tower->cr_no];
            $params[] = ['key' => 'commregnnoar', 'value' => $check_exist_booking->tower->cr_no];
            $params[] = ['key' => 'depositamount', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'depositamountar', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'depositamountwords', 'value' => $check_exist_booking->monthly_number_word];
            $params[] = ['key' => 'depositamountwordsar', 'value' => $check_exist_booking->monthly_number_word_ar];
            $params[] = ['key' => 'elecricitymeterno', 'value' => $check_exist_booking->electricity_charge];
            $params[] = ['key' => 'electricitymeternoar', 'value' => $check_exist_booking->electricity_charge];
            $params[] = ['key' => 'furniturestatus', 'value' => $check_exist_booking->furnished_status_en];
            $params[] = ['key' => 'furniturestatusar', 'value' => $check_exist_booking->furnished_status_ar];
            $params[] = ['key' => 'email', 'value' => $check_exist_booking->email];
            $params[] = ['key' => 'emailar', 'value' => $check_exist_booking->email];
            $params[] = ['key' => 'expirydate', 'value' => $effectiveDate];
            $params[] = ['key' => 'expirydatear', 'value' => $effectiveDate];
            $params[] = ['key' => 'expiryyears', 'value' => $duration + $check_exist_booking->no_month_free];
//            $params[] = ['key' => 'expiryyears', 'value' => $no_year];
            $params[] = ['key' => 'expiryyearsar', 'value' => $duration + $check_exist_booking->no_month_free];
//            $params[] = ['key' => 'expiryyearsar', 'value' => $no_year];
            $params[] = ['key' => 'floorno', 'value' => $check_exist_booking->floor_no];
            $params[] = ['key' => 'floornoar', 'value' => $check_exist_booking->floor_no];
            $params[] = ['key' => 'landlordcompany', 'value' => $check_exist_booking->tower->company_name];
            $params[] = ['key' => 'landlordcompanyar', 'value' => $check_exist_booking->tower->company_name_ar];
            $params[] = ['key' => 'leasenumber', 'value' => $check_exist_booking->contract_number];
            $params[] = ['key' => 'leasenumberar', 'value' => $check_exist_booking->contract_number];
            $params[] = ['key' => 'leasestartdate', 'value' => date('d/m/Y', strtotime($check_exist_booking->commoncement_date))];
            $params[] = ['key' => 'leasestartdatear', 'value' => date('d/m/Y', strtotime($check_exist_booking->commoncement_date))];
            $params[] = ['key' => 'leaseterm', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'leasetermar', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'poboxno', 'value' => $check_exist_booking->po_box];
            $params[] = ['key' => 'poboxnoar', 'value' => $check_exist_booking->po_box];
            $params[] = ['key' => 'premisedescription', 'value' => 'PremiseDescription'];
            $params[] = ['key' => 'premisedescriptionar', 'value' => 'PremiseDescriptionar'];
            $params[] = ['key' => 'qatarcoolno', 'value' => $check_exist_booking->cool_meter];
            $params[] = ['key' => 'qatarcoolnoar', 'value' => $check_exist_booking->cool_meter];

            $params[] = ['key' => 'registeredaddress', 'value' => $check_exist_booking->tower->company_address_en];
            $params[] = ['key' => 'registeredaddressar', 'value' => $check_exist_booking->tower->company_address_ar];
            $params[] = ['key' => 'rentamount', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'rentamountar', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'rentamountwords', 'value' => $check_exist_booking->monthly_number_word];
            $params[] = ['key' => 'rentamountwordsar', 'value' => $check_exist_booking->monthly_number_word_ar];
            $params[] = ['key' => 'telephone', 'value' => $check_exist_booking->mobile_number];
            $params[] = ['key' => 'telephonear', 'value' => $check_exist_booking->mobile_number];
            $params[] = ['key' => 'tenantname', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantname1', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantname2', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantnamear', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnamear1', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnamear2', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnationality', 'value' => $check_exist_booking->country->nicename];
            $params[] = ['key' => 'tenantnationalityar', 'value' => $check_exist_booking->country->name_ar];
            $params[] = ['key' => 'tenantqatarid', 'value' => $check_exist_booking->qatar_id];
            $params[] = ['key' => 'tenantqataridar', 'value' => $check_exist_booking->qatar_id];
            $params[] = ['key' => 'watermeterno', 'value' => $check_exist_booking->water_charge];
            $params[] = ['key' => 'watermeternoar', 'value' => $check_exist_booking->water_charge];
            $params[] = ['key' => 'workaddress', 'value' => $check_exist_booking->work_address_place_en];
            $params[] = ['key' => 'workaddressar', 'value' => $check_exist_booking->work_address_place_ar];
            $total_tenant_text_en = $check_exist_booking->total_tenant_period_en . '(' . $check_exist_booking->no_month_free + $check_exist_booking->duration . ')';
            $total_tenant_text_ar = $check_exist_booking->total_tenant_period_ar . '(' . $check_exist_booking->no_month_free + $check_exist_booking->duration . ')';
            $params[] = ['key' => 'totaltenantperioden', 'value' => $check_exist_booking->total_tenant_period_en . '(' . ($check_exist_booking->no_month_free + $check_exist_booking->duration) . ')'];
            $params[] = ['key' => 'totaltenantperiodar', 'value' => $check_exist_booking->total_tenant_period_ar . '(' . ($check_exist_booking->no_month_free + $check_exist_booking->duration) . ')'];
            $params[] = ['key' => 'freemonthdiscounttexten', 'value' => "$check_exist_booking->free_month_discount_text_en"];
            $params[] = ['key' => 'freemonthdiscounttextar', 'value' => "$check_exist_booking->free_month_discount_text_ar"];
            if ($check_exist_booking->utility_status == 1) {
                $params[] = ['key' => 'utilitiesclausetexten', 'value' => $this->getMessage('utility_include', 1)];
                $params[] = ['key' => 'utilitiesclausetextar', 'value' => $this->getMessage('utility_include', 2)];

                $params[] = ['key' => 'utilityapplicabilityen', 'value' => $this->getMessage('utility_not_available', 1)];
                $params[] = ['key' => 'utilityapplicabilityar', 'value' => $this->getMessage('utility_not_available', 2)];
            }
            else {

                $params[] = ['key' => 'utilityapplicabilityen', 'value' => $this->getMessage('utility_available', 1)];
                $params[] = ['key' => 'utilityapplicabilityar', 'value' => $this->getMessage('utility_available', 2)];
                $params[] = ['key' => 'utilitiesclausetexten', 'value' => $this->getMessage('utility_exclude', 1)];
                $params[] = ['key' => 'utilitiesclausetextar', 'value' => $this->getMessage('utility_exclude', 2)];
            }
            $total_cheque_text_en = $check_exist_booking->total_duration_text_en . '(' . $check_exist_booking->duration . ')';
            $total_cheque_text_ar = $check_exist_booking->total_duration_text_ar . '(' . $check_exist_booking->duration . ')';

            $params[] = ['key' => 'numberchequesen', 'value' => $total_cheque_text_en];

            $params[] = ['key' => 'numberchequesar', 'value' => $total_cheque_text_ar];
            $postfields = array("WorkflowInfo" => json_encode($params), "signature" => $signature, "qid_front" => $front, "qid_back" => $back);
            if ($check_exist_booking->equipment_list != '') {
                $postfields['document'] = $equipment_list;
            }
            $ctype = "multipart/form-data";
            $make_call = $this->callAPI('POST', $url, $postfields, $ctype);
            $lang = 1;
            $output['siganture'] = $signature;
            $output['input_url'] = $url;
            $output['input_params'] = $params;
            $output['access_token'] = $config->dms_access_token;
            if ($this->isJSON($make_call)) {
                $response = json_decode($make_call, true);
                $output['output'] = $response;
                $array = $this->errorCode(1000, $name, $lang, $output);
            }
            else {

                $output['output'] = $make_call;
                $array = $this->errorCode(2000, $name, $lang, $output);
            }
            return $output['output'];
        }
        else {
            return -1;
        }
    }

    public function updateDmsContract($activity_id, $rid) {

        $name = "DMS Contract Generation";

        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $website = $config->website;
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        if ($check_exist_booking != NULL) {
            $get_property_type = \common\models\PropertyType::find()->where(['id' => $check_exist_booking->property->type_id, 'status' => 1])->one();
            $common_date = $check_exist_booking->commoncement_date;
            $duration = $check_exist_booking->duration;
            $no_month_free = $check_exist_booking->no_month_free;
            $effectiveDate = date('d/m/Y', strtotime("+" . ($duration + $no_month_free) . " months", strtotime($common_date)));
            $url = "/resources/WorkService/completeWorkflowActivity";
            $f_ext = explode('.', $check_exist_booking->qid_front);
            $b_ext = explode('.', $check_exist_booking->qid_back);
            $front = new \CURLFile(Yii::$app->basePath . "/../uploads/client-booking/" . $rid . "/" . $check_exist_booking->qid_front, 'image/' . $f_ext[1], $check_exist_booking->qid_front);
            $back = new \CURLFile(Yii::$app->basePath . "/../uploads/client-booking/" . $rid . "/" . $check_exist_booking->qid_back, 'image/' . $b_ext[1], $check_exist_booking->qid_back);
            $params[] = ['key' => '$ActivityId', 'value' => $activity_id];
            $params[] = ['key' => '$ResponseId', 'value' => "6"];
            $params[] = ['key' => '$Comments', 'value' => 'Contract Updation'];
            $params[] = ['key' => '$SIGNATURE', 'value' => ''];

            if ($check_exist_booking->no_month_free > 0) {
                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A"];

//                $grace_period_end = date('d/m/Y', strtotime("+" . $check_exist_booking->no_month_free . " months", strtotime($common_date)));
//
//                if ($check_exist_booking->no_month_free > 1) {
//                    $months = $this->getMessage('months', 1);
//                    $months_ar = $this->getMessage('months', 1);
//                }
//                else {
//                    $months = $this->getMessage('month', 2);
//                    $months_ar = $this->getMessage('month', 2);
//                }
//                $params[] = ['key' => 'template', 'value' => "18B67799-8F9F-4A3D-8BBF-1C32A3A01092"];
//                $params[] = ['key' => 'addendumtenantname', 'value' => "$check_exist_booking->first_name"];
//                $params[] = ['key' => 'addendumtenantqatarid', 'value' => "$check_exist_booking->qatar_id"];
//                $params[] = ['key' => 'adapartmentno', 'value' => "$check_exist_booking->unit_number"];
//                $params[] = ['key' => 'adbuildingno', 'value' => "$check_exist_booking->tower_no"];
//                $params[] = ['key' => 'adnbmonthfreelettres', 'value' => "$check_exist_booking->no_month_free_letter_en"];
//                $params[] = ['key' => 'nbmonthfreenumbers', 'value' => "$check_exist_booking->no_month_free"];
//                $params[] = ['key' => 'monthormonths', 'value' => "$months"];
//                $params[] = ['key' => 'graceperiodstartdate', 'value' => date('d/m/Y', strtotime($common_date))];
//                $params[] = ['key' => 'graceperiodenddate', 'value' => "$grace_period_end"];
//                $params[] = ['key' => 'adtenantnametwo', 'value' => "$check_exist_booking->last_name"];
//                $params[] = ['key' => 'addendumworkaddress', 'value' => "$check_exist_booking->work_address_place_en"];
//                $params[] = ['key' => 'adtenantnamear', 'value' => "$check_exist_booking->first_name_ar"];
//                $params[] = ['key' => 'adtenantqataridar', 'value' => "$check_exist_booking->qatar_id"];
//                $params[] = ['key' => 'adworkaddressar', 'value' => "$check_exist_booking->work_address_place_ar"];
//                $params[] = ['key' => 'adapartmentnoar', 'value' => "$check_exist_booking->unit_number"];
//                $params[] = ['key' => 'adnbmonthfreelettersar', 'value' => "$check_exist_booking->no_month_free_letter_ar"];
//                $params[] = ['key' => 'nbmonthfreenumbersar', 'value' => "$check_exist_booking->no_month_free"];
//                $params[] = ['key' => 'monthormonthsar', 'value' => "$months_ar"];
//                $params[] = ['key' => 'graceperiodstartdatear', 'value' => date('d/m/Y', strtotime($common_date))];
//                $params[] = ['key' => 'graceperiodenddatear', 'value' => "$grace_period_end"];
//                $params[] = ['key' => 'adtenantnameartwo', 'value' => "$check_exist_booking->last_name_ar"];
            }
            else {
                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A"];
            }

//            $params[] = ['key' => '$ATTACHMENT:4', 'value' => "$check_exist_booking->qid_front"];
//            $params[] = ['key' => '$ATTACHMENT:4', 'value' => "$check_exist_booking->qid_back"];
            $params[] = ['key' => 'apartmentno', 'value' => "$check_exist_booking->unit_number"];
            $params[] = ['key' => 'apartmentnoar', 'value' => "$check_exist_booking->unit_number"];
//            if ($check_exist_booking->no_month_free > 0) {
//                $params[] = ['key' => 'template', 'value' => "18B67799-8F9F-4A3D-8BBF-1C32A3A01092""];
//            } else {
//                $params[] = ['key' => 'template', 'value' => "6461B16A-2056-4D99-B110-02C3BA6BDD0A""];
//            }
            if ($get_property_type != NULL) {
                $params[] = ['key' => 'apartmenttype', 'value' => "$get_property_type->name_en"];
                $params[] = ['key' => 'apartmenttypear', 'value' => "$get_property_type->name_ar"];
            }
            $params[] = ['key' => 'buildingno', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingno1', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingnoar', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'buildingnoar1', 'value' => $check_exist_booking->tower_no];
            $params[] = ['key' => 'carparkingno', 'value' => $check_exist_booking->parking_slot_numbers];
            $params[] = ['key' => 'carparkingnoar', 'value' => $check_exist_booking->parking_slot_numbers];
            $params[] = ['key' => 'commregnno', 'value' => $check_exist_booking->tower->cr_no];
            $params[] = ['key' => 'commregnnoar', 'value' => $check_exist_booking->tower->cr_no];
            $params[] = ['key' => 'depositamount', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'depositamountar', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'depositamountwords', 'value' => $check_exist_booking->monthly_number_word];
            $params[] = ['key' => 'depositamountwordsar', 'value' => $check_exist_booking->monthly_number_word_ar];
            $params[] = ['key' => 'elecricitymeterno', 'value' => $check_exist_booking->electricity_charge];
            $params[] = ['key' => 'electricitymeternoar', 'value' => $check_exist_booking->electricity_charge];
            $params[] = ['key' => 'furniturestatus', 'value' => $check_exist_booking->furnished_status_en];
            $params[] = ['key' => 'furniturestatusar', 'value' => $check_exist_booking->furnished_status_ar];
            $params[] = ['key' => 'email', 'value' => $check_exist_booking->email];
            $params[] = ['key' => 'emailar', 'value' => $check_exist_booking->email];
            $params[] = ['key' => 'expirydate', 'value' => $effectiveDate];
            $params[] = ['key' => 'expirydatear', 'value' => $effectiveDate];
            $params[] = ['key' => 'expiryyears', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'expiryyearsar', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'floorno', 'value' => $check_exist_booking->floor_no];
            $params[] = ['key' => 'floornoar', 'value' => $check_exist_booking->floor_no];
            $params[] = ['key' => 'landlordcompany', 'value' => $check_exist_booking->tower->company_name];
            $params[] = ['key' => 'landlordcompanyar', 'value' => $check_exist_booking->tower->company_name_ar];
            $params[] = ['key' => 'leasenumber', 'value' => $check_exist_booking->contract_number];
            $params[] = ['key' => 'leasenumberar', 'value' => $check_exist_booking->contract_number];
            $params[] = ['key' => 'leasestartdate', 'value' => date('d/m/Y', strtotime($check_exist_booking->commoncement_date))];
            $params[] = ['key' => 'leasestartdatear', 'value' => date('d/m/Y', strtotime($check_exist_booking->commoncement_date))];
            $params[] = ['key' => 'leaseterm', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'leasetermar', 'value' => $duration + $check_exist_booking->no_month_free];
            $params[] = ['key' => 'poboxno', 'value' => $check_exist_booking->po_box];
            $params[] = ['key' => 'poboxnoar', 'value' => $check_exist_booking->po_box];
            $params[] = ['key' => 'premisedescription', 'value' => 'PremiseDescription'];
            $params[] = ['key' => 'premisedescriptionar', 'value' => 'PremiseDescriptionar'];
            $params[] = ['key' => 'qatarcoolno', 'value' => $check_exist_booking->cool_meter];
            $params[] = ['key' => 'qatarcoolnoar', 'value' => $check_exist_booking->cool_meter];

            $params[] = ['key' => 'registeredaddress', 'value' => $check_exist_booking->tower->company_address_en];
            $params[] = ['key' => 'registeredaddressar', 'value' => $check_exist_booking->tower->company_address_ar];
            $params[] = ['key' => 'rentamount', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'rentamountar', 'value' => $check_exist_booking->monthly_rent_number];
            $params[] = ['key' => 'rentamountwords', 'value' => $check_exist_booking->monthly_number_word];
            $params[] = ['key' => 'rentamountwordsar', 'value' => $check_exist_booking->monthly_number_word_ar];
            $params[] = ['key' => 'telephone', 'value' => $check_exist_booking->mobile_number];
            $params[] = ['key' => 'telephonear', 'value' => $check_exist_booking->mobile_number];
            $params[] = ['key' => 'tenantname', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantname1', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantname2', 'value' => $check_exist_booking->first_name . ' ' . $check_exist_booking->last_name];
            $params[] = ['key' => 'tenantnamear', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnamear1', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnamear2', 'value' => $check_exist_booking->first_name_ar . ' ' . $check_exist_booking->last_name_ar];
            $params[] = ['key' => 'tenantnationality', 'value' => $check_exist_booking->country->nicename];
            $params[] = ['key' => 'tenantnationalityar', 'value' => $check_exist_booking->country->name_ar];
            $params[] = ['key' => 'tenantqatarid', 'value' => $check_exist_booking->qatar_id];
            $params[] = ['key' => 'tenantqataridar', 'value' => $check_exist_booking->qatar_id];
            $params[] = ['key' => 'watermeterno', 'value' => $check_exist_booking->water_charge];
            $params[] = ['key' => 'watermeternoar', 'value' => $check_exist_booking->water_charge];
            $params[] = ['key' => 'workaddress', 'value' => $check_exist_booking->work_address_place_en];
            $params[] = ['key' => 'workaddressar', 'value' => $check_exist_booking->work_address_place_ar];
            $total_tenant_text_en = $check_exist_booking->total_tenant_period_en . '(' . $check_exist_booking->no_month_free + $check_exist_booking->duration . ')';
            $total_tenant_text_ar = $check_exist_booking->total_tenant_period_ar . '(' . $check_exist_booking->no_month_free + $check_exist_booking->duration . ')';
            $params[] = ['key' => 'totaltenantperioden', 'value' => $check_exist_booking->total_tenant_period_en . '(' . ($check_exist_booking->no_month_free + $check_exist_booking->duration) . ')'];
            $params[] = ['key' => 'totaltenantperiodar', 'value' => $check_exist_booking->total_tenant_period_ar . '(' . ($check_exist_booking->no_month_free + $check_exist_booking->duration) . ')'];
            $params[] = ['key' => 'freemonthdiscounttexten', 'value' => "$check_exist_booking->free_month_discount_text_en"];
            $params[] = ['key' => 'freemonthdiscounttextar', 'value' => "$check_exist_booking->free_month_discount_text_ar"];
            if ($check_exist_booking->utility_status == 1) {
                $params[] = ['key' => 'utilitiesclausetexten', 'value' => $this->getMessage('utility_include', 1)];
                $params[] = ['key' => 'utilitiesclausetextar', 'value' => $this->getMessage('utility_include', 2)];
                $params[] = ['key' => 'utilityapplicabilityen', 'value' => $this->getMessage('utility_not_available', 1)];
                $params[] = ['key' => 'utilityapplicabilityar', 'value' => $this->getMessage('utility_not_available', 2)];
            }
            else {

                $params[] = ['key' => 'utilityapplicabilityen', 'value' => $this->getMessage('utility_available', 1)];
                $params[] = ['key' => 'utilityapplicabilityar', 'value' => $this->getMessage('utility_available', 2)];
                $params[] = ['key' => 'utilitiesclausetexten', 'value' => $this->getMessage('utility_exclude', 1)];
                $params[] = ['key' => 'utilitiesclausetextar', 'value' => $this->getMessage('utility_exclude', 2)];
            }
            $total_cheque_text_en = $check_exist_booking->total_duration_text_en . '(' . $check_exist_booking->duration . ')';
            $total_cheque_text_ar = $check_exist_booking->total_duration_text_ar . '(' . $check_exist_booking->duration . ')';

            $params[] = ['key' => 'numberchequesen', 'value' => $total_cheque_text_en];

            $params[] = ['key' => 'numberchequesar', 'value' => $total_cheque_text_ar];

            $postfields = array("WorkflowInfo" => json_encode($params));

            $ctype = "multipart/form-data";
            $make_call = $this->callAPI('POST', $url, $postfields, $ctype);
            $lang = 1;
            $output['input_url'] = $url;
            $output['input_params'] = $params;
            $output['access_token'] = $config->dms_access_token;
            if ($this->isJSON($make_call)) {
                $response = json_decode($make_call, true);
                $output['output'] = $response;
                $array = $this->errorCode(1000, $name, $lang, $output);
            }
            else {

                $output['output'] = $make_call;
                $array = $this->errorCode(2000, $name, $lang, $output);
            }
            return $output['output'];
        }
        else {
            return -1;
        }
    }

    public function getActivity($wid, $activity_type) {

        $name = "DMS Get Activity ID ";

        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $url = "/resources/WorkService/getWorkActivityOfType?workid=" . $wid . "&activitytype=" . $activity_type;
        $ctype = "multipart/form-data";
        $postfields['workid'] = $wid;
        $postfields['activitytype'] = $activity_type;
        $make_call = $this->callAPIACTIVITY('GET', $url, $postfields, $ctype);
        $lang = 1;

        $result['name'] = $name;
        $result['url'] = $url;
        $result['input'] = $postfields;
        $result['output'] = $make_call;

        $array = $this->errorCode(9000, $name, $lang, $result);
        return $make_call;
    }

    public function getDocumentId($get_activity) {

        $name = "Get Contract Document ID";

        $url = "/resources/WorkService/getActivityPrimaryDocumentId?id=" . $get_activity;
        $ctype = "multipart/form-data";
        $postfields['id'] = $get_activity;
        $make_call = $this->callAPI('GET', $url, $postfields, $ctype);
        $lang = 1;
        $result['name'] = $name;
        $result['url'] = $url;
        $result['input'] = $postfields;
        $result['output'] = $make_call;
        $array = $this->errorCode(2000, $name, $lang, $result);

        return $make_call;
    }

    public function getDocument($doc_id, $rid, $type) {

        $name = "Get Contract Document";
        if ($type == 2) {

            $url = "/resources/DocumentService/downloadAnnotatedDocument?id=" . $doc_id;
        }
        else {
            $url = "/resources/DocumentService/downloadPrintDocument?id=" . $doc_id;
        }
        $ctype = "multipart/form-data";
        $postfields['id'] = $doc_id;
        $postfields['rid'] = $rid;
        $make_call = $this->callBlobAPI('GET', $url, $postfields, $ctype);
        return $make_call;
    }

    public function getMaterValue($param) {
        $get_value = \common\models\CrmMaster::find()->where(['can_name' => $param, 'status' => 1])->one();
        if ($get_value != NULL) {
            return $get_value->val;
        }
        else {
            return "";
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
        }
        else {

            $array = $this->errorCode(1000, $name, $lang, $params);
            return $response['records'];
        }
    }

    function callAPII($method, $url, $data, $ctype) {
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        $access_token = $this->GetAccessToken();

        if ($access_token != '') {
            $site_url = $config->dms_base_url;
            $post_url = $site_url . $url;
            $header = array(
                "token: $access_token",
                "Content-Type: multipart/form-data"
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_BUFFERSIZE, 128);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// EXECUTE:
            $result = curl_exec($ch);
            if (!$result) {
                die("Connection Failure");
            }
            curl_close($ch);
            return $result;
        }
        else {
            return 'Access token not getting';
        }
    }

    function callAPI($method, $url, $data, $ctype) {
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        $access_token = $this->GetAccessToken();
        if ($access_token != '') {
            $site_url = $config->dms_base_url;
            $post_url = $site_url . $url;
            $curl = curl_init();

            switch ($method) {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                default:
                    $url = $post_url;
            }
// OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $post_url);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: ' . $ctype,
                'token: ' . $access_token,
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

// EXECUTE:
            $result = curl_exec($curl);

            $error_msg = [];
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
            }
//            $info = curl_getinfo($curl);
            if (!$result) {
                $return['message'] = "Connection Failure";
                $return['post_values'] = $data;
//                $return['info'] = $info;
                $return['error'] = $error_msg;
                $return['response'] = $result;
                curl_close($curl);
                return $return;
//                die("Connection Failure" . $method . '-post_url-' . $post_url);
            }
            curl_close($curl);

            return $result;
        }
        else {
            return 'Access token not getting';
        }
    }

    function callAPIACTIVITY($method, $url, $data, $ctype) {
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        $access_token = $this->GetAccessToken();
        if ($access_token != '') {
            $site_url = $config->dms_base_url;
            $post_url = $site_url . $url;
            $curl = curl_init();

            switch ($method) {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                default:
                    $url = $post_url;
            }
// OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $post_url);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: ' . $ctype,
                'token: ' . $access_token,
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

// EXECUTE:
            $result = curl_exec($curl);
            $error_msg = [];
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
            }
            $info = curl_getinfo($curl);
//            if (!$result) {
//                $return['message'] = "Connection Failure";
//                $return['post_values'] = $data;
////                $return['info'] = $info;
//                $return['error'] = $error_msg;
//                $return['response'] = $result;
//                return $return;
////                die("Connection Failure" . $method . '-post_url-' . $post_url);
//            }
            curl_close($curl);

            return $result;
        }
        else {
            return 'Access token not getting';
        }
    }

    function callBlobAPI($method, $url, $data, $ctype) {
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        $access_token = $this->GetAccessToken();
        if ($access_token != '') {

            $site_url = $config->dms_base_url;
            $post_url = $site_url . $url;


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $post_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    'token: ' . $access_token,
                ),
            ));

            $response = curl_exec($curl);
            return $response;
        }
        else {
            return 'Access token not getting';
        }
    }

    function calljsonAPI($method, $url, $data, $ctype) {
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        $access_token = $this->GetAccessToken();
        if ($access_token != '') {
            $site_url = $config->dms_base_url;
            $post_url = $site_url . $url;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $post_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "token: " . $access_token,
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);

            $info = curl_getinfo($curl);
            if (!$response) {
                $return['message'] = "Connection Failure";
                $return['post_values'] = $data;
                return $return;
//                die("Connection Failure" . $method . '-post_url-' . $post_url);
            }
            curl_close($curl);
            return $response;
        }
        else {
            return 'Access token not getting';
        }
    }

    function getimage($id, $w) {
        $site_url = "http://185.62.238.17/~qmstaging";
//    $i = 0;
        $multiCurl = array();
// data to be returned
// multi handle
        $mh = curl_multi_init();

        $fetchURL = $site_url . "/index.php/rest/default/V1/categories/" . $id;
//    $url[$i] = $fetchURL;
        $multiCurl[$w] = curl_init($fetchURL);
        curl_setopt($multiCurl[$w], CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($multiCurl[$w], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($multiCurl[$w], CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer hqxx120aw0ow9btew3s7387fuehfsu1t"));
        curl_multi_add_handle($mh, $multiCurl[$w]);


        $running = null;
        do {
            curl_multi_exec($mh, $running);
        }
        while ($running > 0);


        $newresultdecode = curl_multi_getcontent($multiCurl[$w]);
        $resultfinal = json_decode($newresultdecode, true);
        $array = json_decode(json_encode($resultfinal), True);
        $image = $site_url . "/pub/media/catalog/category/All-01.png";
        if ($newresultdecode != NULL) {
            if ($newresultdecode['custom_attributes'][0]['attribute_code'] == "image") {
                $img = $newresultdecode['custom_attributes'][0]['value'];

                if ($img != "") {
                    $image = $site_url . "/pub/media/catalog/category/" . $img;
                }
                else {
                    $image = $site_url . "/pub/media/catalog/category/All-01.png";
                }
            }
            else {
                $image = $site_url . "/pub/media/catalog/category/All-01.png";
            }
        }
        else {
            $image = $site_url . "/pub/media/catalog/category/All-01.png";
        }
        curl_multi_remove_handle($mh, $multiCurl[$w]);
        curl_multi_close($mh);
        return $image;
    }

    function updateAfterDmsAction($contract_number, $contract_status) {
        $name = "DMS Updation after data-" . $contract_status;
        $lang = 1;

        if (isset($contract_number) && $contract_number != '') {
            $contract_number = $contract_number;
        }
        else {
            $array = $this->getCode(411, $name, $lang, "");
            $array['message'] = $array['message'] . '.DMS Connection - contract_number required';
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->data = $array;
            Yii::$app->end();
        }
        if (isset($contract_status) && $contract_status != '') {
            $contract_status = $contract_status;
        }
        else {
            $array = $this->getCode(411, $name, $lang, "");
            $array['message'] = $array['message'] . '.DMS Connection - contract_status required';
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->data = $array;
            Yii::$app->end();
        }

        $create_contract = "";
        $cstatus = "";
        $params1 = [];
        $check_booking_form_exist = \common\models\ClientBookingForm::find()->where(['status' => 1, 'contract_number' => $contract_number])->one();

        if ($check_booking_form_exist != NULL) {

            $check_booking_form_exist->contract_status = $contract_status;
            $params1 = [];
            if ($check_booking_form_exist->save()) {


                $check_avail = [];
                $check_avail[] = $check_booking_form_exist->agent_id;

                $reciever_type = 2;
                $notification_type = 2;

                $notif_key['redirection'] = 'PDF_VISUALIZER';
                $notif_key['contract_url'] = 'uploads/contracts/' . $check_booking_form_exist->id . '/' . $check_booking_form_exist->contract_file;
                $notif_key['booking_form_id'] = $check_booking_form_exist->id;

                $template_key["{%property_id%}"] = $check_booking_form_exist->property->property_id;
                $template_key["{%user_name%}"] = $check_booking_form_exist->user->name;
                if ($contract_status == 8) {
                    $update_history = Yii::$app->CommonRequest->addHistory($check_booking_form_exist->id, 8, "Contract Generated to CMS.", $check_booking_form_exist->agent_id, 0);

                    $this->sendNotif($template_key, 'contract_generated_description', 'contract_generated_title', $check_avail, $notif_key, $notification_type, $reciever_type);
                }
                else if ($contract_status == 11) {
                    $update_history = Yii::$app->CommonRequest->addHistory($check_booking_form_exist->id, 11, "Contract Regenerated to CMS.", $check_booking_form_exist->agent_id, 0);
                    $check_booking_form_exist->contract_status = 12;
                    $check_booking_form_exist->save(FALSE);

                    $this->sendNotif($template_key, 'contract_regenerated_description', 'contract_regenerated_title', $check_avail, $notif_key, $notification_type, $reciever_type);
                }
                else if ($contract_status == 14) {

                    $get_booking_user = \common\models\Users::find()->where(['status' => 10, 'id' => $check_booking_form_exist->user_id])->one();
                    $agent_details = \common\models\Users::find()->where(['status' => 10, 'id' => $check_booking_form_exist->agent_id, 'account_type_id' => 3])->one();
                    if ($get_booking_user != NULL) {
                        $get_tower = \common\models\Tower::find()->where(['status' => 1, 'code' => $check_booking_form_exist->tower_no])->one();
                        $common_date = $check_booking_form_exist->commoncement_date;
                        $duration = $check_booking_form_exist->duration;
                        $effectiveDate = date('d/m/Y', strtotime("+" . $duration . " monthd", strtotime($common_date)));
                        $get_cheq = \common\models\Cheque::find()->where(['booking_form_id' => $check_booking_form_exist->id, 'cheque_type' => 1])->limit(12)->all();
                        $cheqs = [];
                        if ($get_cheq != NULL) {
                            $i = 0;
                            foreach ($get_cheq as $che) {
                                if ($che->cheque_type == 0) {
                                    $cheqs[$i]['Remarks'] = "Security Cheque";
                                }
                                else {
                                    $cheqs[$i]['Remarks'] = 'Rent Out Cheque';
                                }
                                $cheque_amount = round($che->amount, 2);
                                $cheqs[$i]['ChequeStatus__id'] = Yii::$app->ApiManager->getMaterValue('cheque-status-not-cleared');
                                $cheqs[$i]['ChequeRemarks'] = "Rental";
                                $cheqs[$i]['ChequeNumber'] = $che->cheque_number;
                                $cheqs[$i]['ChequeDate'] = date('d/m/Y', strtotime($che->cheque_date));
                                $cheqs[$i]['Bank'] = $che->bank;
                                $cheqs[$i]['Amount'] = "$cheque_amount";
                                $cheqs[$i]['ERPDebitVoucherNo'] = "Test1";
                                $cheqs[$i]['ERPCreditVoucherNo'] = "Test1";
                                $cheqs[$i]['PaymentMode__id'] = Yii::$app->ApiManager->getMaterValue('payment-mode-cheque');
                                $i++;
                            }
                        }
                        $params1['lineItems'] = $cheqs;
                        $price = $check_booking_form_exist->monthly_rent_number;
                        $rent_anuam = round($check_booking_form_exist->monthly_rent_number * 12, 2);
                        $rent_per_period = round($check_booking_form_exist->monthly_rent_number, 2);
                        $amount_jh = round($check_booking_form_exist->monthly_rent_number * $check_booking_form_exist->duration, 2);
                        $actual_month = ($check_booking_form_exist->duration) - $check_booking_form_exist->no_month_free;
                        $params1['Title'] = "$check_booking_form_exist->id";
                        $params1['ContractNumber'] = $check_booking_form_exist->contract_number;
                        $params1['PropertyId__code'] = $check_booking_form_exist->tower_no;
                        $params1['UnitId__id'] = $check_booking_form_exist->units->master_id;
                        $params1['LeaseStartDate'] = date('d/m/Y', strtotime($common_date));
                        $params1['LeaseEndDate'] = $effectiveDate;
                        $params1['NoOfInstalments'] = "$actual_month";
                        $params1['InstalmentStartDate'] = date('d/m/Y', strtotime($check_booking_form_exist->commoncement_date));
                        $params1['AdvancePayment'] = "";
                        $params1['TotalArea'] = $check_booking_form_exist->property->surface;
                        $params1['Rate'] = "$price";
                        $params1['SalesPersonId__id'] = "0";
                        $params1['AgentId__id'] = $check_booking_form_exist->agent->master_id;
                        $params1['RentPerAnum'] = "$rent_anuam";
                        $params1['RentPerPeriod'] = "$rent_per_period";
                        $params1['OtherCharges'] = " ";
                        $params1['Commission'] = "0.00";
                        $params1['SecurityDeposit'] = "";
                        $params1['Terms'] = "79874";
                        $params1['Name'] = $check_booking_form_exist->user->name;
                        $params1['AssignedTo__id'] = Yii::$app->ApiManager->getMaterValue('assign-rems');
                        $params1['LocationId__id'] = "0";
                        $params1['AmountJH'] = "$amount_jh";
                        $params1['ContractStatus__id'] = Yii::$app->ApiManager->getMaterValue('contract-status-valid');
                        $params1['ContactId__id'] = Yii::$app->ApiManager->getMaterValue('contact-persion');
                        $params1['CustomerId__id'] = $check_booking_form_exist->user->master_id;
                        $params1['TenantName'] = $check_booking_form_exist->user->name . ' ' . $check_booking_form_exist->user->last_name;
//                                $params1['TenantCode'] = "$check_booking_form_exist->user_id.0";
                        $params1['DepositBank__id'] = $get_tower->deposit_bank_id;
                        $params1['CommissionPerc'] = "0.00";
                        $params1['AgentEmail'] = $check_booking_form_exist->agent->email;
                        $params1['ContractType__id'] = Yii::$app->ApiManager->getMaterValue('contract-type-name');
                        $params1['ContractDate'] = date('d/m/Y', strtotime($check_booking_form_exist->commoncement_date));
                        $params1['Mobile'] = $check_booking_form_exist->user->phone;
                        $params1['Email'] = $check_booking_form_exist->user->email;
                        $params1['QID'] = $check_booking_form_exist->qatar_id;
                        $params1['ContractStatus__name'] = "Valid";




                        $master = 0;
//                        $create_contract = 0;
                        if (Yii::$app->ErrorCode->getGlobalVariable('environment') == "P") {


                            $create_contract = Yii::$app->ApiManager->createContract($params1, $master);
                        }
                        $array = $this->getCode(5000, $name, $lang, $create_contract);

                        if ($create_contract['errors'] == null) {
                            $update_history = Yii::$app->CommonRequest->addHistory($check_booking_form_exist->id, 14, "Contract Created On CRM.", $check_booking_form_exist->agent_id, 0);

                            $check_booking_form_exist->contract_id = $create_contract['id'];
                            $check_booking_form_exist->save(FALSE);
                            $cstatus = "Done";
                        }
                        else {
                            $check_booking_form_exist->contract_status = 13;
                            $check_booking_form_exist->save(FALSE);

                            $cstatus = "Not Done";
                        }
                    }
                }
                $array = $this->getCode(200, $name, $lang, "");
                $array['message'] = 'Data Saved Successfully';
                $array['response'] = $create_contract;
                $array['response_status'] = $cstatus;
                $array['data'] = [];
                $array['records'] = json_encode($params1);
                $array['contract_id'] = $check_booking_form_exist->contract_id;
                return $array;
            }
            else {
                $array = $this->getCode(411, $name, $lang, "");
                $array['errors'] = $check_booking_form_exist->errors;
                $array['data'] = [];
                return $array;
            }
        }
    }

    function initiatedmscontract($rid) {


        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();

        if ($check_exist_booking != NULL) {
            $work_id = 0;
            if ($check_exist_booking->workflow_id != 0) {
                $work_id = $check_exist_booking->workflow_id;
            }
            else {
                $result = Yii::$app->DmsapiManager->generateContract($rid);
                if ($result != 0) {
                    $update_history = Yii::$app->CommonRequest->addHistory($rid, 900, "Contract created on DMS ", $check_exist_booking->agent_id, 0);

                    $check_exist_booking->workflow_id = $result;
                    if ($check_exist_booking->save(FALSE)) {

                        $get_activity_info = Yii::$app->DmsapiManager->getActivityInfo($check_exist_booking->id, "A_tenantsignature");
                        if ($get_activity_info != 0 && is_array($get_activity_info)) {
                            $attachments = $get_activity_info['attachments'];
                            $front_dms = '';
                            $back_dms = '';
                            if ($attachments != NULL) {
                                $front_dms = $attachments[1]['docId'];
                                $back_dms = $attachments[2]['docId'];

                                if ($front_dms != '') {
                                    $check_exist_booking->qid_front_dms_reference = $front_dms;
                                }
                                if ($back_dms != '') {
                                    $check_exist_booking->qid_back_dms_reference = $back_dms;
                                }
                                $check_exist_booking->save(FALSE);
                                $name = "Qatar ID reference updaredsuccessfully";
                                $log['output'] = "Qatar ID reference updaredsuccessfully";
                                $lang = 1;
                                $array = Yii::$app->ErrorCode->getCodeReservation(411, $name, $lang, $log);
                            }
                        }
                        else {
                            $name = "DMS Info";
                            $log['output'] = "DMS Info not getting";
                            $lang = 1;
                            $log['error'] = $get_activity_info;
                            $array = Yii::$app->ErrorCode->getCodeReservation(411, $name, $lang, $log);
                        }
                        $work_id = $check_exist_booking->workflow_id;
                    }
                }
            }

            $security_check = "";
            $get_document_id = 0;
            $get_document = "";
            $ok = "";
            if ($work_id != 0) {
                if ($check_exist_booking->current_activity_id != 0 && $check_exist_booking->current_activity_id != "") {
                    $get_activity = $check_exist_booking->current_activity_id;
                }
                else {
                    $get_activity = Yii::$app->DmsapiManager->getActivity($work_id, 'A_tenantsignature');
                }
                if ($get_activity != 0 && !is_array($get_activity)) {
                    $check_exist_booking->current_activity_id = $get_activity;
                    $check_exist_booking->save(FALSE);
                    $get_cheque_details = \common\models\Cheque::find()->where(['booking_form_id' => $rid, 'cheque_type' => 0])->one();
                    if ($get_cheque_details != NULL) {
                        $save_cheques = "";
                        if ($get_cheque_details->dms_cheque_reference != '') {
                            $check_ref_no = $get_cheque_details->dms_cheque_reference;
                            $c_ext = explode('.', $get_cheque_details->cheque_image);
                            $check_items[] = ['docId' => $check_ref_no, 'docTitle' => $get_cheque_details->cheque_image, 'format' => 'image/' . $c_ext[1], 'docType' => ['id' => 3]];
                            $save_cheques = Yii::$app->DmsapiManager->saveChequeActivity($check_items, $get_activity);
                        }
                        else {
                            $security_check = Yii::$app->DmsapiManager->securityCheck($rid, 0);
                            if (is_array($security_check)) {
                                $get_cheque_details->dms_cheque_update_status = 1;
                                $get_cheque_details->save(FALSE);
                                $check_ref_no = $security_check['output'];
                                $name = "Security Cheque output";
                                $log['output'] = $security_check;
                                $lang = 1;
                                $array = Yii::$app->ErrorCode->getCodeReservation(411, $name, $lang, $log);
                                $c_ext = explode('.', $get_cheque_details->cheque_image);
                                $check_items[] = ['docId' => $check_ref_no, 'docTitle' => $get_cheque_details->cheque_image, 'format' => 'image/' . $c_ext[1], 'docType' => ['id' => 3]];
                                $save_cheques = Yii::$app->DmsapiManager->saveChequeActivity($check_items, $get_activity);
                            }
                            else {
                                $check_ref_no = $security_check;

                                $c_ext = explode('.', $get_cheque_details->cheque_image);
                                $check_items[] = ['docId' => $check_ref_no, 'docTitle' => $get_cheque_details->cheque_image, 'format' => 'image/' . $c_ext[1], 'docType' => ['id' => 3]];
                                $save_cheques = Yii::$app->DmsapiManager->saveChequeActivity($check_items, $get_activity);
                            }
                        }

                        if ($save_cheques["output"] == "OK") {
                            $update_history = Yii::$app->CommonRequest->addHistory($rid, 901, "Security Cheque Added on DMS ", $check_exist_booking->agent_id, 0);
                            $get_document_id = Yii::$app->DmsapiManager->getDocumentId($get_activity);
                            if (is_array($get_document_id)) {

                            }
                            else {
                                $check_exist_booking->dms_document_id = $get_document_id;
                                $check_exist_booking->save(FALSE);
                                $get_document = Yii::$app->DmsapiManager->getDocument($get_document_id, $check_exist_booking->id, 1);
                                $name = md5(microtime());
                                if (!is_dir(Yii::$app->basePath . '/../uploads/contracts/' . $check_exist_booking->id)) {
                                    mkdir(Yii::$app->basePath . '/../uploads/contracts/' . $check_exist_booking->id);
                                    chmod(Yii::$app->basePath . '/../uploads/contracts/' . $check_exist_booking->id, 0777);
                                }
                                if (file_put_contents(Yii::$app->basePath . "/../uploads/contracts/" . $check_exist_booking->id . '/' . $name . '.pdf', $get_document)) {
                                    if ($check_exist_booking->contract_file != '') {
                                        $data = Yii::$app->basePath . "/../uploads/contracts/" . $check_exist_booking->id . "/" . $check_exist_booking->contract_file;
                                        if (file_exists($data)) {
                                            chmod($data, 0777);
//                                            unlink($data);
                                        }
                                    }
                                    $update_history = Yii::$app->CommonRequest->addHistory($rid, 902, "Generated Contract Saved on CMS ", $check_exist_booking->agent_id, 0);

                                    $check_exist_booking->contract_file = $name . '.pdf';
                                    $check_exist_booking->dms_security_contract_status = 2;
                                    $check_exist_booking->save(FALSE);
                                    $ok = "OK";
                                }
                            }
                        }
                    }
                }
            }
        }
        $lang = 1;
        $name = "Initiate Contract";

        $array['workflo_status'] = $result;
        $array['workflo_id'] = $work_id;
        $array['activity_id'] = $get_activity;
        $array['security_check'] = $check_ref_no;
        $array['save_cheque'] = $save_cheques;
        $array['get_document_id'] = $get_document_id;
        $array['get_document'] = $check_exist_booking->contract_file;
        $array['dms_status'] = $ok;

        $adad = $this->errorCode(8000, $name, $lang, $array);

        return $array;
    }

    function uploadSignatureToDms($rid, $activity_type) {
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        $update_signature_with_dms_response = -1;
        $ok = "";
        $update_signature_with_dms = "";
        $get_document_id = "";
        if ($check_exist_booking != NULL) {
            $work_id = $check_exist_booking->workflow_id;
            $update_signature_with_dms = "NO getting";
            if ($work_id != 0) {
                $get_activity = Yii::$app->DmsapiManager->getActivity($work_id, $activity_type);
                if ($get_activity != 0 && !is_array($get_activity)) {
                    $check_exist_booking->current_activity_id = $get_activity;
                    $check_exist_booking->save(FALSE);
                }
                else {
                    $get_activity = $check_exist_booking->current_activity_id;
                }
                if ($get_activity != 0) {


//                    $check_exist_booking->current_activity_id = $get_activity;
//                    $check_exist_booking->save(FALSE);
                    $update_signature_with_dms = Yii::$app->DmsapiManager->uploadSignature($get_activity, $rid);
                    if (isset($update_signature_with_dms)) {
                        if ($update_signature_with_dms != -1) {
                            if (isset($update_signature_with_dms['response']) && $update_signature_with_dms['response'] == 0) {
//                        $update_signature_with_dms_response = $update_signature_with_dms['response'];
                                $mdl = new \common\models\Enquiry();
                                $mdl->message = 'testing' . $update_signature_with_dms['response'];
                                $mdl->save(FALSE);

                                $get_document_id = Yii::$app->DmsapiManager->getDocumentId($get_activity);
                                if (is_array($get_document_id)) {

                                }
                                else {
                                    $check_exist_booking->dms_document_id = $get_document_id;
                                    $check_exist_booking->save(FALSE);
                                    $get_document = Yii::$app->DmsapiManager->getDocument($get_document_id, $check_exist_booking->id, 1);
                                    $name = md5(microtime());
                                    if (!is_dir(Yii::$app->basePath . '/../uploads/contracts/' . $check_exist_booking->id)) {
                                        mkdir(Yii::$app->basePath . '/../uploads/contracts/' . $check_exist_booking->id);
                                        chmod(Yii::$app->basePath . '/../uploads/contracts/' . $check_exist_booking->id, 0777);
                                    }
                                    if (file_put_contents(Yii::$app->basePath . "/../uploads/contracts/" . $check_exist_booking->id . '/' . $name . '.pdf', $get_document)) {
                                        if ($check_exist_booking->contract_file != '') {
                                            $data = Yii::$app->basePath . "/../uploads/contracts/" . $check_exist_booking->id . "/" . $check_exist_booking->contract_file;
                                            if (file_exists($data)) {
                                                chmod($data, 0777);
//                                                unlink($data);
                                            }
                                        }
                                        $check_exist_booking->contract_file = $name . '.pdf';
                                        $check_exist_booking->dms_signature_status = 2;
                                        $check_exist_booking->save(FALSE);

                                        $ok = "OK";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $array['workflo_id'] = $work_id;
        $array['activity_id'] = $get_activity;
        $array['document_status'] = $get_document_id;
        $array['signature_status'] = $update_signature_with_dms;
        $array['signature'] = $ok;
        return $array;
    }

    function uploadtwelvecheque($rid, $activity_type) {
        $check_exist_booking = \common\models\ClientBookingForm::find()->where(['id' => $rid, 'status' => 1])->one();
        $ok = "";
        $check_response = [];
        if ($check_exist_booking != NULL) {
            $work_id = $check_exist_booking->workflow_id;
            $update_signature_with_dms = "Not getting";
            if ($work_id != 0) {
//                $get_activity = Yii::$app->DmsapiManager->getActivity($work_id);
//                $get_activity = $check_exist_booking->current_activity_id;
                $get_activity = Yii::$app->DmsapiManager->getActivity($work_id, $activity_type);
                if ($get_activity != 0 && !is_array($get_activity)) {
                    $check_exist_booking->current_activity_id = $get_activity;
                    $check_exist_booking->save(FALSE);
                }
                else {
                    $get_activity = $check_exist_booking->current_activity_id;
                }
                if ($get_activity != 0) {

                    $get_twelve_cheque = \common\models\Cheque::find()->where(['status' => 1, 'booking_form_id' => $check_exist_booking->id, 'cheque_type' => 1])->all();
                    if ($get_twelve_cheque != NULL) {
                        foreach ($get_twelve_cheque as $get_cheque_details) {
                            $save_cheques = "";
                            if ($get_cheque_details->dms_cheque_reference != '') {

                            }
                            else {
                                $security_check = Yii::$app->DmsapiManager->twelveCheck($check_exist_booking->id, 1, $get_cheque_details);
                                $check_response[] = $security_check;
                                $get_cheque_details->dms_cheque_update_status = 1;
                                $get_cheque_details->save(FALSE);
                            }
                        }
                    }
                    $get_twelve_cheque = \common\models\Cheque::find()->where(['status' => 1, 'booking_form_id' => $check_exist_booking->id, 'cheque_type' => 1])->all();
                    if ($get_twelve_cheque != NULL) {
                        $check_items = [];
                        foreach ($get_twelve_cheque as $get_cheque_details) {
                            $save_cheques = "";
                            if ($get_cheque_details->dms_cheque_reference != '') {
                                $check_ref_no = $get_cheque_details->dms_cheque_reference;
                                $c_ext = explode('.', $get_cheque_details->cheque_image);
                                $check_items[] = ['docId' => $check_ref_no, 'docTitle' => $get_cheque_details->cheque_image, 'format' => 'image/' . $c_ext[1], 'docType' => ['id' => 5]];
                            }
                        }

                        if ($check_items != NULL) {
                            $save_cheques = Yii::$app->DmsapiManager->saveChequeActivity($check_items, $get_activity);
                            if ($save_cheques['output'] == "OK") {
                                $check_exist_booking->dms_twelve_cheque_status = 2;
                                $check_exist_booking->save(FALSE);
                                $ok = "OK";
                            }
                        }
                    }
                }
            }
        }
        $array['workflo_id'] = $work_id;
        $array['activity_id'] = $get_activity;
        $array['cheque_items'] = $check_items;
//        $array['add_cheque_response'] = $check_response;
        $array['response'] = $ok;
        $array['response_out'] = $save_cheques;
        return $array;
    }

    public function GetAccessToken() {
        date_default_timezone_set('Asia/Qatar');
        $get_token = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        if ($get_token->dms_access_token == '' || $get_token->dms_token_last_updated_on == '0000-00-00 00:00:00') {
            $token = $this->generateToken();
            if ($token != "") {
                $get_token->dms_access_token = $token;
                $get_token->dms_token_last_updated_on = date('Y-m-d H:i:s');
                $get_token->save(FALSE);
            }
        }
        else {
            $last_updated = $get_token->dms_token_last_updated_on;
            $last_timestamp = strtotime($last_updated);
            $current_time = strtotime(date('Y-m-d H:i:s'));
            $new_time = strtotime('+1 minutes', $last_timestamp);
            if ($current_time >= $new_time) {
                $token = $this->generateToken();
                if ($token != "") {
                    $get_token->dms_access_token = $token;
                    $get_token->dms_token_last_updated_on = date('Y-m-d H:i:s');
                    $get_token->save(FALSE);
                }
            }
            else {
                $token = $get_token->dms_access_token;
            }
        }

        return $token;
    }

    public function generateToken() {
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        if ($config != NULL) {
            $name = "Get DMS Access token";
//        $this->layout = false;
//        header('Content-type:appalication/json');
            $site_url = $config->dms_base_url;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $site_url . "/resources/UserService/authenticateUser",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "userid: " . base64_encode($config
                            ->dms_user_name
                    ),
                    "password: " . base64_encode($config->dms_password)
                ),
            ));

            $response = curl_exec($curl);

            $result = json_decode($response, true);

            if ($this->isJSON($response)) {
                return '';
            }
            else {
                return $response;
            }
        }
        else {
            return '';
        }
    }

    function isJSON($string) {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    function getViewType($type) {
        $check_view_type = \common\models\ViewType::find()->where(['label' => $type])->one();
        if
        ($check_view_type != NULL) {
            return $check_view_type->id;
        }
        else {
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

    function getPropertyType($type) {
        $check_view_type = \common\models\PropertyType::find()->where(['name_en' => $type])->one();

        if ($check_view_type != NULL) {
            return $check_view_type->id;
        }
        else {
            $model = new \common\models\PropertyType();
            $model->name_en = $type;
            $model->name_ar = $type;

            $name = $type;
            $name = str_replace(' ', '_', $name);
            $name = rtrim($name, '_');
            $model->can_name = strtoupper($name);
            $model->save(FALSE);
            return $model->id;
        }
    }

    function errorCode($code, $name, $lang, $value = "") {

        $retun = [];

        $file_size = filesize(Yii ::$app->basePath . "/../uploads/logs/crm_app_log.txt");
        $size = $file_size / 1000;
        if ($size >= 1000) {
            $old_name = Yii::$app->basePath . "/../uploads/logs/crm_app_log.txt";
            $new_name = Yii::$app->basePath . "/../uploads/logs/crm_app_log" . date('Y-m-d') . ".txt";
            rename($old_name, $new_name);
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/crm_app_log.txt', "a") or die("Unable to open file!");
        }
        else {
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/crm_app_log.txt', "a") or die("Unable to open file!");
        }

        if ($code != 2000) {
            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Error code : ' . $code;
        }
        else {

            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Success : ' . $code;
        }
        $imp = '';
//        if ($value != '') {
//            if (is_array($value)) {
//                $imp = serialize($value);
//            }
//        }
        if ($value != '') {
            if (is_array($value)) {
                $imp = json_encode($value);
            }
            else {
                $imp = $value;
            }
        }
        fwrite($fp, "\r\n" . $write_data);
        fwrite($fp, "\r\n" . $imp);
        fclose($fp);





        return $retun;
    }

    function getMessage($message, $lang) {
        $get_message = \common\models\MobileStrings::find()->where(['string_key' =>
                    $message])->one();

        if ($get_message != NULL) {

            if ($lang == 2) {

                return $get_message->string_ar;
            }
            else {
                return $get_message->string_en;
            }
        }
        else {
            return "";
        }
    }

    function getCode($code, $name, $lang, $value = "") {
        $get_code = \common\models\ErrorCode::find()->where(['error_code' => $code])->one();
        $retun = [];

        $file_size = filesize(Yii::$app->basePath . "/../uploads/logs/app_log.txt");
        $size = $file_size / 1000;
        if ($size >= 1000) {
            $old_name = Yii::$app->basePath . "/../uploads/logs/app_log.txt";
            $new_name = Yii::$app->basePath . "/../uploads/logs/app_log_" . date('Y-m-d') . ".txt";
            rename($old_name, $new_name);
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/app_log.txt', "a") or die("Unable to open file!");
        }
        else {
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/app_log.txt', "a") or die("Unable to open file!");
        }

        if ($code != 200) {
            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Error code : ' . $code;
        }
        else {

            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Success : ' . $code;
        }
        $imp = '';
        if ($value != '') {
            if (is_array($value)) {
                $imp = json_encode($value);
            }
            else {
                $imp = $value;
            }
        }

//        if ($value != '') {
//            if (is_array($value)) {
//                $imp .= "POST DATA => [" . "\r\n";
//                foreach ($value as $key => $val) {
//                    $imp.= $key . ' : ' . $val . "\r\n";
//                }
//                $imp .= " ]" . "\r\n";
//            }
//        }
        fwrite($fp, "\r\n" . $write_data);
        fwrite($fp, "\r\n" . $imp);
        fclose($fp);


        if ($get_code != NULL) {

            $retun['status'] = $get_code->error_code;
            if ($lang == 2) {

                $retun['message'] = $get_code->error_ar;
            }
            else {
                $retun['message'] = $get_code->error_en;
            }
        }


        return $retun;
    }

    public function siteURL() {
        date_default_timezone_set('Asia/Qatar');
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' :
                'http://';
        $domainName = $_SERVER['HTTP_HOST'];
        return $protocol . $domainName;
    }

    function getUserIP() {
        date_default_timezone_set('Asia/Qatar');
// Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        }
        elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        }
        else {
            $ip = $remote;
        }

        return $ip;
    }

    function sendNotif($template_key = [], $desc_key, $title_key, $reciever_list, $notif_key = [], $notification_type, $reciever_type) {

        $tokens = [];
        $tokens_ios = [];
        $tokens_ar = [];
        $tokens_ar_ios = [];


        $reciever_list = array_filter($reciever_list);
        $available_reciever = [];
        if ($reciever_list != NULL) {
            foreach ($reciever_list as $us) {
                $get_device = \common\models\Authentication::find()->where(['user_id' => $us, 'status' => 1])->all();
                if ($get_device != NULL) {
                    foreach ($get_device as $get_d) {
                        $check_desable = \common\models\UserNotification::find()->where(['user_id' => $get_d->user_id, 'notification_type' => $notification_type, 'status' => 0])->one();
                        if ($check_desable == NULL) {
                            $available_reciever[] = $get_d->user_id;
                            $get_us = \common\models\Users::find()->where(['id' => $get_d->user_id])->one();
                            if ($get_us->app_lang_id == 1) {
                                if ($get_d->device_type == 0) {
                                    $tokens[] = $get_d->fb_token;
                                }
                                else {
                                    $tokens_ios[] = $get_d->fb_token;
                                }
                            }
                            else {
                                if ($get_d->device_type == 0) {
                                    $tokens_ar[] = $get_d->fb_token;
                                }
                                else {
                                    $tokens_ar_ios[] = $get_d->fb_token;
                                }
                            }
                        }
                    }
                }
            }
        }

        $tokens = $this->getFilterToken($tokens);
        $tokens_ar = $this->getFilterToken($tokens_ar);
        $tokens_ar_ios = $this->getFilterToken($tokens_ar_ios);
        $tokens_ios = $this->getFilterToken($tokens_ios);

        $title_en = $this->getMessage($title_key, 1);
        $title_ar = $this->getMessage($title_key, 2);

        $body_en = $this->getBody($desc_key, $template_key, 1);
        $body_ar = $this->getBody($desc_key, $template_key, 2);



        $newtk = [];
        if ($tokens != NULL) {
            foreach ($tokens as $tok) {
                $newtk [] = $tok;
            }
            Yii::$app->notificationManager->sendnotification($newtk, $title_en, $body_en, $notif_key, $app = 0);
        }


        $newtk_ios = [];
        if ($tokens_ios != NULL) {
            foreach ($tokens_ios as $tokios) {
                $newtk_ios [] = $tokios;
            }
            Yii::$app->notificationManager->sendnotification($newtk_ios, $title_en, $body_en, $notif_key, $app = 1);
        }




        $newtk_ar = [];
        if ($tokens_ar != NULL) {
            foreach ($tokens_ar as $tokr) {
                $newtk_ar [] = $tokr;
            }
            Yii ::$app->notificationManager->sendnotification($newtk_ar, $title_ar, $body_ar, $notif_key, $app = 0);
        }

        $newtk_ar_ios = [];
        if ($tokens_ar_ios != NULL) {
            foreach ($tokens_ar_ios as $tokrios) {
                $newtk_ar_ios [] = $tokrios;
            }
            Yii ::$app->notificationManager->sendnotification($newtk_ar_ios, $title_ar, $body_ar, $notif_key, $app = 1);
        }

        if ($available_reciever != NULL) {
            $available_reciever = array_unique($available_reciever);
            foreach ($available_reciever as $reciever) {
                $courier_notifications = Yii:: $app->notificationManager->notifications($notification_type, $reciever, $title_en, $title_ar, $reciever_type, $body_en, $body_ar, $notif_key);
            }
        }
    }

    function sendNotifChat($template_key = [], $desc_key, $title_key, $reciever_list, $notif_key = [], $notification_type, $reciever_type) {

        $tokens = [];
        $tokens_ios = [];
        $tokens_ar = [];
        $tokens_ar_ios = [];


        $reciever_list = array_filter($reciever_list);
        $available_reciever = [];
        if ($reciever_list != NULL) {
            foreach ($reciever_list as $us) {
                $get_device = \common\models\Authentication::find()->where(['user_id' => $us, 'status' => 1])->all();
                if ($get_device != NULL) {
                    foreach ($get_device as $get_d) {
                        $check_desable = \common\models\UserNotification::find()->where(['user_id' => $get_d->user_id, 'notification_type' => $notification_type, 'status' => 0])->one();
                        if ($check_desable == NULL) {
                            $available_reciever[] = $get_d->user_id;
                            $get_us = \common\models\Users::find()->where(['id' => $get_d->user_id])->one();
                            if ($get_us->app_lang_id == 1) {
                                if ($get_d->device_type == 0) {
                                    $tokens[] = $get_d->fb_token;
                                }
                                else {
                                    $tokens_ios[] = $get_d->fb_token;
                                }
                            }
                            else {
                                if ($get_d->device_type == 0) {
                                    $tokens_ar[] = $get_d->fb_token;
                                }
                                else {
                                    $tokens_ar_ios[] = $get_d->fb_token;
                                }
                            }
                        }
                    }
                }
            }
        }

        $tokens = $this->getFilterToken($tokens);
        $tokens_ar = $this->getFilterToken($tokens_ar);
        $tokens_ar_ios = $this->getFilterToken($tokens_ar_ios);
        $tokens_ios = $this->getFilterToken($tokens_ios);

        $title_en = $title_key;
        $title_ar = $title_key;

        $body_en = $this->getBody($desc_key, $template_key, 1);
        $body_ar = $this->getBody($desc_key, $template_key, 2);



        $newtk = [];
        if ($tokens != NULL) {
            foreach ($tokens as $tok) {
                $newtk [] = $tok;
            }
            Yii::$app->notificationManager->sendnotification($newtk, $title_en, $body_en, $notif_key, $app = 0);
        }


        $newtk_ios = [];
        if ($tokens_ios != NULL) {
            foreach ($tokens_ios as $tokios) {
                $newtk_ios [] = $tokios;
            }
            Yii::$app->notificationManager->sendnotification($newtk_ios, $title_en, $body_en, $notif_key, $app = 1);
        }




        $newtk_ar = [];
        if ($tokens_ar != NULL) {
            foreach ($tokens_ar as $tokr) {
                $newtk_ar [] = $tokr;
            }
            Yii ::$app->notificationManager->sendnotification($newtk_ar, $title_ar, $body_ar, $notif_key, $app = 0);
        }

        $newtk_ar_ios = [];
        if ($tokens_ar_ios != NULL) {
            foreach ($tokens_ar_ios as $tokrios) {
                $newtk_ar_ios [] = $tokrios;
            }
            Yii ::$app->notificationManager->sendnotification($newtk_ar_ios, $title_ar, $body_ar, $notif_key, $app = 1);
        }

        if ($available_reciever != NULL) {
            $available_reciever = array_unique($available_reciever);
            foreach ($available_reciever as $reciever) {
                $courier_notifications = Yii:: $app->notificationManager->notifications($notification_type, $reciever, $title_en, $title_ar, $reciever_type, $body_en, $body_ar, $notif_key);
            }
        }
    }

    function getFilterToken($tokens = []) {
        $tokens = array_filter($tokens);
        $tokens = array_unique($tokens);

        $tokens = array_values($tokens);
        return $tokens;
    }

    function getBody($desc_key, $template_key = [], $lang) {
        $body = $this->getMessage($desc_key, $lang);
        if ($template_key != NULL) {
            foreach ($template_key as $key => $val) {
                $body = str_replace(
                        $key, $val, $body);
            }
        }
        return $body;
    }

}
