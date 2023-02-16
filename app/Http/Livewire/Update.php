<?php

namespace App\Http\Livewire;

use App\Models\Product as Products ;
use Livewire\Component;

class Update extends Component
{
    public $products;
     /**
     * render the product data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->products = Products::select('id', 'title', 'description')
                                ->get();
        return view('livewire.update');
    }
}