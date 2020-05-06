@if($item->image->url || $item->gallery)
	<div class="img-slider-wrap">
		<div class="slider-for">
			@if($item->image)
				<div class="slide-item">
					<img src="{{ $item->image->url }}" alt="Credits: {{ $item->image->copyright }}">
					<div class="div_copyright">{{ $item->image->copyright }}</div>
				</div>
			@endif
			@if($item->gallery)
				@foreach($item->gallery->images as $image)
					<div class="slide-item">
						<img src="{{ $image->url }}" alt="Credits: {{ $image->copyright }}">
						<div class="div_copyright">{{ $image->copyright }}</div>
					</div>
				@endforeach
			@endif
		</div>
		<div class="slider-nav">
			@if($item->image && $item->gallery)
				<div class="slide-item">
					<img src="{{ $item->image->small_image_url }}" alt="">
				</div>
			@endif
			@if($item->gallery)
				@foreach($item->gallery->images as $image)
					<div class="slide-item">
						<img src="{{ $image->small_image_url }}" alt="">
					</div>
				@endforeach
			@endif
		</div>
	</div>
@endif