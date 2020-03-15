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
                    <button onclick="location.href='{{route('register.role.new')}}'" class="btn btn-primary btn-sm btn-icon"><i class="ft-plus white"></i> Novo</button>
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
                                <th class="border-top-0 text-right">Ação</th>
                            </tr>
                            </thead>
                            <tbody class="value-last-orders">
                                @foreach( $resultData AS $data )
                                <tr>
                                    <td class="text-truncate">{{$data['id']}}</td>
                                    <td class="text-truncate">
                                        <a href="{{route('register.role.edit',[$data['id']])}}">
                                            {{$data['name']}}
                                        </a>
                                    </td>
                                    <td class="text-truncate text-right">
                                        <a class="btn-delete" data-id="{{$data['id']}}"><i class="la la-trash"></i></a>
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

    <script>
        @include('includes.filter-js')
        cruds.bindDelete('role');

    </script>
@endsection
