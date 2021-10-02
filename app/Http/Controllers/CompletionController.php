<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CompletionController extends Controller
{

    public function index()
    {
        return view('completion', ['text' => '']);
    }

    public function generateText(Request $request)
    {
        $client = new Client();
        $text = $request->get('text');

        $prompt = <<<EOD
This is an email generator

Seed Words: introduce Jane to the team, she will be a Customer Support Representative
Email: Dear team,

I am pleased to introduce you to Jane who is starting today as a Customer Support Representative. She will be providing technical support and assistance to our users, making sure they enjoy the best experience with our products.

Feel free to greet Jane in person and congratulate her with the new role!

Best regards
"""
Seed Words: student discounts for Annual Coding Conference
Email: Greetings,

I would like to ask if you provide student discounts for tickets to the Annual Coding Conference.

I’m a full-time student at the University of Texas and I’m very excited about your event, but unfortunately, the ticket price is too high for me. I would appreciate if you could offer me an educational discount.

Looking forward to hearing from you!
"""
Seed: sorry about your bad experience, refund, discount
Email: Dear John,

I’m sorry for the unpleasant experience you had in our store and I can understand your frustration. I have forwarded your complaint to our management team, and we’ll do our best to make sure this never happens again.

I refunded your purchase, and your funds should be with you shortly. We also want to offer you a 10% discount for your next purchase in our store.

Please accept our apologies for the inconvenience you had.

Best regards
"""
Seed Words: $text
Email: 
EOD;

        $apiKey = env('API_KEY');
        $response = $client->post('https://api.openai.com/v1/engines/curie-instruct-beta/completions', [
            'headers' => ['Authorization' => sprintf('Bearer %s', $apiKey)],
            'json' => [
                'prompt' => $prompt,
                'max_tokens' => 200,
                "temperature" => 0.3,
                "top_p" => 1,
                "frequency_penalty" => 1,
                "stop" => '"""'
            ]
        ]);

        $result = json_decode($response->getBody()->__toString(), true);
        return view('completion', [ 'text' => $this->formatText($result["choices"][0]["text"])]);
    }

    private function formatText($text)
    {
        return str_replace("\n", '<br>', $text);
    }
}
