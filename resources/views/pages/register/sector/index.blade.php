@extends('layout')

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
                    <button onclick="location.href='{{route('register.sector.new'.$routeSufix)}}'" class="btn btn-primary btn-sm btn-icon"><i class="ft-plus white"></i> Novo</button>
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
                                <th class="border-top-0">Status</th>
                            @if( !$isInput )
                                <th class="border-top-0">Impressora</th>
                            @endif
                                <th class="border-top-0">Tt.Produtos</th>
                                <th class="border-top-0 text-right">Ação</th>
                            </tr>
                            </thead>
                            <tbody class="value-last-orders">                                
                                @foreach( $sectors AS $sector )
                                    <tr>
                                        <td class="text-truncate">{{$sector['id']}}</td>
                                        <td class="text-truncate"><a href="{{route('register.sector.edit'.$routeSufix,[$sector['id']])}}">{{$sector['name']}}</a></td>
                                        <td class="text-truncate">{!! get_label_bool($sector['status'], true) !!}</td>
                                    @if( !$isInput )
                                        <td class="text-truncate">
                                        @php
                                            $ipPort = array_get( $sector, 'printer.ip_port' );
                                            $ipPort = !empty( $ipPort ) ? "<p><small>$ipPort</small></p>" : '';
                                        @endphp
                                            {!! array_get( $sector, 'printer.name', '--' ) . $ipPort !!}
                                        </td>
                                    @endif
                                        <td class="text-truncate">
                                            @if( !$isInput )
                                                @if( $sector['count_product_main'] > 0 )
                                                    <a href="{{route('catalog.products.index_main')}}?sector_id={{$sector['id']}}">{{ $sector['count_product_main'] }}</a>
                                                @else 0 @endif
                                            @else
                                                @if( $sector['count_product_inputs'] > 0 )
                                                    <a href="{{route('catalog.products.index_inputs')}}?sector_id={{$sector['id']}}">{{ $sector['count_product_inputs'] }}</a>
                                                @else 0 @endif
                                            @endif
                                        </td>
                                        <td class="text-truncate text-right">
                                            <a class="btn-delete" data-id="{{$sector['id']}}"><i class="la la-trash"></i></a>
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

@section('js')
    <script src="../assets/js/cruds/main.js"></script>
    <script>
        cruds.bindDelete('sector');
        @include('includes.filter-js')
    </script>
@endsection
