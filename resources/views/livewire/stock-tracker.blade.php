@php
    /** @var \App\Models\Product $product */
@endphp

<div {{--wire:poll.60s="refreshStock"--}}>
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <select
                wire:model.defer="retailer"
                @class(['form-select', 'is-invalid' => $errors->has('retailer')])
            >
                <option value="" disabled>-- Select a retailer --</option>

                @foreach($retailers as $retailer)
                    <option value="{{ $retailer }}">
                        {{ $retailer }}
                    </option>
                @endforeach
            </select>

            @error('retailer')
                <p class="text-danger mt-1 mb-0">*{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-3 mb-3">
            <input
                type="text"
                wire:model.defer="name"
                placeholder="name"
                @class(['form-control', 'is-invalid' => $errors->has('name')])
            >

            @error('name')
                <p class="text-danger mt-1 mb-0">*{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <input
                type="text"
                wire:model.defer="url"
                placeholder="https://example.test/product"
                @class(['form-control', 'is-invalid' => $errors->has('url')])
            >

            @error('url')
                <p class="text-danger mt-1 mb-0">*{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-2 mb-3">
            <button wire:click="add" wire:loading.class="disabled" class="btn btn-primary w-100">
                <div wire:loading="add">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </div>

                <div wire:loading.remove="add">
                    Add
                </div>
            </button>
        </div>
    </div>

    <table class="table table-borderless">
        <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Retailer</th>
                <th>Last/current price</th>
                <th>In stock</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach($this->products as $product)
                <tr wire:key="product-{{ $product->id }}">
                    <td>
                        <img src="https://picsum.photos/150" alt="product" class="rounded-2">
                    </td>

                    <td>
                        <a href="{{ $product->url }}" target="_blank">{{ $product->name }}</a>
                    </td>

                    <td>{{ $product->retailer->name }}</td>

                    <td>€ {{ number_format($product->price, 2, ',', '.') }}</td>

                    <td>
                        <span @class(['badge', 'text-bg-success' => $product->in_stock, 'text-bg-danger' => ! $product->in_stock])>
                            {{ $product->in_stock ? 'Yes' : 'No' }}
                        </span>
                    </td>

                    <td class="text-center">
                        <button wire:click="remove({{ $product->id }})" class="btn btn-link link-danger">Stop tracking</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
