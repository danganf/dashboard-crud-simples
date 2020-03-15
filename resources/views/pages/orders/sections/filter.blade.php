<div class="col-lg-12">
    <div class="card">
        <div class="card-header reload-card" id="last-orders">
            <h4 class="card-title">Filtragem</h4>
            <div class="heading-elements">
                <a data-action="collapse" class="btn btn-sm btn-icon btn-success"><i id="icon-filter" class="ft-plus white"></i></a>
                <button type="button" class="btn btn-filter btn-sm btn-icon btn-success btn-click"><i class="ft-filter white"></i> Buscar </button>
                <button onclick="window.location.href='{{route('orders.index')}}'" type="button" class="btn btn-clear hidden btn-sm btn-icon btn-danger btn-click"><i id="icon-clear" class="ft-x-square white"></i> Limpar </button>
            </div>
        </div>
        <div id="cardFilter" class="card-content collapse">
            <div class="card-body">
                <form class="form" action="{{route('orders.index')}}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label for="projectinput1">Código</label>
                                    <input class="form-control" name="salecode">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label for="projectinput1">Pagos</label>
                                    <select class="form-control" name="paid">
                                        <option value="">Todos</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NAO</option>
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
                </form>
            </div>
        </div>
    </div>
</div>
