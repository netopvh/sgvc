<form action="{{ route('contratos.index') }}" method="get">
    <div class="row">
        <div class="col-xs-1">
            <div class="form-group">
                <label>Numero:</label>
                <input type="text" name="numero" class="form-control">
            </div>
        </div>
        <div class="col-xs-1">
            <div class="form-group">
                <label>Ano:</label>
                <input type="text" id="numbers" name="ano" class="form-control">
            </div>
        </div>
        <div class="col-xs-2">
            <div class="form-group">
                <label>Tipo:</label>
                <select name="tipo" class="select">
                    <option value=""></option>
                    @foreach($tipos_contrato as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="form-group">
                <label>Contratante:</label>
                <select name="casa" class="select">
                    <option value=""></option>
                    @foreach($casas as $casa)
                        <option value="{{ $casa->id }}">{{ $casa->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-1">
            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="select">
                    <option value="V">Vigente</option>
                    <option value="C">Cancelado</option>
                    <option value="F">Finalizado</option>
                </select>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="form-group">
                <label>Data Início:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                    <input type="text" name="inicio" class="form-control datepicker">
                </div>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="form-group">
                <label>Data Encerramento:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                    <input type="text" name="encerramento" class="form-control datepicker">
                </div>
            </div>
        </div>
        <div class="col-xs-1">
            <div class="form-group">
                <label></label>
                <button type="submit" class="btn btn-lg btn-primary">Pesquisar</button>
            </div>
        </div>
    </div>
</form>