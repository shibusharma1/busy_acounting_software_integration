<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BusyService
{
    protected $baseUrl = 'http://127.0.0.1:981'; // your working port

    protected $username = 'a';
    protected $password = 'a';

    // public function sendRequest($xml)
    // {
    //     $response = Http::asForm()->post($this->baseUrl, [
    //         'SC' => 2,                // Add Voucher from XML
    //         'VchType' => 9,           // Sale
    //         'VchXml' => $xml,         // YOUR FULL XML
    //         'UserName' => $this->username,
    //         'Pwd' => $this->password,
    //     ]);

    //     return [
    //         'result' => $response->header('Result'),
    //         'description' => $response->header('Description'),
    //         'raw' => $response->body(),
    //     ];
    // }
    // use Illuminate\Support\Facades\Http;

    public function sendRequest($xml)
    {
        $response = Http::withHeaders([
            // 'SC' => 2,
            // 'VchType' => 9,
              'SC' => 5,
            'MasterType' => 2,
            'MasterXml' => $xml, // FULL XML
            'UserName' => $this->username,
            'Pwd' => $this->password,
        ])->get($this->baseUrl);

        return [
            'result' => $response->header('Result') ?? '',
            'description' => $response->header('Description') ?? '',
            'body' => $response->body(),
        ];
    }
}
