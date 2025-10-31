<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Controllers\Openai\OpenaiController;
use App\Models\{
    PostModel,
    OrdersModel,
    User\UsersModel
};

class FrontFetchController extends Controller
{
    public function index()
    {
        $allPost = Request::allPost();

        if ($allPost['action'] == 'place_order') {
            $this->place_order($allPost);
        } elseif ($allPost['action'] == 'promt') {
            $this->promt($allPost);
        }
    }

    public function promt($allPost)
    {
        $secret_key = 'Bearer sk-ptwX4z5VTHSuwXPYriwaO1pmux8oUpsL';

        $model = $allPost['model'];
        $zapros = $allPost['promt'];
        $zapros .= $allPost['text'] . '. ';

        $request_body = [
            "model" => $model, //gpt-4.1-mini gpt-4.1-nano gpt-4o-mini gpt-3.5-turbo
            "messages" => [
                ["role" => "user", "content" => $zapros]
            ],
            "temperature" => 0.7
        ];
        $postfields = json_encode($request_body);
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.proxyapi.ru/openai/v1/chat/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . $secret_key
        ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo json_encode($err, true);
        } else {
            $balance = json_decode(json_decode($this->proxyapiBalance()));
            // if ($balance->balance < 200) {}
            $obj = json_decode($response, true);
        	$result = str_replace($zapros, '', $obj['choices'][0]['message']['content']);
            $result_obj = ['result' => $result, 'response' => $response, 'balance' => $balance->balance];

            $user_id = userId();
            $c_tokens = $obj['usage']['completion_tokens'];
            $p_tokens = $obj['usage']['prompt_tokens'];

            $ct_summ = $c_tokens/1000*cost_of_request($obj['model'], 'completion');
            $pt_summ = $p_tokens/1000*cost_of_request($obj['model'], 'prompt');

            $expenses = $ct_summ+$pt_summ;

            $result_obj = ['result' => $result, 'response' => $response, 'balance' => $balance->balance, 'expenses' => round($expenses, 4)];

            UsersModel::updateUserTokensOai(
                [
                    'id' => $user_id,
                    'c_tokens' => $c_tokens,
                    'p_tokens' => $p_tokens
                ]
            );

            UsersModel::updateUserExpenses(
                [
                    'id' => $user_id,
                    'expenses' => $expenses
                ]
            );

            // UsersModel::setUserTokensOai(
            //     [
            //         'user_id' => $user_id,
            //         'token_name' => $obj['model'],
            //         'token_value' => $c_tokens,
            //         'token_type' => 'completion'
            //     ]
            // );
            //
            // UsersModel::setUserTokensOai(
            //     [
            //         'user_id' => $user_id,
            //         'token_name' => $obj['model'],
            //         'token_value' => $p_tokens,
            //         'token_type' => 'prompt'
            //     ]
            // );

            echo json_encode($result_obj, true);

            // echo json_encode($allPost, true);
        }
    }

    public static function proxyapiBalance()
    {
        $secret_key = 'Bearer sk-ptwX4z5VTHSuwXPYriwaO1pmux8oUpsL';
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.proxyapi.ru/proxyapi/balance",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . $secret_key
        ],
        ]);
        $response = curl_exec($curl);
        return json_encode($response, true);
    }

    public function place_order($allPost)
    {
        $message = [];
        $userId = userId();
        $userIdOrder = ($userId)? $userId : 0;
        $orderList = json_decode($allPost['orderList'], true);

        $last_post_id = OrdersModel::create(
            [
                'user_id'        => $userIdOrder,
                'order_products' => $allPost['orderList'],
                'user_info'      => $allPost['name'] . ';' . $allPost['phone'] . ';' . preg_replace('/[^0-9+]/', '', $allPost['phone'])
            ]
        );

        if ($last_post_id) {
            $prod_id = [];
            foreach ($orderList as $key => $value) {
                $prod_id[] = $value['id'];
            }

            $prod_id_count = [];
            foreach ($orderList as $key => $value) {
                $prod_id_count[$value['id']] = $value['count'];
            }

            $products = PostModel::getPostsForId(implode(',', $prod_id));

            $products_data_cart = [];
            foreach ($products as $key => $product) {
                if (in_array($product['post_id'], $prod_id)) {
                    $product['count'] = (int)$prod_id_count[(int)$product['post_id']];
                }
                $products_data_cart[] = $product;
            }

            $text_tg = '<b>Заказ</b>' . "\n";
            foreach ($products_data_cart as $key => $product) {
                $text_tg .= '#' . $product['post_id'] . ' ';
                $text_tg .= $product['post_title'] . ' - ';
                $text_tg .= $product['count'] . "\n";
            }

            message_to_telegram($text_tg, '477875115');
            $message['type'] = 'success';
        } else {
            $message['type'] = 'error';
        }

        echo json_encode($message, true);
    }
}
