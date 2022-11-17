<option value="{{ $category->id }}">
    {{ $name }} / {{ $category->name }}
</option>

@foreach($category->children as $child)
    @include('shopfolio::components.forms.option-category', ['name' => "{$name} / {$category->name}", 'category' => $child])
@endforeach
