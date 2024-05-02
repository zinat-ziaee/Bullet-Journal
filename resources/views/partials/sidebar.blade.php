@auth

@php
  $collectionModel = new App\Models\Collection;
@endphp

<ul>
  @foreach($collectionModel::getItems() as $values)
  <li class="{{(request()->route()->getName()==$collectionModel::getRouteName($values->name))?'active-sidebar':''}}">
    <a href="{{route($collectionModel::getRouteName($values->name))}}">{{ $values->name }}</a>
  </li>
  @endforeach
</ul>

@endauth