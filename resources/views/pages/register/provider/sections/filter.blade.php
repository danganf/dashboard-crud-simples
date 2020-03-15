<div class="col-lg-12">
    <div class="card">
        <div class="card-header reload-card">
            <h4 class="card-title">Filtragem</h4>
            <div class="heading-elements">
                <a data-action="collapse" class="btn btn-sm btn-icon btn-success"><i id="icon-filter" class="ft-plus white"></i></a>
                <button type="button" class="btn btn-filter btn-sm btn-icon btn-success btn-click"><i class="ft-filter white"></i> Buscar </button>
                <button onclick="window.location.href='{{route('register.provider.index')}}?reset'" type="button" class="btn btn-clear hidden btn-sm btn-icon btn-danger btn-click"><i id="icon-clear" class="ft-x-square white"></i> Limpar </button>
            </div>
        </div>
        <div id="cardFilter" class="card-content collapse">
            <div class="card-body">
                <form class="form">
                    <div class="form-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label for="projectinput1">Busca <small style="color:#817b9d">Nome e/ou ID</small></label>
                                        <input class="form-control" name="search">
                                    </div>
                                </div>
                                <div class="col-md-3 col-xl-2">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Todos</option>
                                            <option value="S">ATIVO</option>
                                            <option value="N">INATIVO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xl-2">
                                    <div class="form-group">
                                        <label for="status">Encomenda?</label>
                                        <select class="form-control" name="accept_order">
                                            <option value="">Todos</option>
                                            <option value="S">SIM</option>
                                            <option value="N">NÃO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xl-3">
                                    <div class="form-group">
                                        <label for="tags_filter">Tag</label>
                                        <select class="form-control" name="tags[]" id="tags_filter" multiple="multiple">
                                            <option value="">Todos</option>
                                            @foreach( $tags AS $row )
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label for="projectinput1">Registros por pagina</label>
                                        <select class="form-control" name="limit">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
