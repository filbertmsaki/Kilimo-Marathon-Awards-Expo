<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Response;

class FlutterwaveService
{

    public static function createPayment($request)
    {
        $client = new Client();
        try {
            $response = $client->post('https://api.flutterwave.com/v3/payments', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'tx_ref' => $request['reference'],
                    'amount' => $request['amount'],
                    'currency' =>  $request['currency'],
                    'redirect_url' =>  $request['redirect_url'] ?? 'https://20a2-197-250-51-156.ngrok-free.app/flw-redirect',
                    'customer' => [
                        'email' => $request['customer_email'],
                        'name' => $request['customer_name'],
                        'phonenumber' => $request['customer_phonenumber'],
                    ],
                    'customizations' => [
                        'title' => $request['title'],
                    ],
                ],
            ]);
            $result = json_decode($response->getBody(), true);
            if ($result && $result['status'] === 'success') {
                return response()->json($result['data']['link'], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    'message' => $result['message'] ?? 'An error occurred.',
                ], 400);
            }
        } catch (ClientException $e) {
            // Handle client-side errors (4xx)
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json([
                'message' => $errorResponse['message'] ?? 'A client error occurred.',
                'status' => $errorResponse['status'] ?? 'error'
            ], $e->getResponse()->getStatusCode());
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                return response()->json([
                    'message' => $errorResponse['message'] ?? 'An error occurred while processing your request.',
                ], $e->getResponse()->getStatusCode());
            } else {
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
