		@if($b_item_id_isset && $o_item->images && $o_item->images->count())
		@foreach($o_item->images as $image)
			@include('user._form_image_item', ['image' => $image])
		@endforeach
		@endif
