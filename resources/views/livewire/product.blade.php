<div class="row">
    <div class="col">
        <div class="col m-2 position-fixed " style="bottom: 10px; right: 0; height: auto; z-index: 5;">
            <x-alerts.success />
            <x-alerts.error />
        </div>
       
        <div class="card border-none bg-gray-100">

                @if (!$addProduct)
                    <button data-bs-toggle="modal" data-bs-target="#add" {{-- wire:click="addProduct()" --}}
                        class="btn btn-outline-primary rounded-pill float-end mx-auto btn-sm mb-2 mt-2 me-2">Add
                        Product</button>
                    @include('livewire.create')
                @endif
                <div class="form-outline d-flex w-5/6 md:w-3/4 lg:w-1/2 mx-auto mb-4">
                    <input type="search" wire:model.lazy="search" wire:keydown.enter="Search" placeholder="Search"
                        class="form-control shadow-md rounded-pill" />
                    <i class="fas fa-search text-white ml-1 p-2 my-1 rounded-circle bg-secondary" wire:click="Search"></i>
                </div>

            {{-- load states, prefetch, dirty states --}}
            {{-- prefetch --}}
            {{-- <button wire:click.prefetch="toggleContent">Show Content</button> 
              @if ($contentIsVisible)
                <span>Some Content...</span>
             @endif --}}
            {{-- <div wire:offline>
                You are now offline.
             </div>
             <div>
                <input wire:dirty.class="border bg-danger" wire:model.lazy="addProduct">
                <span wire:dirty wire:target="addProduct">Updating...</span>
                <input wire:model.lazy="addProduct">
             </div> --}}
            {{-- comment --}}

            <div class="row justify-content-center mb-3">
                @if (count($products) > 0)
                    {{-- <div wire:poll.4000ms>
                        Current time: {{ now() }}
                    </div> --}}
                    @foreach ($products as $product)
                        <div class="col-sm-5 col-md-4 col-lg-3 m-2">
                            <div class="card-body shadow-lg " style="border-radius: 35px;">
                                <div class="row mb-4 mb-lg-0">
                                    <img src="{{ str_contains($product['image'], 'http') ? $product['image'] : asset('storage/' . $product['image']) }}"
                                        class="w-full" height="200px" style="border-radius: 25px;" />
                                </div>
                                <div class="row my-1">
                                    <h5 class="m-1">{{ ucwords($product['title']) }}</h5>
                                    <div class="d-flex flex-row">
                                        <div class="text-warning mb-1 me-2">
                                            @php $i=0; @endphp
                                            @while ($i++ < rand(1, 5))
                                                <i class="fa fa-star"></i>
                                            @endwhile
                                        </div>
                                        <span>{{ rand(50, 10000) }}</span>
                                    </div>
                                    <p class="text-muted no-wrap">
                                        {{ substr($product['description'], 0, 70) }}
                                    </p>
                                </div>
                                <div class="row border-top">
                                    <div class="d-flex flex-row align-items-center mt-1">
                                        <h4 class="mb-1 me-1 text-sm">
                                            ₹{{ $price = mt_rand(90000, 2000000) / 10 }}</h4>
                                        <span class="text-muted text-sm"><s>₹{{ $price + $price / 10 }}</s></span>
                                    </div>
                                    {{-- <h6 class="text-success fw-light">Free shipping</h6> --}}
                                    <div class="d-flex flex-row  mt-2">
                                        <button data-bs-toggle="modal" data-bs-target="#update"
                                            wire:click="editProduct({{ $product['id'] }})"
                                            class="btn btn-outline-primary btn-sm w-50 rounded-pill m-1">Edit</button>
                                        <button wire:click="deleteProduct({{ $product['id'] }})"
                                            class="btn btn-outline-danger btn-sm w-50 rounded-pill m-1">Delete</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <tr>
                        <td align="center">
                            No Products Found.
                        </td>
                    </tr>
                @endif
            </div>

            @include('livewire.update')
            @if ($hasMorePages)
                <div x-data x-intersect="@this.call('loadProducts')" class=" mx-auto w-full md:w-52 lg:w-72">
                    {{-- @foreach (range(1, 2) as $x) --}}
                    @include('livewire.partials.skeleton')
                    {{-- @endforeach --}}
                </div>
            @endif
        </div>
    </div>


    {{-- Alert Message Disappear --}}
    <script>
        window.addEventListener('alert-close', event => {
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 4000);
        })
    </script>

</div>
