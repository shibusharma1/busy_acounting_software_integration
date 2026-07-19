<?php

namespace App\Http\Controllers;

use App\Services\BusyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BusyController extends Controller
{

    public function create(BusyService $busy)
    {
        return view('busy.sale');
    }

    // public function store(Request $request, BusyService $busy)
    // {
    //     $request->validate([
    //         // 'customer' => 'required',
    //         'vch_no' => 'required',
    //         'date' => 'required|date',
    //         'item' => 'required',
    //         'qty' => 'required|numeric',
    //         'price' => 'required|numeric',
    //     ]);

    //     $date = date('d-m-Y', strtotime($request->date));
    //     $amount = $request->qty * $request->price;

    //     $xml = "<Sale>
    //     <VchSeriesName>Main</VchSeriesName>
    //     <Date>{$date}</Date>
    //     <VchType>9</VchType>
    //     <StockUpdationDate>{$date}</StockUpdationDate>
    //     <VchNo>{$request->vch_no}</VchNo>
    //     <STPTName>VAT/13%</STPTName>
    //     <MasterName1>Customer-Amit Gupta</MasterName1>
    //     <MasterName2>Main Store</MasterName2>
    //     <TranCurName>Rs.</TranCurName>
    //     <InputType>1</InputType>

    //     <ItemEntries>
    //         <ItemDetail>
    //             <Date>{$date}</Date>
    //             <VchType>9</VchType>
    //             <VchNo>{$request->vch_no}</VchNo>
    //             <SrNo>1</SrNo>
    //             <ItemName>{$request->item}</ItemName>
    //             <UnitName>Pcs.</UnitName>
    //             <Qty>{$request->qty}</Qty>
    //             <Price>{$request->price}</Price>
    //             <Amt>{$amount}</Amt>
    //         </ItemDetail>
    //     </ItemEntries>
    // </Sale>";

    //     $response = $busy->sendRequest($xml);

    //     return back()->with('response', $response['description'] ?? 'Done');
    // }
    public function store(Request $request, BusyService $busy)
    {
        $request->validate([
            'vch_no' => 'required',
            // 'date' => 'required|date',
            'item' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $date = date('d-m-Y', strtotime($request->date));
        // $date = 01-04-2026; // ✅ FIXED DATE FOR TESTING

        // ✅ YOUR FULL WORKING XML (NO CHANGE)
        $xml = '<Sale><VchSeriesName>Main</VchSeriesName><Date>' . $date . '</Date><VchType>9</VchType><StockUpdationDate>' . $date . '</StockUpdationDate><VchNo>' . $request->vch_no . '</VchNo><AutoVchNo>6</AutoVchNo><STPTName>VAT/13%</STPTName><MasterName1>Customer-Amit Gupta</MasterName1><MasterName2>Main Store</MasterName2><TranCurName>Rs.</TranCurName><InputType>1</InputType><BillingDetails><PartyName>Customer-Amit Gupta</PartyName><Address1>New Delhi</Address1><Address2>India</Address2><MobileNo>9992229989</MobileNo></BillingDetails><VchOtherInfoDetails><OFInfo/><Transport>Santosh Transport &amp; Company</Transport><Station>Dadri</Station><PurchaseBillNo>1/2026-27</PurchaseBillNo><PurchaseBillDate>' . $date . '</PurchaseBillDate><Narration1>NA-</Narration1><GrDate>' . $date . '</GrDate></VchOtherInfoDetails><ItemEntries><ItemDetail><Date>' . $date . '</Date><VchType>9</VchType><VchNo>' . $request->vch_no . '</VchNo><SrNo>1</SrNo><ItemName>' . $request->item . '</ItemName><UnitName>Pcs.</UnitName><AltUnitName>Pcs.</AltUnitName><ConFactor>1</ConFactor><Qty>' . $request->qty . '</Qty><QtyMainUnit>' . $request->qty . '</QtyMainUnit><QtyAltUnit>' . $request->qty . '</QtyAltUnit><ItemTaxCategory>GST 18%</ItemTaxCategory><Price>' . $request->price . '</Price><PriceAltUnit>' . $request->price . '</PriceAltUnit><ListPrice>' . $request->price . '</ListPrice><Amt>' . ($request->qty * $request->price) . '</Amt><NettAmount>0</NettAmount><CompoundDiscount>0.00</CompoundDiscount><STAmount>0</STAmount><STPercent>0</STPercent><TaxBeforeSurcharge1>0</TaxBeforeSurcharge1><STPercent1>0</STPercent1><TaxBeforeSurcharge>0</TaxBeforeSurcharge><MC>Main Store</MC><DiscountStructure>Simple Discount, % of Price</DiscountStructure></ItemDetail></ItemEntries></Sale>';

        $response = $busy->sendRequest($xml);

        // Log::info('BUSY API RESPONSE', [
        //     'result' => $response['result'],
        //     'description' => $response['description'],
        //     'body' => $response['raw'],
        //     // 'status' => $response['status'],
        // ]);


        \Log::info('BUSY REQUEST HEADER', [
            'xml_length' => strlen($xml),
        ]);

        // dd($response->headers(), $response->body());
        // return back()->with(
        //     'response',
        //     "Result: " . $response['result'] . " | " . $response->header('description') . " | Body: " . $response['body']
        // );
        return back()->with(
            'response',
            "Result: " . ($response['result'] ?? 'N/A') .
                " | " . ($response['description'] ?? 'No description') .
                " | Body: " . $response['body']
        );
    }
    // public function testCustomerQuery()
    // {
    //     try {

    //         // Try different queries one by one if required
    //         // $query = "SELECT * FROM ACCOUNT"; //failed
    //         // $query = "SELECT NAME FROM ACCOUNT_MASTER";
    //         // $query = "SELECT Name FROM MSysObjects WHERE Type=1";
    //         // $query = "SELECT * FROM BUSYMASTER";
    //         // fully working
    //         // $query = "SELECT * FROM Master1 WHERE MasterType = 2 AND ParentGrp = 116"; //Client or Customer
    //         // $query = "SELECT * FROM Master1 WHERE MasterType = 6  AND ParentGrp = 401"; //product
    //         $query = "SELECT * FROM Master1 WHERE MasterType = 5"; //product
    //         // $query = "SELECT * FROM Voucher1 WHERE VoucherTypes = 2"; //product
    //         // $query = "SELECT TOP 5 * FROM Master1";

    //         Log::info('================ BUSY SQL TEST START ================');

    //         Log::info('BUSY SQL Query', [
    //             'query' => $query,
    //         ]);

    //         $response = Http::withHeaders([
    //             'SC'       => 1,
    //             'Qry'      => $query,
    //             'UserName' => 'a',      // Change if required
    //             'Pwd'      => 'a',      // Change if required
    //         ])->get('http://127.0.0.1:981');

    //         Log::info('BUSY Response Status', [
    //             'status' => $response->status(),
    //         ]);

    //         file_put_contents(
    //             storage_path('app/busy_voucher.xml'),
    //             $response->body()
    //         );

    //         // Log::info('BUSY Response Headers', [
    //         //     'headers' => $response->headers(),
    //         // ]);

    //         Log::info('BUSY Response Body', [
    //             'body' => $response->body(),
    //         ]);

    //         Log::info('================ BUSY SQL TEST END ================');
    //         // $xml = simplexml_load_string($response->body());

    //         // $xml->registerXPathNamespace('z', '#RowsetSchema');

    //         // $rows = $xml->xpath('//z:row');

    //         // $data = [];

    //         // foreach ($rows as $row) {
    //         //     $data[] = (array)$row->attributes();
    //         // }
    //         // dd($data);

    //         // $results = [];

    //         // foreach ($data as $busyItem) {
    //         //     $busyItem = $busyItem['@attributes'];
    //         //     $payload = [
    //         //         'client' => [
    //         //             'client_code'   => $busyItem['Code'] ?? null,
    //         //             'name'          => $busyItem['Name'] ?? null,
    //         //             'company_id'  => 58,
    //         //             'pan'           => $busyItem['Alias'] ?? null,

    //         //             // // Add more mappings here
    //         //             // 'address_1'     => $busyItem['C1'] ?? null,
    //         //             // 'address_2'     => $busyItem['C2'] ?? null,
    //         //             // 'phone'         => $busyItem['C3'] ?? null,
    //         //             // 'email'         => $busyItem['C4'] ?? null,
    //         //         ],

    //         //         'status' => 200
    //         //     ];


    //         //     Log::info("=====================================Payload Start===========================================");
    //         //     Log::info($payload);
    //         //     Log::info("=====================================Payload END===========================================");

    //         //     $deltaResponse = Http::withToken("eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1NiIsImp0aSI6IjQ5MWQ4ODNjZjdiODRmMWY4ZGRiMmE0ODVhNTdhYWMxOGM0YTUxZmEwNDJmYmMwODA5NzY5NDIyYmU2NDE2Njg3MzRjZmZmNmEyMDNhY2RlIiwiaWF0IjoxNzg0MTk3NjQyLjAyODE5LCJuYmYiOjE3ODQxOTc2NDIuMDI4MTk1LCJleHAiOjE3ODQyMDEyNDIuMDE5Njg2LCJzdWIiOiI0Nzk5Iiwic2NvcGVzIjpbXX0.Z3QRmkYUnDkwq-KnOWyodDHBdIPUyT9Li2K4kNmTWxvolg_dSwsunbHhk7tB-HDM2CAZu2RSLSkciqqrTss4MLFYVRdZM_CRm9zy9P0m1OcJ-2GhDJofVysOQY0u6mlnLPVUPD8OqP40kfWalEtGJhYVKcJWHL1hF21RNnVCTq33W9GV5CfB5WJPSEmh_Vr1_fwhzAUizbsZt9f3AUePiL1rf_09oxo99wgugLScXTp6cRjlpDVUhl-2oH4DEx1ZSY4Vuiu47AB6eUIXA88JTwoCOjQEEL89buSX_iJCG80oqtUEC9StLxpW3MQqCZDCgx_o-c68nYp5Zt1gsq9o-3hqzYD7dhVKu7bfGGW6HDphf22jJ1hvRLXRX8pcjCghL6NV2sv_1Lcov6vXb1ZA1TTXySy-VCBzXfwJaii2Xdy8oZ852DPXl2Cu9nijmdThsAXOq_r9JsBvFHfXJPjPQr8fB62IgrsNqK6eKAwUsNK2bsLAgBRhZ_lECnlg4MVTWkoxhCkl1XMmSTjPBqX_45JxNWwD_rV2LQ-gPYgxOOYED5NymPBgQ_Y5GbYIrtcJwa9w2Y4rWX--OFUme7TddCdHnDyXV3mPeWCgYyJ2ubShZiJqxzZtsEkfg_aAmd9EztZ-KHwzV_ySjutnOeHDntFdvx0E49fxLsol9vYO2Z4")
    //         //         ->acceptJson()
    //         //         ->post(
    //         //             'https://dev.deltasalesapp.com/api/v1/saveClient',
    //         //             $payload
    //         //         );

    //         //     $results[] = [
    //         //         'busy_code' => $busyItem['Code'] ?? null,
    //         //         'busy_name' => $busyItem['Name'] ?? null,
    //         //         'status'    => $deltaResponse->status(),
    //         //         'response'  => $deltaResponse->json(),
    //         //     ];
    //         // }

    //         // return response()->json($results);
    //         // return response()->json($data);
    //         // file_put_contents(
    //         //     storage_path('app/busy_master.xml'),
    //         //     $response->body()
    //         // );

    //         return response()->json([
    //             'saved' => true,
    //             // 'path'  => storage_path('app/busy_master.xml')
    //         ]);
    //     } catch (\Throwable $e) {

    //         Log::error('BUSY SQL Exception', [
    //             'message' => $e->getMessage(),
    //             'line' => $e->getLine(),
    //             'file' => $e->getFile(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function testCustomerQuery()
    {
        try {

            $tables = [
                'Voucher1',
                'Voucher',
                'Vouchers',
                'VoucherHeader',
                'VoucherDetail',
                'VoucherBody',
                'Transaction1',
                'Transaction',
                'Transactions',
                'Tran1',
                'Tran',
                'Sales',
                'SalesOrder',
                'SaleOrder',
                'Sale',
                'Purchase',
                'PurchaseOrder',
                'Invoice',
                'Invoices',
                'Bill',
                'Bills',
                'Ledger',
                'Ledger1',
                'Account',
                'Accounts',
                'Master1',
                'Master',
                'Item',
                'Items',
                'Stock',
                'Stock1',
                'StockItem',
                'StockItems',
                'VoucherItem',
                'VoucherItems',
            ];

            $results = [];

            foreach ($tables as $table) {

                $query = "SELECT TOP 1 * FROM {$table}";

                Log::info("Testing table: {$table}");

                $response = Http::withHeaders([
                    'SC'       => 1,
                    'Qry'      => $query,
                    'UserName' => 'a',
                    'Pwd'      => 'a',
                ])->get('http://127.0.0.1:981');

                $body = $response->body();

                // Save every response for inspection
                file_put_contents(
                    storage_path("app/busy_discovery_{$table}.xml"),
                    $body
                );

                $exists = false;

                if (
                    stripos($body, '<z:row') !== false ||
                    stripos($body, '<rs:data') !== false ||
                    stripos($body, '<xml') !== false
                ) {
                    $exists = true;
                }

                $results[] = [
                    'table'  => $table,
                    'exists' => $exists,
                    'status' => $response->status(),
                ];
            }

            return response()->json([
                'success' => true,
                'results' => $results,
            ]);
        } catch (\Throwable $e) {

            Log::error('BUSY Discovery Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function discoverBusyVoucherTables()
    {
        try {

            $tables = [

                // Most likely voucher tables
                'Voucher1',
                'Voucher',
                'VoucherMaster',
                'VoucherDetail',
                'VoucherDetails',
                'VoucherItem',
                'VoucherItems',
                'VoucherBody',
                'VoucherHeader',

                // Sales related
                'Sale',
                'Sales',
                'SalesOrder',
                'SalesOrders',
                'SaleOrder',
                'SO',

                // Purchase
                'Purchase',
                'PurchaseOrder',

                // Transactions
                'Transaction',
                'Transactions',
                'Tran1',
                'TranMaster',

                // Inventory
                'Inventory',
                'InventoryVoucher',

                // Others
                'Bill',
                'Bills',
                'Document',
                'Documents',
                'Entry',
                'Entries',
                'Vch',
                'Vouchers',
            ];

            $results = [];

            foreach ($tables as $table) {

                $query = "SELECT TOP 1 * FROM {$table}";

                try {

                    $response = Http::withHeaders([
                        'SC'       => 1,
                        'Qry'      => $query,
                        'UserName' => 'a',
                        'Pwd'      => 'a',
                    ])->get('http://127.0.0.1:981');

                    $body = $response->body();

                    if (
                        stripos($body, 'Invalid') !== false ||
                        stripos($body, 'Error') !== false ||
                        stripos($body, 'does not exist') !== false
                    ) {

                        $results[] = [
                            'table'  => $table,
                            'status' => 'NOT FOUND',
                        ];

                        continue;
                    }

                    file_put_contents(
                        storage_path("app/{$table}.xml"),
                        $body
                    );

                    $results[] = [
                        'table' => $table,
                        'status' => 'FOUND',
                        'preview' => substr($body, 0, 300),
                    ];
                } catch (\Throwable $e) {

                    $results[] = [
                        'table' => $table,
                        'status' => 'ERROR',
                        'message' => $e->getMessage(),
                    ];
                }
            }

            return response()->json($results, 200, [], JSON_PRETTY_PRINT);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
