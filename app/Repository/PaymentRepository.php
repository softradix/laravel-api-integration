<?php
namespace App\Repositories;
use App\Models\Transaction;

class PaymentRepository {
    /**
     * params Shoppers information array format
     */
     public function makePayment($data = []) {
        $time = date("Y-m-dTH:i:s");
        $trans_id = $this->generateTransactionId();
        $publicKey = env('PUBLIC_KEY');
        $signature = $this->generateSignature($time, $trans_id);

        $params = [
            'public_key' => $publicKey,
            'time' => $time,
            'channel' => 3,
            'amount' => $data['amount'],
            'currency' => 'CLP',
            'trans_id' => $trans_id,
            'time_expired' => "30",
            'url_ok' => 'https://softradixtechnologies.com/thanks',
            'url_error' => 'https://softradixtechnologies.com/error',
            'signature' => $signature,
            'shopper_information' => json_encode([
                    "name_shopper" => $data['first_name'] ?? "",
                    "last_name_Shopper" => $data['last_name'] ?? "",
                    "type_doc_identi" => $data['type_doc_identi'] ?? "",
                    "Num_doc_identi" => $data['num_doc_identi'] ?? "",
                    "email" => $data['shopper_email'] ?? "",
                    "country_code" => $data['country_code'] ?? "",
                    "Phone" => $data['shopper_phone'] ?? ""
                ])
        ];

        $curl = curl_init(env('CERT_ENVIRONMENT'));
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_FAILONERROR => true
        ));

        $response = curl_exec($curl);
        if(curl_exec($curl) === false) {
            return false;
            // echo 'Curl error: ' . curl_error($curl);
        }
        $result = $this->saveTransaction($params);
        if($result) {
            // return the URL returned by CURL call to controller method
            return $response;
        }   else {
            return false;
        }
    }

    /**
     * generate signature using keys and transaction information
     * */
    public function generateSignature($time, $trans_id) {
        $postData = [
            "public_key" => env('PUBLIC_KEY'),
            "time" => $time,
            "amount" => 1000.00,
            "currency" => 'CLP',
            "trans_id" => $trans_id,
            "time_expired" => 30,
            "url_ok" => 'https://softradixtechnologies.com/thanks',
            "url_error" => 'https://softradixtechnologies.com/error',
            "channel" => 3,
            "secret_key" => env('SECRET_KEY')
        ];
        // get secret key from your config
        ksort($postData);
        //echo "<pre>"; print_r($postData);
        $signatureData = "";
        foreach ($postData as $key => $value){
            $signatureData .= $value;
        }
        //echo "<pre>"; print_r($signatureData);
        // $signature = hash_hmac('SHA256', $signatureData, env('SECRET_KEY'));
        $signature = hash_hmac('SHA256', $signatureData, env('SECRET_KEY'));
        $signature = base64_encode($signature);
        return $signature;
    }

    /**
     * Generate unique transaction ID for transaction model
     * So that later when webhook will be called we can update transaction status to success by identifying it with transaction ID.
     */
    public function generateTransactionId() {
        $trans_id = uniqid();
        $trans = Transaction::where('trasaction_id', $trans_id)->first();
        if($trans) {
            $this->generateTransactionId();
        }   else {
            return $trans_id;
        }
    }

    /**
     * Save new transaction to database
     */
    public function saveTransaction($data = []) {
        $row = [
            'trasaction_id' => $data['trans_id'],
            'time' => $data['time'],
            'payment_channel' => $data['channel'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'signature' => $data['signature'],
            'time_expired' => $data['time_expired'],
            'shopper_first_name' => $data['shopper_information']['name_shopper'] ?? '',
            'shopper_last_name' => $data['shopper_information']['last_name_Shopper'] ?? '',
            'type_doc_identi' => $data['shopper_information']['type_doc_identi'] ?? '',
            'Num_doc_identi' => $data['shopper_information']['Num_doc_identi'] ?? '',
            'email' => $data['shopper_information']['email'] ?? '',
            'country_code' => $data['shopper_information']['country_code'] ?? '',
            'Phone' => $data['shopper_information']['Phone'] ?? '',
            'transaction_status' => 0
        ];
        unset($data);
        $trans = Transaction::create($row);
        unset($row);
        if($trans) {
            return true;
        }   else {
            return false;
        }
    }
}

?>