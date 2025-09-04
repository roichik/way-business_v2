{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-landmark"></i>Структура предприятия</a>
    <ul class="nav-dropdown-items">
        <x-backpack::menu-item title="Компании" icon="la la-question" :link="backpack_url('companies')"/>
        <x-backpack::menu-item title="Подразделения/отделы" icon="la la-question" :link="backpack_url('divisions')"/>
        <x-backpack::menu-item title="Должности" icon="la la-question" :link="backpack_url('positions')"/>
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

<label for="mySelect">Choose options:</label>
<select id="mySelect" name="mySelection" multiple>
    <optgroup label="Group A">
        <option value="optionA1">Option A1</option>
        <option value="optionA2">Option A2</option>
    </optgroup>
    <optgroup label="Group B">
        <option value="optionB1">Option B1</option>
        <option value="optionB2">Option B2</option>
        <option value="optionB3">Option B3</option>
    </optgroup>
    <option value="standaloneOption">Standalone Option</option>
</select>
