{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-landmark"></i>Структура предприятия</a>
    <ul class="nav-dropdown-items">
        <x-backpack::menu-item title="Типы структуры компании" icon="la la-question" :link="backpack_url('company-structure/types')"/>
        @foreach(\App\Models\CompanyStructureType::get() as $companyStructure)
            @php
                $url = backpack_url( '/company-structure/'  . $companyStructure->slug);
            @endphp
            <x-backpack::menu-item title="{{$companyStructure->title}}" icon="la la-question" :link="$url" />
        @endforeach
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-landmark"></i>Управление доступом</a>
    <ul class="nav-dropdown-items">
        <x-backpack::menu-item title="Права доступа" icon="la la-question" :link="backpack_url('permissions')"/>
        <x-backpack::menu-item title="Роли" icon="la la-question" :link="backpack_url('roles')"/>
    </ul>
</li>
<x-backpack::menu-item title="Пользователи" icon="la la-question" :link="backpack_url('users')"/>
