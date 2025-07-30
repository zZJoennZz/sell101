<x-layout>
    <x-slot:title>
        {{ $product->name }}
    </x-slot>
    <div class="container" style="margin-top: 32px;">
        <div class="row">
            <div class="col s12 m6">
                <div id="product-gallery" style="text-align:center;">
                    @if($product->images->count())
                        <img id="main-product-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" style="width:100%;max-width:400px;border-radius:8px;">
                        <div style="margin-top:16px;display:flex;gap:8px;justify-content:center;">
                            @foreach($product->images as $img)
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                     alt="Image"
                                     class="gallery-thumb"
                                     style="width:60px;height:60px;object-fit:cover;border-radius:4px;cursor:pointer;border:2px solid #eee;"
                                     onclick="changeMainImage(this)">
                            @endforeach
                        </div>
                    @else
                        <img src="/img/no-image.png" alt="No Image" style="width:100%;max-width:400px;">
                    @endif
                </div>
            </div>
            <div class="col s12 m6">
                <h4>{{ $product->name }}</h4>
                <p class="grey-text">{{ $product->product_category->name ?? '' }}</p>
                <p>{{ $product->description }}</p>
                <div>
                    <label for="variation-select" style="font-weight:500;">Variation:</label>
                    @if($product->variations->count() > 1)
                        <select id="variation-select" class="browser-default" style="margin-bottom:16px;max-width:300px;">
                            @foreach($product->variations as $variation)
                                <option value="{{ $variation->id }}" data-price="{{ $variation->price }}">
                                    {{ $variation->name }} - ₱{{ $variation->price }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="hidden" id="variation-select" value="{{ $product->variations->first()->id }}">
                        <div style="margin-bottom:16px;">
                            <span class="teal-text" style="font-weight:500;">{{ $product->variations->first()->name }}</span>
                        </div>
                    @endif
                </div>
                <div style="margin-bottom:16px;">
                    <span style="font-size:2rem;font-weight:600;" id="product-price">
                        ₱{{ $product->variations->first()->price }}
                    </span>
                </div>
                <button class="btn waves-effect waves-light teal" style="width:180px;">Add to Cart</button>
            </div>
        </div>
        <div class="row" style="margin-top:40px;">
            <div class="col s12 m8">
                <h5>Reviews</h5>
                <div class="card-panel grey lighten-4">
                    <p class="grey-text">Reviews section coming soon...</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function changeMainImage(thumb) {
            document.getElementById('main-product-image').src = thumb.src;
            // Remove border from all thumbs
            document.querySelectorAll('.gallery-thumb').forEach(function(img) {
                img.style.border = '2px solid #eee';
            });
            // Highlight selected
            thumb.style.border = '2px solid #00897b';
        }
        document.addEventListener('DOMContentLoaded', function() {
            var select = document.getElementById('variation-select');
            if (select && select.tagName === 'SELECT') {
                select.addEventListener('change', function() {
                    var selected = select.options[select.selectedIndex];
                    var price = selected.getAttribute('data-price');
                    document.getElementById('product-price').textContent = '₱' + price;
                });
            }
            // Highlight first thumb by default
            var firstThumb = document.querySelector('.gallery-thumb');
            if (firstThumb) {
                firstThumb.style.border = '2px solid #00897b';
            }
        });
    </script>
</x-layout>