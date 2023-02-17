<?php

namespace App\Http\Livewire;

use App\Models\Product as Products;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

use function PHPUnit\Framework\isEmpty;

class Product extends Component
{
    use WithFileUploads;

    public $title, $description, $productId, $image, $path;
    public $search = '';
    public $products, $nextCursor, $hasMorePages;

    /**
     * queryString
     */
    protected $queryString = [
        'search' => ['except' => '']
    ];

    /**
     * Listeners
     */
    protected $listeners = ['deleteProduct'];

    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'image' => 'required|mimes:jpeg,png,jpg,gif,svg,avif'
    ];

    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->image = '';
    }

    /**
     * render the product data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.product');
    }

    /**
     * Mount on first component call
     * @return void
     */
    public function mount()
    {
        $this->products = new Collection();
        $this->loadProducts();
    }

    /**
     * Load More Product
     * @return void
     */
    public function loadProducts()
    {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) return;

        $products = Products::orderBy('id')->cursorPaginate(8, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
        $this->products->push(...$products->items());

        // dd((Products::cursorPaginate(15)));
        // dd((Products::orderBy('title')->cursorPaginate(15)));
        // dd((Products::orderBy('id')->cursorPaginate(15,['title','description','id'])));
        // dd((Products::orderBy('id')->cursorPaginate(15,['title','description','id'],'cursor')));
        // dd((Products::orderBy('id')->cursorPaginate(15,['title','description','id'],'cursor',Cursor::fromEncoded($this->nextCursor))));
        // dd((Products::orderBy('id')->cursorPaginate(15,['title','description','id'],'cursor',Cursor::fromEncoded($this->nextCursor)))->nextCursor());
        // dd((Products::orderBy('id')->cursorPaginate(15,['title','description','id'],'cursor',Cursor::fromEncoded($this->nextCursor)))->nextCursor()->encode());

        if ($this->hasMorePages = $products->hasMorePages()) {
            $this->nextCursor = $products->nextCursor()->encode();
        }
    }

    /**
     * Search for Product
     * @return void || Redirect()
     */
    public function Search()
    {
        // If search is not empty
        if ($this->search != '') {

            $this->products = Products::where('title', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->take(30)->get();

            //if there is no result then loadProduct  shouldn't be called
            if (isEmpty($this->products)) {
                $this->hasMorePages = null;
            }
        } else {
            $search = '';
            return redirect('/');
        }
    }

    /**
     * store the user inputted product data in the products table
     * @return void
     */
    public function storeProduct()
    {
        $this->validate();
        $path = $this->image->store('product_images');
        try {
            Products::create([
                'title' => $this->title,
                'description' => $this->description,
                'image' => $path
            ]);
            session()->flash('success', 'Product Created Successfully!!');
            $this->resetFields();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert-close');
        } catch (\Exception $ex) {
            session()->flash('error', 'Something went wrong!!');
        }
    }

    /**
     * show existing product data in edit product form
     * @param mixed $id
     * @return void
     */
    public function editProduct($id)
    {
        try {
            $product = Products::findOrFail($id);
            $this->resetErrorBag();
            if (!$product) {
                session()->flash('error', 'Product not found');
            } else {
                $this->title = $product->title;
                $this->description = $product->description;
                $this->path = $product->image;
                $this->productId = $product->id;
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something went wrong!!');
        }
    }

    /**
     * update the product data
     * @return void
     */
    public function updateProduct()
    {

        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,avif'
        ]);


        if ($this->image) {
            File::delete(public_path('storage/' . $this->path));
            $this->path =  $this->image->store('product_images');
        }
        try {
            Products::whereId($this->productId)->update([
                'title' => $this->title,
                'description' => $this->description,
                'image' => $this->path
            ]);
            session()->flash('success', 'Product Updated Successfully!!');
            $this->resetFields();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert-close');
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    /**
     * delete specific product data from the products table
     * @param mixed $id
     * @return void
     */
    public function deleteProduct($id)
    {
        try {
            File::delete(public_path('storage/' . (Products::find($id)->value('image'))));
            Products::find($id)->delete();
            session()->flash('success', "Product Deleted Successfully!!");
            $this->dispatchBrowserEvent('alert-close');
        } catch (\Exception $e) {
            session()->flash('error', "Something went wrong!!");
        }
    }

    /**
     * reset input fields on modal close
     * @return void
     */
    public function closeModal()
    {
        $this->resetFields();
    }
}
