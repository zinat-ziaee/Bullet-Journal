@auth

@php
$collections = \App\Models\Collection::getItems();

$fixedCollections = $collections->where('is_fixed', true);
$customCollections = $collections->where('is_fixed', false);

@endphp

<aside class="sidebar">

<button type="button"
        class="sidebar-toggle"
        id="sidebarToggle"
        title="باز و بسته کردن منوی کناری"
        aria-label="باز و بسته کردن منوی کناری">
    ☰
</button>


{{-- دفتر من --}}
<div class="sidebar-section">

    <div class="sidebar-section-title">
        📔 دفتر من
    </div>

    <ul>
        @foreach($fixedCollections as $collection)

            @php
                $routeName = \App\Models\Collection::getRouteName(
                    $collection->name
                );
            @endphp

            <li>
                <a href="{{ route($routeName) }}">
                    {{ $collection->name }}
                </a>
            </li>

        @endforeach
    </ul>

</div>


{{-- مجموعه‌های من --}}
<div class="sidebar-section">

    <div class="sidebar-section-title">
        📚 مجموعه‌های من
    </div>

    <ul class="custom-collections">

        @foreach($customCollections as $collection)

            <li>
                <a href="{{ route('collections.show', $collection) }}">
                    {{ $collection->name }}
                </a>
            </li>

        @endforeach

        <li>
            <a href="{{ route('collections.create') }}">
                + افزودن مجموعه
            </a>
        </li>

    </ul>

</div>


{{-- اهداف سالانه --}}
<div class="sidebar-section">

    <div class="sidebar-section-header">

        <a href="{{ route('goals.index') }}"
           class="sidebar-section-title">
            🎯 اهداف سالانه
        </a>

        <a href="{{ route('goal_categorizes.create') }}"
           class="sidebar-add"
           title="افزودن دسته اهداف">
            +
        </a>

    </div>

</div>


</aside>

@endauth
