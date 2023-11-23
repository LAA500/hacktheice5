@extends('layouts.admin')

@section('content')
<div>
    <div>
        <SupplyCreate>
            <template v-slot:warehouses>
                @foreach($warehouses as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </template>
        </SupplyCreate>
    </div>
</div>
@endsection