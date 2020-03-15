@extends('layout')

@section('js')
    <script>
        cruds.bindDelete('unit');
        @include('includes.filter-js')
    </script>
@endsection

@section('content')

<div class="row">
    @include($basicPath.'.sections.filter')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header reload-card" id="last-orders">
                <h4 class="card-title"></h4>
                <div class="heading-elements">
                    <button onclick="location.href='{{route('register.unit.new')}}'" class="btn btn-primary btn-sm btn-icon"><i class="ft-plus white"></i> Novo</button>
                    <span class="dropdown"></span>
                </div>
            </div>
            <div class="card-content collapse show">
                <div id="last-orders" class="media-list position-relative">
                    <div class="table-responsive">
                        <table class="table table-hover table-xl mb-0">
                            <thead>
                            <tr>
                                <th class="border-top-0" style="width: 5%">#</th>
                                <th class="border-top-0">Nome</th>
                                <th class="border-top-0">Iniciais</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">Tt.Produtos</th>
                                <th class="border-top-0">Tt.Insumos</th>
                                <th class="border-top-0 text-right">Ação</th>
                            </tr>
                            </thead>
                            <tbody class="value-last-orders">
                            @foreach( $units AS $unit )
                                <tr>
                                    <td class="text-truncate">{{$unit['id']}}</td>
                                    <td class="text-truncate"><a href="{{route('register.unit.edit',[$unit['id']])}}">{{$unit['name']}}</a></td>
                                    <td class="text-truncate">{{$unit['initials']}}</td>
                                    <td class="text-truncate">
                                        {!! get_label_bool($unit['status'], true) !!}
                                    </td>
                                    <td class="text-truncate">
                                        @if( $unit['count_product_main'] > 0 )
                                            <a href="{{route('catalog.products.index_main')}}?unit_id={{$unit['id']}}">{{ $unit['count_product_main'] }}</a>
                                        @else 0 @endif
                                    </td>
                                    <td class="text-truncate">
                                        @if( $unit['count_product_inputs'] > 0 )
                                            <a href="{{route('catalog.products.index_inputs')}}?unit_id={{$unit['id']}}">{{ $unit['count_product_inputs'] }}</a>
                                        @else 0 @endif
                                    </td>
                                    <td class="text-truncate text-right">
                                        <a class="btn-delete" data-id="{{$unit['id']}}"><i class="la la-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @component('components.paginator', ['paginator'=>$paginator, 'paginator_info' => $paginator_info])@endcomponent
            </div>
        </div>
    </div>
</div>

@endsection
