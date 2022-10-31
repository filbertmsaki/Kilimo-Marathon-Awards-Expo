<?php

namespace App\Models\Payment;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

class Dpo
{
    const LIVE_URL = 'https://secure.3gdirectpay.com';
    const TEST_URL = 'https://secure1.sandbox.directpay.online';
    const CALLBACK_URL = '/callback';
    const CANCELED_URL = '/canceled';

    private $baseUrl;
    private $company_token;
    private $account_type;
    private $gatewayUrl;
    private $dpo_mode;
    private $back_url;
    private $redirect_url;

    private $dpo_base_url,
        $dpo_default_currency,
        $dpo_default_country;

    public function __construct()
    {


        $dpo_group_settings = DpoGroup::first();
        $this->company_token = $dpo_group_settings->dpo_company_token;
        $this->account_type   = $dpo_group_settings->dpo_default_service;

        $this->dpo_base_url      = $dpo_group_settings->dpo_base_url;
        $this->redirect_url = $this->dpo_base_url . self::CALLBACK_URL;
        $this->back_url = $this->dpo_base_url . self::CANCELED_URL;
        $this->account_description    = $dpo_group_settings->dpo_default_service_description;
        $this->dpo_mode           = $dpo_group_settings->dpo_sandbox;



        $this->dpo_default_currency   = $dpo_group_settings->dpo_default_currency;
        $this->dpo_default_country    = $dpo_group_settings->dpo_default_country;


        //Check the url if it in test mode or active mode
        if ($this->dpo_mode == false) {
            $this->baseUrl = self::TEST_URL;
        } else {
            $this->baseUrl = self::LIVE_URL;
        }
        $this->gatewayUrl = $this->baseUrl . '/payv2.php?ID=';
    }

    public function gatewayUrl()
    {
        return $this->gatewayUrl;
    }

    public function createToken($request)
    {
        $companyToken      = $this->company_token;
        $serviceType       = $this->account_type;
        $accountDdescription = $this->account_description;
        $backUrl           = $this->back_url;
        $redirectUrl       = $this->redirect_url;
        $companyRef         = $request->token;
        $customerFirstName = $request->first_name;
        $customerLastName  = $request->last_name;
        $customerPhone     = $request->phone;
        $customerCountry   = $request->iso;
        $paymentCurrency   = $this->dpo_default_currency;
        $paymentAmount     = $request->amount;
        $customerEmail     = $request->email;
        $customerCity     = $request->city;
        $customerAddress     = $request->address;
        $customerZip     = $request->zip;
        $serviceDescription   = $request->description;
        $serviceDate   = date('Y/m/d H:i');
        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <API3G>
        <CompanyToken>' . $companyToken . '</CompanyToken>
        <Request>createToken</Request>
        <Transaction>
        <PaymentAmount>' . $paymentAmount . '</PaymentAmount>
        <PaymentCurrency>' . $paymentCurrency . '</PaymentCurrency>
        <CompanyRef>' . $companyRef . '</CompanyRef>
        <CompanyRefUnique>0</CompanyRefUnique>
        <RedirectURL>' . $redirectUrl . '</RedirectURL>
        <BackURL>' . $backUrl . ' </BackURL>
        <customerCountry>' . $customerCountry . '</customerCountry>
        <customerFirstName>' . $customerFirstName . '</customerFirstName>
        <customerLastName>' . $customerLastName . '</customerLastName>
        <customerPhone>' . $customerPhone . '</customerPhone>
        <customerEmail>' . $customerEmail . '</customerEmail>
        <customerCity>' . $customerCity . '</customerCity>
        <customerAddress>' . $customerAddress . '</customerAddress>
        <customerZip>' . $customerZip . '</customerZip>
        <TransactionSource>whmcs</TransactionSource>
        <PTL>5</PTL>
        </Transaction>
        <Services>
          <Service>
            <ServiceType>' . $serviceType . '</ServiceType>
            <ServiceDescription>' . $serviceDescription . '</ServiceDescription>
            <ServiceDate>' . $serviceDate . '</ServiceDate>
          </Service>
        </Services>
        </API3G>';

        $client = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $response = $client->post('/API/v6/', [
            'debug' => FALSE,
            'body' => $xml,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ]
        ]);
        $body = $response->getBody();

        if ($body != '') {
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            if ($array['Result'] != '000') {
                $response = Arr::prepend($array, false, 'success');
            } else if ($array['Result'] == '000') {
                $response = Arr::prepend($array, true, 'success');
            }
            return $response;
        } else {
            return [
                'success'           => false,
                'result'            => 'Unknown error occurred in token creation',
                'resultExplanation' => 'Unknown error occurred in token creation',
            ];
        }
    }
    public function ChargeTokenMobile($data)
    {

        $companyToken =  $this->company_token;
        $transToken   = $data['transToken'];
        $phoneNumber  = $data['phoneNumber'];
        $mno          = $data['mno'];
        $mnocountry   = $data['mnocountry'];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
              <API3G>
                <CompanyToken>' . $companyToken . '</CompanyToken>
                <Request>ChargeTokenMobile</Request>
                <TransactionToken>' . $transToken . '</TransactionToken>
                <PhoneNumber>' . $phoneNumber . '</PhoneNumber>
                <MNO>' . $mno . '</MNO>
                <MNOcountry>' . $mnocountry . '</MNOcountry>
              </API3G>';

        $client = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $response = $client->post('/API/v6/', [
            'debug' => FALSE,
            'body' => $xml,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ]
        ]);
        $body = $response->getBody();
        if ($body != '') {
            $res = str_replace(array("<br>"), '   ', $body);
            $xml = simplexml_load_string($res);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            $responce = [];

            if (isset($array['StatusCode']) != '') {
                $responce['success']    = 'true';
                $responce['result'] = $array;
                return $responce;
            } else {
                $responce['success'] = 'false';
                $responce['result'] = $array;
                return $responce;
            }
        }
    }

    public function companyMobilePaymentOptions()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
      <API3G>
        <CompanyToken>' . $this->company_token . '</CompanyToken>
        <Request>CompanyMobilePaymentOptions</Request>
      </API3G>';

        $client = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $response = $client->post('/API/v6/', [
            'debug' => FALSE,
            'body' => $xml,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ]
        ]);
        $body = $response->getBody();
        if ($body != '') {
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);

            if (isset($array['Result']) != '') {
                $responce = [];
                $responce['success'] = false;
                $responce['result'] = $array;
                return $responce;
            } else {
                $mnoList = $array['paymentoptionsmobile']['terminalmobile'];
                $responce = [];
                $responce['success'] = true;
                $responce['result'] = $mnoList;
                return $responce;
            }
        } else {
            return [
                'success'           => false,
                'result'            => 'Unknown error occurred in token creation',
                'resultExplanation' => 'Unknown error occurred in token creation',
            ];
        }
    }

    public function verifyToken($data)
    {

        $companyToken = $this->company_token;
        $transToken   = $data['TransToken'];
        $xml = '<?xml version="1.0" encoding="utf-8"?>
          <API3G>
            <CompanyToken>' . $companyToken . '</CompanyToken>
            <Request>verifyToken</Request>
            <TransactionToken>' . $transToken . '</TransactionToken>
          </API3G>';

        $client = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $response = $client->post('/API/v6/', [
            'debug' => FALSE,
            'body' => $xml,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ]
        ]);
        $body = $response->getBody();
        if ($body != '') {
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);

            if ($array['Result'] != 900) {
                $response = Arr::prepend($array, false, 'success');
                return $response;
            } else {
                $response = Arr::prepend($array, true, 'success');
                return $response;
            }
        } else {
            return [
                'success'           => false,
                'result'            => 'Unknown error occurred in token creation',
                'resultExplanation' => 'Unknown error occurred in token creation',
            ];
        }
    }
    public function getPaymentUrl($data)
    {
        if ($data['success'] == true) {
            $verifyToken   = $this->verifyToken(['TransToken' => $data['TransToken']]);
            if (!empty($verifyToken) && $verifyToken != '') {

                $dpo_payment_url = $this->gatewayUrl() . $data['TransToken'];
                return $dpo_payment_url;
            } else {
                return [
                    'success'           => false,
                    'result'            => 'Unknown error occurred in token creation',
                    'resultExplanation' => 'Unknown error occurred in token creation',
                ];
            }
        } else {
            return [
                'success'           => false,
                'result'            => 'Unknown error occurred in token creation',
                'resultExplanation' => 'Unknown error occurred in token creation',
            ];
        }
    }

    public function directPaymentPage($data)
    {
        $create_token = $this->createToken($data);

        $get_payment_url = $this->getPaymentUrl($create_token);

        return Redirect::to($get_payment_url);
    }

    public function getBalance()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
      <API3G>
        <Request>getBalance</Request>
        <CompanyToken>' . $this->company_token . '</CompanyToken>
        <Currency>TZS</Currency>
      </API3G>';

        $client = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $response = $client->post('/API/v6/', [
            'debug' => FALSE,
            'body' => $xml,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ]
        ]);
        $body = $response->getBody();
        if ($body != '') {
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            if (isset($array['Result']) != '') {
                $responce = [];
                $responce['success'] = false;
                $responce['result'] = $array;
                return $responce;
            } else {
                $responce = [];
                $responce['success'] = true;
                $responce['result'] = $array;
                return $responce;
            }
        } else {
            return [
                'success'           => false,
                'result'            => 'Unknown error occurred in token creation',
                'resultExplanation' => 'Unknown error occurred in token creation',
            ];
        }
    }
    public function cancelToken($data)
    {
        $companyToken   = $this->company_token;
        $transToken     = $data['TransToken'];
        $xml = '<?xml version="1.0" encoding="utf-8"?>
      <API3G>
        <CompanyToken>' . $companyToken . '</CompanyToken>
        <Request>cancelToken</Request>
        <TransactionToken>' . $transToken . '</TransactionToken>
      </API3G>';

        $client = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $response = $client->post('/API/v6/', [
            'debug' => FALSE,
            'body' => $xml,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ]
        ]);
        $body = $response->getBody();
        if ($body != '') {
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            if ($array['Result'] === '000') {
                $responce = [];
                $responce['success'] = true;
                $responce['result'] = $array;
                return $responce;
            } else {
                $responce = [];
                $responce['success'] = false;
                $responce['result'] = $array;
                return $responce;
            }
        } else {
            return [
                'success'           => false,
                'result'            => 'Unknown error occurred in token creation',
                'resultExplanation' => 'Unknown error occurred in token creation',
            ];
        }
    }
    public function refundToken($data)
    {
        $companyToken   = $this->company_token;
        $transToken     = $data['transToken'];
        $refundAmount   = $data['refundAmount'];
        $refundDetails  = $data['refundDetails'];

        $xml = '<?xml version="1.0" encoding="utf-8"?>
      <API3G>
        <Request>refundToken</Request>
        <CompanyToken>' . $companyToken . '</CompanyToken>
        <TransactionToken>' . $transToken . '</TransactionToken>
        <refundAmount>' . $refundAmount . '</refundAmount>
        <refundDetails>' . $refundDetails . '</refundDetails>
      </API3G>';

        $client = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $response = $client->post('/API/v6/', [
            'debug' => FALSE,
            'body' => $xml,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ]
        ]);
        $body = $response->getBody();
        if ($body != '') {
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            if ($array['Result'] === '000') {
                $responce = [];
                $responce['success'] = true;
                $responce['result'] = $array;
                return $responce;
            } else {
                $responce = [];
                $responce['success'] = false;
                $responce['result'] = $array;
                return $responce;
            }
        } else {
            return [
                'success'           => false,
                'result'            => 'Unknown error occurred in token creation',
                'resultExplanation' => 'Unknown error occurred in token creation',
            ];
        }
    }
}
