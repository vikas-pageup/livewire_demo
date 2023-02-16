<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class LoadMoreButton extends Component
{
    public $page;
    public $perPage;
    public $loadMore;

    public function mount($page = 1, $perPage = 1)
    {
        $this->page = $page + 1; //increment the page
        $this->perPage = $perPage;
        $this->loadMore = false; //show the button
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }
    public function render()
    {
        if ($this->loadMore) {
            // $rows = ;

            return view('livewire.product', [
                'products' => Product::paginate($this->perPage, ['*'], null, $this->page)
            ]);
        } else {
            return view('livewire.load-more-button');
        }
    }
}
