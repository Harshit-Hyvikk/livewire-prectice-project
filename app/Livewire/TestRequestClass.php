<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class TestRequestClass extends Component
{
    public $name;

    public function submit(Request $request)
    {
        // Access via request
        $data = $request->all();
        // or specific fields

        // foreach ($data['components'] as $key => $value) {
        //     dd($value['updates']['name']);
        // }
        dd($data);
        $name = $data['name'];

    }
    public function render()
    {
        return view('livewire.test-request-class');
    }
}
