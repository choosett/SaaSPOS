<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Http;

class PathaoBarikoiSearch extends Component
{
    public $cities;
    public $apiKey;

    public function __construct()
    {
        $this->apiKey = env('BARIKOI_API_KEY', 'MjI4NzpXNTY1TTNNM0NR');

        // Fetch Pathao Cities
        $accessToken = file_get_contents(storage_path('app/pathao_token.txt'));

        if ($accessToken) {
            $response = Http::withToken($accessToken)->get(config('pathao.base_url') . '/aladdin/api/v1/city-list');
            $data = $response->json();

            $this->cities = $data['data']['data'] ?? [];
        } else {
            $this->cities = [];
        }
    }

    public function render()
    {
        return view('components.pathao-barikoi-search');
    }
}
